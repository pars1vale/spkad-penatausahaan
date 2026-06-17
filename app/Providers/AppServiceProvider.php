<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
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
        Blueprint::macro('userstamps', function (bool $withDeletedBy = true) {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();

            $this->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $this->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            if ($withDeletedBy) {
                $this->unsignedBigInteger('deleted_by')->nullable();
                $this->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            }
        });
        Blueprint::macro('dropUserstamps', function () {
            $this->dropForeign(['created_by']);
            $this->dropForeign(['updated_by']);
            $this->dropForeign(['deleted_by']);
            $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
}
