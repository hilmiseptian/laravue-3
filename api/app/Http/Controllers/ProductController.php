<?php

namespace App\Http\Controllers;

use App\Models\MsProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        //get data from model
        $MsProductModels = new MsProduct;

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data'    => $MsProductModels->getProductList()->get()
        ], 200);
    }

    public function show($id)
    {
        //find model by ID
        $MsProductModel = new MsProduct();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Product',
            'data'    => $MsProductModel->getProductList($id)->first()
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'productName'  => 'required',
            'categoryID'   => 'required',
            'image'        => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the max file size if needed

        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        } else {
            $imagePath = null;
        }

        //save to database
        $MsProductModel = MsProduct::create([
            'productName'  => $request->productName,
            'categoryID'   => $request->categoryID,
            'image' => $imagePath,
        ]);

        //success save to database
        if ($MsProductModel) {
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data'    => $MsProductModel
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Product Failed to Save',
        ], 409);
    }

    public function update(Request $request, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'productName'   => 'required',
            'categoryID'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find model by ID
        $MsProductModel = MsProduct::findOrFail($id);

        if ($MsProductModel) {
            $MsProductModel->update([
                'productName' => $request->productName,
                'categoryID' => $request->categoryID,
                'subCategoryID' => $request->subCategoryID,
                'notes' => $request->notes,
            ]);

            if ($request->hasFile('image') && !is_null($request->file('image'))) {
                if ($MsProductModel->image) {
                    Storage::disk('public')->delete($MsProductModel->image);
                }
                
                $imagePath = $request->file('image')->store('product_images', 'public');
                $MsProductModel->update(['image' => $imagePath]);
            }

            if ($MsProductModel->image && is_null($request->file('image'))) {
                Storage::disk('public')->delete($MsProductModel->image);
                $MsProductModel->update(['image' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product Updated',
                'data'    => $MsProductModel
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Product Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        //find model by ID
        $MsProductModel = MsProduct::findOrfail($id);

        if ($MsProductModel) {
            if ($MsProductModel->image) {
                Storage::disk('public')->delete($MsProductModel->image);
            }
            //delete model
            $MsProductModel->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product Deleted',
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Product Not Found',
        ], 404);
    }
}
