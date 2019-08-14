<?php
/******************************************************************************
* $FileName : Zinebuilder.php
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
; Zination_Zinebuilder_Model_Zinebuilder
;------------------------------------------------------------------------------
; DESCRIPTION
;    Model class
;
* HISTORY:  Date            Author      Comment:
* Log:      Jul 16, 2015     REALWAT    Creation
*******************************************************************************/
class Zination_Zinebuilder_Model_Zinebuilder extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this -> _init('zinebuilder/zinebuilder') ;
    }
}
?>
