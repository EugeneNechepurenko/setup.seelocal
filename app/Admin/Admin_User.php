<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(App\AdminUser::class, function (ModelConfiguration $model) {
    $model->setTitle('Admin Users');
// Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::text('name')->setLabel('Name'),
            AdminColumn::text('email')->setLabel('E-mail'),
            AdminColumn::custom()->setLabel('Status')->setCallback(function ($instance) {
                    return $instance->status ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
                })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
        ]);
        $display->paginate(15);
        return $display;
    });
// Create And Edit
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('name', 'Name')->required(),
            AdminFormElement::text('email', 'E-mail')->required(),
            AdminFormElement::text('password', 'Password')->required()->setDefaultValue('********'),
            AdminFormElement::checkbox('status', 'Status')
        );
    });
});


