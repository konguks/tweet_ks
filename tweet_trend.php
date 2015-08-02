<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 01-Aug-15
 * Time: 1:39 PM
 */

require_once getcwd().'/twitteroauth/autoload.php';
require_once getcwd().'/phpInsight-master/autoload.php';
require_once getcwd().'/NewWorld.php';
use Abraham\TwitterOAuth\TwitterOAuth;
#use NewWorld;

try {

    $sentiment = new \PHPInsight\Sentiment();
    $nw = new NewWorld();

    $toa = $nw->GetAPICon();

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

    $results_world = $nw->GetTrendPlace($toa,$query_World);
    $results_India = $nw->GetTrendPlace($toa,$query_India);
    $results_USA = $nw->GetTrendPlace($toa,$query_USA);
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
