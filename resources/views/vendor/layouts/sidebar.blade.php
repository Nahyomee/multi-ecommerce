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
        <li class="{{ setActive(['vendor.dashboard']) }}">
          <a href="{{route('vendor.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ setActive(['vendor.shop-profile.*']) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Ecommerce</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['vendor.shop-profile.*']) }}"><a class="nav-link" href="{{route('vendor.shop-profile.index')}}">Shop Profile</a></li>
          </ul>
        </li>
        <li class="dropdown {{ setActive(['vendor.products.*']) }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i> <span>Manage Product</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['vendor.products.*']) }}"><a class="nav-link" href="{{route('vendor.products.index')}}">Products</a></li>
          </ul>
        </li>
        <li class="dropdown {{ setActive([
          'admin.orders.*', 
          ]) }}">
          <a href="#" class="nav-link has-dropdown"><i class="far fa-clipboard"></i> <span>Orders</span></a>
          <ul class="dropdown-menu">
            <li class="{{ setActive(['vendor.orders.index']) }}"><a class="nav-link" href="{{route('vendor.orders.index')}}">Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' =>'pending'])}}">Pending Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'processed_and_ready_to_ship'])}}">Processed Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'dropped_off'])}}">Dropped Off Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'shipped'])}}">Shipped Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'out_for_delivery'])}}">Out for Delivery Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'cancelled'])}}">Cancelled Orders</a></li>
            <li class="{{ setActive(['vendor.orders.status']) }}"><a class="nav-link" href="{{route('vendor.orders.status', ['status' => 'delivered'])}}">Delivered Orders</a></li>
          </ul>
        </li> 
        
        <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
        
      </ul>      </aside>
  </div>