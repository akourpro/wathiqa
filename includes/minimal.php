<?php

/**
 * AUTO LOAD WITHOUT HEADER
 */

include_once 'config.php';

include_once 'functions.php';

include_once 'csrf.php';
$csrf = new CSRF_Protect("_csrf", "SEC_System");
