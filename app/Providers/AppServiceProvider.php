<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
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
            $client = new Client(['base_uri' => 'https://localhost:8443/api/']);
            $res = $client->request('GET', 'Bank', ["verify" => false]);
            // echo $res->getStatusCode();
            $body = $res->getBody();

            $content = json_encode($body->getContents());
            $data1 = json_decode($content, true); // Convert JSON to an associative array
            $data = json_decode($data1, true); // Convert JSON to an associative array
            $results = $data['bankInfos'];

            $menu = config('adminlte.menu');
            foreach ($results as $result){
                $menu[] = [
                    'text' => Str::upper($result["bankName"]),
                    'url'  => '/banks/' . $result["id"],
                    'icon' => 'fas fa-sm fa-building',
                    'label_color' => 'white',
                ];
            }

            // $menu[] = [
            //         'text' => "Contact Us",
            //         'url'  => '/contact-us',
            //         'icon' => 'fas fa-sm fa-paper-plane',
            //         'label_color' => 'white',
            //     ];
            // $menu[] = [
            //         'text' => "Privacy Policy",
            //         'url'  => '/privacy-policy',
            //         'icon' => 'fas fa-sm fa-lock',
            //         'label_color' => 'white',
            //     ];


            config(['adminlte.menu' => $menu]);
            // dd($menu);

    }
}
