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
use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Dinamic\Model\Producto;
use FacturaScripts\Dinamic\Model\Variante;
use FacturaScripts\Dinamic\Model\AtributoValor;
use FacturaScripts\Plugins\Ubicaciones\Model\Location;

/**
 * Controller to edit a single item from the Location model
 *
 * @author Daniel Fernández <hola@danielfg.es>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class EditVariantLocation extends EditController
{
    
    /**
     * Returns the model name
     */
    public function getModelClassName()
    {
        return 'VariantLocation';
    }

    /**
     * Returns basic page attributes
     *
     * @return array
     */
    public function getPageData()
    {
        $pagedata = parent::getPageData();
        $pagedata['title'] = 'variant-location';
        $pagedata['menu'] = 'warehouse';
        $pagedata['icon'] = 'fas fa-search-location';
        $pagedata['showonmenu'] = false;

        return $pagedata;
    }
    
    /**
     * Loads the data to display.
     *
     * @param string   $viewName
     * @param BaseView $view
     */
    protected function loadData($viewName, $view)
    {
        parent::loadData($viewName, $view);
        
        $mainViewName = $this->getMainViewName();
        if ($viewName == $mainViewName) {
            $view->disableColumn('code', true);  // Force disable PK column
            
            // Load product and variant data
            $this->loadProductData($viewName);
            $this->loadVariantData($viewName);
        }
    }

    /**
     * Run the autocomplete action.
     * Returns a JSON string for the searched values.
     *
     * @return array
     */
    protected function autocompleteAction(): array
    {
        $source = $this->request->get('source', '');
        switch ($source) {
            case 'locations':
                return $this->autocompleteForLocations();

            default:
                return parent::autocompleteAction();
        }
    }
    
    /**
     * 
     * @return array
     */
    protected function autocompleteForLocations()
    {
        $data = $this->requestGet(['field', 'fieldcode', 'source', 'term', 'codewarehouse']);

        $where = [ new DataBaseWhere('codewarehouse', $data['codewarehouse']) ];
        foreach ($this->getColumnValuesWhere('aisle|rack|shelf|bin', $data['term']) as $condition) {
            $where[] = $condition;
        }
    
        $order = [ 'aisle' => 'ASC', 'rack' => 'ASC', 'shelf' => 'ASC', 'bin' => 'ASC' ];

        $results = [];
        $location = new Location();
        foreach ($location->all($where, $order) as $row) {
            $results[] = ['key' => $row->id, 'value' => $row->descriptionComplete()];
        }
        
        if (empty($results)) {
            $i18n = static::toolBox()->i18n();
            $results[] = ['key' => null, 'value' => $i18n->trans('no-data')];
        }

        return $results;        
    }
    
    /**
     * Create product model and load data
     * 
     * @param string $viewName
     */
    private function loadProductData($viewName)
    {
        $idproduct = $this->getViewModelValue($viewName, 'idproduct');
        if (empty($idproduct)) {
            return;
        }

        $product = new Producto();
        if ($product->loadFromCode($idproduct)) {
            // Inject the product values into the main model. Is necessary for the xml view.
            $mainModel = $this->getModel();
            $mainModel->product_reference = $product->referencia;
            $mainModel->product_description = $product->descripcion;
        }
    }

    /**
     * 
     * @param string $fields
     * @param string $values
     * @return DataBaseWhere[]
     */
    private function getColumnValuesWhere($fields, $values)
    {
        $result = [];
        $column1 = explode('|', $fields);
        $column2 = explode(' ', $values);
        $maxValues = count($column1) - 1;
        
        for ($index = 0; $index < count($column2); $index++) {
            $result[] = new DataBaseWhere($column1[$index], mb_strtolower($column2[$index], 'UTF8'), 'LIKE');
            if ($index == $maxValues) {
                return $result;
            }
        }
        
        return $result;
    }
    
    /**
     * Create variant product model and load data
     * 
     * @param string $viewName
     */
    private function loadVariantData($viewName)
    {
        $idproduct = $this->getViewModelValue($viewName, 'idproduct');
        if (empty($idproduct)) {
            return;
        }

        $idvariant = $this->getViewModelValue($viewName, 'idvariant');
        
        $variant = new Variante();
        $where = [ new DataBaseWhere('idproducto', $idproduct) ];
        $order = [ 'referencia' => 'ASC' ];
        
        $values = [];
        foreach ($variant->all($where, $order, 0, 0) as $row) {
            // Inject the variant product values into the main model. Is necessary for the xml view.
            if ($row->idvariante == $idvariant) {
                $mainModel = $this->getModel();
                $mainModel->variant_reference = $row->referencia;                        
            }

            $title = $row->referencia . $this->getAttributesDescription($row->idatributovalor1, $row->idatributovalor2);
            $values[] = ['value' => $row->referencia, 'title' => $title];
        }

        // Add variant data to widget select array
        $columnReference = $this->views[$viewName]->columnForName('reference');
        if ($columnReference) {
            $columnReference->widget->setValuesFromArray($values, false);
        }
    }
    
    /**
     * 
     * @param int $idAttribute1
     * @param int $idAttribute2
     * @return string
     */
    private function getAttributesDescription($idAttribute1, $idAttribute2)
    {
        $attributeValue = new AtributoValor();
        $result = '';

        if (!empty($idAttribute1) && $attributeValue->loadFromCode($idAttribute1)) {
            $result .= ': ' . $attributeValue->descripcion;
        }

        if (!empty($idAttribute2) && $attributeValue->loadFromCode($idAttribute2)) {
            $result .= empty($result) ? ": " : ', ';
            $result .= $attributeValue->descripcion;
        }

        return $result;
    }
}