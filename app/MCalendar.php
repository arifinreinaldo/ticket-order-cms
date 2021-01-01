<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MCalendar extends Model
{
    use  LogsActivity;

    protected $table = 'events';
    protected static $logAttributes = ['event_title', 'event_cover_image', 'event_banner_image', 'event_content'];
    protected static $logName = 'event';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
