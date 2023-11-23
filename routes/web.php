<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieSeriesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('movies')->name('movies.')->group(function () {
    //In this prefix (localhost/movies/...) it has all things you can manipulate on movies action
    //each function is explained in the function that its related to the endpoint call
    Route::get('/{page?}', [MovieSeriesController::class, 'ShowMovies']);
    Route::get('/popular/top-5', [MovieSeriesController::class, 'top5RatedMovies']);
    Route::get('/filter/{page?}', [MovieSeriesController::class, 'ShowMoviesPage']);

    Route::prefix('favorites')->name('favorites.')->middleware(['auth'])->group(function () {
        Route::post('/add/{movieId}', [UserController::class, 'addFavoriteMovie']);
        Route::delete('/remove/{movieId}', [UserController::class, 'removeFavoriteMovie']);
    });

    Route::get('/search/{id}', [MovieSeriesController::class, 'searchMovieByID']);
    Route::get('/watch/{id}', [MovieSeriesController::class, 'watchMovieTrailer']);
});

Route::prefix('series')->name('series.')->group(function () {
    Route::get('/{page?}', [MovieSeriesController::class, 'ShowSeries']);
    Route::get('/popular/top-5', [MovieSeriesController::class, 'top5RatedSeries']);
    Route::get('/filter/{page?}', [MovieSeriesController::class, 'ShowSeriesPage']);

    Route::prefix('favorites')->name('favorites.')->middleware(['auth'])->group(function () {
        Route::post('/add/{serieId}', [UserController::class, 'addFavoriteSerie']);
        Route::delete('/remove/{serieId}', [UserController::class, 'removeFavoriteSerie']);
    });
    Route::get('/search/{id}', [MovieSeriesController::class, 'searchSerieByID']);
    Route::get('/watch/{id}', [MovieSeriesController::class, 'watchMovieTrailer']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [UserController::class, 'getFavoriteMoviesAndSeries']);
});

Route::get('/search/find/{query}', [MovieSeriesController::class, 'search']);

require __DIR__ . '/auth.php';







