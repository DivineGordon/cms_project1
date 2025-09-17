<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class ClientAuthController extends Controller
{
    /**
     * Show the client login form.
     */
    public function showLoginForm()
    {
        return Inertia::render('Auth/ClientLogin');
    }

    /**
     * Handle client login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('client.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the client registration form.
     */
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/ClientRegister');
    }

    /**
     * Handle client registration.
     */
    public function register(Request $request)
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

        Auth::guard('client')->login($client);

        return redirect()->route('client.dashboard');
    }

    /**
     * Handle client logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }
}
