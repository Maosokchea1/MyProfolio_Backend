<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route សម្រាប់ទាញយក ឬបង្ហាញ CV ដោយសុវត្ថិភាព មិនឱ្យជាប់ Error 403 លើ Render
Route::get('/view-cv/{filename}', function ($filename) {
    $path = 'profiles/cv/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'CV file not found.');
    }

    return Storage::disk('public')->response($path);
})->where('filename', '.*');