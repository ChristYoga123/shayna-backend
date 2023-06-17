<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ Route::is("admin.dashboard.index") ? "active" : "" }}">
                    <a href="index.html"><i class
                        ="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="menu-title">Barang</li><!-- /.menu-title -->
                <li class="{{ Route::is("admin.barang.index") ? "active" : "" }}">
                    <a href="{{ route("admin.barang.index") }}"> <i class="menu-icon fa fa-list"></i>Lihat Barang</a>
                </li>
                <li class="{{ Route::is("admin.barang.create") ? "active" : "" }}">
                    <a href="{{ route("admin.barang.create") }}"> <i class="menu-icon fa fa-plus"></i>Tambah Barang</a>
                </li>

                <li class="menu-title">Foto Barang</li><!-- /.menu-title -->
                <li class="{{ Route::is("admin.galeri.index") ? "active" : "" }}">
                    <a href="{{ route("admin.galeri.index") }}"> <i class="menu-icon fa fa-list"></i>Lihat Foto Barang</a>
                </li>
                <li class="{{ Route::is("admin.galeri.create") ? "active" : "" }}">
                    <a href="{{ route("admin.galeri.create") }}"> <i class="menu-icon fa fa-plus"></i>Tambah Foto Barang</a>
                </li>

                <li class="menu-title">Transaksi</li><!-- /.menu-title -->
                <li class="{{ Route::is("admin.transaksi.index") ? "active" : "" }}">
                    <a href="{{ route("admin.transaksi.index") }}"> <i class="menu-icon fa fa-list"></i>Lihat Transaksi</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>