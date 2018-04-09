<?php

use Jevets\WpApi\WpApi;

if (!function_exists('wpapi')) {
    /**
     * Get an instance of the WpApi facade
     *
     * @return \Jevets\WpApi\WpApi
     */
    function wpapi()
    {
        return app(Jevets\WpApi\WpApi::class);
    }
}
