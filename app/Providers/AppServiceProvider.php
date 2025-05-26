<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Models\ActivityLog;
use App\Models\Parents;
use App\Models\CareBuddy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        // Log model events
        $this->logModelEvents();

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

    /**
     * Register model event logging
     */
    protected function logModelEvents()
    {
        $models = [
            User::class,
Parents::class,
            CareBuddy::class,
            // Add other models you want to track
        ];

        foreach ($models as $model) {
            $model::created(function ($model) {
                $this->logActivity($model, 'created');
            });

            $model::updated(function ($model) {
                $this->logActivity($model, 'updated');
            });

            $model::deleted(function ($model) {
                $this->logActivity($model, 'deleted');
            });
        }
    }

    /**
     * Log activity for a model event
     */
    protected function logActivity($model, string $event)
    {
        $user = Auth::user();
        
        ActivityLog::create([
            'log_name' => $event,
            'description' => $event,
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'causer_type' => $user ? get_class($user) : null,
            'causer_id' => $user ? $user->id : null,
            'properties' => [
                'attributes' => $model->getAttributes(),
                'old' => $event === 'updated' ? $model->getOriginal() : [],
            ]
        ]);
    }
}
