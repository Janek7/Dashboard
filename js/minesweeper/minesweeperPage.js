'use strict';

//settings stuff
document.getElementById("settingsButton").addEventListener("click", function (ev) {
    document.getElementById("settingsOutBox").style.display = "block";
});

document.getElementById("closeSettings").addEventListener("click", function (ev) {
    document.getElementById("settingsOutBox").style.display = "none";
});

document.getElementById("deleteRecords").addEventListener("click", function (ev) {
   document.cookie = "beginner=-";
   document.cookie = "intermediate=-";
   document.cookie = "expert=-";
   setRecordText(getSelectedDifficulty())
});

var beginnerRadioButton = document.getElementById("beginner");
var intermediateRadioButton = document.getElementById("intermediate");
var expertRadioButton = document.getElementById("expert");
var radioButtonList = [];
radioButtonList.push(beginnerRadioButton);
radioButtonList.push(intermediateRadioButton);
radioButtonList.push(expertRadioButton);

setRecordText(getSelectedDifficulty());

var changeTemplate = function (ev) {

    var widthValue;
    var heightValue;
    var mineValue;

    if (beginnerRadioButton.checked) {
        widthValue = 9;
        heightValue = 9;
        mineValue = 10;
    } else if (intermediateRadioButton.checked) {
        widthValue = 16;
        heightValue = 16;
        mineValue = 40;
    } else if (expertRadioButton.checked) {
        widthValue = 16;
        heightValue = 30;
        mineValue = 99;
    }

    document.getElementById("heightInput").setAttribute("value", widthValue);
    document.getElementById("widthInput").setAttribute("value", heightValue);
    document.getElementById("mineInput").setAttribute("value", mineValue);

    setRecordText(getSelectedDifficulty());

};

for (var radioButtonIndex in radioButtonList) {
    radioButtonList[radioButtonIndex].addEventListener("change", changeTemplate);
}
window.addEventListener("load", changeTemplate);

//Eingabeprüfungen
/*var inputElements = [document.getElementById("widthInput"), document.getElementById("heightInput"), document.getElementById("mineInput")];
var proofInput = function (ev) {
    for (var inputElementIndex in inputElements) {
        var inputElement = inputElements[inputElementIndex];
        alert(inputElement.value.match(/\d+/));
        if (inputElement.value.match(/^\d+$/) == null) {
            changeTemplate();
        }
    }
};
for (var inputElementIndex in inputElements) {
    inputElements[inputElementIndex].addEventListener("input", proofInput, false);
}*/



//new game stuff
var game;
document.getElementById("startNewGameButton").addEventListener("click", function (ev) {
    if (game != null) {
        game.delteGameBoard();
        document.getElementById("winText").style.display = "none";
        document.getElementById("loseText").style.display = "none";
    }
    game = new Game(document.getElementById("heightInput").getAttribute("value"),
        document.getElementById("widthInput").getAttribute("value"),
        document.getElementById("mineInput").getAttribute("value")
    );
});