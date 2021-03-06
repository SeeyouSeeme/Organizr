<?php

$data = false;

ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL | E_STRICT);

require_once("user.php");
require_once("functions.php");
use Kryptonit3\Sonarr\Sonarr;
use Kryptonit3\SickRage\SickRage;
$sonarr = new Sonarr(SONARRURL, SONARRKEY);
$radarr = new Sonarr(RADARRURL, RADARRKEY);
$sickrage = new SickRage(SICKRAGEURL, SICKRAGEKEY);
$USER = new User("registration_callback");

// Check if connection to homepage is allowed
qualifyUser(HOMEPAGEAUTHNEEDED, true);

// Load Colours/Appearance
foreach(loadAppearance() as $key => $value) {
	${$key} = $value;
}

$startDate = date('Y-m-d',strtotime("-".CALENDARSTARTDAY." days"));
$endDate = date('Y-m-d',strtotime("+".CALENDARENDDAY." days")); 

?>

<!DOCTYPE html>

<html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no" />

        <title><?=$title;?> Homepage</title>

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css"> 
        <script src="js/menu/modernizr.custom.js"></script>

        <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">

        <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.css">

        <link rel="stylesheet" href="css/style.css?v=<?php echo INSTALLEDVERSION; ?>">
        <link rel="stylesheet" href="bower_components/mdi/css/materialdesignicons.min.css?v=<?php echo INSTALLEDVERSION; ?>">
        <link rel="stylesheet" href="bower_components/google-material-color/dist/palette.css?v=<?php echo INSTALLEDVERSION; ?>">
        <link rel="stylesheet" type="text/css" href="bower_components/slick/slick.css?v=<?php echo INSTALLEDVERSION; ?>">
        <!-- Add the slick-theme.css if you want default styling -->
       

        <!--Scripts-->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/moment/min/moment.min.js"></script>
        <script src="bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
        <script src="bower_components/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>
        <script src="bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
        <script src="bower_components/cta/dist/cta.min.js"></script>
        <script src="bower_components/fullcalendar/dist/fullcalendar.js?v=<?php echo INSTALLEDVERSION; ?>"></script>
        <script src="bower_components/slick/slick.js?v=<?php echo INSTALLEDVERSION; ?>"></script>

        <script src="js/jqueri_ui_custom/jquery-ui.min.js"></script>
	    <script src="js/jquery.mousewheel.min.js" type="text/javascript"></script>
		
		<!--Other-->
		<script src="js/ajax.js?v=<?php echo INSTALLEDVERSION; ?>"></script>
		
        <!--[if lt IE 9]>
        <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
        <script src="bower_components/respondJs/dest/respond.min.js"></script>
        <![endif]-->
        <style>
            .fc-day-grid-event{
                cursor: pointer;
            }
            .recentItems {
                padding-top: 10px;
                margin: 5px 0;
            }
            .slick-image-tall{
                width: 125px;
                height: 180px;
            }
            .slick-image-short{
                width: 125px;
                height: 130px;
                margin-top: 50px;
            }
            .overlay{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: none;
                z-index: 0;
                opacity: .98;
            }
            sort {
                display: none;
            }
            table.fc-list-table {
                table-layout: auto;
            }.tabbable{
                margin-bottom: 0;
            }.fc-day-grid-event .fc-content {
                white-space: normal;
            }.fc-list-item {
                table-layout: auto;
                position: inherit;
                margin: 10px;
                border-radius: 4px;
                padding: 0 5px 0 5px;
                color: #fff !important;
            }.fc-calendar .fc-toolbar {
                background: <?=$topbar;?>;
                color: <?=$topbartext;?>;
                border-radius: 5px 5px 0 0;
                padding: 15px;
            }.fc-calendar .fc-toolbar .fc-right {
                bottom: 0px;
                right: 20px;
            }.fc-calendar .fc-toolbar .fc-right button {
                color: <?=$topbartext;?>;
            }.fc-calendar .fc-toolbar .fc-prev-button, .fc-calendar .fc-toolbar .fc-next-button {
                color: <?=$topbartext;?>;
            }.carousel-image{
                width: 100px !important;
                height: 150px !important;
                border-radius: 3px 0 0 3px;  
            }.carousel-image.album{
                width: 150px !important;
                height: 150px !important;
                border-radius: 3px 0 0 3px;  
            }.carousel-control.album {
                top: 5px !important;
                width: 4% !important;
            }.carousel-control {
                top: 5px !important;
                width: 4% !important;
            }.carousel-caption.album {
                position: absolute;
                right: 4%;
                top: 0px;
                left: 160px;
                z-index: 10;
                bottom: 0px;
                padding-top: 0px;
                color: #fff;
                text-align: left;
            }.carousel-caption {
                position: absolute;
                right: 4%;
                top: 0px;
                left: 110px;
                z-index: 10;
                bottom: 0px;
                padding-top: 0px;
                color: #fff;
                text-align: left;
                padding-bottom: 2px !important;
                overflow: hidden !important;
            } @media screen and (max-width: 576px) {
				.nzbtable {
					padding-left: 5px !important;
					padding-right: 2px !important;
					font-size: 10px !important;
					word-break: break-word !important;
				}
				.nzbtable-file-row {
					padding-left: 5px !important;
					padding-right: 2px !important;
					font-size: 10px !important;
					white-space: normal !important;
					word-break: break-all !important;
					width: 0% !important;
				}
            } .nzbtable-file-row {
				white-space: normal !important;
				word-break: break-all !important;
				width: 0% !important;
			}.nzbtable-row {
				white-space: normal !important;
				width: 0% !important;
				font-size: 12px; !important;
			}<?php customCSS(); ?>       
        </style>
    </head>

    <body class="scroller-body" style="padding: 0px;">
        <div class="main-wrapper" style="position: initial;">
            <div id="content" class="container-fluid">
                <br/>
 
                <?php if (qualifyUser(HOMEPAGENOTICEAUTH) && HOMEPAGENOTICETITLE && HOMEPAGENOTICETYPE && HOMEPAGENOTICEMESSAGE && HOMEPAGENOTICELAYOUT) { echo buildHomepageNotice(HOMEPAGENOTICELAYOUT, HOMEPAGENOTICETYPE, HOMEPAGENOTICETITLE, HOMEPAGENOTICEMESSAGE); } ?>
                
                <?php if (qualifyUser(HOMEPAGECUSTOMHTML1AUTH) && HOMEPAGECUSTOMHTML1) { echo "<div>" . HOMEPAGECUSTOMHTML1 . "</div>"; } ?>

                <?php if(SPEEDTEST == "true"){ ?>
                <style type="text/css">

                    .flash {
                        animation: flash 0.6s linear infinite;
                    }

                    @keyframes flash {
                        0% { opacity: 0.6; }
                        50% { opacity: 1; }
                    }

                </style>
                <script type="text/javascript">
                    var w = null
                    function runTest() {
                        document.getElementById('startBtn').style.display = 'none'
                        document.getElementById('testArea').style.display = ''
                        document.getElementById('abortBtn').style.display = ''
                        w = new Worker('bower_components/speed/speedtest_worker.min.js')
                        var interval = setInterval(function () { w.postMessage('status') }, 100)
                        w.onmessage = function (event) {
                            var data = event.data.split(';')
                            var status = Number(data[0])
                            var dl = document.getElementById('download')
                            var ul = document.getElementById('upload')
                            var ping = document.getElementById('ping')
                            var jitter = document.getElementById('jitter')
                            dl.className = status === 1 ? 'w-name flash' : 'w-name'
                            ping.className = status === 2 ? 'w-name flash' : 'w-name'
                            jitter.className = ul.className = status === 3 ? 'w-name flash' : 'w-name'
                            if (status >= 4) {
                                clearInterval(interval)
                                document.getElementById('abortBtn').style.display = 'none'
                                document.getElementById('startBtn').style.display = ''
                                w = null
                            }
                            if (status === 5) {
                                document.getElementById('testArea').style.display = 'none'
                            }
                            dl.textContent = data[1] + " Mbit/s";
                            $("#downloadpercent").attr("style", "width: " + data[1] + "%;");
                            $("#uploadpercent").attr("style", "width: " + data[2] + "%;");
                            $("#pingpercent").attr("style", "width: " + data[3] + "%;");
                            $("#jitterpercent").attr("style", "width: " + data[5] + "%;");
                            ul.textContent = data[2] + " Mbit/s";
                            ping.textContent = data[3] + " ms";
                            jitter.textContent = data[5] + " ms";
                        }
                        w.postMessage('start')
                    }
                    function abortTest() {
                        if (w) w.postMessage('abort')
                    }
                </script>

                <div class="row" id="testArea" style="display:none">

                    <div class="test col-sm-3 col-lg-3">
                        <div class="content-box ultra-widget green-bg" data-counter="">
                            <div id="downloadpercent" class="progress-bar progress-bar-striped active w-used" style=""></div>
                            <div class="w-content">
                                <div class="w-icon right pull-right"><i class="mdi mdi-cloud-download"></i></div>
                                <div class="w-descr left pull-left text-center">
                                    <span class="testName text-uppercase w-name">Download</span>
                                    <br>
                                    <span class="w-name counter" id="download" ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="test col-sm-3 col-lg-3">
                        <div class="content-box ultra-widget red-bg" data-counter="">
                            <div id="uploadpercent" class="progress-bar progress-bar-striped active w-used" style=""></div>
                            <div class="w-content">
                                <div class="w-icon right pull-right"><i class="mdi mdi-cloud-upload"></i></div>
                                <div class="w-descr left pull-left text-center">
                                    <span class="testName text-uppercase w-name">Upload</span>
                                    <br>
                                    <span class="w-name counter" id="upload" ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="test col-sm-3 col-lg-3">
                        <div class="content-box ultra-widget yellow-bg" data-counter="">
                            <div id="pingpercent" class="progress-bar progress-bar-striped active w-used" style=""></div>
                            <div class="w-content">
                                <div class="w-icon right pull-right"><i class="mdi mdi-timer"></i></div>
                                <div class="w-descr left pull-left text-center">
                                    <span class="testName text-uppercase w-name">Latency</span>
                                    <br>
                                    <span class="w-name counter" id="ping" ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="test col-sm-3 col-lg-3">
                        <div class="content-box ultra-widget blue-bg" data-counter="">
                            <div id="jitterpercent" class="progress-bar progress-bar-striped active w-used" style=""></div>
                            <div class="w-content">
                                <div class="w-icon right pull-right"><i class="mdi mdi-pulse"></i></div>
                                <div class="w-descr left pull-left text-center">
                                    <span class="testName text-uppercase w-name">Jitter</span>
                                    <br>
                                    <span class="w-name counter" id="jitter" ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>

                </div>

                <div id="abortBtn" class="row" style="display: none" onclick="javascript:abortTest()">
                    <div class="col-lg-12">
                        <div class="content-box red-bg" style="cursor: pointer;">
                            <h1 style="margin: 10px" class="text-uppercase text-center">Abort Speed Test</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div id="startBtn" class="row" onclick="javascript:runTest()">
                    <div class="col-lg-12">
                        <div class="content-box green-bg" style="cursor: pointer;">
                            <h1 style="margin: 10px" class="text-uppercase text-center">Run Speed Test</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if((PLEXSEARCH == "true" && qualifyUser(PLEXHOMEAUTH))) { ?>
                <div id="searchPlexRow" class="row">
                    <div class="col-lg-12">
                        <div class="content-box box-shadow big-box todo-list">                        
                            <form id="plexSearchForm" onsubmit="return false;" autocomplete="off">
                                <div class="">
                                    <div class="input-group">
                                        <div style="border-radius: 25px 0 0 25px; border:0" class="input-group-addon gray-bg"><i class="fa fa-search white"></i></div>
                                        <input id="searchInput" type="text" style="border-radius: 0;" autocomplete="off" name="search-title" class="form-control input-group-addon gray-bg" placeholder="Media Search">
										<div id="clearSearch" style="border-radius: 0 25px 25px 0;border:0; cursor: pointer;" class="input-group-addon gray-bg"><i class="fa fa-close white"></i></div>
                                        <button style="display:none" id="plexSearchForm_submit" class="btn btn-primary waves"></button>
                                    </div>
                                </div>
                            </form>
                            <div id="resultshere" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php if((NZBGETURL != "" && qualifyUser(NZBGETHOMEAUTH)) || (SABNZBDURL != "" && qualifyUser(SABNZBDHOMEAUTH))) { ?>
                <div id="downloadClientRow" class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="content-box">
                            <div class="tabbable panel with-nav-tabs panel-default">
                                <div class="panel-heading">
                                    <div class="content-tools i-block pull-right">
                                        <a id="getDownloader" class="repeat-btn">
                                            <i class="fa fa-repeat"></i>
                                        </a>
                                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
										<!-- Lets Move This To Homepage Settings
                                        <ul id="downloaderSeconds" class="dropdown-menu" style="top: 32px !important">
                                            <li data-value="5000"><a>Refresh every 5 seconds</a></li>
                                            <li data-value="10000"><a>Refresh every 10 seconds</a></li>
                                            <li data-value="30000"><a>Refresh every 30 seconds</a></li>
                                            <li data-value="60000"><a>Refresh every 60 seconds</a></li>
                                        </ul>
										-->
                                    </div>
                                    <h3 class="pull-left"><?php if(NZBGETURL != ""){ echo "NZBGet "; } if(SABNZBDURL != ""){ echo "SABnzbd "; } ?></h3>
                                    <ul class="nav nav-tabs pull-right">
                                        <li class="active"><a href="#downloadQueue" data-toggle="tab" aria-expanded="true"><?php echo $language->translate("QUEUE");?></a></li>
                                        <li class=""><a href="#downloadHistory" data-toggle="tab" aria-expanded="false"><?php echo $language->translate("HISTORY");?></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="downloadQueue">
                                            <div class="table-responsive" style="max-height: 300px">
                                                <table class="table table-striped progress-widget zero-m" style="max-height: 300px">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-xs-7 nzbtable-file-row"><?php echo $language->translate("FILE");?></th>
                                                            <th class="col-xs-2 nzbtable"><?php echo $language->translate("STATUS");?></th>
                                                            <th class="col-xs-1 nzbtable"><?php echo $language->translate("CATEGORY");?></th>
                                                            <th class="col-xs-2 nzbtable"><?php echo $language->translate("PROGRESS");?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="dl-queue sabnzbd"></tbody>
                                                    <tbody class="dl-queue nzbget"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="downloadHistory">
                                            <div class="table-responsive" style="max-height: 300px">
                                                <table class="table table-striped progress-widget zero-m" style="max-height: 300px">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-xs-7 nzbtable-file-row"><?php echo $language->translate("FILE");?></th>
                                                            <th class="col-xs-2 nzbtable"><?php echo $language->translate("STATUS");?></th>
                                                            <th class="col-xs-1 nzbtable"><?php echo $language->translate("CATEGORY");?></th>
                                                            <th class="col-xs-2 nzbtable"><?php echo $language->translate("PROGRESS");?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="dl-history sabnzbd"></tbody>
                                                    <tbody class="dl-history nzbget"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
				<?php if (qualifyUser(PLEXHOMEAUTH) && PLEXTOKEN) { ?>
                <div id="plexRowNowPlaying" class="row">
                    <?php if(PLEXPLAYINGNOW == "true"){ echo getPlexStreams(12, PLEXSHOWNAMES, $USER->role); } ?>
                </div>
                <div id="plexRow" class="row">
                    <div class="col-lg-12">
                    <?php
                    if(PLEXRECENTMOVIE == "true" || PLEXRECENTTV == "true" || PLEXRECENTMUSIC == "true"){  
                        $plexArray = array("movie" => PLEXRECENTMOVIE, "season" => PLEXRECENTTV, "album" => PLEXRECENTMUSIC);
                        echo getPlexRecent($plexArray);
                    } 
                    ?>
                    </div>
                </div>
                <div id="plexPlaylists" class="row">
                    <div class="col-lg-12">
                    <?php
                    if(PLEXPLAYLISTS == "true"){  
                        echo getPlexPlaylists($plexArray);
                    } 
                    ?>
                    </div>
                </div>
                <?php } ?>
    
				<?php if (qualifyUser(EMBYHOMEAUTH) && EMBYTOKEN) { ?>
                <div id="embyRowNowPlaying" class="row">
                    <?php if(EMBYPLAYINGNOW == "true"){ echo getEmbyStreams(12, EMBYSHOWNAMES, $USER->role); } ?>
                </div>
                <div id="embyRow" class="row">
                    <div class="col-lg-12">
                    <?php
                    if(EMBYRECENTMOVIE == "true" || EMBYRECENTTV == "true" || EMBYRECENTMUSIC == "true"){  
                        $embyArray = array("Movie" => EMBYRECENTMOVIE, "Episode" => EMBYRECENTTV, "MusicAlbum" => EMBYRECENTMUSIC, "Series" => EMBYRECENTTV);
                        echo getEmbyRecent($embyArray);
                    } 
    
                    ?>
                    </div>

                </div>
				<?php } ?>
                <?php if ((SONARRURL != "" && qualifyUser(SONARRHOMEAUTH)) || (RADARRURL != "" && qualifyUser(RADARRHOMEAUTH)) || (HEADPHONESURL != "" && qualifyUser(HEADPHONESHOMEAUTH)) || (SICKRAGEURL != "" && qualifyUser(SICKRAGEHOMEAUTH))) { ?>
                <div id="calendarLegendRow" class="row" style="padding: 0 0 10px 0;">
                    <div class="col-lg-12 content-form form-inline">
                        <div class="form-group">
                            <select class="form-control" id="imagetype_selector" style="width: auto !important; display: inline-block">
                                <option value="all">View All</option>
                                <?php if(RADARRURL != ""){ echo '<option value="film">Movies</option>'; }?>
                                <?php if(SONARRURL != "" || SICKRAGEURL != ""){ echo '<option value="tv">TV Shows</option>'; }?>
                                <?php if(HEADPHONESURL != ""){ echo '<option value="music">Music</option>'; }?>
                            </select>

                            <span class="label label-primary well-sm">Available</span>
                            <span class="label label-danger well-sm">Unavailable</span>
                            <span class="label indigo-bg well-sm">Unreleased</span>
                            <span class="label light-blue-bg well-sm">Premier</span>
                        </div>
                        <!--
                        <div class="pull-right">
                            <div class="btn-group" role="group">
                            <button type="button" class="btn waves btn-default btn-sm dropdown-toggle waves-effect waves-float" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View All<span class="caret"></span></button>
                            <ul style="right:0; left: auto" class="dropdown-menu">
                                <li><a class="" href="javascript:void(0)">Movies</a></li>
                                <li><a class="" href="javascript:void(0)">TV Shows</a></li>
                                <li><a class="" href="javascript:void(0)">Music</a></li>
                            </ul>
                            </div>
                        </div>-->

                    </div>
                </div>
                <div id="calendarRow" class="row">
                    <div class="col-lg-12">
                        <div id="calendar" class="fc-calendar box-shadow fc fc-ltr fc-unthemed"></div>
                    </div>
                </div>
                <?php } ?>
            </div>    
        </div>
        <script>
        $('.close-btn').click(function(e){
            var closedBox = $(this).closest('div.content-box').remove();
            e.preventDefault();
        });
		$('#clearSearch').click(function(e){
            $('#searchInput').val("");
            $('#resultshere').html("");
            $('#searchInput').focus();
            e.preventDefault();
        });
        
		$(document).on("click", ".openTab", function(e) {
			if($(this).attr("openTab") === "true") {
				var isActive = parent.$("div[data-content-name^='<?php echo strtolower(PLEXTABNAME);?>']");
				var activeFrame = isActive.children('iframe');
				if(isActive.length === 1){
					activeFrame.attr("src", $(this).attr("href"));
					parent.$("li[name='<?php echo strtolower(PLEXTABNAME);?>']").trigger("click");
				}else{
					parent.$("li[name='<?php echo strtolower(PLEXTABNAME);?>']").trigger("click");
					parent.$("div[data-content-name^='<?php echo strtolower(PLEXTABNAME);?>']").children('iframe').attr("src", $(this).attr("href"));
				}
				e.preventDefault();
			}else{
				console.log("nope");
			}

        });
        
            
        function localStorageSupport() {
            return (('localStorage' in window) && window['localStorage'] !== null)
        }

        $( document ).ready(function() {
            $('#plexSearchForm').on('submit', function () {
                var refreshBox = $(this).closest('div.content-box');
                $("<div class='refresh-preloader'><div class='la-timer la-dark'><div></div></div></div>").appendTo(refreshBox).fadeIn(300);
                setTimeout(function(){
                    var refreshPreloader = refreshBox.find('.refresh-preloader'),
                    deletedRefreshBox = refreshPreloader.fadeOut(300, function(){
                        refreshPreloader.remove();
                    });
                },1000);
                ajax_request('POST', 'search-plex', {
                    searchtitle: $('#plexSearchForm [name=search-title]').val(),
                }).done(function(data){ $('#resultshere').html(data);});

            });
            $('.repeat-btn').click(function(){
                var refreshBox = $(this).closest('div.content-box');
                $("<div class='refresh-preloader'><div class='la-timer la-dark'><div></div></div></div>").appendTo(refreshBox).fadeIn(300);
                setTimeout(function(){
                    var refreshPreloader = refreshBox.find('.refresh-preloader'),
                    deletedRefreshBox = refreshPreloader.fadeOut(300, function(){
                        refreshPreloader.remove();
                    });
                },1500);
            });
            $(document).on('click', '.w-refresh', function(){
                var id = $(this).attr("link");
                $("div[np^='"+id+"']").toggle();
            });

            $('div[class*=recentItems-]').each(function() {
                var name = $(this).attr("data-name");
                console.log(name);
                $(this).slick({
                
                    slidesToShow: 13,
                    slidesToScroll: 13,
                    infinite: true,
                    lazyLoad: 'ondemand',
                    prevArrow: '<a class="zero-m pull-left prev-mail btn btn-default waves waves-button btn-sm waves-effect waves-float"><i class="fa fa-angle-left"></i></a>',
                    nextArrow: '<a class="pull-left next-mail btn btn-default waves waves-button btn-sm waves-effect waves-float"><i class="fa fa-angle-right"></i></a>',
                    appendArrows: $('.'+name),
                    arrows: true,
                    responsive: [
                    {
                    breakpoint: 1750,
                    settings: {
                        slidesToShow: 12,
                        slidesToScroll: 12,
                    }
                    },
                    {
                    breakpoint: 1600,
                    settings: {
                        slidesToShow: 11,
                        slidesToScroll: 11,
                    }
                    },
                    {
                    breakpoint: 1450,
                    settings: {
                        slidesToShow: 10,
                        slidesToScroll: 10,
                    }
                    },
                    {
                    breakpoint: 1300,
                    settings: {
                        slidesToShow: 9,
                        slidesToScroll: 9,
                    }
                    },
                    {
                    breakpoint: 1150,
                    settings: {
                        slidesToShow: 8,
                        slidesToScroll: 8,
                    }
                    },
                    {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 7,
                        slidesToScroll: 7,
                    }
                    },
                    {
                    breakpoint: 850,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6,
                    }
                    },
                    {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                    }
                    },
                    {
                    breakpoint: 675,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
                });
            });
            //RECENT ITEMS
            // each filter we click on
            $(".filter-recent-event > li").on("click", function() {
                    
                // toggle the filter on/off
                $(this).data( "filter-on" , !$(this).data("filter-on") );
                
                // set all the filter strings to empty
                var filtersOn = "";
                var filtersOff = "";
                var allFilters = "";
                
                // loop through each filter
                $(".filter-recent-event > li").each(function() {
                    
                    // set a variable to hold the value of the filter class
                    // and also if the filter is on/off
                    var filter = $(this).data("filter");
                    var isOn = $(this).data("filter-on");

                    // add the filter to the filtersOn / filtersOff collection
                    if( isOn ) {
                        filtersOn += "." + filter + ", ";
                    } else {
                        filtersOff += "." + filter + ", ";
                    }

                });
                
                // remove the last ", " from each filter collection.
                filtersOn = filtersOn.replace(/, $/, "");
                filtersOff = filtersOff.replace(/, $/, "");
                
                // remove all filters if none are on.
                if( filtersOn === "" ) {
                    filtersOn = "*";
                    filtersOff = "";
                }
                
                // combine the filters together ( on + off )
                allFilters = filtersOn + ":not(" + filtersOff + ")";
                console.log( allFilters );
                
                // now filter the slides.
                $('.recentItems-recent')
                    .slick('slickUnfilter')
                    .slick('slickFilter' , allFilters );

            });
            //PLAYLIST SHIT
             // each filter we click on
            $(".filter-recent-playlist > li").on("click", function() {
                var name = $(this).attr('data-name');
                var filter = $(this).attr('data-filter');
                $('#playlist-title').text(name);
                
                // now filter the slides.
                $('.recentItems-playlists')
                    .slick('slickUnfilter')
                    .slick('slickFilter' , '.'+filter );

            });

            $("body").niceScroll({
                railpadding: {top:0,right:0,left:0,bottom:0},
                scrollspeed: 30,
                mousescrollstep: 60
            });
            $(".table-responsive").niceScroll({
                railpadding: {top:0,right:0,left:0,bottom:0},
                scrollspeed: 30,
                mousescrollstep: 60
            });

            <?php if((NZBGETURL != "" && qualifyUser(NZBGETHOMEAUTH)) || (SABNZBDURL != "" && qualifyUser(SABNZBDHOMEAUTH))){ ?>
            var queueRefresh = <?php echo DOWNLOADREFRESH; ?>;
            var historyRefresh = <?php echo HISTORYREFRESH; ?>; // This really doesn't need to happen that often

            var queueLoad = function() {
            <?php if(SABNZBDURL != "") { echo '$("tbody.dl-queue.sabnzbd").load("ajax.php?a=sabnzbd-update&list=queue");'; } ?>
            <?php if(NZBGETURL != "") { echo '$("tbody.dl-queue.nzbget").load("ajax.php?a=nzbget-update&list=listgroups");'; } ?>
            };

            var historyLoad = function() {
            <?php if(SABNZBDURL != "") { echo '$("tbody.dl-history.sabnzbd").load("ajax.php?a=sabnzbd-update&list=history");'; } ?>
            <?php if(NZBGETURL != "") { echo '$("tbody.dl-history.nzbget").load("ajax.php?a=nzbget-update&list=history");'; } ?>
            };

            // Initial Loads
            queueLoad();
			historyLoad();

            // Interval Loads
            var queueInterval = setInterval(queueLoad, queueRefresh);
            var historyInterval = setInterval(historyLoad, historyRefresh);

            // Manual Load
            $("#getDownloader").click(function() {
                queueLoad();
                historyLoad();
            });
            <?php } ?>
        });

        $( window ).on( "load", function() {
            $( "ul.filter-recent-playlist > li:first" ).trigger("click");
        });

        </script>
        <?php if ((SONARRURL != "" && qualifyUser(SONARRHOMEAUTH)) || (RADARRURL != "" && qualifyUser(RADARRHOMEAUTH)) || (HEADPHONESURL != "" && qualifyUser(HEADPHONESHOMEAUTH)) || (SICKRAGEURL != "" && qualifyUser(SICKRAGEHOMEAUTH))) { ?>
        <script>
            $(function () {

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                $('#calendar').fullCalendar({
                    eventLimit: false, 
                    firstDay: <?php echo CALENDARSTART;?>,
                    height: "auto",
                    defaultView: '<?php echo CALENDARVIEW;?>',
                    header: {
                        left: 'prev,next,',
                        center: 'title',
                        right: 'today, month, basicDay,basicWeek,'
                    },
                    views: {
                        basicDay: { buttonText: '<?php echo $language->translate("DAY");?>', eventLimit: false },
                        basicWeek: { buttonText: '<?php echo $language->translate("WEEK");?>', eventLimit: false },
                        month: { buttonText: '<?php echo $language->translate("MONTH");?>', eventLimit: false },
                        today: { buttonText: '<?php echo $language->translate("TODAY");?>' },
                    },
                    events: [
<?php 
if (SICKRAGEURL != "" && qualifyUser(SICKRAGEHOMEAUTH)){
	try { 
		echo getSickrageCalendarWanted($sickrage->future());
	} catch (Exception $e) { 
		writeLog("error", "SICKRAGE/BEARD ERROR: ".strip($e->getMessage())); 
	} try { 
		echo getSickrageCalendarHistory($sickrage->history("100","downloaded"));
	} catch (Exception $e) { 
		writeLog("error", "SICKRAGE/BEARD ERROR: ".strip($e->getMessage())); 
	}
}
if (SONARRURL != "" && qualifyUser(SONARRHOMEAUTH)){
	try {
		echo getSonarrCalendar($sonarr->getCalendar($startDate, $endDate)); 
	} catch (Exception $e) { 
		writeLog("error", "SONARR ERROR: ".strip($e->getMessage())); 
	}
}
if (RADARRURL != "" && qualifyUser(RADARRHOMEAUTH)){ 
	try { 
		echo getRadarrCalendar($radarr->getCalendar($startDate, $endDate)); 
	} catch (Exception $e) { 
		writeLog("error", "RADARR ERROR: ".strip($e->getMessage())); 
	}
}
if (HEADPHONESURL != "" && qualifyUser(HEADPHONESHOMEAUTH)){
	echo getHeadphonesCalendar(HEADPHONESURL, HEADPHONESKEY, "getHistory"); 
	echo getHeadphonesCalendar(HEADPHONESURL, HEADPHONESKEY, "getWanted"); 

}?>                                
                    ],
                    eventRender: function eventRender( event, element, view ) {
                        return ['all', event.imagetype].indexOf($('#imagetype_selector').val()) >= 0
                    },

                    editable: false,
                    droppable: false,
					timeFormat: '<?php echo CALTIMEFORMAT; ?>',
                });
            });
            $('#imagetype_selector').on('change',function(){
                $('#calendar').fullCalendar('rerenderEvents');
            })
        </script>
        <?php } ?>
        <script>
            function convertTime(a){
                if(a){
                    var hours = Math.trunc(a/60);
                    var minutes = a % 60;
                    return hours+"h "+minutes+"m";
                }else{
                    return "N/A";
                }
            }
            function convertArray(a, type){
                var result = "";
                var count = 1;
                var color = "";
                $.each( a, function( key, value ) {
                    if (count == 1){ color = "gray"; }else{ color = "gray"; }
                    if(type == "MOVIE"){
                        result += '<span class="label label-'+color+'">'+value['name']+'</span>&nbsp;';
                    }else if(type == "TV"){
                        result += '<span class="label label-'+color+'">'+value+'</span>&nbsp;';
                    }
                    count++;
                });
                return result;
            }
            function convertTrailer(a){
                var result = "";
                var count = 1;
                $.each( a.results, function( key, value ) {
                    if (count == 1){
                        result += '<span id="openTrailer" style="cursor:pointer;width: 100%;display: block;" data-key="'+value['key']+'" data-name="'+value['name']+'" data-site="'+value['site']+'" class="label label-danger"><i class="fa fa-youtube-play" aria-hidden="true"></i> &nbsp;Watch Trailer</span>&nbsp;';
                    }
                    count++;
                });
                return result;
            }
            function convertCast(a){
                var result = "";
                var count = 1;
                $.each( a.cast, function( key, value ) {
                    if( value['profile_path'] ){
                        if (count <= 6){
                            result += '<div class="col-lg-2 col-xs-2"><div class="zero-m"><img style="border-radius:10%;margin-left: auto;margin-right: auto;display: block;" height="50px" src="https://image.tmdb.org/t/p/w150'+value['profile_path']+'" alt="profile"><h5 class="text-center"><strong>'+value['name']+'</strong></h5><h6 class="text-center">'+value['character']+'</h6></div></div>';
                            count++;
                        }
                    }
                });
                return result;
            }
            function whatIsIt(a){
                var what = Object.prototype.toString;
                if(what.call(a) == "[object Array]"){
                    return a[0].fileName;
                }else if(what.call(a) == "[object Object]"){
                    return a.fileName;
                }
            }
            function whatWasIt(a){
                var what = Object.prototype.toString;
                if(what.call(a) == "[object Array]"){
                    return a[0];
                }else if(what.call(a) == "[object Object]"){
                    return a;
                }
            }
            $(document).on('click', "#openTrailer", function(){
                var key = $(this).attr("data-key");
                $('#iFrameYT').html('<iframe id="calendarYoutube" class="embed-responsive-item" src="https://www.youtube.com/embed/'+key+'" allowfullscreen=""></iframe>');
                $('#calendarVideo').modal('show');
            });
            $(document).on('click', "a[class*=ID-]", function(){
                $('#calendarExtra').modal('show');
                var refreshBox = $('#calendarMainID');
                $("<div class='refresh-preloader'><div class='la-timer la-dark'><div></div></div></div>").appendTo(refreshBox).fadeIn(300);
                setTimeout(function(){
                    var refreshPreloader = refreshBox.find('.refresh-preloader'),
                    deletedRefreshBox = refreshPreloader.fadeOut(300, function(){
                        refreshPreloader.remove();
                    });
                },300);
                var check = $(this).attr("class");
                var ID = check.split("--")[1];
                if (~check.indexOf("tvID")){
                    var type = "TV";
                    ajax_request('POST', 'tvdb-get', {
                        id: ID,
                    }).done(function(data){ 
                        if( data.trakt ) {                        
                            $.ajax({
                                type: 'GET',
                                url: 'https://api.themoviedb.org/3/tv/'+data.trakt.tmdb+'?api_key=83cf4ee97bb728eeaf9d4a54e64356a1&append_to_response=videos,credits',
                                cache: true,
                                async: true,
                                complete: function(xhr, status) {
                                    var result = $.parseJSON(xhr.responseText);
                                    if (xhr.statusText === "OK") {
                                        console.log(result);
                                        $('#calendarTitle').text(result.name);
                                        $('#calendarRating').html('<span class="label label-gray"><i class="fa fa-thumbs-up white"></i> '+result.vote_average+'</span>&nbsp;');
                                        $('#calendarRuntime').html('<span class="label label-gray"><i class="fa fa-clock-o white"></i> '+convertTime(whatWasIt(result.episode_run_time))+'</span>&nbsp;');
                                        $('#calendarSummary').text(result.overview);
                                        $('#calendarTagline').text("");
                                        $('#calendarTrailer').html(convertTrailer(result.videos));
                                        $('#calendarCast').html(convertCast(result.credits));
                                        $('#calendarGenres').html(convertArray(result.genres, "MOVIE"));
                                        $('#calendarLang').html(convertArray(result.languages, "TV"));
                                        $('#calendarPoster').attr("src","https://image.tmdb.org/t/p/w300"+result.poster_path);
                                        $('#calendarMain').attr("style","background-size: cover; background: linear-gradient(rgba(25,27,29,.75),rgba(25,27,29,.75)),url(https://image.tmdb.org/t/p/w1000"+result.backdrop_path+");top: 0;left: 0;width: 100%;height: 100%;position: fixed;");
                                        $('#calendarExtra').modal('show');
                                    }
                                }
                            });
                        }else{
                           $('#calendarTitle').text(data.series.seriesName);
                            $('#calendarRating').html('<span class="label label-gray"><i class="fa fa-thumbs-up white"></i> '+data.series.siteRating+'</span>&nbsp');
                            $('#calendarRuntime').html('<span class="label label-gray"><i class="fa fa-clock-o white"></i> '+convertTime(data.series.runtime)+'</span>&nbsp;');
                            $('#calendarSummary').text(data.series.overview);
                            $('#calendarTagline').text("");
                            $('#calendarTrailer').html("");
                            $('#calendarCast').html("");
                            $('#calendarGenres').html(convertArray(data.series.genre, "TV"));
                            $('#calendarLang').html("");
                            $('#calendarPoster').attr("src","https://thetvdb.com/banners/_cache/"+whatIsIt(data.poster));
                            $('#calendarMain').attr("style","background-size: cover; background: linear-gradient(rgba(25,27,29,.75),rgba(25,27,29,.75)),url(ajax.php?a=show-image&image=http://thetvdb.com/banners/"+whatIsIt(data.backdrop)+");top: 0;left: 0;width: 100%;height: 100%;position: fixed;");
                            $('#calendarExtra').modal('show');
                        }
                    });
                }else if (~check.indexOf("movieID")){
                    var type = "MOVIE";
                    $.ajax({
                        type: 'GET',
                        url: 'https://api.themoviedb.org/3/movie/'+ID+'?api_key=83cf4ee97bb728eeaf9d4a54e64356a1&append_to_response=videos,credits',
                        cache: true,
                        async: true,
                        complete: function(xhr, status) {
                            var result = $.parseJSON(xhr.responseText);
                            console.log(result);
                            console.log(convertCast(result.credits));
                            if (xhr.statusText === "OK") {
                                $('#calendarTitle').text(result.title);
                                $('#calendarRating').html('<span class="label label-gray"><i class="fa fa-thumbs-up white"></i> '+result.vote_average+'</span>&nbsp;');
                                $('#calendarRuntime').html('<span class="label label-gray"><i class="fa fa-clock-o white"></i> '+convertTime(result.runtime)+'</span>&nbsp;');
                                $('#calendarSummary').text(result.overview);
                                $('#calendarTagline').text(result.tagline);
                                $('#calendarTrailer').html(convertTrailer(result.videos));
                                $('#calendarCast').html(convertCast(result.credits));
                                $('#calendarGenres').html(convertArray(result.genres, "MOVIE"));
                                $('#calendarLang').html(convertArray(result.spoken_languages, "MOVIE"));
                                $('#calendarPoster').attr("src","https://image.tmdb.org/t/p/w300"+result.poster_path);
                                $('#calendarMain').attr("style","background-size: cover; background: linear-gradient(rgba(25,27,29,.75),rgba(25,27,29,.75)),url(https://image.tmdb.org/t/p/w1000"+result.backdrop_path+");top: 0;left: 0;width: 100%;height: 100%;position: fixed;");
                                $('#calendarExtra').modal('show');
                            }
                        }
                    });
                }
            });
        </script>
        <div id="calendarExtra" class="modal fade in" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg gray-bg" role="document">
                <div id="calendarMainID" class="modal-content">
                    <div class="modal-content" id="calendarMain"></div>
                    <div style="position: inherit; padding: 15px">
                        <span id="calendarRuntime" class="pull-left"></span>
                        <span id="calendarRating" class="pull-left"></span>
                        <span id="calendarGenres" class="pull-right"></span>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <img style="width:100%;border-radius: 10px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" id="calendarPoster" src="">
                            </div>
                            <div class="col-sm-8">
                                <h2 id="calendarTitle" class="modal-title text-center">Modal title</h2>
                                <h6 id="calendarTagline" class="modal-title text-center"><em>Modal title</em></h6>
                                <p id="calendarSummary">Modal Summary</p>
                                <div class="" id="calendarCast">Modal Summary</div>
                            </div>
                        </div>
                    </div>
                   <div style="position: inherit; padding: 15px 0px 30px 0px; margin-top: -20px;">
                        <div class="col-sm-4">
                            <span id="calendarTrailer" class="pull-left" style="width:100%"></span>
                        </div> 
                        <div class="col-sm-8">   
                            <span id="calendarLang" class="pull-right"></span>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div id="calendarVideo" class="modal fade in palette-Grey-900 bg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg gray-bg" role="document">
                <div id="calendarMainVideo" class="modal-content gray-bg">
                    <div class="">
                        <!-- 16:9 aspect ratio -->
                        <div id="iFrameYT" class="embed-responsive embed-responsive-16by9 gray-bg"></div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>