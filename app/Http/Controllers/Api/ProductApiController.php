<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->perPage == null ? 10 : $request->perPage;
        $data = Product::paginate($perPage)->withQueryString();
        return $this->success(data: $data);
    }

    public function user(Request $request, $id)
    {
        $perPage = $request->perPage == null ? 10 : $request->perPage;
        $data = Product::query()
            ->whereHas('userProducts', function ($query) use ($id) {
                $query->select('id')->where('user_id', [$id]);
            })
            ->paginate($perPage)->withQueryString();
        return $this->success(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validation = $this->validateProduct($request);
        if ($validation != null)
            return $validation;

        // $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
        // Storage::disk('public')->put($imageName, file_get_contents($request->image));

        $product = Product::create([
            'name' => $request->name,
            // 'image' => $imageName,
            'image' => $request->image->store('images','public'),
            'description' => $request->description
        ]);

        $res = [
            'id' => $product->id,
        ];
        return $this->success(data: $res, code: 201);
    }

    private function validateProduct(Request $request): JsonResponse|array|null
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->error(data: ['error' => $validator->errors()]);
        } else
            return null;
    }

    /**
     * Display the specified resource.
     */
    public function details($id)
    {
        $product = Product::find($id);
        if ($product == null)
            return $this->error(message: 'product not found', code: 404);
        return $this->success(data: $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        // $validation = $this->validateProduct($request);
        // if ($validation != null)
        //     return $validation;

        $product = Product::find($id);

        if ($request->image) {
            // $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            // Storage::disk('public')->put($imageName, file_get_contents($request->image));
            // Storage::disk('public')->delete($product->image);
            // $product->image = $imageName;

            if ($request->hasFile('image')) {
                $image=$request->image->store('images','public');
                Storage::disk('public')->delete($product->image);
                $product->image = $image;
            }
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return $this->success(message: 'product updated successfully', code: 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if ($product == null) {
                return $this->error(message: 'product doesn\'t exist.', code: 404);
            }

            $imageName = $product->image;

            $result = $product->delete();
            if ($result) {
                Storage::disk('public')->delete($imageName);
                return $this->success(message: 'product deleted successfully.');
            } else
                return $this->error(message: 'can\'t delete the product.', code: 403);
        } catch (e) {
            return $this->error(message: 'can\'t delete the product.', code: 403);
        }
    }
}

