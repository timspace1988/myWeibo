<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Activate your account</title>
  </head>
  <body>
    <h1>Thank you for your register on My Weibo</h1>

    <p>
      Please click following link to activate your account
      <a href="{{route('confirm_email', $user->activation_token)}}">
        {{route('confirm_email', $user->activation_token)}}
      </a>
    </p>
    <p>
      Please ignore this letter if you did not sign up on My Weibo.
    </p>
  </body>
</html>
