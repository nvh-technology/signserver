<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = Owner::all();
        return view('admin.users.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:8',
            'passcode' => 'required|string',
            'owners' => 'array',
            'owners.*' => 'exists:owners,id',
            'owner_pivot' => 'array',
            'owner_pivot.*.userName' => 'nullable|string',
            'owner_pivot.*.passcode' => 'nullable|string',
            'owner_pivot.*.credentialID' => 'nullable|string',
            'backgroundSignature' => 'nullable|image|mimes:png|max:2048',
        ]);

        $request->validate([
            'owners' => [
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($value as $ownerId) {
                        $userName = $request->input('owner_pivot.' . $ownerId . '.userName');
                        $credentialID = $request->input('owner_pivot.' . $ownerId . '.credentialID');

                        if (empty($userName) && empty($credentialID)) {
                            $owner = Owner::find($ownerId);
                            $fail(__('validation.custom.user.owner_credential_missing', ['owner_name' => $owner->name]));
                        }
                    }
                },
            ],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'passcode' => bcrypt($validatedData['passcode']),
        ]);

        if ($request->hasFile('backgroundSignature')) {
            $file = $request->file('backgroundSignature');
            $extension = $file->getClientOriginalExtension();
            $randomName = \Str::random(40) . '.' . $extension;
            $path = $file->storeAs('backgrounds', $randomName);
            $user->backgroundSignature = $path;
            $user->save();
        }

        if (isset($validatedData['owners'])) {
            $syncData = [];
            foreach ($validatedData['owners'] as $ownerId) {
                $pivot = $validatedData['owner_pivot'][$ownerId] ?? [];
                $syncData[$ownerId] = [
                    'userName' => $pivot['userName'] ?? null,
                    'passcode' => $pivot['passcode'] ?? null,
                    'credentialID' => $pivot['credentialID'] ?? null,
                ];
            }
            $user->owners()->sync($syncData);
        }

        return redirect()->route('admin.users.index')->with('success', __('validation.custom.user.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $owners = Owner::all();
        return view('admin.users.edit', compact('user', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'passcode' => 'required|string',
            'owners' => 'array',
            'owners.*' => 'exists:owners,id',
            'owner_pivot' => 'array',
            'owner_pivot.*.userName' => 'nullable|string',
            'owner_pivot.*.passcode' => 'nullable|string',
            'owner_pivot.*.credentialID' => 'nullable|string',
            'backgroundSignature' => 'nullable|image|mimes:png|max:2048',
        ]);

        $request->validate([
            'owners' => [
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($value as $ownerId) {
                        $userName = $request->input('owner_pivot.' . $ownerId . '.userName');
                        $credentialID = $request->input('owner_pivot.' . $ownerId . '.credentialID');

                        if (empty($userName) && empty($credentialID)) {
                            $owner = Owner::find($ownerId);
                            $fail(__('validation.custom.user.owner_credential_missing', ['owner_name' => $owner->name]));
                        }
                    }
                },
            ],
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
        // Passcode is now required, so no need for filled check
        $user->passcode = bcrypt($validatedData['passcode']);

        if ($request->hasFile('backgroundSignature')) {
            // Delete old background if it exists
            if ($user->backgroundSignature) {
                Storage::disk('local')->delete($user->backgroundSignature);
            }
            $file = $request->file('backgroundSignature');
            $extension = $file->getClientOriginalExtension();
            $randomName = \Str::random(40) . '.' . $extension;
            $path = $file->storeAs('backgrounds', $randomName);
            $user->backgroundSignature = $path;
        }

        $user->save();

        if (isset($validatedData['owners'])) {
            $syncData = [];
            foreach ($validatedData['owners'] as $ownerId) {
                $pivot = $validatedData['owner_pivot'][$ownerId] ?? [];
                $syncData[$ownerId] = [
                    'userName' => $pivot['userName'] ?? null,
                    'passcode' => $pivot['passcode'] ?? null,
                    'credentialID' => $pivot['credentialID'] ?? null,
                ];
            }
            $user->owners()->sync($syncData);
        } else {
            $user->owners()->detach(); // Detach all if no owners are selected
        }

        return redirect()->route('admin.users.index')->with('success', __('validation.custom.user.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('validation.custom.user.deleted_success'));
    }

    public function editRoles(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit-roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', __('validation.custom.user.roles_updated_success'));
    }

    public function backgroundSignature(User $user)
    {
        if ($user->backgroundSignature && Storage::disk('local')->exists($user->backgroundSignature)) {
            return response()->file(Storage::disk('local')->path($user->backgroundSignature));
        }

        abort(404);
    }
}