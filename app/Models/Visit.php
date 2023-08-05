<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visit extends Model
{
    use HasFactory;


    #region Attributes

    #endregion

    #region relations
    public function Member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function loyalty(): HasOne
    {
        return $this->hasOne(Loyalty::class);
    }
    #endregion
}
