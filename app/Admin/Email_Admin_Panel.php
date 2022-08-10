<?php

use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(App\EmailAdminPanel::class, function (ModelConfiguration $model) {
    $model->setTitle('Test');
// Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table()->setColumns([
            AdminColumn::link('timeline')->setLabel('Timeline'),
        ]);
        $display->paginate(15);
        return $display;
    });

// Create And Edit
    $model->onCreateAndEdit(function () {
        return $form = AdminForm::panel()->addBody([
                AdminFormElement::text('timeline', 'Timeline')->required(),
            ]
        );
    });
});