<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsCategory extends Model
{
    protected $table = 'ms_category';

    use HasFactory;
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
        'categoryName', 'notes'
    ];
}
