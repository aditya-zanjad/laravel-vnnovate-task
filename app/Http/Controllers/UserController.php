<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UpdateUserRequest;

/**
 * This class contains methods for managing the users.
 *
 * The methods perform tasks that include getting a paginated
 * list of all the users, updating current user's profile etc.
 *
 * @author  Aditya Zanjad <adityazanjad474@gmail.com>
 * @version 1.0
 * @access  public
 */
class UserController extends Controller
{
    /**
     * To decide the number of records per page of the datatable
     *
     * @var int RECORDS_PER_PAGE
     */
    protected const RECORDS_PER_PAGE = [10, 15, 20, 25, 30, 40, 45, 50];

    /**
     * Return a view that'll show a paginated list of users
     *
     * @return \Illuminate\View\View
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    /**
     * Show the form for editing the specified user's profile details.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\View
     */
    public function edit($id)
    {
        $validator = validator()->make(['id' => $id], [
            'id' => 'required|numeric|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.index');
        }

        $validated = $validator->validated();  // Get validated form data

        return view('users.edit')
            ->with('user', User::find($validated['id']))
            ->with('cities', City::select(['id', 'name'])->get());
    }

    /**
     * Allow current user to update their profile details.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $validated  =   $request->validated();  // Get validated form data
        $user       =   User::find($validated['user_id']);

        // Authorize the user
        $this->authorize('update', $user);

        // Default response
        $response = [
            'type'      =>  'error',
            'message'   =>  'Failed to update the user profile'
        ];

        // Update user's details
        $user->name     =   $validated['name'];
        $user->email    =   $validated['email'];
        $user->gender   =   $validated['gender'];
        $user->city_id  =   $validated['city_id'];

        if ($request->has('new_password') && $request->filled('new_password')) {
            $user->password = bcrypt($validated['new_password']);
        }

        $userUpdated = $user->save();

        if ($userUpdated) {
            $response['type']       =   'success';
            $response['message']    =   "The user's profile is updated successfully";
        }

        session()->flash($response['type'], $response['message']);
        return redirect()->route('users.edit', $validated['user_id']);
    }
}
