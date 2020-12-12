<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MRole extends Model
{
    use LogsActivity;

    protected $table = 'user_role';
    protected $guarded = ['id'];

    protected static $logAttributes = ['role_name', 'status'];
    protected static $logName = "user role";
}
