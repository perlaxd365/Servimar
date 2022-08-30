<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $sedes = Sede::all();
        return view('admin.users.edit', compact('user', 'roles', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->roles != null) {
            //rol
            $user->roles()->sync($request->roles);
        } elseif ($request->sede != null) {
            //sede
            $usuario = User::find($user->id);
            $usuario->id_sede = $request->sede;
            $usuario->save();
            
            //nombre sede
            $sede_nomnbre = '';
            $sedes = Sede::where('id_sede', $request->sede)->get();
            foreach ($sedes as $sede) {
                $sede_nomnbre = $sede->descripcion;
            }

            date_default_timezone_set('America/Lima');
            Jornada::create([
                'entrada_jornada' => now()->format('d/m/Y H:i:s A'),
                'salida_jornada' => now()->format('d/m/Y H:i:s A'),
                'estado_jornada' => true,
                'user_create_jornada' => $user->name,
                'user_sede' => $sede_nomnbre
            ]);
        }

        return redirect()->route('admin.users.edit', $user)->with('info', 'Se actualizó  correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
