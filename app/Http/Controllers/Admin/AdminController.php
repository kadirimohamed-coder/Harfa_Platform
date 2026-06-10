<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Craftsman;
use App\Models\Gig;
use App\Models\PointTransaction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ─────────────────────────────────────────
    // Dashboard
    // ─────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'users'          => User::count(),
            'craftsmen'      => Craftsman::count(),
            'bookings_month' => Booking::whereMonth('created_at', now()->month)->count(),
            'avg_rating'     => number_format(Review::avg('rating') ?? 0, 1),
        ];

        $bookingsByStatus = Booking::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.dashboard', compact('stats', 'bookingsByStatus'));
    }

    // ─────────────────────────────────────────
    // Users
    // ─────────────────────────────────────────
    public function users(Request $request)
    {
        $query = User::orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where(fn($q) => $q
                ->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
            );
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('status', "Compte {$user->name} : {$user->status}");
    }

    public function destroyUser(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Vous ne pouvez pas supprimer votre propre compte.');
        $user->delete();
        return back()->with('status', "Utilisateur {$user->name} supprimé.");
    }

    // ─────────────────────────────────────────
    // Craftsmen
    // ─────────────────────────────────────────
    public function craftsmen(Request $request)
    {
        $craftsmen = Craftsman::with(['user', 'categories', 'reviews', 'bookings'])
            ->withAvg('reviews', 'rating')
            ->paginate(20);

        return view('admin.craftsmen', compact('craftsmen'));
    }

    public function toggleCraftsman(Craftsman $craftsman)
    {
        $user         = $craftsman->user;
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with('status', "Artisan {$user->name} : {$user->status}");
    }

    // ─────────────────────────────────────────
    // Categories
    // ─────────────────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('craftsmen')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80|unique:categories',
            'icon' => 'nullable|string|max:60',
        ]);

        Category::create($data);
        return back()->with('status', "Catégorie « {$data['name']} » créée.");
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80|unique:categories,name,'.$category->id,
            'icon' => 'nullable|string|max:60',
        ]);

        $category->update($data);
        return back()->with('status', "Catégorie mise à jour.");
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('status', "Catégorie supprimée.");
    }

    // ─────────────────────────────────────────
    // Bookings
    // ─────────────────────────────────────────
    public function bookings(Request $request)
    {
        $query = Booking::with(['client', 'craftsman.user'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }

    public function updateBooking(Request $request, Booking $booking)
    {
        $data = $request->validate(['status' => 'required|in:pending,confirmed,done,cancelled']);
        $booking->update($data);

        return back()->with('status', "Réservation #{$booking->id} : ".ucfirst($data['status']));
    }

    // ─────────────────────────────────────────
    // Reviews
    // ─────────────────────────────────────────
    public function reviews(Request $request)
    {
        $reviews = Review::with(['booking.client', 'booking.craftsman.user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.reviews', compact('reviews'));
    }

    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('status', 'Avis supprimé.');
    }

    // ─────────────────────────────────────────
    // Gigs
    // ─────────────────────────────────────────
    public function gigs(Request $request)
    {
        $gigs = Gig::with(['category', 'client', 'applications'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.gigs', compact('gigs'));
    }

    public function toggleGig(Gig $gig)
    {
        $gig->status = $gig->status === 'open' ? 'closed' : 'open';
        $gig->save();

        return back()->with('status', "Offre « {$gig->title} » : {$gig->status}");
    }

    public function destroyGig(Gig $gig)
    {
        $gig->delete();
        return back()->with('status', "Offre supprimée.");
    }

    // ─────────────────────────────────────────
    // Platform Points
    // ─────────────────────────────────────────
    public function payments()
    {
        $transactions = PointTransaction::with('user')
            ->orderByDesc('created_at')
            ->paginate(30);

        $totalPoints    = PointTransaction::where('type', 'purchase')->sum('amount');
        $totalPurchases = PointTransaction::where('type', 'purchase')->count();

        return view('admin.payments', compact('transactions', 'totalPoints', 'totalPurchases'));
    }
}
