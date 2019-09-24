<?php
/**
 * This file is part of webportal plugin for FacturaScripts.
 * Copyright (C) 2018 Carlos Garcia Gomez  <carlos@facturascripts.com>
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

use FacturaScripts\Core\Model\Base;

/**
 * Description of ProductoUbicacion
 *
 * @author Daniel Fernández <hola@danielfg.es>
 */
class ProductoUbicacion extends Base\ModelClass
{
    use Base\ModelTrait;

    public static function primaryColumn()
    {
        return 'codubicacion';
    }

    public static function tableName()
    {
        return 'productos_ubicaciones';
    }
    
    public function clear()
    {
        parent::clear();
    }
    
    public function url(string $type = 'auto', string $list = 'List')
    {
        switch ($type) {
            case 'edit':
                return is_null($this->idproducto) ? 'EditProducto' : 'EditProducto?code=' . $this->idproducto;

            case 'list':
                return $list . 'Producto';

            case 'new':
                return 'EditProducto';
        }

        /// default
        return empty($this->idproducto) ? $list . 'Producto' : 'EditProducto?code=' . $this->idproducto;
    }
}
