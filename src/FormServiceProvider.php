<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 02/11/2018
 * Time: 18:46
 */

namespace Z1lab\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->publishTranslations();
        $this->publishComponents();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/form');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'form');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'form');
        }
    }

    /**
     * Publish components.
     *
     * @return void
     */
    public function publishComponents()
    {
        $this->publishes([
            __DIR__ . '/../resources/js/components' => base_path('resources/js/components/forms'),
        ], 'form-components');
    }

    /**
     * Publish translations files.
     *
     * @return void
     */
    public function publishTranslations()
    {
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/form'),
        ]);
    }
}