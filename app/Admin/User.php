<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(App\User::class, function (ModelConfiguration $model) {
    $model->setTitle('Users');
// Display
$model->onDisplay(function () {
$display = AdminDisplay::table();

$display->setColumns([
AdminColumn::text('first_name')->setLabel('First Name'),
// AdminColumn::text('last_name')->setLabel('Last Name'),
AdminColumn::text('email')->setLabel('Email'),
AdminColumn::custom()->setLabel('Company')->setCallback(function ($instance) {
$html = $instance->company_name. '<a href="/admin/orders?user_id='.$instance->id.'" class="btn btn-xs btn-default pull-right label-info">Orders</a>';
                $html .= '<a href="/admin/campaign_manager?created_by='.$instance->id.'" class="btn btn-xs btn-default pull-right label-info">Campigns</a>';
                return $html;
}),

AdminColumn::text('phone_number')->setLabel('Phone Number'),
    AdminColumn::custom()->setLabel('Status')->setCallback(function ($instance) {
        return $instance->status ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
    })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
]);


$display->paginate(15);
return $display;
});
// Create And Edit
$model->onCreateAndEdit(function () {
    return $form = AdminForm::panel()->addBody([
        AdminFormElement::text('first_name', 'First name')->required(),
        // AdminFormElement::text('last_name', 'Last name')->required(),
        AdminFormElement::text('company_name', 'Company')->required(),
        AdminFormElement::text('email', 'E-Mail')->required(),
        AdminFormElement::text('phone_number', 'Phone Number')->required(),
        AdminFormElement::text('password', 'Password')->required(),
        AdminFormElement::checkbox('status', 'Status'),
    ]);
});
});