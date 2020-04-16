<div class="nav">
    <div class="sb-sidenav-menu-heading">Pribadi</div>
    <a class="nav-link" href="{{ url('/') }}"
        ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Tagihan Anda</a
    >
    @role('admin')
    <div class="sb-sidenav-menu-heading">Admin</div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
        ><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
        Master
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    ></a>
    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="{{ url('/admin/master/warga') }}">Daftar Warga</a><a class="nav-link" href="{{ url('/admin/master/tagihan') }}">Daftar Tagihan</a></nav>
    </div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
        ><div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
        Tagihan Warga
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    ></a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="{{ url('/admin/tagihan/bulanan') }}">Tagihan Bulanan</a><a class="nav-link" href="/admin/tagihan/upload">Upload Tagihan</a></nav>
    </div>
    @endrole
</div>