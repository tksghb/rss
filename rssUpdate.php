#!/usr/bin/php

<?php

//ini_set('display_errors', 1);
ini_set('max_execution_time', 300);

require_once dirname(__FILE__).'/class/rss.php';

//insert rss
$url = 'http://xxx';
$xml = simplexml_load_file($url);

foreach ($xml->item as $item)
{
    $rssValues = array();

    //$rssValues['date'] = (string)$item->children('dc', true)->date; //does not work on < php 5.2
    $nameSpace = $xml->getNamespaces(true);
    $rssValues['date'] = (string)$item->children($nameSpace['dc'])->date;
    $rssValues['title'] = (string)$item->title;
    $rssValues['description'] = (string)$item->description;
    $rssValues['link'] = (string)$item->link;

    //user name, server no and entry no are in the link. format is as follows.
    //http://(user name).abcd(server no).test.com/efgh(entry no).html
    $link = (string)$item->link;

    //user name
    $userNameFrom = strpos($link, 'http://') + 7;
    $userNameEnd = strpos($link, '.abcd') - $userNameFrom;
    $rssValues['userName'] = substr($link, $userNameFrom, $userNameEnd);

    //server no
    $serverNoFrom = strpos($link, '.abcd') + 5;
    $serverNoEnd = strpos($link, '.test.com') - $serverNoFrom;
    $rssValues['serverNo'] = substr($link, $serverNoFrom, $serverNoEnd);

    //entry no
    $entryNoFrom = strpos($link, '.test.com/efgh') + 14;
    $entryNoEnd = strpos($link, '.html') - $entryNoFrom;
    $rssValues['entryNo'] = substr($link, $entryNoFrom, $entryNoEnd);
    
    //insert into database if not existance
    $rss = new rss();
    if ($rss->isRssExistance($rssValues['date'], $rssValues['link']) === false)
    {
        $rss->insertRss($rssValues);
    }
}

//delete rss
$criteria = date('Y-m-d H:i:s', strtotime('- 3 day'));

$rss = new rss();
$rss->deleteRss($criteria);

