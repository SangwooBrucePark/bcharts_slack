<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/7/17
 * Time: 9:42 PM
 */

namespace App\Http\Controllers;


class Slack
{
    const OAUTH_ACCESS = 'https://slack.com/api/oauth.access';
    const POST_MESSAGE = 'https://slack.com/api/chat.postMessage';
    const UPDATE_MESSAGE = 'https://slack.com/api/chat.update';
    const ME_MESSAGE = 'https://slack.com/api/chat.meMessage';

    public static function get_request($response_url, $req_data)
    {
        $slack = curl_init($response_url);
        curl_setopt($slack, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($slack, CURLOPT_POSTFIELDS, $req_data);
        curl_setopt($slack, CURLOPT_CRLF, true);
        curl_setopt($slack, CURLOPT_RETURNTRANSFER, true);

        $resp_data = curl_exec($slack);
        curl_close($slack);

        return json_decode($resp_data);
    }

    public static function post_request($response_url, $req_data)
    {
        $slack = curl_init($response_url);
        curl_setopt($slack, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($slack, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($slack, CURLOPT_POSTFIELDS, $req_data);
        curl_setopt($slack, CURLOPT_CRLF, true);
        curl_setopt($slack, CURLOPT_RETURNTRANSFER, true);

        $resp_data = curl_exec($slack);
        curl_close($slack);

        return json_decode($resp_data);
    }

    public static function json_request($response_url, $json_data)
    {
        $json_string = json_encode($json_data);

        $slack = curl_init($response_url);
        curl_setopt($slack, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($slack, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($slack, CURLOPT_POSTFIELDS, $json_string);
        curl_setopt($slack, CURLOPT_CRLF, true);
        curl_setopt($slack, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($slack, CURLOPT_HTTPHEADER, array(
                "Content-Type" => "application/json",
                "Content-Length" => strlen($json_string)
            )
        );

        $resp_data = curl_exec($slack);
        curl_close($slack);

        return json_decode($resp_data);
    }
}