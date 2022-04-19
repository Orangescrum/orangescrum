<?php

class InvoiceCustomer extends AppModel {

    public $validate = array(
        /* 'title' => array(
          'alphaNumeric' => array(
          'rule' => 'alphaNumeric',
          'required' => false,
          'message' => 'Invalid title'
          #'message' => 'Letters and numbers only'
          ),
          ), */
        'first_name' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Invalid first name'
            #'message' => 'Letters and numbers only'
            ),
        ),
        /* 'last_name' => array(
          'alphaNumeric' => array(
          'rule' => 'alphaNumeric',
          'required' => false,
          'message' => 'Invalid last name'
          #'message' => 'Letters and numbers only'
          ),
          ), */
        'currency' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Invalid Currency'
            #'message' => 'Letters and numbers only'
            ),
            'currencyExist' => array(
                'rule' => 'currencyExist',
                'required' => true,
                'message' => 'Currency not found'
            #'message' => 'Letters and numbers only'
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'required' => true,
                'message' => 'Invalid email address'
            ),
        ),
        #'email' => 'email',
        'phone' => array(
            #'rule' => array('phone', null, 'all'),
            'rule' => 'numeric',
            'message' => 'Invalid phone number',
            'allowEmpty' => true,
            'required' => false,
        ),
        /*'zipcode' => array(
            'rule' => array('postal', null, 'all')
        ),*/
    );

    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];
        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
    }

    public function currencyExist($check) {
        $value = array_values($check);
        $value = $value[0];
        $res = $this->query('SELECT * FROM currencies WHERE LOWER(code) =\'' . strtolower($value) . '\'');
        return !empty($res);
    }
	function addDummyCustomer($project_id, $comp_id, $user_id){
		$customer = array();
		$customer_ret = array();
		$key_arr = array(0=>'title',
						1=> 'first_name',
						2=> 'last_name',
						3=> 'email',
						4=> 'currency',
						5=> 'organization',
						6=> 'street',
						7=> 'city',
						8=> 'state',
						9=> 'country',
						10=> 'zipcode',
						11=> 'phone',
						12 => 'status',
						);
		
		if (($handle = fopen(CSV_PATH . "dummy_project/Orangescrum_invoice.csv", "r")) !== FALSE) {
			App::import('Component', 'Format');
			$format = new FormatComponent(new ComponentCollection);
			$i = 0;
			$j = 0;
			$separator = ',';
			$chk_coma = $data = fgetcsv($handle, 1000, ",");
			if (count($chk_coma) == 1 && stristr($chk_coma[0], ";")) {
				$separator = ';';
			}
			rewind($handle);
			$project_list = array();
			while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
				if (!$i) {
					$i++;
				}else{
					if($data){
						$currencyCode = 0;
						foreach($data as $k=>$v){	
							if(empty($v)){
								$customer[$key_arr[$k]] = NULL;
							}
							/*else if($k == 4){
								if (trim($v) != '' || trim($v) != 0) {
									$currencyCode = $format->getCurrencyCode($v);
								}
								$customer[$key_arr[$k]] = $currencyCode;
							}*/
							else{
								$customer[$key_arr[$k]] = $v;
							}
						}
						$customer['user_id'] = 0;            
						$customer['uniq_id'] = $format->generateUniqNumber();
						$customer['project_id'] = $project_id;
						$customer['company_id'] = $comp_id;
						$customer['created'] = date("Y-m-d H:i:s"); 
						$customer['modified'] = date("Y-m-d H:i:s");
						$this->create();
						$this->save($customer, array('validate' => false));
						array_push($customer_ret, $this->getLastInsertID());
					}
				}
			}
		}
		return $customer_ret;
		
	}
}