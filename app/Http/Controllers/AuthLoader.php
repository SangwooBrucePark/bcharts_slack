<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/8/17
 * Time: 6:24 AM
 */

namespace App\Http\Controllers;

use App;

class AuthLoader
{
    public static function get_token($team_id)
    {
        $team_auth = App\Team::where('team_id', $team_id);
        if ($team_auth->count() != 0) {
            return $team_auth->pluck('access_token')[0];
        }

        return null;
    }
}