<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.blog', compact('blogs'));
    }

    /**
     * Display a single blog post by slug.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)
                ->where('status', 'published')
                ->first();

            if (!$blog) {
                Log::warning("Blog not found for slug: $slug");
                return view('frontend.blog_show', ['blog' => null]);
            }

            $blog->increment('views');

            return view('frontend.blog_show', compact('blog'));
        } catch (\Exception $e) {
            Log::error("Error fetching blog with slug: $slug. Error: " . $e->getMessage());
            return view('frontend.blog_show', ['blog' => null]);
        }
    }
}
