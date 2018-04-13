<?php

namespace Jevets\WpApi;

use GuzzleHttp\Psr7\Response;

interface Responder
{
    /**
     * Build the response data
     *
     * @param null|\GuzzleHttp\Psr7\Response $response
     * @param mixed $error
     * @return array
     */
    public function respond($response = null, $error = null);
}
