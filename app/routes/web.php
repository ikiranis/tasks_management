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
Route::get('tasks', [TasksListController::class, 'index']);

// Utilities
Route::post('checkLogin', [UserController::class, 'checkLogin']);
Route::post('registerUser', [UserController::class, 'registerUser']);
Route::get('logout', [UserController::class, 'logout']);

// APIs
Route::post('api/createTasksList', [TasksListController::class, 'createTasksList']);
Route::post('api/updateTasksList', [TasksListController::class, 'updateTasksList']);
Route::post('api/addTask', [TasksListController::class, 'addTask']);
Route::post('api/deleteTask', [TasksListController::class, 'deleteTask']);
Route::post('api/deleteTasksList', [TasksListController::class, 'deleteTasksList']);

// Run the routes

Route::run();
