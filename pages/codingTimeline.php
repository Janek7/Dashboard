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

?>
<div class="row">
    <div class="col-md-3">
        <button id="newProject" type="button" class="btn btn-block btn-primary">Neues Projekt anlegen</button>
    </div>
</div>
<br/>
<div>
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
                        <a href="index.php?page=codingProject&project=<?php echo $project->getTitle(); ?>">
                            <?php echo $project->getTitle(); ?></a>
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
                            <input type="te" id="gitreponame" name="gitRepoName" class="form-control" required="required"
                                   placeholder="Repository"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gitrepolink" class="col-sm-2 control-label">Repository Link</label>
                        <div class="col-sm-10">
                            <input type="url" id="gitrepolink" name="gitRepoLink" class="form-control" required="required"
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