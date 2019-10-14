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

namespace FacturaScripts\Plugins\Ubicaciones\Model;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Dinamic\Model\Variante;
use FacturaScripts\Plugins\Ubicaciones\Model\Location;

/**
 * Location of product variants in the warehouse
 *
 * @author Daniel Fernández <hola@danielfg.es>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class VariantLocation extends ModelClass
{
    use ModelTrait;

    /**
     * Primary key.
     * 
     * @var int
     */
    public $id;
    
    /**
     * Link to the location model.
     * 
     * @var int
     */
    public $idlocation;
    
    /**
     * Link to the product model.
     * 
     * @var int
     */
    public $idproduct;
    
    /**
     * Link to the variant product model.
     * 
     * @var int
     */
    public $idvariant;
        
    /**
     * This function is called when creating the model table. Returns the SQL
     * that will be executed after the creation of the table. Useful to insert values
     * default.
     *
     * @return string
     */
    public function install()
    {
        new Location();
        new Variante();
        parent::install();

        return '';
    }
    
    /**
     * Returns the name of the column that is the model's primary key.
     *
     * @return string
     */
    public static function primaryColumn()
    {
        return 'id';
    }

    /**
     * Returns the name of the table that uses this model.
     *
     * @return string
     */
    public static function tableName()
    {
        return 'variants_locations';
    }    
    
    /**
     * Set a id of variant from product and variant reference
     * 
     * @param string $product
     * @param string $reference
     */
    public function setIdVariantFromReference($product, $reference)
    {
        $where = [ 
            new DataBaseWhere('idproducto', $product),
            new DataBaseWhere('referencia', $reference) 
        ];
        
        $variant = new Variante();
        $variant->loadFromCode('', $where);
        $this->idvariant = $variant->idvariante;        
    }    
    
    /**
     * Returns the url where to see / modify the data.
     *
     * @param string $type
     * @param string $list
     *
     * @return string
     */
    public function url(string $type = 'auto', string $list = 'List')
    {
        $list = 'EditProducto?code=' . $this->idproduct . '&active=List';
        return parent::url($type, $list);
    }    
}
