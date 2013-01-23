<!DOCTYPE html>
<html>
    <head>
        <title>DartPush - <?php echo $title_for_layout; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <?php
            echo $this->Html->css('bootstrap.css');
            echo $this->Html->css('bootstrap-responsive.css');
            echo $this->Html->css('style.css');
            echo $this->Html->script('http://code.jquery.com/jquery-latest.js');
            echo $this->Html->script('bootstrap.js');
            echo $this->Html->script('when.js');
            echo $this->Html->script('http://autobahn.s3.amazonaws.com/js/autobahn.min.js');
            echo $this->Html->script('postController.js');
        ?>

    </head>
    <body>
        <div id="wrapper" class="container">
            <?php echo $this->fetch('content'); ?>
        </div>
    </body>
</html>