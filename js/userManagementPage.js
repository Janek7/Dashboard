'use strict';

const verifiedLabels = document.getElementsByClassName("verifiedLabel");
$(".verifiedLabel").click(function () {
    this.setAttribute("data-selected", "true");

    document.getElementById("verifyModalTitle").innerHTML = "Verify Infos zu " + this.dataset['user'];
    document.getElementById("verifyModalCheckBox").checked = this.dataset['verified'] == "1";
    if (this.dataset['verified'] == "1") {
        document.getElementById("verifier").innerHTML = this.dataset['verifier'];
        document.getElementById("verifyDate").innerHTML = this.dataset['verifydate'];
    } else {
        document.getElementById("verifierDiv").style.display = "None";
        document.getElementById("verifyDateDiv").style.display = "None";
    }
    document.getElementById("verifyModal").style.display = "block";
});

$("#closeVerifyModal").click(function (ev) {
    $("#verifyModal").fadeOut();
    getSelectedLabel().setAttribute("data-selected", "false");
});

function getSelectedLabel() {
    for (var labelIndex in verifiedLabels) {
        if (labelIndex == "length") {
            break;
        }
        if (verifiedLabels[labelIndex].dataset['selected'] == "true") {
            return verifiedLabels[labelIndex];
        }
    }
}

$("#closeVerifyModalButton").click(function (ev) {

    var updatePage = function modifyPage(req, label, verify) {
        $("#verifyModal").fadeOut();
        /*var response = eval('(' + req.responseText+ ')');
        alert(response);*/
        //TODO: Label data attribute mit Infos aus JSON Rückgabe ändern
        label.setAttribute("class","label verifiedLabel " + (verify ? "label-success" : "label-danger"));
        label.innerHTML = verify ? "Verfiziert" : "Unverfiziert";
    };

    var req = getXmlHttpRequestObject();
    if((req.readyState == 4 || req.readyState == 0)) {
        var l = getSelectedLabel();
        var verify = document.getElementById("verifyModalCheckBox").checked;
        var phpcall = "functions/verify.php?verify=" + verify + "&userid=" + l.dataset['userid'];
        req.open('GET', phpcall, true);
        req.onreadystatechange = updatePage(req, l, verify);
        req.send();
    }

});

function getXmlHttpRequestObject() {
    if(window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        alert('Ajax funktioniert bei Ihnen nicht!');
    }
}


/*
var contentWithoutModals = document.querySelectorAll(":not(.modal-dialog *)");
for (var contentIndex in contentWithoutModals) {
    contentWithoutModals[contentIndex].addEventListener("click", function (ev) {
        var modals = document.getElementsByClassName("model-dialog");
        for (var modalIndex in modals) {
            alert("hi");
            //modals[modalIndex].style.display = "None";
        }

    });
}*/
