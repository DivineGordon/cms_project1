<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Page;
use App\Models\PageAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PublicPageController extends Controller
{
    /**
     * Display the public page.
     */
    public function show(Request $request, $clientSlug, $pageSlug)
    {
        $client = Client::where('slug', $clientSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $page = $client->pages()
            ->where('slug', $pageSlug)
            ->where('is_published', true)
            ->with('theme')
            ->firstOrFail();

        // Track page view
        $this->trackPageView($request, $page);

        return Inertia::render('Public/Page', [
            'page' => $page,
            'client' => $client,
        ]);
    }

    /**
     * Track page view for analytics.
     */
    private function trackPageView(Request $request, Page $page)
    {
        $sessionId = Session::getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $referer = $request->header('referer');

        // Check if this is a unique visitor for this session
        $isUniqueVisitor = !PageAnalytics::where('page_id', $page->id)
            ->where('session_id', $sessionId)
            ->whereDate('viewed_at', now())
            ->exists();

        PageAnalytics::create([
            'page_id' => $page->id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referer' => $referer,
            'session_id' => $sessionId,
            'is_unique_visitor' => $isUniqueVisitor,
            'viewed_at' => now(),
        ]);
    }
}
