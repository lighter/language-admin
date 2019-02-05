<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'user_id', 'lang_key', 'lang',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
