<?php

namespace Modules\AoraPageBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomPageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|unique:dynamic_pages,title,'.$this->id,
            'slug'=>'required|unique:dynamic_pages,slug,'.$this->id,
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
