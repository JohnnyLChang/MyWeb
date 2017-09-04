<?php
    $msgtokens = array(
        "今天課表" => 0,
        "明天課表" => 1,
        "後天課表" => 2,
    );

    if (in_array("今天課表", $msgtokens)) {
        echo $msgtokens["今天課表"];
    }

    $msg = "今天課表";
    echo mb_substr($msg, 0, 2, "UTF-8") . "不用上課喔！！！";
?>