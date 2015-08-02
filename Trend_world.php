<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 01-Aug-15
 * Time: 11:36 PM
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

    $woeid_World = 23424977;

    $query_World = array(
        "id" => $woeid_World
    );

    $results_world = $nw->GetTrendPlace($toa,$query_World);

    echo '<html><head>
            <style>
                @font-face {
                    font-family: moltor;
                    src: url(fonts/Moltorv2i.ttf);
                }
            </style>
            <script type="text/javascript">';
    echo "function rawurlencode(str) {
                str = (str + '').toString();
                return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
            }
            function pass(id){
                parent.cht.location.replace('tweet_chrt.php?link='+rawurlencode(document.getElementById(id).value));
                parent.ts.location.replace('tweet_stat.php?link='+rawurlencode(document.getElementById(id).value));
            }
            </script>
            </head><body style=\"height: 100%; margin: 0px;\">";
    echo '<table width=100%>
            <tr>
            <td><div style="background-image: url("Images/txtr2.jpg");"><a style="font-size: large;font-family: moltor"> Trending in USA : </a></div> </td>
            </tr>';
    $cnt = 1;

    foreach ($results_world as $resultw) {

        foreach($resultw->trends as $result){
            echo '<tr><td><button type="button" id="btn_'.$cnt.'" onclick="pass(this.id);" value="'.rawurldecode($result->name).'">'.rawurldecode($result->name).'</button></td></tr>';
            $cnt += 1;
        }
    }

    echo '</table></body></html>';
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}