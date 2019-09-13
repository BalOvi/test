<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class TestController extends Controller
{
    public function test()
    {

        $apiKey = 'd8300d4d6432628851a8c6934fcf3dbb';
        $date = date('Y-m-d');
        $genreList = new \GuzzleHttp\Client();
        // $request = $client->get('https://api.themoviedb.org/3/movie/now_playing?api_key=' . $apiKey . '');
        $genreListRequest = $genreList->get('https://api.themoviedb.org/3/genre/movie/list?api_key=' . $apiKey . '');
        $genreListResponse = json_decode($genreListRequest->getBody());
        foreach ($genreListResponse as $key => $value) {
            dd($value);
            # code...
        }
        $id = 1;
        $pageNr =  '&page=' . $id . '';
        $movies = new \GuzzleHttp\Client();
        $moviesRequest = $movies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $date . '' . $pageNr);
        $moviesResponse = json_decode($moviesRequest->getBody());

        foreach ($moviesResponse->results as $movie) {
            // dd($movie);
            foreach ($movie->genre_ids as $genreId) {
                dd($genreId);
            }
            $store = [
                'original_title' => $movie->original_title,
                'genre' => $movie->genre_ids

            ];
            Movie::create($store);
        }
        return 'see if it worked';
        // $pages = $moviesResponse->total_pages;

        // for ($i=0; $i < $pages; $i++) { 
        //     $getmovies = new \GuzzleHttp\Client();
        //     $Request = $getmovies->get('https://api.themoviedb.org/3/discover/movie?api_key=' . $apiKey . '&primary_release_date.gte=' . $date . '' . '&page=' . $i . '');
        //     $moviesResponse = json_decode($Request->getBody());
        // }
        // dd($pages);
    }
    public function store()
    {
        $v = $this->test();
        return $v;
        // dd($v);
    }
}
