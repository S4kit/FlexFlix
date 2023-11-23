<?php

namespace App\Http\Controllers;

use App\Models\FavoriteSeries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['user' => $user, 'message' => 'User registered successfully'], 201);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);

        } catch (\Exception $e) {
            // Log the exception for further investigation
            \Log::error('User registration failed: ' . $e->getMessage());

            return response()->json(['error' => 'User registration failed. Please try again.'], 500);
        }
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json(['user' => $user, 'message' => 'User logged in successfully'], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }


    public function addFavoriteMovie($movieId)
    {
        $user = Auth::user();
        if (!$user->movies()->where('movie_id', $movieId)->exists()) {
            $favorite = new Favorite(['movie_id' => $movieId]);
            $user->movies()->save($favorite);
            return response()->json(['message' => 'Movie added to favorites successfully'], 200);
        } else {
            return response()->json(['message' => 'Movie already in favorites list'], 500);
        }
    }

    public function removeFavoriteMovie($movieId)
    {
        $user = Auth::user();

        if ($user->movies()->where('movie_id', $movieId)->exists()) {

            $user->movies()->where('movie_id', $movieId)->delete();
            return response()->json(['message' => 'Movie removed from favorites successfully'], 200);
        } else
            return response()->json(['message' => 'Movie is not in favorite list'], 500);

    }

    public function addFavoriteSerie($serieId)
    {
        $user = Auth::user();
        if (!$user->series()->where('series_id', $serieId)->exists()) {
            $favorite = new FavoriteSeries(['series_id' => $serieId]);
            $user->series()->save($favorite);
            return response()->json(['message' => 'TVShow added to favorites successfully'], 200);
        } else {
            return response()->json(['message' => 'TVShow already in favorites list'], 500);
        }
    }

    public function removeFavoriteSerie($serieId)
    {
        $user = Auth::user();

        if ($user->series()->where('series_id', $serieId)->exists()) {
            $user->series()->where('series_id', $serieId)->delete();
            return response()->json(['message' => 'TVShow removed from favorites successfully'], 200);
        } else
            return response()->json(['message' => 'TVShow is not in favorite list'], 500);

    }


    public function getFavoriteMoviesAndSeries()
    {
        try {
            $user = Auth::user();

            $favoriteMovies = $user->movies()->whereNotNull('movie_id')->get();
            $favoriteSeries = $user->series()->whereNotNull('series_id')->get();

            return response()->json([
                'favorite_movies' => $favoriteMovies,
                'favorite_series' => $favoriteSeries,
                'message' => 'Favorite movies and series fetched successfully',
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error fetching favorite movies and series: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch favorites. Please try again.'], 500);
        }
    }

}


