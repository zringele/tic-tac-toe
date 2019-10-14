$(document).ready(function() {
    let game = 0;
    let $chat = $('#chat');

    $('.tic').on('click', function (e) {
        if (game === 0) return;
        let $target = $(e.currentTarget)
        $target.html('X');
        $chat.html('computing best response...');

        $.post( "/game/"+game+"/move/" + $target.data('id'), function( data ) {
            $('.tic[data-id=' + data.response + ']').html('Y');
            $chat.html('Your turn');
        });
    });

    $('#play').on('click', function () {
        $.post( "/game/new" + $target.data('id'), function( data ) {
            $('.tic').each(function (key, hash) {
                $(hash).html('#');
            });
            $chat.html('Lets go!');
        });
    });
});