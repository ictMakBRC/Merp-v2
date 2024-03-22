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
            return $figure != null? "<?php echo number_format($figure,2); ?>":"<?php echo 'N/A'; ?>";
        });

        Blade::directive('numberFormat', function ($figure) {
            return $figure != null? "<?php echo number_format($figure); ?>":"<?php echo 'N/A'; ?>";
        });

        Blade::directive('formatDate', function ($expression) {
            return $expression != null? "<?php echo date('d-M-Y', strtotime($expression)); ?>":"<?php echo 'N/A'; ?>";
        });

        Blade::directive('formatDateTime', function ($date) {
            return $date != null? "<?php echo date('d-M-Y H:i', strtotime($date)); ?>":"<?php echo 'N/A'; ?>";
        });

        Blade::directive('formatTelephoneContact', function ($contact) {
            return "<?php echo str_replace('-', '', $contact); ?>";
        });
    }
}
