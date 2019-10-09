<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>粉丝列表</title>
</head>
<body>
<form action="{{url('practise/send')}}" method="post">
    @csrf
    <input type="submit" value="发送">
    <textarea name="content" id="" cols="30" rows="10"></textarea>
        <table border="1">
            <tr>
                <td></td>
                <td>粉丝名</td>
                <td>openid</td>
            </tr>
            @foreach($info as $v)
            <tr>
                <td><input type="checkbox" name="openid[]" value="{{$v['openid']}}" ></td>
                <td>{{$v['nickname']}}</td>
                <td>{{$v['openid']}}</td>
            </tr>
            @endforeach
        </table>
</form>
</body>
</html>
