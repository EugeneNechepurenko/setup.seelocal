var set_start_data;
var s_date_s4 = '';
var e_date_s4 = '';
var date_s4 = '';
var tmp_tick = 1;
// var s4_selected_period = '-';
// var time_min = '';
// var time_max = '';
// var time_sub = '';
function updateHandle(el, val) {
	el.textContent = val;
}
function custom_ui(){
	// 	var min = '';
	// 	var max = '';

	// Datepicker Init
	var date = new Date(); 

	var WorkingDaysMax = new Date();
	var WorkingDaysMin = new Date();
	var adjustmentsMax =  [0, 0, 0, 2, 2, 2, 1];// Offsets by day of the week
	var adjustmentsMin =  [0, 0, 0, 0, 0, 2, 1];
	WorkingDaysMax.setDate(WorkingDaysMax.getDate() + 3 + adjustmentsMax[WorkingDaysMax.getDay()]); 
	WorkingDaysMin.setDate(WorkingDaysMin.getDate() + 4 + adjustmentsMin[WorkingDaysMin.getDay()]);

	console.log(WorkingDaysMin);

	var min_day_check = WorkingDaysMin.getDay();
	if(min_day_check == 6){
		WorkingDaysMin.setDate(WorkingDaysMin.getDate() + 1);
	}
	min_day_check = WorkingDaysMin.getDay();
	if(min_day_check == 0){
		WorkingDaysMin.setDate(WorkingDaysMin.getDate() + 1);
	}
	//caltulate +day becouse +4w => add just 3w. and week now
	var day_plus_calendar = WorkingDaysMin.getDay() + 1;
	if(day_plus_calendar == 1){
		day_plus_calendar = day_plus_calendar + 4;
	}else if(day_plus_calendar == 2){
		day_plus_calendar = day_plus_calendar + 3;
	}else if(day_plus_calendar == 3){
		day_plus_calendar = day_plus_calendar + 2;
	}else if(day_plus_calendar == 4){
		day_plus_calendar = day_plus_calendar + 1;
	}else if(day_plus_calendar == 5){
		day_plus_calendar = day_plus_calendar + 3;
	}else if(day_plus_calendar == 6){
		day_plus_calendar = day_plus_calendar + 3;
	}

console.log(WorkingDaysMin);



	set_start_data = $.datepicker.formatDate('dd.mm.yy', new Date(WorkingDaysMin));
	$("#start").html(set_start_data); 

	// if(s4_selected_period != '-'){
	// // 	if(s4_selected_period == 0 || s4_selected_period == 2){
	// // 		min = time_min;
	// // 		max = time_max;
	// // 	}
	// 	if(s4_selected_period == 1){
	// 		min = time_min;
	// 		max = '';
	// 	}
	// }else{
	// 	if(s4_selected_period == 0 || s4_selected_period == 2){
	// 		min = WorkingDaysMin;
	// 		max = "+3d+4w";
	// 	}
	// 	else if(s4_selected_period == 1){
	// 		min = WorkingDaysMin;
	// 		max = '';
	// 	}
	// }

	jQuery('#datepicker-blue').datepicker({ 
		minDate: WorkingDaysMin,  
		dateFormat: "dd.mm.yy",   
		dayNamesShort: ["Sun","Mon","Tues","Wed","Thurs","Fri","Sat"],
		beforeShowDay: jQuery.datepicker.noWeekends,
		onSelect: function(dateText, inst) {
			date_s4 = dateText;
			jQuery("#start").html(dateText); 
		}
	});





	jQuery('#datepicker').datepicker({
		range: 'period', 
		minDate: WorkingDaysMin,
		dateFormat: "dd.mm.yy",
		beforeShowDay: function (date) {
			var adjustmentsMin1 =  [0, 0, 0, 0, 0, 2, 1];

			var add_d = 0;
			var WorkingDaysMin1 = new Date();
			WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + add_d);

			WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 4 + adjustmentsMin1[WorkingDaysMin1.getDay()]);
			var min_day_check = WorkingDaysMin1.getDay();
			if(min_day_check == 6){ WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1); }
			min_day_check = WorkingDaysMin1.getDay();
			if(min_day_check == 0){ WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1); }

			var day_plus_calendar1 = WorkingDaysMin1.getDay() + 1;
			if(day_plus_calendar1 == 1){ day_plus_calendar1 = day_plus_calendar1 + 4; }
			else if(day_plus_calendar1 == 2){ day_plus_calendar1 = day_plus_calendar1 + 3; }
			else if(day_plus_calendar1 == 3){ day_plus_calendar1 = day_plus_calendar1 + 2; }
			else if(day_plus_calendar1 == 4){ day_plus_calendar1 = day_plus_calendar1 + 1; }
			else if(day_plus_calendar1 == 5){ day_plus_calendar1 = day_plus_calendar1 + 3; }
			else if(day_plus_calendar1 == 6){ day_plus_calendar1 = day_plus_calendar1 + 3; }

			var D=new Date();
			var $tmp = WorkingDaysMin1;
			$tmp.setDate(D.getDate() + 27 + day_plus_calendar1);

			if (date.getTime() > $tmp.getTime()) { return [true, 'no_work_days', '']; }
			else if(date.getTime() > WorkingDaysMin1.getTime()){ return [true, 'no_work_days', '']; }
			else if(D.getDay()==0 && D.getDay()==6){ return jQuery.datepicker.noWeekends; }
			else{ return [true, '']; }
		},
		onSelect: function(dateText, inst, extensionRange) {
			// extensionRange - объект расширения
			s_date_s4 = extensionRange.startDateText;
			e_date_s4 = extensionRange.endDateText;
			jQuery('#start').html(extensionRange.startDateText);
			jQuery('#end').html(extensionRange.endDateText);
			rewrite_datapicker(WorkingDaysMin, s_date_s4);
		}
	});



/*
 jQuery('#datepicker').datepicker({
 range: 'period',
 minDate: WorkingDaysMin,
 // maxDate: day_plus_calendar+"d4w",
 dateFormat: "dd.mm.yy",
 // beforeShowDay: jQuery.datepicker.noWeekends,
 beforeShowDay: function (date) {
 var adjustmentsMin1 =  [0, 0, 0, 0, 0, 2, 1];

 var add_d = 0;
 var WorkingDaysMin1 = new Date();
 WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + add_d);

 WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 4 + adjustmentsMin1[WorkingDaysMin1.getDay()]);
 var min_day_check = WorkingDaysMin1.getDay();
 if(min_day_check == 6){ WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1); }
 min_day_check = WorkingDaysMin1.getDay();
 if(min_day_check == 0){ WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1); }

 var day_plus_calendar1 = WorkingDaysMin1.getDay() + 1;
 if(day_plus_calendar1 == 1){ day_plus_calendar1 = day_plus_calendar1 + 4; }
 else if(day_plus_calendar1 == 2){ day_plus_calendar1 = day_plus_calendar1 + 3; }
 else if(day_plus_calendar1 == 3){ day_plus_calendar1 = day_plus_calendar1 + 2; }
 else if(day_plus_calendar1 == 4){ day_plus_calendar1 = day_plus_calendar1 + 1; }
 else if(day_plus_calendar1 == 5){ day_plus_calendar1 = day_plus_calendar1 + 3; }
 else if(day_plus_calendar1 == 6){ day_plus_calendar1 = day_plus_calendar1 + 3; }

 var D=new Date();
 var $tmp = WorkingDaysMin1;
 $tmp.setDate(D.getDate() + 27 + day_plus_calendar1);

 if (date.getTime() > $tmp.getTime()) { return [true, 'no_work_days', '']; }
 else if(date.getTime() > WorkingDaysMin1.getTime()){ return [true, 'no_work_days', '']; }
 else if(D.getDay()==0 && D.getDay()==6){ return jQuery.datepicker.noWeekends; }
 else{ return [true, '']; }
 },
 onSelect: function(dateText, inst, extensionRange) {
 // extensionRange - объект расширения
 s_date_s4 = extensionRange.startDateText;
 e_date_s4 = extensionRange.endDateText;
 jQuery('#start').html(extensionRange.startDateText);
 jQuery('#end').html(extensionRange.endDateText);
 console.log(extensionRange);
 }
 });
*/



	// beforeShowDay: function (date) {
	// 	console.log(date);
	// 	var $tmp = WorkingDaysMin;
	// 	$tmp.setDate()
	// 	selectedDay = date.getTime();
	// 	var d = date.getTime();
	// 	if (d > selectedDay + 1 + 86400000 * 7) {
	// 		return [true, 'ui-state-highlight', ''];
	// 	} else {
	// 		return [true, 'ui-state-highlight', ''];
	// 	}
	// },

 //
 // var D=new Date();
	// n = '1';
	// var num=Math.abs(n);
	// var tem,count=0;
	// var dir= (n<0)? -1: 1;
	// while(count< num){
	// 	D= new Date(D.setDate(D.getDate()+dir));
	// 	if(D.isHoliday())continue;
	// 	tem=D.getDay();
	// 	if(tem!=0 && tem!=6) ++count;
	// }
	// console.log(D);
	// 	// return D;

	jQuery("#start").html(datepicker.minDate);

	jQuery(".time.blue").on("click", function(){
		jQuery(".table-campaign").removeClass("green-cell").addClass("blue-cell");
		jQuery("#datepicker").removeClass("green-picker").addClass("blue-picker");
		jQuery( "#datepicker").hide();
		jQuery("#datepicker-blue").show();
	    jQuery("#start").html(date.getDate() + 4+ '.0' + (Number(date.getMonth())+1) + '.' + date.getFullYear());
	    jQuery("#end").html(""); 
	});

	jQuery(".time.orange").on("click", function(){
		jQuery(".table-campaign").removeClass("green-cell blue-cell");
		jQuery("#datepicker").removeClass("green-picker blue-picker");
		jQuery( "#datepicker").show();
		jQuery("#datepicker-blue").hide();
	});

	jQuery(".time.green").on("click", function(){
		jQuery(".table-campaign").removeClass("blue-cell").addClass("green-cell");
		jQuery("#datepicker").removeClass("blue-picker").addClass("green-picker");
		jQuery( "#datepicker").show();
		jQuery("#datepicker-blue").hide();
	});
}


function formatDate(date) {
	var d = new Date(date),
	month = '' + (d.getMonth() + 1),
	day = '' + d.getDate(),
	year = d.getFullYear();
	year = year.toString();
	year = year.slice(2,4);
	
	if (month.length < 2) month = '0' + month;
	if (day.length < 2) day = '0' + day;
	
	return [day, month, year].join('-');
}


function rewrite_datapicker(WorkingDaysMin, s_date_s4){
console.log(tmp_tick);
	if(tmp_tick == 0) {
		console.log('function rewrite Calendar!');
		// console.log(s_date_s4);

		var tmp = s_date_s4.split(".");
		tmp = new Date(tmp[2], tmp[1] - 1, tmp[0]);

		jQuery('#datepicker').html('').removeClass('hasDatepicker');
		jQuery('#datepicker').datepicker({
			range: 'period',
			minDate: WorkingDaysMin,
			dateFormat: "dd.mm.yy",
			beforeShowDay: function (date) {
				var adjustmentsMin1 = [0, 0, 0, 0, 0, 2, 1];

				var add_d = 0;
				var WorkingDaysMin1 = new Date();
				WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + add_d);

				WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 4 + adjustmentsMin1[WorkingDaysMin1.getDay()]);
				var min_day_check = WorkingDaysMin1.getDay();
				if (min_day_check == 6) {
					WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1);
				}
				min_day_check = WorkingDaysMin1.getDay();
				if (min_day_check == 0) {
					WorkingDaysMin1.setDate(WorkingDaysMin1.getDate() + 1);
				}

				var day_plus_calendar1 = WorkingDaysMin1.getDay() + 1;
				if (day_plus_calendar1 == 1) {
					day_plus_calendar1 = day_plus_calendar1 + 4;
				}
				else if (day_plus_calendar1 == 2) {
					day_plus_calendar1 = day_plus_calendar1 + 3;
				}
				else if (day_plus_calendar1 == 3) {
					day_plus_calendar1 = day_plus_calendar1 + 2;
				}
				else if (day_plus_calendar1 == 4) {
					day_plus_calendar1 = day_plus_calendar1 + 1;
				}
				else if (day_plus_calendar1 == 5) {
					day_plus_calendar1 = day_plus_calendar1 + 3;
				}
				else if (day_plus_calendar1 == 6) {
					day_plus_calendar1 = day_plus_calendar1 + 3;
				}

				var D = new Date();
				// var D = tmp;
				var $tmp = WorkingDaysMin1;
				// console.log($tmp);
				$tmp.setDate(D.getDate() + 27 + day_plus_calendar1);
				// console.log(D.getDate() + 27 + day_plus_calendar1);
				//
				var tmp_range = new Date(tmp.getTime());
				// console.log(tmp_range.getDate());
				tmp_range.setDate(tmp_range.getDate() + 27);
				// console.log(tmp_range);
				// console.log(tmp);

				// console.log(date.getTime() + ' ' + date);
				// console.log(tmp_range.getTime() + ' ' + tmp_range);


				if (date.getTime() > tmp_range.getTime()) {
					// console.log('1 ' + date);
					return [true, 'no_work_days', ''];
				}

				// else if(date.getTime() > WorkingDaysMin1.getTime()){
				//     // console.log('2 '+date);
				//     return [true, 'no_work_days', ''];
				// }
				//
				//
				else if (D.getDay() == 0 && D.getDay() == 6) {
					// console.log('3 '+date);
					return jQuery.datepicker.noWeekends;
				}
				else {
					// console.log('4 '+date);
					return [true, ''];
				}
			},
			onSelect: function (dateText, inst, extensionRange) {
				s_date_s4 = extensionRange.startDateText;
				e_date_s4 = extensionRange.endDateText;
				jQuery('#start').html(extensionRange.startDateText);
				jQuery('#end').html(extensionRange.endDateText);
				rewrite_datapicker(WorkingDaysMin, s_date_s4);
			}
		});
		$('#datepicker').datepicker('setDate', [tmp,tmp]);
		tmp_tick = 1;
	}
	// else if(tmp_tick == 1){
	// 	var tmp = s_date_s4.split(".");
	// 	tmp = new Date(tmp[2], tmp[1] - 1, tmp[0]);
	// 	$('#datepicker').datepicker('setDate', [tmp]);
    //
	// 	tmp_tick = 2;
	// }
	else if(tmp_tick == 1){
		tmp_tick = 0;
	}


}



























$(document).on('click','.video-play',function(){
	$('body').addClass('jj');
	disblekeypress();

	$('#light').fadeIn(600);
	$('#fade').fadeIn(600);
});
$(document).on('click','.video-close',function(){
	$('#light').fadeOut(600);
	$('#fade').fadeOut(600);
	activekeypress();
});
// On click Esc key Disabled Popup
$(document).on('keyup',function(evt) {

	if (evt.keyCode == 27) {
		//  if (evt.which == 27) {
		$('#light').fadeOut(600);
		$('#fade').fadeOut(600);
	}

});
function disblekeypress() {


	$("body.jj").on("keyup", function(e){
		if (e.which === 27){
			return false;
		}
	});

}
function activekeypress() {

	$("body").on("keyup", function(e){
		if (e.which === 27){
			alert("awesome");
			return true;
		}
	});

}
//On click Overlay hide Popup....
$(document).on('click','.black_overlay',function(){
	activekeypress();
	$('#light').fadeOut(600);
	$('#fade').fadeOut(600);

});
      