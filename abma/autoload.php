<?php

/**
 * AUTO LOAD WITH HEADER
 */

include_once 'includes/config.php';

include_once 'includes/functions.php';

// login
sec_session_start("DOCS-abma");
if (!login_check_admin()) {
    echo "<meta http-equiv='Refresh' content='0 url=" . safer($site["site_url"]) . "abma/auth/login'>";
    exit;
}

include_once 'includes/csrf.php';
$csrf = new CSRF_Protect("_csrf", "DOCS-abma");

include_once 'abma/header.php';
