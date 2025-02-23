<?php

namespace Modules\MultiVendor\Repositories;
use Modules\MultiVendor\Entities\SellerCommssionType;

class CommisionRepository
{
    public function getAll()
    {
        return SellerCommssionType::latest()->get();
    }
    public function getAllActive()
    {
        return SellerCommssionType::where('status',1)->get();
    }
    public function findByID($id)
    {
        return SellerCommssionType::findOrFail($id);
    }
    public function findBySlug($id)
    {
        return SellerCommssionType::where('slug',$id)->first();
    }
    public function update($data)
    {
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = strtolower(str_replace(' ','-',$data['name']['en']));
        }else{
            $data['slug'] = strtolower(str_replace(' ','-',$data['name']));
        }

        $setup =  SellerCommssionType::where('id', $data['id'])->first();
        return  $setup->fill($data)->save();
    }
}
