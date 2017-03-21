<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 20/03/2017
 * Time: 17:24
 */

function upgrade_module_0_2($module) {
    return true;
    // Exécuter chaque commande SQL d'installation
    $sql_file = dirname(__FILE__) . '/sql/install-0.2.sql';
    if(!$module->loadSQLFile($sql_file)) {
        return false;
    }

    return true;
}