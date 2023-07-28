<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('moneyFormat', function ($figure) {
            return "<?php echo number_format($figure,2); ?>";
        });

        Blade::directive('numberFormat', function ($figure) {
            return "<?php echo number_format($figure); ?>";
        });

        Blade::directive('formatDate', function ($expression) {
            return "<?php echo date('d-M-Y', strtotime($expression)); ?>";
        });

        Blade::directive('formatDateTime', function ($date) {
            return "<?php echo date('d-M-Y H:i', strtotime($date)); ?>";
        });

        Blade::directive('formatTelephoneContact', function ($contact) {
            return "<?php echo str_replace('-', '', $contact); ?>";
        });
    }
}
