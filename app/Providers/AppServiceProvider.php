<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        // Register Livewire components
        Livewire::component('parent.carebuddy-recommendations', \App\Livewire\Parent\CarebuddyRecommendations::class);
        
        // Register Blade components with their prefixes
        $this->loadViewComponentsAs('parent', [
            \App\View\Components\Parent\Layouts\ParentLayout::class,
        ]);
        
        $this->loadViewComponentsAs('carebuddy', [
            \App\View\Components\Carebuddy\Layouts\Carebuddy::class,
        ]);
    }
}
