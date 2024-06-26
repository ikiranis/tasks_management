<?php

namespace apps4net\tasks\routes;

use apps4net\tasks\controllers\TasksListController;
use apps4net\tasks\controllers\TeamsController;
use apps4net\tasks\controllers\UserController;
use apps4net\tasks\libraries\Route;
use apps4net\tasks\controllers\MainController;

// Declare the app routes

// Main views
Route::get('', [MainController::class, 'index']);
Route::get('teams', [TeamsController::class, 'index']);
Route::get('login', [UserController::class, 'login']);
Route::get('register', [UserController::class, 'register']);
Route::get('tasks', [TasksListController::class, 'index']);
Route::get('termsOfUse', [MainController::class, 'termsOfUse']);
Route::get('privacyPolicy', [MainController::class, 'privacyPolicy']);
Route::get('xml', [TeamsController::class, 'displayTransformedXML']);

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
Route::post('api/createTeam', [TeamsController::class, 'createTeam']);
Route::post('api/addUserToTeam', [TeamsController::class, 'addUserToTeam']);
Route::post('api/addUserToList', [TasksListController::class, 'addUserToList']);
Route::get('api/checkUsername', [UserController::class, 'checkUsername']);
Route::get('api/exportTeamsToXML', [TeamsController::class, 'exportTeamsToXML']);

// Run the routes

Route::run();
