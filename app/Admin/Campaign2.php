<?php

use App\Campaign;
use App\Campaign_Type;
use App\Campaign_Location;


use SleepingOwl\Admin\Model\ModelConfiguration;
AdminSection::registerModel(Campaign::class, function (ModelConfiguration $model) {
    $model->setTitle('Campaign manager')->setAlias('campaign_manager');
    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::table();
        $display->setFilters([
			AdminDisplayFilter::related('created_by')->setModel(Campaign::class),
		]);

        $display->setApply(function($query) {
		    $query->orderBy('id', 'desc');
		});


        $display->setColumns([
            $countyTitleColumn = AdminColumn::text('campaign_name')->setLabel('Campaign name'),
            $countyTitleColumn = AdminColumn::text('type.gender')->setLabel('Gender'),
        ]);
        $display->paginate(10);



        return $display;
    });
    $model->disableCreating();
    // Create And Edit
    $model->onCreateAndEdit(function($id = null) {
        $display = AdminDisplay::tabbed();
        $display->setTabs(function() use ($id) {
            $tabs = [];
			$campaign_get_params = DB::table('campaign_master')->where('id', $id)->get();

			$s1 = AdminDisplay::tabbed()->setTabs(function() use ($id, $campaign_get_params) {
				$t = [];
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(

				AdminFormElement::columns()->addColumn(function() use ($id, $campaign_get_params) {

					return [
						AdminFormElement::custom()->setDisplay(function() use ($id, $campaign_get_params) {

							$campaign_objectives = DB::table('campaign_objectives')->get();

							return view('step-settings.step-1', ['id' => $id, 'campaign' => $campaign_objectives, 'get_comp' => $campaign_get_params]);
						})->setCallback(function () {})->render(),

				];})))->setLabel('campaign')->setActive();
				return $t;
			});

			$tabs[] = AdminDisplay::tab($s1)->setLabel('Step 1')->setActive();




			$s2 = AdminDisplay::tabbed()->setTabs(function() use ($id) {
				$t = [];
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function() use ($id){
						return [
							AdminFormElement::custom()->setDisplay(function() use ($id) {
								$campaign_master = DB::table('campaign_master')->where('id', $id)->first();
								$campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->first();
								return view('step2.step2_details', ['id' => $id, 'campaign' => $campaign_master, 'campaign_type' => $campaign_type]);
							})->setCallback(function ($instance) { $instance->myField = 12; })->render(),
						];})))->setLabel('Details')->setActive();


				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id) {
						return [
							AdminFormElement::custom()->setDisplay(function() use ($id) {

								$campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->get();
								$campaign_locations = DB::table('campaign_locations')->where('campaign_type_id', $campaign_type[0]->id)->get();

								return view('step2.step2_locations', ['id' => $campaign_type[0]->id, 'campaign_locations' => $campaign_locations]);
							})->setCallback(function ($instance) {})->render(),
						];})))->setLabel('Locations');

				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id) {
						return [
							AdminFormElement::custom()->setDisplay(function() use ($id) {
								$campaign_interests = DB::table('campaign_interests')->get();
								$campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->first();
								if(!empty($campaign_type->interests)){
									$campaign_type = explode(',', $campaign_type->interests);
								}
								return view('step2.step2_interests', ['campaign_interests' => $campaign_interests, 'campaign_type' => $campaign_type]);
							})->setCallback(function ($instance) { $instance->myField = 12; })->render(),
						];
					})))->setLabel('Interests');
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id) {
						return [
							AdminFormElement::custom()->setDisplay(function() use ($id) {
								$keywords = '';
								$campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->first();
								if(!empty($campaign_type->keywords)){
									$keywords = explode(',', $campaign_type->keywords);
								}
								return view('step2.step2_keywords', ['keywords' => $keywords]);
							})->setCallback(function ($instance) {})->render(),
						];
					})))->setLabel('Keywords');

				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id) {
						return [
							AdminFormElement::custom()->setDisplay(function() use ($id) {
								$placements = '';
								$campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->first();
								if(!empty($campaign_type->placements)){
									$placements = explode(',', $campaign_type->placements);
								}
								return view('step2.step2_targetWebsites', ['placements' => $placements]);
							})->setCallback(function ($instance) {})->render(),
						];
					})))->setLabel('Target Websites');
				return $t;
			});

			$tabs[] = AdminDisplay::tab($s2)->setLabel('Step 2');


			$s3 = AdminDisplay::tabbed()->setTabs(function() use ($id, $campaign_get_params) {
				$t = [];
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id, $campaign_get_params) {
					return [

						AdminFormElement::custom()->setDisplay(function() use ($id, $campaign_get_params) {
							$imagesPath = 'http://' . $_SERVER['HTTP_HOST'] . '/images/uploads/';
							$pathDir = 'images/uploads/';
							$getAllImages = scandir($pathDir);
							unset($getAllImages[0]);
							unset($getAllImages[1]);
							return view('step-settings.step-3-logo', ['id' => $id, 'campaign' => $campaign_get_params, 'path' => $imagesPath, 'images' => $getAllImages]);
						})->setCallback(function () {})->render(),

						];
					})))->setLabel('Logo')->setActive();

				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id) {
					return [

						AdminFormElement::custom()->setDisplay(function() use ($id) {

							$campaign_images = DB::table('campaign_images')->where('campaign_id', $id)->get();
							$path = 'http://' . $_SERVER['HTTP_HOST'] . '/images/uploads/';

							return view('step-settings.step-3-images', ['id' => $id, 'campaign' => $campaign_images, 'path' => $path]);
						})->setCallback(function () {})->render(),

						];
					})))->setLabel('Images');


				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use ($id, $campaign_get_params) {
					return [

						AdminFormElement::custom()->setDisplay(function() use ($id, $campaign_get_params) {

							return view('step-settings.step-3-promotion', ['id' => $id, 'campaign' => $campaign_get_params]);
						})->setCallback(function () {})->render(),

						];
					})))->setLabel('Promotion');
				return $t;
			});

			$tabs[] = AdminDisplay::tab($s3)->setLabel('Step 3');




			$s4 = AdminDisplay::tabbed()->setTabs(function() use ($id, $campaign_get_params) {
				$t = [];
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
					AdminFormElement::columns()->addColumn(function () use($id, $campaign_get_params) {
					return [

						AdminFormElement::custom()->setDisplay(function() use ($id, $campaign_get_params) {

							$date = $campaign_get_params[0]->campaign_start_date;
							$finDate = $campaign_get_params[0]->campaign_end_date;
							$campaign_plans = DB::table('campaign_plans')->get();

							return view('step-settings.step-4', ['id' => $id,
																 'campaign_plans' => $campaign_plans,
																 'campaign' => $campaign_get_params,
																 'date' => $date,
																 'findate' => $finDate
																]);
						})->setCallback(function () {})->render(),

				];})))->setLabel('Campaign')->setActive();
				return $t;
			});

			$tabs[] = AdminDisplay::tab($s4)->setLabel('Step 4');



			$s5 = AdminDisplay::tabbed()->setTabs(function() use ($id, $campaign_get_params) {
				$t = [];
				$t[] = AdminDisplay::tab(AdminForm::form()->setItems(
				AdminFormElement::columns()->addColumn(function () use ($id, $campaign_get_params) {
					return [

						AdminFormElement::custom()->setDisplay(function() use ($id, $campaign_get_params) {
							return view('step-settings.step-5', ['id' => $id, 'campaign' => $campaign_get_params]);
						})->setCallback(function () {})->render(),

					];
				})))->setLabel('Pay now')->setActive();

				return $t;
			});

			$tabs[] = AdminDisplay::tab($s5)->setLabel('Step 5');


		//	$tabs[] = AdminDisplay::tab($s)->setLabel('Step 2')->setActive();


            return $tabs;
        });
        return $display;
    });
});