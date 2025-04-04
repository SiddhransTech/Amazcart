<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxDesignResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dimensions' => [
                'breadth' => $this->breadth,
                'length' => $this->length,
                'height' => $this->height,
                'thickness' => $this->thickness,
            ],
            'flute_freq' => $this->flute_freq,
            'model_url' => $this->model_url,
            'image_url' => $this->image_url,
            'faces' => $this->faces,
            'volume' => $this->volume,
            'surface_area' => $this->surface_area,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}