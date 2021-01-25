<?php

namespace Salabun\EntityHelpers;

/**
 *  Обробник збережених даних:
 */
Trait DataController
{
    /** 
     *  Тип обробки версій:
     */
    private $versioningTypes = [
        'TINYINT'   => 255,         // 1 байт
        'SMALLINT'  => 65535,       // 2 байти
        'INT'       => 4294967295,  // 4 байти
    ];

    private $versioningType = 'INT';
    
    /** 
     *  Кількість змін у сутності:
     */
    private $updatedPropertiesCount = 0;
    
    /** 
     *  Кількість відхилених версій: 
     */
    private $rejectedPropertiesCount = 0;
     
    /** 
     *  Тут зберігаються всі властивості сутності, по яких буде проходити порівняння версій: 
     */
    private $comparativeProperties = [];
     
    /** 
     *  Постфікс для версій властивостей:
     */
    private $entityPostfix = '_version';
    
    /** 
     *  Усі властивості сутності:
     */
    private $entity = [];
    
    /** 
     *  Усі версії властивостей сутності:
     */
    private $entityVersions = [];
    
    /** 
     *  Інформація про зміни у властивостях:
     */
    private $chengedProperties = [];
    
    /** 
     *  Встановлює тип обробки версій:
     */
    public function setVersioningType($value)
    {
        if (key_exists($value, $this->versioningTypes)) {
            $this->versioningType = $value;
        }
       
        return $this;        
    }          
    
    /** 
     *  Додати одну властивість, по якій буде проходити порівняння:
     */
    public function addComparativeProperty($string)
    {
        if(is_string($string)) {
            $this->comparativeProperties[] = $string;
        }
        
        return $this;
    }
    
    /** 
     *  Додати властивості, по яких буде проходити порівняння:
     */
    public function addComparativeProperties($array)
    {
        if(is_array($array)) {
            $this->comparativeProperties = array_merge($this->comparativeProperties, $array);
        }
        
        return $this;
    }
    
    /** 
     *  Повертає властивості, по яких буде проходити порівняння:
     */
    public function getComparativeProperties()
    {
        return $this->comparativeProperties;
    }
    
    /** 
     *  Встановити постфікс версії сутності:
     */
    public function setEntityPostfix($string)
    {
        $this->entityPostfix = $string;
    }
    
    /** 
     *  Зберігаю зміну властивості:
     */
    private function saveStoredPropertyChanges($array)
    {
        $this->chengedProperties[$array['property']] = [
            'old_value' => $array['old_value'],
            'new_value' => $array['new_value'],
            'old_version' => $array['old_version'],
            'new_version' => $array['new_version'],
        ];
    }
    

    /** 
     *  Змінюю збережену властивість:
     */
    private function changeEntityProperty($property, $value)
    {
        $this->entity[$property] = $value;     
    }
    
    /** 
     *  Змінюю версію збереженої властивості:
     */
    private function changeEntityPropertyVersion($property, $version)
    {
        // Дізнаюсь якою буде наступна версія сутності:
        $maxVersion = $this->versioningTypes[$this->versioningType]; 

        $this->entityVersions[$property] = $version;
    }
    
    /** 
     *  Повертає перелік змінених властивостей сутності з її минулими значеннями та версіями:
     */
    public function getStoredPropertyChanges()
    {
        return $this->chengedProperties;
    }
    /** 
     *  Повертає усі змінені властивості злитої сутності:
     */
    public function getNewProperties()
    {
        $array = [];
        
        foreach($this->chengedProperties as $chengedProperty => $info) {
             $array[$chengedProperty] = $info['new_value'];
        }
        
        return $array;
    }
    
    /** 
     *  Повертає версії усіх властивостей злитої сутності:
     */
    public function getEntityVersions()
    {
        return $this->entityVersions;
    }
    
    /** 
     *  Повертає усі змінені версії сутності:
     */
    public function getNewVersions()
    {
        $array = [];
        
        $newProperties = $this->getNewProperties();
        
        foreach($newProperties as $property => $value) {
             $array[$property] = $this->getEntityVersions()[$property];
        }
        
        return $array;
    }
    
    /** 
     *  Повертає лише злиту сутність:
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /** 
     *  Повертає злиту сутність включно з новими версіями її властивостей:
     */
    public function getEntityWithVersions()
    {
        $array = $this->entity;
        $array['versions'] = $this->entityVersions ;
        
        return $array;
    }
    
    /** 
     *  Повертає злиту сутність включно з новими версіями її властивостей в одновимірному масиві:
     */
    public function getEntityWithFlatVersions()
    {
        $array = $this->entity;

        foreach($this->entityVersions as $property => $version) {
            $array[$property . $this->entityPostfix] = $version;
        }
        
        ksort($array);
        
        return $array;
    }
    

    
}