<?php
/**
 *
 * File: RestoreTables.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 26/1/24
 * Time: 11:25 π.μ.
 *
 */

namespace apps4net\syncDB\services;

use apps4net\syncDB\libraries\DB;

class RestoreTablesService
{
    private array $errors = [];

    /**
     * Run the main process of restoring tables
     *
     * @param array $auditTrailRecords
     * @return array
     */
    public function run(array $auditTrailRecords): array
    {
        DB::connect();
        DB::$conn->beginTransaction();

        foreach ($auditTrailRecords as $auditTrailRecord) {
            switch ($auditTrailRecord['operation']) {
                case 'INSERT':
                    $this->doTheInsert($auditTrailRecord);
                    break;
                case 'UPDATE':
                    $this->doTheUpdate($auditTrailRecord);
                    break;
                case 'DELETE':
                    $this->doTheDelete($auditTrailRecord);
                    break;
            }
        }

        // If there are no errors, commit the transaction. Else, rollback
        if (count($this->errors) === 0) {
            DB::$conn->commit();


            $lastRecordInserted = $auditTrailRecords[count($auditTrailRecords) - 1]['id'];

            // Delete imported records from remote audit_trail table
            try {
                $API = new APICallsService();
                $API->deleteImportedRecords($lastRecordInserted);
            } catch (\Exception $e) {
                $this->setError($e->getMessage(), $lastRecordInserted, 'Deleting imported records');
            }
        } else {
            DB::$conn->rollBack();
        }

        return $this->errors;
    }

    /**
     * Errors getter
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Set an error on the errors array
     *
     * @param string $action
     * @param string $message
     * @param int $index
     * @return void
     */
    private function setError(string $message, int $index, string $action): void
    {
        $this->errors[] = [
            'index' => $index,
            'action' => $action,
            'error' => $message
        ];
    }

    /**
     * Do the insert of a record
     *
     * @param array $auditTrailRecord
     */
    private function doTheInsert(array $auditTrailRecord): void
    {
        $tableMetadata = [];

        try {
            $tableMetadata = $this->getTableMetadata($auditTrailRecord['table_name']);
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), $auditTrailRecord['id'], 'Getting table metadata');
        }

        $newValues = $this->castValuesWithTypes($tableMetadata, $auditTrailRecord['new_data']);

        $sql = <<<EOT
            INSERT INTO {$auditTrailRecord['table_name']} ({$this->getTableFields($tableMetadata)})
            VALUES ({$newValues})
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            $this->setError("Error inserting record in {$auditTrailRecord['table_name']} table: " . $e->getMessage(), $auditTrailRecord['id'], $sql);
        }
    }

    /**
     * Do the update of a record
     *
     * @param array $auditTrailRecord
     */
    private function doTheUpdate(array $auditTrailRecord): void
    {
        $tableMetadata = [];

        try {
            $tableMetadata = $this->getTableMetadata($auditTrailRecord['table_name']);
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), $auditTrailRecord['id'], 'Getting table metadata');
        }

        $primaryKey = $this->getThePrimaryKeyOfATable($tableMetadata, $auditTrailRecord['new_data']);

        $updatedFields = $this->getUpdatedFields(
            $auditTrailRecord['new_data'],
            $auditTrailRecord['old_data'],
            $this->getTableFields($tableMetadata));

        $sql = <<<EOT
            UPDATE {$auditTrailRecord['table_name']}
            SET {$updatedFields}
            WHERE {$primaryKey['primaryKey']} = {$primaryKey['data']}
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            $this->setError("Error updating record in {$auditTrailRecord['table_name']} table: " . $e->getMessage(), $auditTrailRecord['id'], $sql);
        }
    }

    /**
     * Do the delete of a record
     *
     * @param array $auditTrailRecord
     */
    private function doTheDelete(array $auditTrailRecord): void
    {
        $tableMetadata = [];

        try {
            $tableMetadata = $this->getTableMetadata($auditTrailRecord['table_name']);
        } catch (\Exception $e) {
            $this->setError($e->getMessage(), $auditTrailRecord['id'], 'Getting table metadata');
        }

        $primaryKey = $this->getThePrimaryKeyOfATable($tableMetadata, $auditTrailRecord['old_data']);

        $sql = <<<EOT
            DELETE FROM {$auditTrailRecord['table_name']}
            WHERE {$primaryKey['primaryKey']} = {$primaryKey['data']}
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            $this->setError("Error deleting record in {$auditTrailRecord['table_name']} table: " . $e->getMessage(), $auditTrailRecord['id'], $sql);
        }
    }

    /**
     * Get the primary key of a table and the data of it, searching in the metadata
     *
     * @param array $tableMetadata
     * @param string $data
     * @return array
     */
    private function getThePrimaryKeyOfATable(array $tableMetadata, string $data): array
    {
        $primaryKey = '';
        $index = 0;

        foreach ($tableMetadata as $key => $field) {
            if ($field['COLUMN_KEY'] === 'PRI') {
                $primaryKey = $field['COLUMN_NAME'];
                break;
            }
        }

        $values = explode(',', $data);

        return [
            'primaryKey' => $primaryKey,
            'data' => $values[$index]
        ];
    }

    /**
     * Get updated fields in format column1 = value1, column2 = value2 etc
     *
     * @param string $newData
     * @param string $oldData
     * @param string $tableFields
     * @return string
     */
    private function getUpdatedFields(string $newData, string $oldData, string $tableFields): string
    {
        $newData = $this->addQuotesToValues($newData);
        $oldData = $this->addQuotesToValues($oldData);

        $newValues = explode(',', $newData);
        $oldValues = explode(',', $oldData);
        $tableFields = explode(',', $tableFields);

        $updatedFields = '';
        foreach ($newValues as $key => $value) {
            if ($value !== $oldValues[$key]) {
                $updatedFields .= $tableFields[$key] . ' = ' . $value . ',';
            }
        }

        return substr($updatedFields, 0, -1);
    }

    /**
     * Get new values of data with Cast of types
     *
     * @param array $tableMetadata
     * @param string $data
     * @return string
     */
    private function castValuesWithTypes(array $tableMetadata, string $data): string
    {
        $convertTypes = [
            'timestamp' => 'DATETIME',
            'tinyint' => 'UNSIGNED'
        ];

        $doNotCastTypes = [
            'text'
        ];

        $columnTypes = $this->getColumnTypes($tableMetadata);

        $data = $this->addQuotesToValues($data);

        $values = explode(',', $data);

        $newValues = '';
        foreach ($values as $key => $value) {
            if ($value === "'NULL'") {
                $newValues .= "NULL,";
            } else {
                $type = trim($columnTypes[$key]['type']);

                // Convert types for mariadb
                foreach ($convertTypes as $typeToChange => $convertType) {
                    if (str_contains($type, $typeToChange)) {
                        $type = $convertType;
                    }
                }

                if (!in_array($type, $doNotCastTypes)) {
                    $newValues .= "CAST(" . $value . " AS " . $type . "),";
                } else {
                    $newValues .= $value . ",";
                }
            }
        }

        $newValues = substr($newValues, 0, -1);
        $newValues = str_replace('\'NULL\'', 'NULL', $newValues);

        return $newValues;
    }

    /**
     * Get the fields of a table
     *
     * @param array $tableMetadata
     * @return string
     */
    private function getTableFields(array $tableMetadata): string
    {
        $fields = '';

        foreach ($tableMetadata as $field) {
            $fields .= $field['COLUMN_NAME'] . ',';
        }

        return substr($fields, 0, -1);
    }

    /**
     * Get the types of columns of a table
     *
     * @param array $tableMetadata
     * @return array
     */
    private function getColumnTypes(array $tableMetadata): array
    {
        $types = [];

        foreach ($tableMetadata as $field) {
            $type = $field['DATA_TYPE'];
            if ($type === 'varchar') {
                $type .= '(' . $field['CHARACTER_MAXIMUM_LENGTH'] . ')';
            }
            $types[] = [
                'columnName' => $field['COLUMN_NAME'],
                'type' => $type
            ];
        }

        return $types;
    }

    /**
     * Get all the metadata of a table
     *
     * @param string $table
     * @return array
     * @throws \Exception
     */
    private function getTableMetadata(string $table): array
    {
        $sql = <<<EOT
            SELECT *
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table';
        EOT;

        try {
            $stmt = DB::$conn->prepare($sql);
            $stmt->execute();

            $tableMetadata = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error reading $table table: " . $e->getMessage());
        }

        return $tableMetadata;
    }

    /**
     * Add quotes to values
     *
     * @param string $values
     * @return string
     */
    private function addQuotesToValues(string $values): string
    {
        $values = explode(',', $values);

        $valuesWithQuotes = '';
        foreach ($values as $value) {
            $trimmedValue = trim($value);
            $valuesWithQuotes .= "'$trimmedValue',";
        }

        return substr($valuesWithQuotes, 0, -1);
    }
}
