<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $userFiles = UserFile::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('profile.edit', [
            'user' => $user,
            'userFiles' => $userFiles,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's passcode.
     */
    public function updatePasscode(Request $request): RedirectResponse
    {
        $user = $request->user();

        $rules = [
            'passcode' => ['required', 'string', 'confirmed'],
        ];

        if ($user->passcode) {
            $rules['current_passcode'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->passcode)) {
                    $fail(__('validation.custom.passcode_update.current_passcode_mismatch'));
                }
            }];
        }

        $validated = $request->validate($rules, [
            'current_passcode.required' => __('validation.custom.passcode_update.current_passcode_required'),
            'passcode.required' => __('validation.custom.passcode_update.new_passcode_required'),
            'passcode.confirmed' => __('validation.custom.passcode_update.new_passcode_confirmed'),
        ]);

        $user->passcode = Hash::make($validated['passcode']);
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'passcode-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Download the signed file.
     */
    public function downloadSignedFile(UserFile $userFile)
    {
        // Ensure the user is authorized to download the file
        if ($userFile->user_id !== Auth::id()) {
            abort(403);
        }

        $fileName = $userFile->original_file_name;
        $filePath = $userFile->signed_file_path;

        if (!file_exists($filePath)) {
            return back()->with('fail', 'File not found.');
        }

        return Storage::download($filePath, 'signed.'.$fileName);
    }

    /**
     * Download the original file.
     */
    public function downloadOriginalFile(UserFile $userFile)
    {
        // Ensure the user is authorized to download the file
        if ($userFile->user_id !== Auth::id()) {
            abort(403);
        }

        $filePath = $userFile->original_file_path;
        $fileName = $userFile->original_file_name;

        if (!Storage::exists($filePath)) {
            return back()->with('fail', 'File not found.');
        }

        return Storage::download($filePath, $fileName);
    }
}
