@if(!empty($comment_view['listComment']))
@foreach($comment_view['listComment'] as $v)
<div class="item clearfix" style="margin-bottom:20px">
    <div class="image">
        @if(!empty($v->avatar))
        <img src="{{asset($v->avatar)}}" alt="{{$v->fullname}}"
            style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
        @else
        <img src="https://ui-avatars.com/api/?name={{$v->fullname}}" alt="{{$v->fullname}}"
            style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
        @endif
    </div>
    <div class="info">
        <div class="name">
            <div class="rate pull-left">
                <label>{{$v->fullname}}</label>
            </div>
            <span class="pull-right">{{Carbon\Carbon::parse($v->created_at)->isoFormat('MMM')}}
                {{Carbon\Carbon::parse($v->created_at)->isoFormat('DD')}},
                {{Carbon\Carbon::parse($v->created_at)->isoFormat('YYYY')}}</span>
        </div>
        <p>{{$v->message}}</p>
    </div>
</div>
@if($v->child)
@foreach($v->child as $kc=>$vc)
<div class="item clearfix" style="padding-left:90px;margin-top:10px">
    <div class="image">
        @if(!empty($vc->avatar))
        <img src="{{asset($vc->avatar)}}" alt="{{$vc->fullname}}"
            style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
        @else
        <img src="https://ui-avatars.com/api/?name={{$vc->fullname}}" alt="{{$vc->fullname}}"
            style="border-radius:100%;width:60px;height:60px;object-fit: cover;">
        @endif
    </div>
    <div class="info">
        <div class="name">
            <div class="rate pull-left">
                <label>{{$vc->fullname}}</label>
                @if($vc->type == "QTV")
                <span style="color:red;font-weight:bold">ADMIN</span>
                @endif
            </div>
            <span class="pull-right">{{Carbon\Carbon::parse($v->created_at)->isoFormat('MMM')}}
                {{Carbon\Carbon::parse($v->created_at)->isoFormat('DD')}},
                {{Carbon\Carbon::parse($v->created_at)->isoFormat('YYYY')}}</span>
        </div>
        <p>{{$vc->message}}</p>
    </div>
</div>
@endforeach
@endif
@endforeach
<div class="dataTables_paginate paging_bootstrap pull-right paginate_cmt">
    {{$comment_view['listComment']->links()}}
</div>
@endif