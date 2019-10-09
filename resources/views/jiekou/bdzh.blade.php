@extends('layouts.admin')
@section('title')登录@endsection
@section('content')
    <div style="margin-top:6%">
        <h2 align="center">绑定管理员账号</h2>
    <form class="form-horizontal" action="{{url('do_bdzh')}}" method="post">

        
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="name" name="name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">绑定管理账号</button>
            </div>
        </div>
    </form>
    </div>
@endsection