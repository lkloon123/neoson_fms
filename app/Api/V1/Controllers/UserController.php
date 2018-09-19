<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\UpdateUserRequest;
use App\Api\V1\Resources\UserResource;
use App\Helper\ResponseHelper;
use App\Models\User;
use Auth;
use Bouncer;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check permission
        if (Bouncer::cannot('view_user_list')) {
            throw new AccessDeniedHttpException('you are not allow to view all user');
        }

        return ResponseHelper::success(UserResource::collection(User::all()));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(UpdateUserRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($request->file('profile_img')) {
            $fileName = Storage::disk('public')->put('profile_img', $request->file('profile_img'));
            $user->profile_img = Storage::url($fileName);
        }

        if ($request->get('name')) {
            $user->name = $request->get('name');
        }

        $user->save();

        return ResponseHelper::success([
            'msg' => 'successfully updated user profile',
            'id' => $user->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
