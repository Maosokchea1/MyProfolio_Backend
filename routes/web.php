<?php
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

// Route សម្រាប់បង្ហាញ/ទាញយក CV តាមរយៈ Storage Facade ដោយសុវត្ថិភាព
Route::get('/storage/profiles/cv/{filename}', function ($filename) {
    $path = 'profiles/cv/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'CV file not found.');
    }

    return Storage::disk('public')->response($path);
})->where('filename', '.*');