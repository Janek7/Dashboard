'use strict';

$("#newProject").click(function () {
    $("#newProjectModal").css("display", "block");
});

$("#closeNewProjectModal").click(function () {
    $("#newProjectModal").fadeOut();
});

$("#timeInterval").html("Zeitraum: " + $(".label-info:last").html() + " - heute");

$(document).ready(function () {
    $.ajax({
        url : 'functions/codingMain/getLanguageDonut.php',
    }).done(function(data){
        Morris.Donut({
            element: 'languageDonut',
            data: JSON.parse(data),
            resize: true,
            colors: ['#d69700', '#af5500', '#09cd32','#d8cd00', '#4233a2', '#0060A2']
        });

    });
});