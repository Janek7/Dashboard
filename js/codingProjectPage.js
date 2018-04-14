'use strict';

// Action Buttons
//DELETE STUFF
$("#deleteButton").click(function () {
    $("#delteModal").css("display", "block");
});


//CHANGE STATE STUFF
$("#changeStateButton").click(function () {
    $("#changeStateModal").css("display", "block");
});

$("#closeChangeStateModal").click(function () {
    $("#changeStateModal").fadeOut();
});

$("#saveChangeStateModalButton").click(function () {
    var newstate = $("#stateInput").val();
    var project = $("#project");
    if (newstate != project.data('state')) {
        var phpcall = "functions/changeCodingProjectState.php?newstate=" + newstate + "&projectid=" + project.data('id');
        alert(phpcall);
        $.get(phpcall, function (data, status) {
            $("#successAlertText").html("Der Status des Projekts wurde erfolgreich zu " + newstate + " geändert");
            $('#successAlertBox').css("display", "Block");
            var stateColor = $("#stateColor");
            var stateText = $("#stateText");
            if (newstate == "open") {
                stateText.html("In Bearbeitung");
                stateColor.class("bg-yellow");
                //Funktioniert net
                stateColor.removeClass("bg-green");
            } else {
                stateText.html("Fertiggestellt");
                stateColor.class("bg-green");
                //Funktioniert net
                stateColor.removeClass("bg-yellow");
            }
        });
    }
    $("#changeTitleModal").fadeOut();
});


//CHANGE TITLE STUFF
$("#changeTitleButton").click(function () {
    $("#changeTitleModal").css("display", "block");
});

$("#saveChangeTitleModalButton").click(function () {
    var newtitle = $("#titleInput").val();
    var project = $("#project");
    if (newtitle != project.data('title')) {
        var phpcall = "functions/changeCodingProjectTitle.php?newtitle=" + newtitle + "&projectid=" + project.data('id');
        $.get(phpcall, function (data, status) {
            $("#header").html(newtitle);
            $("#navText").html(newtitle);
            $("#successAlertText").html("Der Titel des Projekts wurde erfolgreich zu " + newtitle + " geändert");
            $('#successAlertBox').css("display", "Block");
        });
    }

    $("#changeTitleModal").fadeOut();
});

$("#closeChangeTitleModal").click(function () {
    $("#changeTitleModal").fadeOut();
});