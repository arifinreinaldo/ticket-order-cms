<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MParameter extends Model
{
    use LogsActivity;

    protected $table = 'parameters';
    protected $guarded = ['id'];

    protected static $logAttributes = ['name', 'value'];
    protected static $logName = "parameter";

    public function getImage()
    {
        return ($this->value) ? asset('/storage/' . $this->value) : '/svg/icon.svg';
    }
}
