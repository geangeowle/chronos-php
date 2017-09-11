<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title><?php echo $title_for_layout; ?></title>
  <meta name="description" content="ChronosPHP">
  <meta name="author" content="Gean Geowle">

  <!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->

  <style>
    body {
    font-family: Georgia, sans-serif;
    line-height: 2rem;
    font-size: 1.3rem;
      background-color: #FAFAFA;
      color: #333;
      margin: 0px;
    }

    /*body, p, ol, ul, td {
      font-family: helvetica, verdana, arial, sans-serif;
      font-size:   13px;
      line-height: 18px;
    }*/

    pre {
      font-size: 11px;
      white-space: pre-wrap;
    }

    pre.box {
      border: 1px solid #EEE;
      padding: 10px;
      margin: 0px;
      width: 958px;
    }

    header {
      color: #F0F0F0;
      background: #C52F24;
      padding: 0.5em 1.5em;
    }

    h1 {
      margin: 0.2em 0;
      line-height: 2.8rem;
      font-size: 2.5rem;
      letter-spacing: -1px;
    }

    h2 {
      color: #C52F24;
    }

    #container {
      box-sizing: border-box;
      width: 100%;
      padding: 0 1.5em;
    }



  </style>

</head>

<body>
    <header>
        <h1>Error</h1>
    </header>
    <div id="container">
		<?php echo $content_for_layout; ?>
	</div>
	<!-- <script src="js/scripts.js"></script> -->
</body>
</html>
