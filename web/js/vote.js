$('.upvote').on('click', function () {
    var id = $(this).parents('.test').data('key');
    $.post(urlVoteUp, {"id": id}, function (data) {
        console.log(data);
        var result = JSON.parse(data);
        if (typeof result == 'object') {
            console.log(result.error);
        }
        $('.vote').html(result);
    });
});
$('.downvote').on('click', function () {
    var id = $(this).parents('.test').data('key');
    $.post(urlVoteDown, {"id": id}, function (data) {
        var result = JSON.parse(data);
        if (typeof result == 'object') {
            console.log(result.error);
        }
        $('.vote').html(result);
    });
});