$(document).ready(function () {
    var userHref;
    var userHrefSplit;
    var userId;

    $(".modal-thumbnails").click(function () {
        $("#set_user_image").prop('disabled', false);

        userHref = $("#user_id").prop('href');
        userHrefSplit = userHref.split("=");
        userId = userHrefSplit[userHrefSplit.length - 1];
        alert(userId);
    });


    tinymce.init({selector: 'textarea'});
});

