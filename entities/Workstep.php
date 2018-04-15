<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 15.04.2018
 * Time: 19:32
 */

class Workstep {

    private $project;
    private $text;
    private $start_date;
    private $end_date;
    private $time;

    function __construct($workstep) {
        $this->project = $workstep['project_id'];
        $this->text = $workstep['text'];
        $this->start_date = new DateTime($workstep['start_date']);
        $this->end_date = new DateTime($workstep['end_date']);
        $this->time = date_diff($this->start_date, $this->end_date);
    }

    
    public function getProject() {
        return $this->project;
    }

    public function getText() {
        return $this->text;
    }

    public function getStartDate() {
        return $this->start_date->format('Y-m-d H:i:s');
    }

    public function getEndDate() {
        return $this->end_date->format('Y-m-d H:i:s');
    }

    public function getTime() {
        return $this->time->format("%hh %Imin");
    }
    
    

}