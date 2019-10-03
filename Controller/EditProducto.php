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

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Controller\EditProducto as ParentController;

/**
 * Controller to edit a single item from the Producto model
 *
 * @author Daniel Fernández <hola@danielfg.es>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class EditProducto extends ParentController
{
    /**
     * Load views
     */
    protected function createViews()
    {
        parent::createViews();
        $this->addListView('ListVariantLocation', 'ModelView\VariantLocation', 'locations', 'fas fa-search-location');
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
            case 'ListVariantLocation':
                $mainViewName = $this->getMainViewName();
                $idproduct = $this->getViewModelValue($mainViewName, 'idproducto');
                $where = [new DataBaseWhere('idproduct', $idproduct)];
                $order = ['codwarehouse' => 'ASC', 'idvariant' => 'ASC'];
                $view->loadData('', $where, $order);
                break;
                
            default:
                parent::loadData($viewName, $view);
        }
    }
}