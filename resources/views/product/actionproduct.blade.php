{{-- <a href="{{ route('edit_product',$id) }}" data-toggle="tooltip" data-original-title="edit" class="edit btn btn-success edit">
    Edit
    </a>
    <a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
    Delete
    </a> --}}
    <a href="{{ route('edit_product',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
        Edit
        </a>
        {{-- <a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
        Delete
        </a> --}}
        <a href="{{ route('destroypro',$id) }}" data-toggle="tooltip" data-original-title="delete" class="delete btn btn-danger delete">
            Delete
            </a>