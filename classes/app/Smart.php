<?
namespace app;

use lib\Rest;


class Smart 
{
    public string $entity;

	public function __construct()
    {
        $this->entity = (!empty($_ENV['ENV_ENTITY'])) ? $_ENV['ENV_ENTITY'] : '';
    }

    public function getRestUsers($resultDb)
	{
        return Rest::post('user.get', $resultDb);
	}

    public function getEntity($resultDb)
	{
        
        $data = array('ENTITY' => $this->entity);

        $resulPost = Rest::post('entity.item.get', $resultDb, $data);
        
        $resulEntity = (!empty($resulPost['result'])) ? $resulPost['result'] : [];

        if(!empty($resulEntity)) {

            return  $resulEntity;
        }
        
        return "error";
	}

    public function getSmartInfo($resultDb, $nameSmart)
	{
        
        $data = array('ENTITY' => $this->entity);

        $resulPost = Rest::post('entity.item.get', $resultDb, $data);

        $resulEntity = (!empty($resulPost['result'])) ? $resulPost['result'] : [];

        $result = array();

        if(!empty($resulEntity)) {
            foreach ($resulEntity as $itemEntity) {
                
                if($itemEntity['NAME'] === $nameSmart) {
                    $entityIdNum = $itemEntity['PROPERTY_VALUES']['entityIdSmart'];  
                    $data = array('entityTypeId' => $entityIdNum);
    
                    $resultPost = Rest::post('crm.item.list', $resultDb, $data);
                    
                    $post = (!empty($resultPost['result']['items'])) ? $resultPost['result']['items'] : [];
                    
                    $result = array(
                        'entityIdNumber' => $entityIdNum,
                        'idNumber' => $itemEntity['PROPERTY_VALUES']['idSmart'],
                        'result' => $post
                    );
                }
                
            }

            return  $result;
        }
        
        return ['error -> get smart info'];
	}

    public function getSmartNumber($resultDb, $data, $nameSmart)
	{
        
        $resulPost = Rest::post('entity.item.get', $resultDb, $data);
        $resulEntity = (!empty($resulPost['result'])) ? $resulPost['result'] : [];

        if(!empty($resulEntity)) {
            foreach ($resulEntity as $itemEntity) {
                
                if($itemEntity['NAME'] === $nameSmart) {
                    $resultId = array(
                        $entityIdNumber => $itemEntity['PROPERTY_VALUES']['entityIdSmart'],
                        $idNumber => $itemEntity['PROPERTY_VALUES']['idSmart'],
                    );
                    
                }
            }
            return $resultId;
        }

        return ['error'];
	}

    public function callBatch($resultDb, $batch)
	{
        return Rest::post('batch', $resultDb, $batch);
	}

    public function call($resultDb, $batch)
	{
        return Rest::callBatch($resultDb, $batch);
	}
}


