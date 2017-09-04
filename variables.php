<?php
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
$start="سلام ادمین گرامی!
پس از عضویت ربات در گروه یا اضافه شدن عضو جدید من شناسه و اطلاعات اورا به شما ارسال میکنم!
شناسه برای اسپم بدون نیاز به دستور در گروه لازم است!
با دکمه تنظیم پیام شروع میتوانید پیغامی را تعریف کنید که پس از استارت شدن توسط کاربر در شخصی یا گروه نشان داده شود
با با دکمه ارسال اسپم متن/عکس/استیکر میتوانید بدون اینکه در گروه یا شخصی کاربر دستوری ارسال کنید به من دستور اسپم بدهید!
با دکمه ترک گروه میتوانید به من دستور بدید تا از یک گروه خارج شم!
با دکمه دریافت اعضا میتوانید شناسه تمام اعضا را در یک فایل دریافت کنید
با دکمه اطلاعات عضو میتوانید با دادن شناسه اطلاعات یک عضو را دریافت کنید!
با تشکر از شما!";