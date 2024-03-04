<?php
/**
 *
 * File: AuditTrailService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 26/1/24
 * Time: 10:31 π.μ.
 *
 */

namespace apps4net\syncDB\services;

use apps4net\syncDB\libraries\DB;

class AuditTrailService
{

    /**
     * Read the audit_trail table
     *
     * @return array
     * @throws \Exception
     */
    public function readAuditTrailTable(): array
    {
        $result = [];

        DB::connect();

        $sql = <<<EOT
            SELECT * FROM audit_trail
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $auditTrailRecords = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error reading audit_trail table: " . $e->getMessage());
        }

        if(empty($auditTrailRecords)) {
            throw new \Exception("No records found in audit_trail table");
        }

        return $auditTrailRecords;
    }

    /**
     * Delete imported records from audit_trail table
     *
     * @param int $lastRecordInserted
     * @throws \Exception
     */
    public function deleteImportedRecords(int $lastRecordInserted): void
    {
        DB::connect();

        $sql = <<<EOT
            DELETE FROM audit_trail WHERE id <= :lastRecordInserted
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->bindParam(':lastRecordInserted', $lastRecordInserted, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error deleting imported records from audit_trail table: " . $e->getMessage());
        }
    }
}
