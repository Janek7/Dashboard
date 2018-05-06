<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 22.04.2018
 * Time: 21:05
 */

global $conn;
$sqlGetProjectStats = "SELECT COUNT(*) as projects, SUM((SELECT ROUND(SUM(TIMESTAMPDIFF(MINUTE, start_date, end_date))/60) 
FROM coding_worksteps WHERE project_id = cp.id)) as dev_time, SUM(IF(cp.state = 'closed', 1, 0)) as closed FROM coding_projects cp;";

$projectStatsResult = $conn->query($sqlGetProjectStats);
$row = $projectStatsResult->fetch_assoc();
$projects = $row['projects'];
$devTime = $row['dev_time'];
$closedProjects = intval($row['closed']);
?>

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <!-- Project Count Box -->
            <div class="col-md-4">
                <div class="small-box bg-blue-gradient">
                    <div class="inner">
                        <h3><?php echo $projects;?></h3>
                        <p>Projekte</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-calendar"></i>
                    </div>
                    <a id="gitRepoLink" href="index.php?page=codingTimeline" target="_blank"
                       class="small-box-footer">Timeline <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Dev Time Widget -->
            <div class="col-md-4">
                <div class="small-box bg-yellow-gradient">
                    <div class="inner">
                        <h3><?php echo $devTime;?>+</h3>
                        <p>Stunden Entwicklung</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-clock-o"></i>
                    </div>
                    <br/>
                </div>
            </div>
            <!-- Closed Rate Box -->
            <div class="col-md-4">
                <div class="small-box bg-green-gradient">
                    <div class="inner">
                        <h3><?php echo round(($closedProjects / $projects)*100);?>%</h3>
                        <p>Fertiggestellt</p>
                    </div>
                    <div class="icon">
                        <i id="gitIcon" class="fa fa-check"></i>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
    <div class="col-md-4">
        <!-- Language Donut -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Häufigkeit der Sprachen</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div id="languageDonut"></div>
            </div>
        </div>
    </div>
</div>
