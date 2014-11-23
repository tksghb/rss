<?php

require_once dirname(__FILE__).'/class/rss.php';
require_once dirname(__FILE__).'/class/paging.php';

//get search criteria
$queries = array();
$queries['date'] = '';
$queries['url'] = '';
$queries['user'] = '';
$queries['server'] = '';
$queries['entry'] = '';
$queries['entrymore'] = '';
$queries['title'] = '';
$queries['record'] = '';
$queries['page'] = '';
if (isset($_GET['date'])) $queries['date'] = $_GET['date'];
if (isset($_GET['url'])) $queries['url'] = $_GET['url'];
if (isset($_GET['user'])) $queries['user'] = $_GET['user'];
if (isset($_GET['server'])) $queries['server'] = $_GET['server'];
if (isset($_GET['entry'])) $queries['entry'] = $_GET['entry'];
if (isset($_GET['entrymore'])) $queries['entrymore'] = $_GET['entrymore'];
if (isset($_GET['title'])) $queries['title'] = $_GET['title'];
if (isset($_GET['record'])) $queries['record'] = $_GET['record']; else $queries['record'] = 50;
if (isset($_GET['page'])) $queries['page'] = $_GET['page']; else $queries['page'] = 1;

//get search criteria from cookie if first visit
if (empty($_SERVER['QUERY_STRING']))
{
    if (isset($_COOKIE['COOKIE_DATE'])) $queries['date'] = $_COOKIE['COOKIE_DATE'];
    if (isset($_COOKIE['COOKIE_URL'])) $queries['url'] = $_COOKIE['COOKIE_URL'];
    if (isset($_COOKIE['COOKIE_USER'])) $queries['user'] = $_COOKIE['COOKIE_USER'];
    if (isset($_COOKIE['COOKIE_SERVER'])) $queries['server'] = $_COOKIE['COOKIE_SERVER'];
    if (isset($_COOKIE['COOKIE_ENTRY'])) $queries['entry'] = $_COOKIE['COOKIE_ENTRY'];
    if (isset($_COOKIE['COOKIE_ENTRYMORE'])) $queries['entrymore'] = $_COOKIE['COOKIE_ENTRYMORE'];
    if (isset($_COOKIE['COOKIE_TITLE'])) $queries['title'] = $_COOKIE['COOKIE_TITLE'];
}

//validate input
$data = null;
$rss = new rss();
$message = $rss->validateSelecrtRss($queries);

//get data
if ($message === '')
{
    //paging
    $totalRecord = $rss->selectRss('1', $queries);
    $pageList = paging::getPageList($totalRecord, $queries['record'], $queries['page']);
    $recordList = paging::getRecordList($queries['record']);

    //data
    $data = $rss->selectRss('2', $queries);
}

//display checkbox
if (isset($_GET['entrymore']) || (empty($_SERVER['QUERY_STRING']) && isset($_COOKIE['COOKIE_ENTRYMORE'])))
    $entrymoreChecked = 'checked="checked"';
else
    $entrymoreChecked = '';

//display data area
$noDataDisplay = '';
$dataDisplay = '';
if (count($data) === 0)
    $dataDisplay = 'none';
else
    $noDataDisplay = 'none';

//set criteria into cookie (30 days) for next visit
setcookie('COOKIE_DATE', $queries['date'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_URL', $queries['url'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_USER', $queries['user'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_SERVER', $queries['server'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_ENTRY', $queries['entry'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_ENTRYMORE', $queries['entrymore'], time() + 60 * 60 * 24 * 30);
setcookie('COOKIE_TITLE', $queries['title'], time() + 60 * 60 * 24 * 30);


