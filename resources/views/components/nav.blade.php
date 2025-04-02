@auth
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm not-print">
        <div class="container">
            <a class="navbar-brand d-md-none d-lg-block" href="{{ url('/') }}">
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
                    <li>
                        <a href="{{ url('/') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            الرئيسية
                        </a>
                    </li>
                    @can('users_management')
                        <li>
                            <a href="{{ route('admin.users') }}"
                               class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                الموظفين
                            </a>
                        </li>
                    @endcan

                    @can('offices_management')
                        <li>
                            <a href="{{ route('admin.offices') }}"
                               class="{{ request()->routeIs('admin.offices') ? 'active' : '' }}">
                                المقرات
                            </a>
                        </li>
                    @endcan

                    @canany(['break_fast_products_manage', 'import_create', 'import_edit', 'import_delete'])
                        <li>
                            <a href="{{ route('admin.products') }}"
                               class="{{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                الأصناف و الوجبات
                            </a>
                        </li>
                    @endcanany

                    @canany(['delegate_create', 'delegate_edit', 'delegate_delete'])
                        <li>
                            <a href="{{ route('admin.delegates') }}"
                               class="{{ request()->routeIs('admin.delegates') ? 'active' : '' }}">
                                المناديب
                            </a>
                        </li>
                    @endcanany
                    @canany(['tasks_create', 'tasks_edit', 'tasks_delete'])
                        <li>
                            <a href="{{ route('admin.tasks') }}"
                               class="{{ request()->routeIs('admin.tasks') ? 'active' : '' }}">
                                إدارة المهام
                            </a>
                        </li>
                    @endcanany
                    @can('tasks_manage')
                        <li>
                            <a href="{{ route('admin.tasks.managers', [optional(auth()->user()->office)->id]) }}"
                               class="{{ request()->routeIs('admin.tasks.managers') ? 'active' : '' }}">
                                المهام
                            </a>
                        </li>
                    @endcan
                    @canany(['import_writing_print', 'import_create', 'import_edit', 'import_delete'])
                        <li>
                            <a href="{{ route('managers.reports') }}"
                               class="{{ request()->routeIs('managers.reports') ? 'active' : '' }}">
                                المحاضر
                            </a>
                        </li>
                    @endcanany
                    {{--                    @canany(['evaluation_create', 'evaluation_edit', 'evaluation_delete'])--}}
                    {{--                        <li>--}}
                    {{--                            <a href="{{ route('admin.evaluate.index') }}"--}}
                    {{--                               class="{{ request()->routeIs('admin.evaluations') ? 'active' : '' }}">--}}
                    {{--                                التقييم--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    @endcanany--}}
                    @canany(['evaluation_print'])
                        <li>
                            <a href="{{ route('admin.evaluate.index') }}"
                               class="{{ request()->routeIs('admin.evaluations') ? 'active' : '' }}">
                                التقييم
                            </a>
                        </li>
                    @endcanany

                    <li>
                        <a href="{{ route('contract.index') }}"
                           class="{{ request()->routeIs('contract.index') ? 'active' : '' }}">
                            العقود
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav align-items-center gap-1">
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
                        @role('admin')
                        <li class="nav-item dropdown notification-li" wire:click="updateUnreadedLogs">
                            <i class="fa-solid fa-bell fa-lg"></i>
                            <span class="badge badge-danger">@livewire('logs-counter-livewire')</span>
                            <ul class="logs">
                                @livewire('logs-list-livewire')
                            </ul>
                        </li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mx-2">
                                    <i class="fa-solid fa-user-circle fa-lg"></i>
                                    {{ strtok(Auth::user()->name, ' ') }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
    {{--    @dd(\Spatie\Activitylog\Models\Activity::all()->last(), auth()->user()->lastReadedLog)--}}
@endauth
