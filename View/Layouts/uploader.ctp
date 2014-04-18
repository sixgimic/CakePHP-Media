<!DOCTYPE html>
<html>
    <head>
        <title>Uploader</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <?php echo $this->Html->css('/Media/css/app.css'); ?>
        <?php echo $this->fetch('css'); ?>
    </head>
    <body>

	   <?php echo $this->Session->flash('Auth'); ?>
	   <?php echo $this->Session->flash(); ?>

       <?php echo $this->fetch('content'); ?>

        <!-- jQuery AND jQueryUI -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <?php echo $this->Html->script('/Media/js/jqui.js'); ?>
        <?php echo $this->fetch('script'); ?>

    </body>
</html>