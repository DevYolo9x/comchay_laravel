<nav id="primary-nav" class="dropdown cf" style="display: none">

    <ul class="dropdown menu">
        @if($menu_header->count() > 0)
        @foreach($menu_header as $item)
        <li><a href="{{url($item->slug)}}" <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?>>{{$item->title}}</a>
            @if($item->children->count() > 0)
            <ul class="sub-menu">
                @foreach($item->children as $item2)
                <li><a href="{{url($item2->slug)}}" <?php echo !empty($item2->target === '_blank') ? 'target="_blank"' : '' ?>>{{$item2->title}}</a>
                    @if($item2->children->count() > 0)
                    <ul class="sub-menu">
                        @foreach($item2->children as $item3)
                        <li>
                            <a href="{{url($item3->slug)}}" <?php echo !empty($item3->target === '_blank') ? 'target="_blank"' : '' ?>>{{$item3->title}}</a>
                            @if($item3->children->count() > 0)
                            <ul class="sub-menu">
                                @foreach($item3->children as $item4)
                                <li> <a href="{{url($item4->slug)}}" <?php echo !empty($item4->target === '_blank') ? 'target="_blank"' : '' ?>>{{$item4->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
        @endif
        @if($menu_top->count() > 0)
        @foreach($menu_top as $key => $item)
        <li><a href="{{url($item->slug)}}">{{$item->title}}</a></li>
        @endforeach
        @endif

        <li><a href="{{route('customer.changepassword')}}">Đổi mật khẩu</a></li>
        <li><a href="{{route('customer.dashboard')}}">{{Auth::user()->name}}</a></li>
        <li><a href="{{route('customer.logout')}}">Đăng xuất</a></li>
    </ul>

</nav><!-- / #primary-nav -->