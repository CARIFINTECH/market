<div class="dropdown-menu options-user" role="menu">
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">My account</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/user/manage/orders"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;Orders</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/business/manage/details"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;My Details</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Verification</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/favorites"><span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;Favorites</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/alerts"><span class="glyphicon glyphicon-bell"></span>&nbsp;&nbsp;Search Alerts</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/business/manage/support"><span class="fa fa-envelope"></span> &nbsp;&nbsp; Support</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                   <span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp; Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">My Ads Portal</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/ads">
                    <span class="glyphicon glyphicon-folder-open"></span>
                    &nbsp;&nbsp;Manage My Ads
                </a>
            </li>
            <li><a class="nav-link nav-color" href="/user/ad/create"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Post an Ad</a> </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/images"><span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;Images</a>
            </li>
        </ul>
    </div>
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">Jobs/Profile</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/job/profile/edit/general"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Private Profile</a>
            </li>
            @foreach(Auth::user()->publishProfiles as $profile)
            <li>
                <a class="nav-link nav-color" href="/user/job/publish/profile?type={{$profile->type}}"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;{{$profile->getType()}} Profile</a>
            </li>
            @endforeach
            <li>
                <a class="nav-link nav-color" href="/user/job/portal"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Candidate Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Job Alerts</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Company Alerts</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Recommended Jobs</a>
            </li>
        </ul>
    </div>
    @if(Auth::user()->contract!==null)
    <div class="list-menu-common">
        <div class="title-list">
            <span>My business</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/business/manage/company"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Company</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/business/manage/finance"><span class="glyphicon glyphicon-gbp"></span> &nbsp;&nbsp;Financials</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/business/manage/metrics"><span class="glyphicon glyphicon-stats"></span> &nbsp;&nbsp;Metrics</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/recruiter/portal"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;&nbsp;Recruitment Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/motors"><span class="fa fa-car"></span> &nbsp;&nbsp;Motors Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-building"></span> &nbsp;&nbsp;Properties Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-tag"></span> &nbsp;&nbsp;For Sales Portal</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-tag"></span> &nbsp;&nbsp;Services Portal</a>
            </li>
        </ul>
    </div>
    @endif
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">Invoices</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/user/manage/contacts"><span class="glyphicon glyphicon-open-file"></span>&nbsp;&nbsp;Send Invoice</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/invoices"><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp;Unpaid Invoice</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/invoices"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Paid Invoice</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/invoices"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Pending Invoices</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-cloud-download"></span>&nbsp;&nbsp;Download Invoice CSV/Excel</a>
            </li>
        </ul>
    </div>
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">sWallet</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/business/manage/swallet">My sWallet</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#">My Statement</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#">Share Balance</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#">Share Referral Code</a>
            </li>
        </ul>
    </div>
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">Chat Centrium</span>
        </div>
        <ul>
            <li>
                <a class="nav-link nav-color" href="/user/manage/messages"><span class="fa fa-commenting"></span> &nbsp;&nbsp;Messages</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/manage/contacts"><span class="fa fa-address-book"></span> &nbsp;&nbsp;Contacts</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="/user/groups/create"><span class="fa fa-users"></span> &nbsp;&nbsp;New Group</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-reply-all"></span> &nbsp;&nbsp;New Broadcast</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-comments-o"></span> &nbsp;&nbsp;New Conversation</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-money"></span> &nbsp;&nbsp;Share your Balance</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-paperclip"></span> &nbsp;&nbsp;Attachment</a>
            </li>
            <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-cog"></span> &nbsp;&nbsp;Settings</a>
            </li>
             <li>
                <a class="nav-link nav-color" href="#"><span class="fa fa-user-circle"></span> &nbsp;&nbsp;Profile</a>
            </li>
        </ul>
    </div>
    <div class="list-menu-common">
        <div class="title-list">
            <span class="nav-link nav-color">Our Offers</span>
        </div>
        <ul>
            <li>
                <span class="nav-link nav-offer">We do not have offers at the moment</span>
            </li>
        </ul>
    </div>
</div>
        