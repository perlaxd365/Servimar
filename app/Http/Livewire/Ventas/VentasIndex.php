<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Contometro;
use App\Models\Credito;
use App\Models\Embarcacion;
use App\Models\Jornada;
use App\Models\Kardex;
use App\Models\Product;
use App\Models\Sede;
use App\Models\TipoPago;
use App\Models\Venta;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class VentasIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $show;
    public $paginasVentas;
    //buscar embarcacion
    public $id_emb, $nombre_emb, $matricula_emb, $searchEmbarcacion;
    //tipo de pago
    public $idtipopago;
    //id_producto
    public $id_producto, $abastecimiento;
    //datos de venta
    public $galonaje_venta, $precio_venta, $nombre_ref_venta,
        $dni_ref_venta, $telefono_ref_venta, $moneda_venta, $observacion_venta,
        $id_venta, $precio_galon, $nombre_banco_venta;
    //datos de contómetro
    public $contometro_1, $contometro_a, $contometro_b;
    //datos de contómetro inicio de jornada
    public $contometro_1_inicio, $contometro_a_inicio, $contometro_b_inicio;
    //datos de contómetro fin de jornada
    public $contometro_1_fin, $contometro_a_fin, $contometro_b_fin;
    //mostrar contometro 1 O 2
    public $mostrarContrometro = 1;
    //Producto actual de abastecimiento
    public $precio_general, $stock_actual;
    //dolares
    public $dolares;
    //sede
    public $sede;
    //Mostrar precio comprobante
    public $mostrarPrecio;
    //Mostrar precio front
    public $mostrarPrecioFront;
    //Mostrar bancos cuando es depósito
    public $depositoBanco;
    //buscar Venta
    public $searchVenta;
    //vista
    public $view;
    //jornada 
    public $estado_jornada, $entrada_jornada, $id_jornada;

    public function mount()
    {
        //Sede
        $sedes = Sede::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($sedes as $sede) {
            $this->sede = $sede->descripcion;
        }
        //jornada

        $jornadas = Jornada::select('*')
            ->where('user_create_jornada', '=', auth()->user()->name)
            ->where('user_sede', '=', $this->sede)
            ->orderby('id_jornada', 'desc')
            ->first();

        $this->id_jornada = $jornadas->id_jornada;
        $this->estado_jornada = $jornadas->estado_jornada;
        $this->entrada_jornada = $jornadas->entrada_jornada;


        //producto
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($productos as  $producto) {
            $this->id_producto = $producto->id_producto;
            $this->precio_general = $producto->precio_pro;
            $this->precio_galon = $producto->precio_pro;
            $this->stock_actual = $producto->stock_pro;
            $this->abastecimiento = $producto->nombre_pro;
        }

        $this->show = 5;
        $this->paginasVentas = 10;
        $this->idtipopago = 1;
        $this->moneda_venta = 'Soles';
        $this->mostrarPrecio = true;
        $this->mostrarPrecioFront = true;


        $data = json_decode(file_get_contents('https://api.apis.net.pe/v1/tipo-cambio-sunat'), true);
        $this->dolares = $data['venta'];
        $this->view = 'create';

        //contómetro
        if (auth()->user()->id_sede == 4) {
            $this->mostrarContrometro = 2;
        }
    }
    public function render()
    {
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        $tipoPagos = TipoPago::All();
        //EMBARCACIONES
        $embarcaciones = Embarcacion::select(
            DB::raw('SUM(galones_credito) AS galones_credito'),
            'embarcacions.id',
            'nombre_emb',
            'razon_cli',
            'matricula_emb',
            'duenio_emb',
            'telefono_emb',
        )
            ->join('clientes', 'embarcacions.id_cliente', '=', 'clientes.id_cliente')
            ->leftjoin('creditos', function ($join) {
                $join->on('embarcacions.id', '=', 'creditos.id_embarcacion')
                    ->where('creditos.estado_credito', '=', true);
            })
            ->where(function ($query) {
                return $query
                    ->orwhere('razon_cli', 'LIKE', '%' . $this->searchEmbarcacion . '%')
                    ->orwhere('nombre_emb', 'LIKE', '%' . $this->searchEmbarcacion . '%');
            })
            ->where('estado_cli', '=', true)
            ->where('estado_emb', '=', true)
            ->groupby('embarcacions.id')
            ->paginate($this->show);

        //LISTADO DE VENTAS
        date_default_timezone_set('America/Lima');
        $ventas = Venta::select('*')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->where(function ($query) {
                return $query
                    ->orwhere('nombre_emb', 'LIKE', '%' . $this->searchVenta . '%')
                    ->orwhere('nombre_tipo_pago', 'LIKE', '%' . $this->searchVenta . '%');
            })
            ->where('fecha_venta', '>',  $this->entrada_jornada)
            ->where('ventas.estado_venta', '=', 'Activo')
            ->where('ventas.user_create_venta', '=', auth()->user()->name)
            ->orderby('fecha_venta', 'desc')
            ->paginate($this->paginasVentas);

        foreach ($ventas as $key => $venta) {
            # code...
        }

        //DETALLE DE VENTAS
        $detalleVenta = Venta::select('*')
            ->join('contometros', 'contometros.id_venta', '=', 'ventas.id_venta')
            ->join('embarcacions', 'embarcacions.id', '=', 'ventas.id_embarcacion')
            ->join('tipo_pagos', 'tipo_pagos.id_tipo_pago', '=', 'ventas.id_tipo_pago')
            ->where('ventas.id_venta', '=', $this->id_venta)
            ->where('ventas.estado_venta', '=', 'Activo')
            ->paginate($this->paginasVentas);

        //JORNADA


        return view(
            'livewire.ventas.ventas-index',
            compact(
                'embarcaciones',
                'productos',
                'tipoPagos',
                'ventas',
                'detalleVenta'
            )
        );
    }
    public function seleccionEmbarcacion($id, $nombre, $matricula)
    {
        $this->nombre_emb = $nombre;
        $this->id_emb = $id;
        $this->matricula_emb = $matricula;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetPage();
    }


    public function calcularTotal()
    {
        if ($this->galonaje_venta != null) {
            $this->precio_venta = $this->galonaje_venta * $this->precio_galon;
        }
    }
    public function store()
    {

        $messages = [
            'nombre_emb.required' => 'Por favor selecciona una embarcación.',
            'galonaje_venta.gt' => 'El valor mínimo para agregar es 1.',
            'idtipopago.required' => 'Por favor seleccionar un tipo de pago.',
            'galonaje_venta.lt' => 'La venta no puede exeder los ' . $this->stock_actual . ' Galones.',
            'precio_venta.gt' => 'El valor mínimo para agregar es 1.',
            'nombre_ref_venta.required' => 'El campo Nombres y Apellidos de referencia es obligatorio',
            'moneda_venta.required' => 'Por favor, seleccionar moneda',
        ];

        $rules = [


            'nombre_emb' => 'required',
            'galonaje_venta' => 'gt:0|lt:' . $this->stock_actual + 1,
            'idtipopago' => 'required',
            'precio_venta' => 'gt:0',
            'nombre_ref_venta' => 'required',
            'moneda_venta' => 'required',


        ];
        $this->validate($rules, $messages);

        $producto = Product::find($this->id_producto);
        $producto->update([
            'stock_pro' => $this->stock_actual - $this->galonaje_venta,

        ]);
        date_default_timezone_set('America/Lima');
        $id_venta = Venta::create([
            'id_embarcacion' => $this->id_emb,
            'id_producto' => $this->id_producto,
            'id_tipo_pago' => $this->idtipopago,
            'galonaje_venta' => $this->galonaje_venta,
            'precio_venta' => $this->mostrarPrecioFront == false ? 0 : $this->precio_venta,
            'nombre_producto' => $this->abastecimiento,
            'precio_x_galon_venta' => $this->precio_galon,
            'monto_inicial_venta' => $this->stock_actual,
            'moneda_venta' => $this->moneda_venta,
            'nombre_ref_venta' => $this->nombre_ref_venta,
            'dni_ref_venta' => $this->dni_ref_venta,
            'telefono_ref_venta' => $this->telefono_ref_venta,
            'fecha_venta' => now()->format('d/m/Y H:i:s A'),
            'estado_venta' => 'Activo',
            'mostrar_venta' => $this->mostrarPrecio,
            'nombre_banco_venta' => $this->nombre_banco_venta,
            'observacion_venta' => $this->observacion_venta,
            'user_create_venta' => auth()->user()->name,
            'user_sede' => $this->sede,
        ])->id_venta;

        if ($this->idtipopago == 2) {
            Credito::create([
                'id_embarcacion' => $this->id_emb,
                'id_venta' => $id_venta,
                'precio_galon_credito' => $this->precio_galon,
                'galones_credito' => $this->galonaje_venta,
                'monto_credito' => $this->mostrarPrecioFront == false ? 0 : $this->precio_venta,
                'fecha_credito' => now(),
                'estado_credito' => true,
                'user_create_credito' => auth()->user()->name,
            ]);
        }



        Kardex::create([
            'id_producto' => $this->id_producto,
            'id_tipo_movimiento' => 3,
            'cantidad_inicial_kar' => $this->stock_actual,
            'cantidad_kar' => $this->galonaje_venta,
            'total_kar' => $this->stock_actual - $this->galonaje_venta,
            'user_create_kar' => auth()->user()->name,

        ]);
        $this->stock_actual = $this->stock_actual - $this->galonaje_venta;

        //registro de contometro
        Contometro::create([
            'id_venta' => $id_venta,
            'id_jornada' => $this->id_jornada,
            'id_sede' => auth()->user()->id_sede,
            'contometro_1' => $this->contometro_1,
            'contometro_a' => $this->contometro_a,
            'contometro_b' => $this->contometro_b,
            'estado_contometro' => 'Activo',
            'user_create' => auth()->user()->name,
            'user_sede' => $this->sede,
        ]);

        $this->print();
        $this->default();

        // $this->dispatchBrowserEvent('print', ['id' => $id_venta]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se realizó la venta correctamente.']);
    }

    public function print()
    {


        // $formaPago = TipoPago::where('idtipopago', $this->idtipopago)->get();
        // foreach ($formaPago as  $value) {
        //     $formapago = $value->nombre_tipo_pago;
        // }

        // //FECHA
        // date_default_timezone_set('America/Lima');
        // //FIN FECHA

        // /* Call this file 'hello-world.php' */
        // $connector = new WindowsPrintConnector("XP-58");
        // $printer = new Printer($connector);
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $logo = EscposImage::load("logo.jpg", false);
        // $printer->bitImage($logo);

        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->setTextSize(2, 2);
        // $printer->text("NOTA DE DESPACHO\n");
        // $printer->setTextSize(1, 1);
        // $printer->text("(" . $this->sede . ")\n");
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->feed(1);
        // $printer->text("ATENCION: " . auth()->user()->name . "\n");
        // $printer->text("FECHA: " . now()->format('d/m/Y H:i:s A') . "\n");
        // $printer->text("EMBARCACION: " . $this->nombre_emb . "\n");
        // $printer->text("MATRICULA: " . $this->matricula_emb . "\n");
        // $printer->text("REFERENCIA: " . $this->nombre_ref_venta . "\n");
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->text("--------------------------\n");
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("FORMA DE PAGO: " . $formapago . "\n");
        // $printer->text("MONEDA: " . $this->moneda_venta . "\n");
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->text("--------------------------\n");
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $this->moneda_venta == 'Soles' ? $signoMoneda = 'S/ ' : $signoMoneda = '$ ';

        // if ($this->mostrarPrecio == true) {

        //     $printer->text("CANTIDAD              PRECIO \n");
        //     $printer->text("GALONES: " . $this->galonaje_venta . "           " . $signoMoneda . $this->precio_venta . "\n");
        // } else {

        //     $printer->text("CANTIDAD               \n");
        //     $printer->text("GALONES: " . $this->galonaje_venta . "\n");
        // }


        // $printer->feed(2);
        // $testStr = "Testing 123";
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->qrCode($testStr, Printer::QR_ECLEVEL_L, 7, Printer::QR_MODEL_1);
        // $printer->feed();
        // $printer->text("Visita nuestra pagina web para  ver precios y enviar requerimientos escaneando el codigo QR o   ingresando a:\n");
        // $printer->text("www.servimar.xyz\n");

        // $printer->feed(5);
        // $printer->close();
    }

    public function default()
    {
        $this->mostrarPrecio = true;
        $this->mostrarPrecioFront = true;
        $this->idtipopago = 1;
        $this->galonaje_venta = null;
        $this->precio_venta = null;
        $this->nombre_ref_venta = null;
        $this->dni_ref_venta = null;
        $this->telefono_ref_venta = null;
        $this->moneda_venta = 'Soles';
        $this->id_emb = null;
        $this->nombre_emb = null;
        $this->observacion_venta = null;
        $this->nombre_banco_venta = null;
        $this->contometro_1 = null;
        $this->contometro_a = null;
        $this->contometro_b = null;
    }

    public function updatedidtipopago()
    {
        if ($this->idtipopago == 2) {

            $this->mostrarPrecioFront = false;
            $this->mostrarPrecio = false;
            $this->depositoBanco = false;
        } else if ($this->idtipopago == 3) {

            $this->mostrarPrecioFront = true;
            $this->mostrarPrecio = true;
            $this->depositoBanco = true;
        } else {

            $this->depositoBanco = false;
            $this->mostrarPrecioFront = true;
            $this->mostrarPrecio = true;
        }
    }
    public function modalDetalle($id_venta)
    {
        $this->id_venta = $id_venta;
    }
    public function crearVentaView()
    {
        $this->view = 'create';
    }
    public function listarVentaView()
    {
        $this->view = 'list';
    }

    public function finalizarJornada()
    {

        //resto
        $rules_all = [
            'contometro_1_fin' => 'required',
        ];
        $messages_all = [
            'contometro_1_fin.required' => 'Por favor ingresar Contómetro',
        ];
        //paita
        $rules_paita = [
            'contometro_a_fin' => 'required',
            'contometro_b_fin' => 'required',
        ];
        $messages_paita = [
            'contometro_a_fin.required' => 'Por favor ingresar contómetro A',
            'contometro_b_fin.required' => 'Por favor ingresar contómetro B',
        ];

        if (auth()->user()->id_sede == 4) {

            $this->validate($rules_paita, $messages_paita);
        } else {

            $this->validate($rules_all, $messages_all);
        }
        date_default_timezone_set('America/Lima');
        $jornada = Jornada::create([
            'id_user' => auth()->user()->id,
            'entrada_jornada' => $this->entrada_jornada,
            'salida_jornada' => now()->format('d/m/Y H:i:s A'),
            'estado_jornada' => false,
            'user_create_jornada' => auth()->user()->name,
            'user_sede' => $this->sede
        ])->id_jornada;
        //registro de contometro
        Contometro::create([
            'id_jornada' => $jornada,
            'id_sede' => auth()->user()->id_sede,
            'contometro_1' => $this->contometro_1_fin,
            'contometro_a' => $this->contometro_a_fin,
            'contometro_b' => $this->contometro_b_fin,
            'estado_contometro' => 'Activo',
            'user_create' => auth()->user()->name,
            'user_sede' => $this->sede,
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se finalizo la venta de hoy correctamente.']);
        $this->dispatchBrowserEvent('actualizar-pagina', []);
    }
    public function iniciarJornada()
    {

        //resto
        $rules_all = [
            'contometro_1_inicio' => 'required',
        ];
        $messages_all = [
            'contometro_1_inicio.required' => 'Por favor ingresar Contómetro',
        ];
        //paita
        $rules_paita = [
            'contometro_a_inicio' => 'required',
            'contometro_b_inicio' => 'required',
        ];
        $messages_paita = [
            'contometro_a_inicio.required' => 'Por favor ingresar contómetro A',
            'contometro_b_inicio.required' => 'Por favor ingresar contómetro B',
        ];

        if (auth()->user()->id_sede == 4) {

            $this->validate($rules_paita, $messages_paita);
        } else {

            $this->validate($rules_all, $messages_all);
        }
        date_default_timezone_set('America/Lima');
        $jornada = Jornada::create([
            'id_user' => auth()->user()->id,
            'entrada_jornada' => now()->format('d/m/Y H:i:s A'),
            'estado_jornada' => true,
            'user_create_jornada' => auth()->user()->name,
            'user_sede' => $this->sede
        ])->id_jornada;
        //registro de contometro
        Contometro::create([
            'id_jornada' => $jornada,
            'id_sede' => auth()->user()->id_sede,
            'contometro_1' => $this->contometro_1_inicio,
            'contometro_a' => $this->contometro_a_inicio,
            'contometro_b' => $this->contometro_b_inicio,
            'estado_contometro' => 'Activo',
            'user_create' => auth()->user()->name,
            'user_sede' => $this->sede,
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se inició la venta de hoy correctamente.']);
        $this->dispatchBrowserEvent('actualizar-pagina', []);
    }
}
