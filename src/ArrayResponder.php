<?php

namespace Jevets\WpApi;

use GuzzleHttp\Psr7\Response;

class ArrayResponder implements Responder
{
    /**
     * Format the response data
     *
     * @param null|\GuzzleHttp\Psr7\Response $response
     * @param mixed $error
     * @return array
     */
    public function respond($response = null, $error = null)
    {
        return filled($error) ? $this->error($error) : $this->response($response);
    }

    /**
     * Respond with successful data
     *
     * @param \GuzzleHttp\Psr7\Response
     * @return array
     */
    protected function response(Response $response)
    {
        $data = json_decode((string) $response->getBody(), true);

        return [
            'data' => $data,
            'total' => $response->getHeader('X-WP-Total'),
            'pages' => $response->getHeader('X-WP-TotalPages'),
        ];
    }

    /**
     * Respond with an error
     *
     * @param array $error
     * @return array
     */
    protected function error($error)
    {
        return [
            'error' => $error,
            'data' => [],
            'total' => 0,
            'pages' => 0,
        ];
    }
}
