<?php

/**
 * This is the model base class for the table "abstract_user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AbstractUser".
 *
 * Columns in table "abstract_user" available as properties of the model,
 * followed by relations of table "abstract_user" available as properties of the model.
 *
 * @property integer $id
 * @property string $app_user_id
 *
 * @property AbstractMessage[] $abstractMessages
 * @property Vote[] $votes
 */
abstract class BaseAbstractUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'abstract_user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AbstractUser|AbstractUsers', $n);
	}

	public static function representingColumn() {
		return 'app_user_id';
	}

	public function rules() {
		return array(
			array('app_user_id', 'required'),
			array('app_user_id', 'length', 'max'=>45),
			array('id, app_user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'abstractMessages' => array(self::HAS_MANY, 'AbstractMessage', 'abstract_user_id'),
			'votes' => array(self::HAS_MANY, 'Vote', 'abstract_user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'app_user_id' => Yii::t('app', 'App User'),
			'abstractMessages' => null,
			'votes' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('app_user_id', $this->app_user_id, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}