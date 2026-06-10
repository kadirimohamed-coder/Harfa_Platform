<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Craftsman;
use App\Models\Gig;
use App\Models\GigApplication;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // ─────────────────────────────────────────
    // Dashboard
    // ─────────────────────────────────────────
    public function dashboard()
    {
        $user = auth()->user();

        $bookings = Booking::where('client_id', $user->id)
            ->with(['craftsman.user'])
            ->latest()
            ->take(5)
            ->get();

        $gigs = Gig::where('user_id', $user->id)
            ->with(['category', 'applications'])
            ->where('status', 'open')
            ->latest()
            ->take(4)
            ->get();

        $totalBookings     = Booking::where('client_id', $user->id)->count();
        $activeBookings    = Booking::where('client_id', $user->id)->whereIn('status', ['pending','confirmed'])->count();
        $completedBookings = Booking::where('client_id', $user->id)->where('status', 'done')->count();

        // New applications in the last 48 hours on the client's gigs
        // take(50) guards against memory exhaustion on large datasets
        $newApplications = GigApplication::whereHas('gig', fn($q) => $q->where('user_id', $user->id))
            ->with(['craftsman.user', 'gig'])
            ->where('created_at', '>=', now()->subHours(48))
            ->latest()
            ->take(50)
            ->get();

        return view('client.dashboard', compact(
            'bookings', 'gigs', 'totalBookings', 'activeBookings', 'completedBookings',
            'newApplications'
        ));
    }

    // ─────────────────────────────────────────
    // Bookings
    // ─────────────────────────────────────────
    public function bookings(Request $request)
    {
        $allowed       = ['pending', 'confirmed', 'done', 'cancelled'];
        $currentStatus = in_array($request->query('status'), $allowed) ? $request->query('status') : null;

        $query = Booking::where('client_id', auth()->id())
            ->with(['craftsman.user', 'review'])
            ->latest();

        if ($currentStatus) {
            $query->where('status', $currentStatus);
        }

        $bookings = $query->paginate(15);

        return view('client.bookings', compact('bookings', 'currentStatus'));
    }

    // ─────────────────────────────────────────
    // Book form
    // ─────────────────────────────────────────
    public function bookForm(Craftsman $craftsman)
    {
        $craftsman->load('user', 'categories', 'reviews');
        return view('client.book-form', compact('craftsman'));
    }

    public function bookStore(Request $request, Craftsman $craftsman)
    {
        $data = $request->validate([
            'booking_date' => 'required|date|after:now',
            'description'  => 'required|string|max:1000',
            'address'      => 'required|string|max:200',
            'urgency'      => 'nullable|string|max:20',
        ]);

        Booking::create([
            'client_id'    => auth()->id(),
            'craftsman_id' => $craftsman->id,
            'booking_date' => $data['booking_date'],
            'description'  => $data['description'],
            'address'      => $data['address'],
            'urgency'      => $data['urgency'] ?? 'normal',
            'status'       => 'pending',
        ]);

        return redirect()->route('client.bookings')
            ->with('status', 'Demande de réservation envoyée ! L\'artisan va vous contacter.');
    }

    // ─────────────────────────────────────────
    // Reviews
    // ─────────────────────────────────────────
    public function reviews()
    {
        $reviews = Review::whereHas('booking', fn($q) => $q->where('client_id', auth()->id()))
            ->with('booking.craftsman.user')
            ->latest()
            ->get();

        return view('client.reviews', compact('reviews'));
    }

    public function reviewForm(Booking $booking)
    {
        abort_if($booking->client_id !== auth()->id(), 403);
        abort_if($booking->status !== 'done', 403);
        abort_if($booking->review()->exists(), 403, 'Vous avez déjà évalué cette réservation.');

        $booking->load('craftsman.user');
        return view('client.review-form', compact('booking'));
    }

    public function reviewStore(Request $request, Booking $booking)
    {
        abort_if($booking->client_id !== auth()->id(), 403);

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'rating'     => $data['rating'],
            'comment'    => $data['comment'] ?? null,
        ]);

        return redirect()->route('client.bookings')
            ->with('status', 'Merci pour votre évaluation !');
    }

    // ─────────────────────────────────────────
    // Gigs
    // ─────────────────────────────────────────
    public function postJobForm()
    {
        $categories = Category::orderBy('name')->get();
        return view('client.post-job', compact('categories'));
    }

    public function gigStore(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'city'        => 'required|string|max:80',
            'deadline'    => 'nullable|date|after:today',
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'open';

        Gig::create($data);

        return redirect()->route('client.dashboard')
            ->with('status', 'Offre publiée avec succès ! Les artisans peuvent maintenant postuler.');
    }

    public function gigShow(Gig $gig)
    {
        abort_if($gig->user_id !== auth()->id(), 403);
        $gig->load(['category', 'applications.craftsman.user']);
        return view('client.gig-show', compact('gig'));
    }

    // ─────────────────────────────────────────
    // Billing
    // ─────────────────────────────────────────
    public function billing()
    {
        return view('client.billing');
    }

    // ─────────────────────────────────────────
    // Inbox / Chat
    // ─────────────────────────────────────────
    public function inbox()
    {
        $partners = $this->getChatPartners();
        return view('client.inbox', compact('partners'));
    }

    public function inboxChat(User $user)
    {
        $partners = $this->getChatPartners();
        $partner  = $user;
        $chats    = Chat::conversation(auth()->id(), $user->id)->orderBy('created_at')->get();

        return view('client.inbox', compact('partners', 'partner', 'chats'));
    }

    public function inboxSend(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string|max:2000',
        ]);

        Chat::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $data['receiver_id'],
            'message'     => $data['message'],
        ]);

        return redirect()->route('client.inbox.chat', $data['receiver_id']);
    }

    // ─────────────────────────────────────────
    // Helper
    // ─────────────────────────────────────────
    private function getChatPartners()
    {
        $ids = Chat::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get()
            ->flatMap(fn($c) => [$c->sender_id, $c->receiver_id])
            ->unique()
            ->filter(fn($id) => $id !== auth()->id());

        return User::whereIn('id', $ids)->get();
    }
}