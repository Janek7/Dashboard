<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 13.04.2018
 * Time: 22:38
 */

global $conn;
global $languageLabelColors;
global $codingProjects;
$userid = $_SESSION['userid'];
$months = [];

$sqlGetProjectStats = "SELECT COUNT(*) as projects, SUM((SELECT ROUND(SUM(TIMESTAMPDIFF(MINUTE, start_date, end_date))/60) 
FROM coding_worksteps WHERE project_id = cp.id)) as dev_time, SUM(IF(cp.state = 'closed', 1, 0)) as closed FROM coding_projects cp;";

$projectStatsResult = $conn->query($sqlGetProjectStats);
$row = $projectStatsResult->fetch_assoc();
$projects = $row['projects'];
$devTime = $row['dev_time'];
$closedProjects = intval($row['closed']);
?>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <!-- Project Count Box -->
            <div class="col-md-6">
                <div class="small-box bg-blue-gradient">
                    <div class="inner">
                        <h3><?php echo $projects; ?></h3>
                        <p>Projekte</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-calendar"></i>
                    </div>
                    <br/>
                </div>
            </div>
            <!-- Dev Time Widget -->
            <div class="col-md-6">
                <div class="small-box bg-yellow-gradient">
                    <div class="inner">
                        <h3><?php echo $devTime; ?>+</h3>
                        <p>Stunden Entwicklung (seit April)</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-clock-o"></i>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Closed Rate Box -->
            <div class="col-md-6">
                <div class="small-box bg-green-gradient">
                    <div class="inner">
                        <h3><?php echo round(($closedProjects / $projects) * 100); ?>%</h3>
                        <p>Fertiggestellt</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-check"></i>
                    </div>
                    <br/>
                </div>
            </div>
            <!-- New Project Widget -->
            <div class="col-md-6">
                <div class="small-box bg-teal-gradient">
                    <div class="inner">
                        <h3>Projekt</h3>
                        <p>neu erstellen</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-plus"></i>
                    </div>
                    <a id="newProject" class="small-box-footer">Create <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Language Donut -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Verwendung der Sprachen</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div id="languageDonut"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div>
            <h3>Timeline <small>Zeitlicher Verlauf der Projekte</small></h3>
            <p id="timeInterval"></p>
            <ul class="timeline">
                <?php foreach ($codingProjects as $project):
                    $projectStartDate = $project->getStartDateObject();
                    $yearMonthString = date_format($projectStartDate, "y-m");
                    if (!in_array($yearMonthString, $months)): ?>
                        <li class="time-label">
                <span class="label-info">
                    <?php echo $projectStartDate->format("F Y"); ?>
                </span>
                        </li>
                        <?php
                        array_push($months, $yearMonthString);
                    endif;
                    ?>
                    <!-- Project -->
                    <li>
                        <i class="fa fa-code <?php echo $languageLabelColors[$project->getMainLanguage()]; ?>"></i>
                        <div class="timeline-item">
                <span class="time">
                    <i class="fa <?php echo $project->getGitIcon(); ?>"></i>
                    <a target="_blank"
                       href="<?php echo $project->getGitRepoLink(); ?>"><?php echo $project->getGitClient(); ?></a>
                </span>
                            <h3 class="timeline-header">
                                <a href="index.php?page=codingProject&project=<?php echo $project->getTitle(); ?>"
                                   target="_blank"><?php echo $project->getTitle(); ?></a>
                            </h3>
                            <div class="timeline-body">
                                <p><b>Status: </b><?php echo $project->getStateLabel(); ?></p>
                                <b>Beschreibung:</b>
                                <ul id="desc">
                                    <?php
                                    foreach ($project->getDesc() as $descText) {
                                        echo "<li>$descText</li>";
                                    }
                                    ?>
                                </ul>
                                <p><b>Arbeitszeit: </b><?php echo $project->getTime(); ?></p>
                                <p>
                                    <b>Sprachen:</b>
                                    <?php
                                    foreach ($project->getLanguageLabels() as $languageLabel) {
                                        echo $languageLabel;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <!-- Urpsrung -->
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
        </div>
    </div>
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
            <form class="form-horizontal" action="functions/codingProject/insertCodingProject.php" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Titel</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Titel"
                                   required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startDate" class="col-sm-2 control-label">Start Datum</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="startDate" name="startDate"
                                   required="required" value="<?php echo date('Y-m-d'); ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="languages" class="col-sm-2 control-label">Sprachen</label>
                        <div class="col-sm-10">
                            <select id="languages" multiple="multiple" name="languages[]" class="form-control"
                                    required="required">
                                <option value="1">Java</option>
                                <option value="2">HTML</option>
                                <option value="3">CSS</option>
                                <option value="4">JavaScript</option>
                                <option value="5">PHP</option>
                                <option value="6">Python</option>
                                <option value="7">Groovy</option>
                                <option value="8">TypeScript</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mainLanguage" class="col-sm-2 control-label">Haupt Sprache</label>
                        <div class="col-sm-10">
                            <select id="mainLanguage" name="mainLanguage" class="form-control" required="required">
                                <option value="1">Java</option>
                                <option value="2">HTML</option>
                                <option value="3">CSS</option>
                                <option value="4">JavaScript</option>
                                <option value="5">PHP</option>
                                <option value="6">Python</option>
                                <option value="7">Groovy</option>
                                <option value="8">TypeScript</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitclient" class="col-sm-2 control-label">Git Client</label>
                        <div class="col-sm-10">
                            <select id="gitclient" name="gitclient" class="form-control" required="required">
                                <option value="Github" selected="selected">Github</option>
                                <option value="Bitbucket">Bitbucket</option>
                                <option value="Gitlab">Gitlab</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitreponame" class="col-sm-2 control-label">Repository Name</label>
                        <div class="col-sm-10">
                            <input type="te" id="gitreponame" name="gitRepoName" class="form-control"
                                   required="required"
                                   placeholder="Repository"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitrepolink" class="col-sm-2 control-label">Repository Link</label>
                        <div class="col-sm-10">
                            <input type="url" id="gitrepolink" name="gitRepoLink" class="form-control"
                                   required="required"
                                   placeholder="https://github.com/user/repository"/>
                        </div>
                    </div>
                    <div>
                        <label for="state" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select id="state" name="state" class="form-control" required="required">
                                <option value="open" selected="selected">In Bearbeitung</option>
                                <option value="closed">Fertig</option>
                            </select>
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