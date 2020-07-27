    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Warga</li>
    </ol>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $warga_list }}" href="{{ url('/admin/master/warga') }}">Daftar Warga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $warga_upload }}"  href="{{ url('/admin/master/warga/upload') }}">Upload</a>
        </li>
    </ul>