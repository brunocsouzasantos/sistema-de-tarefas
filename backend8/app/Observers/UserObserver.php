<?php

namespace App\Observers;

use App\Models\User;
use App\Http\Controllers\Util;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUserObserver;

class UserObserver
{
    protected $util;

    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
       $this->util->dipararEmailUserObserver('Criação de usuário', $user);
    }
    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $this->util->dipararEmailUserObserver('Alteração de usuário', $user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $this->util->dipararEmailUserObserver('Usuário deletado', $user);
    }
}
