<?php

namespace App\Providers;


use App\Models\Category;
use App\Models\City;
use App\Models\Country;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['courses.fields'], function ($view) {
            $categoryItems = Category::pluck('name','id')->toArray();
            $view->with('categoryItems', $categoryItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $categoryItems = Category::pluck('name','id')->toArray();
            $view->with('categoryItems', $categoryItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $categoryItems = Category::pluck('name','id')->toArray();
            $view->with('categoryItems', $categoryItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $categoryItems = Category::pluck('name','id')->toArray();
            $view->with('categoryItems', $categoryItems);
        });
        View::composer(['courses.fields'], function ($view) {
            $categoryItems = Category::pluck('name','id')->toArray();
            $view->with('categoryItems', $categoryItems);
        });
        View::composer(['backend.config.locations.fields'], function ($view) {
            $cityItems = City::pluck('name','id')->toArray();
            $view->with('cityItems', $cityItems);
        });
        View::composer(['cities.fields'], function ($view) {
            $countryItems = Country::pluck('name','id')->toArray();
            $view->with('countryItems', $countryItems);
        });
        View::composer(['backend.config.locations.fields'], function ($view) {
            $countryItems = Country::pluck('name','id')->toArray();
            $view->with('countryItems', $countryItems);
        });

        //
    }
}
