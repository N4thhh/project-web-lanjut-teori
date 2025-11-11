<!-- resources/views/includes/sidebar.blade.php -->
<div class="sidebar" style="width:220px; background:#1e293b; height:100vh; float:left; border-right:1px solid #222; box-shadow:2px 0 8px #0002;">
  <div style="display:flex; align-items:center; gap:8px; padding:28px 24px 16px 24px;">
    <svg width="30" height="30" fill="#36bffa" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10" fill="#eaf6ff"/>
      <path d="M8 16h8M8 12h8M8 8h8" stroke="#36bffa" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <span style="font-size:21px; font-weight:700; color:#36bffa; letter-spacing:1px;">LaundryKu</span>
  </div>
  <ul style="list-style:none; padding:0; margin:0;">

    {{-- DASHBOARD (active hanya di /admin/dashboard) --}}
    <li
      style="margin:8px 16px; display:flex; align-items:center; gap:12px;
             padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;
             @if(Route::is('admin.dashboard'))
                background:#36bffa11; color:#36bffa; font-weight:600;
             @else
                color:#fff;
             @endif">
      <a href="{{ route('admin.dashboard') }}"
         style="color:inherit; text-decoration:none; display:flex; align-items:center; gap:12px; width:100%;">
        <svg width="20" height="20" fill="none" stroke="{{ Route::is('admin.dashboard') ? '#36bffa' : '#fff' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v3m0 0l-2 2"></path>
        </svg>
        <span>Dashboard</span>
      </a>
    </li>

    {{-- PESANAN --}}
    <li
      style="margin:8px 16px; padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;
             @if(Route::is('admin.orders.*'))
                background:#36bffa11; color:#36bffa; font-weight:600;
             @else
                color:#fff;
             @endif">
      <a href="{{ route('admin.orders.index') }}"
         style="color:inherit; text-decoration:none; display:flex; align-items:center; gap:12px; width:100%;">
        <svg width="20" height="20" fill="none" stroke="{{ Route::is('admin.orders.*') ? '#36bffa' : '#fff' }}" stroke-width="2">
          <rect x="3" y="7" width="14" height="10" rx="2"/>
          <path d="M16 3v4M8 3v4" />
        </svg>
        <span>Pesanan</span>
      </a>
    </li>

    {{-- PELANGGAN (Link aktif dan highlight) --}}
    <li
      style="margin:8px 16px; padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;
             @if(Route::is('admin.pelanggan'))
                background:#36bffa11; color:#36bffa; font-weight:600;
             @else
                color:#fff;
             @endif">
      <a href="{{ route('admin.pelanggan') }}"
         style="color:inherit; text-decoration:none; display:flex; align-items:center; gap:12px; width:100%;">
        <svg width="20" height="20" fill="none" stroke="{{ Route::is('admin.pelanggan') ? '#36bffa' : '#fff' }}" stroke-width="2">
          <circle cx="10" cy="8" r="4"/>
          <path d="M2 21v-2a4 4 0 014-4h8a4 4 0 014 4v2"></path>
        </svg>
        <span>Pelanggan</span>
      </a>
    </li>

    {{-- Layanan --}}
    <li style="color:#fff; margin:8px 16px; display:flex; align-items:center; gap:12px; padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;">
      <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2">
        <path d="M20 6H4v12h16z"/>
        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
      </svg>
      Layanan
    </li>
    <li style="color:#fff; margin:8px 16px; display:flex; align-items:center; gap:12px; padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;">
      <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2">
        <path d="M3 11h18M9 7V4a1 1 0 012-1h2a1 1 0 012 1v3"/>
      </svg>
      Laporan
    </li>
    <li style="color:#fff; margin:8px 16px; display:flex; align-items:center; gap:12px; padding:14px 20px; border-radius:10px; cursor:pointer; transition:.2s;">
      <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.65 1.65 0 010 3 1.65 1.65 0 01-3-1.3 6 6 0 10-8.8 0A1.65 1.65 0 014.6 18a1.65 1.65 0 010-3"></path>
      </svg>
      Pengaturan
    </li>
  </ul>
</div>
