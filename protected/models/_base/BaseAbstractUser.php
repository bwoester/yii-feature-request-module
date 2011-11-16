<?php

/**
 * This is the model base class for the table "abstractuser".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AbstractUser".
 *
 * Columns in table "abstractuser" available as properties of the model,
 * followed by relations of table "abstractuser" available as properties of the model.
 *
 * @property integer $id
 *
 * @property Abstractmessage[] $abstractmessages
 * @property Vote[] $votes
 */
abstract class BaseAbstractUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'abstractuser';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AbstractUser|AbstractUsers', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'abstractmessages' => array(self::HAS_MANY, 'Abstractmessage', 'id'),
			'votes' => array(self::HAS_MANY, 'Vote', 'user_nr'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'abstractmessages' => null,
			'votes' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}