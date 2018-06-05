'use strict';

$("#testButton").click(function () {
    alert("test");
});

$("#closeUploadImgModal").click(function () {
    $("#uploadImgModal").fadeOut();
});


$("#uploadImgBtn").click(function () {
    $("#uploadImgModal").css("display", "block");
});
