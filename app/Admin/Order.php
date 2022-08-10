<?php

use SleepingOwl\Admin\Model\ModelConfiguration;
//use SleepingOwl\Admin\Facades\FormElement;
//use SleepingOwl\Admin\Facades\Form;
//use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Facades\Display;
use SleepingOwl\Admin\Facades\Form;
use SleepingOwl\Admin\Facades\FormElement;
use SleepingOwl\Admin\Facades\Navigation;

/*
AdminSection::registerModel(\App\Order::class, function (ModelConfiguration $model) {
    $model->setTitle('Campaign Plans');
// Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('transection_id')->setLabel('Transaction ID'),
            AdminColumn::text('price')->setLabel('Amount'),
        ]);
        $display->paginate(15);
        return $display;
    });
// Create And Edit
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
          //  AdminFormElement::text('title', 'Title')->required(),
          //  AdminFormElement::textAddon('price_0', 'Price')->setAddon('£')->required()
        );
    });
});
*/
AdminSection::registerModel(App\Order::class, function (ModelConfiguration $model) {
    $model->setTitle('Orders');
// Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
$display->setFilters([
AdminDisplayFilter::related('user_id')->setModel(App\Order::class),
]);
        $display->setColumns([
            AdminColumn::text('price')->setLabel('price')
        ]);
        $display->paginate(15);
        return $display;
    });
// Create And Edit
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::tabbed()->addBody(
            AdminFormElement::text('price', 'price')->required()
        );
    });
});

AdminSection::registerModel(App\Campaign::class, function (ModelConfiguration $model) {
    $model->setTitle('Campaign');
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('campaign_name')->setLabel('campaign_name')
        ]);
        $display->paginate(15);
        return $display;
    });
// Create And Edit
// Create And Edit
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('campaign_name', 'Campaign Name')->required(),
            AdminFormElement::text('campaign_type', 'campaign_type')->required(),
            AdminFormElement::text('campaign_plan', 'campaign_plan')->required()

        );
    });
});
//AdminFormElement::text('campaign_name', 'campaign_name')->required()
/*

        $display = Form::tabbed();

        $display->items(function ()
        {
            $tabs = [];

            $firstTab = AdminDisplay::table();
            // configure first tab display
            $tabs[] = AdminDisplay::tab($firstTab)->label('First Tab')->active(true);

            $secondTab = AdminDisplay::datatables();
            // configure second tab display
            $tabs[] = AdminDisplay::tab($secondTab)->label('Second Tab');

            $thirdTab = Admin::model('App\MyOtherModel')->display();
            // this tab will be display from 'App\MyOtherModel' configuration
            $tabs[] = AdminDisplay::tab($thirdTab)->label('Third Tab');

            return $tabs;
        });


        return $display;
*/