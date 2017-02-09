<?php

namespace App\Http\Controllers\InteractionCallbacks;

use App\Message;
use App\Http\Controllers\Slack;
use App\Http\Controllers\AuthLoader;
use App\Http\Controllers\MessageTemplates\NoAuthToUpdateCycle;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/9/17
 * Time: 10:28 AM
 */
class UpdateCycle
{
    var $token = null; //
    var $original_ts = null; //
    var $original_channel = null; //
    var $original_attachments = null; //
    var $response_url = null;
    var $req_user_id = null;
    var $req_user_name = null;
    var $action_value = null;

    public function __construct($payload)
    {
        $this->action_name = $payload->actions[0]->name;
        $this->action_value = $payload->actions[0]->value;

        $original_message = $payload->original_message;
        $this->token = AuthLoader::get_token($payload->team->id);
        $this->original_ts = $original_message->ts;
        $this->original_channel = $payload->channel->id;

        $this->original_attachments = $original_message->attachments;

        $this->response_url = $payload->response_url;

        $this->req_user_id = $payload->user->id;
        $this->req_user_name = $payload->user->name;
    }

    public function apply()
    {
        $original_actions = $this->original_attachments[1]->actions; // actions of original message
        $original_text = $this->original_attachments[0]->text;

        $original_record = Message::where('ts', $this->original_ts)->first(['user_id', 'update_cycle']);

        switch ($this->action_name) {
            case 'once_update':
                $this->original_attachments[0]->text = preg_replace('/<!date\^\d+\^/', '<!date^' . (string)time() . '^', $original_text);
                $this->original_attachments[0]->image_url .= '?time=' . (string)time();
                $this->update_message($original_record->update_cycle);
                break;
            case 'selected_cycle':
                if ($original_record->user_id !== $this->req_user_id) {
                    $req_data = NoAuthToUpdateCycle::get_template($this->token, $this->original_channel, $this->req_user_id, $this->req_user_name);
                    $response = Slack::json_request($this->response_url, $req_data);
                } else {
                    foreach ($original_actions as $action) {
                        if ($action->name === 'selected_cycle') {
                            if ($action->value === $this->action_value) {
                                $action->style = 'primary';
                            } else {
                                $action->style = 'default';
                            }
                        }
                    }

                    $this->update_message($this->action_value);
                }
                break;
        }
    }

    private function update_message($update_cycle)
    {
        $attachments_urlencoded = urlencode(json_encode($this->original_attachments));
        $req_data = 'token=' . $this->token . '&ts=' . $this->original_ts . '&channel=' . $this->original_channel . '&attachments=' . $attachments_urlencoded;

        $response = Slack::get_request(Slack::UPDATE_MESSAGE, $req_data);

        if ($response->ok) {
            Message::where('ts', $this->original_ts)->update([
                    'message' => $req_data,
                    'update_cycle' => $update_cycle,
                ]
            );
        }
    }
}