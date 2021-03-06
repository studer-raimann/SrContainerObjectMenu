<?php

namespace srag\Plugins\SrContainerObjectMenu\Area\Table;

use ilSrContainerObjectMenuPlugin;
use srag\DataTableUI\SrContainerObjectMenu\Component\Column\Column;
use srag\DataTableUI\SrContainerObjectMenu\Component\Data\Row\RowData;
use srag\DataTableUI\SrContainerObjectMenu\Component\Format\Format;
use srag\DataTableUI\SrContainerObjectMenu\Component\Table;
use srag\DataTableUI\SrContainerObjectMenu\Implementation\Column\Formatter\DefaultFormatter;
use srag\DataTableUI\SrContainerObjectMenu\Implementation\Utils\AbstractTableBuilder;
use srag\Plugins\SrContainerObjectMenu\Area\AreaCtrl;
use srag\Plugins\SrContainerObjectMenu\Area\AreasCtrl;
use srag\Plugins\SrContainerObjectMenu\ContainerObject\ContainerObjectsCtrl;
use srag\Plugins\SrContainerObjectMenu\Utils\SrContainerObjectMenuTrait;

/**
 * Class TableBuilder
 *
 * @package srag\Plugins\SrContainerObjectMenu\Area\Table
 */
class TableBuilder extends AbstractTableBuilder
{

    use SrContainerObjectMenuTrait;

    const PLUGIN_CLASS_NAME = ilSrContainerObjectMenuPlugin::class;


    /**
     * @inheritDoc
     *
     * @param AreasCtrl $parent
     */
    public function __construct(AreasCtrl $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    public function render() : string
    {
        self::dic()->toolbar()->addComponent(self::dic()->ui()->factory()->button()->standard(self::plugin()->translate("add_area", AreasCtrl::LANG_MODULE),
            self::dic()->ctrl()->getLinkTargetByClass(AreaCtrl::class, AreaCtrl::CMD_ADD_AREA, "", false, false)));

        return parent::render();
    }


    /**
     * @inheritDoc
     */
    protected function buildTable() : Table
    {
        $table = self::dataTableUI()->table(ilSrContainerObjectMenuPlugin::PLUGIN_ID . "_areas",
            self::dic()->ctrl()->getLinkTarget($this->parent, AreasCtrl::CMD_LIST_AREAS, "", false, false),
            self::plugin()->translate("areas", AreasCtrl::LANG_MODULE), [
                self::dataTableUI()->column()->column("title",
                    self::plugin()->translate("title", AreasCtrl::LANG_MODULE))->withSortable(false),
                self::dataTableUI()->column()->column("menu_title",
                    self::plugin()->translate("menu_title", ContainerObjectsCtrl::LANG_MODULE))->withSortable(false),
                self::dataTableUI()->column()->column("container_objects_title",
                    self::plugin()->translate("container_objects", ContainerObjectsCtrl::LANG_MODULE))->withSortable(false)->withFormatter(new class() extends DefaultFormatter {

                    /**
                     * @inheritDoc
                     */
                    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
                    {
                        return strval($value);
                    }
                }),
                self::dataTableUI()->column()->column("color_hex",
                    self::plugin()->translate("color", AreasCtrl::LANG_MODULE))->withSortable(false)->withFormatter(new class() extends DefaultFormatter {

                    /**
                     * @inheritDoc
                     */
                    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
                    {
                        if (!empty($value)) {
                            return '<div style="background-color:' . strval($value) . ';height:25px;width:25px;"></div>';
                        } else {
                            return "";
                        }
                    }
                }),
                self::dataTableUI()->column()->column("link_container_object_title",
                    self::plugin()->translate("link_container_object", AreasCtrl::LANG_MODULE))->withSortable(false),
                self::dataTableUI()->column()->column("actions",
                    self::plugin()->translate("actions", AreasCtrl::LANG_MODULE))->withFormatter(self::dataTableUI()->column()->formatter()->actions()->actionsDropdown())
            ], new DataFetcher())->withPlugin(self::plugin());

        return $table;
    }
}
