<?php
//توکن خود را در خط پايين قرار دهيد
define('API_KEY','');
//شناسه ادمين را جلوی مساوی قرار دهید
$admin=60453874;
//
//
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//
function save($file,$data){
file_put_contents($file,$data);
}
//
$up=file_get_contents('php://input');
$update=json_decode($up);
$text=$update->message->text;
$matches=explode(" ",$update->message->text);
$chat_id=$update->message->chat->id;
$photo=$update->message->photo;
$username=$update->message->chat->username;
$firstname=$update->message->chat->first_name;
$lastname=$update->message->chat->last_name;
$title=$update->message->chat->title;
$caption=$update->message->caption;
$photo=$update->message->photo;
$photoid = json_encode($photo, JSON_PRETTY_PRINT);
$photoidd = json_encode($photoid, JSON_PRETTY_PRINT);
$photoidd = str_replace('"[\n    {\n        \"file_id\": \"','',$photoidd);
$pos = strpos($photoidd, '",\n');
$pos = $pos -1;
$photo_id = substr($photoidd, 0, $pos);
$sticker_id=$update->message->sticker->file_id;
$members=explode("\n",file_get_contents('members.txt'));
$wlc=file_get_contents('wlc.txt');
$action=file_get_contents('actions.txt');
$spamtxt=file_get_contents('spamtxt.txt');
$picspam=file_get_contents('picspam.txt');
$stspam=file_get_contents('stspam.txt');
$ac='actions.txt';
//
if(isset($update->message)){
if(!in_array($chat_id,$members)){
$file=fopen('members.txt','a');
fwrite($file,$chat_id."\n");
bot('sendMessage',['chat_id'=>$admin,'text'=>"$title $firstname $lastname,@$username,$chat_id"]);
}
if($chat_id==$admin){
if($matches[0]=='/start'){
    bot('sendMessage',array(
	'chat_id'=>$admin,
	'text'=>"سلام ادمين گرامي!
پس از عضويت ربات در گروه يا اضافه شدن عضو جديد من شناسه و اطلاعات اورا به شما ارسال ميکنم!
شناسه براي اسپم بدون نياز به دستور در گروه لازم است!
با دکمه تنظيم پيام شروع ميتوانيد پيغامي را تعريف کنيد که پس از استارت شدن توسط کاربر در شخصي يا گروه نشان داده شود
با با دکمه ارسال اسپم متن/عکس/استيکر ميتوانيد بدون اينکه در گروه يا شخصي کاربر دستوري ارسال کنيد به من دستور اسپم بدهيد!
با دکمه ترک گروه ميتوانيد به من دستور بديد تا از يک گروه خارج شم!
با دکمه دريافت اعضا ميتوانيد شناسه تمام اعضا را در يک فايل دريافت کنيد
با دکمه اطلاعات عضو ميتوانيد با دادن شناسه اطلاعات يک عضو را دريافت کنيد!
با تشکر از شما!",
	'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>'تنظيم متن شروع']
              ],
              [
	        ['text'=>'ارسال اسپم متن'],['text'=>'ارسال اسپم عکس'],['text'=>'ارسال اسپم استيکر']
		],
		[
		['text'=>'ترک گروه'],['text'=>'پاک کردن لیست ممبرها']
		],
		[
		['text'=>'دريافت اعضا'],['text'=>'اطلاعات عضو']
		]
              ],
              "resize_keyboard"=>true,
              "one_time_keyboard"=>true
        ])
          ));
		  save($ac,' ');
}
if($text=="تنظيم متن شروع"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا متن خود را جهت تنظيم ارسال کنيد']);
save($ac,'start');
}elseif($text=="ارسال اسپم متن"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا متن خود ر ارسال کنيد']);
save($ac,'txtspam');
}elseif($text=="ارسال اسپم عکس"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا عکس خود را ارسال کنيد']);
save($ac,'picspam');
}elseif($text=="ارسال اسپم استيکر"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا استيکر موردنظر را ارسال کنيد']);
save($ac,'stspam');
}elseif($text=="ترک گروه"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا شناسه گروه را ارسال کنيد']);
save($ac,'leave');
}elseif($text=="دريافت اعضا"){
bot('sendDocument',array('chat_id'=>$admin,'document'=>new CURLFILE("members.txt")));
}elseif($text=="پاک کردن لیست ممبرها"){
save('members.txt','');
bot('sendMessage',['chat_id'=>$admin,'text'=>'انجام شد']);
}elseif($text=="اطلاعات عضو"){
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا شناسه عضو را ارسال کنيد']);
save($ac,'userinfo');
}else{
if($action=='start'){
save('wlc.txt',$text);
bot('sendMessage',['chat_id'=>$admin,'text'=>'تنظيم شد']);
save($ac,'');
}elseif($action=='txtspam'){
save('spamtxt.txt',$text);
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا تعداد دفعات اسپم را نوشته يک فاصله ايجاد کنيد وشناسه هدف را بنويسيد']);
save($ac,'txtspam_user');
}elseif($action=='stspam'){
save('stspam.txt',$sticker_id);
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا تعداد دفعات اسپم را نوشته يک فاصله ايجاد کنيد وشناسه هدف را بنويسيد']);
save($ac,'stspam_user');
}elseif($action=='leave'){
bot('leaveChat',['chat_id'=>$text]);
bot('sendMessage',['chat_id'=>$admin,'text'=>'گروه رو ترک کردم قربان!']);
save($ac,'');
}elseif($action=='txtspam_user'){
for($i=0;$i<$matches[0];++$i){
bot('sendMessage',['chat_id'=>$matches[1],'text'=>$spamtxt]);
}
bot('sendMessage',['chat_id'=>$admin,'text'=>"??ماموريت انجام شد\nبراي برگشت /start"]);
save($ac,'');
}
elseif($action=='picspam_user'){
for($i=0;$i<$matches[0];++$i){
bot('sendPhoto',['chat_id'=>$matches[1],'photo'=>$picspam]);
}
bot('sendMessage',['chat_id'=>$admin,'text'=>"??ماموريت انجام شد\nبراي برگشت /start"]);
save($ac,'');
}
elseif($action=='stspam_user'){
for($i=0;$i<$matches[0];++$i){
bot('sendSticker',['chat_id'=>$matches[1],'sticker'=>$stspam]);
}
bot('sendMessage',['chat_id'=>$admin,'text'=>"??ماموريت انجام شد\nبراي برگشت /start"]);
save($ac,'');
}
elseif($action=='userinfo'){
$gt=bot('getChat',array('chat_id'=>$text));
$gtfirst=$gt->result->first_name;
$gtlast=$gt->result->last_name;
$gtuser=$gt->result->username;
$gtid=$gt->result->id;
$gttype=$gt->result->type;
$gttitle=$gt->result->title;
bot('sendMessage',['chat_id'=>$admin,'text'=>"First Name: ".$gtfirst."
Title(For Groups/channels): ".$gttitle."
Last Name: ".$gtlast."
User Name: [@".$gtuser."](https://telegram.me/".$gtuser.")
ID: ".$gtid."
Type: ".$gttype,'MARKDOWN']);
save($ac,'');
}
}
}else{
bot('sendMessage',['chat_id'=>$chat_id,'text'=>$wlc]);
}
}
if(isset($update->message->photo)){
if($action=='picspam' && $chat_id==$admin){
save('picspam.txt',$photo_id);
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا تعداد دفعات اسپم را نوشته يک فاصله ايجاد کنيد وشناسه هدف را بنويسيد']);
save('actions.txt','picspam_user');
}
}
if(isset($update->message->sticker)){
if($action=='stspam' && $chat_id==$admin){
save('stspam.txt',$sticker_id);
bot('sendMessage',['chat_id'=>$admin,'text'=>'لطفا تعداد دفعات اسپم را نوشته يک فاصله ايجاد کنيد وشناسه هدف را بنويسيد']);
save('actions.txt','stspam_user');
}
}
