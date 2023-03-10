<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DataTables;
use Illuminate\Http\Request;

class ProductAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function creat(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-name="' . $row->name . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-name="' . $row->name . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('product.product');
    }

    // public function store(Request $request)
    // {
    // $request->validate([
    // 'first_name' => 'required',
    // 'email' => 'required',
    // 'password' => 'required',
    // ]);
    // $user = new user;
    // $user->first_name = $request->first_name;
    // $user->last_name = $request->last_name;
    // $user->password = $request->password;

    // $user->save();
    // return redirect()->route('users.index')
    // ->with('success','User has been created successfully.');
    // }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $data['image'] = $filename;
        }


        Product::Create([
            'name' => $request->name,
            'image' => $filename,
            'description' => $request->description]);

        // return response()->json(['success'=>'Product saved successfully.']);
        return redirect()->route('productlist');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit_product($id)
    {
        $product = Product::find($id);
        return view('product.edit_product', compact('product'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroypro(Request $request)
    {
        Product::where('id', $request->id)->delete();
        return redirect()->route('productlist')
            ->with('success', 'User Has Been deleted successfully');

        // Product::find($id)->delete();
        //   return redirect()->route('productlist');

        // return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function productlist()
    {
        if (request()->ajax()) {
            // return datatables()->of(Product::select('*'))
            $data = Product::select('id', 'name', 'image', 'description');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<a href=' . asset('/public/Image/' . $row->image) . ' target="blank"><img src="' . asset($row->image) . '" alt="" width="150" height="150"></a>';
                })
                ->addColumn('action', 'product.action')
                ->rawColumns(['image', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('product.productlist');
    }

    public function productindex()
    {
        if (request()->ajax()) {
            // return datatables()->of(Product::select('*'))
            $data = Product::select('id', 'name', 'image', 'description');
            return Datatables::of($data)->addIndexColumn()
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<a href=' . asset('/public/Image' . $row->image) . ' target="blank"><img src="' . asset('/public/Image/' . $row->image) . '" alt="" width="150" height="150"></a>';
                })
                ->addColumn('action', 'product.actionproduct')
                ->rawColumns(['image', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('product.productlist');
    }

    public function editnewproduct(Request $request, $id)
    {

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $data['image'] = $filename;
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'phone_number' => 'required',
        ]);
        $product = product::find($id);
        $product->name = $request->name;
        $product->image = $filename;
        $product->description = $request->description;
        $product->save();
        return view('product.productlist');

    }
}
