<?php

namespace Modules\FrontendCMS\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PricingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'name.'. $code => "required",

                'status' =>'required',
                "expire_in" => "required",
                "plan_price" =>"required",
            ];
        }else{
            return [
                'name' => 'required',
                'status' =>'required',
                "plan_price" =>"required",

            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The name field is required',
                'name.*.unique_translation' => 'The name field has already been taken',
            ];
        }else{
            return [
                'name.required' => 'The name field is required',
                'name.unique' => 'The name field has already been taken',
            ];
        }
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
