<?php

namespace apps4net\tasks\routes;

use apps4net\tasks\controllers\TasksListController;
use apps4net\tasks\controllers\UserController;
use apps4net\tasks\libraries\Route;
use apps4net\tasks\controllers\MainController;

// Declare the app routes

// Main views
Route::get('', [MainController::class, 'index']);
Route::get('teams', [MainController::class, 'teams']);
Route::get('login', [MainController::class, 'login']);
Route::get('register', [MainController::class, 'register']);
Route::get('tasks', [MainController::class, 'tasks']);

// Utilities
Route::post('checkLogin', [UserController::class, 'checkLogin']);
Route::post('registerUser', [UserController::class, 'registerUser']);
Route::get('logout', [UserController::class, 'logout']);

// APIs
Route::post('createTasksList', [TasksListController::class, 'createTasksList']);

// Run the routes

Route::run();
