<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1"
    m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('admin.dashboard') }}" class="m-menu__link "><i
                    class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span
                        class="m-menu__link-wrap"> <span class="m-menu__link-text">Dashboard</span>
                    </span></span></a></li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text">Components</h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu {{ Route::is('stuff.*') || Route::is('item.*') || Route::is('consumable.*') || Route::is('barcode.*') || Route::is('stock_bhp.*') || Route::is('opname.*') ? 'm-menu__item--open m-menu__item--expanded' : '' }}"
            aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;"
                class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-layers"></i><span
                    class="m-menu__link-text">Barang</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span
                                class="m-menu__link-text">Base</span></span></li>
                    <li class="m-menu__item {{ Route::is('stuff.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('stuff.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Data Barang</span></a></li>
                    <li class="m-menu__item {{ Route::is('item.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('item.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Data Item</span></a></li>
                    <li class="m-menu__item {{ Route::is('stock_bhp.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('stock_bhp.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Stok Barang BHP</span></a></li>
                    <li class="m-menu__item {{ Route::is('consumable.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('consumable.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Pengunaan BHP</span></a></li>
                    <li class="m-menu__item {{ Route::is('opname.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('opname.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Stock Opname</span></a></li>
                    <li class="m-menu__item {{ Route::is('barcode.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('barcode.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Cetak Barcode</span></a></li>
                </ul>
            </div>
        </li>
        <li class="m-menu__item {{ Route::is('rental.*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a
                href="{{ route('rental.home', ['status' => 'submission']) }}" class="m-menu__link "><i
                    class="m-menu__link-icon flaticon-interface-4"></i><span class="m-menu__link-title"> <span
                        class="m-menu__link-wrap"> <span class="m-menu__link-text">Peminjaman</span>
                    </span></span></a></li>
        <li class="m-menu__item {{ Route::is('procurement.*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a
                href="{{ route('procurement.home', ['status' => 'submission']) }}" class="m-menu__link "><i
                    class="m-menu__link-icon flaticon-cart"></i><span class="m-menu__link-title"> <span
                        class="m-menu__link-wrap"> <span class="m-menu__link-text">Pengadaan</span>
                    </span></span></a></li>
        <li class="m-menu__item {{ Route::is('exterminate.*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a
                href="{{ route('exterminate.home', ['status' => 'submission']) }}" class="m-menu__link "><i
                    class="m-menu__link-icon flaticon-signs-2"></i><span class="m-menu__link-title"> <span
                        class="m-menu__link-wrap"> <span class="m-menu__link-text">Pemusnahan</span>
                    </span></span></a></li>
        <li class="m-menu__item  m-menu__item--submenu {{ Route::is('report.*') ? 'm-menu__item--open m-menu__item--expanded' : '' }}"
            aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;"
                class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-clipboard"></i><span
                    class="m-menu__link-text">Laporan</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                            class="m-menu__link"><span class="m-menu__link-text">Buttons</span></span></li>
                    {{-- <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.stuff') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Data Barang</span></a></li>
                    <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.item') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Data Item Barang</span></a></li> --}}
                    <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.consumable') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Penggunaan BHP</span></a></li>
                    {{-- <li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/dropdown.html"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">User</span></a></li>
                    <li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/dropdown.html"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Item</span></a></li> --}}
                    <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.rental') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Peminjaman</span></a></li>
                    <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.procurement') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Pengadaan</span></a></li>
                    <li class="m-menu__item " aria-haspopup="true"><a href="{{ route('report.extermination') }}"
                            class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Pemusnahan</span></a></li>

                </ul>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu {{ Route::is('school.*') || Route::is('type.*') || Route::is('category.*') || Route::is('unit.*') || Route::is('location.*') || Route::is('supplier.*') || Route::is('broken_action.*') || Route::is('source.*') ? 'm-menu__item--open m-menu__item--expanded' : '' }}"
            aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;"
                class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-web"></i><span
                    class="m-menu__link-text">Data Master</span><i
                    class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                            class="m-menu__link"><span class="m-menu__link-text">Buttons</span></span></li>
                    <li class="m-menu__item {{ Route::is('school.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('school.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Data Sekolah</span></a></li>
                    <li class="m-menu__item {{ Route::is('type.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('type.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Jenis Barang</span></a></li>
                    <li class="m-menu__item {{ Route::is('category.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('category.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Kategori Barang</span></a></li>
                    <li class="m-menu__item {{ Route::is('unit.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('unit.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Satuan</span></a></li>
                    <li class="m-menu__item {{ Route::is('location.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('location.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Ruang</span></a></li>
                    <li class="m-menu__item {{ Route::is('supplier.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('supplier.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Penyedia</span></a></li>
                    <li class="m-menu__item {{ Route::is('broken_action.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('broken_action.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Tindakan Pemusnahan</span></a></li>
                    <li class="m-menu__item {{ Route::is('source.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('source.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Sumber Dana</span></a></li>

                </ul>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu {{ Route::is('admin.*') || Route::is('user.*') ? 'm-menu__item--open m-menu__item--expanded' : '' }}"
            aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;"
                class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users"></i><span
                    class="m-menu__link-text">Akun</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
            <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                            class="m-menu__link"><span class="m-menu__link-text">Portlets</span></span></li>
                    <li class="m-menu__item  {{ Route::is('admin.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('admin.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">Admin</span></a></li>
                    <li class="m-menu__item {{ Route::is('user.*') ? 'm-menu__item--active' : '' }}"
                        aria-haspopup="true"><a href="{{ route('user.home') }}" class="m-menu__link "><i
                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                class="m-menu__link-text">User</span></a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
