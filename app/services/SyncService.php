<?php
/**
 *
 * File: syncService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 22/1/24
 * Time: 12:32 μ.μ.
 *
 */

namespace apps4net\syncDB\services;

use apps4net\syncDB\libraries\DB;

class SyncService
{
    /**
     * Get a list of tables
     *
     * @return array
     * @throws \Exception
     */
    public function getListOfTables(): array
    {
        DB::connect();

        $sql = "SHOW TABLES";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $listOfTables = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // If $listOfTables is empty throw an exception
        if (empty($listOfTables)) {
            throw new \Exception("No tables found");
        }

        // convert array from array with key Tables_in_db to array without key
        return array_map(function ($item) {
            return $item['Tables_in_db'];
        }, $listOfTables);
    }

    /**
     * Get the checksum of a table
     *
     * @param string $table
     * @return string
     */
    private function getChecksumOfTableContent(string $table): string
    {
        DB::connect();

        $sql = "CHECKSUM TABLE $table";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $checksum = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['Checksum'];

        // If $checksum is empty throw an exception
        if (empty($checksum)) {
            $checksum = '0';
        }

        return $checksum;
    }

    /**
     * Get the checksums of a list of tables
     *
     * @param array $tables
     * @return array
     * @throws \Exception
     */
    private function getTablesChecksums(array $tables): array {
        $checksums = [];

        foreach ($tables as $table) {
            $checksums[$table] = $this->getChecksumOfTableContent($table);
        }

        if(empty($checksums)) {
            throw new \Exception("No checksums found");
        }

        return $checksums;
    }

    /**
     * @throws \Exception
     */
    public function getChecksums(): array
    {
        $listOfTables = [];
        $checksums = [];

        try {
            $listOfTables = $this->getListOfTables();
        } catch (\Exception $e) {
             throw new \Exception($e->getMessage());
        }

        try {
            $checksums = $this->getTablesChecksums($listOfTables);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $checksums;
    }
}
