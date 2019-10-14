<?php
/**
 * This file is part of Ubicaciones plugin for FacturaScripts.
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

namespace FacturaScripts\Plugins\Ubicaciones\Model\ModelView;

use FacturaScripts\Core\Model\Base\ModelView;
use FacturaScripts\Plugins\Ubicaciones\Model\VariantLocation as VariantLocationModel;

/**
 * Location of Variant products. Model View.
 *
 * @author Daniel Fernández <hola@danielfg.es>
 * @author Artex Trading sa <jcuello@artextrading.com>
 */
class VariantLocation extends ModelView
{
        
    /**
     * Constructor and class initializer.
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data);

        $this->setMasterModel(new VariantLocationModel());
    }
    
    protected function getTables(): array
    {
        return [
            'variants_locations',
            'locations',
            'almacenes',
            'variantes'
        ];
    }
    
    protected function getFields(): array
    {
        return [
            'id' => 'variants_locations.id',
            'idlocation' => 'variants_locations.idlocation',
            'idproduct' => 'variants_locations.idproduct',
            'idvariant' => 'variants_locations.idvariant',
            'aisle' => 'locations.aisle',
            'drawer' => 'locations.drawer',
            'codewarehouse' => 'locations.codewarehouse',
            'rack' => 'locations.rack',
            'shelf' => 'locations.shelf',
            'storage_type' => 'locations.storage_type',
            'validation_code' => 'locations.validation_code',            
            'namewarehouse' => 'almacenes.nombre',
            'nameproduct' => 'productos.descripcion',
            'reference' => 'variantes.referencia',
            'barcode' => 'variantes.codbarras',
            'idattribute1' => 'variantes.idatributovalor1',
            'idattribute2' => 'variantes.idatributovalor2',
            'nameattribute1' => 'attribute1.descripcion',
            'nameattribute2' => 'attribute2.descripcion'
        ];
    }
    
    protected function getSQLFrom(): string {
        return 'variants_locations'
            . ' INNER JOIN productos ON productos.idproducto = variants_locations.idproduct'
            . ' INNER JOIN variantes ON variantes.idvariante = variants_locations.idvariant'
            . ' INNER JOIN locations ON locations.id = variants_locations.idlocation'
            . ' INNER JOIN almacenes ON almacenes.codalmacen = locations.codewarehouse'
            . ' LEFT JOIN atributos_valores attribute1 ON attribute1.id = variantes.idatributovalor1'
            . ' LEFT JOIN atributos_valores attribute2 ON attribute2.id = variantes.idatributovalor2';
    }  
}
