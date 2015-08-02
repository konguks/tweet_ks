<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 02-Aug-15
 * Time: 12:05 AM
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

    $woeid_India = 23424848;

    $query_India = array(
        "id" => $woeid_India
    );

    $results_India = $toa->get('trends/place', $query_India);


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
            <td><div style="background-image: url("Images/txtr2.jpg");"><a style="font-size: large;font-family: moltor"> Trending in India : </a></div></td>
            </tr>';
    $cnt = 1;

    foreach ($results_India as $resultw) {
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