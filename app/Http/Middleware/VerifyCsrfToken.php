<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected function tokensMatch($request)
    {
        $token = $request->request->get('token');
        if ($token == null) {
            if (json_decode($request->request->get('payload'))->token === env('TOKEN', '')) {
                return true;
            }
        } else {
            if ($token === env('TOKEN', '')) {
                return true;
            }
        }

        return parent::tokensMatch($request); // TODO: Change the autogenerated stub
    }
}
