<?php

namespace apps4net\tasks\routes;

use apps4net\tasks\controllers\UserController;
use apps4net\tasks\libraries\Route;
use apps4net\tasks\controllers\MainController;

// Declare the app routes

// Main views
Route::get('', [MainController::class, 'index']);
Route::get('groups', [MainController::class, 'groups']);
Route::get('login', [MainController::class, 'login']);
Route::get('register', [MainController::class, 'register']);
Route::get('tasks', [MainController::class, 'tasks']);

// Utilities
Route::post('checkLogin', [UserController::class, 'checkLogin']);

// Run the routes

Route::run();
