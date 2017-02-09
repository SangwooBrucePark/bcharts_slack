<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = ['team_id', 'team_name', 'access_token', 'scope', 'bot_user_id', 'bot_access_token', 'user_id', 'created_at', 'updated_at'];
}
