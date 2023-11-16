<aside class="main-sidebar main-sidebar main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link" style="background-color: #F2CC7B !important; height: 56px">
        <img src="{{ asset('images/logo.jpg') }}" alt="Inventory Management System" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light navbar-header">
            <strong>IMS</strong>
        </span>
    </a>
    <section class="sidebar" style="min-height: 100%; background-color: #0C0C0C !important;">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-gear"></i>
                        <p>
                            Setups
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a href="{{ route('user.users') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        User Registration
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('account.accounts') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Account Registration
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brand.brands') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Brand
                                </p>
                            </a>
                        </li>
                      {{--  <li class="nav-item">
                            <a href="{{ route('category.categories') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>--}}
                        <li class="nav-item">
                            <a href="{{ route('product.products') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bank.list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Bank
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Purchase
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('purchase.purchases') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Purchase
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchase-return.purchases') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Purchase Return
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('sale.sales') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Sales
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sale-return.sales-return') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Sales Return
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Accounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('cpv.list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Cash Payment Voucher
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('crv.list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Cash Receipt Voucher
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bpv.list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Bank Payment Voucher
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brv.list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Bank Receipt Voucher
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--<li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Delivery Charges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('delivery-charges.dc-list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Delivery Charges
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.customers') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Calculator
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>--}}

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('account-ledger.ledger') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Account Ledger
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock.report') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Stock Report
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

