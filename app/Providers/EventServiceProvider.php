<?php

namespace App\Providers;

use App\Models\Sede;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $users = User::all()->count();
            $sedes = Sede::where('id_sede', auth()->user()->id_sede)->get();
            foreach ($sedes as $sede) {
                $nombresede = $sede->descripcion;
            }
            $event->menu->add('Bienvenido a la sede ( ' . $nombresede . ' )');
            $event->menu->add([
                'header' => 'GESTION DE SISTEMA',
                'can'    => 'admin.users.index'
            ]);
            $event->menu->add([
                'text'  => 'Usuarios',
                'route' => 'admin.users.index',
                'icon'  => 'fas fa-users fa-fw',
                'label' =>  $users,
                'label_color' => 'info',
                'can'           => 'admin.users.index'
            ]);
            $event->menu->add([
                'header' => 'GESTION DE EMPRESA',
                'can'    => 'admin.clientes.index'
            ]);
            $event->menu->add([
                'text' => 'Clientes',
                'route' => 'admin.clientes.index',
                'icon' => 'far fa-address-card',
                'label' =>  $users,
                'label_color' => 'warning',
                'can'           => 'admin.clientes.index'
            ]);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
