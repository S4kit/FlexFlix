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
        //We get in here the informations provided from the user and validate depends on our rules
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
            // Here we create the user by saving the informations
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['user' => $user, 'message' => 'User registered successfully'], 201);

        } catch (ValidationException $e) {
            //Handle Errors
            return response()->json(['error' => $e->errors()], 422);

        } catch (\Exception $e) {
            // Log the exception for further investigation
            \Log::error('User registration failed: ' . $e->getMessage());

            return response()->json(['error' => 'User registration failed. Please try again.'], 500);
        }
    }



    public function login(Request $request)
    {
        //Validate the informations recieved from the User
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        //Using Auth to make attemption for the login if the informations provided matches the informations of the user from DB
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            //Grant the user an authentification
            $user = Auth::user();
            return response()->json(['user' => $user, 'message' => 'User logged in successfully'], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        //Grant the user LogginOut
        Auth::logout();

        return response()->json(['message' => 'User logged out successfully'], 200);
    }


    public function addFavoriteMovie($movieId)
    {
        //Get the user Information to add the movieID provided to Add to favoriteList
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
        //Get the user Information to add the movieID provided to remove from the favoriteList

        $user = Auth::user();

        if ($user->movies()->where('movie_id', $movieId)->exists()) {

            $user->movies()->where('movie_id', $movieId)->delete();
            return response()->json(['message' => 'Movie removed from favorites successfully'], 200);
        } else
            return response()->json(['message' => 'Movie is not in favorite list'], 500);

    }

    public function addFavoriteSerie($serieId)
    {
        //Get the user Information to add the serieID provided to add to the favoriteList

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
        //Get the user Information to add the serieId provided to remove from the favoriteList

        $user = Auth::user();

        if ($user->series()->where('series_id', $serieId)->exists()) {
            $user->series()->where('series_id', $serieId)->delete();
            return response()->json(['message' => 'TVShow removed from favorites successfully'], 200);
        } else
            return response()->json(['message' => 'TVShow is not in favorite list'], 500);

    }


    public function getFavoriteMoviesAndSeries()
    {

        //get all the favoriteList from Database and show it to the client
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


