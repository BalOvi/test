@extends('layouts.app')

@section('scripts')
<script src="/node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('public/js/modal.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1>Movie Details</h1>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Name:</th>
                                                <td id="movie_name"></td>
                                            </tr>
                                            <tr>
                                                <th>Overview:</th>
                                                <td id="movie_overview"></td>
                                            </tr>
                                            <tr>
                                                <th>Popularity:</th>
                                                <td id="movie_popularity"></td>
                                            </tr>
                                            <tr>
                                                <th>Vote average:</th>
                                                <td id="movie_vote_average"></td>
                                            </tr>
                                            <tr>
                                                <th>Vote count:</th>
                                                <td id="movie_vote_count"></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td id="movie_status"></td>
                                            </tr>
                                            <tr>
                                                <th>Poster:</th>
                                                <td id="movie_poster"></td>
                                            </tr>
                                            <tr>
                                                <th>Genres:</th>
                                                <td id="movie_genres"></td>
                                            </tr>
                                            <tr>
                                                <th>Language of the movie:</th>
                                                <td id="movie_language"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nr.</th>
                                <th scope="col">Title</th>
                                <th scope="col">Genre(s)</th>
                                <th scope="col">Release data</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movies as $movie)
                            <tr>
                                <th scope="row">{{$movie->id}}</th>
                                <td>{{$movie->original_title}}</td>
                                <td>{{$movie->genre}}</td>
                                <td>{{$movie->release_date}}</td>
                                <td><button class="button details" href="#" data-toggle="modal" data-target="#myModal"
                                        data-movie-id="{{$movie->movie_id}}">Details</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection