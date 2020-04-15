<?php

use humhub\modules\custom_pages\models\Page;
use humhub\modules\content\widgets\richtext\RichText;
use humhub\libs\Html;

/* @var $page Page*/

$cssClass = ($page->hasAttribute('cssClass') && !empty($page->cssClass)) ? $page->cssClass : 'custom-pages-page';
?>

<?php if ($page->hasTarget(Page::NAV_CLASS_ACCOUNTNAV) ||
          $page->hasTarget(Page::NAV_CLASS_DIRECTORY)): ?>
    <div class="panel panel-default <?= Html::encode($cssClass) ?>">
        <div class="panel-body">
            <?= RichText::output($md)?>
        </div>
    </div>
<?php else: ?>
    <div class="container <?=  Html::encode($cssClass) ?>">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= RichText::output($md)?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>