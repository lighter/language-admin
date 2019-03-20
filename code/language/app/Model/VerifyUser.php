<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VerifyUser
 *
 * @package App\Model
 */
class VerifyUser extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
