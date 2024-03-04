<?php
/**
 *
 * File: Sync.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 19/1/24
 * Time: 1:00 μ.μ.
 *
 * Controller with main methods for syncing the local database with the remote one
 *
 */

namespace apps4net\syncDB\controllers;

use apps4net\syncDB\services\APICallsService;
use apps4net\syncDB\services\AuditTrailService;
use apps4net\syncDB\services\RestoreTablesService;
use apps4net\syncDB\services\SyncService;
use apps4net\syncDB\services\TriggersGeneratorService;

class SyncController extends Controller
{
    private SyncService $syncService;
    private TriggersGeneratorService $triggersGeneratorService;
    private AuditTrailService $auditTrailService;
    private RestoreTablesService $restoreTablesService;
    private APICallsService $API;

    public function __construct()
    {
        parent::__construct();

        $this->syncService = new SyncService();
        $this->triggersGeneratorService = new TriggersGeneratorService();
        $this->auditTrailService = new AuditTrailService();
        $this->restoreTablesService = new RestoreTablesService();
        $this->API = new APICallsService();
    }

    /**
     * Get a list of tables
     */
    public function index(): void
    {
        $this->returnSuccess([
            'message' => 'Welcome to the SyncDB API'
        ]);
    }

    /**
     * Create triggers for all tables and create the audit trail table
     *
     * @return void
     */
    public function createTriggers(): void
    {
        if ($_ENV['REMOTE_API_URL'] !== "") {
            $this->returnError(400, "You can't run this script from local host");
        }

        $listOfTables = [];
        $excludeTables = ['jos_session', 'audit_trail'];

        try {
            $listOfTables = $this->syncService->getListOfTables();

            // Remove the tables that we don't want to create triggers
            $listOfTables = array_diff($listOfTables, $excludeTables);
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        $this->triggersGeneratorService->generate($listOfTables);

        $this->returnSuccess(['message' => 'Triggers created successfully']);
    }

    /**
     * Read the audit trail table
     *
     * @return void
     */
    public function readAuditTrail(): void
    {
        if ($_ENV['REMOTE_API_URL'] !== "") {
            $this->returnError(400, "You can't run this script from local host");
        }

        $auditTrailRecords = [];

        try {
            $auditTrailRecords = $this->auditTrailService->readAuditTrailTable();
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        $result = [
            "auditTrailRecords" => $auditTrailRecords
        ];

        $this->returnSuccess($result);
    }

    /**
     * Sync the local database with the remote audit trail
     *
     * @return void
     */
    public function syncWithRemoteAuditTrail(): void
    {
        if ($_ENV['REMOTE_API_URL'] === "") {
            $this->returnError(400, "You can't run this script from remote server");
        }

        $auditTrailRecords = [];

        try {
            $auditTrailRecords = $this->API->readAuditTrail();
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        $restoreResult = $this->restoreTablesService->run($auditTrailRecords['data']['auditTrailRecords']);

        $errorMessage = 'Tables restored successfully';
        if (count($restoreResult) > 0) {
            $auditTrailRecordsCount = count($auditTrailRecords['data']['auditTrailRecords']);

            $errorMessage = 'There were errors while restoring tables. '
                . count($restoreResult) . ' out of ' . $auditTrailRecordsCount
                . ' records failed to restore. All the changes has been reverted (rollback).';
        }

        $this->returnSuccess([
            'message' => $errorMessage,
            'auditTrailRecords' => $auditTrailRecords['data']['auditTrailRecords'],
            'errors' => $restoreResult
        ]);
    }

    /**
     * Delete imported records from audit_trail table
     *
     * @return void
     */
    public function deleteImportedRecords(): void
    {
        if ($_ENV['REMOTE_API_URL'] !== "") {
            $this->returnError(400, "You can't run this script from local host");
        }

        $lastRecordInserted = $_GET['lastRecordInserted'] ?? 0;

        if ($lastRecordInserted === 0) {
            $this->returnError(400, 'lastRecordInserted parameter is required');
        }

        try {
            $this->auditTrailService->deleteImportedRecords($lastRecordInserted);
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        $this->returnSuccess(['message' => 'Imported records deleted successfully']);
    }

    /**
     * Get the checksums of all tables
     *
     * @return void
     */
    public function getChecksums(): void
    {
        $checksums = [];

        try {
            $checksums = $this->syncService->getChecksums();
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        $result = [
            "checksums" => $checksums
        ];

        $this->returnSuccess($result);
    }

    /**
     * Check the integrity of the database
     *
     * @return void
     */
    public function checkDBIntegrity(): void
    {
        $remoteChecksums = [];
        $localChecksums = [];

        // Get remote checksums
        try {
            $remoteChecksums = $this->API->getRemoteChecksums()['data']['checksums'];
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        // Get local checksums
        try {
            $localChecksums = $this->syncService->getChecksums();
        } catch (\Exception $e) {
            $this->returnError(400, $e->getMessage());
        }

        // Check for differences
        $differences = [];
        foreach ($remoteChecksums as $table => $checksum) {
            if ($checksum !== $localChecksums[$table]) {
                $differences[$table] = [
                    'remote' => $checksum,
                    'local' => $localChecksums[$table]
                ];
            }
        }

        $result = [
            "differences" => $differences
        ];

        $this->returnSuccess($result);
    }
}
