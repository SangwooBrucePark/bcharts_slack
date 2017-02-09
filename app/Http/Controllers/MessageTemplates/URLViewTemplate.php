<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/8/17
 * Time: 9:28 PM
 */

namespace App\Http\Controllers\MessageTemplates;


class URLViewTemplate
{
    public static function get_template($access_token, $channel_id, $title, $user_id, $user_name, $chart_url, $ts)
    {
        $req_header = 'token=' . $access_token . '&channel=' . $channel_id . '&as_user=false&username=flyingbee&icon_url=https://slack.bcharts.xyz/fullbeelogo-512x512.png&attachments=';
        //$req_header = 'token=' . $access_token . '&channel=' . $channel_id . '&as_user=false&attachments=';

        $req_attachment = array(
            array(
                'fallback' => '<@' . $user_id . '|' . $user_name . '> posted a new chart~!!',
                'color' => '#2196F3',
                'title' => $title,
                'text' => 'Posted by <@' . $user_id . '|' . $user_name . '>. `<!date^' . $ts . '^Last updated at {time} {date_short}|aaa>`',
                'image_url' => $chart_url,
                'footer' => 'Powered by bCharts',
                'footer_icon' => 'https://slack.bcharts.xyz/fullbeelogo-512x512.png',
                'thumb_url' => 'https://slack.bcharts.xyz/fullbeelogo-512x512.png',
                'ts' => $ts,
                'mrkdwn_in' => ['text', 'fields'],
            ),
            array(
                'fallback' => 'Please, select update cycle.',
                'text' => 'Please, select update cycle.',
                'callback_id' => 'update_cycle',
                'color' => '#8AC7F9',
                'attachment_type' => 'default',
                'actions' => array(
                    array(
                        'name' => 'selected_cycle',
                        'text' => 'Off',
                        'value' => '0',
                        'type' => 'button',
                        'style' => 'primary'
                    ),
                    array(
                        'name' => 'selected_cycle',
                        'text' => '30m',
                        'value' => '30',
                        'type' => 'button'
                    ),
                    array(
                        'name' => 'selected_cycle',
                        'text' => '1h',
                        'value' => '60',
                        'type' => 'button'
                    ),
                    array(
                        'name' => 'selected_cycle',
                        'text' => '2h',
                        'value' => '120',
                        'type' => 'button'
                    ),
                    array(
                        'name' => 'once_update',
                        'text' => 'Once',
                        'value' => 'update',
                        'type' => 'button',
                        'style' => 'danger'
                    )
                )
            )
        );

        return $req_header . urlencode(json_encode($req_attachment));
    }
}