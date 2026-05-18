<?php

App::uses('AppModel', 'Model');

class Beneficiary extends AppModel {

    public $belongsTo = array(
        'Crud' => array(
            'className' => 'Crud',
            'foreignKey' => 'crud_id'
        )
    );

}