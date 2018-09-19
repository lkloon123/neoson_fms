<?php

use App\Helper\ResponseHelper;
use App\Helper\VersioningHelper;
use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    //basic api
    $api->group(['namespace' => 'App\Api\V1\Controllers', 'middleware' => 'bindings'], function (Router $api) {
        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->post('register', 'AuthController@register');
            $api->post('login', 'AuthController@login');
            $api->post('email/verify', 'AuthController@verifyEmail');

            $api->post('recovery', 'AuthController@recoveryPassword');
            $api->post('reset', 'AuthController@resetPassword');

            $api->post('refresh', 'AuthController@refresh');

            //required token
            $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
                $api->post('password/change', 'AuthController@changePassword');
                $api->post('logout', 'AuthController@logout');
                $api->post('me', 'AuthController@me');
            });
        });

        //required token
        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            //dashboard
            $api->group(['prefix' => 'dashboard'], function (Router $api) {
                $api->get('/', 'DashboardController@index');
            });

            //settings
            $api->group(['prefix' => 'setting'], function (Router $api) {
                //2fa
                $api->group(['prefix' => 'twofa'], function (Router $api) {
                    $api->post('/setup', 'TwoFactorController@setup');
                    $api->post('/setup/save', 'TwoFactorController@save');
                    $api->post('/disable', 'TwoFactorController@disable');
                    $api->post('/verify', 'TwoFactorController@verify');
                    $api->post('/check', 'TwoFactorController@check');
                });

                //notifications
                $api->group(['prefix' => 'notification'], function (Router $api) {
                    $api->get('/', 'NotificationSettingController@index');
                    $api->put('/', 'NotificationSettingController@update');
                });
            });

            //portfolio
            $api->group(['prefix' => 'monitor'], function (Router $api) {
                $api->get('/', 'MonitorInfoController@index');
            });

            //farm
            $api->group(['prefix' => 'farm'], function (Router $api) {
                $api->get('/permission', 'FarmController@getPermissionList');
                $api->get('/permission/list', 'FarmController@allPermission');
                $api->get('/{id}/user/list', 'FarmUserController@show');
                $api->put('/{id}/user/list', 'FarmUserController@update');

                $api->get('/', 'FarmController@index');
                $api->post('/', 'FarmController@create');
                $api->get('/{id}', 'FarmController@show');
                $api->put('/{id}', 'FarmController@update');
                $api->delete('/{id}', 'FarmController@delete');
            });

            //miner
            $api->group(['prefix' => 'miner'], function (Router $api) {
                $api->get('/', 'MinerController@index');
                $api->post('/', 'MinerController@create');
                $api->get('/summary/{minerId}', 'MinerSummaryController@index');
                $api->get('/{id}', 'MinerController@show');
                $api->put('/{id}', 'MinerController@update');
                $api->delete('/{id}', 'MinerController@delete');
            });

            //coin
            $api->group(['prefix' => 'coin'], function (Router $api) {
                $api->post('/', 'CoinController@create');
                $api->put('/{id}', 'CoinController@update');
                $api->delete('/{id}', 'CoinController@delete');
            });

            //pool
            $api->group(['prefix' => 'pool'], function (Router $api) {
                $api->post('/', 'PoolController@create');
                $api->put('/{id}', 'PoolController@update');
                $api->delete('/{id}', 'PoolController@delete');
            });

            //user
            $api->group(['prefix' => 'user'], function (Router $api) {
                $api->get('/', 'UserController@index');
                $api->post('/', 'UserController@update');
            });

            //notification
            $api->group(['prefix' => 'notification'], function (Router $api) {
                $api->get('/', 'NotificationController@index');
                $api->put('/{id}', 'NotificationController@update');
                $api->put('/update/all', 'NotificationController@updateAll');
            });

            //wallet
            $api->group(['prefix' => 'wallet'], function (Router $api) {
                $api->get('/', 'WalletController@index');
            });

            //wallet control
            $api->group(['prefix' => 'walletcontrol'], function (Router $api) {
                $api->get('/setup/coinlist', 'WalletControlController@getNotExistCoinList');
                $api->post('/', 'WalletControlController@create');
                $api->put('/{id}', 'WalletControlController@update');
                $api->delete('/{id}', 'WalletControlController@delete');
            });

            //nicehash account
            $api->group(['prefix' => 'nicehash/account'], function (Router $api) {
                $api->get('/', 'NicehashAccountController@index');
                $api->post('/', 'NicehashAccountController@create');
                $api->get('/{id}', 'NicehashAccountController@show');
                $api->put('/{id}', 'NicehashAccountController@update');
                $api->delete('/{id}', 'NicehashAccountController@delete');
            });

            //support
            $api->group(['prefix' => 'support'], function (Router $api) {
                $api->group(['prefix' => 'ticket'], function (Router $api) {
                    $api->get('/', 'SupportTicketController@index');
                    $api->post('/', 'SupportTicketController@create');
                    $api->get('/{id}', 'SupportTicketController@show');
                    $api->post('/{id}', 'SupportTicketController@update');

                    $api->group(['prefix' => 'message'], function (Router $api) {
                        $api->get('/{supportTicketId}', 'SupportTicketMessageController@index');
                        $api->post('/{supportTicketId}', 'SupportTicketMessageController@create');
                    });
                });
            });
        });

        //public api
        $api->group(['prefix' => 'public', 'middleware' => 'bindings'], function (Router $api) {
            //public/coin
            $api->get('coin', 'CoinController@index');
            $api->get('coin/{id}', 'CoinController@show');

            //public/pool
            $api->get('pool', 'PoolController@index');
            $api->get('pool/{id}', 'PoolController@show');

            //public/wallet control
            $api->get('walletcontrol/status', 'WalletControlController@index');
            $api->get('walletcontrol/status/{ticker}', 'WalletControlController@show');

            //public/miner
            $api->get('miner/verify', 'MinerController@verify');
            $api->post('miner/summary', 'MinerSummaryController@create');

            //public/software
            $api->get('software', 'SoftwareController@index');
            $api->get('software/{id}', 'SoftwareController@show');
            $api->get('software/{id}/download', 'SoftwareController@minerDownload');
        });

    });

    //modules
    $api->group(['prefix' => 'modules', 'middleware' => 'bindings', 'namespace' => '\App\Modules\Controllers'], function (Router $api) {
        //modules/remotestart
        $api->group(['prefix' => 'remotestart', 'middleware' => 'jwt.auth'], function (Router $api) {
            $api->get('/setup', 'RemoteStartController@setup');
            $api->get('/setup/pooldata/{ticker}', 'RemoteStartController@poolData');
            $api->post('/start', 'RemoteStartController@start');
        });

        //modules/bot
        $api->group(['prefix' => 'bot', 'middleware' => 'jwt.auth'], function (Router $api) {
            $api->post('/message', 'BotMessageController@create');
        });

        //modules/withdrawal
        $api->group(['prefix' => 'withdrawal', 'middleware' => 'jwt.auth'], function (Router $api) {
            $api->post('/fee', 'WithdrawalController@getFee');
            $api->post('/request', 'WithdrawalController@requestWithdrawal');
            $api->post('/process', 'WithdrawalController@processWithdrawal');
            $api->get('/history', 'WithdrawHistoryController@index');
        });

        //modules/miner
        //for miner client call purpose
        $api->group(['prefix' => 'miner'], function (Router $api) {
            $api->post('/get', 'RemoteStartController@getMinerByApiKey');
        });

        //modules/control
        //for controls
        $api->group(['prefix' => 'control'], function (Router $api) {
            $api->get('/latest', function () {
                return response()->json(['success' => true, 'data' => [
                    'ver' => VersioningHelper::minerControl()->verNumber(),
                    'size' => Storage::size('miner_control/' . VersioningHelper::minerControl()->verNumber() . '/neosonfms_launcher.jar'),
                    'release' => Storage::lastModified('miner_control/' . VersioningHelper::minerControl()->verNumber() . '/neosonfms_miner.jar')
                ]]);
            });
            $api->get('/download', function () {
                return response()->download(storage_path('app/miner_control/' . VersioningHelper::minerControl()->verNumber() . '/neosonfms_miner.jar'));
            });
            $api->get('/download/launcher', function () {
                return response()->download(storage_path('app/miner_control/' . VersioningHelper::minerControl()->verNumber() . '/neosonfms_launcher.jar'));
            });
        });
    });

    $api->get('/clearcache', function () {
        return response()->json([Cache::flush()]);
    });

    $api->get('/version', function () {
        return ResponseHelper::success([
            'version' => VersioningHelper::mainApp()->verNumber()
        ]);
    });
});
