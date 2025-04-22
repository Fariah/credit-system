<?php

namespace App\Providers;

use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Domain\Credit\Repository\CreditRepositoryInterface;
use App\Domain\Credit\Rule\AgeRule;
use App\Domain\Credit\Rule\IncomeRule;
use App\Domain\Credit\Rule\RandomRejectionForPragueRule;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use App\Domain\Credit\Rule\RegionRule;
use App\Domain\Credit\Rule\ScoreRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;
use App\Domain\Notification\ClientNotificationInterface;
use App\Infrastructure\Notification\LogClientNotification;
use App\Infrastructure\Persistence\Eloquent\EloquentClientRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentCreditRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientRepositoryInterface::class, EloquentClientRepository::class);
        $this->app->singleton(CreditEligibilityChecker::class, function () {
            return new CreditEligibilityChecker([
                new ScoreRule,
                new IncomeRule,
                new AgeRule,
                new RegionRule,
                new RandomRejectionForPragueRule,
            ]);
        });

        $this->app->singleton(RegionRateModifierRule::class, fn () => new RegionRateModifierRule);
        $this->app->singleton(CreditRepositoryInterface::class, EloquentCreditRepository::class);
        $this->app->singleton(ClientNotificationInterface::class, LogClientNotification::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
