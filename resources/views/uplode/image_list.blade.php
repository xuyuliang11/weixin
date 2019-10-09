<html>
<head>
    <title>素材管理</title>
</head>
<body>
<center>
    <h1>素材管理</h1>
    <a href="{{url('index/image')}}">上传永久素材</a><br/><br/>
    <form action="">
        <select name="type" id="" >
            <option value="image" @if($type=='image') selected @endif>图片</option>
            <option value="voice" @if($type=='voice') selected @endif>语音</option>
            <option value="video" @if($type=='video') selected @endif>视频</option>
            <option value="thumb" @if($type=='thumb') selected @endif>缩略图</option>
        </select>
        <input type="submit" value="切换">
    </form>
    <table border="1">
        <tr>
            <td>id</td>
            <td>media_id</td>
            <td>type</td>
            <td>path</td>
            <td>add_time</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->media_id}}</td>
                <td>{{$v->type}}</td>
                <td>{{$v->path}}</td>
                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                <td>
                   @if($v->path === '0' ) <a href="{{url('index/sidebar')}}?id={{$v->id}}">下载素材</a> @endif
                </td>
            </tr>
        @endforeach
    </table>
    <br/>
    <br/>
</center>
</body>
</html>