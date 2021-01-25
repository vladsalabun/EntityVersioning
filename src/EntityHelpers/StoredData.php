<?php

namespace Salabun\EntityHelpers;

/**
 *  Обробник збережених даних:
 */
Trait StoredData
{
    /** 
     *  Збережені властивості:
     */
    private $storedProperties = [];

    /** 
     *  Версії збережених властивостей:
     */
    private $storedPropertiesVersions = [];
    
    /** 
     *  Додати збережені властивості:
     */
    public function addStoredProperties($array) 
    {
        if(is_array($array)) {
            $this->storedProperties = array_merge($this->storedProperties, $array);
        }
        
        return $this;
    }

    /** 
     *  Додати версії збережених властивостей:
     */
    public function addStoredPropertiesVersions($array) 
    {
        if(is_array($array)) {
            $this->storedPropertiesVersions = array_merge($this->storedPropertiesVersions, $array);
        }
        
        return $this;
    }
    
    /** 
     *  Повертає збережені властивості:
     */
    public function getStoredProperties() 
    {
        return $this->storedProperties;
    }
    
    /** 
     *  Повертає версії збережених властивостей:
     */
    public function getStoredPropertiesVersions()
    {
        return $this->storedPropertiesVersions;
    }

}