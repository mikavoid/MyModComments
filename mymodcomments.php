<?php
/**
 * Created by PhpStorm.
 * User: Adm
 * Date: 10/03/2017
 * Time: 11:59
 */

class MyModComments extends Module
{
    public function __construct() {
        /****************************************************************************
         * L'appel du parent est dû aux initialisations qui y sont faites
         * Seuls les deux premiers attributs sont obligatoires
         ***************************************************************************/
        $this->name = 'mymodcomments';
        $this->tab = 'front_office_features';
        $this->version = '0.2.0';
        $this->author = 'Mickaël BOULAT - Maia Solutions';
        $this->ps_versions_compliancy = array('min' => '1.5.2', 'max' => '1.6.1.11');

        $this->bootstrap = true;

        parent::__construct();
        $this->displayName = $this->l('My product comments module');
        $this->description = $this->l('With this module, your clients will be able to rate and comment your products !');

    }

    /**
     * Création de la page de configuration
     * La valeur de retour sera le contenu affiché à l'écran
     * Affiche un lien de configuration au module
     */
    public function getContent() {
        $this->processConfiguration();
        $this->assignConfiguration();
        return $this->display(__FILE__, 'getContent.tpl');
    }

    /**
     * Permet de récupérer la soumission du formulaire de configuration
     * Appelé dans getContent
     */
    public function  processConfiguration() {

        // Checker si le formulaire à été envoyé
        if (Tools::isSubmit('submit_mymodcomments_form')) {
            $enable_grades = !!Tools::getValue('enable_grades');
            $enable_comments = !!Tools::getValue('enable_comments');
            Configuration::updateValue('MYMOD_GRADES', $enable_grades);
            Configuration::updateValue('MYMOD_COMMENTS', $enable_comments);

            // Confirmation message
            $this->context->smarty->assign('confirmation', 'OK !');
        }
    }

    /**
     * Envoie les variables de configuration à Smarty
     */
    public function assignConfiguration() {
        $enable_grades = Configuration::get('MYMOD_GRADES');
        $enable_comments = Configuration::get('MYMOD_COMMENTS');

        $this->context->smarty->assign('enable_grades', $enable_grades);
        $this->context->smarty->assign('enable_comments', $enable_comments);
    }

    /****************************************************************************
     * Gestion des hooks
     ***************************************************************************/

    public function install() {
        // Appeler la méthode d'installation parente
        if (!parent::install()) {
            return false;
        }

        // Exécuter chaque commande SQL d'installation
        $sql_file = dirname(__FILE__) . '/install/install.sql';
        if(!$this->loadSQLFile($sql_file)) {
            return false;
        }

        // Enregistrement sur les hooks
        if (!$this->registerHook('displayProductTabContent')) {
            return false;
        }

        Configuration::updateValue('MYMOD_GRADES', 1);
        Configuration::updateValue('MYMOD_COMMENTS', 1);

        return true;
    }

    public function uninstall() {
        // Appeler la méthode d'installation parente
        if (!parent::uninstall()) {
            return false;
        }

        // Exécuter chaque commande SQL d'installation
        $sql_file = dirname(__FILE__) . '/install/uninstall.sql';
        if(!$this->loadSQLFile($sql_file)) {
            return false;
        }

        Configuration::deleteByName('MYMOD_GRADES');
        Configuration::deleteByName('MYMOD_COMMENTS');


        return true;
    }

    public function hookDisplayProductTabContent($params) {
        $this->processProductTabContent();
        $this->assignProductTabContent();
        return $this->display(__FILE__, 'displayProductTabContent.tpl');
    }
    public function processProductTabContent() {
        if (Tools::isSubmit('mymod_pc_submit_comment')) {
            $id_product = Tools::getValue('id_product');
            $firstname = Tools::getValue('firstname');
            $lastname = Tools::getValue('lastname');
            $email = Tools::getValue('email');
            $grade = Tools::getValue('grade');
            $comment = Tools::getValue('comment');
            $insert = array(
                'id_product' => (int) $id_product,
                'grade' => (int) $grade,
                'firstname' => pSQL($firstname),
                'lastname' => pSQL($lastname),
                'email' => pSQL($email),
                'comment' => pSQL($comment),
                'date_add' => date('Y-m-d H:i:s'),
            );
            Db::getInstance()->insert('mymod_comment', $insert);
            $this->context->smarty->assign('new_comment_posted', 'true');
        }
    }

    public function assignProductTabContent() {

        $this->context->controller->addCSS($this->_path . 'views/css/mymodcomments.css', 'all');
        $this->context->controller->addJS($this->_path . 'views/js/mymodcomments.js');

        $enable_comments = Configuration::get('MYMOD_COMMENTS');
        $enable_grades = Configuration::get('MYMOD_GRADES');
        $id_product = Tools::getValue('id_product');
        $comments = Db::getInstance()->executeS('
            SELECT * FROM `' . _DB_PREFIX_ . 'mymod_comment` 
            WHERE `id_product` = ' . (int) $id_product
        );

        $this->context->smarty->assign('enable_grades', $enable_grades);
        $this->context->smarty->assign('enable_comments', $enable_comments);
        $this->context->smarty->assign('comments', $comments);
    }

    public function loadSQLFile($filePath) {
        // Récupération du contenu du fichier SQL
        $sql_content = file_get_contents($filePath);
        if (!$sql_content) {
            return false;
        }

        //Remplace le préfixe dans le fichier et récupère les commandes SQL dans un tableau
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

        // Exécuter chaque commande SQL
        $result = true;
        foreach($sql_requests as $request) {
            if(!empty($request)) {
                $result &= Db::getInstance()->execute(trim($request));
            }
        }

        // retrouner le résultat
        return $result;
    }

}
