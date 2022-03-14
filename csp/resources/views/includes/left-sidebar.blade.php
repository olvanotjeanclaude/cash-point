<div class="vertical-menu">

    <div data-simplebar class="h-100 loading-sidebar" id="left-sidebar">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled invisible" id="side-menu">
                <li class="text-center mb-3">
                    <h6 class="text-white">{{ Auth::user()->full_name }}</h6>
                    @switch(Auth::user()->permission)
                        @case(1)
                            <label class="badge bg-light">Admin </label>
                        @break

                        @case(2)
                            <label class="badge bg-primary">Yönetici</label>
                        @break

                        @case(3)
                            <label class="badge bg-warning">Personel</label>
                        @break

                        @case(4)
                            <label class="badge bg-info">Müsteri</label>
                        @break

                        @default
                            <label class="badge bg-light">Belirlenmemiş</label>
                    @endswitch
                </li>


                <li>
                    <a href="{{ route('admin.index') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}" class="waves-effect">
                        <i class="fas fa-users-cog"></i>
                        <span id="countUser" class="badge rounded-pill bg-white text-dark float-end"></span>
                        <span>Utilisateurs</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('admin.transactions.index') }}" class="waves-effect">
                        <i class="fas fas fa-id-badge"></i>
                        <span id="countConsultant" class="badge rounded-pill bg-info float-end"></span>
                        <span>Transactions</span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="text-light small invisible mt-5 w-100">
            <p class="text-center">
                © {{ date('Y') }} Developed by
                <a href="https://olvanot.herokuapp.com/" class="text-light" target="_blank">
                    <i class="mdi mdi-heart text-danger"></i>
                    Olvanot Jean Claude Rakotonirina
                </a>
                <span>
                    {{ env('APP_VERSION') }}
                </span>
            </p>
        </div>
    </div>

    <!-- Sidebar -->
</div>
