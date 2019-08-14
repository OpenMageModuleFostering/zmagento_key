<?php
class Zination_Zinebuilder_AuthController extends Mage_Adminhtml_Controller_Action
{
    const SERVER        = "https://www.zination.com"    ;
    const LOG_FILE      = "zinebuilder.log"             ;
    
    /**************************************************************************
    ; authAction
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    authenticate mg to zination
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Sep 29, 2015            REALWAT    Creation
    ***************************************************************************/
    public function indexAction()
    {
        $jsonData = array(
                    'status' => '0X000CC',
                    'message' => 'Unexpected Error.'
        ) ;
        $zinebuilder = Mage::getModel('zinebuilder/zinebuilder') ;
        $registered_app = $zinebuilder -> getCollection() -> getFirstItem() ;
        if ( $registered_app -> getId() ){
            $u_id = $registered_app->getData('title') ;
            if ( empty($u_id) ){
                $unique_u_id = hexdec(substr(uniqid(),0,16)) ;
                $zine_data = array(
                        'zinebuilder_id' => $registered_app -> getId(),
                        'title' => $unique_u_id,
                );
                $registered_app->setData($zine_data)->save() ;
            }
            
            if ( true === $registered_app -> getData('verified') ){
                $this->getResponse()->setRedirect($this->getUrl('zinebuilder/dashboard/index/'));
            }else{
                $status = $this -> appregister();
                if ( 201 !== $status['status'] ){
                    Mage::log('Failed to register app '. $status, null, self::LOG_FILE) ;
                    $this -> getResponse() -> clearHeaders()
                          -> setHeader('Content-type','application/json',true) ;
                    $this -> getResponse() -> setBody(json_encode($status))  ;
                }else{
                    $this->getResponse()->setRedirect($this->getUrl('zinebuilder/dashboard/index/'));
                }
            }
        }else{
            $status = $this -> appregister();
            if ( 201 !== $status['status'] ){
                Mage::log('Failed to register app '. $status['status'], null, self::LOG_FILE) ;
                $this -> getResponse() -> clearHeaders()
                      -> setHeader('Content-type','application/json',true) ;
                $this -> getResponse() -> setBody(json_encode($status))  ;
            }else{
                $this->getResponse()->setRedirect($this->getUrl('zinebuilder/dashboard/index/'));
            }
        }
    }
    
    /**************************************************************************
    ; getServer
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get server host
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getServer(){
        return self::SERVER ;
    }
    
    /**************************************************************************
    ; getServerApp
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get server app url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getServerApp(){
        return self::SERVER . "/apps/magento" ;
    }
    
    /**************************************************************************
    ; getServerInstallApp
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get server extension install url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getServerInstallApp(){
        return self::getServerApp() . "/install/" ;
    }
    
    /**************************************************************************
    ; getServerRegisterApp
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get server app register url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getServerRegisterApp(){
        return self::getServerApp() . "/api/register/" ;
    }
    
    /**************************************************************************
    ; getUserRegister
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get user register url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getUserRegister(){
        return self::getServerApp() . "/u/register/" ;
    }
    
    /**************************************************************************
    ; getUserConnect
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get user connect url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getUserConnect(){
        return self::getServerApp() . "/u/connect/" ;
    }
    
    /**************************************************************************
    ; getUserDashboard
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get user dashboard url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getUserDashboard(){
        return self::getServerApp() . "/u/dashboard/" ;
    }
    
    /**************************************************************************
    ; getUserLogin
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Get user login url
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    public static function getUserLogin(){
        return self::getServer() . "/account/login/" ;
    }
    
    /**************************************************************************
    ; registerExtensionApp
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ; register extension app to magento
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    private function registerExtensionApp()
    {
        // generate unique app id
        Mage::log('register app extension', null, self::LOG_FILE);
 
        // register app in magento extension
        $zinebuilder = Mage::getModel('zinebuilder/zinebuilder') ;
        $registered_app = $zinebuilder -> getCollection() -> getFirstItem() ;
        if ( $registered_app -> getId() ){
            return $registered_app -> getData('z_app_id') ;
        }
        
        $hash = hexdec(substr(uniqid(),0,8)) ;
        $uniqAppId = uniqid($hash, false);
        $currentDate = date("Y-m-d h:i:sa") ;
        
        $unique_u_id = hexdec(substr(uniqid(),0,16)) ;
        
        $zineApp = array(
            'z_app_id' => $uniqAppId,
            'created'  => $currentDate,
            'updated'  => $currentDate,
            'title'     => $unique_u_id
        );
        $zinebuilder -> setData($zineApp)
                     -> save() ;
        
        return $zinebuilder -> getData('z_app_id') ;
    }
    
    /**************************************************************************
    ; registerServerApp
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ; register extension app to zination server
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    private function registerServerApp()
    {
        // register app with server
        Mage::log('register app with zination server '.self::getServerInstallApp(), 
                   null, self::LOG_FILE);
        $zinebuilder = Mage::getModel('zinebuilder/zinebuilder')
                       ->getCollection()
                       ->getFirstItem() ;
        if ( empty($zinebuilder) ){
            $zinebuilder = $this -> registerExtensionApp() ;
        }
        
        $post_field = array(
                'app_id' => $zinebuilder->getData('z_app_id'),
                'app_date' => $zinebuilder->getData('created'),
                'app_domain' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB),
                'shop_name' => Mage::getStoreConfig('trans_email/ident_general/name'),
                'shop_email' => Mage::getStoreConfig('trans_email/ident_general/email'),
                'shop_phone' => Mage::getStoreConfig('general/store_information/phone')
        );
        Mage::log($zinebuilder->getData('z_app_id')." ".
                    Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB),
                    null, self::LOG_FILE) ;
                  
        $ch = curl_init(self::getServerInstallApp());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($ch);
        $data = (array) json_decode($result) ;
        
        curl_close ($ch);
        Mage::log('register app on server status: '.$data['status'], 
                   null, self::LOG_FILE);
        
        return $data ;
        
    }

/**************************************************************************
    ; registerApiUser
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ; register extension app user api 
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    private function registerApiUser()
    {
        Mage::log('register api user', null, self::LOG_FILE);
        $api_user = Mage::getModel('api/user');
        $zinebuilder = Mage::getModel('zinebuilder/zinebuilder')
                     -> getCollection() 
                     -> getFirstItem() ;
        $data = array() ;
        
        try
        {
            $apiUser = $api_user->loadByUsername('zinebuilder');
            if($apiUser->getId())
            {   
                Mage::log('API User already registered.', null, self::LOG_FILE); 
            }
            else
            {
                $apiKey = md5(uniqid('z_user_', true));
                
                $apiRole = Mage::getModel('api/roles')
                            ->setName('zinebuilder')
                            ->setPid(false)
                            ->setRoleType('G')
                            ->save() ;
                            
                Mage::getModel('api/rules')
                        ->setRoleId($apiRole->getId())
                        ->setResources(array('zinebuilder'))
                        ->saveRel();
                        
                $api_user->setData(array(
                    'username' => 'zinebuilder',
                    'api_key' => $apiKey,
                    'api_key_confirmation' => $apiKey,
                    'is_active' => 1,
                    'user_roles' => '',
                    'assigned_user_role' => '',
                    'role_name' => '',
                    'roles' => array($apiRole->getId())
                ));
                
                $api_user->save()->load($api_user->getId());
                $api_user->setRoleIds(array($apiRole->getId()))
                        ->setRoleUserId($api_user->getUserId())
                        ->saveRelations();
                $zine_data = array(
                        'zinebuilder_id' => $zinebuilder -> getId(),
                        'z_user_token' => $apiKey,
                );
                
                $zinebuilder->setData($zine_data)->save() ;
            }
                
        }catch(Exception $ex)
        {
            Mage::log($ex, null, self::LOG_FILE);
        }
        
        $data = $this -> registerRemoteUser() ;
        return $data ;
    
    }
    
    
    
    /**************************************************************************
    ; registerRemoteUser
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ; register extension app user api to zination server
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    private function registerRemoteUser(){
        // register api user with server
        Mage::log('register api user with zination server', null, self::LOG_FILE);
        // get app id and installed date to register user
        $zinebuilder = Mage::getModel('zinebuilder/zinebuilder') 
                     -> getCollection()
                     -> getFirstItem() ;
        
        $post_field = array(
                'app_id' => $zinebuilder -> getData('z_app_id'),
                'app_domain' => md5(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)),
                'app_date' => md5($zinebuilder -> getData('created')),
                'app_user' => 'zinebuilder',
                'app_key'  => $zinebuilder -> getData('z_user_token')
                
        );
        $ch = curl_init(self::getServerRegisterApp());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($ch);
        curl_close ($ch);
        $data = (array) json_decode($result) ;
        Mage::log('register api user status: ' . $data['status'], 
                  null, self::LOG_FILE);
        
        if ( 201 == $data['status'] ){
            $zine_data = array(
                'zinebuilder_id' => $zinebuilder -> getId(),
                'verified' => true
            );
            
            $zinebuilder -> setData($zine_data) -> save() ;
        }
        
        return $data ;
    }
    
    /**************************************************************************
    ; appregisterAction
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ; appregister routing in extension
    ;
    ; RETURNS
    ;
    ; INTERFACE NOTES
    ;
    ; IMPLEMENTATION
    ;
    ; HISTORY:  Date           PTS     Author      comment:
    ; Log:      Jul 16, 2015            REALWAT    Creation
    ***************************************************************************/
    private function appregister()
    {   
        // register app extension in magento
        Mage::log("1. Register App Extension with magento", 
                   null, self::LOG_FILE);
        $app_id = $this -> registerExtensionApp() ;
        if ( !empty($app_id) ){
            // register app with zination server
            Mage::log("2. Register App Extension with zination: ".$app_id, 
                      null, self::LOG_FILE) ;
            $result = $this -> registerServerApp() ;
            if ( ( 201 == $result['status'] ) || ( 409 == $result['status'] ) ){
                // register api user with zination server
                Mage::log("3. Register App user api with zination", 
                          null, self::LOG_FILE) ;
                $result = $this -> registerApiUser() ;   
            }
        }
        
        return $result ;
    }    
}
  
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
