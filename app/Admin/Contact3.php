<?php

use App\Model\Contact3;
use App\Model\Type;


use App\Campaign_Objective;
use App\Campaign;


use SleepingOwl\Admin\Model\ModelConfiguration;
AdminSection::registerModel(Contact3::class, function (ModelConfiguration $model) {
    $model->setTitle('Contacts')->setAlias('contacts');
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->setColumns([
            $countyTitleColumn = AdminColumn::text('campaign_name')->setLabel('campaign_name'),
            $countyTitleColumn = AdminColumn::text('type.gender')->setLabel('111'),
        ]);
        $display->paginate(10);
        return $display;
    });
    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {

        $display = AdminDisplay::tabbed();
        $display->setTabs(function() use ($id) {
            $tabs = [];

			$s = AdminDisplay::tabbed();
				$ii = 'dsa';
			$s->setTabs(function() use ($id,$ii) {
				$t = [];


				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function()
					{//print_r(AdminFormElement::text('type', '1111111111111111'));
					return [

					//AdminFormElement::text('type.gender', '1111111111111111')->toArray()),
						AdminFormElement::text('campaign_name', 'Campaing name'),

						AdminFormElement::text('campaign_phone', 'Phone number'),
						AdminFormElement::text('campaign_phone', 'Age'),
						AdminFormElement::select('campaign_phone', 'Genders')->setOptions([1 => 'Male', 2 => 'Female', 3 => 'Male & Females']),
						AdminFormElement::text('campaign_phone', 'Realtio'),
						AdminFormElement::text('campaign_phone', 'Language'),
						AdminFormElement::select('campaign_name', 'Relationship status')->setOptions(['single' => 'Single',
																									'married' => 'Married',
																									'all' => 'Single & Married']),
						AdminFormElement::text('campaign_phone', 'Job title targeting')
					];}))
				)->setLabel('Details')->setActive();


				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function() { return [
						AdminFormElement::text('campaign_name', 'Location'),
						AdminFormElement::text('campaign_phone', 'Target towns/cities'),
						AdminFormElement::text('campaign_phone', 'Postcode(s) optional'),

						AdminFormElement::text('campaign_phone', 'Mile radius')
					];}))
				)->setLabel('Location');

				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function() { return [
						AdminFormElement::multiselect('campaign_name', 'Selected Interests')->setOptions(['single' => 'Single',
						'married' => 'Married',
						'all' => 'Single & Married'])

					];}))
				)->setLabel('Interests');






















				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function() use ($id,$ii) {

							return [
						AdminFormElement::custom()->setDisplay(function() use ($id,$ii){
																 //$data = App\Campaign_Objective::all();
																 $data = 'gfd';
																 $data2 = $ii;
																	return view('test_f', ['instance' => 'dfsadsadsafasdfdsfdsf','data' => $data,'data' => $data2]);
																})->setCallback(function ($instance)
																	{
																		$instance->myField = 12;
																	})->render(),
					/*AdminFormElement::view('test_f'),*/
				AdminColumn::text('title')


					];}))
				)->setLabel('Keywords');

				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function() { return [
						AdminFormElement::text('campaign_name', 'Campaing name'),
						AdminFormElement::text('campaign_phone', 'Phone number'),
						AdminFormElement::text('campaign_phone', 'Age'),
						AdminFormElement::text('campaign_phone', 'Genders'),
						AdminFormElement::text('campaign_phone', 'Realtio'),
						AdminFormElement::text('campaign_phone', 'Language'),
						AdminFormElement::text('campaign_phone', 'Relationship status'),
						AdminFormElement::text('campaign_phone', 'Job title targeting')
					];}))
				)->setLabel('Target Websites');




				return $t;
			});


			$tabs[] = AdminDisplay::tab($s)->setLabel('Step 1')->setActive();
/*
			$s1 = AdminDisplay::tabbed()->setTabs(function() use ($id) {
				$s1t = [];
				$t3 = AdminForm::form()->setItems(AdminFormElement::columns()->addColumn(function() { return [
					AdminFormElement::text('campaign_name', 'campaign_name')->required(),
					AdminFormElement::text('campaign_phone', 'campaign_phone')->required()
				];}));
				$s1t[] = AdminDisplay::tab($t3)->setLabel('Detail2s')->setActive();

				$t3 = AdminForm::form()->setItems(AdminFormElement::columns()->addColumn(function() { return [
					AdminFormElement::text('campaign_type', 'campaign_type')->required(),
					AdminFormElement::text('campaign_plan', 'campaign_plan')->required()
				];}));
				$s1t[] = AdminDisplay::tab($t3)->setLabel('Location2');

				return $s1t;
			});


			$tabs[] = AdminDisplay::tab($s1)->setLabel('Step 02');



















				$tabs[] = AdminDisplay::tab(AdminForm::form()->setItems(AdminFormElement::columns()
				->addColumn(function() {
					return [
					AdminFormElement::text('campaign_name', 'Objective')->required()
					];
				}))
				)->setLabel('Step 1')->setActive();kl
*/

                $step_2 = AdminForm::form();
                $step_2->setItems(
                    AdminFormElement::columns()
                        ->addColumn(function() {
                            return [
                                AdminFormElement::text('photo', 'Campaing name'),
                                AdminFormElement::text('photo', 'Phone number'),
                                AdminFormElement::text('photo', 'Age'),
                                AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                            ];
                        })->addColumn(function() {
                            return [
                                AdminFormElement::text('country.title', 'Country title')->required(),
                                AdminFormElement::textarea('comment', 'Comment'),
                            ];
                        })
                );
                $tabs[] = AdminDisplay::tab($step_2)->setLabel('Step 2');

                $step_3 = AdminForm::form();
                $step_3->setItems(
                    AdminFormElement::columns()
                        ->addColumn(function() {
                            return [
                                AdminFormElement::image('photo', 'Photo'),
                                AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                            ];
                        })->addColumn(function() {
                            return [
                                AdminFormElement::text('country.title', 'Country title')->required(),
                                AdminFormElement::textarea('comment', 'Comment'),
                            ];
                        })
                );
                $tabs[] = AdminDisplay::tab($step_3)->setLabel('Step 3');

                $step_4 = AdminForm::form();
                $step_4->setItems(
                    AdminFormElement::columns()
                        ->addColumn(function() {
                            return [
                                AdminFormElement::image('photo', 'Photo'),
                                AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                            ];
                        })->addColumn(function() {
                            return [
                                AdminFormElement::text('country.title', 'Country title')->required(),
                                AdminFormElement::textarea('comment', 'Comment'),
                            ];
                        })
                );
                $tabs[] = AdminDisplay::tab($step_4)->setLabel('Step 4');

                $step_5 = AdminForm::form();
                $step_5->setItems(
                    AdminFormElement::columns()
                        ->addColumn(function() {
                            return [
                                AdminFormElement::image('photo', 'Photo'),
                                AdminFormElement::date('birthday', 'Birthday')->setFormat('d.m.Y'),
                            ];
                        })->addColumn(function() {
                            return [
                                AdminFormElement::text('country.title', 'Country title')->required(),
                                AdminFormElement::textarea('comment', 'Comment'),
                            ];
                        })
                );
                $tabs[] = AdminDisplay::tab($step_5)->setLabel('Step 5');

            return $tabs;
        });
        return $display;
    });
});