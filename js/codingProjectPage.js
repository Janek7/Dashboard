'use strict';

//DESC STUFF
//Kleine Buttons
$(".descEditBtn").click(function () {
    alert("soon");
});

$(".descRemoveBtn").click(function () {
    var descid = this.dataset['descid'];
    var phpcall = "functions/codingProject/deleteDesc.php?descid=" + descid;
    $.get(phpcall, function () {
        var desc = $("#desc" + descid);
        var descText = desc.text();
        desc.remove();
        $("#successAlertText").html("Die Beschreibung '" + descText + "' wurde erfolgreich gelöscht!");
        $('#successAlertBox').css("display", "Block");
    })
});

//Desc Add
$("#addDescButton").click(function () {
    $("#newDescModal").css("display", "block");
});

$("#closeNewDescModal").click(function () {
    $("#newDescModal").fadeOut();
});

$("#saveNewDesc").click(function () {
    var textVal = $("#descText").val();
    if (textVal != "") {
        var phpcall = "functions/codingProject/insertDesc.php?projectId=" + $("#project").data("id") + "&descText=" + textVal;
        $.get(phpcall, function (data, status) {
            var json = JSON.parse(data);
            var newElement = "<li id='desc" + json['id'] + "'>" + json['text'] + "<span class='pull-right'>" +
                "<button class='btn btn-xs descEditBtn' data-descid='" + json['id'] + "'><i class='fa fa-pencil'></i></button>" +
                "<button class='btn btn-xs descRemoveBtn' data-descid='" + json['id'] + "'><i class='fa fa-ban'></i></button>" +
                "</span></li>";
            $("#descList").append(newElement);
            $("#successAlertText").html("Die Beschreibung '" + textVal + "' wurde erfolgreich hinzugefügt!");
            $('#successAlertBox').css("display", "Block");
        });
    }
    $("#newDescModal").fadeOut();
});


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
    var phpcall = "functions/codingProject/updateGitData.php?projectid=" + gitModal.data("projectid") + "&projecttitle="
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
        var phpcall = "functions/codingProject/changeCodingProjectState.php?newstate=" + newstate + "&projectid="
            + project.data('id');
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
        var phpcall = "functions/codingProject/changeCodingProjectTitle.php?newtitle=" + newtitle + "&projectid="
            + project.data('id');
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