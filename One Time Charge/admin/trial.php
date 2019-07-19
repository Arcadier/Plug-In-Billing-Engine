<?php
require 'callAPI.php';
require 'admin_token.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Uncomment if you want to enable Trial
    //don't forget to uncomment in subscribe in subscribe.php as well
    
    $contentBodyJson = file_get_contents('php://input');
    $content = json_decode($contentBodyJson, true);
    $phpExit = '<?php exit(); ?>';
    $adminID = $content['adminID'];
    $baseUrl = $content['baseURL'];
    $packageId = $content['packageID'];
    $GETurl = 'https://'.$baseUrl.'/api/v2/plugins/'.$packageId.'/custom-tables/Tanoo/';
    $table = callAPI("GET",null,$GETurl,false);
    $adminrowID = false;
    $hasUsed = false;
    foreach($table['Records'] as $row){
        if($row['BaseURL']==$baseUrl)
        {
            $adminrowID = $row['Id'];
            $hasUsed = $row['HasUsedTrial'];
        }
    }
    
    if (file_exists('../license/trial-expire.php') == false) {
        if (!$adminrowID)
        {
            $time = time() + 30;
            file_put_contents('../license/trial-expire.php', $time);
            $url = 'https://'.$baseUrl.'/api/v2/plugins/'.$packageId.'/custom-tables/Tanoo/rows';
            $data = [ 
                'BaseURL' => $baseUrl, 
                'HasUsedTrial' => 'No' 
            ];
            
            $createnewrow = callAPI("POST", null, $url, $data);
            echo $time;
        }
        else{
            echo "STOP TRYIN";
        }
    }
    else {
        $time = file_get_contents('../license/trial-expire.php');
        $time = str_replace($phpExit, '', $time);
        if($time > time()){
            echo $time;
        }
        else{
            echo "Time up";
            $url = 'https://'.$baseUrl.'/api/v2/plugins/'.$packageId.'/custom-tables/Tanoo/rows/'.$adminrowID;
            $data = [
               'HasUsedTrial' => 'Yes'
            ];
            $update = callAPI("PUT", null, $url, $data);
            echo 0;
        }
    }
    
}
?>
