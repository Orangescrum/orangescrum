<!doctype html>
<html lang="en">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <?php /* <meta http-equiv="X-Frame-Options" content="deny"> */ ?>
    <title>Gantt Chart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow" />
    <?php echo $this->Html->meta('icon'); ?>
    <?php
    #echo $this->Html->css(array('bootstrap.min.css','bootstrap-material-design.min.css','ripples.min.css'));
    echo $this->Html->css(array("/css/codebase/dhtmlxgantt.css"));
    echo $this->Html->css(array("/css/codebase/dhtmlxSuite/skins/skyblue/dhtmlx.css"));
    #'jquery-ui-1.8.4.custom',
    #echo $this->Html->css( "/css/print.css", array("media" => "print"));
    echo $this->Html->css('//fonts.googleapis.com/icon?family=Material+Icons', array('noversion' => true));
    echo $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array('noversion' => true));
    echo $this->Html->css(array("/css/selectize.default"));
    echo $this->Html->css(array("/css/codebase/gantt.css"));
    ?>
    <body onresize="modSampleHeight()" onload="modSampleHeight()">
        <?php echo $this->fetch('content'); ?>
    </body>
</html>