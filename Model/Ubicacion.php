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
 * Description of Ubicacion
 *
 * @author Daniel Fernández <hola@danielfg.es>
 */
class Ubicacion extends Base\ModelClass
{
    use Base\ModelTrait;

    public static function primaryColumn()
    {
        return 'codubicacion';
    }
    
    public function primaryDescriptionColumn()
    {
        return 'codubicacion';
    }

    public static function tableName()
    {
        return 'ubicaciones';
    }
    
    public function clear()
    {
        parent::clear();
    }
    
    public function url(string $type = 'auto', string $list = 'List')
    {
        return parent::url($type, 'ListAlmacen?activetab=List');
    }
}
