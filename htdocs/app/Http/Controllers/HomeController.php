<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = date('Y-m-d');
        $apiKey = 'd8300d4d6432628851a8c6934fcf3dbb';
        $movies = Movie::where('release_date', $today)->get();

        if (count($movies) > 0) {
            return view('home', compact('movies'));
        } else {

            $genreList = new \GuzzleHttp\Client();
            $genreListRequest = $genreList->get('https://api.themoviedb.org/3/genre/movie/list?api_key=' . $apiKey . '');
            $genreListResponse = json_decode($genreListRequest->getBody());
            $id = 1;
            $pageNr =  '&page=' . $id . '';
            $movies = new \GuzzleHttp\Client();
            $moviesRequest = $movies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $today . '' . $pageNr);
            $moviesResponse = json_decode($moviesRequest->getBody());
            $pages = $moviesResponse->total_pages;
            for ($i = 1; $i < $pages; $i++) {
                $getmovies = new \GuzzleHttp\Client();
                $Request = $getmovies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $today . '' . '&page=' . $i . '');
                $moviesResponse = json_decode($Request->getBody());
                foreach ($moviesResponse->results as $movie) {
                    // if ($movie->original_title == 'Tall Girl') {
                    //     // dd($movie->id);
                    // }
                    if ($movie->release_date == $today) {
                        $genreNameArray = array();
                        foreach ($genreListResponse->genres as $genre) {
                            $result = array_search($genre->id, $movie->genre_ids);
                            if (is_int($result)) {
                                $genreNameArray[] = $genre->name;
                            }
                        }
                        $store = [
                            'movie_id' => $movie->id,
                            'original_title' => $movie->original_title,
                            'genre' => implode(", ", $genreNameArray),
                            'release_date' => $movie->release_date
                        ];
                        Movie::updateOrCreate($store);
                    }
                }
            }
            $movies = Movie::where('release_date', $today)->get();
            return view('home', compact('movies'));
        }
    }
}
