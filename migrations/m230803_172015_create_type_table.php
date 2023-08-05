<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type}}`.
 */
class m230803_172015_create_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}

        $this->createTable('{{%type}}', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%type}}');
    }
}
