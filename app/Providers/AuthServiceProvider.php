<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
   public const RT = 'У вас нет прав для просмотра этой страницы';
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        /** 
         * ?Commodity expert
         * !Товаровед добавление товаров, категорий, брендов 
         * 
         * ?Operator
         * !Оператор удалять, редактировать: товары,категории, бренды, заказы, одобрение комментариев
         * 
         * ?Driver 
         * Сделать специальную форму для просмотра и изменения статуса заказа
         * !Водитель просмотр заказов
         */
        $this->registerPolicies();

        Gate::define('admin', function(User $user){
            return $user->admin === 1?Response::allow():Response::deny(self::RT);
        });

        Gate::define('commodity-expert', function(User $user){
            return $user->admin === 2?Response::allow():Response::deny(self::RT);
        });
        
        Gate::define('operator', function(User $user){
            return $user->admin === 3?Response::allow():Response::deny(self::RT);
        });
        Gate::define('driver', function(User $user){
            return $user->admin === 4?Response::allow():Response::deny(self::RT);
        });
    }
}
