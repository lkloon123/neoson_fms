import VueRouter from "vue-router";

const notFound = (dashboardUrl) => {
    return {
        path: '*',
        component: () => import('./pages/NotFound.vue'),
        props: {
            dashboardUrl: dashboardUrl
        }
    }
};

const routes = [
        {
            path: '/portal',
            component: () => import('./pages/backend/layout/Main.vue'),
            meta: {requiresAuth: true},
            children: [
                {
                    path: '/',
                    redirect: 'dashboard',
                },
                {
                    path: 'dashboard',
                    component: () => import('./pages/backend/views/dashboard/Index'),
                },
                {
                    path: 'setting',
                    component: () => import('./pages/backend/views/setting/Index'),
                    children: [
                        {
                            path: 'twofactor',
                            component: () => import('./pages/backend/views/setting/two_factor/Index'),
                        },
                        {
                            path: 'editprofile',
                            component: () => import('./pages/backend/views/setting/edit_profile/Index'),
                        },
                        {
                            path: 'changepassword',
                            component: () => import('./pages/backend/views/setting/change_password/Index'),
                        },
                        {
                            path: 'notification',
                            component: () => import('./pages/backend/views/setting/notification/Index'),
                        }
                    ]
                },
                {
                    path: 'support/ticket',
                    component: () => import('./pages/backend/views/support_ticket/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/support_ticket/SupportTicket/SupportTicketContainer'),
                        },
                        {
                            path: 'view/:id',
                            component: () => import('./pages/backend/views/support_ticket/SupportTicketMessage/SupportTicketMessageContainer'),
                        },
                        {
                            path: 'create',
                            component: () => import('./pages/backend/views/support_ticket/SupportTicket/CreateSupportTicketContainer'),
                        }
                    ]
                },
                {
                    path: 'farm',
                    component: () => import('./pages/backend/views/farm/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/farm/FarmContainer'),
                        }
                    ]
                },
                {
                    path: 'miner',
                    component: () => import('./pages/backend/views/miner/Index'),
                    children: []
                },
                {
                    path: 'portfolio',
                    component: () => import('./pages/backend/views/portfolio/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/portfolio/PortfolioContainer'),
                        }
                    ]
                },
                {
                    path: 'coin',
                    component: () => import('./pages/backend/views/coin/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/coin/CoinContainer'),
                        },
                        {
                            path: 'create',
                            name: 'coin_create',
                            component: () => import('./pages/backend/views/coin/CreateAndUpdateCoinContainer'),
                        },
                        {
                            path: ':id/edit',
                            name: 'coin_edit',
                            component: () => import('./pages/backend/views/coin/CreateAndUpdateCoinContainer'),
                        },
                        {
                            path: ':id',
                            name: 'coin_view',
                            component: () => import('./pages/backend/views/coin/DetailViewCoinContainer'),
                        }
                    ]
                },
                {
                    path: 'pool',
                    component: () => import('./pages/backend/views/pool/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/pool/PoolContainer'),
                        },
                        {
                            path: 'create',
                            name: 'pool_create',
                            component: () => import('./pages/backend/views/pool/CreateAndUpdatePoolContainer'),
                        },
                        {
                            path: ':id/edit',
                            name: 'pool_edit',
                            component: () => import('./pages/backend/views/pool/CreateAndUpdatePoolContainer'),
                        },
                        {
                            path: ':id',
                            name: 'pool_view',
                            component: () => import('./pages/backend/views/pool/DetailViewPoolContainer'),
                        }
                    ]
                },
                {
                    path: 'wallet',
                    component: () => import('./pages/backend/views/modules/wallet/Index'),
                    children: [
                        {
                            path: 'balance',
                            component: () => import('./pages/backend/views/modules/wallet/WalletBalanceContainer'),
                        }
                    ]
                },
                {
                    path: 'nicehash',
                    component: () => import('./pages/backend/views/nicehash/Index'),
                    children: [
                        {
                            path: '/',
                            component: () => import('./pages/backend/views/nicehash/NicehashAccountContainer'),
                        }
                    ]
                },
                {
                    path: 'module/withdrawal',
                    component: () => import('./pages/backend/views/modules/withdrawal/Index'),
                    children: [
                        {
                            path: 'history',
                            component: () => import('./pages/backend/views/modules/withdrawal/WithdrawalHistoryContainer'),
                        }
                    ]
                },
                {
                    path: 'module/minercontrol',
                    component: () => import('./pages/backend/views/modules/miner_control/Index'),
                    children: [
                        {
                            path: 'monitor',
                            component: () => import('./pages/backend/views/modules/miner_control/monitor/Index'),
                            children: [
                                {
                                    path: '/',
                                    component: () => import('./pages/backend/views/modules/miner_control/monitor/MonitorContainer'),
                                }
                            ]
                        },
                        {
                            path: 'remote',
                            component: () => import('./pages/backend/views/modules/miner_control/remote_start/Index'),
                            children: [
                                {
                                    path: 'start',
                                    component: () => import('./pages/backend/views/modules/miner_control/remote_start/RemoteStartContainer'),
                                }
                            ]
                        },
                        {
                            path: 'software',
                            component: () => import('./pages/backend/views/modules/miner_control/software/Index'),
                            children: [
                                {
                                    path: 'download',
                                    component: () => import('./pages/backend/views/modules/miner_control/software/SoftwareContainer')
                                }
                            ]
                        }
                    ]
                },
                {
                    path: 'admin',
                    component: () => import('./pages/backend/views/admin/Index'),
                    meta: {requiresAdmin: true},
                    children: [
                        {
                            path: 'walletcontrol',
                            component: () => import('./pages/backend/views/admin/wallet_control/Index'),
                            children: [
                                {
                                    path: '/',
                                    component: () => import('./pages/backend/views/admin/wallet_control/WalletControlContainer'),
                                },
                                {
                                    path: 'create',
                                    component: () => import('./pages/backend/views/admin/wallet_control/CreateWalletControl'),
                                }
                            ]
                        },
                        {
                            path: 'bot',
                            component: () => import('./pages/backend/views/admin/bot_message/Index'),
                            children: [
                                {
                                    path: 'message',
                                    component: () => import('./pages/backend/views/admin/bot_message/BotMessageContainer'),
                                },
                            ]
                        }
                    ]
                },
                notFound('/portal')
            ]
        },
        {
            path: '/',
            component: () => import('./pages/frontend/layout/Main'),
            meta: {requiresAuth: false},
            children: [
                {
                    path: '/',
                    component: () => import('./pages/frontend/views/dashboard/Index'),
                },
                {
                    path: 'login',
                    component: () => import('./pages/frontend/views/auth/Login'),
                },
                {
                    path: 'register',
                    component: () => import('./pages/frontend/views/auth/Register'),
                },
                {
                    path: 'email/verify',
                    component: () => import('./pages/frontend/views/auth/VerifyEmail'),
                },
                {
                    path: 'password/recovery',
                    component: () => import('./pages/frontend/views/auth/RecoveryPassword'),
                },
                {
                    path: 'password/reset',
                    component: () => import('./pages/frontend/views/auth/ResetPassword')
                },
                {
                    path: 'wallet/withdraw/process',
                    component: () => import('./pages/frontend/views/withdraw/VerifyWithdraw'),
                },
                notFound('/')
            ]
        }
    ]
;

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    linkExactActiveClass: 'active',
    scrollBehavior: (to, from, savedPosition) => {
        return savedPosition || {x: 0, y: 0}
    }
});

export default router;