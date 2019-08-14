<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/******************************************************************************
* $FileName : IndexController.php
* $Date     : Jul 16, 2015
* $Revision : 1.0
* $Author   : REALWAT
* $Archive  : NA
* $Logfile  : zination.log
* $Project  : Zination
******************************************************************************
* Copyright REALWAT INC.
* This document contains CONFIDENTIAL information, which is the property of
* REALWAT INC.. Reproduction of this document,
* utilization of its contents or disclosure to third parties (even in part)
* without the prior written permission of REALWAT INC is prohibited.
******************************************************************************
* MODULE:
* Management
*
* HISTORY:  Date             Author     comment:
* Log:      Jul 16, 2015     REALWAT    Creation
*
*******************************************************************************/

/*******************************************************************************
; Zination_Zinebuilder_IndexController
;------------------------------------------------------------------------------
; DESCRIPTION
;    Handler to route automatic product catalog builder
;
* HISTORY:  Date            Author      Comment:
* Log:      Jul 16, 2015     REALWAT    Creation
*******************************************************************************/
class Zination_Zinebuilder_DashboardController extends Mage_Adminhtml_Controller_Action
{

    const LOG_FILE      = "zinebuilder.log"             ;
    
    /**************************************************************************
    ; addCustomJS
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Add external javascript to the extension
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
    private function addCustomJS(){
        $headBlock = $this -> getLayout() -> getBlock('head') ;
        $headBlock -> addJs('zination/zinebuilder/jquery-1.11.3.min.js');
        $headBlock -> addJs('zination/zinebuilder/jquery-ui.min.js') ;
        $headBlock -> addJs('zination/zinebuilder/zinebuilder.js') ;
        
    }
    
    /**************************************************************************
    ; addCustomCSS
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    Add custom stylesheet to the extension
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
    private function addCustomCSS(){
        $headBlock = $this -> getLayout() -> getBlock('head') ;
        $headBlock -> addCss('zination/zinebuilder/jquery-ui.min.css') ;
        $headBlock -> addCss('zination/zinebuilder/zinebuilder.css') ;
    }
    
    /**************************************************************************
    ; indexAction
    ;--------------------------------------------------------------------------
    ; DESCRIPTION
    ;    index routing in extension
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
    public function indexAction()
    {   
        // Render UI
        Mage::log('render index action', null, self::LOG_FILE) ;
        $this -> loadLayout() ;
        //$this -> addCustomJS() ;
        $this -> addCustomCSS() ;
        $this -> _setActiveMenu('zination');
        $this -> _addContent($this->getLayout()
                                  ->createBlock('adminhtml/template')
                                  ->setTemplate('zination/zinebuilder/index.phtml'));
        $this -> renderLayout() ;
    }
}
