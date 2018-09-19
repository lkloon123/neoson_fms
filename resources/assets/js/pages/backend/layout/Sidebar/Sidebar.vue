<template>
    <aside class="main-sidebar">
        <section class="sidebar">

            <user-panel></user-panel>

            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Main</li>

                <router-link to="/portal/dashboard" tag="li">
                    <a><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </router-link>

                <router-link to="/portal/portfolio" tag="li">
                    <a><i class="fa fa-eye"></i> <span>My Portfolio</span></a>
                </router-link>

                <li class="treeview">
                    <a href="#"><i class="fa fa-wrench"></i>
                        <span>Miner Control</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link to="/portal/module/minercontrol/monitor" tag="li">
                            <a><i class="fa fa-line-chart"></i> <span>Monitoring</span></a>
                        </router-link>

                        <router-link to="/portal/module/minercontrol/remote/start" tag="li">
                            <a><i class="fa fa-wrench"></i> <span>Remote Start</span></a>
                        </router-link>

                        <router-link to="/portal/module/minercontrol/software/download" tag="li">
                            <a><i class="fa fa-download"></i> <span>Download</span></a>
                        </router-link>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-dollar"></i>
                        <span>Wallet</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link to="/portal/wallet/balance" tag="li">
                            <a><i class="fa fa-credit-card"></i> <span>Balance & Withdrawal</span></a>
                        </router-link>

                        <router-link to="/portal/module/withdrawal/history" tag="li">
                            <a><i class="fa fa-history"></i> <span>Withdrawal History</span></a>
                        </router-link>
                    </ul>
                </li>

                <li class="header">Other</li>

                <router-link to="/portal/coin" tag="li">
                    <a><i class="fa fa-bitcoin"></i> <span>Supported Coins</span></a>
                </router-link>

                <router-link to="/portal/pool" tag="li">
                    <a><i class="fa fa-object-group"></i> <span>Supported Pools</span></a>
                </router-link>

                <li class="treeview">
                    <a href="#"><i class="fa fa-cog"></i>
                        <span>FMS Settings</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link to="/portal/farm" tag="li">
                            <a><i class="glyphicon glyphicon-list"></i> <span>Farm Setting</span></a>
                        </router-link>

                        <router-link to="/portal/nicehash" tag="li">
                            <a><i class="glyphicon glyphicon-list"></i> <span>Nicehash Setting</span></a>
                        </router-link>
                    </ul>
                </li>

                <li class="treeview" v-if="isAdmin">
                    <a href="#"><i class="fa fa-cog"></i>
                        <span>Admin</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <router-link to="/portal/admin/walletcontrol" tag="li">
                            <a><i class="glyphicon glyphicon-list"></i> <span>Wallet Control</span></a>
                        </router-link>

                        <router-link to="/portal/admin/bot/message" tag="li">
                            <a><i class="fa fa-comment"></i> <span>Bot Message</span></a>
                        </router-link>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
</template>

<script>
    import {mapGetters} from 'vuex';
    import UserPanel from "./components/UserPanel";

    export default {
        computed: {
            ...mapGetters({
                isAdmin: 'user/isAdmin'
            })
        },
        components: {
            UserPanel
        },
        mounted() {
            //fix menu tree
            $('.sidebar-menu').tree();

            //fix sidebar
            $(document).on('click', '.sidebar a', function () {
                if ($(this).attr('href') !== '#') {
                    $("body").removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu');
                }
            });
        },
    }
</script>

<style scoped>
    li > a {
        text-decoration: none;
    }
</style>