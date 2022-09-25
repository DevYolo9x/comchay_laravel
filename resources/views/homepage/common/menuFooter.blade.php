<?php
$menu_footer = Cache::remember('menu_footer', 60, function () {
    $menu_footer_id = \App\Models\Menu::where('slug', 'menu-footer')->pluck('id');
    $menu_footer = \App\Models\MenuItem::where('menu_id', $menu_footer_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
    return $menu_footer;
});
?>
@if($menu_footer->count() > 0)
<div class="container px-1 md:px-0 mx-auto mb-2 mt-10">
    <div>
        <ul class="flex flex-wrap space-x-6 gap-2">
            @foreach($menu_footer as $key => $item)
            <li><a href="{{url($item->slug)}}" <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?> class="uppercase font-bold hover:text-c8252c">{{$item->title}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif