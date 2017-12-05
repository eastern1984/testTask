<?php

use yii\db\Migration;

/**
 * Class m171205_113049_add_tables
 */
class m171205_113049_add_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ingridient', [
            'id' => $this->primaryKey(),
            'name'             => $this->string(32),
            'status'                => $this->integer(),
        ]);

        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'name'             => $this->string(32),
            'ingredients'                => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ingridient');
        $this->dropTable('dish');
        return true;
    }
}
