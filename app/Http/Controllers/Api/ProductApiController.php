<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        $Products = Product::all();
        return response([ 'products' => productResource::collection($products), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Name' => 'required|max:255',
            'Description' => 'required|max:255',
            'Image' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $product = product::create($data);

        $product = Product::create($data);
        return response()->json([
            'product' => $product
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        
        return response(['product' => new productResource($product), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        // $product->update($request->all());

        // return response(['product' => new productResource($product), 'message' => 'Update successfully'], 200);
        $data = array();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
       $data['image'] = $request->image;

       $result=$request->file('file')->store('apiDocs');
    //    if($request->file('public/image')->isValid()){

        
    //     $image = $request->image->store('livros');
    //     $data['image'] = $image;}
    //     $product = DB::table('products')->where('id', $id)->update($data);
        
         return response(['product' => $product, 'message' => 'Update successfully'], 200);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
{
    
    $product=Product::where('name',$name)->first();
    $result = $product->delete();
    if($result){
        return ['result'=>'Record has been deleted'];
    }
}
}

