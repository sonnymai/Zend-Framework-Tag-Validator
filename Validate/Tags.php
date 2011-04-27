<?php

/**
 * This class validates the number of tags and also the length of tags
 */

class My_Validate_Tags extends Zend_Validate_Abstract
{
    const INVALID_MAXTAGS = 'maxTags';
    const INVALID_TAGLENGTH = 'tagLength';

    protected $_maxTags;
    protected $_maxTagLength;
    protected $_tagArray;
    protected $_messageTemplates = array(
        self::INVALID_MAXTAGS => "You have specified more than %maxTags% tags",
        self::INVALID_TAGLENGTH => "Individual tags should be less than %maxTagLength% characters",
    );
    protected $_messageVariables = array(
        'maxTags' => '_maxTags',
        'maxTagLength' => '_maxTagLength'
    );

    /**
     *
     * @param int $maxTags : Maximum number of tags allowed
     * @param int $maxTagLength : Maximum length of an individual tag
     */
    public function __construct($maxTags, $maxTagLength)
    {
        $this->_maxTags = $maxTags;
        $this->_maxTagLength = $maxTagLength;
    }

    /**
     * Check if the input value is valid
     * 
     * @param String $value : the value to be validated ( a string of tags)
     * @return boolean
     */
    public function isValid($value)
    {

        $processTags = new My_Tags_Process();
        $this->_tagArray = $processTags->getFilteredTags($value);
        
        if ( $this->_maxTags != 0 ) {
            if ( !$this->_checkTagCount() ) {
                $this->_error(self::INVALID_MAXTAGS);
                return false;
            }
        }

        if ( !$this->_checkTagLength() ) {
            $this->_error(self::INVALID_TAGLENGTH);
            return false;
        }
        return true;
    }

    /**
     * Check the number of tags
     * 
     * @return boolean
     */
    private function _checkTagCount()
    {
        if ( count($this->_tagArray) > $this->_maxTags ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check if a tag is longer the MaxTagLength
     *
     * @return boolean
     */
    private function _checkTagLength()
    {
        foreach ( $this->_tagArray as $tag ) {
            if ( strlen($tag) > $this->_maxTagLength ) {
                return false;
            }
        }
        return true;
    }

}