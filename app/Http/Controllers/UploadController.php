<?php

namespace App\Http\Controllers;

use App\Helpers\RSSPHelper;
use App\Models\OwnerUser;
use App\Models\UserFile;
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
        $user = \Auth::user();
        $owners = $user->owners;
        return view('upload', compact('owners'));
    }

    public function upload(Request $request)
    {
        // 1. Validate the uploaded file
        $request->validate([
            'file_to_sign' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // Max 10MB
            'owner_id' => 'required|exists:owners,id',
        ]);

        $file = $request->file('file_to_sign');
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $originalFilePath = $file->store('sign_documents');

        $user = \Auth::user();



        if ($extension == 'pdf') {
            $ownerUser = OwnerUser::where('owner_id', $request->owner_id)
                ->where('user_id', $user->id)
                ->first();

            [$status, $signedFilePath] = RSSPHelper::signPDF(
                $originalFilePath,
                $ownerUser,
                $request->input('signature_page'),
                $request->input('signature_position'),
                $request->input('reason'),
                $request->input('location'),
                $user->background_signature
            );
            $signedFilePath = $signedFilePath == "" ? null : $signedFilePath;
            if ($status && $signedFilePath) {
                $userFile = UserFile::create([
                    'user_id' => $user->id,
                    'owner_id' => $request->owner_id,
                    'original_file_name' => $fileName,
                    'original_file_path' => $originalFilePath,
                    'signed_file_path' => $signedFilePath,
                ]);
                return response()->download($signedFilePath, 'signed.' . $fileName);
            }
        } else {
            return back()->with('success', "File uploaded successfully!");
        }

        return back()->with('fail', $signedFilePath ?? "Có lỗi xảy ra khi ký file");
    }
}
