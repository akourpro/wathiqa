<?php

/**
 * AUTO LOAD WITH HEADER
 */

include_once 'includes/config.php';

include_once 'includes/functions.php';

// login
sec_session_start("DOCS-qalam");
if (!login_check_admin()) {
    echo "<meta http-equiv='Refresh' content='0 url=" . safer($site["site_url"]) . "qalam/auth/login'>";
    exit;
}

include_once 'includes/csrf.php';
$csrf = new CSRF_Protect("_csrf", "DOCS-qalam");

include_once 'qalam/header.php';
