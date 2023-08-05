<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'last_visit_date' => $this->last_visit_date,
            'max_receipt'     => $this->max_receipt,
            'total_receipt'   => $this->total_receipt,
            'total_points'    => $this->total_points,
            'visits'          => VisitResource::collection($this->whenLoaded('visits')),
            'created_at'      => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
