<?php
/**
 *
 * File: Route.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 19/1/24
 * Time: 12:50 μ.μ.
 *
 * Handles the routes
 *
 * Example to add a route:
 *
 * Route::get('/', [SyncController::class, 'index']);
 * Route::run();
 *
 * This works too
 *
 * Route::get('/', [new SyncController(), 'index']);
 *
 */

namespace apps4net\syncDB\libraries;

class Route
{
    private static array $routes = [];
    private string $route;
    private array $controllerAction;

    /**
     * Get a GET route
     *
     * @param String $route
     * @param array $controllerAction
     * @return void
     */
    public static function get(string $route, array $controllerAction): void
    {
        $instance = new self();

        $instance->route = $route;
        $instance->controllerAction = $controllerAction;
        $instance->addRoute('GET');
    }

    /**
     * Get a POST route
     *
     * @param string $route
     * @param array $controllerAction
     * @return void
     */
    public static function post(string $route, array $controllerAction): void
    {
        $instance = new self();

        $instance->route = $route;
        $instance->controllerAction = $controllerAction;
        $instance->addRoute('POST');
    }

    /**
     * Add a new route
     *
     * @param string $method
     * @return void
     */
    private function addRoute(string $method): void
    {
        if (count($this->controllerAction) === 2) {
            $controller = $this->controllerAction[0];
            $action = $this->controllerAction[1];

            if (is_string($controller)) {
                $controller = new $controller();

                $this->controllerAction = [new $controller, $action];
            }

            if (is_object($controller) && method_exists($controller, $action)) {
                self::$routes[$this->route] = [$this->controllerAction, $method];
            } else {
                throw new \InvalidArgumentException('Controller action is not callable');
            }
        } else {
            throw new \InvalidArgumentException('Controller action must be an array with 2 elements');
        }
    }

    /**
     * @return void
     */
    public static function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $currentRootDir = dirname($_SERVER['PHP_SELF']);

        // Remove the root directory from the path
        $path = substr($path, strlen($currentRootDir));
        $callback = self::$routes[$path];

        if ($callback && is_array($callback)) {
            $controller = $callback[0][0];
            $action = $callback[0][1];
            $method = $callback[1];

            if ($_SERVER['REQUEST_METHOD'] == $method && method_exists($controller, $action)) {
                $controller->$action();
            } else {
                if ($_SERVER['REQUEST_METHOD'] !== $method) {
                    $message = "HTTP Method " . $method . " Not Allowed";
                } else {
                    $message = "Controller method " . $action . " Not Found";
                }

                http_response_code(405);
                echo json_encode([
                    "message" => $message
                ]);
            }
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => "Controller Not found"
            ]);
        }
    }

}
