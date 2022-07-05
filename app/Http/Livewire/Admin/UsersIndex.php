<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sede;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{

    public $id_user, $name, $dni, $email, $pass1, $pass2, $id_sede;
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search;
    public $view = "create";
    public $show;


    public function mount()
    {

        $this->show = 8;
    }
    public function render()
    {
        $sedes = Sede::all();
        $users = User::select('*')
            ->join('sedes', 'sedes.id_sede', '=', 'users.id_sede')
            ->where(function ($query) {
                return $query
                ->orwhere('descripcion', 'LIKE', '%' . $this->search . '%')
                ->orwhere('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('dni', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->where('users.estado', '=', true)
            ->orderby('users.id', 'asc')->paginate($this->show);

        return view('livewire.admin.users-index', compact('users', 'sedes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function store()
    {
        $messages = [
            'name.required' => 'Introduce names y apellidos',
            'dni.required' => 'Por favor introducir número de DNI',
            'id_sede.required' => 'Por favor selecciona una sede',
            'email.required' => 'Por favor introdir email, para inicio de sesión',
            'pass1.required' => 'Por favor introdir contraseña , para inicio de sesión',
            'pass2.required' => 'Vuelve a introducir la contraseña',
            'pass2.same' => 'Las contraseñas deben coincidir',
            'dni.min' => 'El dni consta de 8 digitos',
        ];

        $rules = [


            'name' => 'required',
            'dni' => 'required|max:8|min:8|unique:users',
            'id_sede' => 'required',
            'email' => 'required|email|unique:users',
            'pass1' => 'required',
            "pass2" => "required|same:pass1",

        ];
        $this->validate($rules, $messages);

        User::create([
            'id_sede' => $this->id_sede,
            'name' => $this->name,
            'dni'   => $this->dni,
            'email' => $this->email,
            'password' => bcrypt($this->pass1),
            'estado' => true,

        ]);

        $this->dispatchBrowserEvent('respuesta', ['res' => 'Agregó a ' . $this->name . ' con éxito.']);
        $this->default();
    }

    public function editar($id)
    {
        $this->view = "editar";
        $user = User::find($id);
        $this->id_user = $user->id;
        $this->id_sede = $user->id_sede;
        $this->name = $user->name;
        $this->dni = $user->dni;
        $this->email = $user->email;
    }

    public function default()
    {
        $this->view = "create";
        $this->id_sede = "";
        $this->name = "";
        $this->dni = "";
        $this->email = "";
        $this->pass1 = "";
        $this->pass2 = "";
    }
    public function update()
    {
        $usuario = User::find($this->id_user);
        $usuario->update([
            'id_sede' => $this->id_sede,
            'name' => $this->name,
            'dni'   => $this->dni,
            'email' => $this->email
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se actualizó a  ' . $this->name . ' con éxito.']);
        $this->default();
    }
    
    public function delete($id)
    {
        $usuario = User::find($id);
        $usuario->update([
            'estado' => false
        ]);
        $this->dispatchBrowserEvent('respuesta', ['res' => 'Se eliminó a  ' . $usuario->name . ' con éxito.']);
        $this->default();
    }
}
