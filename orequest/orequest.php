<?php
require_once '../classes/order/Order.php';
require_once '../classes/order/OrderHistory.php';

if (!defined('_PS_VERSION_')) {
    exit;
}

class Orequest extends Module
{

    public function __construct()
    {
        $this->name = 'orequest';
        $this->tab = 'checkout';
        $this->version = '1.0.0';
        $this->author = 'test';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Orequest');
        $this->description = $this->l('This module for makes POST request');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('actionOrderStatusPostUpdate') &&
            $this->registerHook('actionNewOrder');
    }


    public function uninstall()
    {
        return parent::uninstall();
    }


    public function hookBackOfficeHeader()
    {
        $params1 = [
            'name' => 'backoffice'
        ];
        $this->doPost('127.0.0.1:8000/api/test', $params1);
    }

    public function hookHeader()
    {
        $params1 = [
            'name' => 'header'
        ];
        $this->doPost('127.0.0.1:8000/api/test', $params1);
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        //var_dump($params);
        $params1 = [
            'name' => $params['id_order']
        ];
        $this->doPost('127.0.0.1:8000/api/test', $params1);

    }
    public function hookActionNewOrder($params)
    {
       // $params['id_order'] $params['newOrderStatus']->name

        $params1 = [
            'name' => $params['id_order']
        ];
        $this->doPost('127.0.0.1:8000/api/test', $params1);

    }
    private static function doPost($postUrl, array $params){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $postUrl,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
        ));

        $response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        switch ($http_status){
            case 200:
                $objOrder = new Order($params['name']); 
                $history = new OrderHistory();
                $history->id_order = (int)$objOrder->id;
                $history->changeIdOrderState(3, (int)($objOrder->id)); 
				return $response;
            case 400:
            default:
                return false;
        }
        
    }

}
