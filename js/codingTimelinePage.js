'use strict';

$("#newProject").click(function () {
    $("#newProjectModal").css("display", "block");
});

$("#closeNewProjectModal").click(function () {
    $("#newProjectModal").fadeOut();
});