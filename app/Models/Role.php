<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends RoleModel
{
    use SoftDeletes;

    public $guarded = [];
}
