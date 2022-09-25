 @if(!$configIs->isEmpty())
 @foreach($configIs as $item)
 <th>{{$item->title}}</th>
 @endforeach
 @endif