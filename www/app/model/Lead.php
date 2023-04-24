<?php

class Lead extends TRecord
{
    const TABLENAME  = 'lead';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('email');
        parent::addAttribute('date_birth');
        parent::addAttribute('telephone');
            
    }

    
}

