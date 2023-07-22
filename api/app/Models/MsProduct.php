<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MsProduct extends Model
{
    protected $table = 'ms_product';

    use Blameable;
    use HasFactory;
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'productName', 'categoryID', 'subCategoryID', 'notes', 'image', 'created_by'
    ];

    public function getProductList($id = null)
    {
        $query = DB::table('ms_product AS product')
            ->join('ms_category AS category', 'product.categoryID', '=', 'category.id')
            ->leftJoin('ms_subcategory AS subCategory', 'product.subCategoryID', '=', 'subCategory.id')
            ->select('product.*', 'category.categoryName', 'subCategory.subCategoryName');
        if ($id !== null) {
            $query->where('product.id', $id);
        }
        
        return $query;
    }
}
