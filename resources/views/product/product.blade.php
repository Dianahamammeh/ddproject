<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
</head>
<style type="text/css">
    .container{
        margin-top:150px;
    }
    h4{
        margin-bottom:30px;
    }
</style>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>product</h4>
                </div>
                <div class="col-md-12 text-right mb-5">
                    {{-- <a class="btn btn-success" href="javascript:void(0)" name="createNewProduct"> Create New Product</a> --}}
                </div>
                {{-- <div class="col-md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>image</th>
                                <th>description</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>
   
            <div class="modal-body">
                <form method="POST" action="{{ route('saveproduct') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label"> Product Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Product Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" name="description" required="" placeholder="Enter description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Product image</label>
                        <div class="col-sm-12">
                            <input type="file" class="input-file" name="image" wire:model="image"/>
                            @csrf
                           
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
</body>
    

</html>