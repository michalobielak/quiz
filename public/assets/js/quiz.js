$(document).ready(function () {
    $.ajax({
        url: '/quiz/question',
        success: function(response) {
            $('#question').html(response)
        }
    });
});