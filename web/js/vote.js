$('.upvote').on('click', function () {
    var id = $(this).parents('.test').data('key');
    $.post(urlVoteUp, {"id": id}, function (data) {
        var result = JSON.parse(data);
        if (typeof result == 'object') {
            console.log(result.error);
        } else {
            var test = $('.test[data-key=' + id + ']');
            test.find('.upvote,.downvote').removeClass();
            test.find('.vote').html(result);
            $.pjax.reload('#liders_block', '');
        }
    });
});
$('.downvote').on('click', function () {
    var id = $(this).parents('.test').data('key');
    $.post(urlVoteDown, {"id": id}, function (data) {
        var result = JSON.parse(data);
        if (typeof result == 'object') {
            console.log(result.error);
        } else {
            var test = $('.test[data-key=' + id + ']');
            test.find('.upvote,.downvote').removeClass();
            test.find('.vote').html(result);
        }
    });
});

