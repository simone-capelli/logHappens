<?php
$params = trim($_SERVER['QUERY_STRING'], '/');
$params = explode("/", $params);
$params = array_filter($params, 'strlen');
$objParsers = new logics\Parsers();
$objPages = new logics\Pages();

// Array con le pagine di template da includere
$views = [];

// Actions to be done for every request
$countAll = $objParsers->countall();

// Se non esiste un parametro nella URL seleziono la home page
if (empty($params)) {
    if (empty($countAll)) {
        reload('display/start');
    }
    reload('display/info');
}

// Page specific actions
if (isPage('truncate')) {
    $pageTitle = "Parsers";

    $file = filterString(1);
    $logs = $objParsers->truncate($file);
    reload("/viewlog/" . $file);
}

if (isPage('viewlog')) {
    $pageTitle = "Parsers";

    $file = filterString(1);
    $logs = $objParsers->read($file);
    $views[] = "templates/parsers/log_reader.php";
}

if (isPage('display')) {
    $pageTitle = "Display";

    $displayPage = filterString(1);
    $file = $objPages->display($displayPage);
    $views[] = $file;
}