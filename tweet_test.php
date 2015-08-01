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





            echo 'start...<br>';
            define('CONSUMER_KEY', 'tEOWFrYWgs4ml0PzJtKSsYUrj');
            define('CONSUMER_SECRET', 'o58Tp63xUnNkIJUIr9o96O47kwhvNq1amRciv5F5MtdTLPwX1z');
            define('ACCESS_TOKEN', '714419437-qTbbCQGAq3fx3Hn6RDpv7MZ6CA78BLwDxWlMAY7O');
            define('ACCESS_TOKEN_SECRET', 'bX6sQfSD9MNKez83VAjKWOq7bxWc8DVxsOmTgTOjXuxwi');

            try {
                $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

                $sentiment = new \PHPInsight\Sentiment();

                #echo $toa;
				#echo '<h2>STEP 1</h2><br>';

                $query = array(
                    "q" => rawurlencode("Rs 2.43"),
                    "count" => 1000
                    );

                $results = $toa->get('search/tweets', $query);
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

                echo '<a style="color:red">'.'POS COUNT : '.'</a><a style="color:green">'.$pos_cnt.'</a><br>';
                echo '<a style="color:red">'.'POS TOTAL : '.'</a><a style="color:green">'.$pos_tot.'</a><br>';
                echo '<a style="color:red">'.'NEG COUNT : '.'</a><a style="color:green">'.$neg_cnt.'</a><br>';
                echo '<a style="color:red">'.'NEG TOTAL : '.'</a><a style="color:green">'.$neg_tot.'</a><br>';
                echo '<a style="color:red">'.'NEU COUNT : '.'</a><a style="color:green">'.$neu_cnt.'</a><br>';
                echo '<a style="color:red">'.'NEU TOTAL : '.'</a><a style="color:green">'.$neu_tot.'</a><br>';

                echo count($twt).'<br>';

                echo "<html><head>".$query["q"]."</head><body><table>
                <tr>
                <td>USERNAME</td>
                <td>TWEET</td></tr>";


                foreach ($results->statuses as $result) {
                    echo "<tr><td>".$result->user->screen_name."</td><td>".": " . $result->text . "</td></tr>";
                }
            echo "</table></body></html>";

            }
            catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
