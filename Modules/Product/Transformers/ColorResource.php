<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $values = null;
        if(!empty($this->resource) && !empty($this->values))
        {
            foreach($this->values as $attrVal)
            {
                $values[] = [
                        "id" => $attrVal->id,
                        "value" => $attrVal->value,
                        "attribute_id" => $attrVal->attribute_id,
                        "created_at" => $attrVal->created_at ,
                        "updated_at" => $attrVal->updated_at,
                 ];

            }

        }
         if(!empty($this->resource)){
              return [
                  "id" => $this->id,
                  "name" => $this->name,
                  "display_type" => $this->display_type,
                  "description" => $this->description,
                  "status" => $this->status,
                  "created_by" => $this->created_by,
                  "updated_by" => $this->updated_by,
                  "created_at" => $this->created_at,
                  "updated_at" => $this->updated_at,
                  "values" => $values

                ];
         }else{
             return [];
         }

    }
}
