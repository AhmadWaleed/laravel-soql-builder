<?php

namespace AhmadWaleed\Soquel;

use UnexpectedValueException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class Soquel
{
    public static function authenticate(): array
    {
        $storage = ucwords(config('forrest.storage.type'));
        if (! in_array($storage, [ 'Session', 'Cache' ])) {
            throw new UnexpectedValueException("'$storage' is not a supported storage type for 'forrest.storage.type'. Please use 'Session' or 'Cache'.");
        }

        if (! $storage::has(config('forrest.storage.path') . 'token')) {
            config()->set('forrest.authentication', 'UserPassword');
            Forrest::authenticate();
        }

        return decrypt($storage::get(config('forrest.storage.path') . 'token'));
    }
}
