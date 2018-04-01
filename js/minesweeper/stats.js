'use strict';

/**
 * get record of difficulty form cookie
 * @param difficulty selected difficulty
 * @returns {*} record as string
 */
function getRecord(difficulty) {

    var recordString = "";
    var cookieList = document.cookie.split("; ");
    for (var i in cookieList) {
        var kvpair = cookieList[i].split("=");
        var key = kvpair[0];
        var value = kvpair[1];
        if (key == difficulty) {
            recordString += value;
            return "" + value;
        }
    }

    return "-";
}

/**
 * changes record paragraph in HTML document
 * @param difficulty selected difficulty
 */
function setRecordText(difficulty) {

    var recordText = "Rekord Schwierigkeitsstufe ";
    if (difficulty == "beginner") recordText += "Anfänger";
    else if (difficulty == "intermediate") recordText += "Fortgeschritten";
    else if (difficulty == "expert") recordText += "Experte";
    recordText += ": " + getRecord(difficulty);

    document.getElementById("recordText").innerHTML = recordText;

}

/**
 * Writes game stats as new record in cookie if the game time is faster
 * @param difficulty selected difficulty
 * @param seconds game time
 */
function writeRecordInCookie(difficulty, seconds) {

    if (getRecord(difficulty) == "-" || seconds < getRecord(difficulty)) {
        document.cookie = difficulty + "=" + seconds;
        setRecordText(difficulty);
    }

}

/**
 * returns the selected difficulty
 * @returns {*} difficulty as string
 */
function getSelectedDifficulty() {

    if (document.getElementById("beginner").checked) return "beginner";
    else if (document.getElementById("intermediate").checked) return "intermediate";
    else if (document.getElementById("expert").checked) return "expert";

}