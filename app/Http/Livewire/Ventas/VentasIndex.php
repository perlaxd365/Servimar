<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Credito;
use App\Models\Embarcacion;
use App\Models\Kardex;
use App\Models\Product;
use App\Models\Sede;
use App\Models\TipoPago;
use App\Models\Venta;
use DateTime;
use Exception;
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
    //buscar embarcacion
    public $id_emb, $nombre_emb, $matricula_emb, $searchEmbarcacion;
    //tipo de pago
    public $id_tipo_pago;
    //id_producto
    public $id_producto, $abastecimiento;
    //datos de venta
    public $galonaje_venta, $precio_venta, $nombre_ref_venta, $dni_ref_venta, $telefono_ref_venta, $moneda_venta;
    //Producto actual de abastecimiento
    public $precio_general, $stock_actual;
    //dolares
    public $dolares;
    //sede
    public $sede;
    //Mostrar precio
    public $mostrarPrecio;

    public function mount()
    {
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($productos as  $producto) {
            $this->id_producto = $producto->id_producto;
            $this->precio_general = $producto->precio_pro;
            $this->stock_actual = $producto->stock_pro;
            $this->abastecimiento = $producto->nombre_pro;
        }
        $sedes = Sede::where('id_sede', auth()->user()->id_sede)->get();
        foreach ($sedes as $sede) {
            $this->sede = $sede->descripcion;
        }
        $this->show = 5;
        $this->id_tipo_pago = 1;
        $this->moneda_venta = 'Soles';
        $this->mostrarPrecio = true;


        $data = json_decode(file_get_contents('https://api.apis.net.pe/v1/tipo-cambio-sunat'), true);
        $this->dolares = $data['venta'];
    }
    public function render()
    {
        $productos = Product::where('id_sede', auth()->user()->id_sede)->get();
        $tipoPagos = TipoPago::All();
        $embarcaciones = Embarcacion::select('*')
        ->join('clientes', 'embarcacions.id_cliente','=','clientes.id_cliente')
                        ->where(function ($query) {
                            return $query
                                ->orwhere('razon_cli', 'LIKE', '%' . $this->searchEmbarcacion . '%')
                                ->orwhere('nombre_emb', 'LIKE', '%' . $this->searchEmbarcacion . '%');
                        })
                        ->where('estado_cli', '=', true)
                        ->where('estado_emb', '=', true)->paginate($this->show);
        $creditos = Credito::select('monto_credito')
                        ->where('id_embarcacion',)
        return view('livewire.ventas.ventas-index', compact('embarcaciones', 'productos', 'tipoPagos'));
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
            $this->precio_venta = $this->galonaje_venta * $this->precio_general;
        }
    }
    public function store()
    {

        $messages = [
            'nombre_emb.required' => 'Por favor selecciona una embarcación.',
            'galonaje_venta.gt' => 'El valor mínimo para agregar es 1.',
            'id_tipo_pago.required' => 'Por favor seleccionar un tipo de pago.',
            'galonaje_venta.lt' => 'La venta no puede exeder los ' . $this->stock_actual . ' Galones.',
            'precio_venta.gt' => 'El valor mínimo para agregar es 1.',
            'nombre_ref_venta.required' => 'El campo Nombres y Apellidos de referencia es obligatorio',
            'moneda_venta.required' => 'Por favor, seleccionar moneda',
        ];

        $rules = [


            'nombre_emb' => 'required',
            'galonaje_venta' => 'gt:0|lt:' . $this->stock_actual + 1,
            'id_tipo_pago' => 'required',
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
            'id_tipo_pago' => $this->id_tipo_pago,
            'galonaje_venta' => $this->galonaje_venta,
            'precio_venta' => $this->precio_venta,
            'moneda_venta' => $this->moneda_venta,
            'nombre_ref_venta' => $this->nombre_ref_venta,
            'dni_ref_venta' => $this->dni_ref_venta,
            'telefono_ref_venta' => $this->telefono_ref_venta,
            'fecha_venta' => now()->format('d/m/Y H:i:s A'),
            'estado_venta' => 'Activo',
            'user_create_venta' => auth()->user()->name,
        ])->id_venta;
            
        if ($this->id_tipo_pago == 2) {
            Credito::create([
                'id_embarcacion' => $this->id_emb,
                'id_venta' => $id_venta,
                'monto_credito' => $this->precio_venta,
                'fecha_credito' => now(),
                'estado_credito' => true,
                'user_create_credito' => auth()->user()->name,
            ]);
        }



        Kardex::create([
            'id_producto' => $this->id_producto,
            'id_tipo_movimiento' => 3,
            'cantidad_kar' => $this->galonaje_venta,
            'total_kar' => $this->stock_actual - $this->galonaje_venta,
            'user_create_kar' => auth()->user()->name,

        ]);
        //$this->print();
        $this->default();

        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se realizó la venta correctamente.']);
    }

    public function print()
    {

        $formaPago = TipoPago::where('id_tipo_pago', $this->id_tipo_pago)->get();
        foreach ($formaPago as  $value) {
            $formapago = $value->nombre_tipo_pago;
        }

        //FECHA
        date_default_timezone_set('America/Lima');
        //FIN FECHA

        /* Call this file 'hello-world.php' */
        $connector = new WindowsPrintConnector("XP-58");
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load("logo.jpg", false);
        $printer->bitImage($logo);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("NOTA DE DESPACHO\n");
        $printer->setTextSize(1, 1);
        $printer->text("(" . $this->sede . ")\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("ATENCION: " . auth()->user()->name . "\n");
        $printer->text("FECHA: " . now()->format('d/m/Y H:i:s A') . "\n");
        $printer->text("EMBARCACION: " . $this->nombre_emb . "\n");
        $printer->text("MATRICULA: " . $this->matricula_emb . "\n");
        $printer->text("REFERENCIA: " . $this->nombre_ref_venta . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("--------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("FORMA DE PAGO: " . $formapago . "\n");
        $printer->text("MONEDA: " . $this->moneda_venta . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("--------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $this->moneda_venta == 'Soles' ? $signoMoneda = 'S/ ' : $signoMoneda = '$ ';

        if ($this->mostrarPrecio == true) {

            $printer->text("CANTIDAD              PRECIO \n");
            $printer->text("GALONES: " . $this->galonaje_venta . "           " . $signoMoneda . $this->precio_venta . "\n");
        } else {

            $printer->text("CANTIDAD               \n");
            $printer->text("GALONES: " . $this->galonaje_venta . "\n");
        }


        $printer->feed(2);
        $testStr = "Testing 123";
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->qrCode($testStr, Printer::QR_ECLEVEL_L, 7, Printer::QR_MODEL_1);
        $printer->feed();
        $printer->text("Visita nuestra pagina web para  ver precios y enviar requerimientos escaneando el codigo QR o   ingresando a:\n");
        $printer->text("www.servimar.xyz\n");

        $printer->feed(5);
        $printer->close();
    }

    public function default()
    {
        $this->id_tipo_pago = 1;
        $this->galonaje_venta = '';
        $this->precio_venta = '';
        $this->nombre_ref_venta = '';
        $this->dni_ref_venta = '';
        $this->telefono_ref_venta = '';
        $this->moneda_venta = 'Soles';
        $this->id_emb = '';
        $this->nombre_emb = '';
    }
}
