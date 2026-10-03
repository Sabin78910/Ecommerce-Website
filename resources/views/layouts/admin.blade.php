<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="surfside media" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    </head>

    <body class="body">
        <div id="wrapper">
            <div id="page" class="">
                <div class="layout-wrap">
                    <div class="section-menu-left">
                        <div class="box-logo" style="margin-bottom:150px;">
                            <a href="{{ route('admin.index') }}" id="site-logo-inner">
                                <img class="" id="logo_header_1" alt=""
                                    src="{{ asset('images/logo/logo.png') }}"
                                    data-light="{{ asset('images/logo/logo.png') }}"
                                    data-dark="{{ asset('images/logo/logo.png') }}">
                            </a>
                            <div class="button-show-hide">
                                <i class="icon-menu-left"></i>
                            </div>
                        </div>
                        <div class="center">
                            <div class="center-item">
                                <div class="center-heading" style="margin-top:80px;">Main Home</div>
                                <ul class="menu-list">
                                    <li class="menu-item">
                                        <a href="{{ route('admin.index') }}" class="">
                                            <div class="icon"><i class="icon-grid"></i></div>
                                            <div class="text">Dashboard</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="center-item">
                                <ul class="menu-list">
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-shopping-cart"></i></div>
                                            <div class="text">Products</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.products_create') }}" class="">
                                                    <div class="text">Add Product</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.products') }}" class="">
                                                    <div class="text">Products</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-layers"></i></div>
                                            <div class="text">Brand</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.brand.add') }}" class="">
                                                    <div class="text">New Brand</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.brands') }}" class="">
                                                    <div class="text">Brands</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-layers"></i></div>
                                            <div class="text">Category</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.category.create') }}" class="">
                                                    <div class="text">New Category</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.category') }}" class="">
                                                    <div class="text">Categories</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-file-plus"></i></div>
                                            <div class="text">Order</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.orders') }}" class="">
                                                    <div class="text">Orders</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.coupons') }}" class="">
                                            <div class="icon"><i class="icon-grid"></i></div>
                                            <div class="text">Coupons</div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('admin.users') }}" class="">
                                            <div class="icon"><i class="icon-user"></i></div>
                                            <div class="text">User</div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('admin.payment-verifications.index') }}">
                                            <div class="icon"><i class="icon-credit-card"></i></div>
                                            <div class="text">
                                                Payment Verifications
                                                @php
                                                    use App\Models\PaymentVerification;

                                                    $pending = PaymentVerification::whereHas('order', function (
                                                        $query,
                                                    ) {
                                                        $query->where('status', 'payment completed');
                                                    })->count();
                                                @endphp
                                                @if ($pending)
                                                    <span class="badge bg-danger">{{ $pending }}</span>
                                                @endif
                                            </div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('contact-queries.index') }}">
                                            <div class="icon"><i class="far fa-envelope"></i></div>
                                            <div class="text">
                                                Queries
                                                @php
                                                    $unread = \App\Models\ContactQuery::where(
                                                        'status',
                                                        'unread',
                                                    )->count();
                                                @endphp
                                                @if ($unread)
                                                    <span class="badge bg-danger">{{ $unread }}</span>
                                                @endif
                                            </div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a href="{{ route('admin.settings') }}" class="">
                                            <div class="icon"><i class="icon-settings"></i></div>
                                            <div class="text">Settings</div>
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <form method="post" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <a href="{{ route('logout') }}" class=""
                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <div class="icon"> <i class="fas fa-sign-out-alt"></i></div>
                                                <div class="text">Logout</div>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-content-right">

                        <div class="header-dashboard">
                            <div class="wrap">
                                <div class="header-left">
                                    <a href="index-2.html">
                                        <img class="" id="logo_header_mobile" alt=""
                                            src="images/logo/logo.png" data-light="images/logo/logo.png"
                                            data-dark="images/logo/logo.png" data-width="154px" data-height="52px"
                                            data-retina="images/logo/logo.png">
                                    </a>
                                    <div class="button-show-hide">
                                        <i class="icon-menu-left"></i>
                                    </div>

                                    <form onsubmit="return false;"
                                        style="
    position: relative;
    display: flex;
    align-items: stretch;
    flex-grow: 1;
    margin: 0;
  ">
                                        <fieldset
                                            style="
      flex: 1;
      margin: 0;
      padding: 0;
      border: none;
    ">
                                            <input type="text" id="page-search-input" placeholder="Jump to page…"
                                                autocomplete="off"
                                                style="
        width: 100%;
        padding: 0.5rem 3rem 0.5rem 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 1rem;
      ">
                                        </fieldset>

                                        <button type="button" id="page-search-btn"
                                            style="
      position: absolute;
      top: 0;
      right: 0;
      width: 3rem;
      height: 100%;
      border: none;
      background: transparent;
      cursor: pointer;
    ">
                                            <i class="icon-search"></i>
                                        </button>

                                        <ul id="page-suggestions"
                                            style="
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      margin: 0;
      padding: 0;
      list-style: none;
      border: 1px solid #ccc;
      border-top: none;
      background: #fff;
      max-height: 400px;
      overflow-y: auto;
      display: none;
      box-sizing: border-box;
      z-index: 1000;
    ">
                                        </ul>
                                    </form>

                                </div>
                                <div class="header-grid">
                                    <div class="popup-wrap user type-header">
                                        <div class="dropdown">
                                            <span class="header-user wg-user">
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">{{ auth()->user()->name }}</span>
                                                </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="main-content">
                            @yield('website-content')
                        </div>

                        <div class="bottom-page"
                            style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: grey; color: white; text-align: center; padding: 10px 0; z-index: 1000;">
                            <div class="body-text" style="margin: 0; font-size: 14px; color: white;">Copyright © 2025
                                OnlineNepal</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <script src=" {{ asset('js/jquery.min.js') }}"></script>
        <script src=" {{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script>
            (function($) {

                var tfLineChart = (function() {

                    var chartBar = function() {

                        var options = {
                            series: [{
                                    name: 'Total',
                                    data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00,
                                        0.00, 0.00, 0.00
                                    ]
                                }, {
                                    name: 'Pending',
                                    data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00,
                                        0.00, 0.00, 0.00
                                    ]
                                },
                                {
                                    name: 'Delivered',
                                    data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00,
                                        0.00, 0.00
                                    ]
                                }, {
                                    name: 'Canceled',
                                    data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00,
                                        0.00, 0.00
                                    ]
                                }
                            ],
                            chart: {
                                type: 'bar',
                                height: 325,
                                toolbar: {
                                    show: false,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '10px',
                                    endingShape: 'rounded'
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                show: false,
                            },
                            colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                            stroke: {
                                show: false,
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        colors: '#212529',
                                    },
                                },
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                    'Oct', 'Nov', 'Dec'
                                ],
                            },
                            yaxis: {
                                show: false,
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return "$ " + val + ""
                                    }
                                }
                            }
                        };

                        chart = new ApexCharts(
                            document.querySelector("#line-chart-8"),
                            options
                        );
                        if ($("#line-chart-8").length > 0) {
                            chart.render();
                        }
                    };

                    /* Function ============ */
                    return {
                        init: function() {},

                        load: function() {
                            chartBar();
                        },
                        resize: function() {},
                    };
                })();

                jQuery(document).ready(function() {});

                jQuery(window).on("load", function() {
                    tfLineChart.load();
                });

                jQuery(window).on("resize", function() {});
            })(jQuery);
            $(function() {
                $("#search-input").on("keyup", function() {
                    var searchQuery = $(this).val();
                    if (searchQuery.length > 2) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.search') }}",
                            data: {
                                query: searchQuery
                            },
                            dataType: 'json',
                            success: function(data) {
                                $("#box-content-search").html(''); // Clear previous results
                                $.each(data, function(index, item) {
                                    var url =
                                        "{{ route('admin.products.modify', ['id' => 'product_id']) }}";
                                    var link = url.replace('product_id', item.id);

                                    // Append each product result to the box content
                                    $("#box-content-search").append(`
                                    <li style="list-style: none; margin-bottom: 10px;">
                                        <div onclick="window.location.href='${link}'" 
                                            style="display: flex; align-items: center; justify-content: space-between; 
                                                    border: 1px solid #ddd; border-radius: 5px; padding: 10px; 
                                                    background-color: #f9f9f9; cursor: pointer; transition: background-color 0.3s;">
                                            
                                            <div style="flex-shrink: 0; margin-right: 10px;">
                                                <img src="{{ asset('uploads/products') }}/${item.image}" alt="${item.name}" 
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                            </div>
                                            
                                            <div style="flex-grow: 1;">
                                                <span style="font-size: 14px; color: #333;">${item.name}</span>
                                            </div>
                                        </div>
                                    </li>
                                `);
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching search results:", error);
                            }
                        });
                    }
                });
            });
        </script>
        @stack('website-script')
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('page-search-input');
            const suggestions = document.getElementById('page-suggestions');
            const btn = document.getElementById('page-search-btn');

            // Figure out which endpoint to call
            const isAdmin = window.location.pathname.startsWith('/admin');
            const searchUrl = isAdmin ?
                '{{ route('admin.page.search') }}' :
                '{{ route('user.page.search') }}';

            let items = [],
                currentIndex = -1;

            // Render the dropdown list
            function render(list) {
                suggestions.innerHTML = '';
                if (list.length === 0) {
                    suggestions.style.display = 'none';
                    return;
                }
                list.forEach((page, i) => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action';
                    if (i === currentIndex) li.classList.add('active');
                    li.textContent = page.name;
                    li.dataset.url = page.url;
                    li.addEventListener('click', () => window.location.href = page.url);
                    suggestions.appendChild(li);
                });
                suggestions.style.display = 'block';
            }

            // Fetch matches from server
            function lookup(q) {
                fetch(`${searchUrl}?query=` + encodeURIComponent(q))
                    .then(res => res.json())
                    .then(data => {
                        items = data;
                        currentIndex = -1;
                        render(items);
                    })
                    .catch(console.error);
            }

            // Input listener
            input.addEventListener('input', e => {
                const q = e.target.value.trim();
                if (q.length >= 2) lookup(q);
                else suggestions.style.display = 'none';
            });

            // Keyboard navigation
            input.addEventListener('keydown', e => {
                if (!items.length) return;
                switch (e.key) {
                    case 'ArrowDown':
                        currentIndex = (currentIndex + 1) % items.length;
                        render(items);
                        e.preventDefault();
                        break;
                    case 'ArrowUp':
                        currentIndex = (currentIndex - 1 + items.length) % items.length;
                        render(items);
                        e.preventDefault();
                        break;
                    case 'Enter':
                        e.preventDefault();
                        if (currentIndex >= 0) window.location.href = items[currentIndex].url;
                        break;
                    case 'Escape':
                        suggestions.style.display = 'none';
                        break;
                }
            });

            // Click the search icon → go to first suggestion
            btn.addEventListener('click', () => {
                if (items[0]) window.location.href = items[0].url;
            });

            // Click outside → close
            document.addEventListener('click', e => {
                if (!input.contains(e.target) && !suggestions.contains(e.target))
                    suggestions.style.display = 'none';
            });
        });
    </script>

</html>
