<?php

namespace App\Http\Controllers;

use App\Models\LkCity;
use App\Models\LkProvince;
use App\Models\MsStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        //get data from model
        $stores = new MsStore;

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Store',
            'data'    => $stores->getStoreList()->get()
        ], 200);
    }

    function show($id)
    {
        try {
            $store = new MsStore;

            if ($store) {
                return response()->json([
                    'success' => true,
                    'message' => 'List Data Store',
                    'data' => $store->getStoreList()->first($id)
                ]);
            } else {
                return response()->json(['message' => 'Product not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching the product.'], 500);
        }
    }

    public function create(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'store_name'   => 'required',
            'province_id'   => 'required',
            'city_id'   => 'required',
            'postal_code'   => 'required',
            'street'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $MsStore = MsStore::create([
            'store_name'     => $request->store_name,
            'province_id'     => $request->province_id,
            'city_id'     => $request->city_id,
            'postal_code'     => $request->postal_code,
            'street'     => $request->street,
        ]);

        //success save to database
        if ($MsStore) {
            return response()->json([
                'success' => true,
                'message' => 'Store Created',
                'data'    => $MsStore
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Store Failed to Save',
        ], 409);
    }
    
    public function update(Request $request, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'store_name'   => 'required',
            'province_id'   => 'required',
            'city_id'   => 'required',
            'postal_code'   => 'required',
            'street'   => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find model by ID
        $MsStoreModel = MsStore::findOrFail($id);

        if ($MsStoreModel) {
            //update model
            $MsStoreModel->update([
                'store_name'     => $request->store_name,
                'province_id'   => $request->province_id,
                'city_id'     => $request->city_id,
                'postal_code'   => $request->postal_code,
                'street'     => $request->street,
                'notes'   => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Store Updated',
                'data'    => $MsStoreModel
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Category Not Found',
        ], 404);
    }
    
    public function getProvince()
    {
        //get data from table ms_category
        $LkProvinceModel = LkProvince::get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Province',
            'data'    => $LkProvinceModel
        ], 200);
    }
    public function getCity($id)
    {
        //get data from table ms_category
        $LkProvinceModel = LkCity::where('province_id', $id)->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Province',
            'data'    => $LkProvinceModel
        ], 200);
    }

    public function delete($id)
    {
        //find model by ID
        $MsCategoryModel = MsStore::findOrfail($id);

        if ($MsCategoryModel) {
            //delete model
            $MsCategoryModel->delete();
            return response()->json([
                'success' => true,
                'message' => 'Store Deleted',
            ], 200);
        }

        //data model not found
        return response()->json([
            'success' => false,
            'message' => 'Store Not Found',
        ], 404);
    }
}
