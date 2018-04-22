<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 02.04.2018
 * Time: 22:12
 */

$ocdingProjectTitle = "Kein Projekt";
$codingProjectSmallTitle = "Leider können keine Infos bereitgestellt werden :/";
if (isset($_GET['project'])) {
    $ocdingProjectTitle = $_GET['project'];
    $codingProjectSmallTitle = "Hier siehst du alle Infos zum Projekt " . $ocdingProjectTitle;
}

$pages = [
    'main' => new Page("Startseite", "Willkommen im Dashboard", "main",
        null, "", ""),
    'error' => new Page("Error", "Seite nicht gefunden :/", "error",
        null, "", ""),
    'test' => new Page("Test", "Nur zum Testen", "test", null,
        "", ""),
    'userManagement' => new Page("Nutzer", "Verwaltung der Nutzer", "userManagement",
        "4", "<link rel=\"stylesheet\" href=\"css/userManagement.css\">",
        "<script src=\"js/userManagementPage.js\"></script>"),
    'noperms' => new Page("Error", "Keine Berechtigungen :/", "noperms",
        null, "", ""),
    'codingMain' => new Page("Programmieren", "Hier siehst du generelle Infos",
        "codingMain", "2", "<link rel=\"stylesheet\" href=\"css/codingMain.css\">",
        "<script src=\"js/codingMainPage.js\"></script>"),
    'codingTimeline' => new Page("Timeline", "Zeitlicher Verlauf der Projekte", "codingTimeline",
        "2", "<link rel=\"stylesheet\" href=\"css/codingTimeline.css\">",
        "<script src=\"js/codingTimelinePage.js\"></script>"),
    'codingProject' => new Page($ocdingProjectTitle, $codingProjectSmallTitle, "codingProject",
        "2", "<link rel=\"stylesheet\" href=\"css/codingProject.css\">",
        "<script src=\"js/codingProjectPage.js\"></script>")
];

class Page
{

    private $name;
    private $headerSmall;
    private $fileName;
    private $viewPerm;
    private $extraCSSSheets;
    private $extraJSScripts;

    public function __construct($name, $headerSmall, $fileName, $viewPerm, $extraCSSSheets, $extraJSScripts)
    {
        $this->name = $name;
        $this->headerSmall = $headerSmall;
        $this->fileName = $fileName;
        $this->viewPerm = $viewPerm;
        $this->extraCSSSheets = $extraCSSSheets;
        $this->extraJSScripts = $extraJSScripts;
    }

    public function getTitle()
    {
        return $this->name . " | Dashboard";
    }

    public function getHeader()
    {
        return $this->name . "<small>" . $this->headerSmall . "</small>";
    }

    public function getViewPerm()
    {
        return $this->viewPerm;
    }

    public function getExtraCSSSheets()
    {
        return $this->extraCSSSheets;
    }

    public function getExtraJSScripts()
    {
        return $this->extraJSScripts;
    }

    public function getNavText()
    {
        return $this->name;
    }

    public function getContent()
    {
        include("pages/" . $this->fileName . ".php");
    }

}