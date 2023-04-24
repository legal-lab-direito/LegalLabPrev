<?php

class QuestionsForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'legallab';
    private static $activeRecord = 'Questions';
    private static $primaryKey = 'id';
    private static $formName = 'form_QuestionsForm';

    use BuilderMasterDetailTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de Questões");


        $id = new TEntry('id');
        $category_id = new TDBCombo('category_id', 'legallab', 'Category', 'id', '{description}','description asc'  );
        $type_id = new TDBCombo('type_id', 'legallab', 'Type', 'id', '{description}','description asc'  );
        $description = new TEntry('description');
        $possible_answers_questions_description = new TEntry('possible_answers_questions_description');
        $possible_answers_questions_id = new THidden('possible_answers_questions_id');
        $possible_answers_questions_answer_weight = new TEntry('possible_answers_questions_answer_weight');
        $possible_answers_questions_requires_obs = new TCombo('possible_answers_questions_requires_obs');
        $button_adicionar_possible_answers_questions = new TButton('button_adicionar_possible_answers_questions');

        $type_id->addValidation("Type id", new TRequiredValidator()); 
        $description->addValidation("Descrição", new TRequiredValidator()); 

        $id->setEditable(false);
        $description->setMaxLength(1024);
        $possible_answers_questions_requires_obs->addItems(["1"=>"Sim","0"=>"Não"]);
        $possible_answers_questions_requires_obs->setBooleanMode();
        $button_adicionar_possible_answers_questions->setAction(new TAction([$this, 'onAddDetailPossibleAnswersQuestions'],['static' => 1]), "Adicionar");
        $button_adicionar_possible_answers_questions->addStyleClass('btn-default');
        $button_adicionar_possible_answers_questions->setImage('fas:plus #2ecc71');
        $type_id->enableSearch();
        $category_id->enableSearch();
        $possible_answers_questions_requires_obs->enableSearch();

        $id->setSize(100);
        $type_id->setSize('100%');
        $category_id->setSize('100%');
        $description->setSize('100%');
        $possible_answers_questions_id->setSize(200);
        $possible_answers_questions_requires_obs->setSize(80);
        $possible_answers_questions_description->setSize('100%');
        $possible_answers_questions_answer_weight->setSize('100%');


        $button_adicionar_possible_answers_questions->id = '643d73b97ad99';

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Categoria:", '#ff0000', '14px', null)],[$category_id],[new TLabel("Tipo:", '#ff0000', '14px', null)],[$type_id]);
        $row2->layout = [' col-sm-2 control-label',' col-sm-4',' col-sm-1 control-label',' col-sm-5'];

        $row3 = $this->form->addFields([new TLabel("Descrição:", '#ff0000', '14px', null)],[$description]);

        $this->detailFormPossibleAnswersQuestions = new BootstrapFormBuilder('detailFormPossibleAnswersQuestions');
        $this->detailFormPossibleAnswersQuestions->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormPossibleAnswersQuestions->setProperty('class', 'form-horizontal builder-detail-form');

        $row4 = $this->detailFormPossibleAnswersQuestions->addFields([new TFormSeparator("Possíveis Respostas", '#333', '18', '#eee')]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->detailFormPossibleAnswersQuestions->addFields([new TLabel("Descrição:", '#ff0000', '14px', null, '100%'),$possible_answers_questions_description,$possible_answers_questions_id],[new TLabel("Peso da Resposta:", null, '14px', null, '100%'),$possible_answers_questions_answer_weight],[new TLabel("Requer Observação:", null, '14px', null, '100%'),$possible_answers_questions_requires_obs]);
        $row5->layout = [' col-sm-6',' col-sm-3',' col-sm-3'];

        $row6 = $this->detailFormPossibleAnswersQuestions->addFields([$button_adicionar_possible_answers_questions]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->detailFormPossibleAnswersQuestions->addFields([new THidden('possible_answers_questions__row__id')]);
        $this->possible_answers_questions_criteria = new TCriteria();

        $this->possible_answers_questions_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->possible_answers_questions_list->disableHtmlConversion();;
        $this->possible_answers_questions_list->generateHiddenFields();
        $this->possible_answers_questions_list->setId('possible_answers_questions_list');

        $this->possible_answers_questions_list->style = 'width:100%';
        $this->possible_answers_questions_list->class .= ' table-bordered';

        $column_possible_answers_questions_description = new TDataGridColumn('description', "Descrição", 'left');
        $column_possible_answers_questions_answer_weight = new TDataGridColumn('answer_weight', "Peso da Resposta", 'left');
        $column_possible_answers_questions_requires_obs = new TDataGridColumn('requires_obs', "Requer Observação", 'left');

        $column_possible_answers_questions__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_possible_answers_questions__row__data->setVisibility(false);

        $action_onEditDetailPossibleAnswers = new TDataGridAction(array('QuestionsForm', 'onEditDetailPossibleAnswers'));
        $action_onEditDetailPossibleAnswers->setUseButton(false);
        $action_onEditDetailPossibleAnswers->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailPossibleAnswers->setLabel("Editar");
        $action_onEditDetailPossibleAnswers->setImage('far:edit #478fca');
        $action_onEditDetailPossibleAnswers->setFields(['__row__id', '__row__data']);

        $this->possible_answers_questions_list->addAction($action_onEditDetailPossibleAnswers);
        $action_onDeleteDetailPossibleAnswers = new TDataGridAction(array('QuestionsForm', 'onDeleteDetailPossibleAnswers'));
        $action_onDeleteDetailPossibleAnswers->setUseButton(false);
        $action_onDeleteDetailPossibleAnswers->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailPossibleAnswers->setLabel("Excluir");
        $action_onDeleteDetailPossibleAnswers->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailPossibleAnswers->setFields(['__row__id', '__row__data']);

        $this->possible_answers_questions_list->addAction($action_onDeleteDetailPossibleAnswers);

        $this->possible_answers_questions_list->addColumn($column_possible_answers_questions_description);
        $this->possible_answers_questions_list->addColumn($column_possible_answers_questions_answer_weight);
        $this->possible_answers_questions_list->addColumn($column_possible_answers_questions_requires_obs);

        $this->possible_answers_questions_list->addColumn($column_possible_answers_questions__row__data);

        $this->possible_answers_questions_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->possible_answers_questions_list);
        $this->detailFormPossibleAnswersQuestions->addContent([$tableResponsiveDiv]);

        $row8 = $this->form->addFields([$this->detailFormPossibleAnswersQuestions]);
        $row8->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['QuestionsHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Cadastro","Cadastro de Questões"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onAddDetailPossibleAnswersQuestions($param = null) 
    {
        try
        {
            $data = $this->form->getData();

                $errors = [];
                $requiredFields = [];
                $requiredFields[] = ['label'=>"Descrição", 'name'=>"possible_answers_questions_description", 'class'=>'TRequiredValidator', 'value'=>[]];
                foreach($requiredFields as $requiredField)
                {
                    try
                    {
                        (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                    }
                    catch(Exception $e)
                    {
                        $errors[] = $e->getMessage() . '.';
                    }
                 }
                 if(count($errors) > 0)
                 {
                     throw new Exception(implode('<br>', $errors));
                 }

                $__row__id = !empty($data->possible_answers_questions__row__id) ? $data->possible_answers_questions__row__id : 'b'.uniqid();

                TTransaction::open(self::$database);

                $grid_data = new PossibleAnswers();
                $grid_data->__row__id = $__row__id;
                $grid_data->description = $data->possible_answers_questions_description;
                $grid_data->id = $data->possible_answers_questions_id;
                $grid_data->answer_weight = $data->possible_answers_questions_answer_weight;
                $grid_data->requires_obs = $data->possible_answers_questions_requires_obs;

                $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
                $__row__data['__row__id'] = $__row__id;
                $__row__data['__display__']['description'] =  $param['possible_answers_questions_description'] ?? null;
                $__row__data['__display__']['id'] =  $param['possible_answers_questions_id'] ?? null;
                $__row__data['__display__']['answer_weight'] =  $param['possible_answers_questions_answer_weight'] ?? null;
                $__row__data['__display__']['requires_obs'] =  $param['possible_answers_questions_requires_obs'] ?? null;

                $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
                $row = $this->possible_answers_questions_list->addItem($grid_data);
                $row->id = $grid_data->__row__id;

                TDataGrid::replaceRowById('possible_answers_questions_list', $grid_data->__row__id, $row);

                TTransaction::close();

                $data = new stdClass;
                $data->possible_answers_questions_description = '';
                $data->possible_answers_questions_id = '';
                $data->possible_answers_questions_answer_weight = '';
                $data->possible_answers_questions_requires_obs = '';
                $data->possible_answers_questions__row__id = '';

                TForm::sendData(self::$formName, $data);
                TScript::create("
                   var element = $('#643d73b97ad99');
                   if(typeof element.attr('add') != 'undefined')
                   {
                       element.html(base64_decode(element.attr('add')));
                   }
                ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onEditDetailPossibleAnswers($param = null) 
    {
        try
        {

                $__row__data = unserialize(base64_decode($param['__row__data']));
                $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;

                $data = new stdClass;
                $data->possible_answers_questions_description = $__row__data->__display__->description ?? null;
                $data->possible_answers_questions_id = $__row__data->__display__->id ?? null;
                $data->possible_answers_questions_answer_weight = $__row__data->__display__->answer_weight ?? null;
                $data->possible_answers_questions_requires_obs = $__row__data->__display__->requires_obs ?? null;
                $data->possible_answers_questions__row__id = $__row__data->__row__id;

                TForm::sendData(self::$formName, $data);
                TScript::create("
                   var element = $('#643d73b97ad99');
                   if(!element.attr('add')){
                       element.attr('add', base64_encode(element.html()));
                   }
                   element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editar</span>\");
                   if(!element.attr('edit')){
                       element.attr('edit', base64_encode(element.html()));
                   }
                ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onDeleteDetailPossibleAnswers($param = null) 
    {
        try
        {

                $__row__data = unserialize(base64_decode($param['__row__data']));

                $data = new stdClass;
                $data->possible_answers_questions_description = '';
                $data->possible_answers_questions_id = '';
                $data->possible_answers_questions_answer_weight = '';
                $data->possible_answers_questions_requires_obs = '';
                $data->possible_answers_questions__row__id = '';

                TForm::sendData(self::$formName, $data);

                TDataGrid::removeRowById('possible_answers_questions_list', $__row__data->__row__id);

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Questions(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            TForm::sendData(self::$formName, (object)['id' => $object->id]);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $possible_answers_questions_items = $this->storeMasterDetailItems('PossibleAnswers', 'questions_id', 'possible_answers_questions', $object, $param['possible_answers_questions_list___row__data'] ?? [], $this->form, $this->possible_answers_questions_list, function($masterObject, $detailObject){ 

                //code here

            }, $this->possible_answers_questions_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('QuestionsHeaderList', 'onShow', $loadPageParam); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Questions($key); // instantiates the Active Record 

                $possible_answers_questions_items = $this->loadMasterDetailItems('PossibleAnswers', 'questions_id', 'possible_answers_questions', $object, $this->form, $this->possible_answers_questions_list, $this->possible_answers_questions_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

}

