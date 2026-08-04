<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

Route::get('/skills', [SkillController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);

Route::get('/educations', [EducationController::class, 'index']);
Route::get('/experiences', [ExperienceController::class, 'index']);

Route::post('/contacts', [ContactController::class, 'store']);
