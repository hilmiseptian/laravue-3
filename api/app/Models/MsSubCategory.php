<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsSubCategory extends Model
{
    protected $table = 'ms_subcategory';

    use HasFactory;
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'subCategoryName', 'notes'
    ];
}
