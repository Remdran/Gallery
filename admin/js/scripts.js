$(document).ready(function () {
    var userHref;
    var userHrefSplit;
    var userId;

    var imgSrc;
    var imgSrcSplit;
    var imgName;

    // When a thumbnail is clicked, active the Apply Selection button, get the users id and the images filename
    $(".modal-thumbnails").click(function () {
        $("#set_user_image").prop('disabled', false);

        userHref = $("#user_id").prop('href');
        userHrefSplit = userHref.split("=");
        userId = userHrefSplit[userHrefSplit.length - 1];

        imgSrc = $(this).prop("src");
        imgSrcSplit = imgSrc.split("/");
        imgName = imgSrcSplit[imgSrcSplit.length - 1];
    });

    // When the Apply Selection button is pressed send the imgName and userId via Ajax
    $("#set_user_image").click(function () {
        $.ajax({
            url: "includes/ajax_code.php",
            data: {imgName: imgName, userId: userId},
            type: "POST",
            success: function (data) {
                if (!data.error) {
                    var fixed = data.split(";");
                    var fixednew = fixed[fixed.length - 1]; // FIND THE ";" ERROR AND CHANGE FIXEDNEW TO DATA ON THE LINE BELOW
                    $(".user_img_div a img").prop("src", fixednew);
                }
            }
        })
    });


    tinymce.init({selector: 'textarea'});
});

