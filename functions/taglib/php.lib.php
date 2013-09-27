<?php
if (!defined('XAKINC'))
    exit('Warning...');
/**
 * 
 *
 * @version        $Id: php.lib.php1 9:29 2010年7月6日Z
 */
 
 
function lib_php(&$ctag, &$refObj)
{
    global $dsql;
    global $db;
    $phpcode = trim($ctag->GetInnerText());
    if ($phpcode == '')
        return '';
    ob_start();
    extract($GLOBALS, EXTR_SKIP);
    @eval($phpcode);
    $revalue = ob_get_contents();
    ob_clean();
    return $revalue;
}