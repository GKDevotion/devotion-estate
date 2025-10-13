<div class="user-profile pull-right">
    <ul class="notification-area pull-right">
        <li id="full-view"><i class="ti-fullscreen"></i></li>
        <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
        <li class="dropdown">
            <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                <span>2</span>
            </i>
            <div class="dropdown-menu bell-notify-box notify-box">
                <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                <div class="nofity-list">
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                        <div class="notify-text">
                            <p>You have Changed Your Password</p>
                            <span>Just Now</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                        <div class="notify-text">
                            <p>New Commetns On Post</p>
                            <span>30 Seconds ago</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                        <div class="notify-text">
                            <p>Some special like you</p>
                            <span>Just Now</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                        <div class="notify-text">
                            <p>New Commetns On Post</p>
                            <span>30 Seconds ago</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                        <div class="notify-text">
                            <p>Some special like you</p>
                            <span>Just Now</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                        <div class="notify-text">
                            <p>You have Changed Your Password</p>
                            <span>Just Now</span>
                        </div>
                    </a>
                    <a href="#" class="notify-item">
                        <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                        <div class="notify-text">
                            <p>You have Changed Your Password</p>
                            <span>Just Now</span>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li>
            <img class="avatar user-thumb" src="{{ asset('public/backend/assets/images/icon/avatar.png') }}" alt="{{ Auth::guard('admin')->user()->username }}">
        </li>
        <li>
            <img class="avatar user-thumb dropdown-toggle" data-toggle="dropdown" src="{{ asset('public/backend/assets/images/icon/log-out.png') }}" alt="Log Out" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
            
            <form id="admin-logout-form" action="{{ route('admin.logout.submit') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>    
</div>