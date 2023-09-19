 <!-- Main Sidebar Container -->
 <aside style="background-color: #34333A" class="main-sidebar  elevation-4">

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 @php
                     $userRole = Auth::check() ? Auth::user()->role->name : null;
                 @endphp
                 @if ($userRole === 'superadmin')
                     <img src="{{ asset('images/logo-superadmin.png') }}" class="img-circle elevation-2" alt="User Image">
                 @elseif ($userRole === 'admin')
                     <img src="{{ asset('images/logo-admin.png') }}" class="img-circle elevation-2" alt="User Image">
                 @elseif ($userRole === 'therapist')
                     <img src="{{ asset('images/logo-therapist.png') }}" class="img-circle elevation-2"
                         alt="User Image">
                 @endif
             </div>
             <div class="info ml-1">
                 @php
                     if (Auth::check()) {
                         $userName = Auth::user()->name;
                         $maxNameLength = 15; // Tentukan panjang maksimum nama yang ingin ditampilkan
                         $truncatedName = strlen($userName) > $maxNameLength ? substr($userName, 0, $maxNameLength - 3) . '...' : $userName;
                     
                         // Mendapatkan role (peran) pengguna
                         $userRole = Auth::user()->role->name;
                     } else {
                         $userName = 'User is not logged in';
                         $userRole = null;
                     }
                 @endphp
                 <span style="font-size: 18px; color: white;" title="{{ $userName }}">{{ $truncatedName }}</span>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline" id="searchbar-di-sidebar">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i id="search-hover" style="color: white" class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>


         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul id="listmenu" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">

                 <li class="nav-item">
                     <a href="{{ route('home') }}" class="nav-link">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 @php
                     $userRole = Auth::check() ? Auth::user()->role->name : null;
                 @endphp
                 @if ($userRole === 'superadmin' || $userRole === 'admin')
                     <li class="nav-item">
                         <a href="{{ route('rooms.index') }}" class="nav-link">
                             <i class="nav-icon fas fa-door-open"></i>
                             <p>
                                 Rooms
                             </p>
                         </a>
                     </li>
                 @else
                     <li class="nav-item">
                         <a href="{{ route('myrooms.index') }}" class="nav-link">
                             <i class="nav-icon fas fa-door-open"></i>
                             <p>
                                 My Room
                             </p>
                         </a>
                     </li>
                 @endif

                 <li class="nav-item">
                     <a href="{{ route('storages.index') }}" class="nav-link">
                         <i class="nav-icon fas fa-box"></i>
                         <p>
                             Storages
                         </p>
                     </a>
                     {{-- <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('storage_types.index') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Storage Types</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('storages.index') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Storages</p>
                             </a>
                         </li>
                     </ul> --}}
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-pencil-ruler"></i>
                         <p>
                             Item
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('item_categories.index') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Item Categories</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('items.index') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Items</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('item_locations.index') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Item Location</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-hand-holding-medical"></i>
                         <p>
                             Therapist
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('coming_soon') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Therapist Data</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('coming_soon') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Therapy Sessions</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-child"></i>
                         <p>
                             Client
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ route('coming_soon') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Client Types</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('coming_soon') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Client Data</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 @if ($userRole === 'superadmin')
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon fas fa-user"></i>
                             <p>
                                 User
                                 <i class="right fas fa-angle-left"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('users.index') }}" class="nav-link">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>User Data</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @endif
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
