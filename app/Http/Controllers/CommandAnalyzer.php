<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MessageTemplates\URLViewTemplate;
use App;

class CommandAnalyzer extends Controller
{
    //
    public function bcharts(Request $request)
    {
        $team_id = $request->input('team_id');
        $access_token = AuthLoader::get_token($team_id);
        if ($access_token == null) {
            echo 'Error!!! I guess your team hasn\'t joined this app yet.';
            return;
        }

        $channel_id = $request->input('channel_id');
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');

        $subcommand = $request->input('text');

        $thread_ts = time();

        $req_data = URLViewTemplate::get_template(
            $access_token,
            $channel_id,
            'This is a title part.',
            $user_id,
            $user_name,
            'https://brucepark.hopto.org/b.png',
            $thread_ts);

        $response = Slack::post_request(Slack::POST_MESSAGE, $req_data);

        if ($response->ok) {
            $message = new App\Message;
            $message->ts = $response->ts;
            $message->channel = $response->channel;
            $message->user_id = $user_id;
            $message->message = $req_data;
            $message->update_cycle = 0;
            $message->chart_updated_at = \Carbon\Carbon::now();
            $message->save();
        }
    }
}
