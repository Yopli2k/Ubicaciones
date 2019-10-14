<?php
/**
 * This file is part of Ubicaciones plugin for FacturaScripts.
 * Copyright (C) 2017-2019 Carlos Garcia Gomez <carlos@facturascripts.com>
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

use FacturaScripts\Core\Lib\ExtendedController\EditController;

/**
 * Controller to edit a single item from the Location model
 *
 * @author Daniel Fernández <hola@danielfg.es>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class EditLocation extends EditController
{

    /**
     * Returns the model name
     */
    public function getModelClassName()
    {
        return 'Location';
    }

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData()
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'location';
        $pagedata['menu'] = 'warehouse';
        $pagedata['icon'] = 'fas fa-map-marker-alt';
        $pagedata['showonmenu'] = false;

        return $pagedata;
    }
}