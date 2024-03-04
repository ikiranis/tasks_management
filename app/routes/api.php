<?php
/**
 *
 * File: index.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 19/1/24
 * Time: 12:54 μ.μ.
 *
 */

namespace apps4net\syncDB\routes;

use apps4net\syncDB\libraries\Route;
use apps4net\syncDB\controllers\SyncController;

Route::get('/', [SyncController::class, 'index']);
Route::get('/getChecksums', [SyncController::class, 'getChecksums']);
Route::get('/createTriggers', [SyncController::class, 'createTriggers']);
Route::get('/readAuditTrail', [SyncController::class, 'readAuditTrail']);
Route::get('/restoreTables', [SyncController::class, 'syncWithRemoteAuditTrail']);
Route::get('/deleteImportedRecords', [SyncController::class, 'deleteImportedRecords']);
Route::get('/checkDB', [SyncController::class, 'checkDBIntegrity']);

Route::run();
