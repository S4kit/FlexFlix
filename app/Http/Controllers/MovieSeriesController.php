<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Pagination\Paginator;


//This Controller for Movies/Series Calls, its named MovieSeriesController

class MovieSeriesController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        //Intiate and prepare the call to the API
        $this->movieService = $movieService;
    }

    public function top5RatedMovies()
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $movies = $this->movieService->getMoviesRated();
        //create collection to display the top 5

        $movies = collect($movies);
        //take(5) displays first 5 in the collection
        $top5Movies = $movies->take(5);

        return response()->json(['movies' => $top5Movies, 'message' => 'Movies fetched successfully'], 201);
    }
    public function top5RatedSeries()
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $Series = $this->movieService->getSeriesRated();
        //create collection to display the top 5
        $Series = collect($Series);
        //take(5) displays first 5 in the collection
        $top5Series = $Series->take(5);

        return response()->json(['series' => $top5Series, 'message' => 'Series fetched successfully'], 201);
    }

    public function ShowMovies($page = 1)
    {
        //This sends a request to the movieService where the API call is prepared to be sent
        $movies = $this->movieService->getAllMovies($page);

        return response()->json(['movies' => $movies, 'message' => 'Movies fetched successfully'], 201);
    }

    public function ShowSeries($page = 1)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $movies = $this->movieService->getAllSeries($page);

        return response()->json(['movies' => $movies, 'message' => 'Movies fetched successfully'], 201);
    }

    public function ShowMoviesPage($page = 1)
    {
        $perPage = 10; // Number of items per page

        $allMovies = $this->movieService->getAllMovies($page);

        // Create a collection
        $moviesCollection = collect($allMovies);

        // Manually create a paginator instance with the specified page
        $paginatedMovies = new Paginator($moviesCollection, $perPage);

        $isFiltered = $paginatedMovies->count() === $perPage;

        return response()->json([
            'movies' => $paginatedMovies->items(),
            'is_filtered' => $isFiltered,
            'message' => 'Movies fetched successfully'
        ], 201);
    }

    public function ShowSeriesPage($page = 1)
    {
        $perPage = 10; // Number of items per page

        $allSeries = $this->movieService->getAllSeries($page);

        // Create a collection
        $seriesCollection = collect($allSeries);

        // Manually create a paginator instance with the specified page
        $paginatedSeries = new Paginator($seriesCollection, $perPage);

        $isFiltered = $paginatedSeries->count() === $perPage;

        return response()->json([
            'movies' => $paginatedSeries->items(),
            'is_filtered' => $isFiltered,
            'message' => 'Movies fetched successfully'
        ], 201);
    }

    public function search($query)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $movies = $this->movieService->searchMovies($query);
        $series = $this->movieService->searchSeries($query);

        return response()->json(['movies' => $movies, 'series' => $series], 200);
    }

    public function searchMovieByID($MovieId)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $movies = $this->movieService->findMovie($MovieId);

        return response()->json(['movies' => $movies], 200);
    }
    public function searchSerieByID($SerieId)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $series = $this->movieService->findSerie($SerieId);

        return response()->json(['Series' => $series], 200);

    }

    public function watchMovieTrailer($movieId)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $movieVideo = $this->movieService->watchMovieTrailer($movieId);

        return response()->json(['Movie Video Informations' => $movieVideo], 200);
        //we can redirect using concatination between site name and key of the video .
    }
    public function watchSerieTrailer($movieId)
    {
        //This sends a request to the movieService where the API call is prepared to be sent

        $serieVideo = $this->movieService->watchSerieTrailer($movieId);

        return response()->json(['Movie Video Informations' => $serieVideo], 200);
        //we can redirect using concatination between site name and key of the video .
    }

}
