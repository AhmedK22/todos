<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->created_at->format('Y-m-d') );
        return [
            'id' => $this->id,
            'title' => $this->title,
            'notes' => $this->notes,
            'status' => $this->status,
            'date' =>  $this->created_at->format('Y-m-d') ,
        ];
    }
}
