'use strict';

// Action Buttons
//WORKSTEP STUFF
$("#closeNewWorkstepModal").click(function () {
    $("#newWorkstepModal").fadeOut();
});

$("#workstepButton").click(function () {
    $("#newWorkstepModal").css("display", "block");
});


//GIT STUFF
$("#closeGitModal").click(function () {
    $("#gitModal").fadeOut();
});

$("#gitButton").click(function () {
    $("#gitModal").css("display", "block");
});

$("#saveGitButton").click(function () {
    var gitModal = $("#gitModal");
    var clientValue = $("#gitclient").val();
    var repoNameValue = $("#repoNameInput").val();
    var repoLinkValue = $("#repoLinkInput").val();
    var phpcall = "functions/updateGitData.php?projectid=" + gitModal.data("projectid") + "&projecttitle="
        + gitModal.data("projecttitle") + "&";
    var basicPhpcall = phpcall;
    if (clientValue != gitModal.data("gitclient")) {
        phpcall += "gitClient=" + clientValue + "&";
    }
    if (repoNameValue != gitModal.data("gitreponame")) {
        phpcall += "repoName=" + repoNameValue + "&";
    }
    if (repoLinkValue != gitModal.data("gitrepolink")) {
        phpcall += "repoLink=" + repoLinkValue + "&";
    }
    if (phpcall != basicPhpcall) {
        alert(phpcall);
        $.get(phpcall);
    }
    gitModal.fadeOut();
});


//DELETE STUFF
$("#deleteButton").click(function () {
    $("#delteModal").css("display", "block");
});

$("#closeDeleteModal").click(function () {
    $("#delteModal").fadeOut();
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