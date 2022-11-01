<?php
$isPrivilege = Auth::user()->hasAllPermissions([
    "{$routePrefix}.create",
    "{$routePrefix}.edit",
    "{$routePrefix}.destroy",
]);
?>

@extends('template.backyard')

@section('page-header')
<?php printf('%s', ucwords($modelName))?>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('backyard.home')}}">Home</a></li>
<li class="breadcrumb-item active"><?php printf('%s', ucwords($modelName))?>-Index</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped" id="<?=$modelName?>-table" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <?php if($isPrivilege):?>
                            <th class="text-right">
                                <?php if(Auth::user()->hasPermissionTo("{$routePrefix}.create")): ?>
                                    <a href="<?=route("{$routePrefix}.create")?>" title="Create" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                <?php endif; ?>
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js-inline-data')
window['_userIndexData'] = <?= json_encode([
    'routeIndexData' => route($routePrefix.".index.data"),
    'routeDestroyData' => route($routePrefix.".destroy",999),
    'isPrivilege' => $isPrivilege,
])?>;
@endsection

@section('js-include')
<script src="<?= asset('js/backyard/user/user/index.js')?>"></script>
@endsection