<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\JobOfferService;
use App\Interfaces\JobOfferServiceInterface;
use App\Interfaces\TutorServiceInterface;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Services\TutorService;
use view;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JobOfferServiceInterface::class,JobOfferService::class);
        $this->app->bind(TutorServiceInterface::class,TutorService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(125);
        View::share('countryItems', Country::pluck('name', 'id')->toArray());
        View::share('cityItems', City::pluck('name', 'id')->toArray());
        View::share('categoryItems', Category::pluck('name', 'id')->toArray());

        View::composer(['locations.fields'], function ($view) {
            $cityItems = City::pluck('name','id')->toArray();
            $view->with('cityItems', $cityItems);
        });


    }
}
