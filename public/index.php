<?php

/**
 * This file is the application entry point.
 */

// bootstrap the application
$app = require_once(__DIR__ . '/../app/bootstrap.php');

// dispatch the request
$app->run();

