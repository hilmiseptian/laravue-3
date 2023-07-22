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
            $model->createdBy = Auth::user()->name;
        });

        static::updating(function ($model) {
            $model->editedBy = Auth::user()->name;
        });
    }
}
