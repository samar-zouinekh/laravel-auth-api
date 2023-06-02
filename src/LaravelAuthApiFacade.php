<?php

namespace SamarZouinekh\LaravelAuthApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SamarZouinekh\LaravelAuthApi\Skeleton\SkeletonClass
 */
class LaravelAuthApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-auth-api';
    }
}
