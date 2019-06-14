<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/apple-touch-icon.png')); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/favicon-16x16.png')); ?>">
        <link rel="manifest" href="<?php echo e(asset('images/site.webmanifest')); ?>">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <title><?php echo e(env('APP_NAME')); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/app.css')); ?>">
        <!-- Start of violerts Zendesk Widget script -->
        <script>/*<![CDATA[*/window.zE||(function(e,t,s){var n=window.zE=window.zEmbed=function(){n._.push(arguments)}, a=n.s=e.createElement(t),r=e.getElementsByTagName(t)[0];n.set=function(e){ n.set._.push(e)},n._=[],n.set._=[],a.async=true,a.setAttribute("charset","utf-8"), a.src="https://static.zdassets.com/ekr/asset_composer.js?key="+s, n.t=+new Date,a.type="text/javascript",r.parentNode.insertBefore(a,r)})(document,"script","5fe965bf-5ab7-4b80-bd80-7f62605de9c5");/*]]>*/</script>
        <!-- End of violerts Zendesk Widget script -->
    </head>
    <body>
        <div id="app"></div>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113919167-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-113919167-1');
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcMHBbLvpK26FhSwALwzJMxpEECnmLhbs&libraries=places"></script>
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    </body>
</html>
