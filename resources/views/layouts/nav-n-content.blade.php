<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>La Jolla Admin Panel</h3>
            <strong>LJ</strong>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="/homepage-config">
                    <i class="glyphicon glyphicon-home"></i>
                    首頁
                </a>
            </li>
    

            <li>
                <a href="#product-submenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-gift"></i>
                    商品
                </a>
                <ul class="collapse list-unstyled" id="product-submenu">
                    <li><a href="/products">商品列表</a></li>
                    <li><a href="/products/categories">商品類別</a></li>
                    <li><a href="/products/series">商品系列</a></li>
                    <li><a href="/products/styles">款式系列</a></li>
                </ul>
            </li>
            
            <li>
                <a href="#newsSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-volume-up"></i>
                    最新消息
                </a>
                <ul class="collapse list-unstyled" id="newsSubmenu">
                    <li><a href="/news">中文新聞</a></li>
                    <li><a href="/news-en">English News</a></li>
                </ul>
            </li>

            <li>
                <a href="#warrantySubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-ok"></i>
                    保固註冊
                </a>
                <ul class="collapse list-unstyled" id="warrantySubmenu">
                    <li><a href="/warranties">未處理</a></li>
                    <li><a href="/warranties-done">已完成</a></li>
                </ul>
            </li>

            <li>
                <a href="#contactSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-send"></i>
                    聯絡我們
                </a>
                <ul class="collapse list-unstyled" id="contactSubmenu">
                    <li><a href="/contacts">未處理</a></li>
                    <li><a href="/contacts-done">已完成</a></li>
                </ul>
            </li>

        </ul>

        {{-- <ul class="list-unstyled CTAs">
            <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
            <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
        </ul> --}}
    </nav>

    <!-- Page Content Holder -->
    <div id="content">

        <nav class="navbar navbar-default topbar-section">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn inline">
                        <i class="glyphicon glyphicon-align-left"></i>
                        {{-- <span>Toggle Sidebar</span> --}}
                    </button>
                    
                    <ol class="breadcrumb inline">
                        @yield('breadcrumb')
                    </ol>

                </div>

                

                {{-- <div class="collapse navbar-collapse" id="navbar-collapse-2"> --}}
                    <ul class="nav navbar-nav navbar-right">
                        {{-- <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li> --}}
                        @yield('topbar-right')
                    </ul>
                {{-- </div> --}}
            </div>
        </nav>
        
        <div class="container-fluid content-section" id="app">
            @yield('content')
        </div>
    </div>
</div>