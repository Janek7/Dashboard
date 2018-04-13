'use strict';

//VERIFY MODAL
$(".verifiedLabel").click(function () {
    var _this = this;
    this.setAttribute("data-selected", "true");
    $("#verifyModalTitle").html("Verify Infos zu " + _this.dataset['user']);
    document.getElementById("verifyModalCheckBox").checked = this.dataset['verified'] == "1";
    if (this.dataset['verified'] == "1") {
        $("#verifier").html(this.dataset['verifier']);
        $("#verifyDate").html(this.dataset['verifydate']);
    } else {
        $("#verifierDiv").css("display", "None");
        $("#verifyDateDiv").css("display", "None");
    }
    $("#verifyModal").css("display", "block");
});

$("#closeVerifyModal").click(function () {
    closeVerifyModal();
});

$("#saveVerifyModalButton").click(function () {

    var label = getSelectedVerifyLabel();
    var verify = document.getElementById("verifyModalCheckBox").checked;
    var phpcall = "functions/verify.php?verify=" + (verify ? "1" : "0") + "&userid=" + label.dataset['userid'];
    $.get(phpcall, function (data, status) {
        var json = JSON.parse(data);
        for (var jsonKey in json) {
            label.setAttribute(jsonKey, json[jsonKey]);
        }
        label.setAttribute("class", "label verifiedLabel " + (verify ? "label-success" : "label-danger"));
        label.innerHTML = verify ? "Verfiziert" : "Unverfiziert";
        closeVerifyModal();
        $("#successAlertText").html("Der Verify Status von " + label.dataset['user'] + " wurde erfolgreich bearbeitet");
        $('#successAlertBox').css("display", "Block");
    });

});

function closeVerifyModal() {
    window.location.href = '#';
    $("#verifyModal").fadeOut();
    getSelectedVerifyLabel().setAttribute("data-selected", "false");
}

function getSelectedVerifyLabel() {
    const verifiedLabels = document.getElementsByClassName("verifiedLabel");
    for (var labelIndex in verifiedLabels) {
        if (labelIndex == "length") {
            break;
        }
        if (verifiedLabels[labelIndex].dataset['selected'] == "true") {
            return verifiedLabels[labelIndex];
        }
    }
}



//PERMISSION MODAL
$(".permLabel").click(function () {
    this.setAttribute("data-selected", "true");
    $("#permModalTitle").html("Permission Infos zu " + this.dataset['user']);
    const amountOfRoles = 5;
    for (var i = 1; i <= amountOfRoles; i++) {
        var datasetEntry = "role" + i.toString();
        var checkBox = "#role" + i.toString() + "Checkbox";
        if (this.dataset[datasetEntry] == "1") {
            //TODO: Neu Setzen geht, wird aber nicht angezeigt
            $(checkBox).attr("checked", "checked");
        }
    }

    $("#permModal").css("display", "block");
});

$("#closePermModal").click(function () {
    closePermModal();
});

$("#savePermModalButton").click(function () {

    var label = getSelectedPermLabel();
    const amountOfRoles = 5;
    var phpcall = "functions/updateRoles.php?userid=" + label.dataset['userid'] + "&";
    for (var i = 1; i <= amountOfRoles; i++) {
        var roleString = "role" + i.toString();
        var datasetEntry = roleString;
        var checkBoxString = roleString + "Checkbox";
        var checkBox = document.getElementById(checkBoxString);
        if (label.dataset[datasetEntry] == "1" && checkBox.checked == false){
            phpcall += i.toString() + "=remove&";
            label.setAttribute("data-" + roleString, "0");
        } else if (label.dataset[datasetEntry] == "0" && checkBox.checked == true){
            phpcall += i.toString() + "=add&";
            label.setAttribute("data-" + roleString, "1");
        }
        //checkBox.checked = false;
    }
    if (phpcall != "functions/updateRoles.php?") {
        $.get(phpcall, function (data, status) {
            $("#successAlertText").html("Die Permissions von " + label.dataset['user'] + " wurden erfolgreich bearbeitet");
            $('#successAlertBox').css("display", "Block");
        });
    }
    closePermModal();
    $(".roleCheckBox").prop("checked", false)

});

function closePermModal() {
    window.location.href = '#';
    $("#permModal").fadeOut();
}

function getSelectedPermLabel() {
    const permLabels = document.getElementsByClassName("permLabel");
    for (var labelIndex in permLabels) {
        if (labelIndex == "length") {
            break;
        }
        if (permLabels[labelIndex].dataset['selected'] == "true") {
            return permLabels[labelIndex];
        }
    }
}