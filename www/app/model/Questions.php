<?php

class Questions extends TRecord
{
    const TABLENAME  = 'questions';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    private $type;
    private $category;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('description');
        parent::addAttribute('category_id');
        parent::addAttribute('type_id');
            
    }

    /**
     * Method set_type
     * Sample of usage: $var->type = $object;
     * @param $object Instance of Type
     */
    public function set_type(Type $object)
    {
        $this->type = $object;
        $this->type_id = $object->id;
    }

    /**
     * Method get_type
     * Sample of usage: $var->type->attribute;
     * @returns Type instance
     */
    public function get_type()
    {
    
        // loads the associated object
        if (empty($this->type))
            $this->type = new Type($this->type_id);
    
        // returns the associated object
        return $this->type;
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

    /**
     * Method getPossibleAnswerss
     */
    public function getPossibleAnswerss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('questions_id', '=', $this->id));
        return PossibleAnswers::getObjects( $criteria );
    }

    public function set_possible_answers_questions_to_string($possible_answers_questions_to_string)
    {
        if(is_array($possible_answers_questions_to_string))
        {
            $values = Questions::where('id', 'in', $possible_answers_questions_to_string)->getIndexedArray('description', 'description');
            $this->possible_answers_questions_to_string = implode(', ', $values);
        }
        else
        {
            $this->possible_answers_questions_to_string = $possible_answers_questions_to_string;
        }

        $this->vdata['possible_answers_questions_to_string'] = $this->possible_answers_questions_to_string;
    }

    public function get_possible_answers_questions_to_string()
    {
        if(!empty($this->possible_answers_questions_to_string))
        {
            return $this->possible_answers_questions_to_string;
        }
    
        $values = PossibleAnswers::where('questions_id', '=', $this->id)->getIndexedArray('questions_id','{questions->description}');
        return implode(', ', $values);
    }

    
}

