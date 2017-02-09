<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team as Team;

class AuthorizingController extends Controller
{
    //
    public function auth(Request $request)
    {
        $code = $request->input('code');
        $client_id = env('CLIENT_ID', '');
        $client_secret = env('CLIENT_SECRET', '');

        $req_data = "client_id=" . $client_id . "&client_secret=" . $client_secret . "&code=" . $code;
        $resp_data = Slack::get_request(Slack::OAUTH_ACCESS, $req_data);
        if ($resp_data->ok) {
            $team = Team::where('team_id', '=', $resp_data->team_id);
            if ($team->count() > 0) {
                $team->update([
                    'team_name' => $resp_data->team_name,
                    'access_token' => $resp_data->access_token,
                    'scope' => $resp_data->scope,
                    'bot_user_id' => $resp_data->bot->bot_user_id,
                    'bot_access_token' => $resp_data->bot->bot_access_token,
                    'user_id' => $resp_data->user_id
                ]);
            } else {
                Team::create([
                    'team_id' => $resp_data->team_id,
                    'team_name' => $resp_data->team_name,
                    'access_token' => $resp_data->access_token,
                    'scope' => $resp_data->scope,
                    'bot_user_id' => $resp_data->bot->bot_user_id,
                    'bot_access_token' => $resp_data->bot->bot_access_token,
                    'user_id' => $resp_data->user_id
                ]);
            }

            return view('welcome')->with('team_name', $resp_data->team_name);
        }

        return view('error');
    }
}
