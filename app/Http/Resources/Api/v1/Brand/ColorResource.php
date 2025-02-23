<?php

namespace App\Http\Resources\Api\v1\Brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
     $resource = $this->name ?? null;
       if(!empty($resource)){
            $nn = json_decode($this->name);
            if(json_last_error() === 0){
                 foreach($nn as $nam){
                    $name = $nam;
                }
            }else{
                $name = $this->name;
            }
           
        }


        if(!empty($name)){
            return [
                "id" => $this->id,
                "name" => $name,
                "display_type" => $this->display_type,
                "description" => $this->description,
                "status" => $this->status,
                "created_by" => $this->created_by,
                "updated_by" => $this->updated_by,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
                "values" => $this->values,
            ];

        }else{
            return [

            ];
        }

    }
}
