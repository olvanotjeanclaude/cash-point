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
                        <span>Anasayfa</span>
                    </a>
                </li>


                @userPermission(1)
                <li>
                    <a href="{{ route('admin.users.index') }}" class="waves-effect">
                        <i class="fas fa-users-cog"></i>
                        <span id="countUser" class="badge rounded-pill bg-white text-dark float-end"></span>
                        <span>Kullanıcı Yönetimi</span>
                    </a>
                </li>
                @enduserPermission


                @userPermission(2)
                <li>
                    <a href="{{ route('admin.managers.index') }}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span id="countManager" class="badge rounded-pill bg-primary float-end"></span>
                        <span>Yönetici Yönetimi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.staffs.index') }}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span id="countStaff" class="badge rounded-pill bg-warning float-end"></span>
                        <span>Personel yönetimi</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('admin.consultants.index') }}" class="waves-effect">
                        <i class="fas fas fa-id-badge"></i>
                        <span id="countConsultant" class="badge rounded-pill bg-info float-end"></span>
                        <span>Danışmanlarım</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-table"></i>
                        <span>Müsteriler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.customers.index') }}">
                                <span id="countCustomer" class="badge rounded-pill bg-info float-end"></span>
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.customer.my_customers') }}">
                                <span id="countMyCustomer" class="badge rounded-pill bg-info float-end"></span>
                                Müsterilerim
                            </a>
                        </li>
                    </ul>
                </li>
                @enduserPermission

                @userType(3)
                <li>
                    <a href="{{ route('admin.customer.my_customers') }}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span id="countMyCustomer" class="badge rounded-pill bg-info float-end"></span>
                        <span>Müsterilerim</span>
                    </a>
                </li>
                @enduserType

                @userPermission(2)
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-network-wired"></i>
                        <span>Şübeler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{ route('admin.branchs.index') }}">
                                <span id="countBranch" class="badge rounded-pill bg-success float-end"></span>
                                List
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.branchs.my_branchs') }}" class="waves-effect">
                                <span id="countMyBranch" class="badge rounded-pill bg-success float-end"></span>
                                <span>Şübelerim</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @enduserPermission

                @userType(3)
                <li>
                    <a href="{{ route('admin.branchs.my_branchs') }}" class="waves-effect">
                        <i class="fas fa-network-wired"></i>
                        <span id="countMyBranch" class="badge rounded-pill bg-success float-end"></span>
                        <span>Şübelerim</span>
                    </a>
                </li>
                @enduserType

                @userPermission(3)
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-blender-phone"></i>
                        <span>Görüşmeler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if (Auth::user()->permission == 1 || Auth::user()->permission == 2)
                            <li>
                                <a href="{{ route('admin.meetings.index') }}">
                                    <span id="countMeeting" class="badge rounded-pill bg-success float-end"></span>
                                    <span>List</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('admin.meetings.my_meetings') }}">
                                <span id="countMyMeeting" class="badge rounded-pill bg-success float-end"></span>
                                <span>Görüşmelerim</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.bids.my_bids') }}">
                                <span id="myBids" class="badge rounded-pill bg-success float-end"></span>
                                <span>Tekliflerim</span>
                            </a>
                        </li>
                        <li><a href="{{ route('admin.next-meetings.index') }}" class="waves-effect">
                                <span id="countNextMeeting" class="badge rounded-pill bg-success float-end"></span>
                                Yaklaşanlar</a></li>
                    </ul>
                </li>
                @enduserPermission
                @userPermission(2)
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tasks"></i>
                        <span>Proje Ayarları</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.rooms.index') }}">
                                <span id="rooms" class="badge rounded-pill bg-success float-end"></span>
                                <span>Oda Tipleri</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.types.index') }}">
                                <span id="types" class="badge rounded-pill bg-success float-end"></span>
                                <span>Konut Tipleri</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.facades.index') }}">
                                <span id="facades" class="badge rounded-pill bg-success float-end"></span>
                                <span>Cepheler</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.statuses.index') }}">
                                <span id="status" class="badge rounded-pill bg-success float-end"></span>
                                <span>Durumlar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.interior-feature.index') }}">
                                <span id="status" class="badge rounded-pill bg-success float-end"></span>
                                <span>İç Özellikler</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.exterior-feature.index') }}">
                                <span id="exterior" class="badge rounded-pill bg-success float-end"></span>
                                <span>Dış Özellikler</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file"></i>
                        <span>Sayfa Ayarları</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.find-us.index') }}">
                                <span id="rooms" class="badge rounded-pill bg-success float-end"></span>
                                <span>Bizi Nereden Buldunuz</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.motifs.index') }}">
                                <span class="badge rounded-pill bg-success float-end"></span>
                                <span>Pasif Alma Sebepler</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.contracts.index') }}">
                                <span class="badge rounded-pill bg-success float-end"></span>
                                <span>Sözleşmeler</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @enduserPermission
                @userPermission(3)
                <li>
                    <a href="{{ route('admin.projects.index') }}" class="waves-effect">
                        <i class="fas fa-bars"></i>
                        <span id="countProject" class="badge rounded-pill bg-white text-dark float-end"></span>
                        <span>Projeler</span>
                    </a>
                </li>
                @enduserPermission
                @userPermission(3)
                <li>
                    <a href="{{ route('admin.sales.index') }}" class="waves-effect">
                        <i class="fas fa-coins"></i>
                        <span id="countSale" class="badge rounded-pill bg-white text-dark float-end"></span>
                        <span>Satışlar</span>
                    </a>
                </li>
                @enduserPermission

            </ul>
        </div>

        <div class="text-light small invisible mt-5 w-100">
            <p class="text-center">
                © {{ date('Y') }} Developed by
                <a href="https://www.suaresoft.com/" class="text-light" target="_blank">
                    <i class="mdi mdi-heart text-danger"></i>
                    Suaresoft
                </a>
                <span>
                    {{ env('APP_VERSION') }}
                </span>
            </p>
        </div>
    </div>

    <!-- Sidebar -->
</div>
