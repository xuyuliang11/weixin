<html>
<head>
    <title>用户标签管理</title>
</head>
<body>
<center>
    <h1>用户标签管理</h1>
    <h2>标签名 {{$name}}</h2>
    <table border="1">
        <tr>
            <td>open_id</td>

        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v}}</td>
            </tr>
        @endforeach
    </table>
    <br/>
    <br/>

</center>

</body>
</html>