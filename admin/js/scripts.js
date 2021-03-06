$(document).ready(function () {
    var userHref;
    var userHrefSplit;
    var userId;

    var imgSrc;
    var imgSrcSplit;
    var imgName;

    var photoId;

    // When a thumbnail is clicked, active the Apply Selection button, get the users id and the images filename
    $(".modal-thumbnails").click(function () {
        $("#set_user_image").prop('disabled', false);

        userHref = $("#user_id").prop('href');
        userHrefSplit = userHref.split("=");
        userId = userHrefSplit[userHrefSplit.length - 1];

        imgSrc = $(this).prop("src");
        imgSrcSplit = imgSrc.split("/");
        imgName = imgSrcSplit[imgSrcSplit.length - 1];

        photoId = $(this).attr("data");

        $.ajax({
            url: "includes/ajax_code.php",
            data: {photoId: photoId},
            type: "POST",
            success: function (data) {
                if (!data.error) {
                    $('#modal-sidebar').html(data);
                }
            }
        })
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

    // Slide the side info panel in edit photos and change the direction of the carat
    $(".info-box-header").click(function () {
        $(".inside").slideToggle("fast");
        $("#toggle").toggleClass("glyphicon glyphicon-menu-down glyphicon glyphicon-menu-up");
    });

    // Confirmation for deleting a photo
    $(".deleteLink").click(function () {
        return confirm("Are you sure you want to delete this item?");
    });

    // WYSIWYG editor
    tinymce.init({selector: 'textarea'});
});

