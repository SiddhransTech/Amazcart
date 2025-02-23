<?php
namespace Modules\Product\Repositories;

use Modules\Product\Entities\ProductReport;
use Modules\Product\Entities\ProductReportReason;

class ReportReasonRepository {

    protected $reason;

    public function __construct(ProductReportReason $productReportReason){
        $this->reason = $productReportReason;
    }

    public function get()
    {
        return $this->reason->get();
    }

    public function store($data)
    {
        $reason = new ProductReportReason();
        if(isModuleActive('FrontendMultiLang')){
            return $reason->fill($data)->save();
        }else{
            $reason->setTranslation('name','en',$data['name']);
            $reason->status = $data['status'];
            return $reason->save();
        }

    }

    public function show($data){
        return $this->reason->where($data)->first();
    }

    public function update($data, $id){

        $reason =  $this->reason->where('id',$id)->first();
        if(isModuleActive('FrontendMultiLang')){
            return $reason->fill($data)->save();
        }else{
            $reason->setTranslation('name','en',$data['name']);
            $reason->status = $data['status'];
            return $reason->save();
        }

    }

    public function delete($data){
        $reason =  $this->reason->where($data)->first();
        return   $reason->delete();
    }

}
