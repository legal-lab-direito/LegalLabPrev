<?php

class PerguntasRestService extends AdiantiRecordService
{
    const DATABASE      = 'legallab';
    const ACTIVE_RECORD = 'Questions';
    const ATTRIBUTES    = ['category_id','description','id','type_id'];
    
    /**
     * load($param)
     *
     * Load an Active Records by its ID
     * 
     * @return The Active Record as associative array
     * @param $param['id'] Object ID
     */
     public static function perguntasCategoria($param) {
        try{
            TTransaction::open('legallab');
            if (isset($param['id'])){
                $objects = Questions::where('category_id','=',$param['id'])->orderBy('id')->load();
                $arrayObj = array();
                

                
                if($objects)
                {
                    foreach($objects as $object) 
                    { 
                        $arrayQuest = array();
                        $arrayQuest = $object->toArray();
                        
                        //Busca Respostas da pergunta
                        $objetsAns = PossibleAnswers::where('questions_id', '=', $arrayQuest['id'])->load();
                        
                        $arrayResp = array();
                        $arrayFResp = array();
                        foreach($objetsAns as $objetAns) 
                        { 
                            $arrayResp = $objetAns->toArray();
                            array_push($arrayFResp, $arrayResp);

                        } 
                        
                        array_push($arrayQuest, $arrayFResp);
                        array_push($arrayObj, $arrayQuest);
                        
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
