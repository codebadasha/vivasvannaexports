<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('investor.dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-chart-areaspline"></i>
                        <span key="t-chat">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('investor.client.index') }}" class="waves-effect">
                        <i class="mdi mdi-office-building"></i>
                        <span key="t-chat">All Clients</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('investor.project.index') }}" class="waves-effect">
                        <i class="bx bx-bookmark-plus"></i>
                        <span key="t-chat">All Projects</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('investor.boq.index') }}" class="waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-chat">All BOQs</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('investor.po.index') }}" class="waves-effect">
                        <i class="bx bx-list-check"></i>
                        <span key="t-chat">All POs</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('investor.invoice.index') }}" class="waves-effect">
                        <i class="bx bx-right-indent"></i>
                        <span key="t-chat">All Invoices</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
