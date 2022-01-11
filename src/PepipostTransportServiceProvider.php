<?php
namespace Pepipost\PepipostLaravelDriver;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Pepipost\PepipostLaravelDriver\Transport\PepipostTransport;

class PepipostTransportServiceProvider extends ServiceProvider
{
    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    public function register()
    {

        $this->app->afterResolving(MailManager::class, function ($mail_manager) {
            /** @var $mail_manager MailManager */
            $mail_manager->extend("pepipost", function($config){

                $pepipost_service_config = config('services.pepipost');
                $endpoint = isset($pepipost_service_config['endpoint']) ? $pepipost_service_config['endpoint'] : null;
                return new PepipostTransport($client, $pepipost_service_config['api_key'], $endpoint);
            
            });
        });
    }
}
