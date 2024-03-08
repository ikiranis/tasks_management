<?php
/**
 *
 * File: Permission.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 8/3/24
 * Time: 6:37 μ.μ.
 *
 */

namespace apps4net\tasks\libraries;

class Permission
{
    private static array $permissions = [
        'index' => [
            'all'
        ],
        'login' => [
            'all'
        ],
        'register' => [
            'all'
        ],
        'tasks' => [
            'login', 1
        ],
        'teams' => [
            'login', 0
        ],
    ];

    public static function getPermissionFor(string $action): bool
    {
        if(!array_key_exists($action, self::$permissions)) {
            return true;
        }

        $permissionsForAction = self::$permissions[$action];

        if (in_array('all', $permissionsForAction)) {
            return true;
        }


        // If permissions has "login" and the user is not logged in, return false
        if (in_array('login', $permissionsForAction) && !isset($_SESSION['username'])) {
            return false;
        }

        if (in_array('login', $permissionsForAction)) {
            $permissionRole = $permissionsForAction[1];

            if ($_SESSION['role'] > $permissionRole) {
                return false;
            }

            return true;
        }

        return false;
    }
}
