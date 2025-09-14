@extends('layouts.admin')

@section('title', 'home')


@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Vazir', sans-serif;
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .modal {
            display: none;
        }

        .modal.show {
            display: flex;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-processing {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .status-shipped {
            background-color: #d1fae5;
            color: #059669;
        }

        .status-delivered {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-returned {
            background-color: #f3e8ff;
            color: #7c3aed;
        }

        .table-row:hover {
            background-color: #f9fafb;
        }

        .print-hidden {
            display: none !important;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }
        }
    </style>
    </head>

    <body class="bg-gray-50">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div id="sidebar"
                class="sidebar-transition fixed inset-y-0 right-0 z-50 w-64 bg-white shadow-lg transform translate-x-full lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-between h-16 px-6 border-b">
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <i class="fas fa-shopping-bag text-2xl text-blue-600"></i>
                        <span class="text-xl font-bold text-gray-900">فروشگاه من</span>
                    </div>
                    <button id="closeSidebar" class="lg:hidden p-2 rounded-md hover:bg-gray-100">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>

                <nav class="mt-6 px-4">
                    <div class="space-y-2">
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-home"></i>
                            <span>داشبورد</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg bg-blue-50 text-blue-700">
                            <i class="fas fa-shopping-cart"></i>
                            <span>سفارشات</span>
                            <span class="mr-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">12</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-box"></i>
                            <span>محصولات</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-users"></i>
                            <span>مشتریان</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-chart-bar"></i>
                            <span>گزارشات</span>
                        </a>
                        <a href="#"
                            class="flex items-center space-x-3 space-x-reverse px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-cog"></i>
                            <span>تنظیمات</span>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white shadow-sm border-b no-print">
                    <div class="flex items-center justify-between h-16 px-6">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <button id="openSidebar" class="lg:hidden p-2 rounded-md hover:bg-gray-100">
                                <i class="fas fa-bars text-gray-600"></i>
                            </button>
                            <h1 class="text-2xl font-semibold text-gray-900">مدیریت سفارشات</h1>
                        </div>

                        <div class="flex items-center space-x-4 space-x-reverse">
                            <button id="exportBtn"
                                class="flex items-center space-x-2 space-x-reverse px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <i class="fas fa-download"></i>
                                <span>خروجی Excel</span>
                            </button>

                            <button id="printBtn"
                                class="flex items-center space-x-2 space-x-reverse px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                                <i class="fas fa-print"></i>
                                <span>چاپ</span>
                            </button>

                            <div class="relative">
                                <button id="profileDropdown"
                                    class="flex items-center space-x-2 space-x-reverse p-2 rounded-md hover:bg-gray-100">
                                    <img src="https://via.placeholder.com/32x32" alt="Profile"
                                        class="w-8 h-8 rounded-full">
                                    <span>مدیر سیستم</span>
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </button>
                                <div id="profileMenu"
                                    class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border">
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-sm text-gray-700 border-b">حساب کاربری</div>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">پروفایل</a>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">تنظیمات</a>
                                        <div class="border-t"></div>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">خروج</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Orders Content -->
                <main class="flex-1 overflow-y-auto p-6">
                    <!-- Filters and Search -->
                    <div class="bg-white rounded-lg shadow mb-6 no-print">
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <!-- Search -->
                                <div class="relative">
                                    <i
                                        class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input id="searchInput" type="text" placeholder="جستجو شماره سفارش، نام مشتری..."
                                        class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Status Filter -->
                                <select id="statusFilter"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="pending">در انتظار</option>
                                    <option value="processing">در حال پردازش</option>
                                    <option value="shipped">ارسال شده</option>
                                    <option value="delivered">تحویل داده شده</option>
                                    <option value="cancelled">لغو شده</option>
                                    <option value="returned">مرجوع شده</option>
                                </select>

                                <!-- Date From -->
                                <input id="dateFrom" type="date"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <!-- Date To -->
                                <input id="dateTo" type="date"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Bulk Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 space-x-reverse">
                                    <label class="flex items-center">
                                        <input id="selectAll" type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="mr-2 text-sm text-gray-700">انتخاب همه</span>
                                    </label>

                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        <button id="bulkStatusBtn"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
                                            disabled>
                                            تغییر وضعیت
                                        </button>
                                        <button id="bulkDeleteBtn"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-50"
                                            disabled>
                                            حذف انتخاب شده
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 space-x-reverse">
                                    <span id="totalOrders" class="text-sm text-gray-600">مجموع: ۱۲۳ سفارش</span>
                                    <select id="itemsPerPage" class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                                        <option value="10">۱۰ مورد</option>
                                        <option value="25" selected>۲۵ مورد</option>
                                        <option value="50">۵۰ مورد</option>
                                        <option value="100">۱۰۰ مورد</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase no-print">
                                            <input type="checkbox"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                            onclick="sortTable('order_id')">
                                            شماره سفارش
                                            <i class="fas fa-sort mr-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                            onclick="sortTable('customer')">
                                            مشتری
                                            <i class="fas fa-sort mr-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                            onclick="sortTable('date')">
                                            تاریخ سفارش
                                            <i class="fas fa-sort mr-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100"
                                            onclick="sortTable('amount')">
                                            مبلغ
                                            <i class="fas fa-sort mr-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">وضعیت
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">روش
                                            پرداخت</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase no-print">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody id="ordersTableBody" class="divide-y divide-gray-200">
                                    <!-- Orders will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 no-print">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <p class="text-sm text-gray-700">
                                        نمایش <span id="showingFrom">۱</span> تا <span id="showingTo">۲۵</span> از <span
                                            id="totalItems">۱۲۳</span> مورد
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <button id="prevPage"
                                        class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50"
                                        disabled>
                                        قبلی
                                    </button>
                                    <div id="pageNumbers" class="flex items-center space-x-1 space-x-reverse">
                                        <!-- Page numbers will be populated by JavaScript -->
                                    </div>
                                    <button id="nextPage"
                                        class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        بعدی
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Order Details Modal -->
        <div id="orderModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">جزئیات سفارش</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="orderDetails" class="p-6">
                    <!-- Order details will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Bulk Status Change Modal -->
        <div id="bulkStatusModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-lg font-semibold text-gray-900">تغییر وضعیت سفارشات</h2>
                    <button id="closeBulkModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">وضعیت جدید را برای <span id="selectedCount">0</span> سفارش
                        انتخاب شده انتخاب کنید:</p>

                    <select id="newStatus"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
                        <option value="pending">در انتظار</option>
                        <option value="processing">در حال پردازش</option>
                        <option value="shipped">ارسال شده</option>
                        <option value="delivered">تحویل داده شده</option>
                        <option value="cancelled">لغو شده</option>
                        <option value="returned">مرجوع شده</option>
                    </select>

                    <div class="flex items-center justify-end space-x-4 space-x-reverse">
                        <button id="cancelBulkStatus" class="px-4 py-2 text-gray-600 hover:text-gray-800">لغو</button>
                        <button id="confirmBulkStatus"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">تایید</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay for mobile sidebar -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <script>
            // Sample orders data
            let ordersData = [{
                    id: '1001',
                    customer: 'علی احمدی',
                    email: 'ali@example.com',
                    phone: '09123456789',
                    date: '2024-01-15',
                    amount: 350000,
                    status: 'delivered',
                    payment: 'کارت بانکی',
                    address: 'تهران، خیابان ولیعصر، پلاک ۱۲۳',
                    items: [{
                            name: 'تی شرت مردانه',
                            quantity: 2,
                            price: 150000
                        },
                        {
                            name: 'شلوار جین',
                            quantity: 1,
                            price: 200000
                        }
                    ]
                },
                {
                    id: '1002',
                    customer: 'فاطمه رضایی',
                    email: 'fateme@example.com',
                    phone: '09987654321',
                    date: '2024-01-14',
                    amount: 120000,
                    status: 'pending',
                    payment: 'پرداخت آنلاین',
                    address: 'اصفهان، خیابان چهارباغ، پلاک ۴۵۶',
                    items: [{
                        name: 'کیف دستی',
                        quantity: 1,
                        price: 120000
                    }]
                },
                {
                    id: '1003',
                    customer: 'محمد کریمی',
                    email: 'mohammad@example.com',
                    phone: '09111111111',
                    date: '2024-01-13',
                    amount: 580000,
                    status: 'processing',
                    payment: 'کارت بانکی',
                    address: 'شیراز، خیابان زند، پلاک ۷۸۹',
                    items: [{
                            name: 'کفش ورزشی',
                            quantity: 1,
                            price: 450000
                        },
                        {
                            name: 'جوراب ورزشی',
                            quantity: 2,
                            price: 65000
                        }
                    ]
                },
                {
                    id: '1004',
                    customer: 'زهرا محمدی',
                    email: 'zahra@example.com',
                    phone: '09222222222',
                    date: '2024-01-12',
                    amount: 280000,
                    status: 'shipped',
                    payment: 'پرداخت در محل',
                    address: 'مشهد، خیابان امام رضا، پلاک ۳۲۱',
                    items: [{
                        name: 'مانتو زنانه',
                        quantity: 1,
                        price: 280000
                    }]
                },
                {
                    id: '1005',
                    customer: 'حسن علوی',
                    email: 'hassan@example.com',
                    phone: '09333333333',
                    date: '2024-01-11',
                    amount: 95000,
                    status: 'cancelled',
                    payment: 'کارت بانکی',
                    address: 'تبریز، خیابان شهریار، پلاک ۶۵۴',
                    items: [{
                        name: 'کلاه',
                        quantity: 1,
                        price: 95000
                    }]
                }
            ];

            let filteredOrders = [...ordersData];
            let currentPage = 1;
            let itemsPerPage = 25;
            let selectedOrders = new Set();

            // Initialize page
            document.addEventListener('DOMContentLoaded', function() {
                renderOrders();
                setupEventListeners();
            });

            function setupEventListeners() {
                // Sidebar functionality
                const sidebar = document.getElementById('sidebar');
                const openSidebar = document.getElementById('openSidebar');
                const closeSidebar = document.getElementById('closeSidebar');
                const overlay = document.getElementById('overlay');

                openSidebar.addEventListener('click', () => {
                    sidebar.classList.remove('translate-x-full');
                    overlay.classList.remove('hidden');
                });

                closeSidebar.addEventListener('click', () => {
                    sidebar.classList.add('translate-x-full');
                    overlay.classList.add('hidden');
                });

                overlay.addEventListener('click', () => {
                    sidebar.classList.add('translate-x-full');
                    overlay.classList.add('hidden');
                });

                // Profile dropdown
                const profileDropdown = document.getElementById('profileDropdown');
                const profileMenu = document.getElementById('profileMenu');

                profileDropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                });

                document.addEventListener('click', () => {
                    profileMenu.classList.remove('show');
                });

                // Search and filters
                document.getElementById('searchInput').addEventListener('input', filterOrders);
                document.getElementById('statusFilter').addEventListener('change', filterOrders);
                document.getElementById('dateFrom').addEventListener('change', filterOrders);
                document.getElementById('dateTo').addEventListener('change', filterOrders);
                document.getElementById('itemsPerPage').addEventListener('change', changeItemsPerPage);

                // Select all checkbox
                document.getElementById('selectAll').addEventListener('change', toggleSelectAll);

                // Bulk actions
                document.getElementById('bulkStatusBtn').addEventListener('click', openBulkStatusModal);
                document.getElementById('bulkDeleteBtn').addEventListener('click', bulkDelete);

                // Modal events
                document.getElementById('closeModal').addEventListener('click', closeOrderModal);
                document.getElementById('closeBulkModal').addEventListener('click', closeBulkStatusModal);
                document.getElementById('cancelBulkStatus').addEventListener('click', closeBulkStatusModal);
                document.getElementById('confirmBulkStatus').addEventListener('click', confirmBulkStatusChange);

                // Export and print
                document.getElementById('exportBtn').addEventListener('click', exportToExcel);
                document.getElementById('printBtn').addEventListener('click', printOrders);

                // Pagination
                document.getElementById('prevPage').addEventListener('click', () => changePage(currentPage - 1));
                document.getElementById('nextPage').addEventListener('click', () => changePage(currentPage + 1));
            }

            function renderOrders() {
                const tbody = document.getElementById('ordersTableBody');
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const ordersToShow = filteredOrders.slice(startIndex, endIndex);

                tbody.innerHTML = '';

                ordersToShow.forEach(order => {
                    const row = document.createElement('tr');
                    row.className = 'table-row';
                    row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap no-print">
                        <input type="checkbox" class="order-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-order-id="${order.id}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#${order.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${order.customer}</div>
                        <div class="text-sm text-gray-500">${order.email}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(order.date)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatPrice(order.amount)} تومان</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium rounded-full status-${order.status}">
                            ${getStatusText(order.status)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.payment}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <button onclick="viewOrder('${order.id}')" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="editOrderStatus('${order.id}')" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteOrder('${order.id}')" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button onclick="printOrder('${order.id}')" class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </td>
                `;
                    tbody.appendChild(row);
                });

                // Add event listeners to checkboxes
                document.querySelectorAll('.order-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedOrders);
                });

                updatePagination();
                updateBulkActionButtons();
            }

            function filterOrders() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;
                const dateFrom = document.getElementById('dateFrom').value;
                const dateTo = document.getElementById('dateTo').value;

                filteredOrders = ordersData.filter(order => {
                    const matchesSearch = order.id.includes(searchTerm) ||
                        order.customer.toLowerCase().includes(searchTerm) ||
                        order.email.toLowerCase().includes(searchTerm);

                    const matchesStatus = !statusFilter || order.status === statusFilter;

                    const matchesDateFrom = !dateFrom || order.date >= dateFrom;
                    const matchesDateTo = !dateTo || order.date <= dateTo;

                    return matchesSearch && matchesStatus && matchesDateFrom && matchesDateTo;
                });

                currentPage = 1;
                selectedOrders.clear();
                document.getElementById('selectAll').checked = false;
                renderOrders();
            }

            function sortTable(column) {
                // Simple sorting implementation
                filteredOrders.sort((a, b) => {
                    let aVal, bVal;

                    switch (column) {
                        case 'order_id':
                            aVal = parseInt(a.id);
                            bVal = parseInt(b.id);
                            break;
                        case 'customer':
                            aVal = a.customer;
                            bVal = b.customer;
                            break;
                        case 'date':
                            aVal = new Date(a.date);
                            bVal = new Date(b.date);
                            break;
                        case 'amount':
                            aVal = a.amount;
                            bVal = b.amount;
                            break;
                        default:
                            return 0;
                    }

                    return aVal > bVal ? 1 : -1;
                });

                renderOrders();
            }

            function updateSelectedOrders() {
                selectedOrders.clear();
                document.querySelectorAll('.order-checkbox:checked').forEach(checkbox => {
                    selectedOrders.add(checkbox.dataset.orderId);
                });
                updateBulkActionButtons();
            }

            function toggleSelectAll() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.order-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });

                updateSelectedOrders();
            }

            function updateBulkActionButtons() {
                const bulkStatusBtn = document.getElementById('bulkStatusBtn');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                const hasSelected = selectedOrders.size > 0;

                bulkStatusBtn.disabled = !hasSelected;
                bulkDeleteBtn.disabled = !hasSelected;
            }

            function viewOrder(orderId) {
                const order = ordersData.find(o => o.id === orderId);
                if (!order) return;

                const modal = document.getElementById('orderModal');
                const details = document.getElementById('orderDetails');

                details.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">اطلاعات سفارش</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">شماره سفارش:</span>
                                <span class="font-medium">#${order.id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">تاریخ:</span>
                                <span>${formatDate(order.date)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">وضعیت:</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full status-${order.status}">
                                    ${getStatusText(order.status)}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">روش پرداخت:</span>
                                <span>${order.payment}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">مبلغ کل:</span>
                                <span class="font-bold text-lg">${formatPrice(order.amount)} تومان</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">اطلاعات مشتری</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">نام:</span>
                                <span>${order.customer}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ایمیل:</span>
                                <span>${order.email}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">تلفن:</span>
                                <span>${order.phone}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">آدرس:</span>
                                <p class="mt-1">${order.address}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">اقلام سفارش</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">محصول</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">تعداد</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">قیمت واحد</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">مجموع</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                ${order.items.map(item => `
                                            <tr>
                                                <td class="px-4 py-2">${item.name}</td>
                                                <td class="px-4 py-2">${item.quantity}</td>
                                                <td class="px-4 py-2">${formatPrice(item.price)} تومان</td>
                                                <td class="px-4 py-2">${formatPrice(item.price * item.quantity)} تومان</td>
                                            </tr>
                                        `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-4 space-x-reverse">
                    <button onclick="printOrder('${order.id}')" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        <i class="fas fa-print mr-2"></i>
                        چاپ سفارش
                    </button>
                    <button onclick="editOrderStatus('${order.id}')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        ویرایش وضعیت
                    </button>
                </div>
            `;

                modal.classList.add('show');
            }

            function closeOrderModal() {
                document.getElementById('orderModal').classList.remove('show');
            }

            function editOrderStatus(orderId) {
                const newStatus = prompt(
                    'وضعیت جدید را انتخاب کنید:\n1. در انتظار (pending)\n2. در حال پردازش (processing)\n3. ارسال شده (shipped)\n4. تحویل داده شده (delivered)\n5. لغو شده (cancelled)\n6. مرجوع شده (returned)'
                    );

                const statusMap = {
                    '1': 'pending',
                    '2': 'processing',
                    '3': 'shipped',
                    '4': 'delivered',
                    '5': 'cancelled',
                    '6': 'returned'
                };

                if (statusMap[newStatus]) {
                    const order = ordersData.find(o => o.id === orderId);
                    if (order) {
                        order.status = statusMap[newStatus];
                        renderOrders();
                        alert('وضعیت سفارش با موفقیت تغییر یافت');
                    }
                }
            }

            function deleteOrder(orderId) {
                if (confirm('آیا از حذف این سفارش اطمینان دارید؟')) {
                    const index = ordersData.findIndex(o => o.id === orderId);
                    if (index !== -1) {
                        ordersData.splice(index, 1);
                        filterOrders();
                        alert('سفارش با موفقیت حذف شد');
                    }
                }
            }

            function printOrder(orderId) {
                const order = ordersData.find(o => o.id === orderId);
                if (!order) return;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                <html>
                <head>
                    <title>سفارش #${order.id}</title>
                    <style>
                        body { font-family: Arial, sans-serif; direction: rtl; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .info { margin-bottom: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>فاکتور فروش</h1>
                        <h2>سفارش #${order.id}</h2>
                    </div>
                    
                    <div class="info">
                        <p><strong>مشتری:</strong> ${order.customer}</p>
                        <p><strong>تاریخ:</strong> ${formatDate(order.date)}</p>
                        <p><strong>آدرس:</strong> ${order.address}</p>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>محصول</th>
                                <th>تعداد</th>
                                <th>قیمت واحد</th>
                                <th>مجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${order.items.map(item => `
                                        <tr>
                                            <td>${item.name}</td>
                                            <td>${item.quantity}</td>
                                            <td>${formatPrice(item.price)} تومان</td>
                                            <td>${formatPrice(item.price * item.quantity)} تومان</td>
                                        </tr>
                                    `).join('')}
                        </tbody>
                    </table>
                    
                    <div style="margin-top: 20px; text-align: left;">
                        <h3>مبلغ کل: ${formatPrice(order.amount)} تومان</h3>
                    </div>
                </body>
                </html>
            `);
                printWindow.document.close();
                printWindow.print();
            }

            function openBulkStatusModal() {
                document.getElementById('selectedCount').textContent = selectedOrders.size;
                document.getElementById('bulkStatusModal').classList.add('show');
            }

            function closeBulkStatusModal() {
                document.getElementById('bulkStatusModal').classList.remove('show');
            }

            function confirmBulkStatusChange() {
                const newStatus = document.getElementById('newStatus').value;

                selectedOrders.forEach(orderId => {
                    const order = ordersData.find(o => o.id === orderId);
                    if (order) {
                        order.status = newStatus;
                    }
                });

                renderOrders();
                closeBulkStatusModal();
                alert(`وضعیت ${selectedOrders.size} سفارش با موفقیت تغییر یافت`);
            }

            function bulkDelete() {
                if (confirm(`آیا از حذف ${selectedOrders.size} سفارش انتخاب شده اطمینان دارید؟`)) {
                    ordersData = ordersData.filter(order => !selectedOrders.has(order.id));
                    selectedOrders.clear();
                    filterOrders();
                    alert('سفارشات انتخاب شده با موفقیت حذف شدند');
                }
            }

            function exportToExcel() {
                // Simple CSV export
                let csv = 'شماره سفارش,مشتری,تاریخ,مبلغ,وضعیت,روش پرداخت\n';

                filteredOrders.forEach(order => {
                    csv +=
                        `${order.id},${order.customer},${order.date},${order.amount},${getStatusText(order.status)},${order.payment}\n`;
                });

                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'orders.csv';
                link.click();
            }

            function printOrders() {
                window.print();
            }

            function changeItemsPerPage() {
                itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
                currentPage = 1;
                renderOrders();
            }

            function changePage(page) {
                const totalPages = Math.ceil(filteredOrders.length / itemsPerPage);
                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    renderOrders();
                }
            }

            function updatePagination() {
                const totalPages = Math.ceil(filteredOrders.length / itemsPerPage);
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, filteredOrders.length);

                document.getElementById('showingFrom').textContent = startIndex + 1;
                document.getElementById('showingTo').textContent = endIndex;
                document.getElementById('totalItems').textContent = filteredOrders.length;
                document.getElementById('totalOrders').textContent = `مجموع: ${filteredOrders.length} سفارش`;

                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === totalPages;

                // Update page numbers
                const pageNumbers = document.getElementById('pageNumbers');
                pageNumbers.innerHTML = '';

                for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.className =
                        `px-3 py-2 text-sm border rounded-md ${i === currentPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white border-gray-300 hover:bg-gray-50'}`;
                    button.onclick = () => changePage(i);
                    pageNumbers.appendChild(button);
                }
            }

            // Utility functions
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('fa-IR');
            }

            function formatPrice(price) {
                return price.toLocaleString('fa-IR');
            }

            function getStatusText(status) {
                const statusTexts = {
                    'pending': 'در انتظار',
                    'processing': 'در حال پردازش',
                    'shipped': 'ارسال شده',
                    'delivered': 'تحویل داده شده',
                    'cancelled': 'لغو شده',
                    'returned': 'مرجوع شده'
                };
                return statusTexts[status] || status;
            }
        </script>
    </body>

    </html>
