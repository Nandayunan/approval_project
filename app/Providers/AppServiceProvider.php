<?php

namespace App\Providers;

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
        // Morph map for polymorphic relations
        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'PackagingForm' => 'App\Models\PackagingForm',
            'ResinForm' => 'App\Models\ResinForm',
            'FilmForm' => 'App\Models\FilmForm',
        ]);
    }
}
