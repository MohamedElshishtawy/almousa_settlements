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
        Blade::directive('arDigit', function ($digit) {

            if (!is_numeric($digit)) {
                return "<?php echo $digit; ?>";
            }

            return "<?php echo \Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($digit); ?>";

        });
    }
}
