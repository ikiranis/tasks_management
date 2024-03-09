<?php
/**
 *
 * File: App.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 5/3/24
 * Time: 6:48 μ.μ.
 *
 */

namespace apps4net\tasks\libraries;

class App
{

    /**
     * Get the current page to display
     *
     * @return string
     */
    public static function getCurrentPage(): string
    {
        // Get the page to display
        $page = ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Empty page means index
        if($page === '') {
            $page = 'index';
        }

        return $page;
    }

}
