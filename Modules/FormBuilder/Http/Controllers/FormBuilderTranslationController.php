<?php

namespace Modules\FormBuilder\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Support\Renderable;

class FormBuilderTranslationController extends Controller
{
    public function translation()
    {
        try{
            return view('formbuilder::form.translation');
        }catch(Exception $e){
            Toastr::error(trans('common.something_went_wrong'),trans('common.error'));
            return back();
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "language" => "required|string",
            "key" => "required|string",
            "value" => "required|string"
        ]);

        try{
            if($data['language'] == 'en')
            {
                $langeCode = 'default';
            }else{
                $langeCode = $data['language'];
            }
            $language_file = base_path('resources/lang/'.$langeCode.'/formBuilder.php');
            if(!file_exists($language_file))
            {
                mkdir(base_path($language_file));
            }
            $keys =  Lang::get('formBuilder', [],  $langeCode);
            $keys[$data['key']] = $data['value'];
            $array_keys = array_keys($keys);
            $str = "<?php \n return [ \n";
            foreach($array_keys as $ak)
            {
                $str.= "'{$ak}' => '{$keys[$ak]} ', \n";
            }

            $str.='];';
            file_put_contents($language_file, $str);
            Toastr::success(trans('operation_successful'),trans('common.success'));
            return back();
        }catch(Exception $e){
            Toastr::error(trans('common.something_went_wrong'),trans('common.error'));
            return back();
        }

    }
}
