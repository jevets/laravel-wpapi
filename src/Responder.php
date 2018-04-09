<?php

namespace Jevets\WpApi;

use GuzzleHttp\Psr7\Response;

interface Responder
{
    /**
     * Respond with successful data
     *
     * @param \GuzzleHttp\Psr7\Response $response
     * @return array
     */
    public function success(Response $response);

    /**
     * Respond with an error
     *
     * @param \Exception $error
     * @return array
     */
    public function error($error);
}
