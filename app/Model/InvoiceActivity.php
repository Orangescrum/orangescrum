<?php

class InvoiceActivity extends AppModel {

    public $name = 'InvoiceActivity';
    public $belongsTo = array(
        'Invoice' => array(
            'className' => 'Invoice',
            'foreignKey' => 'invoice_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
    );
}