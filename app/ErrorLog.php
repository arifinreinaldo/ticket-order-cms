<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $guarded = ['id'];
    protected $table = 'error_log';
}
