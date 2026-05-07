<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Serve file by filesystem disk.
     */
    public function __invoke(string $path): StreamedResponse
    {
        $path = ltrim($path, '/');

        if (!Storage::exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $stream = Storage::readStream($path);
        if ($stream === false) {
            abort(500, 'Gagal membuka file');
        }

        $mimeType = Storage::mimeType($path) ?? 'application/octet-stream';
        $size     = Storage::size($path);
        $filename = basename($path);

        $inlineMime = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
        ];

        $disposition = in_array($mimeType, $inlineMime)
            ? 'inline'
            : 'attachment';

        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            },
            200,
            [
                'Content-Type'        => $mimeType,
                'Content-Length'      => $size,
                'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
                'Cache-Control'       => 'public, max-age=3600',
            ]
        );
    }
}
