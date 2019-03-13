<?php

namespace App\Service;

use Nexy\Slack\Client;
use App\Helper\LoggerTrait;

class SlackClient
{
    use LoggerTrait;

    private $slackClient;

    public function __construct(Client $slackClient)
    {
        $this->slackClient = $slackClient;
    }

    public function sendMessage(string $from, string $message)
    {
        $this->logInfo('Beaming a message to Slack!', [
            'message' => $message,
        ]);

        $slackMessage = $this->slackClient->createMessage()
            ->from($from)
            ->setText($message);

        $this->slackClient->sendMessage($slackMessage);
    }
}
