<?php

use humhub\modules\custom_pages\models\CustomPage;
?>

<?php if ($navigationClass == CustomPage::NAV_CLASS_ACCOUNTNAV): ?>

    <iframe id="iframepage" style="width:<?php echo $iframe_width ?>; height: 400px;" src="<?php echo $url; ?>"></iframe>

    <style>
        #iframepage {
            border: none;
            background: transparent url('<?php echo Yii::getAlias("@web/img/loader.gif"); ?>') center center no-repeat;
        }
	.panel.iframecontainer {
   	    background-color: transparent;
	    border: none;
	    box-shadow: none;
	}
    </style>

    <script>
        window.addEventListener("load", function (){$('#iframepage').parent().addClass("iframecontainer"); setSize()});
        window.addEventListener("resize", setSize);

        function setSize() {
            $('#iframepage').css('height', window.innerHeight - 100 + 'px');
            $('#iframepage').css('width', $('#iframepage').parent().outerWidth() - 1 + 'px');
        }
    </script>


<?php else: ?>

    <iframe id="iframepage" style="width:<?php echo $iframe_width ?>;height:400px" src="<?php echo $url; ?>"></iframe>

    <style>
        #iframepage {
            position: absolute;
            left: 0px;
            right: 0px;
            top: 50px;
            border: none;
            background: url('<?php echo Yii::getAlias("@web/img/loader.gif"); ?>') center center no-repeat;
        }
    </style>


    <script>
        window.addEventListener("load", setSize);
        window.addEventListener("resize", setSize);

        function setSize() {

            $('#iframepage').css('height', window.innerHeight - 50 + 'px');
            $('#iframepage').css('width', jQuery('body').outerWidth() - 1 + 'px');
        }
    </script>
<?php endif; ?>
