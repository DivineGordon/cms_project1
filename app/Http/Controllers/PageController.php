<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display a listing of pages for the authenticated client.
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        $pages = $client->pages()->with('theme')->paginate(10);

        return Inertia::render('Pages/Index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        $themes = Theme::where('is_active', true)->get();
        
        return Inertia::render('Pages/Create', [
            'themes' => $themes,
        ]);
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:pages,slug,NULL,id,client_id,' . $client->id,
            'theme_id' => 'required|exists:themes,id',
            'content' => 'required|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $page = $client->pages()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'theme_id' => $request->theme_id,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('pages.edit', $page)
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        $page->load(['client', 'theme', 'analytics']);
        
        return Inertia::render('Pages/Show', [
            'page' => $page,
        ]);
    }

    /**
     * Show the form for editing the page.
     */
    public function edit(Page $page)
    {
        $this->authorize('update', $page);
        
        $themes = Theme::where('is_active', true)->get();
        $page->load('theme');
        
        return Inertia::render('Pages/Edit', [
            'page' => $page,
            'themes' => $themes,
        ]);
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        $this->authorize('update', $page);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:pages,slug,' . $page->id . ',id,client_id,' . $page->client_id,
            'theme_id' => 'required|exists:themes,id',
            'content' => 'required|array',
            'customizations' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $page->update($request->all());

        return redirect()->route('pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);
        
        $page->delete();

        return redirect()->route('pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Publish/unpublish a page.
     */
    public function togglePublish(Page $page)
    {
        $this->authorize('update', $page);
        
        $page->update(['is_published' => !$page->is_published]);

        return redirect()->back()
            ->with('success', $page->is_published ? 'Page published successfully.' : 'Page unpublished successfully.');
    }
}
