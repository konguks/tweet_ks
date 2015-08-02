<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 02-Aug-15
 * Time: 12:58 PM
 */

require_once getcwd().'/twitteroauth/autoload.php';
require_once getcwd().'/phpInsight-master/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class NewWorld
{
    public function Add($a,$b){
        return $a+$b;
    }
    public function Sub($a,$b){
        return $a-$b;
    }
    public function GetAPICon(){
        define('CONSUMER_KEY', 'tEOWFrYWgs4ml0PzJtKSsYUrj');
        define('CONSUMER_SECRET', 'o58Tp63xUnNkIJUIr9o96O47kwhvNq1amRciv5F5MtdTLPwX1z');
        define('ACCESS_TOKEN', '714419437-qTbbCQGAq3fx3Hn6RDpv7MZ6CA78BLwDxWlMAY7O');
        define('ACCESS_TOKEN_SECRET', 'bX6sQfSD9MNKez83VAjKWOq7bxWc8DVxsOmTgTOjXuxwi');
        return new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
    }
    public function GetSearchTweet($toa,$query){

        return $toa->get('search/tweets', $query);
    }
    public function GetTrendPlace($toa,$query){

        return $toa->get('trends/place', $query);
    }
}