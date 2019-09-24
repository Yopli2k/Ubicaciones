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
 * Description of UbicacionesAlmacenes
 *
 * @author Daniel Fernández <hola@danielfg.es>
 */
class UbicacionesAlmacenes extends Base\ModelView
{
    protected function getTables(): array
    {
        return [
            'almacenes',
            'ubicaciones'
        ];
    }
    
    protected function getFields(): array
    {
        return [
            'codubicacion' => 'ubicaciones.codubicacion',
            'pasillo' => 'ubicaciones.pasillo',
            'seccion' => 'ubicaciones.seccion',
            'altura' => 'ubicaciones.altura',
            'codalmacen' => 'almacenes.codalmacen',
            'nombre' => 'almacenes.nombre'
        ];
    }

    protected function getSQLFrom(): string {
        return 'ubicaciones'
            . ' INNER JOIN almacenes ON almacenes.codalmacen = ubicaciones.codalmacen';
    }  
}
