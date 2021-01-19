<?php

namespace Salabun;

use Salabun\EntityHelpers\IncomingData;
use Salabun\EntityHelpers\StoredData;
use Salabun\EntityHelpers\DataController;

/**
 *  This package takes control with entity versions.
 */
class EntityVersioning
{
    use IncomingData, StoredData, DataController;

    /** 
     *  Цей метод зливає вхідні та збережені властивості сутності.
     */
    public function merge()
    {        
        $this->checkIncomingVersions();

        // Зберігаю поточну версію сутності з усіма її властивостями та версіями:
        $this->entity = $this->getStoredProperties();
        $this->entityVersions = $this->getStoredPropertiesVersions();
        
        // Обробляю:
        foreach($this->getIncomingProperties() as $incomingProperty => $incomingValue) {
            
            // Беру в обробку лише ті властивості, які дозволено:
            if (in_array($incomingProperty, $this->getComparativeProperties())) {
                
                // Якщо вхідні дані мають версію властивості більшу, ніж збережена:
                if($this->getIncomingPropertiesVersions()[$incomingProperty] > $this->getStoredPropertiesVersions()[$incomingProperty]) {
                    
                    // Зберігаю зміни, які відбулись:
                    $this->saveStoredPropertyChanges([
                        'property' => $incomingProperty,
                        'old_value' => $this->getStoredProperties()[$incomingProperty],
                        'new_value' => $this->getIncomingProperties()[$incomingProperty],
                        'old_version' => $this->getStoredPropertiesVersions()[$incomingProperty],
                        'new_version' => $this->getIncomingPropertiesVersions()[$incomingProperty],
                    ]);
                    
                    // Застосовую зміни:
                    $this->changeEntityProperty($incomingProperty, $incomingValue);
                    $this->changeEntityPropertyVersion($incomingProperty, $this->getIncomingPropertiesVersions()[$incomingProperty]);
                }
                    
            }
        }

        // Знищую усі дані:
        $this->clearData();

    }
        
    /** 
     *  Перевіряю версії вхідних та збережених даних.
     *  Якщо версії не вказано, то буде встановлена версія 1.
     */
    private function checkIncomingVersions() 
	{
        $properties = array_keys($this->getIncomingPropertiesVersions()); 

        foreach($this->getComparativeProperties() as $comparativeProperty) {
            
            // Якщо властивості немає, але дані є, тоді встановлюю версію 1:
            if (!in_array($comparativeProperty, $properties) and key_exists($comparativeProperty, $this->getIncomingProperties())) {
                
                // Додаю її, та встановлюю версію:
                $this->addIncomingPropertiesVersions([
                    $comparativeProperty => 1,
                ]);
                
            }
            
        }
	}
    
    /** 
     *  Знищую усі дані:
     */
    private function clearData() 
	{
        
	}
}
