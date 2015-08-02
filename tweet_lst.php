<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/30/2015
 * Time: 12:33 AM
 */

namespace tweet_ks;

require_once getcwd().'/twitteroauth/autoload.php';
require_once getcwd().'/phpInsight-master/autoload.php';
require_once getcwd().'/NewWorld.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use NewWorld;

try {

    $sentiment = new \PHPInsight\Sentiment();
    $nw = new NewWorld();

    $toa = $nw->GetAPICon();

    #echo $toa;
    #echo '<h2>STEP 1</h2><br>';

    $query = array(
        "q" => rawurlencode("#MilGanasDe"),
        "count" => 100
    );

    $results = $nw->GetSearchTweet($toa,$query);
    #echo '<h2>STEP 2</h2><br>';
    /*$arr = json_decode(json_encode($results),true);

    #echo '<h2>STEP 3</h2><br>';

    foreach ($arr as $result) {
        echo gettype($result).'<br>';
      echo $result->user->screen_name . ": " . $result->text . '<br>';
       # echo gettype($arr).'<br>';
        #echo gettype($result).'<br>';
        #echo implode(',',$result).'<br>';
        # echo count($result).'<br>';
        # foreach($result as $res){
        #    echo gettype($res).'<br>';
        #     echo count($res).'<br>';
        #   foreach($res as $r){
        #       echo gettype($r).'<br>';
        #   }
        # }
    }*/
    #echo json_encode($results).'<br>';

#    echo count($twt).'<br>';

    echo "<html><head>".$query["q"]."</head><body><table>
                <tr>
                <td>USERNAME</td>
                <td>TWEET</td></tr>";

$cnt = 0;
    foreach ($results->statuses as $result) {
        #echo "<tr><td>".$result->user->screen_name."</td><td>".": " . $result->text . "</td></tr>";
        $cnt += 1;
    }
    echo "</table>";
    echo '<br><br><br><a style="color:red">COUNT : '.$cnt.'</a></body></html>';
    echo 'Done...';

}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
