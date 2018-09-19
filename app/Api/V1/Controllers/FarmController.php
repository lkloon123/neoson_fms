<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CreateFarmRequest;
use App\Api\V1\Requests\UpdateFarmRequest;
use App\Api\V1\Resources\FarmResource;
use App\Helper\PermissionHelper;
use App\Helper\ResponseHelper;
use App\Models\Farm;
use App\Models\FarmUser;
use Auth;
use Bouncer;
use stdClass;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FarmController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function index()
    {
        //get all farm by user
        $farms = Auth::user()->farms;

        if ($farms->isEmpty())
            throw new NotFoundHttpException('no farm found for this user');

        return ResponseHelper::success(FarmResource::collection($farms));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateFarmRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateFarmRequest $request)
    {
        $requestData = $request->only([
            'farm_name',
            'pool_id',
            'coin_id',
            'available'
        ]);

        $farm = Farm::create($requestData);
        $this->validateModel($farm);

        $farm_user = FarmUser::create([
            'isFarmOwner' => true,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id
        ]);
        $this->validateModel($farm_user);

        //set permission to the farm owner
        PermissionHelper::grantAllFarmPermission($farm->id);

        return ResponseHelper::success([
            'msg' => 'farm created',
            'id' => $farm->id
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $farmId
     * @return \Illuminate\Http\Response
     */
    public function show($farmId)
    {
        //get all farm by user
        $farms = Auth::user()->farms;

        if ($farms->isEmpty())
            throw new NotFoundHttpException('no farm found for this user');

        $findFarm = $farms->find($farmId);

        if ($findFarm === null)
            throw new NotFoundHttpException('farm id ' . $farmId . ' not found');

        return ResponseHelper::success(new FarmResource($findFarm));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $farmId
     * @param UpdateFarmRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($farmId, UpdateFarmRequest $request)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $farmId . '_update')) {
            throw new AccessDeniedHttpException('you are not allow to update this farm');
        }

        $requestData = $request->only([
            'farm_name',
            'pool_id',
            'coin_id',
            'available'
        ]);

        if (empty($requestData)) {
            return ResponseHelper::success([
                'msg' => 'nothing updated'
            ]);
        }

        $farm = Farm::find($farmId);

        if ($farm === null) {
            throw new NotFoundHttpException('farm id ' . $farmId . ' not found');
        }

        foreach ($requestData as $key => $value) {
            $farm->$key = $value;
        }

        $this->saveModel($farm);

        return ResponseHelper::success([
            'msg' => 'farm ' . $farm->farm_name . ' updated',
            'id' => $farmId
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $farmId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete($farmId)
    {
        //check permission
        if (Bouncer::cannot('farm_' . $farmId . '_delete')) {
            throw new AccessDeniedHttpException('you are not allow to delete this farm');
        }

        $farm = Farm::find($farmId);
        if ($farm === null)
            throw new NotFoundHttpException('farm id ' . $farmId . ' not found');

        $farm->miners()->delete();
        $farm->farmUsers()->delete();
        $farm->delete();

        return ResponseHelper::success([
            'msg' => 'farm ' . $farm->farm_name . ' deleted'
        ]);
    }

    public function allPermission()
    {
        return ResponseHelper::success(array_keys(PermissionHelper::$farmPermissionList));
    }

    public function getPermissionList()
    {
        //get all farm by user
        $farms = Auth::user()->farms;

        if ($farms->isEmpty())
            throw new NotFoundHttpException('no farm found for this user');

        $finalPermissionList = [];
        foreach ($farms as $farm) {
            $permissionList = PermissionHelper::getAllPermission('farm', $farm->id);

            $permissionTmp = new stdClass();
            $permissionTmp->id = $farm->id;

            $allPermissionList = PermissionHelper::$farmPermissionList;

            if (empty($permissionList)) {
                $permissionTmp->permission = $allPermissionList;
            } else {
                if (\in_array('*', $permissionList, true)) {
                    foreach ($allPermissionList as $key => $value) {
                        $permissionTmp->permission[$key] = true;
                    }
                } else {
                    foreach ($permissionList as $permission) {
                        $splitedStr = explode('_', $permission);
                        $permissionTmp->permission[$splitedStr[\count($splitedStr) - 1]] = true;
                        array_forget($allPermissionList, $splitedStr[\count($splitedStr) - 1]);
                    }

                    foreach ($allPermissionList as $leftoverPermission) {
                        $permissionTmp->permission[$leftoverPermission] = false;
                    }
                }
            }

            $finalPermissionList[] = $permissionTmp;
        }

        return ResponseHelper::success($finalPermissionList);
    }
}
