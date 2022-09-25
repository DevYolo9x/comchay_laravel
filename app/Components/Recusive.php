<?php
namespace App\Components;
class Recusive{
    private $data;
    private $htmlSelect = '';
    public function __construct($data)
    {
        $this->data = $data;
    }
    function catalogueRecusive($parent_id = 0,$id = 0,$text= '')
    {
        foreach ($this->data as $k=>$v){
            if($v['parent_id'] == $id){
                if(!empty($parent_id) && $parent_id === $v['id']){
                    $this->htmlSelect .="<option selected value='".$v['id']."'>".$text.$v['title']."</option>";
                }else{
                    $this->htmlSelect .="<option value='".$v['id']."'>".$text.$v['title']."</option>";
                }
                $this->catalogueRecusive($parent_id,$v['id'],$text.'--');
            }
        }
        return $this->htmlSelect;
    }
}