<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html {
            background:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAWCAMAAADto6y6AAAAD1BMVEUgICAAAQAoKCg1NTU/Pz+suxeKAAAAOklEQVR42u2QwQkAMAgDo3b/mftSlKO4QO+VINGgZPJkarMyXb8TcaJM1/IJBtiYFh3WBDpsx8l/CbgSVgPZd9YSYQAAAABJRU5ErkJggg==');
        }
        body {
            overflow: hidden;
        }

        #jankx-debug {
            color: #fff;
            transform: rotate(-45deg);
            position: absolute;
            left: -30px;
            top: 10px;
            font-size: 15px;
            padding: 0;
            margin: 0;
            background: #f00;
            padding: 3px 30px;
            box-shadow: 0 0 10px 0;
        }
        .preview-container {
            max-width: 400px;
            height: 100vh;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }
        .preview-box {
            border: 0;
            height: 100%;
            width: 100%;
        }
        .hide {
            height: 0px;
            overflow: hidden;
        }
    </style>
    <script type="text/javascript">
        var atags = document.query
    </script>
</head>
<body>

    <div class="preview-container">
        <h1 id="jankx-debug">Debug</h1>
        <?php
        $parsedQueryString = array();
        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $parsedQueryString);
            unset($parsedQueryString['mode']);
            $_SERVER['REQUEST_URI'] = str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
        }
        $parsedQueryString['view'] = 'm';
        $parsedQueryString['mode'] = 'preview';

        $url = site_url(sprintf('%s?%s', $_SERVER['REQUEST_URI'], http_build_query($parsedQueryString)));
        ?>
        <iframe class="preview-box" src="<?php echo $url; ?>"></iframe>
    </div>
</body>
</html>
