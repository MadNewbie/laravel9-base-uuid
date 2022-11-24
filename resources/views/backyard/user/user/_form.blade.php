<?php

use App\Models\User\User;

?>
<div class="row">
    <div class="col-10">
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label('name', 'Nama') !!}
                {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label('username', 'Username') !!}
                {!! Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null, ['placeholder' => 'Alamat Email', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label('roles', 'Roles') !!}
                {!! Form::select('roles[]', $roles, isset($userRole) ? $userRole : [], array('class' => 'form-control','multiple')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                {!! Form::label('type_status', 'Status') !!}
                {!! Form::select('type_status', User::getTypeStatusList(), null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group col-6">
                {!! Form::label('password_confirmation', 'Konfirmasi Password') !!}
                {!! Form::password('password_confirmation', ['placeholder' => 'Konfirmasi Password', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <img class="preview" style="display: none;"/>
            </div>
            <div class="form-group col-12">
                {!! Form::label('photo', 'Photo') !!}
                {!! Form::file('photo_raw', ['class' => 'form-control']) !!}
                {!! Form::hidden('photo', null, ['class' => 'form-control', 'id'=>'true_photo']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-6 col-sm-2">
        <a href="{{URL::previous()}}" class="btn btn-primary" style="width: 100%;">Kembali</a>
    </div>
    <div class="form-group col-xs-6 col-sm-2">
        <button type="submit" class="btn btn-success" style="width:100%">Simpan</button>
    </div>
</div>
@section('js-include')
<script src="<?= asset('js/backyard/user/user/_form.js')?>"></script>
@endsection