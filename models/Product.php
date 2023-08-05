<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $sku
 * @property string $name
 * @property int|null $stock_units
 * @property int $type_id
 *
 * @property Type $type
 */
class Product extends ActiveRecord
{
	public $upload;
	public $removeImage;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'product';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'type_id'], 'required'],
			[['stock_units', 'type_id'], 'integer'],
			[['removeImage'], 'boolean'],
			[['image'], 'image', 'extensions' => 'jpg, jpeg, webp, gif, png'],
			[['sku', 'name'], 'string', 'max' => 255],
			[['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'image' => 'Изображение',
			'sku' => 'SKU',
			'name' => 'Название',
			'stock_units' => 'Кол-во на складе',
			'type_id' => 'Тип товара',
			'type.name' => 'Тип товара',
		];
	}

	/**
	 * Gets query for [[Type]].
	 *
	 * @return ActiveQuery
	 */
	public function getType()
	{
		return $this->hasOne(Type::class, ['id' => 'type_id']);
	}

	public function uploadImage()
	{
		if ($this->upload) {
			$name = '/uploads/' . $this->randomFileName($this->upload->extension);
			$source = Yii::getAlias('@webroot' . $name);
			if ($this->upload->saveAs($source)) {
				return $name;
			}
		}
		return false;
	}

	public static function removeImage($name) {
		if (!empty($name)) {
			$source = Yii::getAlias('@webroot' . $name);
			if (is_file($source)) {
				unlink($source);
			}
		}
	}

	public function afterDelete() {
		parent::afterDelete();
		self::removeImage($this->image);
	}

	public function randomFileName($extension = false)
	{
		$extension = $extension ? '.' . $extension : '';
		do {
			$name = md5(microtime() . rand(0, 1000));
			$file = $name . $extension;
		} while (file_exists($file));

		return $file;
	}
}
