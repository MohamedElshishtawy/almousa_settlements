@auth
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm not-print">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav nav-pages">
                    @auth
                        @can('users_management')
                            {{-- Replaced @role with @can --}}
                            <li>
                                <a href="{{route('admin.users')}}"
                                   class="@if(isset($active) && $active == 'employee') active @endif">
                                    الموظفين
                                </a>
                            </li>
                        @endcan

                        @can('offices_management')
                            {{-- Replaced @role with @can --}}
                            <li>
                                <a href="{{route('admin.offices')}}"
                                   class="@if(isset($active) && $active == 'office') active @endif">
                                    المقرات
                                </a>
                            </li>
                        @endcan


                        @canany(['break_fast_products_manage', 'import_create', 'import_edit', 'import_delete', 'import_show_price','import_model2_create','surplus_create', 'surplus_edit', 'surplus_delete','surplus_model2_create','employment_create', 'employment_edit', 'employment_delete', 'dry_food_create', 'dry_food_edit', 'dry_food_delete', 'dry_food_print','tasks_create', 'tasks_edit', 'tasks_delete','delegate_absence_create', 'delegate_absence_edit', 'delegate_absence_delete', 'delegate_absence_print','delegate_create', 'delegate_edit', 'delegate_delete','unites_management','offices_management','users_management'])
                            {{-- Combined multiple roles with @can and array of permissions --}}
                            <li>
                                <a href="{{route('admin.products')}}"
                                   class="@if(isset($active) && $active == 'products') active @endif">
                                    الأصناف و الوجبات
                                </a>
                            </li>
                        @endcanany

                        @canany(['delegate_create', 'delegate_edit', 'delegate_delete', 'import_create', 'import_edit', 'import_delete', 'import_show_price','import_model2_create','surplus_create', 'surplus_edit', 'surplus_delete','surplus_model2_create','employment_create', 'employment_edit', 'employment_delete'])
                            {{-- Combined multiple roles with @can and array of permissions --}}
                            <li>
                                <a href="{{route('admin.delegates')}}"
                                   class="@if(isset($active) && $active == 'delegates') active @endif">
                                    المناديب
                                </a>
                            </li>
                        @endcanany

                        @canany(['tasks_create', 'tasks_edit', 'tasks_delete'])
                            {{-- Task Management Permission --}}
                            <li>
                                <a href="{{route('managers.tasks')}}"
                                   class="@if(isset($active) && $active == 'tasks') active @endif">
                                    المهام
                                </a>
                            </li>
                        @endcanany

                        @can(['import_writing_print', 'import_create', 'import_edit', 'import_delete', 'import_show_price','import_model2_create','surplus_create', 'surplus_edit', 'surplus_delete','surplus_model2_create','employment_create', 'employment_edit', 'employment_delete'])
                            {{-- Report Viewing Permission --}}
                            <li>
                                <a href="{{route('managers.reports')}}"
                                   class="@if(isset($active) && $active == 'reports') active @endif">
                                    المحاضر
                                </a>
                            </li>
                        @endcan
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav align-items-center gap-1">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown notification-li">
                            <i class="fa-solid fa-bell fa-lg"></i>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{--first word only--}}
                                <span class="mx-2">
                                            <i class="fa-solid fa-user-circle fa-lg"></i>
                                        {{ explode(' ', Auth::user()->name)[0]}}
                                        </span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
@endauth
