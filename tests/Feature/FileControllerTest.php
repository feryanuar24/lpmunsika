<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_404_for_missing_file(): void
    {
        $disk = config('filesystems.default');
        Storage::fake($disk);

        $response = $this->get(route('files', ['path' => 'missing/test.pdf']));

        $response->assertNotFound();
    }

    public function test_it_serves_pdf_file_inline(): void
    {
        $disk = config('filesystems.default');
        Storage::fake($disk);

        $path = 'docs/sample.pdf';
        $content = 'pdf-content';
        Storage::disk($disk)->put($path, $content);

        $response = $this->get(route('files', ['path' => $path]));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'inline; filename="sample.pdf"');
        $response->assertHeader('Content-Length', (string) strlen($content));
    }

    public function test_it_serves_non_inline_file_as_attachment(): void
    {
        $disk = config('filesystems.default');
        Storage::fake($disk);

        $path = 'docs/sample.txt';
        $content = 'plain-text-content';
        Storage::disk($disk)->put($path, $content);

        $response = $this->get(route('files', ['path' => $path]));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename="sample.txt"');
        $response->assertHeader('Content-Length', (string) strlen($content));
    }
}
