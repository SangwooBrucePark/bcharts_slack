<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['ts', 'channel', 'user_id', 'message', 'update_cycle', 'chart_updated_at', 'created_at', 'updated_at'];
}
