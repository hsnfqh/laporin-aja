<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the user's settings form.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $layout = 'layouts.dashboard.index'; // default untuk warga

        if ($user->role === 'admin') {
            $layout = 'layouts.admin';
        } elseif ($user->role === 'operator') {
            $layout = 'layouts.operator';
        }

        return view('settings.index', [
            'user' => $user,
            'layout' => $layout,
        ]);
    }

    /**
     * Update the user's settings.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate and update settings
        $validated = $request->validate([
            'notifications' => 'nullable|array',
            'notifications.email' => 'boolean',
            'notifications.push' => 'boolean',
            'notifications.reports' => 'boolean',
            'theme' => 'nullable|string|in:light,dark,auto',
            'language' => 'nullable|string|in:id,en',
            'privacy' => 'nullable|array',
            'privacy.public_profile' => 'boolean',
            'privacy.analytics' => 'boolean',
        ]);

        // Update user settings
        $settings = $user->settings ?? [];
        $settings = array_merge($settings, $validated);
        $user->settings = $settings;
        $user->save();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}