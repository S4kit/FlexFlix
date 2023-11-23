<?php

namespace App\Services;

use GuzzleHttp\Client;

class MovieService
{
    protected $apiKey;
    protected $baseUrl;
    protected $client;

    public function __construct()
    {
        //Been using themoviesDB API
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = 'https://api.themoviedb.org/3/';
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getAllMovies($page = 1)
    {
        $response = $this->client->get('discover/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'page' => $page,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }
    public function getAllSeries($page = 1)
    {
        $response = $this->client->get('discover/tv', [
            'query' => [
                'api_key' => $this->apiKey,
                'page' => $page,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }
    public function getMoviesRated()
    {
        $response = $this->client->get('movie/top_rated', [
            'query' => [
                'api_key' => $this->apiKey,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }
    public function getSeriesRated()
    {
        $response = $this->client->get('tv/top_rated', [
            'query' => [
                'api_key' => $this->apiKey,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }

    public function searchMovies($query, $page = 1)
    {
        $response = $this->client->get('search/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => $query,
                'page' => $page,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }

    public function searchSeries($query, $page = 1)
    {
        $response = $this->client->get('search/tv', [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => $query,
                'page' => $page,
            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }

    public function findMovie($id)
    {
        $response = $this->client->get('movie/' . $id, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function findSerie($id)
    {
        $response = $this->client->get('tv/' . $id, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }

    public function watchMovieTrailer($id)
    {

        $response = $this->client->get('movie/' . $id . '/videos', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }
    public function watchSerieTrailer($id)
    {

        $response = $this->client->get('tv/' . $id . '/videos', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }

}
