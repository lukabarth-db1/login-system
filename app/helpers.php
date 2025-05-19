<?php

use App\Models\User;

function user()
{
    if (session()->has('user_id')) {
        return User::find(session('user_id'));
    }

    return null;
}
