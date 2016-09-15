<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Profile;
use Response;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profiles = Profile::all();
        return Response::json([
          // 'data' => $profiles
          'data' => $this->transformCollection($profiles)
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
        if (!$request->bio)
        {
          return Response::json([
            'error' => [
              'message' => 'Please Provide Bio'
            ]
          ], 422);
        }
        $profile = Profile::create($request->all());

        return Response::json([
          'message' => 'Profile Created Successfully',
          'data' => $this->transform($profile)
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
        $profile = Profile::find($id);

        if(!$profile) {
          return Response::json([
            'error' => [
              'message' => 'Profile does nor exist'
            ]
          ], 404);
        }
        return Response::json([
          // 'data' => $profile
          'data' => $this->transform($profile)
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
        if(!$request->bio)
        {
          return Response::json([
            'error' => [
              'message' => 'Please Provide Bio'
              ]
          ], 422);
        }

        $profile = Profile::find($id);
        $profile->bio = $request->bio;
        $profile->save();

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
        Profile::destroy($id);
    }

    private function transformCollection($profiles)
    {
      return array_map([$this, 'transform'], $profiles->toArray());
    }

    private function transform($profile)
    {
      return [
        'profile_id' => $profile['id'],
        'profile' => $profile['bio']
      ];
    }
}
