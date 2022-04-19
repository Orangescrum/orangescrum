<?php

class Invoice extends AppModel {

    public $name = 'Invoice';
    public $hasMany = array(
        'InvoiceLog' => array(
            'dependent' => true,
            'order' => 'created ASC',
        )
    );

}