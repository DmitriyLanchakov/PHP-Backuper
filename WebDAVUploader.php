<?
include_once __DIR__.'/../Sabre/autoload.php';
class WebDAVUploader implements IUploader{
	public $dir;
	public $webDav;
	//function __construct($server,$login,$pass,$dir='/'){
	function __construct($prefs){
		extract($prefs);
		if(empty($server)||empty($login)||empty($pass)){
			throw new Exception("You had missed arguments about server");
		}
		static::verifyServerAndInitConnection($server,$login,$pass,$dir);
	}
	function verifyServerAndInitConnection($server,$username,$pass,$dir){
		$webdav = new Sabre_DAV_Client(array(
			'baseUri' => $server,
			'userName' => $username,
			'password' => $pass,
			//'proxy' => '127.0.0.1:8888',
			"curl"=>array(
				CURLOPT_SSL_VERIFYHOST =>0,
				CURLOPT_SSL_VERIFYPEER =>0,
			),
		));
		$str=sha1(rand());
		$webdav->put($str,$dir,'test.txt',1);
		$res=$webdav->request('GET', $dir.'test.txt');
		if($str!=$res["body"])throw new Exception("Hosting test was not passed - sent and received strings differ");
		$webdav->request('DELETE', $dir.'test.txt');
		$this->webdav=&$webdav;
		$this->dir=$dir;
	}
	function upload($fileName,$as){
		$this->webdav->put($fileName,$this->dir.'/',$as);
	}
};
?>