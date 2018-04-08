var verifiedLabels = document.getElementsByClassName("verifiedLabel");
for (var index in verifiedLabels) {
    if (index == "length") break;
    const label = verifiedLabels[index];
    label.addEventListener("click", function(ev) {
        document.getElementById("verifyModalTitle").innerHTML = "Verify Infos zu " + label.dataset['user'];
        document.getElementById("verifyModalCheckBox").checked = label.dataset['verified'] == "1";
        if (label.dataset['verified'] == "1") {
            document.getElementById("verifier").innerHTML = label.dataset['verifier'];
            document.getElementById("verifyDate").innerHTML = label.dataset['verifydate'];
        } else {
            document.getElementById("verifierDiv").style.display = "None";
            document.getElementById("verifyDateDiv").style.display = "None";
        }
        document.getElementById("verifyModal").style.display = "block";
    });
}

document.getElementById("closeVerifyModal").addEventListener("click", function (ev) {
    document.getElementById("verifyModal").style.display = "None";
});

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
