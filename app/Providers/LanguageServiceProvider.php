<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->registerLanguage();
        $this->setTranslation();
    }

    public function registerLanguage(){
    // Get the preferred language from the Accept-Language header
    $preferredLanguage = Request::server('HTTP_ACCEPT_LANGUAGE');
          // Parse the preferred language (e.g., 'en-US,fr;q=0.9' -> 'en')
          $locale = substr($preferredLanguage, 0, 2);
            // Set the application locale if supported
        if (in_array($locale, config('app.supported_locales'))) {
            App::setLocale($locale);
        }else{
            App::setLocale(config('app.fallback_locale'));
        }

    }

    public function setTranslation(): void{
        // current application locale
      $locale = App::getLocale();

      $langFilePath = lang_path('Lang.json');

      if (file_exists($langFilePath)){
        try{
            $translateData = json_decode(file_get_contents($langFilePath), true);
            $langLocaleData = [];
            if (json_last_error() == JSON_ERROR_NONE  && is_array($translateData)) {
               // Filter the JSON data for the current locale
              foreach ($translateData as $key => $translation) {
                if(isset($translation[$locale])  && is_string($translation[$locale])){
                 $translationKey = $locale. '.' .$key;
                 $langLocaleData[$translationKey] = $translation[$locale];
                }
              }

            }
        // Register the filtered language data for the current locale
            Lang::addLines($langLocaleData, $locale);


        }catch (\Exception $e){
            logger()->error("Failed to load translations: " . $e->getMessage());
        }
      }
  }

}
