$(document).ready(function() {
    let game = 0;
    let $chat = $('#message');
    let playing = 0;
    $('.tic').on('click', function (e) {
        if (playing ===0){
            $chat.html('Start a new game');
        }
        if (game === 0) return;
        let $target = $(e.currentTarget)
        $target.html('X');
        $chat.html('computing best response...');

        $.post( "/game/"+game+"/move/" + $target.data('id'), function( data ) {
            $('.tic[data-id=' + data.response + ']').html('Y');
            $chat.html(data.message);
            playing = data.playing;
        });
    });

    $('#play').on('click', function () {
        $.post( "/game/new", function( data ) {
            $('.tic').each(function (key, hash) {
                $(hash).html('#');
            });
            game = data.game;
            playing = 1;
            $chat.html('Lets go!');
        });
    });
});