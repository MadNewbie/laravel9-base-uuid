@can($routePrefix.'.edit')
<a href="<?=route($routePrefix.'.edit', $model->id)?>" class="btn btn-sm btn-warning btn-index-menu" title="Edit">
    <i class="fas fa-edit"></i>
</a>
@endcan

@can($routePrefix.'.destroy')
<button data-id="<?=$model->id ?>" class="btn btn-sm btn-danger btn-destroy btn-index-menu" title="Delete">
    <i class="fas fa-trash"></i>
</button>
@endcan