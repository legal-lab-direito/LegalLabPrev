<?php

class Subject extends TRecord
{
    const TABLENAME  = 'subject';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('description');
            
    }

    /**
     * Method getCategorys
     */
    public function getCategorys()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('subject_id', '=', $this->id));
        return Category::getObjects( $criteria );
    }

    public function set_category_subject_to_string($category_subject_to_string)
    {
        if(is_array($category_subject_to_string))
        {
            $values = Subject::where('id', 'in', $category_subject_to_string)->getIndexedArray('description', 'description');
            $this->category_subject_to_string = implode(', ', $values);
        }
        else
        {
            $this->category_subject_to_string = $category_subject_to_string;
        }

        $this->vdata['category_subject_to_string'] = $this->category_subject_to_string;
    }

    public function get_category_subject_to_string()
    {
        if(!empty($this->category_subject_to_string))
        {
            return $this->category_subject_to_string;
        }
    
        $values = Category::where('subject_id', '=', $this->id)->getIndexedArray('subject_id','{subject->description}');
        return implode(', ', $values);
    }

    
}

