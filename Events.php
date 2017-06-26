<?php
namespace humhub\modules\custom_pages;

use Yii;
use yii\helpers\Url;
use humhub\modules\custom_pages\models\CustomPage;

/**
 * CustomPagesEvents
 *
 * @author luke
 */
class Events extends \yii\base\Object
{
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('CustomPagesModule.base', 'Custom Pages'),
            'url' => Url::to(['/custom_pages/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-file-o"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_pages' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 300,
        ));

        // Check for Admin Menu Pages to insert
    }

    public static function onTopMenuInit($event)
    {
	$applications = Events::getApplications(Yii::$app->user->getIdentity()->username);
        foreach (CustomPage::findAll(['navigation_class' => CustomPage::NAV_CLASS_TOPNAV]) as $page) {

            // Admin only
            if ($page->admin_only == 1 && !Yii::$app->user->isAdmin()) {
                continue;
            }

            if ($page->application_id && !in_array($page->application_id, $applications)) {
                continue;
            }

            $event->sender->addItem(array(
                'label' => $page->title,
                'url' => Url::to(['/custom_pages/view', 'id' => $page->id]),
                'target' => ($page->type == CustomPage::TYPE_LINK) ? $page->link_target : '',
                'icon' => '<i class="fa ' . $page->icon . '"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_pages' && Yii::$app->controller->id == 'view' && Yii::$app->request->get('id') == $page->id),
                'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000,
                'show_on_top' => $page->show_on_top,
            ));
        }
    }

    public static function onAccountMenuInit($event)
    {
	    $applications = Events::getApplications(Yii::$app->user->getIdentity()->username);
        $current_id = (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_pages' && Yii::$app->controller->id == 'view') ? Yii::$app->request->get('id') : NULL;
        foreach (CustomPage::findAll(['navigation_class' => CustomPage::NAV_CLASS_ACCOUNTNAV]) as $page) {
            // Admin only
            if ($page->admin_only == 1 && !Yii::$app->user->isAdmin()) {
                continue;
            }

            if ($page->application_id && !in_array($page->application_id, $applications)) {
                continue;
            }

            $event->sender->addItem(array(
                'label' => $page->title,
                'url' => Url::to(['/custom_pages/view', 'id' => $page->id]),
                'target' => ($page->type == CustomPage::TYPE_LINK) ? $page->link_target : '',
                'icon' => '<i class="fa ' . $page->icon . '"></i>',
                'isActive' => ($current_id == $page->id),
                'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000,
                'show_on_top' => $page->show_on_top,
            ));
        }
    }

    public static function onTopMenuRightInit($event)
    {
        //$event->sender->addWidget(widgets\ContextHelp::className());
    }

    public static function getApplications($user)
    { 
        $applications = \PodemosAuth::get_data($user,"aplicaciones",$location=NULL,$action=NULL,$object=NULL,$query=NULL,$application_id=-1);
        if ($applications)
            return array_map(function($app){return $app->id;}, $applications);
        else
            return [];
    }
}
