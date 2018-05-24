<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 21:20
 */

require 'Workstep.php';
global $conn;
global $languageLabelColors;
global $codingProjects;

$languageLabelColors = [
    "Java" => "bg-yellow-active",
    "HTML" => "bg-orange",
    "CSS" => "bg-green",
    "JavaScript" => "bg-yellow",
    "Python" => "bg-blue-active",
    "PHP" => "bg-purple",
    "Groovy" => "bg-brown",
    "TypeScript" => "bg-blue"
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
    private $gitRepoLink;
    private $gitRepoName;
    private $state;
    private $desc = [];
    private $languages = [];
    private $mainLanguage;
    private $workSteps = [];
    private $time;

    function __construct($project) {
        $this->id = $project['id'];
        $this->title = $project['title'];
        $this->startDate = new DateTime($project['start_date']);
        $this->gitClient = $project['git_client'];
        $this->gitRepoLink = $project['git_repo_link'];
        $this->gitRepoName = $project['git_repo_name'];
        $this->state = $project['state'];

        global $conn;

        $sqlGetProjectDesc = "SELECT id, text FROM coding_project_descriptions WHERE project_id = '$this->id';";
        $projectDescResult = $conn->query($sqlGetProjectDesc);
        while ($desc = $projectDescResult->fetch_assoc()) {
            $this->desc[$desc['id']] = $desc['text'];
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

        $sqlGetProjectWorksteps = "SELECT * FROM coding_worksteps WHERE project_id='$this->id' ORDER BY end_date DESC";
        $projectWorkstepResult = $conn->query($sqlGetProjectWorksteps);
        while ($workstep = $projectWorkstepResult->fetch_assoc()) {
            array_push($this->workSteps, new Workstep($workstep));
        }

        $sqlGetTime = "SELECT ROUND(SUM(TIMESTAMPDIFF(MINUTE, start_date, end_date))/60) as hours 
                              FROM coding_worksteps WHERE project_id = '$this->id'";
        $timeResult = $conn->query($sqlGetTime);
        $time = $timeResult->fetch_assoc();
        $this->time = $time['hours'] . " Stunde" . ($time['hours'] != "1" ? "n" : "");

    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        return $this->title = $title;
    }

    public function getStartDateObject() {
        return $this->startDate;
    }

    public function getStartDateText() {
        return $this->startDate->format("F Y");
    }

    public function getGitClient() {
        return $this->gitClient;
    }

    public function getGitRepoLink(){
        return $this->gitRepoLink;
    }

    public function getGitRepoName() {
        return $this->gitRepoName;
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

    public function setState($state) {
        return $this->state = $state;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getLanguages() {
        return $this->languages;
    }

    public function getLanguageLabels() {
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

    public function getWorkSteps() {
        return $this->workSteps;
    }

    public function getTime(): string {
        return $this->time != " Stunden" ? $this->time : "Nicht geloggt";
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

function getProjectFromId($id) {
    global $codingProjects;
    foreach ($codingProjects as $project) {
        if ($project->getId() == $id) {
            return $project;
        }
    }
    return null;
}