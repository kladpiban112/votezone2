<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../core/config.php";


$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

			
			?>


