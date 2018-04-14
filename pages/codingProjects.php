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
<div class="row">
    <div class="col-md-3">
        <button id="newProject" type="button" class="btn btn-block btn-primary">Neues Projekt anlegen</button>
    </div>
</div>
<br/>
<div>
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
                    <?php echo $projectStartDate->format("F Y"); ?>
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
                        <p><b>Status: </b><span
                                    class="label <?php echo $stateLabelColor; ?>"><?php echo $state; ?></span>
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
        <!-- Urpsrung -->
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
    </ul>
</div>


<!-- New Project Modal -->
<div id="newProjectModal" class="model-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <button id="closeNewProjectModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 id="permModalTitle" class="modal-title">Neues Projekt anlegen</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="functions/insertProject.php" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Titel</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Titel" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startDate" class="col-sm-2 control-label">Start Datum</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="startDate" name="startDate"  required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="languages" class="col-sm-2 control-label">Sprachen</label>
                        <div class="col-sm-10">
                            <select id="languages" multiple="multiple" name="languages" class="form-control" required="required">
                                <option value="java">Java</option>
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                <option value="js">JavaScript</option>
                                <option value="python">Python</option>
                                <option value="php">PHP</option>
                                <option value="groovy">Groovy</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitclient" class="col-sm-2 control-label">Git Client</label>
                        <div class="col-sm-10">
                            <select id="gitclient" name="gitclient" class="form-control" required="required">
                                <option value="github" selected="selected">Github</option>
                                <option value="bitbucket">Bitbucket</option>
                                <option value="gitlab">Gitlab</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitrepo" class="col-sm-2 control-label">Repository</label>
                        <div class="col-sm-10">
                            <input type="url" id="gitrepo" name="gitrepo" class="form-control" required="required"/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Erstellen</button>
                </div>
            </form>
        </div>
    </div>
</div>