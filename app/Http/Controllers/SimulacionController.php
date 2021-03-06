<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ConstruirHabitacion;
use App\Demanda;
use App\Simulacion;
use App\TablaSimulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;

class SimulacionController extends Controller{

    public function crearSimulacion(){
        $registros = Simulacion::all()->toArray();
        Simulacion::destroy($registros);
        //$registros1 = TablaSimulacion::all()->toArray();
        //TablaSimulacion::destroy($registros1);
        Simulacion::create();
        return view('simulacion/nuevo');
    }
    public function definirTemporada(Request $request){
        $simulacion = Simulacion::all()->last();
        $demandaEconomica = $this->clientesEconomica($request['temporada']);
        $demandaNegocios = $this->clientesNegocios($request['temporada']);
        $demandaEjecutiva = $this->clientesEjecutiva($request['temporada']);
        $demandaPremium = $this->clientesPremium($request['temporada']);
        $simulacion->update([
            'temporada' => $request['temporada'],
            'clientes_simulados_economica' => $demandaEconomica,
            'clientes_simulados_negocios' => $demandaNegocios,
            'clientes_simulados_ejecutiva' => $demandaEjecutiva,
            'clientes_simulados_premium' => $demandaPremium,
        ]);
        //Cliente::simularClientes($demandaEconomica);
        return redirect()->route('simulacion');
    }
    public function clientesEconomica($temporada){
        $demandaEconomicaPromedio = Demanda::where([
            ['temporada', '=', null],
            ['tipo', '=', 'economica']
        ])->value('cantidad_clientes');
        if ($temporada == 'alta') {
            $demandaEconomicaAlta = Demanda::where([
                ['temporada', '=', 'alta'],
                ['tipo', '=', 'economica']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 100)) / 100;
            $demandaEconomica = $demandaEconomicaPromedio + ($demandaEconomicaAlta - $demandaEconomicaPromedio) * $aleatorio;
        } else {
            $demandaEconomicaBaja = Demanda::where([
                ['temporada', '=', 'baja'],
                ['tipo', '=', 'economica']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaEconomica = $demandaEconomicaBaja + ($demandaEconomicaPromedio - $demandaEconomicaBaja) * $aleatorio;
        }
        $demandaEconomica = (int)round($demandaEconomica, 0, PHP_ROUND_HALF_UP);
        return $demandaEconomica;
    }
    public function clientesNegocios($temporada){
        $demandaNegociosPromedio = Demanda::where([
            ['temporada', '=', null],
            ['tipo', '=', 'negocios']
        ])->value('cantidad_clientes');
        if ($temporada == 'alta') {
            $demandaNegociosAlta = Demanda::where([
                ['temporada', '=', 'alta'],
                ['tipo', '=', 'negocios']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaNegocios = $demandaNegociosPromedio + ($demandaNegociosAlta - $demandaNegociosPromedio) * $aleatorio;
        } else {
            $demandaNegociosBaja = Demanda::where([
                ['temporada', '=', 'baja'],
                ['tipo', '=', 'negocios']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaNegocios = $demandaNegociosBaja + ($demandaNegociosPromedio - $demandaNegociosBaja) * $aleatorio;
        }
        $demandaNegocios = (int)round($demandaNegocios, 0, PHP_ROUND_HALF_UP);
        return $demandaNegocios;
    }

    public function clientesEjecutiva($temporada){
        $demandaEjecutivaPromedio = Demanda::where([
            ['temporada', '=', null],
            ['tipo', '=', 'ejecutiva']
        ])->value('cantidad_clientes');
        if ($temporada == 'alta') {
            $demandaEjecutivaAlta = Demanda::where([
                ['temporada', '=', 'alta'],
                ['tipo', '=', 'ejecutiva']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaEjecutiva = $demandaEjecutivaPromedio + ($demandaEjecutivaAlta - $demandaEjecutivaPromedio) * $aleatorio;
        } else {
            $demandaEjecutivaBaja = Demanda::where([
                ['temporada', '=', 'baja'],
                ['tipo', '=', 'ejecutiva']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaEjecutiva = $demandaEjecutivaBaja + ($demandaEjecutivaPromedio - $demandaEjecutivaBaja) * $aleatorio;
        }
        $demandaEjecutiva = (int)round($demandaEjecutiva, 0, PHP_ROUND_HALF_UP);
        return $demandaEjecutiva;
    }

    public function clientesPremium($temporada){
        $demandaPremiumPromedio = Demanda::where([
            ['temporada', '=', null],
            ['tipo', '=', 'premium']
        ])->value('cantidad_clientes');
        if ($temporada == 'alta') {
            $demandaPremiumAlta = Demanda::where([
                ['temporada', '=', 'alta'],
                ['tipo', '=', 'premium']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaPremium = $demandaPremiumPromedio + ($demandaPremiumAlta - $demandaPremiumPromedio) * $aleatorio;
        } else {
            $demandaPremiumBaja = Demanda::where([
                ['temporada', '=', 'baja'],
                ['tipo', '=', 'premium']
            ])->value('cantidad_clientes');
            $aleatorio = (rand(0, 1000)) / 1000;
            $demandaPremium = $demandaPremiumBaja + ($demandaPremiumPromedio - $demandaPremiumBaja) * $aleatorio;
        }
        $demandaPremium = (int)round($demandaPremium, 0, PHP_ROUND_HALF_UP);
        return $demandaPremium;
    }
    public function simulacion(){
        $simulacion=Simulacion::all()->last();
        $demandaEconomica=$simulacion->clientes_simulados_economica;
        $demandaNegocios=$simulacion->clientes_simulados_negocios;
        $demandaEjecutiva=$simulacion->clientes_simulados_ejecutiva;
        $demandaPremium=$simulacion->clientes_simulados_premium;
        $demandaTotal=$demandaEconomica+$demandaNegocios+$demandaEjecutiva+$demandaPremium;
        for ($i=1;$i<=$demandaTotal;$i++){
            $aleatorio=(rand(0, 1000)) / 1000;
            if($aleatorio<=0.1485){
                Cliente::simularClientesPremium($i);
            }elseif ($aleatorio<=0.3662){
                Cliente::simularClientesEjecutiva($i);
            }elseif ($aleatorio<=0.6635){
                Cliente::simularClientesNegocios($i);
            }else{
                Cliente::simularClientes($i);
            }
        }
        return redirect()->route('tablaSimulacion');
    }
    public function tablaSimulacion(){
        $registros1 = TablaSimulacion::all()->toArray();
        TablaSimulacion::destroy($registros1);
        $simulacion=Simulacion::all()->last();
        $clientes=$simulacion->clientes;
        foreach ($clientes as $cliente){
            $servici=$cliente->servicio->all();
            $servicio=new Collection();
            foreach ($servici as $ser){
                $servicio->push($ser['servicio'].'('.$ser['costo'].'$)');
            }
            $costoT=$cliente->servicio->sum('costo');
            TablaSimulacion::create([
                'id'=>$cliente->id,
                'numero_cliente'=>$cliente->numero_cliente,
                'tipo_cliente'=>$cliente->tipo_cliente,
                'servicios'=>$servicio->implode(' - '),
                'hospedado'=>$cliente->hospedado,
                'pago'=>$cliente->hospedado?$costoT+$cliente->pago:0,
                'total_ganancia'=>$cliente->hospedado?TablaSimulacion::sum('pago')+$costoT+$cliente->pago:TablaSimulacion::sum('pago'),
                'simulacion_id'=>$simulacion->id
            ]);
        }
        //return redirect()->route('datosSimulacion');
        return redirect()->route('construirHabitacion');
    }
    public function datosSimulacion(){
        $datos=TablaSimulacion::all();
        $habitacionConstruidas=ConstruirHabitacion::all()->last();
       return view('simulacion/simulacion',compact('datos','habitacionConstruidas'));
    }
}
