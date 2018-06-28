<?php

namespace Chat;

use Chat\Entities\User;
use Pubnub\Pubnub;

class ChatManager
{
    public static function init()
    {
        $server = new Server(PubnubAdapter::make());

        $user = new User();

        $config = require __DIR__.'/../config.php';

        $pubnub = new Pubnub(
            $config['publish-key'],
            $config['subscribe-key'],
            $config['secret-key'],
            false
        );

        $joinAs = function() {
            fwrite(STDOUT, 'Connect as: ' );
            return trim(fgets(STDIN));
        };

        fwrite(STDOUT, 'Join: ');
        $room = trim(fgets(STDIN));

        $isUsernameTaken = function($username) use ($pubnub, $room) {
            $hereNow = $pubnub->hereNow($room, false, true);
            foreach ($hereNow['uuids'] as $user) {
                if ($user['state']['username'] === $username) {
                    return true;
                }
            }
        };

        $username = $joinAs();
        while ($isUsernameTaken($username)) {
            fwrite(STDOUT, "Username already taken\n");
            $username = $joinAs();
        }

        $pubnub->setState($room, [
            'username' => $username
        ]);

        fwrite(STDOUT, "\nConnected to '{$room}' as '{$username}'\n");

        $pid = pcntl_fork();

        if ($pid === -1) {
            exit(1);
        } else if ($pid) {
            // Code of parent process
            fwrite(STDOUT, '> ');

            while (true) {
                $message = trim(fgets(STDIN));

                $pubnub->publish($room, [
                    'body' => $message,
                    'username' => $username
                ]);
            }

            pcntl_wait($status); // Guard against child zombie-processes
        } else {
            // Code of child process
            $pubnub->subscribe($room, function($payload) use ($username) {

                $author = $payload['message']['username'];

//                if ($username !== $author) {
                    fwrite(STDOUT, "\r");
//                }


                $message = $payload['message']['body'];
                $timestamp = date('d-m-y H:i:s');

                fwrite(STDOUT, "[{$timestamp}] <{$author}> {$message}\n");

                fwrite(STDOUT, "> "); // carriage return sybmols = overwrite line)

                return true;
            });
        }
    }
}