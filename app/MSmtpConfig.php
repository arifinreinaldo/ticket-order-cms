<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MSmtpConfig extends Model
{
    use  LogsActivity;

    protected $table = 'smtp_configs';
    protected static $logAttributes = ['smtp_username', 'smtp_password', 'smtp_host', 'smtp_sender'];
    protected static $logName = 'smtp_config';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
