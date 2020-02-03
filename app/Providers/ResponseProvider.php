<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Response::macro('createdJson', function (bool $success, string $message = null) {
            $message = $message ?? ($success ? 'Object was created!' : 'Object wasn\'t created!');

            return Response::json(['success' => $success, 'message' => $message], 201);
        });

        Response::macro('updatedJson', function (bool $success, string $message = null) {
            $message = $message ?? ($success ? 'Object was updated!' : 'Object wasn\'t updated!');

            return Response::json(['success' => $success, 'message' => $message], 200);
        });

        Response::macro('deletedJson', function (bool $success, string $message = null) {
            $message = $message ?? ($success ? 'Object was deleted!' : 'Object wasn\'t deleted!');

            return Response::json(['success' => $success, 'message' => $message], 200);
        });

        Response::macro('successJson', function (bool $success, string $message) {
            return Response::json(['success' => $success, 'message' => $message], 200);
        });
    }
}
