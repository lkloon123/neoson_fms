<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\UpdateFarmUserRequest;
use App\Helper\PermissionHelper;
use App\Helper\ResponseHelper;
use App\Models\Farm;
use App\Models\FarmUser;
use App\Models\User;
use Auth;
use Bouncer;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FarmUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\FarmUser $farmUser
     * @return \Illuminate\Http\Response
     */
    public function show($farmId)
    {
        //get all farm by user
        $farms = Auth::user()->farms;

        if ($farms->isEmpty())
            throw new NotFoundHttpException('no farm found for this user');

        /** @var Farm $findFarm */
        $findFarm = $farms->find($farmId);

        if ($findFarm === null)
            throw new NotFoundHttpException('farm id ' . $farmId . ' not found');

        //check permission
        if (Bouncer::cannot('farm_' . $farmId . '_permission')) {
            throw new AccessDeniedHttpException('you are not allow to set permission of this farm');
        }

        $userListWithoutAuthUser = $findFarm->users->filter(function ($user) use ($farmId) {
            return $user->id !== Auth::user()->id && //not logged user
                !Bouncer::is($user)->a('superuser') && //not super user
                !$user->farmUsers
                    ->where('farm_id', '=', $farmId)
                    ->first
                    ->isFarmOwner; //not farm owner
        });

        foreach ($userListWithoutAuthUser as $user) {
            $permissionTmp = new stdClass();
            $permissionList = PermissionHelper::getAllPermission('farm', $findFarm->id, $user);

            $allPermissionList = PermissionHelper::$farmPermissionList;

            if (empty($permissionList)) {
                $permissionTmp = $allPermissionList;
            } else {
                if (\in_array('*', $permissionList, true)) {
                    foreach ($allPermissionList as $key => $value) {
                        $permissionTmp->$key = true;
                    }
                } else {
                    foreach ($permissionList as $permission) {
                        $splitedStr = explode('_', $permission);
                        $allowedPermission = $splitedStr[\count($splitedStr) - 1];
                        $permissionTmp->$allowedPermission = true;
                        array_forget($allPermissionList, $allowedPermission);
                    }

                    foreach ($allPermissionList as $key => $value) {
                        $permissionTmp->$key = false;
                    }
                }
            }

            $user['permission'] = $permissionTmp;
        }

        return ResponseHelper::success($userListWithoutAuthUser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FarmUser $farmUser
     * @return \Illuminate\Http\Response
     */
    public function edit(FarmUser $farmUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $farmId
     * @param UpdateFarmUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($farmId, UpdateFarmUserRequest $request)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $farmId . '_permission')) {
            throw new AccessDeniedHttpException('you are not allow to set permission of this farm');
        }

        $farmUserList = $request->get('farm_user_list');
        $farms = Auth::user()->farms->keyBy('id');
        $searchedFarm = $farms->get($farmId);

        if ($searchedFarm === null) {
            throw new NotFoundHttpException('farm id ' . $farmId . ' not found');
        }

        foreach ($farmUserList as $farmUser) {
            foreach ($farmUser['permission'] as $permissionName => $permissionValue) {
                if ($permissionValue === true) {
                    Bouncer::allow(User::find($farmUser['id']))->to('farm_' . $searchedFarm->id . '_' . $permissionName);
                } else {
                    Bouncer::disallow(User::find($farmUser['id']))->to('farm_' . $searchedFarm->id . '_' . $permissionName);
                }
            }
        }

        return ResponseHelper::success([
            'msg' => 'permission setting successfully saved'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FarmUser $farmUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(FarmUser $farmUser)
    {
        //
    }
}
