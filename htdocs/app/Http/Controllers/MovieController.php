<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Movie;

class MovieController extends Controller
{
    public function store_php()
    {
        $apiKey = 'd8300d4d6432628851a8c6934fcf3dbb';
        $today = date('Y-m-d');
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
                //     dd($movie->id);
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
                        'release_date' => $movie->release_date,
                    ];
                    Movie::updateOrCreate($store);
                }
            }
        }
        $movies = Movie::where('release_date', $today)->get();
        return view('home', compact('movies'));
        // return View::make("home", compact($movies));
    }

    public function store_sql()
    {
        $uuid = (string) Str::uuid();
        $fuuid = str_replace("-", "", $uuid);

        $temporaryTable = DB::unprepared(DB::raw("CREATE TEMPORARY TABLE $fuuid (
            id INT PRIMARY KEY,
            original_title VARCHAR(255),
            genre VARCHAR(255),
            release_date DATE 
        )"));

        DB::table($fuuid)->insert(
            ['id' => 1, 'original_title' => "titlu", 'genre' => 'action', 'release_date' => '2019-09-12']
        );
        // $dropTable = DB::unprepared(DB::raw("DROP TEMPORARY TABLE TempTable"));

        $query = DB::table($fuuid)->select('original_title')->get();
        // dd($query);

        // $apiKey = 'd8300d4d6432628851a8c6934fcf3dbb';
        // $today = date('Y-m-d');
        // $getmovies = new \GuzzleHttp\Client();
        // $Request = $getmovies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $today . '' . '&page=' . $i . '');
        // $moviesResponse = json_decode($Request->getBody());
        // $pages = $moviesResponse->total_pages;


        // for ($i = 1; $i < $pages; $i++) {
        //     $getmovies = new \GuzzleHttp\Client();
        //     $Request = $getmovies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $today . '' . '&page=' . $i . '');
        //     $moviesResponse = json_decode($Request->getBody());
        //     foreach ($moviesResponse->results as $movie) {
        //         # code...
        //     }
        // DB::table($fuuid)->insert(
        //     ['id' => 1, 'original_title' => "titlu", 'genre' => 'action', 'release_date' => '2019-09-12']
        // );
        // $dropTable = DB::unprepared(DB::raw("DROP TEMPORARY TABLE TempTable"));

        // $query = DB::table($fuuid)->select('original_title')->get();
        // dd($query);
        // }
    }
}
