<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MsStore extends Model
{   
    protected $table = 'ms_store';

    use Blameable;
    use HasFactory;
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'store_name', 'province_id', 'city_id', 'postal_code', 'street'
    ];
    
   function getStoreList($id = null) {
        $query = DB::table('ms_store AS store')
        ->leftJoin('lk_province AS province', 'store.province_id', '=', 'province.province_id')
        ->leftJoin('lk_city AS city', 'store.city_id', '=', 'city.city_id')
        //->selectRaw("store.id, store.store_name, CONCAT(store.street, ' - ', city.city_name, ' - ', province.province, ' - ', city.postal_code) AS address");
        ->select(
            'store.id', 
            'store.store_name', 
            'store.province_id', 
            'province.province', 
            'store.city_id', 
            'city.city_name', 
            'city.type', 
            'store.postal_code', 
            'store.street' );
        if (!empty($id)) {
            $query->where('store.id', $id);
        }
        return $query;
    }
}
