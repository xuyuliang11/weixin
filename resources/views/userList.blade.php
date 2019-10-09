<form action="{{url('index/tag_souer')}}" method="post">
<table border="1">
        @csrf
        <input type="hidden" name="tag_id" value="{{$tag_id}}">
        <input type="submit" value="提交">

    <tr>
        <td>打标签</td>
        <td>微信名</td>
        <td>openid</td>
        <td>操作</td>
    </tr>
    @foreach($last_info as $v)
        <tr>
            <td><input type="checkbox" value="{{ $v['openid'] }}" name="openid_list[]"></td>
            <td>{{ $v['nickname'] }}</td>
            <td>{{ $v['openid'] }}</td>
            <td><a href="">查看</a>|<a href="{{url('index/tog_list')}}">标签列表</a>|
                <a href="{{url('index/getidlist')}}?id={{ $v['openid'] }}& nickname={{ $v['nickname'] }}">用户下的标签</a>
            </td>
        </tr>
    @endforeach
</table>
</form>
