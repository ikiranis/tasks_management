<?php
/**
 *
 * File: EnvVariables.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 23/1/24
 * Time: 10:19 π.μ.
 *
 * Get the environment variables from Joomla configuration.php file
 *
 */

namespace apps4net\syncDB\services;

class EnvVariables
{

    /**
     * Set the environment variables
     * from the Joomla configuration.php file
     *
     * @return void
     */
    public function set(): void
    {
        require_once '../configuration.php';
        $joomlaConfig = new \JConfig();

        $_ENV['DB_HOST'] = $joomlaConfig->host;
        $_ENV['DB_NAME'] = $joomlaConfig->db;
        $_ENV['DB_USER'] = $joomlaConfig->user;
        $_ENV['DB_PASS'] = $joomlaConfig->password;
    }
}
