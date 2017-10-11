<?php
use \humhub\modules\custom_pages\models\Page;

$cssClass = ($page->hasAttribute('cssClass') && !empty($page->cssClass)) ? $page->cssClass : 'custom-pages-page';
$margin = $navigationClass == Page::NAV_CLASS_TOPNAV ? -15 : 0;
?>

<style>
    #iframepage {
        border: none;
        <?= $margin ? 'margin-top:'.$margin.'px;' : ''?>        
        background: url('<?= Yii::$app->moduleManager->getModule('custom_pages')->getPublishedUrl('/loader.gif'); ?>') center center no-repeat;
    }
</style>

<iframe class="<?= $cssClass ?>" id="iframepage" style="width:100%;height: 100%" src="<?php echo $url; ?>?rand=<?php echo rand(); ?>"></iframe>    


<script>
    function setSize() {
        $('#iframepage').css('height', (window.innerHeight - $('#iframepage').position().top - <?=$margin?> - 15) + 'px');
    }
    
    // execute setSize in the beginning, else dynamically loaded content in the 
    // Iframe gets the wrong size to work with
    setSize();

    window.onresize = function (evt) {
        setSize();
    };

    $(document).on('humhub:ready', function () {
        $('#iframepage').load(function () {
            setSize();
        });
    });

</script>
