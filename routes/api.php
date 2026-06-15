<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AIController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/ai/chat', [AIController::class, 'chat']);
Route::middleware('auth:sanctum')->post('/ai/chat', [AIController::class, 'chat']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});

Route::middleware('auth:sanctum')->group(function () {

    // AI Chat
    Route::post('/ai/chat', [AIController::class, 'chat']);

    // AI Suggestions
    Route::post('/ai/suggest', [AIController::class, 'suggest']);

    // AI Summary
    Route::post('/ai/summarize', [AIController::class, 'summarize']);

    // Natural language commands
    Route::post('/ai/command', [AIController::class, 'command']);
});