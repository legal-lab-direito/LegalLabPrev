<?php

class CategoryForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'legallab';
    private static $activeRecord = 'Category';
    private static $primaryKey = 'id';
    private static $formName = 'form_CategoryForm';

    use BuilderMasterDetailTrait;
    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Cadastro de categoria");


        $id = new TEntry('id');
        $subject_id = new TDBCombo('subject_id', 'legallab', 'Subject', 'id', '{description}','description asc'  );
        $cod = new TEntry('cod');
        $description = new TEntry('description');
        $file_banner = new TFile('file_banner');
        $presentation_text = new THtmlEditor('presentation_text');
        $files_category_description = new TEntry('files_category_description');
        $files_category_id = new THidden('files_category_id');
        $files_category_file = new TFile('files_category_file');
        $button_adicionar_files_category = new TButton('button_adicionar_files_category');

        $description->addValidation("Descrição", new TRequiredValidator()); 

        $id->setEditable(false);
        $subject_id->enableSearch();
        $button_adicionar_files_category->setAction(new TAction([$this, 'onAddDetailFilesCategory'],['static' => 1]), "Adicionar");
        $button_adicionar_files_category->addStyleClass('btn-default');
        $button_adicionar_files_category->setImage('fas:plus #2ecc71');
        $file_banner->enableFileHandling();
        $files_category_file->enableFileHandling();

        $cod->setMaxLength(10);
        $description->setMaxLength(50);
        $files_category_description->setMaxLength(50);

        $id->setSize(100);
        $cod->setSize('100%');
        $subject_id->setSize('100%');
        $description->setSize('100%');
        $file_banner->setSize('100%');
        $files_category_id->setSize(200);
        $files_category_file->setSize('100%');
        $presentation_text->setSize('100%', 300);
        $files_category_description->setSize('100%');

        $button_adicionar_files_category->id = '6453eb40fc521';

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Assunto:", '#ff0000', '14px', null)],[$subject_id],[new TLabel("Código:", '#000000', '14px', null)],[$cod]);
        $row2->layout = [' col-sm-2 control-label',' col-sm-6',' col-sm-2',' col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Descrição:", '#ff0000', '14px', null)],[$description]);
        $row4 = $this->form->addFields([new TLabel("Arquivo Banner:", null, '14px', null)],[$file_banner]);

        $tab_643d77dd51843 = new BootstrapFormBuilder('tab_643d77dd51843');
        $this->tab_643d77dd51843 = $tab_643d77dd51843;
        $tab_643d77dd51843->setProperty('style', 'border:none; box-shadow:none;');

        $tab_643d77dd51843->appendPage("Texto Principal");

        $tab_643d77dd51843->addFields([new THidden('current_tab_tab_643d77dd51843')]);
        $tab_643d77dd51843->setTabFunction("$('[name=current_tab_tab_643d77dd51843]').val($(this).attr('data-current_page'));");

        $row5 = $tab_643d77dd51843->addFields([$presentation_text]);
        $row5->layout = [' col-sm-12'];

        $tab_643d77dd51843->appendPage("Arquivos");

        $this->detailFormFilesCategory = new BootstrapFormBuilder('detailFormFilesCategory');
        $this->detailFormFilesCategory->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormFilesCategory->setProperty('class', 'form-horizontal builder-detail-form');

        $row6 = $this->detailFormFilesCategory->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$files_category_description,$files_category_id],[new TLabel("Arquivo:", null, '14px', null, '100%'),$files_category_file]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->detailFormFilesCategory->addFields([$button_adicionar_files_category]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->detailFormFilesCategory->addFields([new THidden('files_category__row__id')]);
        $this->files_category_criteria = new TCriteria();

        $this->files_category_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->files_category_list->disableHtmlConversion();;
        $this->files_category_list->generateHiddenFields();
        $this->files_category_list->setId('files_category_list');

        $this->files_category_list->style = 'width:100%';
        $this->files_category_list->class .= ' table-bordered';

        $column_files_category_description = new TDataGridColumn('description', "Descrição:", 'left');
        $column_files_category_file = new TDataGridColumn('file', "Arquivo", 'left');

        $column_files_category__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_files_category__row__data->setVisibility(false);

        $action_onEditDetailFiles = new TDataGridAction(array('CategoryForm', 'onEditDetailFiles'));
        $action_onEditDetailFiles->setUseButton(false);
        $action_onEditDetailFiles->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailFiles->setLabel("Editar");
        $action_onEditDetailFiles->setImage('far:edit #478fca');
        $action_onEditDetailFiles->setFields(['__row__id', '__row__data']);

        $this->files_category_list->addAction($action_onEditDetailFiles);
        $action_onDeleteDetailFiles = new TDataGridAction(array('CategoryForm', 'onDeleteDetailFiles'));
        $action_onDeleteDetailFiles->setUseButton(false);
        $action_onDeleteDetailFiles->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailFiles->setLabel("Excluir");
        $action_onDeleteDetailFiles->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailFiles->setFields(['__row__id', '__row__data']);

        $this->files_category_list->addAction($action_onDeleteDetailFiles);

        $this->files_category_list->addColumn($column_files_category_description);
        $this->files_category_list->addColumn($column_files_category_file);

        $this->files_category_list->addColumn($column_files_category__row__data);

        $this->files_category_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->files_category_list);
        $this->detailFormFilesCategory->addContent([$tableResponsiveDiv]);

        $row9 = $tab_643d77dd51843->addFields([$this->detailFormFilesCategory]);
        $row9->layout = [' col-sm-12'];

        $row10 = $this->form->addFields([$tab_643d77dd51843]);
        $row10->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['CategoryHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Cadastro","Cadastro de categorias"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onAddDetailFilesCategory($param = null) 
    {
        try
        {
            $data = $this->form->getData();

                $__row__id = !empty($data->files_category__row__id) ? $data->files_category__row__id : 'b'.uniqid();

                TTransaction::open(self::$database);

                $grid_data = new Files();
                $grid_data->__row__id = $__row__id;
                $grid_data->description = $data->files_category_description;
                $grid_data->id = $data->files_category_id;
                $grid_data->file = $data->files_category_file;

                $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
                $__row__data['__row__id'] = $__row__id;
                $__row__data['__display__']['description'] =  $param['files_category_description'] ?? null;
                $__row__data['__display__']['id'] =  $param['files_category_id'] ?? null;
                $__row__data['__display__']['file'] =  $param['files_category_file'] ?? null;

                $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
                $row = $this->files_category_list->addItem($grid_data);
                $row->id = $grid_data->__row__id;

                TDataGrid::replaceRowById('files_category_list', $grid_data->__row__id, $row);

                TTransaction::close();

                $data = new stdClass;
                $data->files_category_description = '';
                $data->files_category_id = '';
                $data->files_category_file = '';
                $data->files_category__row__id = '';

                TForm::sendData(self::$formName, $data);
                TScript::create("
                   var element = $('#6453eb40fc521');
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

    public static function onEditDetailFiles($param = null) 
    {
        try
        {

                $__row__data = unserialize(base64_decode($param['__row__data']));
                $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;

                $data = new stdClass;
                $data->files_category_description = $__row__data->__display__->description ?? null;
                $data->files_category_id = $__row__data->__display__->id ?? null;
                $data->files_category_file = $__row__data->__display__->file ?? null;
                $data->files_category__row__id = $__row__data->__row__id;

                TForm::sendData(self::$formName, $data);
                TScript::create("
                   var element = $('#6453eb40fc521');
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

    public static function onDeleteDetailFiles($param = null) 
    {
        try
        {

                $__row__data = unserialize(base64_decode($param['__row__data']));

                $data = new stdClass;
                $data->files_category_description = '';
                $data->files_category_id = '';
                $data->files_category_file = '';
                $data->files_category__row__id = '';

                TForm::sendData(self::$formName, $data);

                TDataGrid::removeRowById('files_category_list', $__row__data->__row__id);

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

            $object = new Category(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $file_banner_dir = 'banner'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'file_banner', $file_banner_dir);
            TForm::sendData(self::$formName, (object)['id' => $object->id]);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $files_category_items = $this->storeMasterDetailItems('Files', 'category_id', 'files_category', $object, $param['files_category_list___row__data'] ?? [], $this->form, $this->files_category_list, function($masterObject, $detailObject){ 

                //code here

                $detailObject->store();
                $dataFile = new stdClass();
                $dataFile->file = $detailObject->file;
                $this->saveFile($detailObject, $dataFile, 'file', 'roteiros');

            }, $this->files_category_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('CategoryHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Category($key); // instantiates the Active Record 

                $files_category_items = $this->loadMasterDetailItems('Files', 'category_id', 'files_category', $object, $this->form, $this->files_category_list, $this->files_category_criteria, function($masterObject, $detailObject, $objectItems){ 

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

