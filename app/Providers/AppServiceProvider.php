<?php

namespace App\Providers;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with([
                'parent_cats' => Category::with('children')->whereNull('parent_id')->get(),
                'children_cats'=> Category::with('children')->whereNotNull('parent_id')->get(),
            ]);
        View::composer('layouts.app', function ($view) {
            $cart = auth()->check() 
                ? auth()->user()->cart()->with('items.product.discounts')->first() 
                : null;

            $view->with('cartItems', $cart ? $cart->items : collect());
        });
    });
    }
}
