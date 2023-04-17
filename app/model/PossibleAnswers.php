<?php

class PossibleAnswers extends TRecord
{
    const TABLENAME  = 'possible_answers';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    private $questions;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('description');
        parent::addAttribute('questions_id');
        parent::addAttribute('answer_weight');
        parent::addAttribute('requires_obs');
            
    }

    /**
     * Method set_questions
     * Sample of usage: $var->questions = $object;
     * @param $object Instance of Questions
     */
    public function set_questions(Questions $object)
    {
        $this->questions = $object;
        $this->questions_id = $object->id;
    }

    /**
     * Method get_questions
     * Sample of usage: $var->questions->attribute;
     * @returns Questions instance
     */
    public function get_questions()
    {
    
        // loads the associated object
        if (empty($this->questions))
            $this->questions = new Questions($this->questions_id);
    
        // returns the associated object
        return $this->questions;
    }

    
}

