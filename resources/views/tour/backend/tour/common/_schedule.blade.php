<?php
$schedule =  [];
if ($errors->any()) {
    $schedule =  old('schedule');
} else if($action == 'update'){
    $schedule =  json_decode($detail->schedule,TRUE);
}
?>
<div class="box p-5 mt-3">
    <div id="schedule">
        @if(isset($schedule['title']) && is_array($schedule['title']) && count($schedule['title']))
        @foreach ($schedule['title'] as $key => $val)
        <div class="mt-5 desc-more">
            <div class="relative">
                <div class="w-full">
                    <input type="text" name="schedule[title][]" value="<?php echo $val ?>" class="form-control"
                        placeholder="Tiêu đề">
                </div>
                <button class=" text-danger delete-attr absolute right-0 top-1/2" type="button"
                    style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><i
                        data-lucide="trash-2" class="w-4 h-4 mr-1"></i></button>
            </div>
            <div class="col-lg-12 mt-3">
                <?php echo Form::textarea('schedule[description][]', $schedule['description'][$key], ['id' => 'ckSchedule' . $key . '', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="flex justify-between items-center mt-5">
        <a href="javascript:void(0)" class="add-schedule btn btn-success text-white" onclick="return false;">Thêm mới
            +</a>
    </div>
</div>