<?php

namespace App\Models;

use App\Models\Cashier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visit extends Model
{
    use HasFactory;


    protected $with = ['member:id,first_name,last_name', 'loyalty', 'cashier:id,name'];

    public static function orderByPoints($order = 'desc')
    {
        return self::join('loyalties', 'visit_id', '=', 'visits.id')
            ->orderBy('loyalties.points', $order)
            ->select('visits.*');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['member'] ?? false, fn($query, $member) =>
            $query->where(fn($query) =>
                $query->whereHas('member', fn ($query) =>
                    $query
                        ->where('first_name', 'like', '%' . $member . '%')
                        ->orWhere('phone', 'like', '%' . $member . '%')
                        ->orWhere('last_name', 'like', '%' . $member . '%')
                        ->orWhere('phone', 'like', '%' . $member . '%')
                )
            )
        );

        $query->when($filters['cashier'] ?? false, fn($query, $cashier) =>
            $query->where(fn($query) =>
                $query->whereHas('cashier', fn ($query) =>
                    $query->where('name', 'like', '%' . $cashier . '%')
                )
            )
        );

        $query->when($filters['receipt'] ?? false, fn($query, $receipt) =>
            $query->where('receipt', '=', $receipt)   
        );
    }

    #region relations
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function loyalty(): HasOne
    {
        return $this->hasOne(Loyalty::class)->orderBy('points', 'asc');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }
    #endregion
}
