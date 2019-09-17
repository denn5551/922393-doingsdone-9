<?php
ob_start();
$aReq = explode ('/', trim ($_SERVER['REQUEST_URI'], ' /'));

$act = $aReq[0] ?? '';

$pagesAllowed = [
    '' => 'index',
    'about' => '',
    'history' => '',
    'feedback' => '',
    'review' => '',
    'prodj' => '',
    'add' => '',
    'task' => '',
    'logout' => '',
    'auth' => '',
    'user' => '',
    'reg' => '',
    'project' => 'index',
    'index' => 'index',
    'index.php' => 'index',
    'controller' => 'index',
    'today' => 'index',
    'tomorrow' => 'index',
    'overdue' => 'index',
    'notime' => 'index',
    'page' => 'index',
    '404' => '',
];

if (isset($pagesAllowed[$act])){
    require "controller/" . ($pagesAllowed[$act] ? $pagesAllowed[$act] : $act) . ".php";
} else {
    require "controller/404.php";
}

$sysOut = ob_get_contents();
ob_end_clean();

echo $sysOut;
