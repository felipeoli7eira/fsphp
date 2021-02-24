<?php

    /**
     * DATABASE
    */

    define('CONF_DB_HOST', 'localhost');
    define('CONF_DB_NAME', 'fullstackphp');
    define('CONF_DB_USER', 'root');
    define('CONF_DB_PASSWORD', 'wsl');

    /**
     * PROJECT URL's
    */
    define('CONF_URL_BASE', 'http://localhost/fsphp');
    define('CONF_URL_ADMIN', CONF_URL_BASE . '/admin');
    define('CONF_URL_ERROR', CONF_URL_BASE . '/404');

    /**
     * DATES
    */
    define('CONF_DATE_BR', 'd/m/Y H:i:s');
    define('CONF_DATE_APP', 'Y-m-d H:i:s');

    /**
     * SESSION
    */
    define('CONF_SESSION_PATH', __DIR__ . '/../../storage/session');

    /**
     * MESSAGE
    */
    define('CONF_MESSAGE_CLASS', 'trigger');
    define('CONF_MESSAGE_INFO', 'info');
    define('CONF_MESSAGE_SUCCESS', 'success');
    define('CONF_MESSAGE_WARNING', 'warning');
    define('CONF_MESSAGE_ERROR', 'error');

    # define('CONF_', '');