<?php
echo doctype('html5');
header("Content-type: text/html; charset=utf-8");

$this->load->library('session');
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/public/bower_components/chosen/chosen.min.css"/>
    <link rel="stylesheet" type="text/css" href="/public/bower_components/fancyBox/source/jquery.fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="/public/bower_components/datetimepicker/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/public/bower_components/jquery-ui/themes/base/all.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/stylesheets/towing.style.css"/>

    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <script src="/public/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/public/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="/public/bower_components/datetimepicker/jquery.datetimepicker.js"></script>

    <script src="/public/bower_components/handlebars/handlebars.min.js"></script>
    <script src="/public/bower_components/chosen/chosen.jquery.min.js"></script>
    <script src="/public/bower_components/fancyBox/source/jquery.fancybox.pack.js"></script>


    <script type="application/javascript">
        $(document).ready(function () {
            $('select').chosen({
                'no_results_text': 'Geen resultaten gevonden',
                'placeholder_text_multiple': 'Selecteer alle opties',
                'placeholder_text_single': 'Selecteer een optie'
            });
        });
    </script>

    <script src="/public/assets/js/towing/towing.js"></script>
    <script src="/public/assets/js/templates.js"></script>

    <style type="text/css">
        .breadcrumbs {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .breadcrumbs div {
            display: inline;
        }

        .breadcrumbs .breadcrum-item-link {
            text-transform: uppercase;
        }

        .breadcrumbs .breadcrum-item-link a {
            text-decoration: none;
            font-weight: bold !important;
            color: #585857;
        }
    </style>

    <title><?php print $title ?></title>
    <?php
    if (isset($css)) {
        foreach ($css as $file) {
            print link_tag('css/' . $file);
        }
    }
    if (!empty($js)) {
        foreach ($js as $file) {
            print '<script type="text/javascript" src="' . $file . '"></script>';
        }
    }

    $_module = 'fast_dossier';

    if ($this->uri->segment(1) === 'commando') {
        $_module = 'commando';
    }
    ?>
</head>

<body>
<div class="l-topbar topbar">
    <div class="l-topbar-content topbar-content">
        <div class="l-branding">
            <div class="logo"></div>
        </div>
        <div class="l-main-search bright">
            <form method="post" action="/<?php print $_module; ?>/search/voucher">
                <input type="text" value="" name="searchVoucherNumber" placeholder="Takelbon zoeken"/>
                <a class="icon--search icon" href="/<?php print $_module; ?>/search"></a>
            </form>
        </div>
        <div class="l-user-navigation">
            <div class="user-navigation bright">
                <!-- div class="l-user-action"><a href="#" class="icon--user"></a></div>
                <div class="l-user-action"><a href="#" class="icon--settings"></a></div -->
                <div class="l-user-action"><a href="/logout/index" class="icon--off"></a></div>
            </div>
        </div>
        <div class="l-main-navigation">
            <nav class="main-navigation">
                <?php if (isset($available_modules) && !empty($available_modules)) : ?>
                    <ul>
                        <?php
                        $urlid = $this->uri->segment(1);

                        foreach ($available_modules as $module) {
                            if (strtoupper($urlid) === $module->code) {
                                printf('<li><a class="active" href="/%s/index">%s</a></li>', strtolower($module->code), $module->name);
                            } else {
                                printf('<li><a href="/%s/index">%s</a></li>', strtolower($module->code), $module->name);
                            }
                        }
                        ?>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>


    </div>
</div>
<div class="container">
    <div class="layout-full">

        <div class="layout-center">
            <?php
            if (isset($error) && $error !== "") {
                printf('<div class="login_messages"><div class="msg msg__error">%s</div></div>', $error);
            }

            if ($this->session->flashdata('_INFO_MSG')) {
                printf('<div class="login_messages"><div class="msg msg__error">%s</div></div>', $this->session->flashdata('_INFO_MSG'));
            }

            print $content;
            ?>
        </div>
    </div>
</div>
</body>
</html>
