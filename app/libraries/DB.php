<?php
/**
 *
 * File: DBConnect.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 19/1/24
 * Time: 10:29 π.μ.
 *
 * Connect to the DB and get the connection
 *
 */

namespace apps4net\tasks\libraries;

use http\Env;

class DB
{
    public static ?\PDO $conn = null;

    /**
     * Make the DB connection
     *
     * @return void
     */
    public static function connect(): void
    {
        if (self::$conn !== null) {
            return;
        }

        try {
            $conn = new \PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            self::$conn = $conn;
        } catch (\PDOException $e) {
            throw new \PDOException("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Close the DB connection
     *
     * @return void
     */
    public static function close(): void
    {
        self::$conn = null;
    }
}
