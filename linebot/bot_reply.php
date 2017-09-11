<?php
require_once './include/composer.php';

function reply($content_type, $message)
{
    global $TimeZone;

    global $header, $from, $receive, $log, $msgtokens;
        
    $url = "https://api.line.me/v2/bot/message/push";
       
    $data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];

    if (!array_key_exists($message, $msgtokens)) {
        $log->addInfo("message " . $message);
        return;
    }

    switch ($content_type) {
        case "text":
            $log->addInfo(" command: " . $message);
            $content_type = "文字訊息";
            $today = new Datetime('now', new DateTimeZone($TimeZone));

            $diff = $msgtokens[$message];
            if ($diff > 0) {
                 $today = $today->modify('+' . $diff .' day');
            }

            $class = new \JavaClass\ClassUrlHelper($log);
            list($url1, $url2) =  $class->GetClassUrl($today);
            if (is_null($url1)|| is_null($url2)) {
                 $replymsg = mb_substr($message, 0, 2, "UTF-8") . " " . date_format($today, "Y/m/d") . " 不用上課喔！！";
                 $data = [
                    "to" => $from,
                    "messages" => array(
                        ["type" => "text", "text" => $replymsg]
                        )
                     ];
            } else {
                 $log->addInfo(" url1: " . $url1);
                 $log->addInfo(" url2: " . $url2);
                 $data = [
                    "to" => $from,
                    "messages" => array(
                        ["type" => "image", "originalContentUrl" => $url1, "previewImageUrl" => $url1],
                        ["type" => "image", "originalContentUrl" => $url2, "previewImageUrl" => $url2]
                        )
                     ];
            }
            break;
        default:
            $content_type = "未知訊息";
            break;
    }
       
       $context = stream_context_create(array(
       "http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
       ));
       $ret = file_get_contents($url, false, $context);

       $log->addInfo("return from line : " . $ret);
}
