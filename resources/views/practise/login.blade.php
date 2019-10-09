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
        <form action="">
            账号：<input type="text" name="account"><br>
            密码：<input type="password" name="password"><br>
            <input type="submit" value="提交">
        </form>
        <div>
            <h3>第三方登陆</h3>
            <button class="wechat">微信登陆</button>
        </div>

</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $('.wechat').click(function(){
        window.location.href="{{url('practise/wechat_login')}}";
    })
</script>
