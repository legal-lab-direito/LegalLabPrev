<?php

class Files extends TRecord
{
    const TABLENAME  = 'files';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    private $category;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('category_id');
        parent::addAttribute('description');
        parent::addAttribute('file');
            
    }

    /**
     * Method set_category
     * Sample of usage: $var->category = $object;
     * @param $object Instance of Category
     */
    public function set_category(Category $object)
    {
        $this->category = $object;
        $this->category_id = $object->id;
    }

    /**
     * Method get_category
     * Sample of usage: $var->category->attribute;
     * @returns Category instance
     */
    public function get_category()
    {
    
        // loads the associated object
        if (empty($this->category))
            $this->category = new Category($this->category_id);
    
        // returns the associated object
        return $this->category;
    }

    
}

