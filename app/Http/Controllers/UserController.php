<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a users of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request, ['query' => 'required|min:2|max:55']);

        $queryParam = $request->input('query');

        return User::select('id', 'name', 'email')
            ->where('name', $queryParam)
            ->orWhere('email', $queryParam)
            ->get();
    }
}
