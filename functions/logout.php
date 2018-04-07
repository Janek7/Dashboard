<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 07.04.2018
 * Time: 12:27
 */

session_start();
session_destroy();
header("Location: ../index.php");