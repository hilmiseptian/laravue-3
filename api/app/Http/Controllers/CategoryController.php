<?php

namespace App\Http\Controllers;

use App\Models\MsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        //get data from table ms_category
        $MsCategoryModels = MsCategory::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data'    => $MsCategoryModels
        ], 200);
    }

    public function show($id)
    {
        //find post by ID
        $MsCategoryModel = MsCategory::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Category',
            'data'    => $MsCategoryModel
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'categoryName'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $MsCategoryModel = MsCategory::create([
            'categoryName'     => $request->categoryName,
            'notes'   => $request->notes
        ]);

        //success save to database
        if ($MsCategoryModel) {
            return response()->json([
                'success' => true,
                'message' => 'Category Created',
                'data'    => $MsCategoryModel
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Category Failed to Save',
        ], 409);
    }

    public function update(Request $request, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'categoryName'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find model by ID
        $MsCategoryModel = MsCategory::findOrFail($id);

        if ($MsCategoryModel) {
            //update model
            $MsCategoryModel->update([
                'categoryName'     => $request->categoryName,
                'notes'   => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category Updated',
                'data'    => $MsCategoryModel
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Category Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        //find model by ID
        $MsCategoryModel = MsCategory::findOrfail($id);

        if ($MsCategoryModel) {
            //delete model
            $MsCategoryModel->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category Deleted',
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Category Not Found',
        ], 404);
    }
}
