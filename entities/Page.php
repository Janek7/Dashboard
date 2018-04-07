<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 02.04.2018
 * Time: 22:12
 */

$pages = [
    'main' => new Page("Startseite", "", "Willkommen im Dashboard", "main"),
    'error' => new Page("Error", "", "Seite nicht gefunden :/", "error"),
    'test' => new Page("Test", "", "Nur zum Testen", "test"),
    'userManagement' => new Page("Nutzer", "", "Verwaltung der Nutzer", "userManagement")
];

class Page {

    private $name;
    private $extraSheets;
    private $headerSmall;
    private $fileName;

    function __construct($name, $extraSheets, $headerSmall, $fileName) {
        $this->name = $name;
        $this->extraSheets = $extraSheets;
        $this->headerSmall = $headerSmall;
        $this->fileName = $fileName;
    }

    function getTitle() {
        return $this->name . " | Dashboard";
    }

    function getHeader() {
        return $this->name . "<small>" . $this->headerSmall . "</small>";
    }

    function hasExtraSheets() {
        return $this->extraSheets != "";
    }

    function getExtraSheets() {
        return $this->extraSheets;
    }

    function getNavText() {
        return $this->name;
    }

    function getContent() {
        return include("pages/" . $this->fileName . ".php");
    }

}