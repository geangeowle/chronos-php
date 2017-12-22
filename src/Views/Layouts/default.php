<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <style type="text/css" media="screen" charset="utf-8">
            body {
                font-family: Georgia, sans-serif;
                line-height: 2rem;
                font-size: 1.3rem;
                background-color: white;
                margin: 0;
                padding: 0;
                color: #000;
            }

            h1 {
                font-weight: normal;
                line-height: 2.8rem;
                font-size: 2.5rem;
                letter-spacing: -1px;
                color: black;
            }

            p { font-family: monospace; }

            .container {
                width: 960px;
                margin: 0 auto 40px;
                overflow: hidden;
            }

            section {
                margin: 0 auto 2rem;
                padding: 1rem 0 0;
                width: 700px;
                text-align: center;
            }
        </style>
        <title><?php echo $title_for_layout; ?></title>
    </head>

    <body>
        <?php echo $content_for_layout; ?>
        <?php echo $Form->start().' '; var_dump($Form); ?>
    </body>
</html>
