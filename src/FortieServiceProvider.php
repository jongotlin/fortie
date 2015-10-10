<?php namespace Wetcat\Fortie;

/*

   Copyright 2015 Andreas Göransson

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

*/

use Illuminate\Support\ServiceProvider;

use Config;

class FortieServiceProvider extends ServiceProvider
{

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;
  

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //$this->package('wetcat/fortie');

    $this->publishes([
      __DIR__.'/config/config.php' => config_path('fortie.php'),
    ]);
  }


  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__.'/config/config.php', 'fortie'
    );
    
    $this->registerCommands();

    $this->registerFortie();
  }


  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array();
  }


  /**
   * Creates a new Fortie object
   *
   * @return void
   */
  protected function registerFortie()
  {
    $this->app->singleton('Wetcat\Fortie\Fortie', function ($app) 
    {  
      $access_token   = Config::get('fortie.default.access_token', Config::get('fortie::default.access_token'));
      $client_secret  = Config::get('fortie.default.client_secret', Config::get('fortie::default.client_secret'));
      $content_type   = Config::get('fortie.default.content_type', Config::get('fortie::default.content_type'));
      $accepts        = Config::get('fortie.default.accepts', Config::get('fortie::default.accepts'));
      $endpoint       = Config::get('fortie.default.endpoint', Config::get('fortie::default.endpoint'));

      return new Fortie(
        $endpoint,
        $access_token,
        $client_secret,
        $content_type,
        $accepts
      );
    });
  }


  /**
   * Register all the Artisan commands for Fortie.
   */
  protected function registerCommands()
  {
    // Register Fortnox commands
  }

}
