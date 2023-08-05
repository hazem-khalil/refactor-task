<?php

namespace App\Http\Resources;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Visit
 */
class VisitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'receipt'    => $this->receipt,
            'loyalty'    => LoyaltyResource::make($this->loyalty),
            'member'     => MemberResource::make($this->member),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
