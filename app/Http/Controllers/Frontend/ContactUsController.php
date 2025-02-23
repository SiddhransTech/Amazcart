<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use \Modules\FrontendCMS\Services\QueryService;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\FrontendCMS\Entities\SellerSocialLink;
use \Modules\FrontendCMS\Services\ContactContentService;
use Modules\FormBuilder\Repositories\FormBuilderRepositories;

class ContactUsController extends Controller
{

    protected $contactContentService;
    protected $queryService;

    public function __construct(ContactContentService $contactContentService, QueryService $queryService)
    {
        $this->contactContentService = $contactContentService;
        $this->queryService = $queryService;
        $this->middleware('maintenance_mode');
    }

    public function index(){
        try{
            $contactContent = $this->contactContentService->getAll();
            $QueryList = $this->queryService->getAllActive();
            $row = '';
            $form_data = '';
            if(Module::has('FormBuilder')){
                if(Schema::hasTable('custom_forms')){
                    $formBuilderRepo = new FormBuilderRepositories();
                    $row = $formBuilderRepo->find(4);
                    if($row->form_data){
                        $form_data = json_decode($row->form_data);
                    }
                }
            }
            $socials = SellerSocialLink::where('user_id',1)->where('status',1)->get();
            return view(theme('pages.contact_us'),compact('contactContent','QueryList','row','form_data','socials'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
