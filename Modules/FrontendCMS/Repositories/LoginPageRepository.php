<?php
namespace Modules\FrontendCMS\Repositories;

use App\Traits\ImageStore;
use \Modules\FrontendCMS\Entities\AboutUs;
use Modules\FrontendCMS\Entities\LoginPage;

class LoginPageRepository {
    use ImageStore;
    public function loginPageUpdate($data)
    {

        $loginPage = LoginPage::where('login_slug',$data['login_slug'])->first();

        if(isModuleActive('FrontendMultiLang')){
            if($loginPage){
                if (isset($data['cover_image'])) {
                    $filename = $this->saveImage($data['cover_image']);
                }else{
                    $filename = $loginPage->cover_img;
                }
                $loginPage->update([
                    'title' => $data['title'],
                    'sub_title' => $data['sub_title'],
                    'cover_img' => $filename,
                    "success_url" => isset($data['success_url']) ? $data['success_url']:''
                ]);
                return true;
            }

        }else{
            if($loginPage){
                if (isset($data['cover_image'])) {
                    $filename = $this->saveImage($data['cover_image']);
                }else{
                    $filename = $loginPage->cover_img;
                }
                $loginPage->setTranslation('title','en',$data['title']);
                $loginPage->setTranslation('sub_title','en',$data['sub_title']);
                $loginPage->cover_img = $filename;
                $loginPage->success_url = isset($data['success_url']) ? $data['success_url']:'';
                $loginPage->save();
                return true;
            }
        }




        return false;
    }

}
