<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class InviteUser
 *
 * @package App\Model
 */
class InviteUser extends Model
{
    protected $table = 'invite_user';

    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
