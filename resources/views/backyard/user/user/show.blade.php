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
    <div class="col-12">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{$user->name}}</dd>
            <dt>Username</dt>
            <dd>{{$user->username}}</dd>
            <dt>Email</dt>
            <dd>{{$user->email}}</dd>
            <dt>Roles</dt>
            <dd>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
            </dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-6 col-sm-2">
        <a class="btn btn-primary" href="{{ URL::previous() }}" style="width:100%">Back</a>
    </div>
</div>
@endsection