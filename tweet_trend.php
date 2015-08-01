<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 01-Aug-15
 * Time: 1:39 PM
 */

require_once getcwd().'/twitteroauth/autoload.php';
require_once getcwd().'/phpInsight-master/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'tEOWFrYWgs4ml0PzJtKSsYUrj');
define('CONSUMER_SECRET', 'o58Tp63xUnNkIJUIr9o96O47kwhvNq1amRciv5F5MtdTLPwX1z');
define('ACCESS_TOKEN', '714419437-qTbbCQGAq3fx3Hn6RDpv7MZ6CA78BLwDxWlMAY7O');
define('ACCESS_TOKEN_SECRET', 'bX6sQfSD9MNKez83VAjKWOq7bxWc8DVxsOmTgTOjXuxwi');

try {
    $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $sentiment = new \PHPInsight\Sentiment();

    $woeid_World = 1;
    $woeid_India = 23424848;
    $woeid_USA = 23424977;



    $query_World = array(
        "id" => $woeid_World
    );

    $query_India = array(
        "id" => $woeid_India
    );

    $query_USA = array(
        "id" => $woeid_USA
    );

    $results_world = $toa->get('trends/place', $query_World);
    $results_India = $toa->get('trends/place', $query_India);
    $results_USA = $toa->get('trends/place', $query_USA);
    #echo json_encode($results_world);
    #echo gettype($results_world).'<br><br>';

    echo '<html><head></head><body>';
    echo '<table width=100%>
            <tr>
            <td><a style="color:red;font-size: large"> Trending in World : </a></td>
            <td> <a style="color:red;font-size: large"> Trending in India : </a></td>
            <td><a style="color:red;font-size: large"> Trending in USA : </a></td>
            </tr><tr><td>';

    foreach ($results_world as $resultw) {

        foreach($resultw->trends as $result){
            echo '<br>'.rawurldecode($result->name);
        }
    }

    echo '</td><td>';

    foreach ($results_India as $resultw) {

        foreach($resultw->trends as $result){
            echo '<br>'.rawurldecode($result->name);
        }
    }

    echo '</td><td>';

    foreach ($results_USA as $resultw) {

        foreach($resultw->trends as $result){
            echo '<br>'.rawurldecode($result->name);
        }
    }

    echo '</td></tr></table></body></html>';
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
