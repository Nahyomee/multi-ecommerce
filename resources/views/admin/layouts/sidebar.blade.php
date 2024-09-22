<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('index')}}">{{$settings->site_name}}</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{route('index')}}">{{getInitials($settings->site_name)}}</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ setActive(['admin.dashboard']) }}">
          <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        <li class="menu-header">Manage Site</li>
        <li class="dropdown {{ setActive([
          'admin.categories.*', 
          'admin.subcategories.*', 
          'admin.child-categories.*'
          ]) }}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-layer-group"></i> <span>Manage Categories</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.categories.*']) }}"><a class="nav-link" href="{{route('admin.categories.index')}}">Categories</a></li>
            <li class="{{ setActive(['admin.subcategories.*']) }}"><a class="nav-link" href="{{route('admin.subcategories.index')}}">Sub Categories</a></li>
            <li class="{{ setActive(['admin.child-categories.*']) }}"><a class="nav-link" href="{{route('admin.child-categories.index')}}">Child Categories</a></li>
          </ul>
        </li> 
        <li class="dropdown {{ setActive(['admin.vendor-profile.*'], ['admin.flash-sales.*'], 
        ['admin.coupons.*'],  ['admin.shipping-rules.*']) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Ecommerce</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.vendor-profile.*']) }}"><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
            <li class="{{ setActive(['admin.flash-sales.*']) }}"><a class="nav-link" href="{{route('admin.flash-sales.index')}}">Flash Sales</a></li>
            <li class="{{ setActive(['admin.coupons.*']) }}"><a class="nav-link" href="{{route('admin.coupons.index')}}">Coupons</a></li>
            <li class="{{ setActive(['admin.shipping-rules.*']) }}"><a class="nav-link" href="{{route('admin.shipping-rules.index')}}">Shipping Rules</a></li>
          </ul>
        </li>
        <li class="dropdown {{ setActive(['admin.brands.*'], ['admin.products.*']) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Manage Product</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.brands.*']) }}"><a class="nav-link" href="{{route('admin.brands.index')}}">Brands</a></li>
            <li class="{{ setActive(['admin.products.*']) }}"><a class="nav-link" href="{{route('admin.products.index')}}">Products</a></li>
            <li class="{{ setActive(['admin.vendors.products.*']) }}"><a class="nav-link" href="{{route('admin.vendors.products')}}">Vendor Products</a></li>
            <li class="{{ setActive(['admin.vendors.products.*']) }}"><a class="nav-link" href="{{route('admin.vendors.products.pending')}}">Pending Vendor Products</a></li>
          </ul>
        </li>
        <li class="dropdown {{ setActive([
          'admin.orders.*', 
          ]) }}">
          <a href="#" class="nav-link has-dropdown"><i class="far fa-clipboard"></i> <span>Orders</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.orders.index']) }}"><a class="nav-link" href="{{route('admin.orders.index')}}">Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' =>'pending'])}}">Pending Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'processed_and_ready_to_ship'])}}">Processed Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'dropped_off'])}}">Dropped Off Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'shipped'])}}">Shipped Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'out_for_delivery'])}}">Out for Delivery Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'cancelled'])}}">Cancelled Orders</a></li>
            <li class="{{ setActive(['admin.orders.status']) }}"><a class="nav-link" href="{{route('admin.orders.status', ['status' => 'delivered'])}}">Delivered Orders</a></li>
          </ul>
        </li> 
        <li class="{{ setActive(['admin.transactions.*']) }}">
          <a href="{{route('admin.transactions.index')}}" class="nav-link"><i class="fas fa-clipboard"></i><span>Transactions</span></a>
        </li>
        <li class="dropdown {{ setActive(['admin.sliders.*'], ['admin.settings.*'], ['admin.payment-settings.*']) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Manage Site</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['admin.sliders.*']) }}"><a class="nav-link" href="{{route('admin.sliders.index')}}">Sliders</a></li>
            <li class="{{ setActive(['admin.settings.*']) }}"><a class="nav-link" href="{{route('admin.settings.index')}}">Settings</a></li>
            <li class="{{ setActive(['admin.payment-settings.*']) }}"><a class="nav-link" href="{{route('admin.payment-settings.index')}}">Payment Settings</a></li>
          </ul>
        </li>
        
        <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
        
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-bicycle"></i> <span>Features</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="features-activities.html">Activities</a></li>
            <li><a class="nav-link" href="features-post-create.html">Post Create</a></li>
            <li><a class="nav-link" href="features-posts.html">Posts</a></li>
            <li><a class="nav-link" href="features-profile.html">Profile</a></li>
            <li><a class="nav-link" href="features-settings.html">Settings</a></li>
            <li><a class="nav-link" href="features-setting-detail.html">Setting Detail</a></li>
            <li><a class="nav-link" href="features-tickets.html">Tickets</a></li>
          </ul>
        </li> 
      </ul>      </aside>
  </div>