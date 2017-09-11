<?php
    require_once 'bot_reply.php';

    global $channel_id;
    global $channel_secret;
    global $channel_access_token;

    $myURL = "https://javaclass.herokuapp.com/linebot/classbot.php";

    $msgtokens = array(
        "今天課表" => 0,
        "明天課表" => 1,
        "後天課表" => 2,
        "大後天課表" => 3,
        "大大後天課表" => 4,
        "大大大後天課表" => 5,
        "大大大大後天課表" => 6,
        "大大大大大後天課表" => 7,
        "大大大大大大後天課表" => 8,
        "大大大大大大大後天課表" => 9
    );
    try {
        $receive = json_decode(file_get_contents("php://input"));
        $text = $receive->events[0]->message->text;
        $type = $receive->events[0]->source->type;
        
        if ($type == "room") {
            $from = $receive->events[0]->source->roomId;
        } elseif ($type == "group") {
            $from = $receive->events[0]->source->groupId;
        } else {
            $from = $receive->events[0]->source->userId;
        }
        
        $content_type = $receive->events[0]->message->type;
        $header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
        reply($content_type, $text);
    } catch (Exception $e) {
        $log->addError('Caught exception: ',  $e->getMessage());
    }
