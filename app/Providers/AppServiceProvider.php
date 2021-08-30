<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Category, Plan, Product, Table, Tenant};
use App\Observers\{CategoryObserver, PlanObserver, ProductObserver, TableObserver, TenantObserver};

class AppServiceProvider extends ServiceProvider
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
        Plan::observe(PlanObserver::class);
        Tenant::observe(TenantObserver::class);
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        Table::observe(TableObserver::class);
    }
}
