@extends('template.backyard')

@section('page-header')
{{$user->name}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('backyard.home')}}">Home</a></li>
<li class="breadcrumb-item active"><?php printf('%s', ucwords($modelName))?>-Show</li>
@endsection

@section('content')
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-12">
                <dl class="dl-horizontal">
                    <dt>Name</dt>
                    <dd>{{$user->name}}</dd>
                    <dt>Username</dt>
                    <dd>{{$user->username}}</dd>
                    <dt>Email</dt>
                    <dd>{{$user->email}}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-4">
        <dt>Foto Profil</dt>
        <?php
            $profpic_filename = Auth::user()->photo_filename ? : "default.jpg";
        ?>
        <img src="<?=asset("storage/profpic/$profpic_filename")?>" alt="foto profil user" class="img-circle">
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-6 col-sm-2">
        <a class="btn btn-primary" href="{{ route('backyard.user.home') }}" style="width:100%">Back</a>
    </div>
    <div class="form-group col-xs-6 col-sm-2">
        <a class="btn btn-warning" href='<?php echo route("{$routePrefix}.edit",Auth::user()->id) ?>' style="width:100%">Edit</a>
    </div>
</div>
@endsection