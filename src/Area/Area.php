<?php

namespace srag\Plugins\SrContainerObjectMenu\Area;

use ActiveRecord;
use arConnector;
use ILIAS\UI\Component\Component;
use ilSrContainerObjectMenuPlugin;
use srag\DIC\SrContainerObjectMenu\DICTrait;
use srag\Plugins\SrContainerObjectMenu\ContainerObject\ContainerObject;
use srag\Plugins\SrContainerObjectMenu\Utils\SrContainerObjectMenuTrait;

/**
 * Class Area
 *
 * @package srag\Plugins\SrContainerObjectMenu\Area
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Area extends ActiveRecord
{

    use DICTrait;
    use SrContainerObjectMenuTrait;

    const PLUGIN_CLASS_NAME = ilSrContainerObjectMenuPlugin::class;
    const TABLE_NAME = ilSrContainerObjectMenuPlugin::PLUGIN_ID . "_area";
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     * @con_is_primary   true
     * @con_sequence     true
     */
    protected $area_id;
    /**
     * @var string
     *
     * @con_has_field    true
     * @con_fieldtype    text
     * @con_is_notnull   true
     */
    protected $title = "";


    /**
     * Area constructor
     *
     * @param int              $primary_key_value
     * @param arConnector|null $connector
     */
    public function __construct(/*int*/ $primary_key_value = 0, /*?*/ arConnector $connector = null)
    {
        parent::__construct($primary_key_value, $connector);
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    public static function returnDbTableName() : string
    {
        return self::TABLE_NAME;
    }


    /**
     * @return Component[]
     */
    public function getActions() : array
    {
        self::dic()->ctrl()->setParameterByClass(AreaCtrl::class, AreaCtrl::GET_PARAM_AREA_ID, $this->area_id);

        return [
            self::dic()->ui()->factory()->link()->standard(self::plugin()->translate("edit_area", AreasCtrl::LANG_MODULE),
                self::dic()->ctrl()->getLinkTargetByClass(AreaCtrl::class, AreaCtrl::CMD_EDIT_AREA, "", false, false)),
            self::dic()->ui()->factory()->link()->standard(self::plugin()->translate("remove_area", AreasCtrl::LANG_MODULE),
                self::dic()->ctrl()->getLinkTargetByClass(AreaCtrl::class, AreaCtrl::CMD_REMOVE_AREA_CONFIRM, "", false, false))
        ];
    }


    /**
     * @return int
     */
    public function getAreaId() : int
    {
        return $this->area_id;
    }


    /**
     * @param int $area_id
     */
    public function setAreaId(int $area_id)/* : void*/
    {
        $this->area_id = $area_id;
    }


    /**
     * @inheritDoc
     */
    public function getConnectorContainerName() : string
    {
        return self::TABLE_NAME;
    }


    /**
     * @param bool $check_visible
     *
     * @return ContainerObject[]
     */
    public function getContainerObjects(bool $check_visible = false) : array
    {
        return self::srContainerObjectMenu()->containerObjects()->getContainerObjects($this->area_id, $check_visible, false);
    }


    /**
     * @return string
     */
    public function getContainerObjectsTitle() : string
    {
        return nl2br(implode("\n", array_map(function (ContainerObject $container_object) : string {
            return $container_object->getTitle();
        }, $this->getContainerObjects())), false);
    }


    /**
     * @param int|null $position
     *
     * @return string
     */
    public function getMenuIdentifier(/*?*/ int $position = null) : string
    {
        $parts = [
            ilSrContainerObjectMenuPlugin::PLUGIN_ID,
            "areas"
        ];

        if (!empty($this->area_id)) {
            $parts[] = $this->area_id;

            if (!empty($position)) {
                $parts[] = $position;
            }
        }

        return implode("_", $parts);
    }


    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title)/* : void*/
    {
        $this->title = $title;
    }


    /**
     * @return bool
     */
    public function isVisible() : bool
    {
        return (!empty($this->getContainerObjects(true)));
    }
}
