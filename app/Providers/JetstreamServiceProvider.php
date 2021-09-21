<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Fortify::registerView(function () {

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 30,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "GET",
            //     CURLOPT_HTTPHEADER => array(
            //         "key: 65524197d6f41f9844e17954fb34dd1e"
            //     ),
            // ));

            // $response = curl_exec($curl);
            // $err = curl_error($curl);

            // curl_close($curl);
            // $response = json_decode($response);
            // $provinces = $response->rajaongkir->results;

            $provinces = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
            $provinces = json_decode($provinces);
            return view('auth.register', compact('provinces'));
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
