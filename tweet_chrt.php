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

    $cnt = 0;

    $chrt_jsn = '[';

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

        $chrt_jsn = $chrt_jsn.'{
            "Tweet":"'.$cnt.
            '","POS":'.$scores["pos"].
            ',"NEU":'.$scores["neu"].
            ',"NEG":'.$scores["neg"].'},';

        $cnt +=1;
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
    $chrt_jsn = rtrim($chrt_jsn, ",");
    $chrt_jsn =  $chrt_jsn.']';

    #echo $chrt_jsn;

    echo '<html><head><title>'.$hstr.'</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/serial.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script>
            var chart1;
            var chart2;

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

            var chartData2 = '.$chrt_jsn.';


            AmCharts.ready(function () {
                // SERIAL CHART
                chart1 = new AmCharts.AmSerialChart();
                chart2 = new AmCharts.AmSerialChart();

                chart1.dataProvider = chartData;
                chart1.categoryField = "Class";
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                chart1.rotate = true;
                // the following two lines makes chart 3D
                chart1.depth3D = 20;
                chart1.angle = 30;

                chart2.dataProvider = chartData2;
                chart2.categoryField = "Tweet";

                chart2.addTitle("Tweet Sentiments", 15);

                // AXES
                // Category
                var categoryAxis = chart1.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";

                // AXES
                // Category
                var categoryAxis2 = chart2.categoryAxis;
                categoryAxis2.gridAlpha = 0.07;
                categoryAxis2.axisColor = "#DADADA";
                categoryAxis2.startOnAxis = true;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisColor = "#DADADA";
                valueAxis.title = "Tweet Counts";
                valueAxis.gridAlpha = 0.1;
                chart1.addValueAxis(valueAxis);

                // Value
                var valueAxis2 = new AmCharts.ValueAxis();
                valueAxis2.title = "percent"; // this line makes the chart "stacked"
                valueAxis2.stackType = "100%";
                valueAxis2.gridAlpha = 0.07;
                chart2.addValueAxis(valueAxis2);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Count";
                graph.valueField = "Count";
                graph.type = "column";
                graph.balloonText = "Count of [[category]] reviews :[[value]]";
                graph.lineAlpha = 0;
                graph.fillColors = "#bf1c25";
                graph.fillAlphas = 1;
                chart1.addGraph(graph);

                // GRAPHS
                // first graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "line";
                graph2.title = "Negative";
                graph2.valueField = "NEG";
                graph2.lineAlpha = 0;
                graph2.fillAlphas = 0.6; // setting fillAlphas to > 0 value makes it area graph
                graph2.balloonText = "<img src=\'Images/neg.png\' style=\'vertical-align:bottom; margin-right: 10px; width:28px; height:21px;\'><span style=\'font-size:14px; color:#000000;\'><b>[[value]]</b></span>";
                chart2.addGraph(graph2);

                // second graph
                graph2 = new AmCharts.AmGraph();
                graph2.type = "line";
                graph2.title = "Neutral";
                graph2.valueField = "NEU";
                graph2.lineAlpha = 0;
                graph2.fillAlphas = 0.6;
                graph2.balloonText = "<img src=\'Images/neu.png\' style=\'vertical-align:bottom; margin-right: 10px; width:28px; height:21px;\'><span style=\'font-size:14px; color:#000000;\'><b>[[value]]</b></span>";
                chart2.addGraph(graph2);

                // third graph
                graph2 = new AmCharts.AmGraph();
                graph2.type = "line";
                graph2.title = "Positive";
                graph2.valueField = "POS";
                graph2.lineAlpha = 0;
                graph2.fillAlphas = 0.6;
                graph2.fillColors = "#009900";
                graph2.balloonText = "<img src=\'Images/pos.png\' style=\'vertical-align:bottom; margin-right: 10px; width:28px; height:21px;\'><span style=\'font-size:14px; color:#000000;\'><b>[[value]]</b></span>";
                chart2.addGraph(graph2);

                chart1.creditsPosition = "top-right";

                // WRITE
                chart1.write("chartdiv");

                // LEGEND
                var legend2 = new AmCharts.AmLegend();
                legend2.align = "center";
                legend2.valueText = "[[value]] ([[percents]]%)";
                legend2.valueWidth = 100;
                legend2.valueAlign = "left";
                legend2.equalWidths = false;
                legend2.periodValueText = "total: [[value.sum]]"; // this is displayed when mouse is not over the chart.
                chart2.addLegend(legend2);

                // CURSOR
                var chartCursor2 = new AmCharts.ChartCursor();
                chartCursor2.zoomable = false; // as the chart displayes not too many values, we disabled zooming
                chartCursor2.cursorAlpha = 0;
                chart2.addChartCursor(chartCursor2);

                // WRITE
                chart2.write("chartdiv2");
            });
        </script>
    </head><body>
    <table width="100%" height="300px"><tr>
    <td width="30%">
    <div id="chartdiv" style="height: 300px"></div>
    </td>
    <td width="70%">
    <div id="chartdiv2" style="height: 300px"></div>
    </td>
    <td>
    </td>
    </tr></table>
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
    echo "</table></p></div></body></html>";

}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
