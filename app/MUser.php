<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MUser extends Model
{
    protected $guarded = ['id'];
    protected $table = 'users';
}
