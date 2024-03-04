<?php
/**
 *
 * File: Controller.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 22/1/24
 * Time: 11:00 π.μ.
 *
 * Main controller to handle the requests. Extend this to every controller of your app
 *
 */

namespace apps4net\tasks\controllers;

class Controller
{
    public function __construct()
    {
        $this->checkCORS();
    }

    /**
     * Check if the request is CORS
     *
     * @return void
     */
    private function checkCORS(): void
    {
        // set headers to allow CORS
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * Return an error message
     *
     * @param string $code
     * @param string $message
     * @return void
     */
    protected function returnError(string $code, string $message): void
    {
        header("Content-Type: application/json; charset=UTF-8");

        http_response_code($code);

        echo json_encode([
            "message" => $message
        ]);

        exit();
    }

    /**
     * Return the success data
     *
     * @param array $data
     * @return void
     */
    protected function returnSuccess(array $data): void
    {
        header("Content-Type: application/json; charset=UTF-8");

        http_response_code(200);

        echo json_encode([
            "data" => $data
        ]);

        exit();
    }

    /**
     * Display the selected view page
     *
     * @param string $view
     * @return void
     */
    protected function view(string $view)
    {
        // Set header for HTML
        header("Content-Type: text/html; charset=UTF-8");

        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
