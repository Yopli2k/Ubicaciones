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

namespace FacturaScripts\Plugins\Ubicaciones\Model;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Dinamic\Model\Producto;
use FacturaScripts\Dinamic\Model\Variante;
use FacturaScripts\Dinamic\Model\Location;

/**
 * Location of product variants in the warehouse
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
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
     * @var string
     */
    public $reference;

    /**
     * Quantity of the product variant in the location.
     *
     * @var float
     */
    public $quantity;

    /**
     * Minimum stock of the product variant in the location.
     *
     * @var float
     */
    public $stockmax;

    /**
     * Maximum stock of the product variant in the location.
     *
     * @var float
     */
    public $stockmin;

    /**
     * Reset the values of all model properties.
     */
    public function clear()
    {
        parent::clear();
        $this->quantity = 0;
        $this->stockmax = 0;
        $this->stockmin = 0;
    }

    /**
     * Returns the product into the location.
     *
     * @return Producto
     */
    public function getProduct(): Producto
    {
        $product = new Producto();
        $product->loadFromCode($this->idproduct);
        return $product;
    }

    /**
     * Returns the variant product into the location.
     *
     * @return Variante
     */
    public function getVariant(): Variante
    {
        $variant = new Variante();
        $where = [ new DataBaseWhere('referencia', $this->reference) ];
        $variant->loadFromCode('', $where);
        return $variant;
    }

    /**
     * This function is called when creating the model table. Returns the SQL
     * that will be executed after the creation of the table. Useful to insert values
     * default.
     *
     * @return string
     */
    public function install(): string
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
    public static function primaryColumn(): string
    {
        return 'id';
    }

    /**
     * Returns the name of the table that uses this model.
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'variantslocations';
    }

    /**
     * Returns true if there are no errors in the values of the model properties.
     * It runs inside the save method.
     *
     * @return bool
     */
    public function test(): bool
    {
        if ($this->stockmin > $this->stockmax) {
            $this->stockmin = $this->stockmax;
        }
        return parent::test();
    }

    /**
     * Returns the url where to see / modify the data.
     *
     * @param string $type
     * @param string $list
     *
     * @return string
     */
    public function url(string $type = 'auto', string $list = 'List'): string
    {
        $list = 'EditProducto?code=' . $this->idproduct . '&active=List';
        return parent::url($type, $list);
    }
}
