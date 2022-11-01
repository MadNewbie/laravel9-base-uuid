@extends('template.backyard')

@section('page-header')
{{$role->name}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('backyard.home')}}">Home</a></li>
<li class="breadcrumb-item active"><?php printf('%s', ucwords($modelName))?>-Show</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <strong>Name: </strong>
            {{$role->name}}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <strong class="mb-3">Permissions: </strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <span class="badge badge-info text-dark">{{$v->name}}</span>
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-6 col-sm-2">
        <a href="{{URL::previous()}}" class="btn btn-primary" style="width: 100%">Back</a>
    </div>
</div>
@endsection