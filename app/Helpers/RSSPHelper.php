<?php

namespace App\Helpers;

use App\Models\OwnerUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class RSSPHelper
{
    /**
     * Signs a file (PDF or Office) using the RSSP SDK.
     *
     * @param string $fileToSign The path to the file in storage.
     * @param string $fileExtension The extension of the file (e.g., 'pdf', 'docx').
     * @param OwnerUser $ownerUser The user and owner details for signing.
     * @param string|null $signaturePage The page for the visible signature (PDF only).
     * @param string|null $signaturePosition The position for the visible signature (PDF only).
     * @param string|null $reason The reason for signing (PDF only).
     * @param string|null $location The location of signing (PDF only).
     * @param string|null $backgroundSignature The path to the background image for the signature (PDF only).
     * @return array [bool $status, string $result]
     */
    public static function signFile($fileToSign, $fileExtension, OwnerUser $ownerUser, $signaturePage = null, $signaturePosition = null, $reason = null, $location = null, $backgroundSignature = null)
    {
        $sdkDirectory = storage_path(env("RSSP_SDK_DIRECTORY", 'app/private/rssp_sdk'));
        $sdkName = env("RSSP_SDK_NAME", 'Program.exe'); // Updated to match the C# project output

        $fileToSignPath = Storage::disk('local')->path($fileToSign);
        $signedDocumentsPath = storage_path('app/private/signed_documents');

        if (!File::isDirectory($signedDocumentsPath)) {
            File::makeDirectory($signedDocumentsPath, 0755, true);
        }

        // --- Build the command ---
        $cmd = $sdkName;
        $cmd .= ' --fileConfig "' . Storage::disk('local')->path($ownerUser->owner->fileConfig) . '"';
        $cmd .= ' --keystoreFile "' . Storage::disk('local')->path($ownerUser->owner->keystoreFile) . '"';
        $cmd .= ' --passCode "' . $ownerUser->passcode . '"';
        $cmd .= ' --signedsPath "' . $signedDocumentsPath . '"';

        if ($ownerUser->userName) {
            $cmd .= ' --userID "' . $ownerUser->userName . '"';
        }
        if ($ownerUser->credentialID) {
            $cmd .= ' --credentialID "' . $ownerUser->credentialID . '"';
        }

        // Add file-specific argument
        if ($fileExtension === 'pdf') {
            $cmd .= ' --filePDF "' . $fileToSignPath . '"';
        } else {
            $cmd .= ' --fileOffice "' . $fileToSignPath . '"';
        }

        // Add PDF-only optional parameters
        if ($fileExtension === 'pdf') {
            if ($signaturePage && $signaturePosition) {
                $cmd .= ' --page "' . $signaturePage . '"';
                $cmd .= ' --position "' . $signaturePosition . '"';
            }
            if ($reason) {
                $cmd .= ' --reason "' . $reason . '"';
            }
            if ($location) {
                $cmd .= ' --location "' . $location . '"';
            }
            if ($backgroundSignature) {
                $cmd .= ' --backgroundPath "' . Storage::disk('local')->path($backgroundSignature) . '"';
            }
        }

        // --- Execute the command ---
        $result = Process::path($sdkDirectory)->run($cmd);
        // $xxxx = $result->output();
        // echo $xxxx;
        // echo '<br>=========<br>';
        // echo $cmd;
        // dd();
        // return [true, $xxxx];
        // --- Process the result ---
        if ($result->successful()) {
            $output = $result->output();
            $signedFilePath = null;

            // Use regex to find the success message and get the file path
            if (preg_match('/^Signed successfully saved as (.*)/m', $output, $matches)) {
                $signedFilePath = trim($matches[1]);
            }

            if ($signedFilePath && File::exists($signedFilePath)) {
                return [true, $signedFilePath];
            } else {
                // SDK process succeeded but didn't produce a file or the path was not found.
                return [false, "SDK Error: " . ($output ?: 'No output from SDK.')];
            }
        } else {
            // SDK process failed to execute.
            return [false, "Process Error: " . $result->errorOutput()];
        }
    }
}
