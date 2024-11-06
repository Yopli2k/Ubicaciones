<?php
/**
 * This file is part of Ubicaciones plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Ubicaciones    Copyright (C) 2019-2022 Jose Antonio Cuello Principal <yopli2000@gmail.com>
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
use FacturaScripts\Core\Lib\ExtendedController\BaseView;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

/**
 * Controller to edit a single item from the Location model
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class EditLocation extends EditController
{

    private const VIEW_VARIANT_LOCATION = 'EditVariantLocationQuantity';

    /**
     * Returns the model name
     */
    public function getModelClassName(): string
    {
        return 'Location';
    }

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData(): array
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'location';
        $pagedata['menu'] = 'warehouse';
        $pagedata['icon'] = 'fas fa-map-marker-alt';
        $pagedata['showonmenu'] = false;

        return $pagedata;
    }

    /**
     * Create the view to display.
     */
    protected function createViews()
    {
        parent::createViews();
        $this->createViewsVariantLocations();
        $this->setTabsPosition('bottom');
    }

    /**
     * Loads the data to display.
     *
     * @param string $viewName
     * @param BaseView $view
     */
    protected function loadData($viewName, $view)
    {
        switch ($viewName) {
            case self::VIEW_VARIANT_LOCATION:
                $mvn = $this->getMainViewName();
                $id = $this->getViewModelValue($mvn, 'id');
                $where = [ new DataBaseWhere('idlocation', $id) ];
                $view->loadData('', $where);
                break;
            default:
                parent::loadData($viewName, $view);
                break;
        }
    }

    /**
     * Add list of products in the location.
     *
     * @return void
     */
    private function createViewsVariantLocations(): void
    {
        $view = $this->addEditListView(
            self::VIEW_VARIANT_LOCATION,
            'VariantLocationQuantity',
            'products',
            'fa-solid fa-cube'
        );
        $view->setInLine(true);
    }
}
