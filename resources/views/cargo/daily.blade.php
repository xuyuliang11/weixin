<table border="1"> 
    <tr>
        <td>操作用户id</td>
        <td>货物id</td>
        <td>操作时间</td>
        <td>操作类型</td>
    </tr>
    @foreach ($data as $v)
    <tr>
        <td>{{$v->uid}}</td>
        <td>{{$v->gid}}</td>
        <td>@php echo date("Y-m-d",$v->time) @endphp</td>
        <td>{{$v->type}}</td>
    </tr>
    @endforeach

</table>