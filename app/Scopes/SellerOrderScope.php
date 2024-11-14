<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SellerOrderScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check() && Auth::user()->role === 'seller') {
            // Filter orders based on the `created_by` attribute in products via carts
            $builder->whereHas('cart_info.product', function ($query) {
                $query->where('created_by', Auth::id());
            });
        }
    }
}
