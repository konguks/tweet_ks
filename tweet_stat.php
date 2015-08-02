<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 02-Aug-15
 * Time: 1:34 AM
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
    if(isset($_GET['link']) && $_GET['link'] != NULL && $_GET['link'] != ''){
        $hstr  = rawurldecode($_GET['link']);
    }
    else{
        $hstr = "#Verizon";
    }

    $query = array(
        "q" => rawurlencode($hstr),
        "count" => 1000,
        "result_type" => "recent"
    );

    $results = $nw->GetSearchTweet($toa,$query);


    $twt = array();
    $pos_tot = 0;
    $neg_tot = 0;
    $neu_tot = 0;

    $pos_cnt = 0;
    $neg_cnt = 0;
    $neu_cnt = 0;

    foreach ($results->statuses as $result) {

        $tmp = $result->text;
        $tmp = str_replace(" "," ",$tmp);
        $tmp = str_replace("http://t.co/[a-z,A-Z,0-9]*{8}","",$tmp);
        $tmp = str_replace("RT @[a-z,A-Z]*: ","",$tmp);
        $tmp = str_replace("#[a-z,A-Z]*","",$tmp);
        $tmp = str_replace("@[a-z,A-Z]*","",$tmp);
        array_push($twt,$tmp);

        $scores = $sentiment->score($tmp);
        $class = $sentiment->categorise($tmp);

        if($class == 'pos'){
            $pos_cnt += 1;
            $pos_tot += $scores["pos"];
        }
        else if($class == 'neg'){
            $neg_cnt += 1;
            $neg_tot += $scores["neg"];
        }else{
            $neu_cnt += 1;
            $neu_tot += $scores["neu"];
        }
    }
    echo '<html><head><title>'.$hstr.'</title>
                </head><body>
                <div align="center" style="vertical-align: middle;">
    <table width="80%" align="center" style="height: 100%;">
    <tr>
    <td width="50%">
    <a style="color:red">'.'POSITIVE COUNT : '.'</a></td><td width="50%"><a style="color:green">'.$pos_cnt.'</a><br>
    </td></tr><tr><td width="50%">
    <a style="color:red">'.'POSITIVE TOTAL : '.'</a></td><td width="50%"><a style="color:green">'.$pos_tot.'</a><br>
    </td></tr><tr><td width="50%">
    <a style="color:red">'.'NEGATIVE COUNT : '.'</a></td><td width="50%"><a style="color:green">'.$neg_cnt.'</a><br>
    </td></tr><tr><td width="50%">
    <a style="color:red">'.'NEGATIVE TOTAL : '.'</a></td><td width="50%"><a style="color:green">'.$neg_tot.'</a><br>
    </td></tr><tr><td width="50%">
    <a style="color:red">'.'NEUTRAL COUNT : '.'</a></td><td width="50%"><a style="color:green">'.$neu_cnt.'</a><br>
    </td></tr><tr><td width="50%">
    <a style="color:red">'.'NEUTAL TOTAL : '.'</a></td><td width="50%"><a style="color:green">'.$neu_tot.'</a><br>
    </td></tr></table></div></body></html>';

}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}