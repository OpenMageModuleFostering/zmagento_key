<?php
/*
$uniqAppId = uniqid('z_app_', false);
$currentDate = date("Y-m-d h:i:sa") ;

$zineApp = array(
    'z_app_id' => $uniqAppId,
    'created'  => $currentDate,
    'updated'  => $currentDate
);

Mage::getModel('zinebuilder/zinebuilder')
    -> setData($zineApp)
    -> save() ;

// send data install to zination
$ch = curl_init();
$post_field = array(
        'app_key' => $uniqAppId,
        'app_domain' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)
);
curl_setopt($ch, CURLOPT_URL,"http://192.168.2.45/apps/magento/install/");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_field));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

// further processing ....
//if ($server_output == "OK") { ... } else { ... }
*/
?>
