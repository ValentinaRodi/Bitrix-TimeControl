<?
namespace app;

use lib\Database;
use lib\Rest;

class DbConnect
{
    private $databaseConnection;

	public function __construct()
    {
        $this->databaseConnection = Database::getInstance(); 
    }

	public function getQuerySelect()
	{
        return $this->databaseConnection->select(
            "SELECT * FROM `portal`;"
        );
	}

    public function getQuerySelectPortal($domain)
	{
        return $this->databaseConnection->select(
            "SELECT * FROM `portal` WHERE DOMAIN='$domain';"
        );
	}
    
    public function getQueryIsert($data)
	{
        return $this->databaseConnection->insert(
            "INSERT INTO `portal` (`DOMAIN`, `ACCESS_TOKEN`, `REFRESH_TOKEN`, `STATUS`, `GMT`)
             VALUES (:DOMAIN, :ACCESS_TOKEN, :REFRESH_TOKEN , :STATUS, :GMT) ON DUPLICATE KEY UPDATE `DOMAIN`=:DOMAIN;",
            $data
        );
	}

    public function getQueryUpdate($accessToken, $newRefreshToken, $domain)
	{
        echo $domain;
        echo $token;
        return $this->databaseConnection->update(
            "UPDATE `portal` SET ACCESS_TOKEN='$accessToken', REFRESH_TOKEN='$newRefreshToken' WHERE DOMAIN='$domain'"
        );
	}

    public function getQueryUpdatePortal($status, $gmt, $domain)
	{
        return $this->databaseConnection->update(
            "UPDATE `portal` SET STATUS='$status', GMT='$gmt' WHERE DOMAIN='$domain'"
        );
	}

    public function getQueryUpdateStatus($status, $domain)
	{
        return $this->databaseConnection->update(
            "UPDATE `portal` SET STATUS='$status' WHERE DOMAIN='$domain'"
        );
	}

    public function getQueryUpdateGpt($gmt, $domain)
	{
        return $this->databaseConnection->update(
            "UPDATE `portal` SET GMT='$gmt' WHERE DOMAIN='$domain'"
        );
	}

    public function getQueryDelete($domain)
	{
        return $this->databaseConnection->delete(
            "DELETE FROM `portal` WHERE DOMAIN = '$domain'"
        );
	}

    public function getQueryRest()
	{
        return Rest::hook('user.get');
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


