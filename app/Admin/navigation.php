<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
//     return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
//    $page
//        ->addPage()
//        ->setTitle('Dashboard')
//        ->setUrl(route('admin.dashboard'))
//        ->setPriority(100);
//
//    $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
    
    [
        'title'    => 'Campaign Plans',
        'icon'  => 'fa fa-exclamation-circle',
        'model'    => \App\Campaign_Plan::class
    ],
    [
        'title'    => 'Campaign Manager',
        'icon'  => 'fa fa-exclamation-circle',
        'model'    => \App\Campaign::class
    ],
   
[
        'title'    => 'Admin Users',
        'icon'  => 'fa fa-user-md',
        'model'    => \App\AdminUser::class
    ],
/*[
        'title'    => 'Orders',
        'icon'  => 'fa fa-user-md',
        'model'    => \App\Order::class
    ],*/
    [
        'title'    => 'Users',
        'icon'  => 'fa fa-users',
        'model'    => \App\User::class
    ],

//    [
//        'title'    => 'Test',
//        'icon'  => 'fa fa-users',
//        'model'    => \App\EmailAdminPanel::class
//    ],

    [
        'title' => 'Exit',
        'icon'  => 'fa fa-power-off',
        'Priority'  => '1000',
        'url'   => route('admin.exit'),
    ],
   
];