<?php

Yii::import( '_featureRequests.components.textTruncator.DOMLettersIterator' );
Yii::import( '_featureRequests.components.textTruncator.DOMWordsIterator' );
Yii::import( '_featureRequests.components.textTruncator.TruncateHTML' );

/**
 * Description of TextTruncator
 *
 * @author Benjamin
 */
class TextTruncator extends CApplicationComponent
{
  const COUNT_WORDS = 0;
  const COUNT_CHARACTERS = 1;

  /////////////////////////////////////////////////////////////////////////////

  public function init()
  {
    parent::init();
  }

  /////////////////////////////////////////////////////////////////////////////

  static public function truncate( $text, $length, $countMode=self::COUNT_WORDS, $append='...' )
  {
    $retVal = $text;

    if (self::isHtml($text)) {
      $retVal = self::truncateHtml( $text, $length, $countMode, $append );
    } else {
      $retVal = self::truncateText( $text, $length, $countMode, $append );
    }

    return $retVal;
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * Checks if the provided parameter contains valid html.
   * 
   * @param string $text
   * @return bool
   */
  static private function isHtml( $text )
  {
    $previous = libxml_use_internal_errors( true );
    libxml_clear_errors();

    $dom = new DOMDocument();
    @$dom->loadHTML( $html );
    
    libxml_use_internal_errors( $previous );
    $aErrors = libxml_get_errors();

    return count($aErrors) === 0;
  }

  /////////////////////////////////////////////////////////////////////////////

  static private function truncateHtml( $text, $length, $countMode, $append )
  {
    $retVal = $text;

    switch ($countMode)
    {
    case self::COUNT_WORDS:
        $retVal = TruncateHTML::truncateWords( $text, $length, $append );
        break;
    case self::COUNT_CHARACTERS:
    default:
        $retVal = TruncateHTML::truncateChars( $text, $length, $append );
        break;
    }

    return $retVal;
  }

  /////////////////////////////////////////////////////////////////////////////

  static private function truncateText( $text, $length, $countMode, $append )
  {
    $retVal = $text;

    switch ($countMode)
    {
    case self::COUNT_WORDS:
        $retVal = self::truncateWords( $text, $length, $append );
        break;
    case self::COUNT_CHARACTERS:
    default:
        $retVal = self::truncateChars( $text, $length, $append );
        break;
    }

    return $retVal;
  }

  /////////////////////////////////////////////////////////////////////////////

  static private function truncateWords( $text, $length, $append )
  {
    $retVal = $text;
    $result = preg_match_all( '/(\w.+?)\w/', $text, $aMatches );

    if ($result !== false && $result > $length)
    {
      $aMatches = array_slice( $aMatches, 0, $length );
      $retVal = implode( ' ', $aMatches );
      $retVal .= $append;
    }

    return $retVal;
  }

  /////////////////////////////////////////////////////////////////////////////

  static private function truncateChars( $text, $length, $append )
  {
    $retVal = $text;

    if (strlen($result) > $length)
    {
      $retVal = substr($text, 0, $length );
      $retVal .= $append;
    }

    return $retVal;
  }

  /////////////////////////////////////////////////////////////////////////////

}
