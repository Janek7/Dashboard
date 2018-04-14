<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 13.04.2018
 * Time: 22:38
 */

global $conn;
$userid = $_SESSION['userid'];
$sqlGetProjects = "SELECT * FROM coding_projects WHERE user_id = '$userid' ORDER BY start_date DESC;";
$projectsResult = $conn->query($sqlGetProjects);

$months = [""];
$labelColors = [
    "Java" => "bg-yellow-active",
    "HTML" => "bg-orange",
    "CSS" => "bg-green",
    "JavaScript" => "bg-yellow",
    "Python" => "bg-blue",
    "PHP" => "bg-purple",
    "Groovy" => "bg-brown"
];

?>

<ul class="timeline">

    <?php while ($project = $projectsResult->fetch_assoc()):
        $projectId = $project['id'];
        $sqlGetProjectLanguages = "SELECT cl.name, cpl.main FROM coding_projects cp JOIN coding_project_languages cpl 
                          ON cp.id = cpl.project_id JOIN coding_languages cl ON cpl.language_id = cl.id WHERE project_id = '$projectId';";
        $projectLanguageResult = $conn->query($sqlGetProjectLanguages);
        $projectLanguages = [];
        while ($language = $projectLanguageResult->fetch_assoc()) {
            array_push($projectLanguages, $language);
        }
        $mainLanguageColor = null;
        foreach ($projectLanguages as $language) {
            if ($language['main'] == "1") {
                $mainLanguageColor = $labelColors[$language['name']];
            }
        }
        $projectStartDate = new DateTime($project['start_date']);
        $yearMonthString = date_format($projectStartDate, "y-m");
        ?>
        <!-- Month -->
        <?php if (!in_array($yearMonthString, $months)): ?>
        <li class="time-label">
                <span class="bg-green">
                    <?php echo  $projectStartDate->format("F Y");?>
                </span>
        </li>
        <?php
        array_push($months, $yearMonthString);
        endif;
        ?>
        <!-- Project -->
        <li>
            <i class="fa fa-code <?php echo $mainLanguageColor; ?>"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-bitbucket"></i><a target="_blank"
                                                                     href="<?php echo $project['git_repo'] ?>">
                        <?php echo $project['git_client']; ?></a></span>
                <h3 class="timeline-header"><a href="#"><?php echo $project['title']; ?></a></h3>
                <div class="timeline-body">
                    <?php
                    $stateLabelColor = null;
                    $state = null;
                    if ($project['state'] == "open") {
                        $stateLabelColor = "label-success";
                        $state = "In Bearbeitung";
                    } else if ($project['state'] == "closed") {
                        $stateLabelColor = "label-danger";
                        $state = "Fertig";
                    }
                    ?>
                    <p><b>Status: </b><span class="label <?php echo $stateLabelColor; ?>"><?php echo $state; ?></span>
                    </p>
                    <b>Beschreibung:</b>
                    <ul>
                        <?php
                        $sqlGetProjectDesc = "SELECT text FROM coding_project_descriptions WHERE project_id = '$projectId';";
                        $projectDescResult = $conn->query($sqlGetProjectDesc);
                        while ($desc = $projectDescResult->fetch_assoc()) {
                            echo "<li>" . $desc['text'] . "</li>";
                        }
                        ?>
                    </ul>
                    <p>
                        <b>Sprachen:</b>
                        <?php
                        foreach ($projectLanguages as $language) {
                            echo "<span class=\"label " . $labelColors[$language['name']] . "\">" . $language['name'] . "</span>";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </li>
    <?php endwhile; ?>
    <!-- April -->
    <li class="time-label">
        <span class="bg-green">
            April 2018
        </span>
    </li>

    <!-- UIP -->
    <li>
        <i class="fa fa-code bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-bitbucket"></i><a target="_blank"
                                                                 href="https://bitbucket.org/sprintathleten/projekt_1/src"> Bitbucket</a></span>
            <h3 class="timeline-header"><a href="#">UIP</a></h3>
            <div class="timeline-body">
                <b>Beschreibung:</b>
                <ul>
                    <li>Laden und Aufbereitung von Datensätzen</li>
                    <li>Implementierung der Machine Learning Methoden k nearest neighbour, support vector machine,
                        random forest und naive bayes
                    </li>
                    <li>Berechnen der Features einer User Story</li>
                    <li>Testroutinen der Machine Learning Methoden</li>
                </ul>
                <p><b>Sprachen:</b>
                    <span class="label bg-blue">Python</span>
                    <span class="label bg-orange">HTML</span>
                </p>
            </div>
        </div>
    </li>

    <!-- Dashboard -->
    <li>
        <i class="fa fa-code bg-purple"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-github"></i><a target="_blank"
                                                              href="https://github.com/Janek7/Dashboard"> Github</a></span>
            <h3 class="timeline-header"><a href="#">Dashboard</a></h3>
            <div class="timeline-body">
                <p><b>Beschreibung:</b> Logging und Darstellung von verschiedenen Daten</p>
                <p><b>Sprachen: </b>
                    <span class="label bg-purple">PHP</span>
                    <span class="label bg-yellow">JavaScript</span>
                    <span class="label bg-orange">HTML</span>
                    <span class="label bg-green">CSS</span></p>
            </div>
        </div>
    </li>

    <!-- März -->
    <li class="time-label">
        <span class="bg-green">
            März 2018
        </span>
    </li>

    <!-- UIP APWI -->
    <li>
        <i class="fa fa-code bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-github"></i><a target="_blank" href="https://github.com/Janek7/UIP-APWI"> Github</a></span>
            <h3 class="timeline-header"><a href="#">UIP APWI</a></h3>
            <div class="timeline-body">
                <b>Beschreibung:</b>
                <ul>
                    <li>Laden und Aufbereitung von Datensätzen</li>
                    <li>Implementierung der Machine Learning Methoden k nearest neighbour, support vector machine und
                        random forest
                    </li>
                </ul>
                <p><b>Sprachen: </b>
                    <span class="label bg-blue">Python</span>
                    <span class="label bg-orange">HTML</span>
                </p>
            </div>
        </div>
    </li>

    <!-- Minesweeper -->
    <li>
        <i class="fa fa-code bg-yellow"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-github"></i><a target="_blank"
                                                              href="https://github.com/Janek7/Minesweeper"> Github</a></span>
            <h3 class="timeline-header"><a href="#">Minesweeper</a></h3>
            <div class="timeline-body">
                <p><b>Beschreibung:</b> Minesweeper in JavaScript</p>
                <p><b>Sprachen: </b>
                    <span class="label bg-yellow">JavaScript</span>
                    <span class="label bg-orange">HTML</span>
                    <span class="label bg-green">CSS</span>
                </p>
            </div>
        </div>
    </li>

    <!-- Februar -->
    <li class="time-label">
        <span class="bg-green">
            Februar 2018
        </span>
    </li>

    <!-- Community Discord Bot -->
    <li>
        <i class="fa fa-code bg-yellow-active"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-code-fork"></i><a target="_blank"
                                                                 href="https://git.timolia.de/timolia/CommunityDiscordBot"> Gitlab</a></span>
            <h3 class="timeline-header"><a href="#">Community Discord Bot</a></h3>
            <div class="timeline-body">
                <p><b>Beschreibung:</b> Community Discord Bot</p>
                <p><b>Sprachen: </b> <span class="label bg-yellow-active">Java</span></p>
            </div>
        </div>
    </li>

    <!-- Dezember -->
    <li class="time-label">
        <span class="bg-green">
            Dezember 2017
        </span>
    </li>

    <!-- Community Discord Bot -->
    <li>
        <i class="fa fa-code bg-yellow-active"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-code-fork"></i><a target="_blank"
                                                                 href="https://git.timolia.de/timolia/DiscordBot"> Gitlab</a></span>
            <h3 class="timeline-header"><a href="#"> Discord Bot</a></h3>
            <div class="timeline-body">
                <p><b>Beschreibung:</b> Discord Bot mit Reminderfunktionen etc.</p>
                <p><b>Sprachen: </b> <span class="label bg-yellow-active">Java</span></p>
            </div>
        </div>
    </li>

    <!-- Phase 10 -->
    <li>
        <i class="fa fa-code bg-yellow-active"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-github"></i><a target="_blank" href="https://github.com/Janek7/Phase10"> Github</a></span>
            <h3 class="timeline-header"><a href="#">Phase 10</a></h3>
            <div class="timeline-body">
                <p><b>Beschreibung:</b> Implementierung von Phase10 gegen Bots mit JavaFX GUI</p>
                <p><b>Sprachen: </b> <span class="label bg-yellow-active">Java</span></p>
            </div>
        </div>
    </li>

    <!-- Urpsrung -->
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>

</ul>
