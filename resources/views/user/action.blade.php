<a href="{{ route('users.edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
    Edit
    </a>
    <a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
    Delete
    </a>
    <a href="{{ route('user.products',$id) }}" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="products" class="products btn btn-success products">
        products
    </a>
