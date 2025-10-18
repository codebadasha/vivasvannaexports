<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('client.dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-chart-areaspline"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>

                @if(Auth::guard('client')->user()->is_active == 1)

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-bookmark-plus"></i>
                            <span>Projects</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('client.project.create') }}">Add Project</a></li>
                            <li><a href="{{ route('client.project.index') }}">All Projects</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-task"></i>
                            <span>BOQ</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('client.boq.create') }}">Add BOQ</a></li>
                            <li><a href="{{ route('client.boq.index') }}">All BOQs</a></li>
                        </ul>
                    </li>   

                    <li>
                        <a href="{{ route('client.po.index') }}" class="waves-effect">
                            <i class="bx bx-list-check"></i>
                            <span key="t-chat">All POs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('client.invoice.index') }}" class="waves-effect">
                            <i class="bx bx-right-indent"></i>
                            <span>All Invoices</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('client.transaction.index') }}" class="waves-effect">
                            <i class="bx bx-sort"></i>
                            <span>All Trasnaction</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('client.credit.add') }}" class="waves-effect">
                            <i class="bx bx-sort"></i>
                            <span>Apply For Credit</span>
                        </a>
                    </li>
                    
                @endif
            </ul>
        </div>
    </div>
</div>
