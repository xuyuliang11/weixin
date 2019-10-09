<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>群发消息</title>
</head>
<body>
<form action="{{url('index/tag_send_do')}}" method="post">
    @csrf
    <input type="hidden" name="tag_id" value="{{$tag_id}}">
    <textarea name="text" id="" cols="30" rows="10"></textarea>
    <input type="submit" value="发送">
</form>
</body>
</html>
