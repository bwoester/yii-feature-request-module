<?php



/**
 * Description of FRHelper
 *
 * @author Benjamin
 */
class FRHelper
{
  /**
   * @see "http://learnyii.blogspot.com/2011/07/yii-json-cjson-models-model-related.html"
   * @param array $aModels the models you want to encode
   * @param string $with comma separated list of relations
   */
  public static function jsonEncode( $aModels, $with=array() )
  {
    $rows = array(); //the rows to output

    /* @var $model CActiveRecord */
    foreach ($aModels as $model)
    {
      $row = $model->attributes;

      foreach ($with as $relationName) {
        $row[$relationName] = CHtml::value( $model, $relationName );
      }

      $rows[] = $row;
    }

    return CJSON::encode( $rows );
  }
}
