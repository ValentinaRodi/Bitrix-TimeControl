<?
// header('Content-Type: application/json; charset=utf-8');
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
namespace app;

require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\DbConnect;
use app\Smart;
use app\UpdaterBX;
use lib\Rest;

class GetBX 
{
    public $dbConnect;
    public $updaterBX;
    public $smartConnect;
    public array $returnData;
    public array $resultDataDb;
    public array $resultBXPost;
    private $resultPost;

	public function __construct()
    {
        $this->retunData = [];

        $this->dbConnect = new DbConnect();
        $this->resultDataDb = [];
        $this->updaterBX = new UpdaterBX();
        $this->smartConnect = new Smart();
        $this->resultPost = [];
    }

    public function response()
    {
        $this->retunData = $this->getDataDb();
        
        return json_encode($this->retunData);
    }

    public function getDataDb()
	{
        $resultDataDb = $this->dbConnect->getQuerySelect();
        
        $this->resultDataDb = (!empty($resultDataDb)) ? $resultDataDb : [];

        if(count($this->resultDataDb)){

            return $this->getBX();
        }

        return ['error'=> 'dataDb not found'];
	}

    public function getBX()
	{
        $result = [];
        
        foreach($this->resultDataDb as $portal) {

            if($portal['STATUS'] === 'true') {
                
                $this->resultPost = $this->smartConnect->getEntity($portal);

                if($this->resultPost === 'error') {

                    $result[$portal['DOMAIN']] = ['STATUS' => $portal['STATUS']];
                    $result[$portal['DOMAIN']]['resultBXPost'] = 'error -> no access to the portal';
                }  
            
                if(is_array($this->resultPost) ) {
                                
                    $resultBXPost = $this->updaterBX->updaterBX($portal);
                    
                    $result[$portal['DOMAIN']] = ['STATUS' => $portal['STATUS']];
                    $result[$portal['DOMAIN']]['resultBXPost'] = $resultBXPost;
                } 

            } else {

                $result[$portal['DOMAIN']] = ['STATUS' => $portal['STATUS']];
            }
        }

        return $result;
	}
    //server time
}