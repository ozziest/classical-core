<?php namespace Ozziest\Core\Helpers;

class ReplacerHelper {
    
    private $content;
    
    /**
     * Class constructor
     * 
     * @param  string   $content
     * @return null
     */
    public function __construct($content)
    {
        $this->content = $content;
    }
        
    /**
     * This method replace the old value with the new one
     * 
     * @param  string   $old
     * @param  string   $new
     * @return self
     */
    public function replace($old, $new)
    {
        $this->content = str_replace('{'.$old.'}', $new, $this->content);
        return $this;
    }
    
    /**
     * This method gets the content
     * 
     * @return string
     */
    public function toString()
    {
        return $this->content;
    }
    
}