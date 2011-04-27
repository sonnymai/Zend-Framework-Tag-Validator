<?php
class My_Tags_Process
{
    /**
     *  This function processing a comma seperated string and returns each value inside an
     * array. All values are filtered for unnecessary whitespace and null values.
     * Duplicated values are also removed
     *
     * @param String $tagString : The string containing comma seperated tags. e.g. "eggs, salt, flour"
     * @return array : array of filtered tags [ 0 => string, ... n => string]
     */
    public static function getFilteredTags($tagString)
    {
        if(!$tagString){
            return false;
        }
        
        $tagArray = explode(',' , $tagString);
        $filter = new Zend_Filter_StringTrim();
        foreach($tagArray as $text){
            $text = $filter->filter($text);
            $text = preg_replace('~\s{1,}~', ' ', $text); //removes any whitespace (including tabs) and replaces with a single space
            $text = ucwords(strtolower(trim($text, '"\'`')));
            if($text || $text == ' '){//if tag value is null or just a space, don't add to the array
                $tags[] = $text;
            }
        }
        $tags = array_unique($tags); //removes duplicate tags
        return $tags;
    }
}