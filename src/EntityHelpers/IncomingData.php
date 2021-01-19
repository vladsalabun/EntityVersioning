<?php

namespace Salabun\EntityHelpers;

/**
 *  Обробник вхідних даних:
 */
Trait IncomingData
{
    /** 
     *  Вхідні властивості:
     */
    private $incomingProperties = [];

    /** 
     *  Версії вхідних властивостей:
     */
    private $incomingPropertiesVersions = [];
    
    /** 
     *  Додати вхідні властивості:
     */
	public function addIncomingProperties($array) 
	{
        if(is_array($array)) {
            $this->incomingProperties = array_merge($this->incomingProperties, $array);
        }
        
        return $this;
	}

    /** 
     *  Додати версії вхідних властивостей:
     */
	public function addIncomingPropertiesVersions($array) 
	{
        if(is_array($array)) {
            $this->incomingPropertiesVersions = array_merge($this->incomingPropertiesVersions, $array);
        }
        
        return $this;
	}
    
    /** 
     *  Повертає вхідні властивості:
     */
	public function getIncomingProperties() 
	{
        return $this->incomingProperties;
	}
    
    /** 
     *  Повертає версії вхідних властивостей:
     */
	public function getIncomingPropertiesVersions() 
	{
        return $this->incomingPropertiesVersions;
	}
    
}