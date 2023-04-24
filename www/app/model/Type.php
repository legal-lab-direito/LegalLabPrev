<?php

class Type extends TRecord
{
    const TABLENAME  = 'type';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('description');
            
    }

    /**
     * Method getQuestionss
     */
    public function getQuestionss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('type_id', '=', $this->id));
        return Questions::getObjects( $criteria );
    }

    public function set_questions_category_to_string($questions_category_to_string)
    {
        if(is_array($questions_category_to_string))
        {
            $values = Category::where('id', 'in', $questions_category_to_string)->getIndexedArray('description', 'description');
            $this->questions_category_to_string = implode(', ', $values);
        }
        else
        {
            $this->questions_category_to_string = $questions_category_to_string;
        }

        $this->vdata['questions_category_to_string'] = $this->questions_category_to_string;
    }

    public function get_questions_category_to_string()
    {
        if(!empty($this->questions_category_to_string))
        {
            return $this->questions_category_to_string;
        }
    
        $values = Questions::where('type_id', '=', $this->id)->getIndexedArray('category_id','{category->description}');
        return implode(', ', $values);
    }

    public function set_questions_type_to_string($questions_type_to_string)
    {
        if(is_array($questions_type_to_string))
        {
            $values = Type::where('id', 'in', $questions_type_to_string)->getIndexedArray('description', 'description');
            $this->questions_type_to_string = implode(', ', $values);
        }
        else
        {
            $this->questions_type_to_string = $questions_type_to_string;
        }

        $this->vdata['questions_type_to_string'] = $this->questions_type_to_string;
    }

    public function get_questions_type_to_string()
    {
        if(!empty($this->questions_type_to_string))
        {
            return $this->questions_type_to_string;
        }
    
        $values = Questions::where('type_id', '=', $this->id)->getIndexedArray('type_id','{type->description}');
        return implode(', ', $values);
    }

    
}

