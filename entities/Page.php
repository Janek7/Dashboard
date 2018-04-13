<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 02.04.2018
 * Time: 22:12
 */

$pages = [
    'main' => new Page("Startseite", "Willkommen im Dashboard", "main",
        "", "", ""),
    'error' => new Page("Error", "Seite nicht gefunden :/", "error",
        "", "", ""),
    'test' => new Page("Test", "Nur zum Testen", "test", "",
        "", ""),
    'userManagement' => new Page("Nutzer", "Verwaltung der Nutzer", "userManagement",
        "4", "<link rel=\"stylesheet\" href=\"css/userManagement.css\">",
        "<script src=\"js/userManagementPage.js\"></script>"),
    'noperms' => new Page("Error", "Keine Berechtigungen :/", "noperms",
        "", "", "")
];

class Page {

    private $name;
    private $headerSmall;
    private $fileName;
    private $viewPerm;
    private $extraCSSSheets;
    private $extraJSScripts;

    public function __construct($name, $headerSmall, $fileName, $viewPerm, $extraCSSSheets, $extraJSScripts) {
        $this->name = $name;
        $this->headerSmall = $headerSmall;
        $this->fileName = $fileName;
        $this->viewPerm = $viewPerm;
        $this->extraCSSSheets = $extraCSSSheets;
        $this->extraJSScripts = $extraJSScripts;
    }

    public function getTitle() {
        return $this->name . " | Dashboard";
    }

    public function getHeader() {
        return $this->name . "<small>" . $this->headerSmall . "</small>";
    }

    public function getViewPerm() {
        return $this->viewPerm;
    }

    public function getExtraCSSSheets() {
        return $this->extraCSSSheets;
    }

    public function getExtraJSScripts() {
        return $this->extraJSScripts;
    }

    public function getNavText() {
        return $this->name;
    }

    public function getContent() {
        return include("pages/" . $this->fileName . ".php");
    }

}