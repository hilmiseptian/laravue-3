<?php

namespace App\Http\Controllers;

use App\Models\MsSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
        //get data from table models
        $MsSubCategoryModels = MsSubCategory::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data'    => $MsSubCategoryModels
        ], 200);
    }

    public function show($id)
    {
        //find model by ID
        $MsSubCategoryModel = MsSubCategory::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Category',
            'data'    => $MsSubCategoryModel
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'subCategoryName'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $MsSubCategoryModel = MsSubCategory::create([
            'subCategoryName'     => $request->subCategoryName,
            'notes'   => $request->notes
        ]);

        //success save to database
        if ($MsSubCategoryModel) {
            return response()->json([
                'success' => true,
                'message' => 'Sub Category Created',
                'data'    => $MsSubCategoryModel
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Sub Category Failed to Save',
        ], 409);
    }

    public function update(Request $request, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'subCategoryName'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find model by ID
        $MsSubCategoryModel = MsSubCategory::findOrFail($id);

        if ($MsSubCategoryModel) {
            //update model
            $MsSubCategoryModel->update([
                'subCategoryName'     => $request->subCategoryName,
                'notes'   => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category Updated',
                'data'    => $MsSubCategoryModel
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
        $MsSubCategoryModel = MsSubCategory::findOrfail($id);

        if ($MsSubCategoryModel) {
            //delete model
            $MsSubCategoryModel->delete();
            
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
