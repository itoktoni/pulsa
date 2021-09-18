<?php

namespace Modules\Procurement\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Config;
use Modules\Procurement\Dao\Models\MovementDetail;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Modules\Procurement\Dao\Repositories\BranchRepository;
use Modules\Procurement\Dao\Repositories\MovementRepository;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Procurement\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Repositories\SupplierRepository;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind('purchase_facades', function () {
            return new PurchaseRepository();
        });
        $this->app->bind('purchase_detail_facades', function () {
            return new PurchaseDetail();
        });
        $this->app->bind('movement_facades', function () {
            return new MovementRepository();
        });
        $this->app->bind('movement_detail_facades', function () {
            return new MovementDetail();
        });
        $this->app->bind('stock_facades', function () {
            return new StockRepository();
        });
        $this->app->bind('supplier_facades', function () {
            return new SupplierRepository();
        });
        $this->app->bind('branch_facades', function () {
            return new BranchRepository();
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('Procurement.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Procurement'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/Procurement');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Procurement';
        }, Config::get('view.paths')), [$sourcePath]), 'Procurement');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/Procurement');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Procurement');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Procurement');
        }
    }

    /**
     * Register an additional directory of Repositories.
     *
     * @return void
     */
    public function registerFactories()
    {
        // if (! app()->environment('production')) {
        //     app(Factory::class)->load(__DIR__ . '/../Database/factories');
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
