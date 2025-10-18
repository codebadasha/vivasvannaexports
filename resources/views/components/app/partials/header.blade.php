<header class="site-header">
    <div class="top-header">
        <div class="container">
            <div class="left-header">
                <div class="hamburger-menu">
                    <span></span><span></span><span></span>
                </div>
                <a href="#" class="site-logo" title="JMARKT">
                    <img src="{{ asset('app/images/site-logo.svg') }}" alt="">
                </a>
            </div>
            <div class="right-header">
                <!-- Search starts -->
                <!-- add class "visible" to "search-wrapper" to make it appear -->
                <div class="search-wrapper">
                    <div class="search-input-wrapper">
                        <input type="text" class="form-control" placeholder="Search Products">
                        <em class="search-icon"><img src="{{ asset('app/images/search.svg') }}" alt=""></em>
                    </div>
                    <div class="search-outputs custom-scroll">
                        <h6>Trending search</h6>
                        <ul class="search-results">
                            <li><a href="#">Rings - Emerald ring</a></li>
                            <li><a href="#">Pendant - Silver pendant</a></li>
                            <li><a href="#">Earrings - Women's gold earrings</a></li>
                            <li><a href="#">Rings - Delicate rings</a></li>
                            <li><a href="#">Rings - Couple ring</a></li>
                            <li><a href="#">Rings - Emerald ring</a></li>
                        </ul>
                        <!-- when no search result found -->
                        <!-- <div class="no-search-results">
                            <em class="icon"><img src="{{ asset('app/images/no-search-results.svg') }}" alt=""></em>
                            <h4>Product Not Found</h4>
                            <p>It may be available soon, Try for another products.</p>
                        </div> -->
                    </div>
                </div>
                <!-- Search ends -->
                <!-- Langugage switcher starts -->
                <div class="lang-wrapper">
                    <em class="lang-trigger"><img src="{{ asset('app/images/lang.svg') }}" alt=""></em>
                    <div class="lang-dropdown">
                        <ul class="links">
                            <li>
                                <a href="{{ route('changeLanguage','en') }}" title="English">{{ __('common.english') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('changeLanguage','ar') }}" title="Arabic">{{ __('common.arabic') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Langugage switcher ends -->
                <!-- Notifications starts -->
                <div class="notification-wrapper">
                    <em class="notification-trigger"><img src="{{ asset('app/images/notification.svg') }}" alt=""></em>
                    <span class="unread-bubble"></span>
                    <div class="notification-dropdown">
                        <div class="notification-title">Notifications</div>
                        <!-- When no notifications available starts -->
                        <div class="notification-info no-data custom-scroll">
                            <div class="no-data-block">
                                <em class="no-data-icon">
                                    <img src="{{ asset('app/images/no-data.svg') }}" alt="">
                                </em>
                                <h4>No notification yet!</h4>
                            </div>
                        </div>
                        <!-- When no notifications available ends -->
                        <!-- <div class="notification-info custom-scroll">
                            <ul class="noti-list">
                                <li class="unread">
                                    <em class="icon"><img src="{{ asset('app/images/notification-orange.svg') }}" alt=""></em>
                                    <div class="noti-content">
                                        <p>Presenting our latest, Viva pride the undisputed icon of style </p>
                                        <span class="date">5:19 PM</span>
                                    </div>
                                </li>
                                <li class="unread">
                                    <em class="icon border-0" style="background-image: url('/app/images/noti01.jpg');"></em>
                                    <div class="noti-content">
                                        <p>A surprise that will ain your heart offers on exquisite presents!</p>
                                        <span class="date">1 hr ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti02.jpg');"></em>
                                    <div class="noti-content">
                                        <p>Extraordinariness that doesn’t fade to welcome the coming year. Extraordinariness that
                                            doesn’t fade to welcome the coming year</p>
                                        <span class="date">23 hr ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti03.jpg');"></em>
                                    <div class="noti-content">
                                        <p>Love is in the little things welcome valentine’s with lil sparkles!</p>
                                        <span class="date">1 day ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon"><img src="{{ asset('app/images/notification-orange.svg') }}" alt=""></em>
                                    <div class="noti-content">
                                        <p>Presenting our latest, Viva pride the undisputed icon of style</p>
                                        <span class="date">1 month ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti04.jpg');"></em>
                                    <div class="noti-content">
                                        <p>A surprise that will ain your heart offers on exquisite presents!</p>
                                        <span class="date">1 year ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon"><img src="{{ asset('app/images/notification-orange.svg') }}" alt=""></em>
                                    <div class="noti-content">
                                        <p>Presenting our latest, Viva pride the undisputed icon of style </p>
                                        <span class="date">5:19 PM</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti01.jpg');"></em>
                                    <div class="noti-content">
                                        <p>A surprise that will ain your heart offers on exquisite presents!</p>
                                        <span class="date">1 hr ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti02.jpg');"></em>
                                    <div class="noti-content">
                                        <p>Extraordinariness that doesn’t fade to welcome the coming year. Extraordinariness that
                                            doesn’t fade to welcome the coming year</p>
                                        <span class="date">23 hr ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti03.jpg');"></em>
                                    <div class="noti-content">
                                        <p>Love is in the little things welcome valentine’s with lil sparkles!</p>
                                        <span class="date">1 day ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon"><img src="{{ asset('app/images/notification-orange.svg') }}" alt=""></em>
                                    <div class="noti-content">
                                        <p>Presenting our latest, Viva pride the undisputed icon of style</p>
                                        <span class="date">1 month ago</span>
                                    </div>
                                </li>
                                <li>
                                    <em class="icon border-0" style="background-image: url('/app/images/noti04.jpg');"></em>
                                    <div class="noti-content">
                                        <p>A surprise that will ain your heart offers on exquisite presents!</p>
                                        <span class="date">1 year ago</span>
                                    </div>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <!-- Notifications ends -->
                <!-- Favourite starts -->
                <a href="{{ route('wishlist') }}" class="favourite">
                    <img src="{{ asset('app/images/favourite.svg') }}" alt="">
                </a>
                <!-- Favourite ends -->
                <!-- Cart starts -->
                <a href="{{ route('cart') }}" class="cart">
                    <img src="{{ asset('app/images/cart.svg') }}" alt="">
                    <span class="unread-bubble"></span>
                </a>
                <!-- Cart ends -->
                @auth
                    <div class="profile-wrapper">
                        <div class="profile-trigger">{{ Auth::user()->name }}</div>
                        <div class="profile-dropdown">
                            <div class="user-info">
                                <span class="name">{{ Auth::user()->name }}</span>
                                <span class="email">{{ Auth::user()->email }}</span>
                            </div>
                            <ul class="links">
                                <li>
                                    <a href="{{ route('myProfile') }}" title="My account">My account</a>
                                </li>
                                <li>
                                    <a href="#" title="Logout" data-bs-toggle="modal" data-bs-target="#logOutModal">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="orange-btn d-none d-lg-inline-block" title="Login">Login</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="bottom-header">
        <span class="mob-menu-close"></span>
        <div class="container">
            <div class="mob-block">
                <div class="user-info-wrapper">
                    <div class="dp">
                        <!-- <img src="{{ asset('app/images/no-user-thumb.svg') }}" alt=""> -->
                        <img src="{{ asset('app/images/user.png') }}" alt="">
                    </div>
                    <div class="user-info">
                        <!-- <h6>Guest User</h6>
                        <a href="login.html">Login</a> -->
                        <h6>Aashif Amir</h6>
                        <a href="{{ route('myProfile') }}">Edit profile</a>
                    </div>
                </div>
            </div>
            <ul class="site-menu">
                <li class="has-submenu">
                    <span class="arrow"></span>
                    <a href="category.html" title="Shop By Categories">Shop By Categories</a>
                    <div class="submenu-wrapper">
                        <div class="submenu-row">
                        @if(!is_null($headerCategory))
                            @foreach($headerCategory as $hk => $hv)
                                @if($hk%2 == 0 || $hk == 0)
                                    <div class="submenu-col">
                                @endif
                                    <div class="category-outer">
                                        <h6 class="category-title">{{ $hv->cat_name }}
                                            <span class="arrow"></span>
                                        </h6>
                                        <div class="category-list">
                                        @if(!is_null($hv->subcategory))
                                            <ul>
                                                @foreach($hv->subcategory as $sk => $sv)
                                                    <li><a href="{{ route('subcategory',$sv->cat_slug) }}" title="{{ $sv->cat_name }}">{{ $sv->cat_name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        </div>
                                    </div>
                                @if($hk%2 != 0 || $hk == 1)
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        </div>
                        <div class="see-all-row">
                            <a href="{{ route('category') }}" class="see-all" title="See All">See All</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('category') }}" title="Jewellery">Jewellery</a>
                </li>
                <li>
                    <a href="{{ route('category') }}" title="Gemstones">Gemstones</a>
                </li>
                <li>
                    <a href="{{ route('category') }}" title="Alloys">Alloys</a>
                </li>
                <li>
                    <a href="{{ route('category') }}" title="Shop By Brands">Shop By Brands</a>
                </li>
            </ul>
            <div class="mob-block account-mob-menu">
                <div class="account-title">My account</div>
                <ul class="account-menu site-menu">
                    <li>
                        <a href="{{ route('wishlist') }}" title="Wishlist">
                            <em class="icon"><img src="{{ asset('app/images/favourite.svg') }}" alt=""></em>Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('addressList') }}" title="My Addresses">
                            <em class="icon"><img src="{{ asset('app/images/location-pin.svg') }}" alt=""></em>My Addresses
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orderList') }}" title="My Orders">
                            <em class="icon"><img src="{{ asset('app/images/my-orders.svg') }}" alt=""></em>My Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kyc') }}" title="KYC">
                            <em class="icon"><img src="{{ asset('app/images/kyc.svg') }}" alt=""></em>KYC
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('merchantList') }}" title="Merchants">
                            <em class="icon"><img src="{{ asset('app/images/merchants.svg') }}" alt=""></em>Merchants
                        </a>
                    </li>
                    <li class="has-submenu">
                        <span class="arrow"></span>
                        <a href="#" title="Help Center">
                            <em class="icon"><img src="{{ asset('app/images/help.svg') }}" alt=""></em>Help Center
                        </a>
                        <div class="submenu-wrapper">
                            <div class="submenu-row">
                                <div class="submenu-col">
                                    <div class="category-outer">
                                        <div class="category-list d-block">
                                            <ul>
                                                <li><a href="#" title="FAQ's">FAQ's</a></li>
                                                <li><a href="#" title="Privacy Policy">Privacy Policy</a></li>
                                                <li><a href="#" title="Terms & Condition">Terms & Condition</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="has-submenu">
                        <span class="arrow"></span>
                        <a href="#" title="Language Preference">
                            <em class="icon"><img src="{{ asset('app/images/lang.svg') }}" alt=""></em>Language Preference
                        </a>
                        <div class="submenu-wrapper">
                            <div class="submenu-row">
                                <div class="submenu-col">
                                    <div class="category-outer">
                                        <div class="category-list d-block">
                                            <ul>
                                                <li><a href="#" title="English">English</a></li>
                                                <li><a href="#" title="Arabic">Arabic</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#" title="Log Out" data-bs-toggle="modal" data-bs-target="#logOutModal">
                            <em class="icon"><img src="{{ asset('app/images/logout.svg') }}" alt=""></em>Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>