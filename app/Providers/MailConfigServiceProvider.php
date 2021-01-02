<?php

namespace App\Providers;

use App\MSmtpConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
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
        $data = MSmtpConfig::all()->first();

        if ($data) {
            $config = array(
                'driver' => env('MAIL_DRIVER', 'smtp'),
                'host' => $data->smtp_host,
                'port' => env('MAIL_PORT', '465'),
                'username' => $data->smtp_username,
                'password' => $data->smtp_password,
                'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
                'from' => array('address' => $data->smtp_username, 'name' => env('APP_NAME', 'Trans')),
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );

            Config::set('mail', $config);
        }
    }
}
