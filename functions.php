<?php

function sendMsg($id,$text,$parse,$perview){
    bot('sendMessage',array('chat_id'=>$id,'text'=>$text,'parse_mode'=>$parse,'disable_web_page_preview'=>$perview));
}
function sendPhoto($id,$photo,$caption){
    bot('sendPhoto',array('chat_id'=>$id,'photo'=>$photo,'caption'=>$caption));
}
function sendSticker($id,$sticker){
    bot('sendSticker',array('chat_id'=>$id,'sticker'=>$sticker));
}
function leave($id){
bot('leaveChat',array('chat_id'=>$id));
}
function save($file,$txt){
file_put_contents($file,$txt);
}
function sendDocument($id,$document,$caption){
    bot('sendDocument',array('chat_id'=>$id,'document'=>new CURLFile($document),'caption'=>$caption));
}
function getChat($id){
$res=bot('getChat',array('chat_id'=>$id));
return $res;
}