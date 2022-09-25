<?php
$checkin = $checkout = $available = $discount = '';
$infoTour = $serviceTour = [];
if ($errors->any()) {
    $checkin =  old('checkin');
    $checkout =  old('checkout');
    $infoTour =  old('infoTour');
    $available =  old('available');
    $serviceTour = old('serviceTour');
    $discount = old('discount');
} else if($action == 'update'){
    $checkin =  $detail->checkin;
    $checkout =  $detail->checkout;
    $available =  $detail->available;
    $discount =  $detail->discount;
    $infoTour =  json_decode($detail->infoTour,TRUE);
    $serviceTour = \App\Models\TourServiceRelationship::where('tour_id',$detail->id)->pluck('tour_service_item_id');
}
?>
<div class="box p-5 mt-3">
    <div class="grid grid-cols-1 md:grid-cols-2 md:space-x-5">
        <div class="mt-3">
            <label class="form-label text-base font-semibold">CHECK IN</label>
            <?php echo Form::text('checkin',$checkin, ['class' => 'form-control w-full datepicker']); ?>
        </div>
        <div class="mt-3">
            <label class="form-label text-base font-semibold">CHECK OUT</label>
            <?php echo Form::text('checkout',$checkout, ['class' => 'form-control w-full datepicker']); ?>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Thời gian</label>
        <?php echo Form::text('infoTour[]',!empty($infoTour)?$infoTour[0]:'', ['class' => 'form-control w-full']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Group</label>
        <?php echo Form::text('infoTour[]',!empty($infoTour)?$infoTour[1]:'', ['class' => 'form-control w-full']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Min Age</label>
        <?php echo Form::text('infoTour[]', !empty($infoTour)?$infoTour[2]:'', ['class' => 'form-control w-full']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Ticket Available</label>
        <?php echo Form::text('available', !empty($available)?$available:'', ['class' => 'form-control w-full']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Discount</label>
        <?php echo Form::text('discount', !empty($discount)?$discount:'', ['class' => 'form-control w-full']); ?>
    </div>


    <div class="wrapper mt-3">
        <label class="text-danger form-label text-base font-semibold">Information</label>
        <?php echo Form::text('groupService','', ['class' => 'form-control w-full hidden']); ?>
        @if(count($services) > 0)
        @foreach($services as $service)
        @if(count($service->items) > 0)
        <div class="mt-3 itemService" data-id="{{$service->id}}">
            <div class="flex " style="align-items: baseline;">
                <label class="form-label text-base font-semibold mb-0">{{$service->title}}</label>
                <a class="text-danger ml-2 modalAddService font-bold" href="javascript:void(0)" data-tw-toggle="modal"
                    data-tw-target="#medium-modal" data-id="{{$service->id}}">[Thêm mới +]</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 p-2" id="box-services-{{$service->id}}">
                @foreach($service->items as $item)
                <div>
                    <label class="form-label text-base">
                        <input type="checkbox" name="serviceTour[]" value="{{$item->id}}"
                            {{ (collect($serviceTour)->contains($item->id)) ? 'checked':'' }}>
                        {{$item->title}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
        @endif
    </div>
</div>
@push('javascript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(function() {
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<script>
$(document).on('click', '.checkbox-item', function() {
    var value = $(this).val();
    if (value == 1) {
        $('.show_date_end').show();
    }
})
</script>
<style>
#ui-datepicker-div {
    z-index: 9999999 !important;
}
</style>
@endpush
