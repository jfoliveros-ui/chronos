<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dataSave = [
            [
                'parameter' => 'TIPO DOCUMENTO',
                'value' => 'CEDULA DE CIUDADANIA',
                'additional_value' => 'CEDULA DE CIUDADANIA',
            ],
            [
                'parameter' => 'TIPO DOCUMENTO',
                'value' => 'CEDULA DE EXTRANJERIA',
                'additional_value' => 'CEDULA DE EXTRANJERIA',
            ],
            [
                'parameter' => 'TIPO DOCUMENTO',
                'value' => 'PASAPORTE',
                'additional_value' => 'PASAPORTE',
            ],
            [
                'parameter' => 'JORNADA',
                'value' => 'Mañana',
                'additional_value' => 'Jornada Mañana',
            ],
            [
                'parameter' => 'JORNADA',
                'value' => 'Tarde',
                'additional_value' => 'Jornada tarde',
            ],
            [
                'parameter' => 'JORNADA',
                'value' => 'Noche',
                'additional_value' => 'Jornada noche',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '1A',
                'additional_value' => 'Primero A',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '1B',
                'additional_value' => 'Primero B',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '2A',
                'additional_value' => 'Segundo A',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '2B',
                'additional_value' => 'Segundo B',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '3A',
                'additional_value' => 'Tercero A',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '3B',
                'additional_value' => 'Tercero B',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '4A',
                'additional_value' => 'Cuarto A',
            ],
            [
                'parameter' => 'SEMESTRE',
                'value' => '4B',
                'additional_value' => 'Cuarto B',
            ],
            [
                'parameter' => 'ROL',
                'value' => 'Administrador',
                'additional_value' => 'Rol que cumplen dentro del sistema',
            ],
            [
                'parameter' => 'ROL',
                'value' => 'Docente',
                'additional_value' => 'Rol que cumplen dentro del sistema',
            ],
            [
                'parameter' => 'ROL',
                'value' => 'CETAP',
                'additional_value' => 'Rol que cumplen dentro del sistema',
            ],
            [
                'parameter' => 'ROL',
                'value' => 'Consulta',
                'additional_value' => 'Rol que cumplen dentro del sistema',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'ACEVEDO',
                'additional_value' => 'ACEVEDO',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'ALGECIRAS',
                'additional_value' => 'ALGECIRAS',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'BELÉN DE LOS ANDAQUÍES',
                'additional_value' => 'BELÉN DE LOS ANDAQUÍES',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'EL PAUJIL',
                'additional_value' => 'EL PAUJIL',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'FLORENCIA',
                'additional_value' => 'FLORENCIA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'GARZÓN',
                'additional_value' => 'GARZÓN',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'IQUIRA - RESGUARDO INDÍGENA',
                'additional_value' => 'IQUIRA - RESGUARDO INDÍGENA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'VALPARAISO',
                'additional_value' => 'VALPARAISO',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'LA PLATA',
                'additional_value' => 'LA PLATA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'MOCOA',
                'additional_value' => 'MOCOA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'MONTAÑITA',
                'additional_value' => 'MONTAÑITA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'NEIVA',
                'additional_value' => 'NEIVA',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'ORITO',
                'additional_value' => 'ORITO',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'PITALITO',
                'additional_value' => 'PITALITO',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'PUERTO ASÍS',
                'additional_value' => 'PUERTO ASÍS',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'SAN AGUSTÍN',
                'additional_value' => 'SAN AGUSTÍN',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'SAN VICENTE DEL CAGÚAN',
                'additional_value' => 'SAN VICENTE DEL CAGÚAN',
            ],
            [
                'parameter' => 'CETAP',
                'value' => 'ORITO',
                'additional_value' => 'ISNOS',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ESCUELAS FILOSÓFICAS Y CAMBIOS PARADIGMÁTICOS I C-2',
                'additional_value' => 'ESCUELAS FILOSÓFICAS Y CAMBIOS PARADIGMÁTICOS I C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'INTRODUCCIÓN A LA PROBLEMATICA PUBLICA C-2',
                'additional_value' => 'INTRODUCCIÓN A LA PROBLEMATICA PUBLICA C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PENSAMIENTO ADMINISTRATIVO PÚBLICO C-2',
                'additional_value' => 'PENSAMIENTO ADMINISTRATIVO PÚBLICO C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROBLEMÁTICA PÚBLICA COLOMBIANA C-2',
                'additional_value' => 'PROBLEMÁTICA PÚBLICA COLOMBIANA C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'TEORÍA DEL  ESTADO  Y DEL PODER C-3',
                'additional_value' => 'TEORÍA DEL  ESTADO  Y DEL PODER C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'RÉGIMEN Y SISTEMAS POLÍTICOS  LATINOAMERICANOS C-3',
                'additional_value' => 'RÉGIMEN Y SISTEMAS POLÍTICOS  LATINOAMERICANOS C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'RÉGIMEN Y SISTEMA POLÍTICO  COLOMBIANO  I - C3',
                'additional_value' => 'RÉGIMEN Y SISTEMA POLÍTICO  COLOMBIANO  I - C3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'RÉGIMEN Y SISTEMA POLÍTICO COLOMBIANO II C-2',
                'additional_value' => 'RÉGIMEN Y SISTEMA POLÍTICO COLOMBIANO II C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ORGANIZACION DEL ESTADO COLOMBIANO Y FORMAS ORGANIZATIVAS DEL ESTADO A NIVEL TERRITORIAL C-3',
                'additional_value' => 'ORGANIZACION DEL ESTADO COLOMBIANO Y FORMAS ORGANIZATIVAS DEL ESTADO A NIVEL TERRITORIAL C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GOBIERNO Y POLÍTICA PÚBLICA C-3',
                'additional_value' => 'GOBIERNO Y POLÍTICA PÚBLICA C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'POLÍTICA PÚBLICA TERRITORIAL C-2',
                'additional_value' => 'POLÍTICA PÚBLICA TERRITORIAL C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'RÉGIMENES Y SISTEMAS POLÍTICOS C-3',
                'additional_value' => 'RÉGIMENES Y SISTEMAS POLÍTICOS C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'DERECHO CONSTITUCIONAL C-3',
                'additional_value' => 'DERECHO CONSTITUCIONAL C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PENSAMIENTO ADMINISTRATIVO Y ORGANIZACIONES PÚBLICAS I C-2',
                'additional_value' => 'PENSAMIENTO ADMINISTRATIVO Y ORGANIZACIONES PÚBLICAS I C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PENSAMIENTO ADMINISTRATIVO Y ORGANIZACIONES PÚBLICAS II C-2',
                'additional_value' => 'PENSAMIENTO ADMINISTRATIVO Y ORGANIZACIONES PÚBLICAS II C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'DERECHO ADMINISTRATIVO C-3',
                'additional_value' => 'DERECHO ADMINISTRATIVO C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GERENCIA DE LOS RECURSOS FÍSICOS Y FINANCIEROS C-3',
                'additional_value' => 'GERENCIA DE LOS RECURSOS FÍSICOS Y FINANCIEROS C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GERENCIA DEL TALENTO HUMANO C-3',
                'additional_value' => 'GERENCIA DEL TALENTO HUMANO C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GERENCIA PÚBLICA INTEGRAL C-4',
                'additional_value' => 'GERENCIA PÚBLICA INTEGRAL C-4',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GESTIÓN DE LAS ORGANIZACIONES PÚBLICAS C-2',
                'additional_value' => 'GESTIÓN DE LAS ORGANIZACIONES PÚBLICAS C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROYECTO DE FUTURO I C-2',
                'additional_value' => 'PROYECTO DE FUTURO I C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROYECTO DE FUTURO II C-2',
                'additional_value' => 'PROYECTO DE FUTURO II C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROYECTO DE FUTURO III C-2',
                'additional_value' => 'PROYECTO DE FUTURO III C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROYECTO DE FUTURO IV C-2',
                'additional_value' => 'PROYECTO DE FUTURO IV C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GLOBALIZACIÓN GEOESTRATEGIA Y RELACIONES MUNDIALES C-2',
                'additional_value' => 'GLOBALIZACIÓN GEOESTRATEGIA Y RELACIONES MUNDIALES C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'TÉCNICAS DEL PROYECTO GEOPOLÍTICO C-2',
                'additional_value' => 'TÉCNICAS DEL PROYECTO GEOPOLÍTICO C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'TEORÍAS Y ENFOQUES DEL DESARROLLO C-2',
                'additional_value' => 'TEORÍAS Y ENFOQUES DEL DESARROLLO C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'TEORÍAS Y ENFOQUES DEL DESARROLLO TERRITORIAL C-2',
                'additional_value' => 'TEORÍAS Y ENFOQUES DEL DESARROLLO TERRITORIAL C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PLANEACIÓN DEL DESARROLLO C-3',
                'additional_value' => 'PLANEACIÓN DEL DESARROLLO C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROYECTOS DE DESARROLLO C-4',
                'additional_value' => 'PROYECTOS DE DESARROLLO C-4',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'GESTIÓN PARA EL DESARROLLO  C-2',
                'additional_value' => 'GESTIÓN PARA EL DESARROLLO  C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PENSAMIENTO ECONÓMICO C-3',
                'additional_value' => 'PENSAMIENTO ECONÓMICO C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ECONOMÍA DE LO PÚBLICO I C-3',
                'additional_value' => 'ECONOMÍA DE LO PÚBLICO I C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ECONOMÍA DE LO PÚBLICO II C-3',
                'additional_value' => 'ECONOMÍA DE LO PÚBLICO II C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'POLÍTICA ECONÓMICA C-2',
                'additional_value' => 'POLÍTICA ECONÓMICA C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'CONTABILIDAD GUBERNAMENTAL C-3',
                'additional_value' => 'CONTABILIDAD GUBERNAMENTAL C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'FINANZAS PÚBLICAS C-4',
                'additional_value' => 'FINANZAS PÚBLICAS C-4',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PRESUPUESTO PÚBLICO C-3',
                'additional_value' => 'PRESUPUESTO PÚBLICO C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'PROCESOS ECONOMICOS TERRITORIALES C-2',
                'additional_value' => 'PROCESOS ECONOMICOS TERRITORIALES C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'CONSTRUCCIÓN DEL CONOCIMIENTO C-2',
                'additional_value' => 'CONSTRUCCIÓN DEL CONOCIMIENTO C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'FUNDAMENTOS EN CIENCIAS SOCIALES C-2',
                'additional_value' => 'FUNDAMENTOS EN CIENCIAS SOCIALES C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ESTADÍSTICA I C-3',
                'additional_value' => 'ESTADÍSTICA I C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ESTADÍSTICA II C-3',
                'additional_value' => 'ESTADÍSTICA II C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'MATEMÁTICAS FINANCIERAS C-3',
                'additional_value' => 'MATEMÁTICAS FINANCIERAS C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'MATEMÁTICAS I C-3',
                'additional_value' => 'MATEMÁTICAS I C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'MATEMÁTICAS II C-3',
                'additional_value' => 'MATEMÁTICAS II C-3',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ELECTIVA IV C-2',
                'additional_value' => 'ELECTIVA IV C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ELECTIVA V C-1',
                'additional_value' => 'ELECTIVA V C-1',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ELECTIVA I C-2',
                'additional_value' => 'ELECTIVA I C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ELECTIVA II C-2',
                'additional_value' => 'ELECTIVA II C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'ELECTIVA III C-2',
                'additional_value' => 'ELECTIVA III C-2',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'TRABAJO DE GRADO C-13',
                'additional_value' => 'TRABAJO DE GRADO C-13',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'SEMINARIO ELECTIVO I C-4',
                'additional_value' => 'SEMINARIO ELECTIVO I C-4',
            ],
            [
                'parameter' => 'MATERIA',
                'value' => 'SEMINARIO SELECTIVO II C-4',
                'additional_value' => 'SEMINARIO SELECTIVO II C-4',
            ],
            [
                'parameter' => 'CATEGORIA',
                'value' => 'OCASIONAL',
                'additional_value' => '40000',
            ],
            [
                'parameter' => 'CATEGORIA',
                'value' => 'CATEDRÁTICO',
                'additional_value' => '60000',
            ],
            [
                'parameter' => 'TOTAL HORAS',
                'value' => '304',
                'additional_value' => 'Total de horas de un docente',
            ],

        ];

        foreach ($dataSave as $data) {
            $parameter = Parameter::where('parameter', $data['parameter'])
                ->where('value', $data['value'])
                ->where('additional_value', $data['additional_value'])
                ->first();
            if (!$parameter) {
                Parameter::insert($data);
            }
        }
    }
}
