<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard for the authenticated client.
     */
    public function index(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        $period = $request->get('period', '30'); // days
        $startDate = now()->subDays($period);
        
        // Get page views data
        $pageViews = PageAnalytics::whereHas('page', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->where('viewed_at', '>=', $startDate)
        ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Get unique visitors data
        $uniqueVisitors = PageAnalytics::whereHas('page', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->where('viewed_at', '>=', $startDate)
        ->where('is_unique_visitor', true)
        ->selectRaw('DATE(viewed_at) as date, COUNT(*) as unique_visitors')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Get top pages
        $topPages = Page::where('client_id', $client->id)
            ->withCount('analytics')
            ->orderBy('analytics_count', 'desc')
            ->limit(10)
            ->get();

        // Get total stats
        $totalViews = PageAnalytics::whereHas('page', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->count();

        $totalUniqueVisitors = PageAnalytics::whereHas('page', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->where('is_unique_visitor', true)->count();

        $totalPages = $client->pages()->count();
        $publishedPages = $client->pages()->where('is_published', true)->count();

        return Inertia::render('Analytics/Index', [
            'pageViews' => $pageViews,
            'uniqueVisitors' => $uniqueVisitors,
            'topPages' => $topPages,
            'stats' => [
                'totalViews' => $totalViews,
                'totalUniqueVisitors' => $totalUniqueVisitors,
                'totalPages' => $totalPages,
                'publishedPages' => $publishedPages,
            ],
            'period' => $period,
        ]);
    }

    /**
     * Export analytics data as CSV.
     */
    public function export(Request $request)
    {
        $client = Auth::guard('client')->user();
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);

        $analytics = PageAnalytics::whereHas('page', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
        ->where('viewed_at', '>=', $startDate)
        ->with('page')
        ->orderBy('viewed_at', 'desc')
        ->get();

        $filename = 'analytics_' . $client->slug . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($analytics) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Date',
                'Page Title',
                'Page Slug',
                'IP Address',
                'User Agent',
                'Referer',
                'Unique Visitor',
            ]);

            // CSV data
            foreach ($analytics as $analytic) {
                fputcsv($file, [
                    $analytic->viewed_at->format('Y-m-d H:i:s'),
                    $analytic->page->title,
                    $analytic->page->slug,
                    $analytic->ip_address,
                    $analytic->user_agent,
                    $analytic->referer,
                    $analytic->is_unique_visitor ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
