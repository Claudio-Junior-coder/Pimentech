<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Budgets;
use App\Models\Products;
use App\Models\Companies;
use App\Models\Customers;
use App\Models\ProviderInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //
        Schema::defaultStringLength(191);


        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $isUserAdmin = 0;
            if(Auth::user()) {
                $isUserAdmin = auth()->user()->type;
            }

            $event->menu->add('Menu');
            $event->menu->add([
                'text'        => 'Inicio',
                'url'         => '/',
                'icon'        => 'fa fa-home',
            ]);
            $event->menu->add([
                'text'        => 'Produtos',
                'url'         => 'products',
                'icon'        => 'fa fa-cubes',
                'label'       => Products::where('draft', 0)->count(),
                'label_color' => 'primary',
            ]);
            if(PROVIDERS_MODULE) {
                $event->menu->add([
                    'text'        => 'Fornecedores',
                    'url'         => 'providers-info',
                    'icon'        => 'fa fa-shopping-basket',
                    'label'       => ProviderInfo::where('draft', 0)->count(),
                    'label_color' => 'warning',
                ]);
            }
            $event->menu->add([
                'text'        => 'Clientes',
                'url'         => 'customers',
                'icon'        => 'fa fa-address-card',
                'label'       => Customers::count(),
                'label_color' => 'light',
            ]);
            if($isUserAdmin == 1) {
                $event->menu->add([
                    'text'        => 'Empresas',
                    'url'         => 'companies',
                    'icon'        => 'fa fa-building',
                    'label'       => Companies::count(),
                    'label_color' => 'dark',
                ]);
            }
            $event->menu->add('Orçamento');
            $event->menu->add([
                'text'        => 'Orçamentos',
                'url'         => 'budgets',
                'icon'        => 'fas fa-money-check-alt',
                'label'       => Budgets::count(),
                'label_color' => 'success',
            ]);
            $event->menu->add([
                'text'        => 'Ver orçamento',
                'url'         => '#',
                'classes'     => 'open-cart',
                'icon'        => 'fas fa-cart-plus',
            ]);
            $event->menu->add('Configurações do sistema');
            if($isUserAdmin == 1) {
                $event->menu->add([
                    'text'    => 'Definições',
                    'icon'    => 'fa fa-cog',
                    'submenu' => [
                        [
                            'text' => 'Sistema',
                            'url'  => '/settings',
                            'icon' => 'fa fa-laptop',
                        ],
                        [
                            'text' => 'Usuários',
                            'url'  => '/users',
                            'icon'        => 'fas fa-fw fa-user',
                            'label'       => User::count(),
                            'label_color' => 'danger',
                        ],
                        [
                            'text' => 'change_password',
                            'url'  => '/users/change/password',
                            'icon' => 'fas fa-fw fa-lock',
                        ],
                    ],
                ]);
            } else {
                $event->menu->add([
                    'text'    => 'Definições',
                    'icon'    => 'fa fa-cog',
                    'submenu' => [
                        [
                            'text' => 'change_password',
                            'url'  => '/users/change/password',
                            'icon' => 'fas fa-fw fa-lock',
                        ],
                    ],
                ]);
            }
        });
    }
}
