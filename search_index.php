<?php
 require_once 'app/Mage.php';
umask(0);
Mage::app('default'); 

$qry=$_REQUEST["q"];
$data=array();


$resource = Mage::getSingleton('core/resource');
$readConnection = $resource->getConnection('core_read');
$query = 'SELECT * FROM search_cache where query_text="'.$qry.'"';
$cache_search_result= $readConnection->fetchAll($query);

if(count($cache_search_result)){
	
	$querymodel = Mage::getModel('catalogsearch/query')->getCollection()
			->addFieldToFilter('query_text',$qry);
	$search_result=$querymodel->getData();

	if($search_result[0]["num_results"]==$cache_search_result[0]["num_results"]){
			 $response=$cache_search_result[0]["cache_result_path"];
			include( $response);
	}
	else
	{
		echo $response="fail";
	}
}
else
{
	echo $response="fail";
}

