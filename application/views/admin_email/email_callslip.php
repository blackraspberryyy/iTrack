<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ITrack Email</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <style>
    body, html{
      margin:0;
      padding:0;
      width:100%;
      font-family:'Roboto', sans-serif;
    }
    .border{
      border:1px solid black;
    }
    .container{
      margin:15px 25px;
      padding:15px 0px;
      border-radius:4px;
    }
    .elevation{
      box-shadow:1px 2px 8px rgba(0,0,0,0.4);
    }
    .full-width{
      width:100%;
    }
    #banner{
      padding:8px;
      background:rgb(244,211,12);
      background: linear-gradient(135deg, rgb(244,211,12) 50%, rgba(0,114,54,1) 50%);
    }
    #banner h2{
      text-align:center;
      text-shadow:1px 2px 5px rgba(0,0,0,0.8);
      color:#f1f1f1;
    }
    #logo{
      padding:24px 0;
      text-align:center;
      background:#E0E0E0;
    }
    .body{
      padding:16px 24px;
    }
    .paragraph{
      text-align:justify; 
      line-height:24px;
    }
    small{
      color:gray;
    }
  </style>
</head>
<body>
  <div class="container elevation">
    <div id = "logo">
        <img src="https://i.imgur.com/7pAyj2P.png" alt="iTrack Logo" height="50"/>
    </div>
    <div id = "banner">
      <h2>Call Slip</h2>
    </div>
    <div class="body">
      <h3><strong>To:</strong> <?= $username?></h3>
      <h3><strong>Date:</strong> <?= date("F d, Y",$datetime)?></h3>
      <h3><strong>Time:</strong> <?= date("h:i A", $datetime)?></h3>
      <br/>
      <p class="paragraph">&emsp;&emsp;<?= $message?></p>
      <br/>
      <br/>
      <div style="text-align:center;">
        <small>Upon receiving this notice, you are given 2 days to report to SACSO-Discipline Unit.</small><br/>
        <small>Disregarding this notice shall mean disobedience which shall be dealt appropriately, as stated in the Student Handbook.</small>
      </div>
      <br/>
      <p>
        <span>Regards, <br/> iTrack Administrator</span>
      </p>
    </div>
  </div>
  <div>
    <center>
      <small>Powered by Systematix</small>
    </center>
  </div>
</body>
</html>