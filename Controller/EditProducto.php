<?php
/**
 * This file is part of FacturaScripts
 * Copyright (C) 2017-2018 Carlos Garcia Gomez <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace FacturaScripts\Plugins\Ubicaciones\Controller;

use FacturaScripts\Plugins\Ubicaciones\Model\UbicacionesAlmacenes;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Controller\EditProducto as ParentController;

/**
 * Controller to edit a single item from the EditProducto model
 *
 * @author Daniel Fernández    <hola@danielfg.es>
 */
class EditProducto extends ParentController
{
    /**
     * Load views
     */
    protected function createViews()
    {
        parent::createViews();
        $this->addEditListView('EditProductoUbicacion', 'ProductoUbicacion', 'ubication', 'fas fa-search-location');
    }
    
    /**
     * Load view data procedure
     *
     * @param string                      $viewName
     * @param ExtendedController\BaseView $view
     */
    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case 'EditProductoUbicacion':
                $idproducto = $this->getViewModelValue('EditProducto', 'idproducto');
                $where = [new DataBaseWhere('idproducto', $idproducto)];
                $view->loadData('', $where, []);
                
                $modelUbicacionesAlmacenes = new UbicacionesAlmacenes();
                $UbicacionesAlmacenes = $modelUbicacionesAlmacenes->all([]);
                $customValues = [];
                
                foreach ($UbicacionesAlmacenes as $ubicacion) {
                    $aux = [
                        'value' => $ubicacion->codubicacion,
                        'title' => 
                            $this->i18n->trans('warehouse').': '.$ubicacion->nombre.' '.
                            $this->i18n->trans('pasillo').': '.$ubicacion->pasillo.' '.
                            $this->i18n->trans('seccion').': '.$ubicacion->seccion.' '.
                            $this->i18n->trans('altura').': '.$ubicacion->altura
                    ];

                    array_push($customValues, $aux);
                }
                
                $columnToModify = $this->views['EditProductoUbicacion']->columnForName('ubication');
                $columnToModify->widget->setValuesFromArray($customValues);
                break;
            default:
                parent::loadData($viewName, $view);
        }
    }
}