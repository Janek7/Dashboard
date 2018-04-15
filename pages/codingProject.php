<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 19:21
 */

global $conn;

$project = null;
if (isset($_GET['project'])):
    $project = getProjectFromTitle($_GET['project']);
else:?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Fehler!</h4>
        Bitte gib einen Projekt Titel als GET Parameter an -> &project=title
    </div>
    <?php
    exit(0);
endif;
if (!$project) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Fehler!</h4>
        Es existiert kein Projekt mit dem Titel <?php echo $_GET['project']; ?>
    </div>
    <?php
    exit(0);
endif;

$commitList = null;
if ($project->getGitClient() == "Github") {
    //Commits von github api
    $httpRequest = "https://api.github.com/repos/Janek7/" . $project->getGitRepoName() . "/commits";
    $options = array('http' => array('user_agent' => $_SERVER['HTTP_USER_AGENT']));
    $context = stream_context_create($options);
    $response = file_get_contents($httpRequest, false, $context);
    $commitList = json_decode($response, true);
}
?>

<!-- Dummie Element mit Projekt Infos für Zugriff aus JQuery -->
<span id="project" data-id="<?php echo $project->getId(); ?>" data-title="<?php echo $project->getTitle(); ?>"
      data-state="<?php echo $project->getState(); ?>"/>

<div id="successAlertBox" class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i><span id="successAlertText"></span></h4>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <!-- ID Box -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-bookmark-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">ID</span>
                        <span class="info-box-number"><?php echo $project->getId(); ?></span>
                    </div>
                </div>
            </div>
            <!-- Date Box -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Projektstart</span>
                        <span class="info-box-number">
                        <?php echo $project->getStartDateText(); ?>
                    </span>
                    </div>
                </div>
            </div>
            <!-- State Box -->
            <div class="col-md-4">
                <div class="info-box">
                <span id="stateColor" class="info-box-icon bg-<?php echo $project->getStateColor() ?>"><i
                            class="fa fa-spinner"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Status</span>
                        <span id="stateText" class="info-box-number"><?php echo $project->getStateText(); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Time Box -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-blue-active"><i class="fa fa-clock-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Entwicklungszeit</span>
                        <span class="info-box-number">
                        <?php
                        $projectid = $project->getId();
                        $sqlGetTime = "SELECT SUM(TIMESTAMPDIFF(HOUR, start_date, end_date)) as hours 
                              FROM coding_worksteps WHERE project_id = '$projectid'";
                        $timeResult = $conn->query($sqlGetTime);
                        $time = $timeResult->fetch_assoc();
                        echo $time['hours'] . " Stunde" . ($time['hours'] != "1" ? "n" : "");
                        ?>
                    </span>
                    </div>
                </div>
            </div>
            <!-- Workstep Box -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon" id="workstepBox"><i class="fa fa-wrench"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Arbeitsschritte</span>
                        <span class="info-box-number">
                        <?php echo count($project->getWorkSteps()) ?>
                    </span>
                    </div>
                </div>
            </div>
            <!-- Commit Box -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-code"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Commits</span>
                        <span class="info-box-number"><?php echo count($commitList); ?></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Language Box -->
            <div class="col-md-3">
                <div class="box box-warning languageLabelBox">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sprachen</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php foreach ($project->getLanguageLabels() as $languageLabel) {
                            echo $languageLabel;
                        } ?>
                    </div>
                </div>
            </div>
            <!-- Desc Box -->
            <div class="col-md-9">
                <div class="box box-primary descBox">
                    <div class="box-header with-border">
                        <h3 class="box-title">Beschreibung</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul>
                            <?php foreach ($project->getDesc() as $descText) {
                                echo "<li>" . $descText . "</li>";
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-<?php echo $project->getGitCLient() == "Github" ? "6" : "12" ?>">
            <div class="row">
                <!-- Workstep Table -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Arbeitsschritte</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Text</th>
                                <th>Zeit</th>
                                <th>Beginn</th>
                                <th>Ende</th>
                            </tr>
                            <?php foreach ($project->getWorkSteps() as $workstep): ?>
                                <tr role="row" class="even">
                                    <td class=""><?php echo $workstep->getText(); ?></td>
                                    <td class=""><?php echo $workstep->getTime(); ?></td>
                                    <td class=""><?php echo $workstep->getStartDate(); ?></td>
                                    <td class=""><?php echo $workstep->getEndDate(); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($project->getGitCLient() == "Github"): ?>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Commits</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Commit Message</th>
                                <th>Datum</th>
                            </tr>
                            <?php
                            foreach ($commitList as $commit) {
                                echo "<tr>";
                                echo "<td><a target='_blank' href='" . $commit['html_url'] . "'>"
                                    . substr($commit['sha'], 0, 7) . "...</a></td>";
                                echo "<td>" . $commit['commit']['message'] . "</td>";
                                echo "<td>" . $commit['commit']['author']['date'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <div class="col-md-3">
        <!-- Action Box -->
        <div class="box box-danger" id="actionsBox">
            <div class="box-header">
                <h3 class="box-title">Aktionen</h3>
            </div>
            <div class="box-body text-center">
                <a class="btn btn-app" id="changeStateButton"><i class="fa fa-spinner"></i>Status</a>
                <a class="btn btn-app " id="workstepButton"><i class="fa fa-wrench"></i>Arbeitsschritt</a>
                <a class="btn btn-app bg-aqua" id="gitButton"><i class="fa fa-code-fork"></i>Git</a>
                <a class="btn btn-app" id="changeTitleButton"><i class="fa fa-edit"></i>Titel</a>
                <a class="btn btn-app bg-orange" id="languageButton"><i class="fa fa-code"></i>Sprachen</a>
                <a class="btn btn-app bg-blue" id="changeDescButton"><i class="fa fa-edit"></i>Beschreibung</a>
                <a class="btn btn-app" id="deleteButton"><i class="fa fa-ban"></i>Löschen</a>
            </div>
        </div>
        <!-- Git Box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo $project->getGitRepoName(); ?></h3>
                <p><?php echo $project->getGitClient(); ?></p>
            </div>
            <div class="icon">
                <i class="fa <?php echo $project->getGitIcon(); ?>"></i>
            </div>
            <a href="<?php echo $project->getGitRepoLink(); ?>" target="_blank" class="small-box-footer">
                Repository <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>


<!-- action modals-->

<!-- change title modal -->
<div id="changeTitleModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closeChangeTitleModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Projekt Titel ändern</h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Titel</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="titleInput" name="title" placeholder="Titel"
                                   required="required" value="<?php echo $project->getTitle(); ?>"/>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button id="saveChangeTitleModalButton" class="btn btn-info pull-right">Speichern</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- change state modal -->
<div id="changeStateModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closeChangeStateModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Projekt Status ändern</h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select id="stateInput" name="stateInput" class="form-control" required="required">
                                <option value="open" <?php echo(($project->getState() == "open")
                                    ? "selected=\"selected\"" : ""); ?>>In Bearbeitung
                                </option>
                                <option value="closed" <?php echo(($project->getState() == "closed")
                                    ? "selected=\"selected\"" : ""); ?>>Fertiggestellt
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button id="saveChangeStateModalButton" class="btn btn-info pull-right">Speichern</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- delete modal -->
<div id="delteModal" class="model-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button id="closeDeleteModal" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Projekt löschen</h4>
        </div>
        <div class="modal-body">
            <form action="functions/deleteCodingProject.php" class="form-horizontal">
                <div class="box-body">
                    <p>Bist du dir sicher, dass du das Projekt <b>löschen</b> willst?</p>
                    <input id="dummieInput" name="projectid" value="<?php echo $project->getId(); ?>"/>
                    <div class="box-footer">
                        <button type="submit" id="deleteModalButton" class="btn btn-danger pull-right">Löschen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>