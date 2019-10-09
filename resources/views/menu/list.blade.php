<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>菜单管理</title>
</head>
<body>
<center>
    <h1>菜单添加</h1>
        <form action="{{url('index/create_menu')}}" method="post">
            @csrf
            一级菜单: <input type="text" name="name1"><br><br>
            二级菜单：<input type="text" name="name2"><br><br>
            类型：
            <select name="type" id="">
                <option value="click">click</option>
                <option value="view">view</option>
            </select><br><br>
            key: <input type="text" name="event_value"><br><br>
            <input type="submit" value="提交">
        </form>
    <h2>菜单展示</h2>
    <table border="2">
        <tr>
            <td>一级菜单</td>
            <td>二级菜单</td>
            <td>操作</td>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->name1}}</td>
            <td>{{$v->name2}}</td>
            <td><a href="{{url('index/menu_del')}}?id={{$v->id}}">删除</a></td>
        </tr>
            @endforeach
    </table>
</center>
</body>
</html>