<?php

 PackageManager::load('admin-default')
    ->js('jQuery', resources_url('js/jquery.min.js'))
    ->js('custom-js', resources_url('js/custom.js'))
    ->js('jquery-ui-js', resources_url('js/jquery-ui.js'))
    ->js('custom_datepicker-js', resources_url('js/custom_datepicker.js'))
    ->css('jquery-ui-css', resources_url('css/jquery-ui.css'))
    ->css('custom-css', resources_url('css/custom.css'));
