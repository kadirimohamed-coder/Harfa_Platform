<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Craftsman;
use App\Models\Gig;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $categories = Category::withCount('craftsmen')->orderByDesc('craftsmen_count')->get();

        $top = Craftsman::with(['user', 'categories', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->where('availability_status', true)
            ->orderByDesc('reviews_avg_rating')
            ->limit(6)
            ->get();

        return view('home.index', compact('categories', 'top'));
    }

    public function about()
    {
        return view('about');
    }

    public function pricing()
    {
        return view('pricing');
    }

    public function findWork(Request $request)
    {
        $query = Gig::with(['category', 'client', 'applications'])
            ->where('status', 'open')
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        $gigs       = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('find-work', compact('gigs', 'categories'));
    }

    public function craftsmenIndex(Request $request)
    {
        $query = Craftsman::with(['user', 'categories', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->whereHas('user', fn($q) => $q->where('status', 'active'));

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('city', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('category')) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $request->category));
        }
        if ($request->filled('city')) {
            $query->whereHas('user', fn($q) => $q->where('city', 'like', '%'.$request->city.'%'));
        }

        $craftsmen  = $query->orderByDesc('reviews_avg_rating')->paginate(10);
        $categories = Category::orderBy('name')->get();

        return view('craftsmen.index', compact('craftsmen', 'categories'));
    }

    public function craftsmenShow(Craftsman $craftsman)
    {
        $craftsman->load(['user', 'categories', 'reviews.booking.client']);
        $reviews = $craftsman->reviews()->with('booking.client')->latest()->get();

        return view('craftsmen.show', compact('craftsman', 'reviews'));
    }

    public function categoryShow(Category $category)
    {
        $craftsmen = Craftsman::with(['user', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->whereHas('user', fn($q) => $q->where('status', 'active'))
            ->paginate(12);

        return view('categories.show', compact('category', 'craftsmen'));
    }
}
