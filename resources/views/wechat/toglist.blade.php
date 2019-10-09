<html>
<head>
    <title>用户标签管理</title>
</head>
<body>
<center>
    <h1>用户标签管理</h1>
    <a href="{{url('index/tog_save')}}">添加标签</a>
    <table border="1">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>粉丝数量</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
                <td>
                    <a href="{{url('index/tagdel/'.$v['id'])}}">删除</a>|
                    <a href="{{url('index/tagup')}}?id={{$v['id']}}&name={{$v['name']}}">修改</a>|
                    <a href="{{url('index/get_user_list')}}?id={{$v['id']}}">打标签</a>|
                    <a href="{{url('index/user_tag')}}?id={{$v['id']}}& name={{$v['name']}}">粉丝列表</a>|
                    <a href="{{url('index/tag_send')}}?id={{$v['id']}}">群发消息</a>
                    <a href="{{url('index/menu')}}">生成菜单</a>
                </td>
            </tr>

        @endforeach
    </table>
    <br/>
    <br/>

</center>

</body>
</html>