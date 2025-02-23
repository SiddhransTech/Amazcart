<?php

namespace Modules\FrontendCMS\Repositories;
use App\Traits\ImageStore;
use Modules\FrontendCMS\Entities\Pricing;

class PricingRepository {

    protected $pricing;
    public function __construct(Pricing $pricing){
        $this->pricing = $pricing;
    }
    public function getAll()
    {
        return $this->pricing::all();
    }
    public function getAllActive()
    {
        return $this->pricing::where('status',1)->get();
    }
    public function save($data)
    {
        $image = null;
        if (!empty($data['image'])) {
            $image = ImageStore::saveImage($data['image'], 165, 165);
        }
        if(isModuleActive('FrontendMultiLang')){
            $pricing = Pricing::create([
                'name' => $data['name'],
                'plan_price' => $data['plan_price'],
                'monthly_cost' => isset($data['monthly_cost'])?$data['monthly_cost']:$data['plan_price'],
                'yearly_cost' => isset($data['yearly_cost'])?$data['yearly_cost']:$data['plan_price'],
                'team_size' => $data['team_size'],
                'stock_limit' => $data['stock_limit'],
                'category_limit' => $data['category_limit'],
                'transaction_fee' => $data['transaction_fee'],
                'best_for' => $data['best_for'],
                'status' => $data['status'],
                'image' => $image,
                'expire_in' => $data['expire_in'],
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'gst_tax_id' => isset($data['gst_id']) ? $data['gst_id']:null,
                'discount_type' => isset($data['discount_type']) ? $data['discount_type']:null,
                'discount' => isset($data['discount']) ? $data['discount']:null,
            ]);

        }else{
            $pricing = new Pricing();
            $pricing->setTranslation('name','en',$data['name']);
            $pricing->plan_price = $data['plan_price'];
            $pricing->monthly_cost = isset($data['monthly_cost'])?$data['monthly_cost']:$data['plan_price'];
            $pricing->yearly_cost = isset($data['yearly_cost'])?$data['yearly_cost']:$data['plan_price'];
            $pricing->team_size = $data['team_size'];
            $pricing->stock_limit = $data['stock_limit'];
            $pricing->category_limit = $data['category_limit'];
            $pricing->transaction_fee = $data['transaction_fee'];
            $pricing->best_for = $data['best_for'];
            $pricing->status = $data['status'];
            $pricing->image = $image;
            $pricing->expire_in = $data['expire_in'];
            $pricing->is_featured =  isset($data['is_featured']) ? 1 : 0;
            $pricing->gst_tax_id = isset($data['gst_id']) ? $data['gst_id']:null;
            $pricing->discount_type = isset($data['discount_type']) ? $data['discount_type']:null;
            $pricing->discount =  isset($data['discount']) ? $data['discount']:null;
            $pricing->save();
        }

        return $pricing;
    }
    public function update($data)
    {
        $image = isset($data['old_image']) ? $data['old_image']:'';
        if (!empty($data['image'])) {
            $image = ImageStore::saveImage($data['image'], 165, 165);
        }

        if(isModuleActive('FrontendMultiLang')){
            return $this->pricing::where('id',$data['id'])->update([
                'name' => $data['name'],
                'plan_price' => $data['plan_price'],
                'monthly_cost' => isset($data['monthly_cost'])?$data['monthly_cost']:$data['plan_price'],
                'yearly_cost' => isset($data['yearly_cost'])?$data['yearly_cost']:$data['plan_price'],
                'team_size' => $data['team_size'],
                'stock_limit' => $data['stock_limit'],
                'category_limit' => $data['category_limit'],
                'transaction_fee' => $data['transaction_fee'],
                'best_for' => $data['best_for'],
                'status' => $data['status'],
                'image' => $image,
                'expire_in' => $data['expire_in'],
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'gst_tax_id' => isset($data['gst_id']) ? $data['gst_id']:null,
                'discount_type' => isset($data['discount_type']) ? $data['discount_type']:null,
                'discount' => isset($data['discount']) ? $data['discount']:null,
            ]);

        }else{
            $pricing = Pricing::where('id',$data['id'])->first();
            $pricing->setTranslation('name','en',$data['name']);
            $pricing->plan_price = $data['plan_price'];
            $pricing->monthly_cost = isset($data['monthly_cost'])?$data['monthly_cost']:$data['plan_price'];
            $pricing->yearly_cost = isset($data['yearly_cost'])?$data['yearly_cost']:$data['plan_price'];
            $pricing->team_size = $data['team_size'];
            $pricing->stock_limit = $data['stock_limit'];
            $pricing->category_limit = $data['category_limit'];
            $pricing->transaction_fee = $data['transaction_fee'];
            $pricing->best_for = $data['best_for'];
            $pricing->status = $data['status'];
            $pricing->image = $image;
            $pricing->expire_in = $data['expire_in'];
            $pricing->is_featured =  isset($data['is_featured']) ? 1 : 0;
            $pricing->gst_tax_id = isset($data['gst_id']) ? $data['gst_id']:null;
            $pricing->discount_type = isset($data['discount_type']) ? $data['discount_type']:null;
            $pricing->discount =  isset($data['discount']) ? $data['discount']:null;
            $pricing->save();
            return $pricing;

        }

    }
    public function delete($id){
        $pricing = $this->pricing->findOrFail($id);
        $pricing->delete();
        return $pricing;
    }
    public function show($id){
        $pricing = $this->pricing->findOrFail($id);
        return $pricing;
    }
    public function edit($id){
        $pricing = $this->pricing->findOrFail($id);
        return $pricing;
    }
    public function statusUpdate($data, $id){
        return $this->pricing::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }
}
