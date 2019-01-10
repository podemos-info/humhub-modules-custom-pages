<?php

namespace humhub\modules\custom_pages\models;

use humhub\modules\custom_pages\models\forms\SettingsForm;
use Yii;
use humhub\components\ActiveRecord;
use humhub\modules\custom_pages\components\Container;
use humhub\modules\custom_pages\modules\template\models\Template;

/**
 * This is the model class for table "custom_pages_page".
 *
 * Pages are global custom page container which can be added to the main navigation or
 * user account setting navigation.
 * 
 * The followings are the available columns in table 'custom_pages_page':
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $icon
 * @property string $content
 * @property integer $sort_order
 * @property integer $admin_only
 * @property integer $in_new_window
 * @property string $navigation_class
 * @property string $cssClass
 * @property string $url
 * @property string $link_target
 */
class Page extends ActiveRecord implements CustomContentContainer
{

    const NAV_CLASS_TOPNAV = 'TopMenuWidget';
    const NAV_CLASS_ACCOUNTNAV = 'AccountMenuWidget';
    const NAV_CLASS_EMPTY = 'WithOutMenu';
    const NAV_CLASS_DIRECTORY = 'DirectoryMenu'; //in humhub\modules\directory\widgets\Menu

    /**
     * @inhritdoc
     */
    public function behaviors()
    {
        return [
            ['class' => Container::className()],
        ];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'custom_pages_page';
    }

    /**
     * @inheritdoc
     */
    public function getPageContentProperty() {
        return 'content';
    }
    
    /**
     * @inerhitdoc
     * @return array
     */
    public function attributeLabels()
    {
        $result = $this->defaultAttributeLabels();
        $result['in_new_window'] = Yii::t('CustomPagesModule.models_Page', 'Open in new window');
        $result['navigation_class'] = Yii::t('CustomPagesModule.models_Page','Navigation');
        $result['url'] = Yii::t('CustomPagesModule.models_Page','Url shortcut');
        $result['application_id'] = 'Application ID';
        $result['show_on_top'] = 'Show on Top Bar';
        $result['iframe_width'] = 'Iframe width';
        $result['link_target'] = 'Link target';
        return $result;
    }

    /**
     * @inhritdoc
     */
    public function rules()
    {
        $rules = $this->defaultRules();
        $rules[] = ['navigation_class', 'required'];
        $rules[] = [['type', 'sort_order', 'admin_only', 'application_id', 'show_on_top'], 'integer'];
        $rules[] = [['in_new_window', 'admin_only'], 'integer'];
        $rules[] = [['url'], 'unique', 'skipOnEmpty' => 'true'];
        $rules[] = [['content', 'url'], 'safe'];
        $rules[] = [['icon', 'iframe_width', 'link_target'], 'string', 'max' => 100];
        return $rules;
    }

    /**
     * Returns a container specific title mainly used in views.
     * @return string
     */
    public function getLabel()
    {
        return Yii::t('CustomPagesModule.models_Page', 'page');
    }

    /**
     * Returns a navigation selection for all navigations this page can be added.
     * @return array
     */
    public static function getNavigationClasses()
    {
        return [
            self::NAV_CLASS_TOPNAV => Yii::t('CustomPagesModule.base', 'Top Navigation'),
            self::NAV_CLASS_ACCOUNTNAV => Yii::t('CustomPagesModule.base', 'User Account Menu (Settings)'),
            self::NAV_CLASS_DIRECTORY => Yii::t('CustomPagesModule.base', 'Directory Menu'),
            self::NAV_CLASS_EMPTY => Yii::t('CustomPagesModule.base', 'Without adding to navigation (Direct link)'),
        ];
    }

    /**
     * Returns an array of all allowed conten types for this container type.
     * @return integer[]
     */
    public function getContentTypes()
    {
        return [
            Container::TYPE_LINK,
            Container::TYPE_HTML,
            Container::TYPE_MARKDOWN,
            Container::TYPE_IFRAME,
            Container::TYPE_TEMPLATE,
            Container::TYPE_PHP,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getPageContent()
    {
        return $this->content;
    }
    
    /**
     * @inheritdoc
     */
    public function getAllowedTemplateSelection()
    {
        return Template::getSelection(['type' => Template::TYPE_LAYOUT]);
    }

    /**
     * @inheritdoc
     */
    public function getPhpViewPath()
    {
        $settings = new SettingsForm();
        return $settings->phpGlobalPagePath;
    }
}
