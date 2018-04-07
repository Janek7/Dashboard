<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 01.04.2018
 * Time: 22:58
 * @param $pagename
 * @return string
 */

function getPage() {
    //index.php?page=example

    global $pages;
    if (isset($_GET['page'])) {
        $pagename = $_GET['page'];
        $path = "pages/" . $pagename . ".php";
        if (!file_exists($path)) {
            $pagename = "error";
        }
        return $pages[$pagename];
    } else {
        return $pages['main'];
    }
}
