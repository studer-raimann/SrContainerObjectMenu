<?php

namespace srag\DataTableUI\SrContainerObjectMenu\Implementation\Format\Browser\Filter;

use srag\CustomInputGUIs\SrContainerObjectMenu\FormBuilder\FormBuilder as FormBuilderInterface;
use srag\DataTableUI\SrContainerObjectMenu\Component\Format\Browser\BrowserFormat;
use srag\DataTableUI\SrContainerObjectMenu\Component\Format\Browser\Filter\Factory as FactoryInterface;
use srag\DataTableUI\SrContainerObjectMenu\Component\Settings\Settings;
use srag\DataTableUI\SrContainerObjectMenu\Component\Table;
use srag\DataTableUI\SrContainerObjectMenu\Implementation\Utils\DataTableUITrait;
use srag\DIC\SrContainerObjectMenu\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\SrContainerObjectMenu\Implementation\Format\Browser\Filter
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @inheritDoc
     */
    public function formBuilder(BrowserFormat $parent, Table $component, Settings $settings) : FormBuilderInterface
    {
        return new FormBuilder($parent, $component, $settings);
    }
}
