<?php

namespace App\Http\Controllers;

use App\Helpers\RSSPHelper;
use App\Models\OwnerUser;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Display the upload form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        // 1. Validate the uploaded file
        $request->validate([
            'file_to_sign' => 'required|mimes:pdf|max:10240', // Max 10MB
        ]);

        $file = $request->file('file_to_sign');
        $fileName = $file->getClientOriginalName();
        $storeName = \Str::random() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sign_documents', $storeName, 'local');

        $user = \Auth::user();

        if ($request->owner_id) {
            $ownerUser = OwnerUser::where('owner_id', $request->owner_id)
                ->where('user_id', $user->id)
                ->first();
        } else {
            $ownerUser = OwnerUser::where('user_id', $user->id)
                ->first();
        }

        [$status, $signedFilePath] = RSSPHelper::signPDF(
            $path,
            $ownerUser,
            $request->input('signature_page'),
            $request->input('signature_position'),
            $request->input('reason'),
            $request->input('location'),
            $user->background_signature
        );
        $signedFilePath = $signedFilePath == "" ? null : $signedFilePath;
        if ($status && $signedFilePath) {
            return response()->download($signedFilePath, 'signed.' . $fileName);
        }

        return back()->with('fail', $signedFilePath ?? "Có lỗi xảy ra khi ký file");

    }
}
