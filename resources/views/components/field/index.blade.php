<?php
/*$field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get(); */
?>
@if(!$field->isEmpty())
@foreach($field as $item)
@include('components.field.'.$item->type,['dataField' => $item])
@endforeach
@endif