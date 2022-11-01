<div class="row">
    <div class="form-group col-xs-12 col-sm-4">
        {!! Form::label('name', 'Nama Role') !!}
        {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control']) !!}
    </div>
</div>
{!! Form::label('permission', 'Permissions') !!}
<div class="row">
    @foreach($permissions as $value)
    <div class="form-group col-xs-12 col-sm-3">
        <label>{!! Form::checkbox('permissions[]', $value->id, isset($rolePermissions) ? in_array($value->id, $rolePermissions) ? true : false : false, array('class' => 'name')) !!} {{ $value->name }}</label>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="form-group col-xs-6 col-sm-2">
        <a href="{{URL::previous()}}" class="btn btn-primary" style="width: 100%;">Kembali</a>
    </div>
    <div class="form-group col-xs-6 col-sm-2">
        <button type="submit" class="btn btn-success" style="width:100%">Simpan</button>
    </div>
</div>