<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MRole extends Model
{
    protected $table = 'user_role';
    protected $guarded = ['id'];
}
