<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::all();
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'fileConfig' => 'required|file',
            'keystoreFile' => 'nullable|file',
        ]);

        $owner = new Owner();
        $owner->name = $request->name;

        if ($request->hasFile('fileConfig')) {
            $path = $request->file('fileConfig')->store('owners');
            $owner->fileConfig = $path;
        }

        // Handle keystoreFile upload
        if ($request->hasFile('keystoreFile')) {
            $path = $request->file('keystoreFile')->store('owners');
            $owner->keystoreFile = $path;
        }

        $owner->save();

        return redirect()->route('admin.owners.index')->with('success', 'Owner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        return view('admin.owners.show', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Owner $owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $rules = [
            'name' => 'required|string',
        ];

        if (!$owner->fileConfig) {
            $rules['fileConfig'] = 'required|file';
        } else {
            $rules['fileConfig'] = 'nullable|file';
        }

        // Add rules for keystoreFile
        if (!$owner->keystoreFile) {
            $rules['keystoreFile'] = 'nullable|file'; // Can be required if you want to force upload
        } else {
            $rules['keystoreFile'] = 'nullable|file';
        }

        $request->validate($rules);

        $owner->name = $request->name;

        if ($request->hasFile('fileConfig')) {
            // Delete old file if exists
            if ($owner->fileConfig) {
                Storage::disk('local')->delete($owner->fileConfig);
            }
            $path = $request->file('fileConfig')->store('owners');
            $owner->fileConfig = $path;
        }

        // Handle keystoreFile upload
        if ($request->hasFile('keystoreFile')) {
            // Delete old file if exists
            if ($owner->keystoreFile) {
                Storage::disk('local')->delete($owner->keystoreFile);
            }
            $path = $request->file('keystoreFile')->store('owners');
            $owner->keystoreFile = $path;
        }

        $owner->save();

        return redirect()->route('admin.owners.index')->with('success', 'Owner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        if ($owner->fileConfig) {
            Storage::disk('local')->delete($owner->fileConfig);
        }
        // Delete keystoreFile if exists
        if ($owner->keystoreFile) {
            Storage::disk('local')->delete($owner->keystoreFile);
        }
        $owner->delete();

        return redirect()->route('admin.owners.index')->with('success', 'Owner deleted successfully.');
    }

    public function downloadConfig(Owner $owner)
    {
        if (!$owner->fileConfig || !Storage::disk('local')->exists($owner->fileConfig)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download($owner->fileConfig);
    }

    public function downloadKeystore(Owner $owner)
    {
        if (!$owner->keystoreFile || !Storage::disk('local')->exists($owner->keystoreFile)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download($owner->keystoreFile);
    }
}
