<?php

namespace Modules\AoraPageBuilder\Repositories;


use Illuminate\Support\Str;
use Modules\FrontendCMS\Entities\DynamicPage;

class PageBuilderRepository
{
    public function all()
    {
        return DynamicPage::where('is_page_builder',1)->get();
    }

    public function create(array $data)
    {

        if(isModuleActive('FrontendMultiLang'))
        {
            return DynamicPage::create([
                'title' =>$data['title'],
                'slug'  =>Str::slug($data['slug'], '-'),
                'status' => 1,
                'is_static' => 0,
                'is_page_builder' =>1
            ]);
        }else{
            $page = new DynamicPage();
            $page->setTranslation('title','en',$data['title']);
            $page->slug = Str::slug($data['slug'], '-');
            $page->status = 1;
            $page->is_static = 0;
            $page->is_page_builder = 1;
            $page->save();
            return $page;
        }

    }

    public function find($id)
    {
        return DynamicPage::findOrFail($id);
    }

    public function designUpdate(array $data,$id)
    {

        $page = DynamicPage::where('id',$id)->first();

        if(isset($data['lang']) && !empty($data['lang'])){
            return $page->setTranslation('description',$data['lang'],$data['body'])->save();
        }else{
            return $page->setTranslation('description','en',$data['body'])->save();
        }


    }

    public function update(array $data,$id)
    {
        if(isModuleActive('FrontendMultiLang'))
        {
            return DynamicPage::where('id', $id)->update([
                'title' =>$data['title'],
                'slug'  =>Str::slug($data['slug'], '-'),
            ]);
        }else{
            $page = DynamicPage::where('id',$id)->first();
            $page->setTranslation('title','en',$data['title']);
            $page->slug = Str::slug($data['slug'], '-');
            $page->save();
        }

    }

    public function delete($id){
        return DynamicPage::findOrFail($id)->delete();
    }
    public function status($data){
        return DynamicPage::findOrFail($data['id'])->update(['status' => $data['status']]);
    }

}
