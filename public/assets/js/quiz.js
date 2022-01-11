$(document).ready(function () {
    var competence = $('#question').data('competence');
    $.ajax({
        url: '/quiz/question/' + competence,
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
    var competence = $('#question').data('competence');
    $.ajax({
        url:'/quiz/question/' + competence,
        type: "POST",
        data: form,
        async: true,
        success: function(response) {
            $('#question').html(response);
            init();
        }
    });
}