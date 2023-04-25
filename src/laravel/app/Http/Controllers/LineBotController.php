<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineBotController extends Controller
{
    private $lineBot;

    public function __construct(LINEBot $lineBot)
    {
        $this->lineBot = $lineBot;
    }

    public function callback(Request $request)
    {
        $signature = $request->header('X-Line-Signature');
        if (empty($signature)) {
            return response('Bad Request', 400);
        }

        try {
            $events = $this->lineBot->parseEventRequest($request->getContent(), $signature);
        } catch (\Exception $e) {
            return response('Internal Server Error', 500);
        }

        foreach ($events as $event) {
            if ($event instanceof TextMessage) {
                $replyText = $event->getText();
                $replyToken = $event->getReplyToken();
                $textMessageBuilder = new TextMessageBuilder($replyText);

                $this->lineBot->replyMessage($replyToken, $textMessageBuilder);
            }
        }

        return response('OK', 200);
    }
}

