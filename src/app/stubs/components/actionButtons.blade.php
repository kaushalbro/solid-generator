<nobr>
    <a href="{{route($attributes['route_prefix'].'.show', $attributes['model']->id)}}" class="actions btn btn-sm btn-info" data-tooltip="true" title="Show">
        <i class="far fa-eye" aria-hidden="true"></i></a>
    <a href="{{route($attributes['route_prefix'].'.edit', $attributes['model']->id)}}"
       class="actions btn btn-sm btn-warning" data-tooltip="true4" title="Edit">
        <i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
    <form style="display:inline" action="{{route($attributes['route_prefix'].'.destroy', $attributes['model']->id)}}" method="POST">
        {{csrf_field()}}
        {{method_field("DELETE")}}
        <button class="btn btn-danger btn-sm delete-asset" title="delete" onclick="deleteModel()">
            <i class="fas fa-trash" aria-hidden="true"></i>
        </button>
    </form>
</nobr>
