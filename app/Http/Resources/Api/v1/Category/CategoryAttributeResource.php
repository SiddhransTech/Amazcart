<?php

namespace App\Http\Resources\Api\v1\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $names = json_decode($this->name, true);
        if(json_last_error() === JSON_ERROR_NONE){
          foreach ( $names as $nm) {
                    $name = $nm;
            }  
            
        }else{
            $name = $this->name;
        }
        
       
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
            
        
    }
}
