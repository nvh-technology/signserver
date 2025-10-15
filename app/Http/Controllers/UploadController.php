<?php

namespace App\Http\Controllers;

use App\Helpers\RSSPHelper;
use App\Models\OwnerUser;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display the upload form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $owners = $user->owners ?? collect();
        return view('upload', compact('owners'));
    }

    /**
     * Handle the file upload and signing process.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        // 1. Validate the uploaded file and owner selection
        $request->validate([
            // 'file_to_sign' => 'required|max:10240', // Max 10MB
            // 'file_to_sign' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // Max 10MB
            'owner_id' => 'required|exists:owners,id',
            'passcode' => 'required|string',
        ]);

        $user = Auth::user();

        // Check if user has a passcode
        if ($user->passcode) {
            // If yes, check if the provided passcode is correct
            if (!Hash::check($request->passcode, $user->passcode)) {
                return back()->with('fail', __('validation.custom.fail.invalid_passcode'));
            }
        } else {
            // If no, this is the new passcode, so hash and save it
            $user->passcode = Hash::make($request->passcode);
            $user->save();
        }

        $file = $request->file('file_to_sign');
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $randomName = \Str::random(40) . '.' . $extension;
        $originalFilePath = $file->storeAs('original_documents', $randomName);

        $user = Auth::user();
        $ownerUser = OwnerUser::where('owner_id', $request->owner_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$ownerUser) {
            return back()->with('fail', __('validation.custom.fail.not_associated_with_owner'));
        }

        // 2. Call the helper to sign the file
        [$status, $result] = RSSPHelper::signFile(
            $originalFilePath,
            $extension,
            $ownerUser,
            $request->input('signature_page'),
            $request->input('signature_position'),
            $request->input('reason'),
            $request->input('location'),
            $user->backgroundSignature,
            $request->input('signature_type', 'main') // Mặc định là ký chính
        );

        // 3. Handle the result
        if ($status) {
            $signedFilePath = $result;
            // Store file info in the database
            UserFile::create([
                'user_id' => $user->id,
                'owner_id' => $request->owner_id,
                'original_file_name' => $fileName,
                'original_file_path' => $originalFilePath,
                'signed_file_path' => $signedFilePath, // Store the absolute path from the SDK
            ]);

            // Return the signed file for download
            return response()->download($signedFilePath, 'signed-' . $fileName);
        } else {
            // Signing failed, return with the error message from the helper
            $errorMessage = $result;

            if (Storage::exists($originalFilePath)) {
                Storage::delete($originalFilePath);
            }
            
            return back()->with('fail', $errorMessage);
        }
    }
}
