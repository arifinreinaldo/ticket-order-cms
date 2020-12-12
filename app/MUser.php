<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MUser extends Model
{
    use  LogsActivity;

    protected $guarded = ['id'];
    protected $table = 'users';
    protected static $logAttributes = ['name', 'email', 'password', 'status', 'role', 'username'];
    protected static $logName = "user admin";
    protected static $logOnlyDirty = true;
}
