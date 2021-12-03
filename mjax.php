<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Mjax extends Module
{
    public function __construct()
    {
        $this->name = 'mjax';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Me';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => '1.7.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Mjax module');
        $this->description = $this->l('Description of my module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('mjax')) {
            $this->warning = $this->l('No name provided');
        }
    }
    public function install()
    {
        return parent::install()&&
        $this->registerHook('displayHeader ');
    }
    public function uninstall()
    {
        return parent::uninstall();
    }
    public function hookDisplayHeader ($params)
    {
        $link = new Link;
        $parameters = array("ajax" => "profile_url");
        $ajax_link = $link->getModuleLink('mjax','ajax', $parameters);
        Media::addJsDef(array(
            'mjax' => array(
                'ajax_link' => $ajax_link
            )
        ));

    }
}
