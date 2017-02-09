<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/9/17
 * Time: 4:22 AM
 */

namespace App\Http\Controllers\MessageTemplates;


class NoAuthToUpdateCycle
{
    public static function get_template($access_token, $channel_id, $user_id, $user_name)
    {
        // $req_header = 'token=' . $access_token . '&channel=' . $channel_id . '&as_user=false&username=flyingbee&icon_url=https://slack.bcharts.xyz/fullbeelogo-512x512.png&attachments=';

        $req_data = 'token=' . $access_token . '&channel=' . $channel_id . '&text=' . urlencode('Sorry <@' . $user_id . '|' . $user_name . '>. You may not have an authority to reset update cycle.');

        $req_attachment = array(
            'response_type' => 'ephemeral',
            'replace_original' => false,
            'delete_original' => false,
            'text' => 'Sorry <@' . $user_id . '|' . $user_name . '>. You may not have an authority to reset update cycle.'
        );

        return $req_attachment;
    }

}