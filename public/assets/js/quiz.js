$(document).ready(function () {
    $.ajax({
        url: '/quiz/question',
        success: function(response) {
            $('#question').html(response);
            init();
        }
    });

});
function init() {
    $('#answer_Odpowiedz').on('click', submitForm);
}
function submitForm(el) {
    form = $('#answer_form').serialize();

    $.ajax({
        url:'/quiz/question',
        type: "POST",
        dataType: "json",
        data: form,
        async: true,
        success: function(response) {
            $('#question').html(response)
        }
    });
}