<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => Profile::query()->first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'profile_image_url' => ['nullable', 'url', 'max:2048'],
            'profile_image_upload' => ['nullable', 'image', 'max:5120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'cv_url' => ['nullable', 'url', 'max:2048'],
            'cv_upload' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $profile = Profile::query()->first();
        $data = Arr::only($validated, [
            'full_name', 'title', 'description', 'phone', 'email', 'address',
        ]);

        if ($request->hasFile('profile_image_upload')) {
            $data['profile_image'] = $request->file('profile_image_upload')
                ->store('profiles/images', 'public');
        } elseif ($request->filled('profile_image_url')) {
            $data['profile_image'] = $validated['profile_image_url'];
        }

        if ($request->hasFile('cv_upload')) {
            $data['cv_file'] = $request->file('cv_upload')
                ->store('profiles/cv', 'public');
        } elseif ($request->filled('cv_url')) {
            $data['cv_file'] = $validated['cv_url'];
        }

        Profile::query()->updateOrCreate(['id' => $profile?->id], $data);

        return back()->with('success', 'About information was updated successfully.');
    }
}
