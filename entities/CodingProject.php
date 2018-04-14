<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 21:20
 */

global $conn;
global $languageLabelColors;
global $codingProjects;

$languageLabelColors = [
    "Java" => "bg-yellow-active",
    "HTML" => "bg-orange",
    "CSS" => "bg-green",
    "JavaScript" => "bg-yellow",
    "Python" => "bg-blue",
    "PHP" => "bg-purple",
    "Groovy" => "bg-brown"
];

$userid = $_SESSION['userid'];
$sqlGetProjects = "SELECT * FROM coding_projects WHERE user_id = '$userid' ORDER BY start_date DESC;";
$projectsResult = $conn->query($sqlGetProjects);
$codingProjects = [];
while ($project = $projectsResult->fetch_assoc()) {
    array_push($codingProjects, new CodingProject($project));
}

class CodingProject {

    private $id;
    private $title;
    private $startDate;
    private $gitClient;
    private $gitRepo;
    private $state;
    private $desc = [];
    private $languages = [];
    private $mainLanguage;

    function __construct($project) {
        $this->id = $project['id'];
        $this->title = $project['title'];
        $this->startDate = new DateTime($project['start_date']);
        $this->gitClient = $project['git_client'];
        $this->gitRepo = $project['git_repo'];
        $this->state = $project['state'];

        global $conn;

        $sqlGetProjectDesc = "SELECT text FROM coding_project_descriptions WHERE project_id = '$this->id';";
        $projectDescResult = $conn->query($sqlGetProjectDesc);
        while ($desc = $projectDescResult->fetch_assoc()) {
            array_push($this->desc, $desc['text']);
        }

        $sqlGetProjectLanguages = "SELECT cl.name, cpl.main FROM coding_projects cp JOIN coding_project_languages cpl 
                          ON cp.id = cpl.project_id JOIN coding_languages cl ON cpl.language_id = cl.id WHERE project_id = '$this->id';";
        $projectLanguageResult = $conn->query($sqlGetProjectLanguages);
        while ($language = $projectLanguageResult->fetch_assoc()) {
            array_push($this->languages, $language['name']);
            if ($language['main'] == "1") {
                $this->mainLanguage = $language['name'];
            }
        }

    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getStartDateObject(): DateTime {
        return $this->startDate;
    }

    public function getStartDateText() {
        return $this->startDate->format("F Y");
    }

    public function getGitClient() {
        return $this->gitClient;
    }

    public function getGitRepo(){
        return $this->gitRepo;
    }

    public function getGitIcon() {
        switch ($this->gitClient) {
            case "Github":
                return "fa-github";
            case "Bitbucket":
                return "fa-bitbucket";
            default:
                return "fa-code-fork";
        }
    }

    public function getState() {
        return $this->state;
    }

    public function getStateText() {
        switch ($this->state) {
            case "open":
                return "In Bearbeitung";
            case "closed":
                return "Fertiggestellt";
            default:
                return null;
        }
    }

    public function getStateLabel() {
        $stateLabelColor = null;
        switch ($this->state) {
            case "open":
                $stateLabelColor = "success";
                break;
            case "closed":
                $stateLabelColor = "danger";
                break;
            default:
                return null;
        }
        return "<span class=\"label label-" . $stateLabelColor ."\">" . $this->getStateText() . "</span>";
    }

    public function getStateColor() {
        switch ($this->state) {
            case "open":
                return "yellow";
            case "closed":
                return "green";
            default:
                return null;
        }
    }

    public function getDesc(): array {
        return $this->desc;
    }

    public function getLanguages(): array {
        return $this->languages;
    }

    public function getLanguageLabels(): array {
        global $languageLabelColors;
        $labels = [];
        foreach ($this->languages as $language) {
            array_push($labels, "<span class=\"label " . $languageLabelColors[$language] . "\">" . $language . "</span>");
        }
        return $labels;
    }

    public function getMainLanguage() {
        return $this->mainLanguage;
    }

}

function getProjectFromTitle($title) {
    global $codingProjects;
    foreach ($codingProjects as $project) {
        if ($project->getTitle() == $title) {
            return $project;
        }
    }
    return null;
}