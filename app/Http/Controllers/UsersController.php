<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Response;

class UsersController extends Controller
{

    public function __construct()
    {
      $this->middleware('jwt.auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return Response::json([
          // 'data' => $users
          'profiles' => $this->transformCollection($users)
        ], 200);
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
        if (!$request->name or !$request->email or !$request->nickname or !$request->bio)
        {
          return Response::json([
            'error' => [
              'message' => 'Please Provide Name, email, nickname and Bio'
            ]
          ], 422);
        }
        $user = User::create($request->all());

        return Response::json([
          'message' => 'Profile Created Successfully',
          'profile' => $this->transform($user)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);

        if(!$user) {
          return Response::json([
            'error' => [
              'message' => 'Profile does nor exist'
            ]
          ], 404);
        }
        return Response::json([
          // 'data' => $profile
          'profile' => $this->transform($user)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!$request->name or !$request->email or !$request->nickname or !$request->bio)
        {
          return Response::json([
            'error' => [
              'message' => 'Please Provide Name, email, nickname and Bio'
              ]
          ], 422);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nickname = $request->nickname;
        $user->bio = $request->bio;
        $user->save();

        return Response::json([
          'message' => 'Profile Updated Successfully'
        ]);
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
        User::destroy($id);
    }

    private function transformCollection($users)
    {
      return array_map([$this, 'transform'], $users->toArray());
    }

    private function transform($user)
    {
      return [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'nickname' => $user['nickname'],
        'bio' => $user['bio']
      ];
    }
}
