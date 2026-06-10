<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Craftsman;
use App\Models\Gig;
use App\Models\GigApplication;
use App\Models\PointTransaction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CraftsmanController extends Controller
{
    // ─────────────────────────────────────────
    // Dashboard
    // ─────────────────────────────────────────
    public function dashboard()
    {
        $user      = auth()->user();
        $craftsman = $user->craftsman;

        $bookings = Booking::where('craftsman_id', $craftsman->id)
            ->with(['client'])
            ->latest()
            ->take(5)
            ->get();

        // Jobs matching this craftsman's categories
        $catIds = $craftsman->categories->pluck('id');
        $matchingGigs = Gig::with(['category', 'applications', 'client'])
            ->whereIn('category_id', $catIds)
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        $avgRating    = Review::whereHas('booking', fn($q) => $q->where('craftsman_id', $craftsman->id))->avg('rating') ?? 0;
        $activeBookings = Booking::where('craftsman_id', $craftsman->id)->whereIn('status', ['pending','confirmed'])->count();
        $completedBookings = Booking::where('craftsman_id', $craftsman->id)->where('status', 'done')->count();

        return view('craftsman.dashboard', compact('craftsman', 'bookings', 'matchingGigs', 'avgRating', 'activeBookings', 'completedBookings'));
    }

    // ─────────────────────────────────────────
    // Profile
    // ─────────────────────────────────────────
    public function profile()
    {
        $craftsman = auth()->user()->craftsman->load('categories', 'reviews');
        return view('craftsman.profile', compact('craftsman'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */ //buch update t5dam 
        $user      = auth()->user();
        $craftsman = $user->craftsman;

        $data = $request->validate([
            'name'                => 'required|string|max:120',
            'phone'               => 'nullable|string|max:20',
            'city'                => 'nullable|string|max:80',
            'address'             => 'nullable|string|max:200',
            'description'         => 'nullable|string',
            'experience_years'    => 'nullable|integer|min:0|max:60',
            'price'               => 'nullable|numeric|min:0',
            'certification'       => 'nullable|string|max:255',
            'availability_status' => 'nullable|boolean',
            'photo'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::disk('public')->delete($user->photo);
            $data['photo'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update([
            'name'    => $data['name'],
            'phone'   => $data['phone'] ?? $user->phone,
            'city'    => $data['city'] ?? $user->city,
            'address' => $data['address'] ?? $user->address,
            'photo'   => $data['photo'] ?? $user->photo,
        ]);

        $craftsman->update([
            'description'         => $data['description'] ?? $craftsman->description,
            'experience_years'    => $data['experience_years'] ?? $craftsman->experience_years,
            'price'               => $data['price'] ?? $craftsman->price,
            'certification'       => $data['certification'] ?? $craftsman->certification,
            'availability_status' => $request->has('availability_status'),
        ]);

        return redirect()->route('craftsman.categories')->with('status', 'Profil mis à jour avec succès !');
    }

    // ─────────────────────────────────────────
    // Categories
    // ─────────────────────────────────────────
    public function categories()
    {
        $craftsman  = auth()->user()->craftsman->load('categories');
        $categories = Category::withCount('craftsmen')->orderBy('name')->get();

        return view('craftsman.categories', compact('craftsman', 'categories'));
    }

    public function updateCategories(Request $request)
    {
        $data = $request->validate([
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        auth()->user()->craftsman->categories()->sync($data['categories'] ?? []);

        return redirect()->route('craftsman.dashboard')->with('status', 'Catégories mises à jour !');
    }

    // ─────────────────────────────────────────
    // Bookings
    // ─────────────────────────────────────────
    public function bookings(Request $request)
    {
        $craftsman     = auth()->user()->craftsman;
        $allowed       = ['pending', 'confirmed', 'done', 'cancelled'];
        $currentStatus = in_array($request->query('status'), $allowed) ? $request->query('status') : null;

        $query = Booking::where('craftsman_id', $craftsman->id)
            ->with('client')
            ->latest();

        if ($currentStatus) {
            $query->where('status', $currentStatus);
        }

        $bookings = $query->paginate(15);

        return view('craftsman.bookings', compact('bookings', 'currentStatus'));
    }

    public function updateBooking(Request $request, Booking $booking)
    {
        abort_if($booking->craftsman_id !== auth()->user()->craftsman->id, 403);

        $data = $request->validate(['status' => 'required|in:pending,confirmed,done,cancelled']);
        $booking->update($data);

        return back()->with('status', 'Statut mis à jour.');
    }

    // ─────────────────────────────────────────
    // Reviews
    // ─────────────────────────────────────────
    public function reviews()
    {
        $craftsman = auth()->user()->craftsman;
        $reviews   = Review::whereHas('booking', fn($q) => $q->where('craftsman_id', $craftsman->id))
            ->with('booking.client')
            ->latest()
            ->get();

        $avgRating = $reviews->avg('rating') ?? 0;

        return view('craftsman.reviews', compact('reviews', 'avgRating'));
    }

    // ─────────────────────────────────────────
    // Completed Jobs (replaces Earnings)
    // ─────────────────────────────────────────
    public function earnings()
    {
        $craftsman = auth()->user()->craftsman;
        $completedBookings = Booking::where('craftsman_id', $craftsman->id)
            ->where('status', 'done')
            ->with('client')
            ->latest()
            ->paginate(20);

        return view('craftsman.earnings', compact('completedBookings'));
    }

    // ─────────────────────────────────────────
    // Billing / Points
    // ─────────────────────────────────────────
    public function billing()
    {
        $transactions = PointTransaction::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('craftsman.billing', compact('transactions'));
    }

    public function buyPoints(Request $request)
    {
        $packages = [
            'starter' => ['pts' => 50,  'price' => 99],
            'pro'     => ['pts' => 120, 'price' => 199],
            'elite'   => ['pts' => 300, 'price' => 399],
        ];

        $data = $request->validate(['package' => 'required|in:starter,pro,elite']);
        $pkg  = $packages[$data['package']];
        /** @var \App\Models\User $user */ //buch update t5dam 
        $user = auth()->user();

        $user->points += $pkg['pts'];
        $user->save();

        PointTransaction::create([
            'user_id'     => $user->id,
            'amount'      => $pkg['pts'],
            'type'        => 'purchase',
            'description' => "Achat pack {$data['package']} ({$pkg['pts']} pts)",
        ]);

        return back()->with('status', "{$pkg['pts']} points ajoutés à votre compte !");
    }

    // ─────────────────────────────────────────
    // Availability
    // ─────────────────────────────────────────
    public function toggleAvailability()
    {
        $craftsman = auth()->user()->craftsman;
        $craftsman->availability_status = !$craftsman->availability_status;
        $craftsman->save();

        $label = $craftsman->availability_status ? 'Disponible' : 'Occupé';
        return back()->with('status', "Statut changé : {$label}");
    }

    // ─────────────────────────────────────────
    // Gigs
    // ─────────────────────────────────────────
    public function gigShow(Gig $gig)
    {
        $gig->load('category', 'client', 'applications');
        return view('craftsman.gig-show', compact('gig'));
    }

    public function gigApply(Gig $gig)
    {
        /** @var \App\Models\User $user */ //buch update t5dam 
        $user      = auth()->user();
        $craftsman = $user->craftsman;

        if ($user->points < 5) {
            return back()->with('error', 'Vous n\'avez pas assez de points. Rechargez dans Facturation.');
        }

        if ($gig->applications()->where('craftsman_id', $craftsman->id)->exists()) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        GigApplication::create([
            'gig_id'       => $gig->id,
            'craftsman_id' => $craftsman->id,
        ]);

        $user->points -= 5;
        $user->save();

        PointTransaction::create([
            'user_id'     => $user->id,
            'amount'      => -5,
            'type'        => 'spend',
            'description' => "Candidature : {$gig->title}",
        ]);

        return back()->with('status', 'Candidature envoyée ! (-5 points)');
    }

    // ─────────────────────────────────────────
    // Inbox
    // ─────────────────────────────────────────
    public function inbox()
    {
        $partners = $this->getChatPartners();
        return view('craftsman.inbox', compact('partners'));
    }

    public function inboxChat(User $user)
    {
        $partners = $this->getChatPartners();
        $partner  = $user;
        $chats    = Chat::conversation(auth()->id(), $user->id)->orderBy('created_at')->get();

        return view('craftsman.inbox', compact('partners', 'partner', 'chats'));
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

        return redirect()->route('craftsman.inbox.chat', $data['receiver_id']);
    }

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