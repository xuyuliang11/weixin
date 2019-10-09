<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <table border="1">
            <tr>
                <td>ID</td>
                <td>用户名</td>
                <td>二维码</td>
                <td>操作</td>
            </tr>
            @foreach( $data as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->nickname}}</td>
                <td><img src="{{env('IMG')}}{{$v->path}}" alt="" HEIGHT="40" width="40"></td>
                <td>
                    <a href="{{url('index/qrcode')}}?id={{$v->id}}">生成二维码</a>
                </td>
            </tr>
            @endforeach
        </table>
</body>
</html>