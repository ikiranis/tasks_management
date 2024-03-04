<?php
/**
 *
 * File: TriggersGenerator.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 24/1/24
 * Time: 12:15 μ.μ.
 *
 * The TriggersGeneratorService class, is responsible for generating database triggers for a given
 * list of tables. It provides methods to generate triggers (INSERT, UPDATE, DELETE) for each
 * table, execute these triggers, and manage an audit_trail table that logs changes. The
 * class also includes methods to create SQL strings for each type of trigger, delete
 * existing triggers, and concatenate table columns for inclusion in a trigger.
 *
 */

namespace apps4net\syncDB\services;

use apps4net\syncDB\libraries\DB;

class TriggersGeneratorService
{
    private array $tables;

    /**
     * Start the process of generating the triggers
     *
     * @param array $tables
     * @return void
     */
    public function generate(array $tables): void
    {
        $this->tables = $tables;

        if (!$this->checkForAuditTrailTable()) {
            $this->createAuditTrailTable();
        }

        $this->removeAllTriggers();

        $this->generateTriggers();
    }

    /**
     * Generate the triggers for all tables in array
     *
     * @return void
     */
    private function generateTriggers(): void
    {
        $this->tables = $this->excludeNotBaseTypeTables($this->tables);

        foreach ($this->tables as $table) {
            $this->generateTriggersForTable($table);
        }
    }

    /**
     * Generate the triggers (INSERT, UPDATE, DELETE) for a table
     *
     * @param string $table
     * @return void
     */
    private function generateTriggersForTable(string $table): void
    {
        $this->executeTriggers([
            $this->getInsertTrigger($table),
            $this->getUpdateTrigger($table),
            $this->getDeleteTrigger($table)
        ]);
    }

    /**
     * Execute and create the triggers
     *
     * @param array $triggers
     * @return void
     */
    private function executeTriggers(array $triggers): void
    {
        foreach ($triggers as $trigger) {
            $stmt = DB::$conn->prepare($trigger['trigger']);
            try {
                $stmt->execute();
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }
    }

    /**
     * Get the INSERT trigger string to be executed
     *
     * @param string $table
     * @return string[]
     */
    private function getInsertTrigger(string $table): array
    {
        $columns = $this->getConcatenatedColumns($table, 'NEW');

        $triggerName = "after_insert_$table";

        $trigger = <<<EOT
            CREATE TRIGGER $triggerName AFTER INSERT ON $table
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_trail (operation, table_name, new_data)
                VALUES ('INSERT', '$table', $columns);
            END
        EOT;

        return [
            'trigger' => $trigger,
            'triggerName' => $triggerName
        ];
    }

    /**
     * Get the UPDATE trigger string to be executed
     *
     * @param string $table
     * @return string[]
     */
    private function getUpdateTrigger(string $table): array
    {
        $oldColumns = $this->getConcatenatedColumns($table, 'OLD');
        $newColumns = $this->getConcatenatedColumns($table, 'NEW');

        $triggerName = "before_update_$table";

        $trigger = <<<EOT
            CREATE TRIGGER $triggerName BEFORE UPDATE ON $table
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_trail (operation, table_name, old_data, new_data)
                VALUES ('UPDATE', '$table', $oldColumns, $newColumns);
            END
        EOT;

        return [
            'trigger' => $trigger,
            'triggerName' => $triggerName
        ];
    }

    /**
     * Get the DELETE trigger string to be executed
     *
     * @param string $table
     * @return string[]
     */
    private function getDeleteTrigger(string $table): array
    {
        $oldColumns = $this->getConcatenatedColumns($table, 'OLD');

        $triggerName = "before_delete_$table";

        $trigger = <<<EOT
            CREATE TRIGGER $triggerName BEFORE DELETE ON $table
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_trail (operation, table_name, old_data)
                VALUES ('DELETE', '$table', $oldColumns);
            END
        EOT;

        return [
            'trigger' => $trigger,
            'triggerName' => $triggerName
        ];
    }

    /**
     * Delete the trigger if exists
     *
     * @param string $triggerName
     * @return void
     */
    private function deleteTheTriggerIfExist(string $triggerName): void
    {
        $trigger = <<<EOT
            DROP TRIGGER IF EXISTS $triggerName;
        EOT;

        // Execute the trigger
        $stmt = DB::$conn->prepare($trigger);
        try {
            $stmt->execute();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * Exclude the tables that are not base type
     *
     * @param array $tables
     * @return array
     */
    private function excludeNotBaseTypeTables(array $tables): array
    {
        $sql = <<<EOT
            SELECT * 
            FROM INFORMATION_SCHEMA.TABLES 
            WHERE TABLE_SCHEMA = :databaseName 
        EOT;

        $stmt = DB::$conn->prepare($sql);
        $stmt->bindValue(':databaseName', $_ENV['DB_NAME']);
        $stmt->execute();

        $baseTypeTables = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Remove the tables that are not base type
        foreach ($baseTypeTables as $table) {
            if ($table['TABLE_TYPE'] !== 'BASE TABLE') {
                $index = array_search($table['TABLE_NAME'], $tables);

                unset($tables[$index]);
            }
        }

        return $tables;
    }

    /**
     * Get the concatenated string of table columns to be added in a trigger
     *
     * @param string $table
     * @param string $whenData NEW or OLD
     * @return string
     */
    private function getConcatenatedColumns(string $table, string $whenData): string
    {
        $sql = "SHOW COLUMNS FROM $table";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $collations = $this->getFieldsCollationsInTable($table);

        $columns = [];
        foreach ($result as $row) {
            $collation = $collations[$row['Field']];

            // Get the CONVERT string if the collation is not empty
            $using = empty($collation) ? $whenData . "." . $row['Field'] : "CONVERT(" . $whenData . "." . $row['Field'] . " USING utf8)";

            $columns[] = "IF(" . $whenData . "." . $row['Field'] . " IS NULL, 'NULL', " . $using . ")";
        }

        return "CONCAT(" . implode(", ', ', ", $columns) . ")";
    }

    /**
     * Get the fields collations in a table
     *
     * @param string $table
     * @return array
     */
    private function getFieldsCollationsInTable(string $table): array
    {
        $sql = "SHOW FULL COLUMNS FROM $table";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $fieldsCollations = [];
        foreach ($result as $row) {
            $fieldsCollations[$row['Field']] = $row['Collation'];
        }

        return $fieldsCollations;
    }

    /**
     * Check if the audit_trail table exists
     *
     * @return bool
     */
    private function checkForAuditTrailTable(): bool
    {
        $sql = "SHOW TABLES LIKE 'audit_trail'";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return !empty($result);
    }

    /**
     * Delete the audit_trail table
     *
     * @return bool
     */
    private function deleteAuditTrailTable(): bool
    {
        $sql = "DROP TABLE IF EXISTS audit_trail";
        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return !empty($result);
    }

    /**
     * Create the audit_trail table
     *
     * @return void
     */
    private function createAuditTrailTable(): void
    {
        $sql = <<<EOT
            CREATE TABLE audit_trail (
                id INT AUTO_INCREMENT PRIMARY KEY,
                operation VARCHAR(7),
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                table_name VARCHAR(255),
                old_data TEXT,
                new_data TEXT
            );
        EOT;

        $stmt = DB::$conn->prepare($sql);
        $stmt->execute();
    }

    /**
     * Remove all triggers from the database
     *
     * @return void
     */
    private function removeAllTriggers(): void
    {
        $sql = <<<EOT
            SELECT trigger_name 
            FROM information_schema.triggers 
            WHERE trigger_schema = :databaseName
        EOT;

        $stmt = DB::$conn->prepare($sql);
        $stmt->bindValue(':databaseName', $_ENV['DB_NAME']);
        $stmt->execute();

        $triggers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($triggers as $trigger) {
            $this->deleteTheTriggerIfExist($trigger['trigger_name']);
        }
    }

}
