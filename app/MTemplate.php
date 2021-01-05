<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MTemplate extends Model
{
    use  LogsActivity;

    protected $table = 'template_emails';
    protected static $logAttributes = ['title', 'head', 'body', 'footer'];
    protected static $logName = 'template email';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
