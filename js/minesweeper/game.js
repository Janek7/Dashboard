'use strict';

class Game {

    /**
     * creates new game
     * @param height height of gameboard
     * @param width width of gameboard
     * @param mines amount of mines
     */
    constructor(height, width, mines) {

        this.fields = [];
        this.height = height;
        this.width = width;
        this.mines = mines;
        this.remainingMines = mines;
        this.ingame = true;
        this.difficulty = getSelectedDifficulty();
        this.firstFieldUncovered = false;
        this.tableElement = document.getElementById("gameboard");
        document.getElementById("mineCounter").innerHTML = this.remainingMines;
        this.timer = new Timer();
        this.generateGameboard();

    }

    /**
     * generates fields
     */
    generateGameboard() {

        var table = document.getElementById("gameboard");

        for (var rows = 0; rows < this.height; rows++) {
            var row = document.createElement("tr");
            row.setAttribute("id", "row" + rows);

            for (var cols = 0; cols < this.width; cols++) {
                var data = document.createElement("td");
                var newElement = document.createElement("img");
                newElement.setAttribute("id", rows + "-" + cols);
                this.fields.push(new Field(this, newElement, rows, cols));
                data.appendChild(newElement);
                row.appendChild(data);
            }
            table.appendChild(row);
        }

    }

    /**
     * spreads mines over the fields randomly
     */
    generateMines(clickedField) {

        for (var mineCounter = 0; mineCounter < this.mines; mineCounter++) {
            var field;
            do {
                var x = Math.floor(Math.random() * this.height);
                var y = Math.floor(Math.random() * this.width);
                field = getFieldFromPos(this, x, y);
            } while (field.isMine() || clickedField == field);
            field.fieldValue = FieldValueEnum.MINE;
        }
        this.computeFieldImages(clickedField);

    }

    /**
     * computes the number of mines around of each field and sets the image
     */
    computeFieldImages(clickedField) {

        for (var index in this.fields) {
            var field = this.fields[index];
            //mine images/minesweeper are already set
            if (!field.isMine()) {
                var positionsToCheck = getSurroundingPositions(this, field);
                var numberOfMinesAround = 0;
                for (var i in positionsToCheck) {
                    var pos = positionsToCheck[i];
                    var fieldFromPos = getFieldFromPos(this, pos.x, pos.y);
                    if (fieldFromPos.isMine()) numberOfMinesAround++;
                }

                switch (numberOfMinesAround) {
                    case 0:
                        field.fieldValue = FieldValueEnum.BLANK;
                        break;
                    case 1:
                        field.fieldValue = FieldValueEnum.ONE;
                        break;
                    case 2:
                        field.fieldValue = FieldValueEnum.TWO;
                        break;
                    case 3:
                        field.fieldValue = FieldValueEnum.THREE;
                        break;
                    case 4:
                        field.fieldValue = FieldValueEnum.FOUR;
                        break;
                    case 5:
                        field.fieldValue = FieldValueEnum.FIVE;
                        break;
                    case 6:
                        field.fieldValue = FieldValueEnum.SIX;
                        break;
                    case 7:
                        field.fieldValue = FieldValueEnum.SEVEN;
                        break;
                    case 8:
                        field.fieldValue = FieldValueEnum.EIGHT;
                        break;
                }
                if (field == clickedField && !field.isBlank()) {
                    for (var fieldIndex in this.fields) {
                        this.fields[fieldIndex].fieldValue = null;
                    }
                    this.generateMines(clickedField);
                }
            }
        }

    }

    /**
     * checks if all mines are marked with a flag
     * @returns {boolean}
     */
    checkWin() {

        var normalFields = [];
        for (var fieldIndex in this.fields) {
            var field = this.fields[fieldIndex];
            if (field.fieldValue != FieldValueEnum.MINE) normalFields.push(field);
        }
        for (var normalFieldIndex in normalFields) {
            var normalField = normalFields[normalFieldIndex];
            if (normalField.covered) return false;
        }
        return true;

    }

    /**
     * ends the game (timer stops and all mines become uncovered)
     */
    end(win, mine) {

        this.timer.stop();
        this.ingame = false;

        if (!win) {
            //uncovers all mines#
            //TODO: falsch gesetzte Flaggen beim Aufdecken anzeigen http://www.metrixx7.de/m/20723.png
            for (var index in this.fields) {
                var field = this.fields[index];
                if (field.isMine() && field.element != mine) field.uncover();
            }
        } else {
            writeRecordInCookie(this.difficulty, this.timer.seconds);
        }
        document.getElementById(win ? "winText" : "loseText").style.display = "block";

    }

    /**
     * updates mine counter
     */
    updateRemainingMineCounter() {
        document.getElementById("mineCounter").innerHTML = this.remainingMines;
    }

    /**
     * deletes the gameboard and stops the timer
     */
    delteGameBoard() {
        while(this.tableElement.rows.length>0) {
            this.tableElement.deleteRow(0);
        }
        this.timer.stop();
        document.getElementById("secCounter").innerHTML = "" + 0;
    }

}


class Field {

    /**
     * creates new Field
     * @param game game
     * @param element element of HTML document
     * @param x horizontal value
     * @param y vertical value
     */
    constructor(game, element, x, y) {

        this.game = game;
        this.element = element;
        this.pos = new Pos(x, y);
        this.covered = true;
        this.marked = false;
        this.fieldValue = null;
        this.setImage("images/minesweeper/field_covered.png");

        //adding eventlisteners
        var _this = this;
        this.element.onmousedown = function (ev) {
            switch (ev.which) {
                case 1:
                    if (_this.covered && !_this.marked && _this.game.ingame) {
                        _this.uncover();
                        //alert(_this.game.checkWin());
                        if (_this.game.checkWin()) _this.game.end(true);
                    } else {
                        ev.preventDefault();
                    }
                    break;
                case 3:
                    if (_this.game.ingame && _this.covered) {
                        if (_this.marked) _this.unmark();
                        else _this.mark();
                    }
                    ev.preventDefault();
                    break;
            }

        };

    }

    /**
     * uncovers field and blank fields around
     * call end of game if the field is a mine
     */
    uncover() {

        if (!this.game.firstFieldUncovered) {
            this.game.firstFieldUncovered = true;
            this.game.generateMines(this);
        }
        this.covered = false;
        this.setImage(FieldValueEnum.properties[this.fieldValue].imgpath);
        if (this.isMine() && this.game.ingame) {
            this.game.end(false, this.element);
            this.setImage("images/minesweeper/mine_false.png")
        }
        else if (this.isBlank()) this.uncoverNeighbours();

    }

    /**
     * uncovers all neighbours which are not mines
     */
    uncoverNeighbours() {

        var surroundingPositions = getSurroundingPositions(this.game, this);
        var surroundungFields = [];
        for (var indexPosition in surroundingPositions) {
            var surroundingPosition = surroundingPositions[indexPosition];
            surroundungFields.push(getFieldFromPos(this.game, surroundingPosition.x, surroundingPosition.y))
        }
        for (var indexFields in surroundungFields) {
            var surroundingField = surroundungFields[indexFields];
            if (surroundingField.covered) surroundingField.uncover();
        }
    }


    /**
     * marks field with a flag
     */
    mark() {

        this.marked = true;
        this.setImage("images/minesweeper/flag.png");
        this.game.remainingMines--;
        this.game.updateRemainingMineCounter();

    }

    /**
     * removes flag
     */
    unmark() {

        this.marked = false;
        this.setImage("images/minesweeper/field_covered.png");
        this.game.remainingMines++;
        this.game.updateRemainingMineCounter();

    }

    setImage(path) {
        this.element.setAttribute("src", path);
    }

    isMine() {
        return this.fieldValue == FieldValueEnum.MINE;
    }

    isBlank() {
        return this.fieldValue == FieldValueEnum.BLANK;
    }

}

/**
 * returns an array with all surrounding positions of a field
 * @param game game
 * @param field field
 * @returns {Array}
 */
function getSurroundingPositions(game, field) {

    var positionsToCheck = [];
    positionsToCheck.push(new Pos(field.pos.x, field.pos.y - 1));
    positionsToCheck.push(new Pos(field.pos.x, field.pos.y + 1));
    positionsToCheck.push(new Pos(field.pos.x - 1, field.pos.y));
    positionsToCheck.push(new Pos(field.pos.x + 1, field.pos.y));
    positionsToCheck.push(new Pos(field.pos.x + 1, field.pos.y + 1));
    positionsToCheck.push(new Pos(field.pos.x + 1, field.pos.y - 1));
    positionsToCheck.push(new Pos(field.pos.x - 1, field.pos.y + 1));
    positionsToCheck.push(new Pos(field.pos.x - 1, field.pos.y - 1));

    var surroundingPositionsInGameboard = [];
    for (var index in positionsToCheck) {
        var pos = positionsToCheck[index];
        //check if the positions are in the gameboard and if they are mines
        if (pos.x >= 0 && pos.x < game.height
            && pos.y >= 0 && pos.y < game.width) {
            surroundingPositionsInGameboard.push(pos);
        }
    }
    return surroundingPositionsInGameboard;

}

/**
 * search the field with the position
 * @param game Game
 * @param x horizontal value
 * @param y vertical value
 * @returns field
 */
function getFieldFromPos(game, x, y) {

    var field;
    for (var index in game.fields) {
        field = game.fields[index];
        if (field.pos.x == x && field.pos.y == y) {
            return field;
        }
    }
    return null;

}

var FieldValueEnum = {

    BLANK: 0,
    ONE: 1,
    TWO: 2,
    THREE: 3,
    FOUR: 4,
    FIVE: 5,
    SIX: 6,
    SEVEN: 7,
    EIGHT: 8,
    MINE: 9,

    properties: {
        0: {numberOfMinesAround: 0, imgpath: "images/minesweeper/field_blank.png"},
        1: {numberOfMinesAround: 1, imgpath: "images/minesweeper/numbers/one.png"},
        2: {numberOfMinesAround: 2, imgpath: "images/minesweeper/numbers/two.png"},
        3: {numberOfMinesAround: 3, imgpath: "images/minesweeper/numbers/three.png"},
        4: {numberOfMinesAround: 4, imgpath: "images/minesweeper/numbers/four.png"},
        5: {numberOfMinesAround: 5, imgpath: "images/minesweeper/numbers/five.png"},
        6: {numberOfMinesAround: 6, imgpath: "images/minesweeper/numbers/six.png"},
        7: {numberOfMinesAround: 7, imgpath: "images/minesweeper/numbers/seven.png"},
        8: {numberOfMinesAround: 8, imgpath: "images/minesweeper/numbers/eight.png"},
        9: {numberOfMinesAround: -1, imgpath: "images/minesweeper/mine.png"},
    }
};

class Pos {

    /**
     * creates a new Position
     * @param x horizontal value
     * @param y vertical value
     */
    constructor(x, y) {

        this.x = x;
        this.y = y;

    }

    toString() {
        return "(" + this.pos.x + "-" + this.pos.y + ")";
    }

}

class Timer {

    /**
     * creates a new Timer
     */
    constructor() {
        this.intervalFunction = null;
        this.seconds = 0;
        this.updateSeconds();
    }

    /**
     * updates the timer element every second
     */
    updateSeconds() {
        var _this = this;
        this.intervalFunction = setInterval(function () {
            _this.seconds = _this.seconds + 1;
            document.getElementById("secCounter").innerHTML = "" + _this.seconds;
        }, 1000);
    }

    /**
     * stops the timer and the end of the game
     */
    stop() {
        clearInterval(this.intervalFunction);
    }

}