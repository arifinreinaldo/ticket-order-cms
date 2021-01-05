<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MStatic extends Model
{
    use  LogsActivity;

    protected $table = 'static_pages';
    protected static $logAttributes = ['content'];
    protected static $logName = 'static pages';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
