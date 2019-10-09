<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户标签修改</title>
</head>
<body>
<form  action="{{url('index/tagup_do')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <input type="text" name="name" value="{{$name}}">
    <input type="submit" value="修改">
</form>
</body>
</html>
