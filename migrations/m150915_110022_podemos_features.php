<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_110022_podemos_features extends Migration
{
    public function up()
    {
        $this->addColumn('custom_pages_page', 'application_id', 'integer');
        $this->addColumn('custom_pages_page', 'iframe_width', 'varchar(10)');
        $this->addColumn('custom_pages_page', 'link_target', 'varchar(255)');
        $this->addColumn('custom_pages_page', 'show_on_top', 'varchar(1)');
    }

    public function down()
    {
        echo "m150915_110022_podemos_features cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
