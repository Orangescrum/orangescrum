<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP FeatureSetting
 * @author Andolasoft
 */
class FeatureSetting extends AppModel {
    public $name = 'FeatureSetting';    
    function getSettings(){ 
        $settings = $this->find('first', array('conditions'=>array('FeatureSetting.company_id' => SES_COMP)));
        return $settings;
    }
}