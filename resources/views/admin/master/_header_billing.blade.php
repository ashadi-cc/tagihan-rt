<ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Tagihan</li>
    </ol>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $billing_list }}" href="{{ url('/admin/master/tagihan') }}">Daftar Tagihan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $billing_upload }}"  href="{{ url('/admin/master/tagihan/upload') }}">Upload</a>
        </li>
    </ul>