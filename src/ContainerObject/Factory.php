<?php

namespace srag\Plugins\SrContainerObjectMenu\ContainerObject;

use ilSrContainerObjectMenuPlugin;
use srag\DIC\SrContainerObjectMenu\DICTrait;
use srag\Plugins\SrContainerObjectMenu\ContainerObject\Form\FormBuilder;
use srag\Plugins\SrContainerObjectMenu\ContainerObject\Table\TableBuilder;
use srag\Plugins\SrContainerObjectMenu\Utils\SrContainerObjectMenuTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\SrContainerObjectMenu\ContainerObject
 */
final class Factory
{

    use DICTrait;
    use SrContainerObjectMenuTrait;

    const PLUGIN_CLASS_NAME = ilSrContainerObjectMenuPlugin::class;
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
     * @param ContainerObjectCtrl $parent
     * @param ContainerObject     $container_object
     *
     * @return FormBuilder
     */
    public function newFormBuilderInstance(ContainerObjectCtrl $parent, ContainerObject $container_object) : FormBuilder
    {
        $form = new FormBuilder($parent, $container_object);

        return $form;
    }


    /**
     * @return ContainerObject
     */
    public function newInstance() : ContainerObject
    {
        $container_object = new ContainerObject();

        return $container_object;
    }


    /**
     * @param ContainerObjectsCtrl $parent
     *
     * @return TableBuilder
     */
    public function newTableBuilderInstance(ContainerObjectsCtrl $parent) : TableBuilder
    {
        $table = new TableBuilder($parent);

        return $table;
    }
}
