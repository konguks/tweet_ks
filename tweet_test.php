<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 7/30/2015
     * Time: 12:33 AM
     */

    namespace tweet_ks;

    require_once getcwd().'/twitteroauth/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;



            echo 'start...<br>';
            define('CONSUMER_KEY', 'tEOWFrYWgs4ml0PzJtKSsYUrj');
            define('CONSUMER_SECRET', 'o58Tp63xUnNkIJUIr9o96O47kwhvNq1amRciv5F5MtdTLPwX1z');
            define('ACCESS_TOKEN', '714419437-qTbbCQGAq3fx3Hn6RDpv7MZ6CA78BLwDxWlMAY7O');
            define('ACCESS_TOKEN_SECRET', 'bX6sQfSD9MNKez83VAjKWOq7bxWc8DVxsOmTgTOjXuxwi');

            try {
                $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
                #echo $toa;
				#echo '<h2>STEP 1</h2><br>';

                $query = array(
                    "q" => rawurlencode("#Jobs"),
                    "since_id" => "2014-01-01",
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
                echo "<html><head>".$query["q"]."</head><body><table>
                <th>
                <td>USERNAME</td>
                <td>TWEET</td></th>";

                foreach ($results->statuses as $result) {
                    echo "<tr><td>".$result->user->screen_name."</td><td>".": " . $result->text . "</td></tr>";
                }
            echo "</table></body></html>";;

            }
            catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
