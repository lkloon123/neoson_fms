<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Helper;


use App\Models\User;
use Auth;
use Bouncer;

class PermissionHelper
{
    public static $farmPermissionList = [
        'update' => false,
        'delete' => false,
        'withdraw' => false,
        'permission' => false
    ];

    public static function grantAllFarmPermission($farmId, User $user = null)
    {
        $role = 'farm_' . $farmId . '_all';
        $allowUser = Bouncer::allow($role);

        foreach (self::$farmPermissionList as $farmPermission => $value) {
            $allowUser->to('farm_' . $farmId . '_' . $farmPermission);
        }

        if ($user === null) {
            Bouncer::assign($role)->to(Auth::user());
        } else {
            Bouncer::assign($role)->to($user);
        }
    }

    public static function getAllPermission($model = null, $modelId = null, User $user = null)
    {
        if ($user === null) {
            $permissionList = Auth::user()->getAbilities();
        } else {
            $permissionList = $user->getAbilities();
        }

        $permissionList = $permissionList->pluck('name')->all();

        if ($model === null) {
            return $permissionList;
        }

        if (\in_array('*', $permissionList, true)) {
            return $permissionList;
        }

        return array_where($permissionList,
            function ($value) use ($model, $modelId) {
                $splitedStr = explode('_', $value);
                if ($modelId !== null) {
                    return starts_with($value, $model) && (int)$splitedStr[1] === $modelId;
                }
                return starts_with($value, $model);
            }
        );
    }
}