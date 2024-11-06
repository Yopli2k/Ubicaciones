<?php
/**
 * This file is part of Ubicaciones plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2022 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Ubicaciones    Copyright (C) 2019-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
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

use Exception;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Dinamic\Model\Producto;
use FacturaScripts\Dinamic\Model\Variante;

/**
 * Management the quantities of the product variants in the warehouse
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class VariantLocationQuantity extends VariantLocation
{

    /** @var Producto */
    public $product;

    /** @var Variante */
    public $variant;

    /** @var string */
    public $productname;

    /**
     * Assign the values of the $data array to the model properties.
     *
     * @param array $data
     * @param array $exclude
     */
    public function loadFromData(array $data = [], array $exclude = [])
    {
        parent::loadFromData($data, $exclude);
        $this->product = $this->getProduct();
        $this->variant = $this->getVariant();
        $this->productname = $this->variant->description();
    }
}
