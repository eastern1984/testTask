<?php

use yii\db\Migration;

/**
 * Class m171205_152039_add_field_to_dish_table
 */
class m171205_152039_add_field_to_dish_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dish', 'status', $this->integer()->defaultValue(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dish', 'status');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171205_152039_add_field_to_dish_table cannot be reverted.\n";

        return false;
    }
    */
}
