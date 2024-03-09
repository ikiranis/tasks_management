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
     * Display the selected view page
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function view(string $view, array $data = []): void
    {
        // Set header for HTML
        header("Content-Type: text/html; charset=UTF-8");

        // Extract the data to variables and pass them to the view
        extract($data);

        require_once __DIR__ . '/../views/' . $view . '.php';
    }

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
