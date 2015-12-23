<?php
$title = Config::get('custom.companyname');

if (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Customer) {
    $customer = Auth::User()->Customer();
    $title = Auth::User()->FirstName . " " . Auth::User()->LastName;
}
?>
        <!--<div class="page-navigation-panel logo"></div>-->
<div class="page-navigation-panel"
     style="background: url('/img/background/bt_cubs.png') left top repeat;background-color: rgba(29,29,29,1);">
    @if(Str::length($title) < 17)
        <div class="name">{{ __('common.dashboard_welcome') }}, {{ $title }}</div>
    @else
        <div class="name">{{ __('common.dashboard_welcome') }},<br/> {{ $title }}</div>
    @endif
    <div class="control"><a href="#" class="psn-control"><span class="icon-reorder" style="color:#1681bf;"></span></a>
    </div>
</div>

<ul class="page-navigation bg-light">
    <li>
        <a href="{{URL::to(__('route.home'))}}"><span class="icon-home"></span>{{ __('common.home') }}</a>
    </li>
    <?php if (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Manager): ?>
    <li>
        <a href="{{URL::to(__('route.managements_list'))}}"><span class="icon-wrench"></span>{{ __('common.management') }}</a>
    </li>
    <li>
        <a href="#"><span class="icon-sitemap"></span> {{ __('common.menu_caption') }}</a>
        <ul>
            {{ HTML::nav_link(__('route.customers'), __('common.menu_customers')) }}
            {{ HTML::nav_link(__('route.applications'), __('common.menu_applications')) }}
            {{ HTML::nav_link(__('route.contents'), __('common.menu_contents')) }}
            {{ HTML::nav_link(__('route.orders'), __('common.menu_orders')) }}
        </ul>
    </li>
    <?php elseif (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Customer): ?>
    <li>
        <a href="#"><span class="icon-dropbox"></span>{{ __('common.menu_caption_applications') }}</a>
        <ul id="allApps">
            <script type="text/javascript">
                var contentsUrl = '<?php echo __('route.contents'); ?>';
                var applicationSettingRoute = "<?php echo __("route.applications_usersettings"); ?>";
                var bannersController = "<?php echo __("route.banners"); ?>";
                $(document).ready(function () {
                    var applicationSettingRouteExp = applicationSettingRoute.replace("(:num)", "\\d+");
                    var appID = parseInt($("input[name$='pplicationID']").val());
                    if (!(appID > 0)) {
                        return;
                    }
                    if (window.location.href.indexOf(bannersController) > -1 || window.location.href.match(new RegExp(applicationSettingRouteExp, "i"))) {
                        $(".page-navigation ul#allSettings li a").each(function (index) {
                            var match = $(this).attr('href').match(/\d+/);
                            if (match.length > 0 && parseInt(match[0]) === appID) {
                                $(this).attr('class', 'visited');
                                return false;
                            }
                        });
                        $(".page-navigation ul#allSettings").prev().trigger('click');
                    } else {
                        $(".page-navigation ul#allApps li a").each(function (index) {
                            if (parseInt(getURLParameter($(this).attr('href'), 'applicationID')) === appID) {
                                $(this).attr('class', 'visited');
                                return false;
                            }
                        });
                        $(".page-navigation ul#allApps").prev().trigger('click');
                    }

                    function getURLParameter(url, name) {
                        return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
                    }
                });
            </script>
            <?php if (Auth::User() != NULL): ?>
            <?php foreach (Auth::User()->Customer()->Applications(eStatus::Active) as $app): ?>
            <li style="width:100%;">
                <?php echo HTML::link(__('route.contents') . '?applicationID=' . $app->ApplicationID, $app->Name, $app->sidebarClass()); ?>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </li>
    <?php endif; ?>
    <li>
        <a href="#"><span class="icon-file-text-alt"></span> {{ __('common.menu_caption_reports') }}</a>
        <ul id="allReports">
            <?php
            $reportLinks = array();
            if (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Manager) {
                $reportLinks = array(101, 201, 301, 302, 1001, 1101, 1201, 1301, 1302);
            } else {
                $reportLinks = array(301, 1001, 1301, 1302);
            }
            ?>
            <?php
            foreach ($reportLinks as $reportLink) {
                echo HTML::nav_link(__('route.reports') . '?r=' . $reportLink, __('common.menu_report_' . $reportLink));
            }
            ?>
            <script type="text/javascript">
                var reportLinks = <?php echo json_encode($reportLinks); ?>;
                $(function () {
                    var reportUrl = window.location.href;
                    var reportUrlParams = reportUrl.split("?");
                    for (var i = 0; i < reportLinks.length; i++) {
                        if (reportUrlParams[1] === "r=" + reportLinks[i]) {
                            $('ul#allReports li:eq(' + i + ') a').attr('class', 'visited');
                            $(".page-navigation ul#allReports").prev().trigger('click');
                        }
                    }
                });
            </script>
        </ul>
    </li>
    <?php if (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Manager): ?>
    <li>
        <a href="#"><span class="icon-user"></span>Kullanıcı Ayarları</a>
        <ul>
            {{ HTML::nav_link(__('route.users'), __('common.menu_users')) }}
            {{ HTML::nav_link(__('route.mydetail'), __('common.menu_mydetail')) }}
        </ul>
    </li>

    <?php endif; ?>
    <?php if (Auth::User() != NULL && (int)Auth::User()->UserTypeID == eUserTypes::Customer): ?>
    <li>
        <a href="{{URL::to(__('route.mydetail'))}}"><span class="icon-user"></span>{{ __('common.menu_mydetail') }}</a>
    </li>
    <li>
        <a href="#"><span class="icon-cogs"></span>{{__('common.application_settings_caption_detail')}}</a>
        <ul id="allSettings">
            <?php foreach (Auth::User()->Customer()->Applications(1) as $app): ?>
            <li style="width:100%;">
                <?php echo HTML::link(str_replace('(:num)', $app->ApplicationID, __('route.applications_usersettings')), $app->Name, $app->sidebarClass()); ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>
    <li>
        <a href="<?php echo Laravel\URL::to(__('route.clients')) ?>">
            <span class="icon-mobile-phone"></span><?php echo __('common.client_list') ?>
        </a>
    </li>
    <li>
        <a href="{{URL::to(__('route.shop'))}}"><span
                    class="icon-credit-card"></span>{{ __('common.application_payment') }}</a>
    </li>
    <?php endif; ?>
</ul> 
