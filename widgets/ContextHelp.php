<?php

namespace humhub\modules\custom_pages\widgets;

use Yii;
use humhub\modules\custom_pages\models\CustomPage;

class ContextHelp extends \yii\base\Widget
{

    public function run()
    {
      $current_id = (Yii::$app->controller->module && Yii::$app->controller->module->id == 'custom_pages' && Yii::$app->controller->id == 'view') ? Yii::$app->request->get('id') : 1;
      $page = $current_id==NULL ? NULL : CustomPage::findOne(['id' => $current_id]);
      $url = "https://manuales.podemos.info/";
      if ($page != NULL) $url = $url."aplicacion-$page->application_id";
      return $this->render('contextHelp', [ "url" => $url ] );
    }

}
