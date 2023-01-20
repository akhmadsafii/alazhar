<?php

namespace App\Providers;

use App\Http\Resources\ProcurementResource;
use App\Models\School;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

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
        // ProcurementResource::withoutWrapping();
        JsonResource::withoutWrapping();

        View()->composer([
            'layout.main',
            'layout.footer',
            'layout.user.main',
            'layout.user.footer',
            'content.auth.v_login',
            'content.report.v_main'
        ], function ($view) {
            $school = School::first();
            // dd($school);
            $view->with(['school' => $school]);
        });
    }
}
