<form action="tim-kiem" class="w-full md:w-auto" method="GET">
    <div class="relative">
        <input placeholder="{{$fcSystem['title_7']}}" type="text" value="{{request()->get('keyword')}}"
            class="bg-gray-200 rounded-full border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300 focus:rounded-full hover:outline-none hover:ring hover:ring-red-300 hover:rounded-full ovn_keyword"
            name="keyword">
        <button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-gray-400 top-1/2 ovn_submit_search"
            style="transform: translateY(-50%);" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1/2 left-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
        </button>

    </div>
</form>