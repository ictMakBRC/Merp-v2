<?php

namespace App\Providers;

use App\Models\Finance\Settings\FmsCurrency;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Global\FacilityInformation;
use App\Models\HumanResource\Settings\CompanyProfile;

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
        
        if (Schema::hasTable('facility_information')) {
            View::share('facilityInfo', CompanyProfile::first());
            View::share('organizationInfo', FacilityInformation::first());
        } else {
            View::share('facilityInfo', []);
            View::share('organizationInfo', []);
        }
        if (Schema::hasTable('fms_currencies')) {
            View::share('baseCurrency', FmsCurrency::where('system_default',1)->first());
        } else {
            View::share('baseCurrency', []);
        }
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
