<?
namespace app;

use lib\Rest;

class SmartBX 
{
    private $entityIdSmart;
    public array $returnData;
    public string $entity;

	public function __construct()
    {
        $this->entityIdSmart = array ( 'entityIdUsersSmart', 'idUsersSmart', 'entityIdMonthSmart', 'idMonthSmart', 'entityIdDaysSmart', 'idDaysSmart');
        $this->entity = (!empty($_ENV['ENV_ENTITY'])) ? $_ENV['ENV_ENTITY'] : '';

        $this->retunData = [];
    }

    public function response(array $data)
    {

        $this->retunData['data'] = $data;
        $this->responseMultiply($data);

        return json_encode($this);
    }

    public function responseMultiply(array $data){
        
        foreach($data as $value){

            $this->retunData['mult'][$value] = (int) $value * 4.59;
        }

    }

}


