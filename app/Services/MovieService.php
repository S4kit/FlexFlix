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
        $this->apiKey = config('services.tmdb.api_key'); //API Key You have to add to your .env TMDB_API_KEY=YOUR_API_KEY_HERE
        $this->baseUrl = 'https://api.themoviedb.org/3/'; //This is the API Link
        $this->client = new Client(['base_uri' => $this->baseUrl]); //Initialize the HTTP client with the base URI for making requests to the MovieDB API
    }

    public function getAllMovies($page = 1)
    {
        /**
         * Send HTTP Request to the baseURL/discover/movie and as the query parameters we include our API key and the page number
         * we've set the page number = 1 as default
         */
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
        /**
         * Send HTTP Request to the baseURL/discover/tv and as the query parameters we include our API key and the page number
         * we've set the page number = 1 as default
         */
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
        /**
         * Send HTTP Request to the baseURL/movie/top_rated and as the query parameters we include our API key 
         * we've got the topRated then in Controller we take only 5 topRated
         */
        $response = $this->client->get('movie/top_rated', [
            'query' => [
                'api_key' => $this->apiKey,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }
    public function getSeriesRated()
    {
        /**
         * Send HTTP Request to the baseURL/tv/top_rated and as the query parameters we include our API key 
         * we've got the topRated then in Controller we take only 5 topRated
         */
        $response = $this->client->get('tv/top_rated', [
            'query' => [
                'api_key' => $this->apiKey,

            ],
        ]);

        return json_decode($response->getBody(), true)['results'];
    }

    public function searchMovies($query, $page = 1)
    {
        /**
         * Send HTTP Request to the baseURL/search/movie and as the query parameters we include our API key and the page number
         * Query variable in here represents the Title of the movie to show details
         */
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
        /**
         * Send HTTP Request to the baseURL/search/tv and as the query parameters we include our API key and the page number
         * Query variable in here represents the Title of the movie to show details
         */
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
        /**
         * Send HTTP Request to the baseURL/movie/IDofTheMovie and as the query parameters we include our API key and the page number
         * this link is different than others because the API endpoint in this situation is different
         */
        $response = $this->client->get('movie/' . $id, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function findSerie($id)
    {
        /**
         * Send HTTP Request to the baseURL/tv/IDofTheSerie and as the query parameters we include our API key and the page number
         * this link is different than others because the API endpoint in this situation is different
         */
        $response = $this->client->get('tv/' . $id, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }

    public function watchMovieTrailer($id)
    {
        /**
         * Send HTTP Request to the baseURL/movie/IDofTheSerie/videos and as the query parameters we include our API key and the page number
         * this link is different than others because the API endpoint in this situation is different
         */
        $response = $this->client->get('movie/' . $id . '/videos', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }
    public function watchSerieTrailer($id)
    {
        /**
         * Send HTTP Request to the baseURL/tv/IDofTheSerie/videos and as the query parameters we include our API key and the page number
         * this link is different than others because the API endpoint in this situation is different
         */
        $response = $this->client->get('tv/' . $id . '/videos', [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);

    }

}
