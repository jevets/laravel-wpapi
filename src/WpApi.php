<?php

namespace Jevets\WpApi;

use GuzzleHttp\Client;
use Illuminate\Support\Traits\Macroable;
use GuzzleHttp\Exception\TransferException;

class WpApi
{
    use Macroable;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Jevets\WpApi\Responder
     */
    protected $responder;

    /**
     * Create a new instance
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client([
            'base_uri' => array_get($config, 'base_uri'),
            'timeout' => array_get($config, 'timeout', 2.0),
        ]);

        $responder = array_get($config, 'responder');

        if (!class_exists($responder)) {
            $responder = ArrayResponder::class;
        }

        $this->responder = app()->make($responder);
    }

    /**
     * Fetch Posts
     *
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function posts(array $query = [])
    {
        return $this->get('posts', $query);
    }

    /**
     * Fetch Pages
     *
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function pages(array $query = [])
    {
        return $this->get('pages', $query);
    }

    /**
     * Fetch Taxonomies
     *
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function taxonomies(array $query = [])
    {
        return $this->get('taxonomies', $query);
    }

    /**
     * Fetch Categories
     *
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function categories(array $query = [])
    {
        return $this->get('categories', $query);
    }

    /**
     * Fetch Tags
     *
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function tags(array $query = [])
    {
        return $this->get('tags', $query);
    }

    /**
     * Fetch Custom Taxonomy terms
     *
     * @param string $taxonomy
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function terms($taxonomy, array $query = [])
    {
        return $this->get(strtolower($taxonomy), $query);
    }

    /**
     * Fetch a single Post
     *
     * @param mixed $identifier
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function post($identifier, array $query = [])
    {
        $uri = 'posts';

        if (is_numeric($identifier)) {
            $uri = sprintf('posts/%d', $identifier);
        } else {
            $arguments['slug'] = $identifier;
        }

        return $this->get($uri, $query);
    }

    /**
     * Make a GET request and return an array
     *
     * @param string $uri
     * @param array $query
     * @return \Jevets\WpApi\Responder
     */
    public function get($uri, array $query = [])
    {
        try {
            $response = $this->client->get($uri, compact('query'));
        } catch (TransferException $e) {
            $error['message'] = $e->getMessage();

            if ($e->getResponse()) {
                $error['code'] = $e->getResponse()->getStatusCode();
            }

            return $this->responder->respond($e->getResponse(), $error);
        }

        return $this->responder->respond($response);
    }
}
