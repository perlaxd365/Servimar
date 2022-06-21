<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sede;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{

    public $id_user, $nombre, $dni, $email, $pass1, $pass2, $id_sede;
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $search;
    public $view = "create";


    public function render()
    {
        $sedes = Sede::all();
        $users = User::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('dni', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->join('sedes', 'sedes.id_sede', '=', 'users.id_sede')
            ->paginate();
        return view('livewire.admin.users-index', compact('users', 'sedes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function store()
    {

        $this->validate([
            'id_sede' => 'required',
            'nombre' => 'required',
            'dni' => 'required',
            'email' => 'required',
            'pass1' => 'required',
            "pass2" => "required|same:pass1",
        ]);

        User::create([
            'id_sede' => $this->id_sede,
            'nombre' => $this->nombre,
            'dni'   => $this->dni,
            'email' => $this->email,
            'password' => bcrypt($this->pass1)

        ]);
    }

    public function editar($id)
    {
        $this->view = "editar";
        $user = User::find($id);
        $this->id_user=$user->id;
        $this->id_sede = $user->id_sede;
        $this->nombre = $user->nombre;
        $this->dni = $user->dni;
        $this->email = $user->email;
    }

    public function default()
    {
        $this->view = "create";
        $this->id_sede = "";
        $this->nombre = "";
        $this->dni = "";
        $this->email = "";
        $this->pass1 = "";
        $this->pass2 = "";
    }
    public function update(){
        $usuario=User::find($this->id_user);
        $usuario->update([
            'id_sede' => $this->id_sede,
            'nombre' => $this->nombre,
            'dni'   => $this->dni,
            'email' => $this->email
        ]);
        $this->view="create";
    }
}
