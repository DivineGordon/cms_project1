<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = Client::with(['pages', 'analytics'])
            ->paginate(10);

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created client.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'slug' => 'required|string|max:255|unique:clients|alpha_dash',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'slug' => $request->slug,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'description' => $request->description,
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        $client->load(['pages.theme', 'analytics']);
        
        return Inertia::render('Clients/Show', [
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the client.
     */
    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $client->id,
            'slug' => 'required|string|max:255|alpha_dash|unique:clients,slug,' . $client->id,
            'company_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $client->update($request->only([
            'name', 'email', 'slug', 'company_name', 'description', 'is_active'
        ]));

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
