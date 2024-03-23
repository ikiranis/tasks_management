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

    /**
     * Get the permission for the action
     *
     * @param string $action
     * @return bool
     */
    public static function getPermissionFor(string $action): bool
    {
        // If the action is not in the permissions array, return true
        if(!array_key_exists($action, self::$permissions)) {
            return true;
        }

        // Get the permissions for the action
        $permissionsForAction = self::$permissions[$action];

        // If permissions has "all", return true
        if (in_array('all', $permissionsForAction)) {
            return true;
        }

        // If permissions has "login" and the user is not logged in, return false
        if (in_array('login', $permissionsForAction) && !isset($_SESSION['username'])) {
            return false;
        }

        // If permissions has "login" and the user is logged in, check the role
        if (in_array('login', $permissionsForAction)) {
            $permissionRole = $permissionsForAction[1];

            // If the user's role is less than the permission role, return false
            if ($_SESSION['role'] > $permissionRole) {
                return false;
            }

            return true;
        }

        return false;
    }
}
