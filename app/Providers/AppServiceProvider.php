<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // グローバル変数
        // 管理者のID番号を1とする
        // 参照: https://stackoverflow.com/questions/28356193/
        config(['admin_id' => 1]);

         // 本番環境(Heroku)でhttpsを強制する
         if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 本番環境以外で、Duskサービスプロバイダを登録する
        if ($this->app->environment('local', 'testing')) {
            //以下のコマンドが入るとテスト”  Class 'DuskServiceProvider' not found  ”エラーが発生するためコメントアウトにしている
                // $this->app->register(DuskServiceProvider::class);
            }
    }
}
