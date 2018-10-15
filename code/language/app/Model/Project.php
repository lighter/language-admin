<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }
}
