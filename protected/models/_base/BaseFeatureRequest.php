<?php

/**
 * This is the model base class for the table "featurerequest".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FeatureRequest".
 *
 * Columns in table "featurerequest" available as properties of the model,
 * followed by relations of table "featurerequest" available as properties of the model.
 *
 * @property integer $id
 * @property string $status
 *
 * @property Abstractmessage $id0
 * @property Vote[] $votes
 */
abstract class BaseFeatureRequest extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'featurerequest';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'FeatureRequest|FeatureRequests', $n);
	}

	public static function representingColumn() {
		return 'status';
	}

	public function rules() {
		return array(
			array('id', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>10),
			array('status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'id0' => array(self::BELONGS_TO, 'Abstractmessage', 'id'),
			'votes' => array(self::HAS_MANY, 'Vote', 'featureRequest_nr'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => null,
			'status' => Yii::t('app', 'Status'),
			'id0' => null,
			'votes' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('status', $this->status, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}