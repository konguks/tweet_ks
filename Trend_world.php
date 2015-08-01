<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 01-Aug-15
 * Time: 11:36 PM
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

    $query_World = array(
        "id" => $woeid_World
    );

    $results_world = $toa->get('trends/place', $query_World);

    echo '<html><head>
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
            </head><body>";
    echo '<table width=100%>
            <tr>
            <td><a style="color:red;font-size: large"> Trending in World : </a></td>
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