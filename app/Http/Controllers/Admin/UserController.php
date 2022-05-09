<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Help\Validator as V;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller {


    /**
     * Показывает список всех пользователей
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Gate::authorize('admin');
        $users = User::paginate(5);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Показывает форму для редактирования пользователя
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        Gate::authorize('admin');
        $role = [
            'Пользователь' => 0,
            'Администратор' => 1,
            'Товаровед' => 2,
            'Оператор' => 3,
            'Водитель'   => 4
        ];
        return view('admin.user.edit', compact('user','role'));
    }

    /**
     * Обновляет данные пользователя в базе данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user) {
        Gate::authorize('admin');
        /*
         * Проверяем данные формы
         */
        $this->validator($request->all(), $user->id)->validate();
        /*
         * Обновляем пользователя
         */
        if ($request->change_password) { // если надо изменить пароль
            $request->merge(['password' => Hash::make($request->password)]);
            $user->update($request->all());
        } else {
            if($request->admin != $user->admin){
                $user->update(['admin'=>$request->admin]);
            }else{
                $user->update($request->except(['password']));
            }
        }
        /*
         * Возвращаемся к списку
         */
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Возвращает объект валидатора с нужными нам правилами
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    private function validator(array $data, int $id) {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:30',
                V::userName()
            ],
            'last_name' => [
                'required',
                'string',
                'max:30',
                V::userName()
            ],
            'middle_name' => [
                'required',
                'string',
                'max:30',
                V::userName()
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // проверка на уникальность email, исключая
                // этого пользователя по идентифкатору
                'unique:users,email,'.$id.',id',
            ],
            'admin'=>[
                'required',
                'int'
            ]
            
        ];
        if (isset($data['change_password'])) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        return Validator::make($data, $rules);
    }
}
