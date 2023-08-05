<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230803_172311_create_product_table extends Migration
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

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
			'image' => $this->string(),
			'sku' => $this->string(),
			'name' => $this->string()->notNull(),
			'stock_units' => $this->integer()->defaultValue(0),
			'type_id' => $this->integer()->notNull()
        ], $tableOptions);

		$this->createIndex('idx-product-type', 'product', 'type_id');
		$this->addForeignKey(
			'fk-product-type',
			'product',
			'type_id',
			'type',
			'id',
			'CASCADE'
		);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
		$this->dropForeignKey(
			'fk-product-type',
			'product'
		);

        $this->dropTable('{{%product}}');
    }
}
