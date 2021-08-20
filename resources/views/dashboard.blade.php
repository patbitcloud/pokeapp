@extends('layouts.master')
@section('content')
<b-navbar toggleable="lg" class="navbar">
    <b-navbar-brand href="#"><img src="/assets/img/pokeapi_256.888baca4.png" class="app_img" /></b-navbar-brand>

    <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item :to="{ name: 'dashboard' }"><span style="color: #fff; fonr-weight:bold;">Dashboard</span>
            </b-nav-item>
            <b-nav-item :to="{ name: 'otherUser' }"><span style="color: #fff; fonr-weight:bold;">Users</span>
            </b-nav-item>
            <b-nav-item :to="{ name: 'myFavorites' }"><span style="color: #fff; fonr-weight:bold;">My Favorites</span>
            </b-nav-item>
        </b-navbar-nav>
        <div class="nav_menu_dropdown">
            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">

                <b-nav-item-dropdown right>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em style="color: #fff; font-weight: bold;">{{ $authUser->full_name }}</em>
                    </template>
                    <b-dropdown-item href="#" v-b-toggle.sidebar-backdrop>Profile</b-dropdown-item>
                    <b-dropdown-item href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form1').submit();">Sign Out</b-dropdown-item>
                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </b-nav-item-dropdown>

            </b-navbar-nav>
        </div>

    </b-collapse>

</b-navbar>
<b-sidebar id="sidebar-backdrop" title="Edit Profile" backdrop shadow>
    <user-profile :auth-user="{{ $authUser }}" />
</b-sidebar>
<b-container fluid>
    <router-view></router-view>
</b-container>
@endsection

<style>
    .navbar {
        background-color: #ef5350;
    }

    .nav_menu_dropdown {
        position: relative;
        left: 64%;

    }

    .app_img {
        height: 50px;
        padding-left: 20px;
    }
</style>