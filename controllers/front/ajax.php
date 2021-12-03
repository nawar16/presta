<?php
require_once(dirname(__FILE__).'/../../../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../../../init.php'); 

class MjaxAjaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        require_once _PS_MODULE_DIR_.'mjax/mjax.php';
        $module = new Mjax;
        if (Tools::isSubmit('ajax')) {
            $context = Context::getContext();
            $cart = $context->cart;
            $cookie = $context->cookie;
            $customer = $context->customer;
            $id_lang = $cookie->id_lang;
            $response = array('status' => false, "message" => $module->l('Nothing here.'));
            switch (Tools::getValue('ajax')) {
                case 'profile_url':
                    $context->cookie->__set('profile_url', Tools::getValue('profile_url'));
                    $profile_url = $context->cookie->__get('profile_url');
                    $response = array('status' => true, "message" => $profile_url);
                    break;
                default:
                    break;
            }
        }
        $json = Tools::jsonEncode($response);
        echo $json;
        die;
    }
}

?>

?>