<?php

namespace Laravel\Passport;

use Illuminate\Support\Arr;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('passport.features', []));
    }

    /**
     * Determine if the application is using access token feature.
     *
     * @return bool
     */
    public static function hasAccessTokenFeature()
    {
        return static::enabled(static::accessToken());
    }

    /**
     * Determine if the application is using the authorization feature.
     *
     * @return bool
     */
    public static function hasAuthorizationFeature()
    {
        return static::enabled(static::authorization());
    }

    /**
     * Determine if the application is using the clients feature.
     *
     * @return bool
     */
    public static function hasClientsFeature()
    {
        return static::enabled(static::clients());
    }

    /**
     * Determine if the application has personal access token enabled.
     *
     * @return bool
     */
    public static function hasPersonalAccessTokenFeature()
    {
        return static::enabled(static::personalAccessToken());
    }

    /**
     * Determine if the application has transient token enabled.
     *
     * @return bool
     */
    public static function hasTransientTokenFeature()
    {
        return static::enabled(static::transientToken());
    }

    /**
     * Enable the clients feature.
     *
     * @return string
     */
    public static function clients()
    {
        return 'clients';
    }

    /**
     * Enable the authorization feature.
     *
     * @return string
     */
    public static function authorization()
    {
        return 'authorization';
    }

    /**
     * Enable the access token feature.
     *
     * @return string
     */
    public static function accessToken()
    {
        return 'access-token';
    }

    /**
     * Enable the personal access token feature.
     *
     * @return string
     */
    public static function personalAccessToken()
    {
        return 'personal-access-token';
    }

    /**
     * Enable the transient token feature.
     *
     * @return string
     */
    public static function transientToken()
    {
        return 'transient-token';
    }
}
