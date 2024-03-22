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
 * Basic application class with utility methods
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
     * Display the selected component
     *
     * @param string $component
     * @param array $data
     * @return void
     */
    public static function component(string $component, array $data = []): void
    {
        // Extract the data to variables and pass them to the component
        extract($data);

        include(__DIR__ . '/../components/' . $component . '.php');
    }

    /**
     * Get the HTML of the selected component
     *
     * @param string $component
     * @param array $data
     * @return string
     */
    public static function componentHTML(string $component, array $data = []): string
    {
        // Extract the data to variables and pass them to the component
        extract($data);

        // Start output buffering
        ob_start();

        // Include the component file
        include(__DIR__ . '/../components/' . $component . '.php');

        // Get the contents of the output buffer and clean it.
        return ob_get_clean();
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

    /**
     * Add the selected script to page
     *
     * @param string $script
     * @return void
     */
    public static function script(string $script): void
    {
        echo "<script src=" . "app/js/" . $script . ".js></script>";
    }

    /**
     * Get the subdirectory of the app, to use it in the URLs, if project is in subdirectory
     *
     * @return string
     */
    public static function getSubdir(): string
    {
        return str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['PHP_SELF']));
    }
}
