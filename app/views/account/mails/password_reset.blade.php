<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8" />
        <title>Nestq 重新設定密碼</title>
    </head>
    <body>
        <p>
        您好。
        <br/>
        <br/>
        我們收到您重新設定密碼的請求，請點選以下地址重設密碼。
        <br/>
        <span>{{ URL::to('reminders/reset', array($token)) }}</span>
        <br/>
        <br/>
        如有疑問，可到我們的 <a href="{{ url('inquiry/guide')}}" ><span>用戶指南</span></a> 了解詳情。
        <br/>
        Nestq 團隊 :)
        </p>
    </body>
</html>