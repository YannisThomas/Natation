<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramApiController;

Route::get('/programme/{programme}/exercice/{exercise}', [App\Http\Controllers\Api\ProgramApiController::class, 'finished']);
