<?php

namespace Chat;

use PubNub\PNConfiguration;
use PubNub\PubNub;
use PubNub\Callbacks\SubscribeCallback;

class ChatManager
{
    public static function init()
    {
        $publishKey = 'pub-c-9f8e6aea-3185-4d6a-99de-9577b2d3fd31';
        $subscribeKey = 'sub-c-4fb1ed2e-7af1-11e8-a43f-d6f8762e29f7';
        $secretKey = 'sec-c-YTQ1Y2E4ZDUtYjk0OS00NGYxLWJkMzgtMmMxMWIwOWFhZjA2';

        $PNConfig = new PNConfiguration();
        $PNConfig->setPublishKey($publishKey)
                ->setSubscribeKey($subscribeKey)
                ->setSecretKey($secretKey);

        $pubnub = new PubNub($PNConfig);

        $connectAs = function() {
            fwrite(STDOUT, 'Connect as: ' );
            return trim(fgets(STDIN));
        };

        $username = $connectAs();

        fwrite(STDOUT, 'Join: ');
        $room = trim(fgets(STDIN));


//        class MySubscribeCallback extends SubscribeCallback {
//            function status($pubnub, $status) {
//                if ($this->checkUnsubscribeCondition()) {
//                    throw (new PubNubUnsubscribeException())->setChannels("awesomeChannel");
//                }
//            }
//
//            function message($pubnub, $message) {
////        die(var_dump($pubnub, $message));
//                echo json_encode($message->getMessage());
//            }
//
//            function presence($pubnub, $presence) {
//            }
//
//            function checkUnsubscribeCondition() {
//                // return true or false
//            }
//        }


//        $callback = new MySubscribeCallback();

//        $pubnub->addListener($callback);

        $pubnub->subscribe();
//            ->channel('chat')
//            ->execute();

        //$pid = pcntl_fork();

        //if ($pid === -1) {
        //    exit(1);
        //} else if ($pid) {
        //    // Код родительского процесса
        //    echo 'hello';
        //
        //    pcntl_wait($status); // Защита против дочерних "Зомби"-процессов
        //} else {
        //    // Код дочернего процесса
        //    // true;
        //}
    }
}