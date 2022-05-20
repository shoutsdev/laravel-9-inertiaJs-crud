<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(User $user): \Inertia\Response
    {
        return Inertia::render(
            'users',
            [
                'data' => $user->latest()->get()
            ]
        );
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required','min:6','confirmed',],
        ])->validate();

        $request['password'] = bcrypt($request->password);
        User::create($request->all());

        return redirect()->back()
            ->with('message', 'User Created Successfully.');
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required','min:6','confirmed',],
        ])->validate();


        $request['password'] = bcrypt($request->password);
        User::find($request->id)->update($request->all());

        return redirect()->back()
                ->with('message', 'User Updated Successfully.');

    }

    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        User::destroy($request->id);

        return redirect()->back()
            ->with('message', 'User deleted successfully.');
    }
}
