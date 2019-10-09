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
<center>
    <form action="{{url('zuo/login_do')}}" method="post">
        账号：<input type="text" name="" ><br><br>
        密码：<input type="password" name=""><br><br>
        <input type="submit" value="提交">
    </form>
    <div >
        第三方登陆：<button class="wechat">微信</button>
    </div>
</center>
</body>
<script src="/js/jq.js"></script>
<script>
    $('.wechat').click(function(){
        window.location.href="{{url('zuo/wechat')}}";
    })
</script>
</html>
