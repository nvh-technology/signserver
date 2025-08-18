<?php

namespace App\Helpers;

use App\Models\Owner;
use App\Models\OwnerUser;
use File;
use Process;
use Storage;

class RSSPHelper
{
    public static function signPDF($fileToSign, OwnerUser $ownerUser, $signaturePage = null, $signaturePosition = null, $reason = null, $location = null, $backgroundSignature = null)
    {
        $sdkDirectory = storage_path(env("RSSP_SDK_DIRECTORY", 'app/private/rssp_sdk'));
        $sdkName = env("RSSP_SDK_NAME", 'rssp_sdk.exe');

        $sdkPath = $sdkDirectory . '/' . $sdkName;

        $signedDir = $sdkDirectory . '/signeds';
        if (!File::isDirectory($signedDir)) {
            File::makeDirectory($signedDir, 0755, true);
        }

        $fileToSignPath = Storage::disk('local')->path($fileToSign);

        // --- Gọi Process ---
        // $args = [
        //     // $sdkPath,
        //     '--fileConfig' => Storage::disk('local')->path($ownerUser->owner->fileConfig),
        //     '--keystoreFile' => Storage::disk('local')->path($ownerUser->owner->keystoreFile),
        //     // '--userID' => 'USERNAME:202506100930',
        //     '--passCode' => '12345678',
        //     '--filePDF' => $fileToSignPath,
        //     // Thêm các tham số tùy chọn khác nếu cần
        //     // '--reason' => 'Xác nhận hợp đồng',
        //     // '--location' => 'Hà Nội',
        // ];

        // if ($ownerUser->userName) {
        //     $args['--userID'] = $ownerUser->userName;
        // }
        // if ($ownerUser->credentialID) {
        //     $args['--credentialID'] = $ownerUser->credentialID;
        // }
        $cmd = $sdkName;
        $cmd .= ' --fileConfig "' . Storage::disk('local')->path($ownerUser->owner->fileConfig) . '"';
        $cmd .= ' --userID "' . $ownerUser->userName . '"';
        $cmd .= ' --passCode "' . $ownerUser->passcode . '"';
        $cmd .= ' --filePDF "' . $fileToSignPath . '"';
        $cmd .= ' --keystoreFile "' . Storage::disk('local')->path($ownerUser->owner->keystoreFile) . '"';
        $cmd .= ' --signedsPath "' . storage_path('app/private/signed_documents'). '"';

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

        $result = Process::path($sdkDirectory)->run($cmd);
        // rssp_sdk.exe --fileConfig "BVTH_DEMO.ssl2" --userID "USERNAME:202506100930" --passCode "12345678" --filePDF "sample.pdf"



        // --- Xử lý kết quả trả về ---
        if ($result->successful()) {
            $output = $result->output();
            $signedFilePath = null;

            // Dùng regex để tìm dòng thông báo thành công và lấy đường dẫn file
            // Mẫu regex tìm kiếm chuỗi "Signed PDF saved as " theo sau là đường dẫn
            if (preg_match('/^Signed PDF saved as (.*)/m', $output, $matches)) {
                // $matches[1] sẽ chứa đường dẫn file, ví dụ: "D:\signserver\storage\app/private/signed_documents\signed.sample.pdf"
                $signedFilePath = trim($matches[1]);
            }

            if ($signedFilePath && File::exists($signedFilePath)) {
                // **THÀNH CÔNG:** Trả về file đã ký cho người dùng tải xuống
                // return response()->download($signedFilePath, 'signed_' . $fileToSign);
                return [true, $signedFilePath];

                /* // Hoặc bạn có thể trả về một JSON chứa đường dẫn file
                return response()->json([
                    'status' => 'success',
                    'message' => 'File signed successfully.',
                    'signed_file_path' => $signedFilePath
                ]);
                */
            } else {
                // **LỖI LOGIC:** Process chạy xong (exit code 0) nhưng không tạo ra file
                // Thường là do lỗi logic bên trong file .exe (ví dụ: không tìm thấy cert)
                return [false, $output];
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'SDK executed but failed to produce a signed file.',
                //     'sdk_output' => $output // Trả về output của SDK để debug
                // ], 500);
            }
        } else {
            // **LỖI THỰC THI:** Process không thể chạy hoặc kết thúc với lỗi
            $errorOutput = $result->errorOutput();
            return [false, $errorOutput];
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'SDK execution failed.',
            //     'error' => $errorOutput
            // ], 500);
        }
    }
}
