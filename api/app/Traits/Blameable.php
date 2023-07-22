<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Blameable
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootBlameable()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::user()->name;
        });

        static::updating(function ($model) {
            $model->edited_by = Auth::user()->name;
        });
    }
}
