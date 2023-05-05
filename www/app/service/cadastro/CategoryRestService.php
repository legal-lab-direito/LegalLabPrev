<?php

class CategoryRestService extends AdiantiRecordService
{
    const DATABASE      = 'legallab';
    const ACTIVE_RECORD = 'Category';
    const ATTRIBUTES    = ['cod','description','file_banner','id','presentation_text','subject_id'];
    
    /**
     * load($param)
     *
     * Load an Active Records by its ID
     * 
     * @return The Active Record as associative array
     * @param $param['id'] Object ID
     */
     
     public static function categoriasTema($param) {
        try{
            TTransaction::open('legallab');
            if (isset($param['id'])){
                $objects = Category::where('subject_id','=',$param['id'])->orderBy('id')->load();
                $arrayObj = array();
                if($objects)
                {
                    foreach($objects as $object) 
                    { 
                        $arrayCat = array();
                        $arrayCat = $object->toArray();
                        
                        //Busca Respostas da pergunta
                        $objetsFiles = Files::where('category_id', '=', $arrayCat['id'])->load();
                                                
                        $arrayFiles = array();
                        $arrayFFiles = array();
                        foreach($objetsFiles as $objetFile) 
                        { 
                            $arrayFiles = $objetFile->toArray();
                            array_push($arrayFFiles, $arrayFiles);

                        } 

                        array_push($arrayCat, $arrayFFiles);
                        array_push($arrayObj, $arrayCat);
                    }    
                }
        
                TTransaction::close();
    
                return $arrayObj;
            } else {
                return "Nenhum registro encontrado!";
            }
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
     }
    
    
    /**
     * delete($param)
     *
     * Delete an Active Records by its ID
     * 
     * @return The Operation result
     * @param $param['id'] Object ID
     */
    
    
    /**
     * store($param)
     *
     * Save an Active Records
     * 
     * @return The Operation result
     * @param $param['data'] Associative array with object data
     */
    
    
    /**
     * loadAll($param)
     *
     * List the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['offset']    Query offset
     *        $param['limit']     Query limit
     *        $param['order']     Query order by
     *        $param['direction'] Query order direction (asc, desc)
     *        $param['filters']   Query filters (array with field,operator,field)
     */
    
    
    /**
     * deleteAll($param)
     *
     * Delete the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['filters']   Query filters (array with field,operator,field)
     */
}
