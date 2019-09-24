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

use FacturaScripts\Core\Controller\ListAlmacen as ParentController;

/**
 *  Controller to list the items in the Ubicacion model
 *
 * @author Daniel fernández     <hola@danielfg.es>
 */
class ListAlmacen extends ParentController
{
    /**
     * Load views
     */
    protected function createViews()
    {
        parent::createViews();
        $this->createViewUbicaciones();
    }

    /**
     * 
     * @param string $name
     */
    protected function createViewUbicaciones($name = 'ListUbicacion')
    {
        $this->addView($name, 'Ubicacion', 'ubications', 'fas fa-search-location');
    }
}
