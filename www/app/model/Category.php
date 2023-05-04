<?php

class Category extends TRecord
{
    const TABLENAME  = 'category';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $subject;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cod');
        parent::addAttribute('description');
        parent::addAttribute('presentation_text');
        parent::addAttribute('subject_id');
        parent::addAttribute('file_banner');
            
    }

    /**
     * Method set_subject
     * Sample of usage: $var->subject = $object;
     * @param $object Instance of Subject
     */
    public function set_subject(Subject $object)
    {
        $this->subject = $object;
        $this->subject_id = $object->id;
    }

    /**
     * Method get_subject
     * Sample of usage: $var->subject->attribute;
     * @returns Subject instance
     */
    public function get_subject()
    {
    
        // loads the associated object
        if (empty($this->subject))
            $this->subject = new Subject($this->subject_id);
    
        // returns the associated object
        return $this->subject;
    }

    /**
     * Method getQuestionss
     */
    public function getQuestionss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('category_id', '=', $this->id));
        return Questions::getObjects( $criteria );
    }
    /**
     * Method getFiless
     */
    public function getFiless()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('category_id', '=', $this->id));
        return Files::getObjects( $criteria );
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
    
        $values = Questions::where('category_id', '=', $this->id)->getIndexedArray('category_id','{category->description}');
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
    
        $values = Questions::where('category_id', '=', $this->id)->getIndexedArray('type_id','{type->description}');
        return implode(', ', $values);
    }

    public function set_files_category_to_string($files_category_to_string)
    {
        if(is_array($files_category_to_string))
        {
            $values = Category::where('id', 'in', $files_category_to_string)->getIndexedArray('description', 'description');
            $this->files_category_to_string = implode(', ', $values);
        }
        else
        {
            $this->files_category_to_string = $files_category_to_string;
        }

        $this->vdata['files_category_to_string'] = $this->files_category_to_string;
    }

    public function get_files_category_to_string()
    {
        if(!empty($this->files_category_to_string))
        {
            return $this->files_category_to_string;
        }
    
        $values = Files::where('category_id', '=', $this->id)->getIndexedArray('category_id','{category->description}');
        return implode(', ', $values);
    }

    
}

