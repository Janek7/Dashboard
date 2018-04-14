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
?>

<div class="col-md-9">
    <div class="row">
        <!-- ID Box -->
        <div class="col-md-3">
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
                <span class="info-box-icon bg-<?php echo $project->getStateColor()?>"><i class="fa fa-spinner"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Status</span>
                    <span class="info-box-number"><?php echo $project->getStateText(); ?></span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Desc Box -->
        <div class="col-md-8">
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
    </div>
</div>


<div class="col-md-3">
    <div class="row">
        <div class="box box-info" id="actionsBox">
            <div class="box-header">
                <h3 class="box-title">Aktionen</h3>
            </div>
            <div class="box-body text-center">
                <a class="btn btn-app" id="changeStateButton"><i class="fa fa-spinner"></i>Status ändern</a>
                <a class="btn btn-app" id="changeTitleButton"><i class="fa fa-edit"></i>Titel ändern</a>
                <a class="btn btn-app" id="deleteButton"><i class="fa fa-ban"></i>Löschen</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>Git</h3>
                <p><?php echo $project->getGitClient(); ?></p>
            </div>
            <div class="icon">
                <i class="fa <?php echo $project->getGitIcon(); ?>"></i>
            </div>
            <a href="<?php echo $project->getGitRepo(); ?>" target="_blank" class="small-box-footer">
                Repository <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>