<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hangman Game</title>
</head>
<?php
Yii::app()->clientScript
    ->registerCssFile(Yii::app()->assetManager
    ->publish(Yii::getPathOfAlias('webroot.css.site.styles').'.less'));
?>
<body>

<?php echo $content; ?>

</body>
</html>