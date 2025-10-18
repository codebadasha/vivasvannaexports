<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-chart-areaspline"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>

                @if(in_array('role',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-lock-check-outline"></i>
                            <span>Organization Role</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('role',$selectedAction) && in_array('add',$selectedAction['role']))
                                <li><a href="{{ route('admin.addRole') }}">Add Organization Role</a></li>
                            @endif
                            <li><a href="{{ route('admin.roleList') }}">All Organization Roles</a></li>
                        </ul>
                    </li>
                @endif

                @if(in_array('investor',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-tie"></i>
                            <span>Investor</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('investor',$selectedAction) && in_array('add',$selectedAction['investor']))
                                <li><a href="{{ route('admin.investor.create') }}">Add Investor</a></li>
                            @endif
                            <li><a href="{{ route('admin.investor.index') }}">All Investor</a></li>
                        </ul>
                    </li>
                @endif

                @if(in_array('supplier-company',$module))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span>Supplier Company</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(array_key_exists('supplier-company',$selectedAction) && in_array('add',$selectedAction['supplier-company']))
                            <li><a href="{{ route('admin.supplier.create') }}">Add Supplier Company</a></li>
                        @endif
                        <li><a href="{{ route('admin.supplier.index') }}">All Supplier Companies</a></li>
                    </ul>
                </li>
                @endif
                @if(in_array('team',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-multiple-plus"></i>
                            <span>Team</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('team',$selectedAction) && in_array('add',$selectedAction['team']))
                                <li><a href="{{ route('admin.team.create') }}">Add Team Member</a></li>
                            @endif
                            <li><a href="{{ route('admin.team.index') }}">All Team Members</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('client-company',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-office-building"></i>
                            <span>Client Company</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('client-company',$selectedAction) && in_array('add',$selectedAction['client-company']))
                                <li><a href="{{ route('admin.client.create') }}">Add Company</a></li>
                            @endif
                            <li><a href="{{ route('admin.invitations.index') }}">All Companies</a></li>
                            <li><a href="{{ route('admin.invitations.create') }}">Send Invitation</a></li>
                            <li><a href="{{ route('admin.invitations.index') }}">All Invitation</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('product',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-bookmark-plus"></i>
                            <span>Products</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('product',$selectedAction) && in_array('add',$selectedAction['product']))
                                <li><a href="{{ route('admin.product.create') }}">Add Product</a></li>
                            @endif
                            <li><a href="{{ route('admin.product.index') }}">All Products</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('po',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-list-check"></i>
                            <span>PO</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('po',$selectedAction) && in_array('add',$selectedAction['po']))
                                <li><a href="{{ route('admin.po.create') }}">Add PO</a></li>
                            @endif
                            <li><a href="{{ route('admin.po.index') }}">All POs</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('project',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-bookmark-plus"></i>
                            <span>Projects</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('project',$selectedAction) && in_array('add',$selectedAction['project']))
                                <li><a href="{{ route('admin.project.create') }}">Add Project</a></li>
                            @endif
                            <li><a href="{{ route('admin.project.index') }}">All Projects</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('boq',$module))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-task"></i>
                            <span>BOQ</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(array_key_exists('boq',$selectedAction) && in_array('add',$selectedAction['boq']))
                                <li><a href="{{ route('admin.boq.create') }}">Add BOQ</a></li>
                            @endif
                            <li><a href="{{ route('admin.boq.index') }}">All BOQs</a></li>
                        </ul>
                    </li>
                @endif
                @if(in_array('invoice',$module))
                    <li>
                        <a href="{{ route('admin.invoice.index') }}" class="waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span>All Invoices</span>
                        </a>
                    </li>
                @endif
                @if(in_array('transaction',$module))
                    <li>
                        <a href="{{ route('admin.transaction.index') }}" class="waves-effect">
                            <i class="bx bx-sort"></i>
                            <span>All Trasnaction</span>
                        </a>
                    </li>
                @endif
                @if(in_array('policy',$module))
                    <li>
                        <a href="{{ route('admin.policyList') }}" class="waves-effect">
                            <i class="bx bx-notepad"></i>
                            <span>Policy Content</span>
                        </a>
                    </li>
                @endif
                @if(in_array('credit',$module))
                    <li>
                        <a href="{{ route('admin.credit.index') }}" class="waves-effect">
                            <i class="bx bx-notepad"></i>
                            <span>Credit Request</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
