<?php
namespace Modules\FrontendCMS\Repositories;
use Modules\FrontendCMS\Entities\InQuery;

class QueryRepository {
    public function getAll()
    {
        return InQuery::all();
    }
    public function getAllActive()
    {
        return InQuery::where('status',1)->get();
    }
    public function save($data)
    {
        $inquery = new InQuery();
        if(isModuleActive('FrontendMultiLang')){
            $inquery->fill($data)->save();
        }else{
            $inquery->setTranslation('name','en',$data['name']);
            $inquery->user_id = auth()->id();
            $inquery->status = isset($data['status']) ? $data['status']:0;
            $inquery->save();
        }

        return $inquery;
    }
    public function update($data, $id)
    {
        $inquery = InQuery::find($id);
        if(isModuleActive('FrontendMultiLang')){
            $inquery->fill($data)->save();
        }else{
            $inquery->setTranslation('name','en',$data['name']);
            $inquery->status = isset($data['status']) ? $data['status']:0;
            $inquery->save();
        }
        return $inquery;
    }
    public function delete($id){
        $inquery = InQuery::find($id);
        $inquery->delete();
        return $inquery;
    }
    public function show($id){
        $query = InQuery::find($id);;
        return $query;
    }
    public function edit($id){
        $query = InQuery::find($id);;
        return $query;
    }
    public function statusUpdate($data, $id){
        return InQuery::where('id',$id)->update([
            'status' => $data['status']
        ]);
    }
}
