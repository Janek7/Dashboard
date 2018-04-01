<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 01.04.2018
 * Time: 22:58
 * @param $pagename
 * @return string
 */

function getPage($pagename) {
    //page? pages/main.php
    $path = "$pagename";

    if (file_exists($path)) {
        return ($path);
    } else {
        return "pages/error404.php";
    }
}
