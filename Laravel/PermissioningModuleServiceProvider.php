<?php

namespace Laravel;

use Gpapanotas\Larabac\Attributes\AttributeManager;
use Gpapanotas\Larabac\Attributes\Contracts\AttributeHandler;
use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;
use Gpapanotas\Larabac\Repositories\DatabaseRuleStorage;
use Gpapanotas\Larabac\Repositories\EloquentRuleStorage;
use Gpapanotas\Larabac\Repositories\MemoryRuleStorage;
use Gpapanotas\Larabac\Services\Contracts\IPermissionEvaluator;
use Gpapanotas\Larabac\Services\Contracts\IRule;
use Gpapanotas\Larabac\Services\PermissionEvaluator;
use Gpapanotas\Larabac\Services\RuleRegistry;
use Illuminate\Support\ServiceProvider;

class PermissioningModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/permissioning.php' => config_path('permissioning.php'),
        ], 'permissioning-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'permissioning-migrations');
    }

    public function register()
    {
        // Merge default configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/permissioning.php',
            'permissioning'
        );

        // Bind RuleStorageInterface
        $this->app->singleton(IRuleStorage::class, function () {
            $config = config('permissioning');
            $storageType = $config['rule_storage'] ?? 'database';

            return match ($storageType) {
                'database' => new DatabaseRuleStorage(),
                'eloquent' => new EloquentRuleStorage(),
                default => new MemoryRuleStorage(),
            };
        });

        // Bind other core services
        $this->app->singleton( AttributeHandler::class, function () {
            return new AttributeManager();
        });

        $this->app->singleton(IRule::class, function ($app) {
            return new RuleRegistry($app->make(IRuleStorage::class));
        });

        $this->app->singleton(IPermissionEvaluator::class, function ($app) {
            return new PermissionEvaluator(
                $app->make(AttributeManager::class),
                $app->make(RuleRegistry::class)
            );
        });
    }
}