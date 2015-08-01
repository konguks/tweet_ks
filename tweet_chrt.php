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
use Abraham\TwitterOAuth\TwitterOAuth;



define('CONSUMER_KEY', 'tEOWFrYWgs4ml0PzJtKSsYUrj');
define('CONSUMER_SECRET', 'o58Tp63xUnNkIJUIr9o96O47kwhvNq1amRciv5F5MtdTLPwX1z');
define('ACCESS_TOKEN', '714419437-qTbbCQGAq3fx3Hn6RDpv7MZ6CA78BLwDxWlMAY7O');
define('ACCESS_TOKEN_SECRET', 'bX6sQfSD9MNKez83VAjKWOq7bxWc8DVxsOmTgTOjXuxwi');

try {
    $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $sentiment = new \PHPInsight\Sentiment();

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

    $results = $toa->get('search/tweets', $query);


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
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/serial.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script>
            var chart;

            var chartData = [
                {
                    "Class": "POSITIVE",
                    "Count":'.$pos_cnt.'
                },
                {
                    "Class": "NEGATIVE",
                    "Count":'.$neg_cnt.'
                },
                {
                    "Class": "NEUTRAL",
                    "Count": '.$neu_cnt.'
                }
            ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "Class";
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                chart.rotate = true;
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisColor = "#DADADA";
                valueAxis.title = "Tweet Counts";
                valueAxis.gridAlpha = 0.1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Count";
                graph.valueField = "Count";
                graph.type = "column";
                graph.balloonText = "Count of [[category]] reviews :[[value]]";
                graph.lineAlpha = 0;
                graph.fillColors = "#bf1c25";
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
        </script>
    </head><body>
    <table width="80%">
    <tr>
    <td width="50%">
    <a style="color:red">'.'POS COUNT : '.'</a><a style="color:green">'.$pos_cnt.'</a><br>
    <a style="color:red">'.'POS TOTAL : '.'</a><a style="color:green">'.$pos_tot.'</a><br>
    <a style="color:red">'.'NEG COUNT : '.'</a><a style="color:green">'.$neg_cnt.'</a><br>
    <a style="color:red">'.'NEG TOTAL : '.'</a><a style="color:green">'.$neg_tot.'</a><br>
    <a style="color:red">'.'NEU COUNT : '.'</a><a style="color:green">'.$neu_cnt.'</a><br>
    <a style="color:red">'.'NEU TOTAL : '.'</a><a style="color:green">'.$neu_tot.'</a><br>
    </td>
    <td width="50%">
    <div id="chartdiv" style="width: 400px; height: 250px;"></div>
    </td></tr></table>
    <div data-role="collapsible">
    <h1>Expand Me for Tweets..</h1>
    <p>
    <table>
                <tr>
                <td>USERNAME</td>
                <td>TWEET</td></tr>';


    foreach ($results->statuses as $result) {
        echo "<tr><td>".$result->user->screen_name."</td><td>".": " . $result->text . "</td></tr>";
    }
    echo "</p></table></body></html>";

}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
