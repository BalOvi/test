$(document).ready(function () {
    // alert('js file included');
    $(".details").click(function (e) {
        e.preventDefault();
        var movie_id = $(this).attr('data-movie-id');
        getmoviedetails(movie_id);
    });
});


function getmoviedetails(movie_id) {
    $.ajax({
        type: 'GET',
        url: "https://api.themoviedb.org/3/movie/" + movie_id + "?api_key=d8300d4d6432628851a8c6934fcf3dbb&language=en-US",
        dataType: 'json',
        cache: false,
        success: function (data) {
            $('#movie_name').text(data.original_title);
            $('#movie_overview').text(data.overview);
            $('#movie_popularity').text(data.popularity);
            $('#movie_vote_average').text(data.vote_average);
            $('#movie_vote_count').text(data.vote_count);
            $('#movie_status').text(data.status);
            $('#movie_language').text(data.original_language);
            var genrelist = '';
            $.each(data.genres, function (i, item) {
                genrelist += item.name + ", ";
            });
            $('#movie_genres').text(genrelist);
        }
    });

}
