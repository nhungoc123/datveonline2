/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     rwd_default
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

function banner(obj) 
{	
	jQuery(obj)
	.cycle({
		slides: '> li',
		speed: 600,
		pauseOnHover: true,
		swipe: true,
		prev: '.slideshow-prev',
		next: '.slideshow-next',
		fx: 'scrollHorz',
	});
}

function createtabs(obj) 
{
	$j(obj).each(function () {
		var wrapper = jQuery(this);

		var dl = wrapper.children('dl:first');
		var dts = dl.children('dt');
		var panes = dl.children('dd');
		var groups = new Array(dts, panes);

		var ul = jQuery('<ul class="toggle-tabs"></ul>');
		dts.each(function () {
			var dt = jQuery(this);
			var li = jQuery('<li></li>');
			li.html(dt.html());
			ul.append(li);
		});
		ul.insertBefore(dl);
		var lis = ul.children();
		groups.push(lis);

		//Add "last" classes.
		var i;
		for (i = 0; i < groups.length; i++) {
			groups[i].filter(':last').addClass('last');
		}

		function toggleClasses(clickedItem, group) {
			var index = group.index(clickedItem);
			var i;
			for (i = 0; i < groups.length; i++) {
				groups[i].removeClass('current');
				groups[i].eq(index).addClass('current');
			}
		}

		lis.on('click', function (e) {
			toggleClasses(jQuery(this), lis);
		});
		// Open the first tab.
		lis.eq(0).trigger('click');
	});
}

function bannercarousel(obj) 
{
	$j(obj).each(function () {
		var wrapper = jQuery(this);

		var dl = wrapper.children('dl:first');
		var dts = dl.children('dt');
		var panes = dl.children('dd');
		var groups = new Array(dts, panes);

		var ul = jQuery('<ul class="toggle-tabs"></ul>');
		dts.each(function () {
			var dt = jQuery(this);
			var li = jQuery('<li></li>');
			li.html(dt.html());
			ul.append(li);
		});
		var _ul = jQuery('<div class="wrap-city"></div>');
		_ul.append(ul);
		_ul.append('<div class="center"><a title="Prev" id="prev" href="javascript: void(0);"><< Prev</a><a title="Next" id="next" href="javascript: void(0);">Next >></a></div>');
		_ul.insertBefore(dl);
		var lis = ul.children();
		groups.push(lis);

		//Add "last" classes.
		var i;
		for (i = 0; i < groups.length; i++) {
			groups[i].filter(':last').addClass('last');
		}

		function toggleClasses(clickedItem, group) {
			var index = group.index(clickedItem);
			var i;
			for (i = 0; i < groups.length; i++) {
				groups[i].removeClass('current');
				groups[i].eq(index).addClass('current');
			}
		}

		lis.on('click', function (e) {
			toggleClasses(jQuery(this), lis);
		});
		// Open the first tab.
		lis.eq(0).trigger('click');
	});
	
	$j(obj+' .wrap-city .toggle-tabs').cycle({
		"carouselVisible" : 5,
		"fx" : "carousel",
		"allowWrap" : false,
		"timeout" : 0,
		"next" : "#next",
		"prev" : "#prev",
		"slideActiveClass" : "active",
		"slides" : "li",
	});
}

function selectCinema(url,formKey,obj)
{
	jQuery('.theatre-tabs li').removeClass('current');
	jQuery(obj).parent('li').addClass('current');
	jQuery.ajax({
		url: url,
		data: {form_key: formKey},
		beforeSend: function(){
			jQuery('.theater-container').children().remove();
			jQuery('.theatre-wrap').append('<div class="waiting"><img src="/skin/frontend/rwd/default/images/opc-ajax-loader.gif"></div>');			
			jQuery('.theatre-wrap .waiting').css('position','absolute');
			jQuery('.theatre-wrap .waiting').css('height','100%');
			jQuery('.theatre-wrap .waiting').css('top','0');
			jQuery('.theatre-wrap .waiting').css('width','100%');
			jQuery('.theatre-wrap .waiting').css('z-index','9999');
			jQuery('.theatre-wrap .waiting img').css('margin','0 auto');
			jQuery('.theatre-wrap .waiting img').css('position','relative');
			jQuery('.theatre-wrap .waiting img').css('top','170px');
		},
	}).done(function(result) {
		var theater = jQuery(result).find( ".theater-container" ).html();		
		jQuery('.theater-container').html(theater);
		banner('.slideshow-theater .slideshow');
		createtabs('.detail-format-film');
		if(jQuery(theater).find( ".theater-session-tabs" ).html()){			
			createtabs('.theater-session-tabs');
		}
		jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		jQuery('.theatre-wrap .waiting').remove();
	});
}
function filterCinema(url,formKey,obj)
{
	jQuery('.theatre-tabs li').removeClass('current');
	jQuery(obj).parent('li').addClass('current');
	jQuery.ajax({
		url: url,
		data: {form_key: formKey},
		beforeSend: function(){
			jQuery('.theater-container').children().remove();
			jQuery('.theatre-wrap').append('<div class="waiting"><img src="/skin/frontend/rwd/default/images/opc-ajax-loader.gif"></div>');			
			jQuery('.theatre-wrap .waiting').css('position','absolute');
			jQuery('.theatre-wrap .waiting').css('height','100%');
			jQuery('.theatre-wrap .waiting').css('top','0');
			jQuery('.theatre-wrap .waiting').css('width','100%');
			jQuery('.theatre-wrap .waiting').css('z-index','9999');
			jQuery('.theatre-wrap .waiting img').css('margin','0 auto');
			jQuery('.theatre-wrap .waiting img').css('position','relative');
			jQuery('.theatre-wrap .waiting img').css('top','170px');
		},
	}).done(function(result) {
		var theater = jQuery(result).find( ".theater-session-tabs" ).html();
		jQuery('.theater-container').append('<div class="heater-head">'+jQuery(result).find( ".heater-head" ).html()+'</div>');
		jQuery('.theater-container').append('<div class="theater-content-tab"><div class="product-collateral toggle-content tabs session-tabs theater-session-tabs">'+theater+'</div></div>');
		if(theater){						
			createtabs('.theatre-wrap .theater-session-tabs');
		}
		jQuery('.theatre-wrap .waiting').remove();
	});
}

function filterMovies(obj,formKey,current)
{
	$j('.collateral-movies-tabs li').removeClass('actived');
	$j(current).addClass('actived');
	$j.ajax({
		url: obj,
		beforeSend: function(){
			$j('.movies-container').children().remove();
			$j('.movies-wrap').append('<div class="waiting"><img src="/skin/frontend/rwd/default/images/opc-ajax-loader.gif"></div>');
			$j('.movies-wrap .waiting').css('position','absolute');
			$j('.movies-wrap .waiting').css('height','100%');
			$j('.movies-wrap .waiting').css('top','0');
			$j('.movies-wrap .waiting').css('width','100%');
			$j('.movies-wrap .waiting').css('z-index','9999');
			$j('.movies-wrap .waiting img').css('margin','0 auto');
			$j('.movies-wrap .waiting img').css('position','relative');
			$j('.movies-wrap .waiting img').css('top','170px');
		},
	}).done(function(result) {			
		var movies_name = $j(result).find( ".product-img-box .product-name" ).text();
		var movies = $j(result).find( ".theatre-city-tabs" ).html();		
		if(movies){						
			$j('.movies-container').append('<div class="heater-head"><div class="page-title movie-title"><h3>'+movies_name+'</h3></div></div>');
			$j('.movies-container').append('<div class="movie-content-tab">'+movies+'</div>');
			createtabs('.movies-wrap .movie-content-tab');
			createtabs('.movies-wrap .session-tabs');
		}
		else {
			$j('.toggle-content.movies-session-tabs').html('<p>This movie don\'t have any session</p>');			
		}
		$j('.movies-wrap .waiting').remove();		
	});
}

function setCinema(i,j,obj)
{
	$j('#session-'+i+'-'+j).find('.area').hide();
	$j('.cinema-'+i+'-'+j).each(function(){
		if($j(this).is(':checked')){
			var checked = $j(this).val();			
			$j('#session-'+i+'-'+j).find('#'+checked).show();
		}
	});	
}

function setMovie(i,obj)
{
	$j('.theatre-wrap #session-'+i).find('.area').hide();
	$j('.theatre-wrap .movie-'+i).each(function(){
		if($j(this).is(':checked')){
			var checked = $j(this).val();			
			$j('.theatre-wrap #session-'+i).find('#'+checked).show();
		}
	});	
}

function togglecontent(obj){
	$j('.'+obj).each(function () {
		var wrapper = jQuery(this);

		var hasTabs = wrapper.hasClass('tabs');

		var dl = wrapper.children('dl:first');
		var dts = dl.children('dt');
		var panes = dl.children('dd');
		var groups = new Array(dts, panes);

		//Create a ul for tabs if necessary.
		if (hasTabs) {
			var ul = jQuery('<ul class="toggle-tabs"></ul>');
			dts.each(function () {
				var dt = jQuery(this);
				var li = jQuery('<li></li>');
				li.html(dt.html());
				ul.append(li);
			});
			ul.insertBefore(dl);
			var lis = ul.children();
			groups.push(lis);
		}

		//Add "last" classes.
		var i;
		for (i = 0; i < groups.length; i++) {
			groups[i].filter(':last').addClass('last');
		}

		function toggleClasses(clickedItem, group) {
			var index = group.index(clickedItem);
			var i;
			for (i = 0; i < groups.length; i++) {
				groups[i].removeClass('current');
				groups[i].eq(index).addClass('current');
			}
		}

		//Toggle on tab (li) click.
		if (hasTabs) {
			lis.on('click', function (e) {
				toggleClasses(jQuery(this), lis);
			});
			//Open the first tab.
			lis.eq(0).trigger('click');
		}
	});
}

function Quickbooking(obj,formKey){
	jQuery.ajax({
		url: obj,
		data: {form_key: formKey},
		beforeSend: function(){
			jQuery.colorbox();
		},
	}).done(function(result) {
		var html = '<div class="movies-list">';
			html += '<div class="product-collateral toggle-content tabs movies-tabs">';
				html +=	'<dl class="collateral-movies-tabs">';
					$j.each(result, function(type,city){
						html +=	'<dt class="tab">';						
							html +=	'<span>'+type+'</span>';
						html += '</dt>';
						
						html += '<dd class="tab-container">';
							
							html += '<div class="tab-content">';
								html += '<div class="theatre-list">';
									html +=	'<div class="product-collateral toggle-content tabs theatre-city-tabs">';
										html +=	'<dl class="collateral-theatre-city-tabs">';
											$j.each(city, function(_city,date){
												html +=	'<dt class="tab">';
													html +=	'<span>'+_city+'</span>';											
												html += '</dt>';
												
												html += '<dd class="tab-container">';
													html +=	'<div class="tab-content">';
														html +=	'<div class="product-collateral toggle-content tabs session-tabs">';
															html +=	'<dl class="collateral-tabs collateral-session-tabs">';
																$j.each(date, function(_date,theaters){
																	var sessiondate = new Date(_date);
																	var d = sessiondate.getDate();
																	var m = sessiondate.getMonth() + 1;
																	if(d < 10){
																		d = '0'+d;
																	}
																	if(m < 10){
																		m = '0'+m;
																	}
																	var d_names = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
																	html += '<dt class="tab">';
																		html +=	'<div class="day">';
																			html += '<span>'+m+'</span>';
																			html += '<em>'+d_names[sessiondate.getDay()]+'</em>';
																			html += '<strong>'+d+'</strong>';
																		html += '</div>';
																	html += '</dt>';
																	
																	html += '<dd class="tab-container">';
																		html += '<div class="tab-content">';
																			html += '<div class="sect-guide">';
																				html += '<div class="descri-timezone">';
																					html += '<ul>';
																						html += '<li><span class="early">Suất chiếu sớm</span></li>';
																					html += '</ul>';
	html += '<p>* Nhấn vào lịch chiếu để đặt vé nhanh.</p>';
																				html += '</div>';
																			html += '</div>';
																			
																			html += '<ul class="session-list">';
																				$j.each(theaters, function(_theater,theater){
																					html += '<li class="area">';
																						html += '<div class="col-theater">';
																							html += '<label>'+theater.title+'</label>'
																						html += '</div>';
																						
																						html += '<div class="col-times">';																							
																							html += '<div class="type-hall">';
																								html += '<div class="info-hall">'+type+'</div>';
																								html += '<div class="info-timetable">';
																									html += '<ul>';
var _session_array = $j.map(theater.session, function(value, index) {
    value.id = index;
    return [value];
});
_session_array.sort(function(a, b)
{
    // a and b will here be two objects from the array
    // thus a[1] and b[1] will equal the names

    // if they are equal, return 0 (no sorting)
    if (a.unix == b.unix) { return 0; }
    if (a.unix > b.unix)
    {
        // if a should come after b, return 1
        return 1;
    }
    else
    {
        // if b should come after a, return -1
        return -1;
    }
});

																						$j.each(_session_array, function(index,session){
																											var room = session.room.toLowerCase();
																											var _room = room.replace(' ', '-');
																											var _class = session.theater+'-'+_room;
																											var booking = session.booking;
																											if(session.early == true){
																												_class += ' early';
																											}
																											var path = location.pathname.split('/');
																											
																											if(theater.booking > 0){
																												var href = location.protocol+'//'+location.host+'/'+path[1]+'/tickets/ticket/index/cinema/'+_theater+'/session/'+session.id;
																											}
																											else {
																												var href = '';
																											}
																											
																											html += '<li class="'+_class+'">';
																												html += '<a href="'+href+'" title="'+session.room+'">';																													
																													html += '<span class="session-detail-time">'+session.time+'</span>';
																													html +=	'<span class="session-detail-meridiem">'+session.meridiem+'</span>'
																												html += '</a>';
																											html += '</li>';
																										});
																									html += '</ul>';
																								html += '</di>';
																							html += '</div>';
																						html += '</div>';
																					html += '</li>';
																				});																				
																			html += '</ul>';
																		html += '</div';
																	html += '</dd>';
																});
															html +=	'</dl>';
														html +=	'</div>';
													html +=	'</div>';
												html +=	'</dd>';
											});											
										html += '</dl>';
									html += '</div>';
								html += '</div>';
							html += '</div>';
						html += '</dd>';
					});
				html += '</dl>';
			html += '</div>';
		html += '</div>';
		jQuery.colorbox({html: '<div class="product-view quick-booking">'+html+'</div>', width:"885px", height:"80%",fixed:true,modal: false});
		togglecontent('movies-tabs');
		togglecontent('theatre-city-tabs');
		togglecontent('session-tabs');
	});
}

function moreView(obj){
	jQuery('.item').removeClass( 'absolute' );
	jQuery(obj).remove(); 
}

function validateForm() {
	var check = false;
	if(parseInt(jQuery('.total-qty').val()) == 0){
		check = true;
		jQuery(".messages_product_view").dialog("destroy");
		jQuery('#messages_product_view').text('Xin vui lòng chọn số lượng vé.');
		jQuery('#messages_product_view').dialog({
			dialogClass: "messages_product_view my-dialog",
			width: 506,
			resizable: false,
			draggable: false,
			close: function (event, ui) {								
				jQuery(this).dialog("destroy");
				jQuery('#messages_product_view').text('');
			},
			modal: true
		});					
	}
	
	if(check == true){
		return false;
	}
}

function sessionPopup(obj){
	var movies = jQuery('.movies-list').html();
	jQuery.colorbox({html: '<div class="product-view quick-booking">'+movies+'</div>', width:"885px", height:"80%",fixed:true,modal: false});
	jQuery('.quick-booking .toggle-tabs').remove();
	$j('.quick-booking .toggle-content').each(function () {
		var wrapper = jQuery(this);

		var hasTabs = wrapper.hasClass('tabs');

		var dl = wrapper.children('dl:first');
		var dts = dl.children('dt');
		var panes = dl.children('dd');
		var groups = new Array(dts, panes);

		//Create a ul for tabs if necessary.
		if (hasTabs) {
			var ul = jQuery('<ul class="toggle-tabs"></ul>');
			dts.each(function () {
				var dt = jQuery(this);
				var li = jQuery('<li></li>');
				li.html(dt.html());
				ul.append(li);
			});
			ul.insertBefore(dl);
			var lis = ul.children();
			groups.push(lis);
		}

		//Add "last" classes.
		var i;
		for (i = 0; i < groups.length; i++) {
			groups[i].filter(':last').addClass('last');
		}

		function toggleClasses(clickedItem, group) {
			var index = group.index(clickedItem);
			var i;
			for (i = 0; i < groups.length; i++) {
				groups[i].removeClass('current');
				groups[i].eq(index).addClass('current');
			}
		}

		//Toggle on tab (li) click.
		if (hasTabs) {
			lis.on('click', function (e) {
				toggleClasses(jQuery(this), lis);
			});
			//Open the first tab.
			lis.eq(0).trigger('click');
		}
	});
}

/* Price format */
function number_format(a, b, c, d)
{
	a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
	e = a + '';
	f = e.split('.');
	if (!f[0]) {
		f[0] = '0';
	}
	if (!f[1]) {
		f[1] = '';
	}
	if (f[1].length < b) {
		g = f[1];
		for (i=f[1].length + 1; i <= b; i++) {
			g += '0';
		}
		f[1] = g;
	}
	if(d != '' && f[0].length > 3) {
		h = f[0];
		f[0] = '';
		for(j = 3; j < h.length; j+=3) {
			i = h.slice(h.length - j, h.length - j + 3);
			f[0] = d + i +  f[0] + '';
		}
		j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
		f[0] = j + f[0];
	}
	c = (b <= 0) ? '' : c;
	return f[0] + c + f[1];
}

function combo(obj)
{
	$j(".ui-dialog-content").dialog("destroy");	
	$j($j(obj).next()).dialog({
		title: $j(obj).attr('title'),
		dialogClass: "my-dialog",
		resizable: false,
		draggable: false,
		close: function (event, ui) {
			$j(this).dialog("destroy");
			$j('.wrapper').removeClass('blur');
		}
	});
	$j('.wrapper').addClass('blur');
}

function plus(obj)
{
	if($j('.total-qty').val() < 8 && parseInt($j(obj).prev().text()) < 8){
		var qty = parseInt($j(obj).prev().text()) + 1;
		var _qty = parseInt($j('.total-qty').val()) + 1;
		
		$j(obj).prev().text(qty);
		$j('.total-qty').val(_qty);
		
		var price = parseInt($j(obj).prev().attr("ticket-price"))*(qty);
		var _price = parseInt($j('.total-price .price').attr("data-total-price"));
		
		$j(obj).parents('tr').find('.ticket-total-price .price').text(number_format(price,0,',','.')+" ₫");
		$j('.total-price .price').attr("data-total-price",_price + parseInt($j(obj).prev().attr("ticket-price")));
		$j('.total-price .price').text(number_format(parseInt($j(obj).prev().attr("ticket-price")) + _price,0,',','.')+" ₫");
		
		var ticketcode = $j(obj).prev().attr("ticket-code");
		
		$j('#ticket-'+ticketcode+'-qty').val(qty);
		$j(obj).nextAll().removeAttr("disabled");
		
		var group = '<li id="ticket-'+ticketcode+'">'
					+ '<div class="ticket-desc">' + $j(obj).prev().attr("ticket-description") +'</div>'
					+ '<div class="ticket-total">' + (qty) +'</div>'
					+ '</li>';
		$j('#ticket-'+ticketcode).remove();
		$j(group).appendTo('.ticket-info-right .ticket-list');
	}	
}

function minus(obj)
{
	if($j('.total-qty').val() > 0 && parseInt($j(obj).next().text()) > 0){
		var qty = parseInt($j(obj).next().text()) - 1;
		var _qty = parseInt($j('.total-qty').val()) - 1;
		
		$j(obj).next().text(qty);
		$j('.total-qty').val(_qty);
		
		var price = parseInt($j(obj).next().attr("ticket-price"))*(qty);
		var _price = parseInt($j('.total-price .price').attr("data-total-price"));
		
		$j(obj).parents('tr').find('.ticket-total-price .price').text(number_format(price,0,',','.')+" ₫");
		$j('.total-price .price').attr("data-total-price",_price - parseInt($j(obj).next().attr("ticket-price")));
		$j('.total-price .price').text(number_format(_price - parseInt($j(obj).next().attr("ticket-price")),0,',','.')+" ₫");
		
		var ticketcode = $j(obj).next().attr("ticket-code");
		
		$j('#ticket-'+ticketcode+'-qty-').val(qty);
		if(qty == 0){
			$j(obj).nextAll().attr("disabled","disabled");
		}
		
		var group = '<li id="ticket-'+ticketcode+'">'
					+ '<div class="ticket-desc">' + $j(obj).next().attr("ticket-description") +'</div>'
					+ '<div class="ticket-total">' + qty +'</div>'
					+ '</li>';
		$j('#ticket-'+ticketcode).remove();
		if(qty > 0){
			$j(group).appendTo('.ticket-info-right .ticket-list');
		}
	}
}

/* Seat map width */
function seatmapWidth(width)
{
	$j('.seats').width(width);		
}

var tickets;
function getTickets(obj)
{
	tickets	= obj;
}

var _total;
function getTotals(obj)
{
	_total	= obj;
}

function seatmapready()
{
	$j.each(tickets , function(key, values){
		$j('.seat').each(function(){
			if($j(this).hasClass('area-'+key) && !$j(this).hasClass('reserved')){
				$j(this).addClass('active');
				$j(this).attr('onclick','selectedseat(this)');
			}
		});
	});
}

// function selectedseat(obj)
// {
	// var area = $j(obj).attr('seat-area');
	// var seat_row = [];
	// var seat_col = [];
	// var seat_no = [];
	// var key = 0;
	// $j.each( _total[area], function( code, value ) {
		// if(_total[area][code]['qty'] > 0 && !$j(obj).attr('ticket-code')){
			// key = code;
			// return false;
		// }
	// });
	
	// if(key > 0){
		// if(_total[area][key]['couple'] > 0){
			// var next = parseInt($j(obj).attr('area-col')) + 1;	
			// var prev = parseInt($j(obj).attr('area-col')) - 1;	
			// var row = parseInt($j(obj).attr('area-row'));
			
			// if(parseInt($j(obj).text()) % 2 == 0){
				// $j(obj).addClass("selected");
				// $j(obj).attr('ticket-code',key);
				// if(parseInt($j(obj).text()) > parseInt($j(obj).prev().text())){
					// $j(obj).prev().addClass("selected");
					// $j(obj).prev().attr('ticket-code',key);
					// if(_total[area][key]['chair'] != ""){
						// seat_no = [_total[area][key]['chair'],$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).prev().text()];
					// }
					// else {
						// seat_no = [$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).prev().text()];
					// }
					
					// if(_total[area][key]['row'] != ""){
						// seat_row = [_total[area][key]['row'],$j(obj).attr('area-row'),$j(obj).prev().attr('area-row')];
					// }
					// else {
						// seat_row = [$j(obj).attr('area-row'),$j(obj).prev().attr('area-row')];
					// }
					
					// if(_total[area][key]['col'] != ""){
						// seat_col = [_total[area][key]['col'],$j(obj).attr('area-col'),$j(obj).prev().attr('area-col')];
					// }
					// else {
						// seat_col = [$j(obj).attr('area-col'),$j(obj).prev().attr('area-col')];
					// }
				// }
				// else {
					// $j(obj).next().addClass("selected");
					// $j(obj).next().attr('ticket-code',key);
					// if(_total[area][key]['chair'] != ""){
						// seat_no = [_total[area][key]['chair'],$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).next().text()];
					// }
					// else {
						// seat_no = [$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).next().text()];
					// }
					
					// if(_total[area][key]['row'] != ""){
						// seat_row = [_total[area][key]['row'],$j(obj).attr('area-row'),$j(obj).next().attr('area-row')];
					// }
					// else {
						// seat_row = [$j(obj).attr('area-row'),$j(obj).next().attr('area-row')];
					// }
					
					// if(_total[area][key]['col'] != ""){
						// seat_col = [_total[area][key]['col'],$j(obj).attr('area-col'),$j(obj).next().attr('area-col')];
					// }
					// else {
						// seat_col = [$j(obj).attr('area-col'),$j(obj).next().attr('area-col')];
					// }
				// }
				
				// _total[area][key]['qty'] = _total[area][key]['qty'] - 2;
			// }
			// else {
				// $j(obj).addClass("selected");
				// $j(obj).attr('ticket-code',key);
				
				// if(parseInt($j(obj).text()) < parseInt($j(obj).prev().text())){
					// $j(obj).prev().addClass("selected");
					// $j(obj).prev().attr('ticket-code',key);
					// if(_total[area][key]['chair'] != ""){
						// seat_no = [_total[area][key]['chair'],$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).prev().text()];
					// }
					// else {
						// seat_no = [$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).prev().text()];
					// }
					
					// if(_total[area][key]['row'] != ""){
						// seat_row = [_total[area][key]['row'],$j(obj).attr('area-row'),$j(obj).prev().attr('area-row')];
					// }
					// else {
						// seat_row = [$j(obj).attr('area-row'),$j(obj).prev().attr('area-row')];
					// }
					
					// if(_total[area][key]['col'] != ""){
						// seat_col = [_total[area][key]['col'],$j(obj).attr('area-col'),$j(obj).prev().attr('area-col')];
					// }
					// else {
						// seat_col = [$j(obj).attr('area-col'),$j(obj).prev().attr('area-col')];
					// }			
				// }
				// else {
					// $j(obj).next().addClass("selected");
					// $j(obj).next().attr('ticket-code',key);
					// if(_total[area][key]['chair'] != ""){
						// seat_no = [_total[area][key]['chair'],$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).next().text()];
					// }
					// else {
						// seat_no = [$j(obj).attr('area-label') + $j(obj).text(),$j(obj).attr('area-label') + $j(obj).next().text()];
					// }
					
					// if(_total[area][key]['row'] != ""){
						// seat_row = [_total[area][key]['row'],$j(obj).attr('area-row'),$j(obj).next().attr('area-row')];
					// }
					// else {
						// seat_row = [$j(obj).attr('area-row'),$j(obj).next().attr('area-row')];
					// }
					
					// if(_total[area][key]['col'] != ""){
						// seat_col = [_total[area][key]['col'],$j(obj).attr('area-col'),$j(obj).next().attr('area-col')];
					// }
					// else {
						// seat_col = [$j(obj).attr('area-col'),$j(obj).next().attr('area-col')];
					// }			
				// }
				
				// _total[area][key]['qty'] = _total[area][key]['qty'] - 2;
			// }
		
			// _total[area][key]['row'] = seat_row.toString();
			// _total[area][key]['col'] = seat_col.toString();
			// _total[area][key]['chair'] = seat_no.toString();
			// _total[area][key]['areanumber'] = $j(obj).attr('area-number');
		// }
		// else {					
			// $j(obj).addClass("selected");
			// $j(obj).attr('ticket-code',key);
			// if(_total[area][key]['chair'] != ""){
				// seat_no = [_total[area][key]['chair'],$j(obj).attr('area-label') + $j(obj).text()];
			// }
			// else {
				// seat_no = [$j(obj).attr('area-label') + $j(obj).text()];
			// }
			
			// if(_total[area][key]['row'] != ""){
				// seat_row = [_total[area][key]['row'],$j(obj).attr('area-row')];
			// }
			// else {
				// seat_row = [$j(obj).attr('area-row')];
			// }
			
			// if(_total[area][key]['col'] != ""){
				// seat_col = [_total[area][key]['col'],$j(obj).attr('area-col')];
			// }
			// else {
				// seat_col = [$j(obj).attr('area-col')];
			// }
						
			// _total[area][key]['qty'] = _total[area][key]['qty'] - 1;
			// _total[area][key]['row'] = seat_row.toString();
			// _total[area][key]['col'] = seat_col.toString();					
			// _total[area][key]['chair'] = seat_no.toString();
			// _total[area][key]['areanumber'] = $j(obj).attr('area-number');
		// }				
		
		// $j('#ticket-row-'+key).val(_total[area][key]['row']);
		// $j('#ticket-col-'+key).val(_total[area][key]['col']);
		// $j('#ticket-seat-'+key).val(_total[area][key]['chair']);
		// $j('#ticket-areanumber-'+key).val(_total[area][key]['areanumber']);		
		// return false;
	// }
	// else {
		// if(!$j(obj).attr('ticket-code')){
			// $j(".ui-dialog-content").dialog("destroy");
			// $j('.popupmessage').text('Bạn đã chọn tất cả các ghế trong phiên đặt vé của bạn. Vui lòng hủy ghế để chọn lại.');
			// $j('.popupmessage').dialog({
				// dialogClass: "my-popupmessage",
				// width: 506,
				// resizable: false,
				// draggable: false,
				// close: function (event, ui) {								
					// $j(this).dialog("destroy");
					// $j('.popupmessage').text('');
				// },
				// modal: true
			// });
		// }
		// else {
			// key = $j(obj).attr('ticket-code');
			
			// $j(".ui-dialog-content").dialog("destroy");
			// $j('.popupmessage').text('Quý khách đồng ý bỏ chọn ghế "'+_total[area][key]['label']+'" ?.');
			// $j('.popupmessage').dialog({
				// dialogClass: "my-popupmessage",
				// width: 506,
				// resizable: false,
				// draggable: false,
				// modal: true,
				// buttons: {
					// "Yes": function() {
						// if(_total[area][key]['qty'] > 0){
							// _total[area][key]['qty'] = _total[area][key]['qty'] + _total[area][key]['chair'].split(',').length;
						// }
						// else {
							// _total[area][key]['qty'] = _total[area][key]['chair'].split(',').length;
						// }
						
						// _total[area][key]['row'] = '';
						// _total[area][key]['col'] = '';					
						// _total[area][key]['chair'] = '';
						
						// var ticket_code = $j(obj).attr('ticket-code');
						
						// $j('.seat').each(function(index,value){
							// if($j(this).attr('ticket-code') == ticket_code){
								// $j(this).removeAttr('ticket-code');
								// $j(this).removeClass("selected");
							// }
						// });	
						
						// $j( this ).dialog( "close" );
					// },
					// "No": function() {
						// $j( this ).dialog( "close" );
					// }
				// }					
			// });
			
			// $j('#ticket-row-'+key).val('');
			// $j('#ticket-col-'+key).val('');
			// $j('#ticket-seat-'+key).val('');
			// $j('#ticket-areanumber-'+key).val('');
		// }
	// }	
// }

// function validateFormseat() {
	// var checkout = false;	
	// var checkqty = false;	
	// $j.each(_total, function( index, value ) {
		// $j.each(value, function( _index, _value ) {
			// if(_total[index][_index]["qty"] > 0){
				// checkqty = true;
				// return false;								
			// } 
			// else {
				// var row = $j('#ticket-row-'+_index).val().split(',');
				// var col = $j('#ticket-col-'+_index).val().split(',');
				// var chair = new Array(row, col);;
				// var check_row = -1;
				
				// if(col.length > 1){					
					// $j.each(row, function(i,n){
						// var next = parseInt(col[i]) + 1;
						// var prev = parseInt(col[i]) - 1;				
						
						// checkout = checkseat(index,n,next,prev);
						// // console.log(checkout);
						// if(checkout == false){
							// return false;
						// }					
					// });
				// }
				// else {
					// var next = parseInt(col[0]) + 1;
					// var prev = parseInt(col[0]) - 1;					

					// checkout = checkseat(index,row[0],next,prev);	
					// // console.log(checkout);					
					// if(checkout == false){
						// return false;
					// }
				// }
			// }
		// });
		
		// if(checkout == false){
			// return false;
		// }
		// else {
			// return true;			
		// }
	// });
	
	// if(checkout == false){
		// if(checkqty == true){
			// $j(".ui-dialog-content").dialog("destroy");
			// $j('.popupmessage').text('Vui lòng chọn đủ theo số lượng ghế quý khách đã yêu cầu.');
			// $j('.popupmessage').dialog({
				// dialogClass: "my-popupmessage",
				// width: 506,
				// resizable: false,
				// draggable: false,
				// modal: true,
				// buttons: {
					// "OK": function() {
						// $j( this ).dialog( "close" );
					// }
				// }
			// });
		// }
		// else {
			// $j(".ui-dialog-content").dialog("destroy");
			// $j('.popupmessage').text('Vui lòng chọn ghế liền nhau.');
			// $j('.popupmessage').dialog({
				// dialogClass: "my-popupmessage",
				// width: 506,
				// resizable: false,
				// draggable: false,
				// modal: true,
				// buttons: {
					// "OK": function() {
						// $j( this ).dialog( "close" );
					// }
				// }					
			// });
		// }
	// }
	// else {
		// $j('.booking-actions .button').attr('disabled','disabled'); 
	// }
	// // return false;
	// return checkout;	
// }

// function checkseat(index,row,next,prev)
// {
	// var _next = parseInt(next) + 1;
	// var _prev = parseInt(prev) - 1;
	
	// if(!$j('#pos-'+index+'-'+row+'-'+prev).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+prev).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+prev).hasClass('selected')){
		// if(!$j('#pos-'+index+'-'+row+'-'+next).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+next).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+next).hasClass('selected')){
			// checkout = true;
			// // checkout = 1;
		// }
		// else {
			// if(!$j('#pos-'+index+'-'+row+'-'+_next).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+_next).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+_next).hasClass('selected')){
				// checkout = false;
				// // checkout = 2;
			// }
			// else {
				// checkout = true;
				// // checkout = 3;
			// }
		// }		
	// }
	// else {
		// if(!$j('#pos-'+index+'-'+row+'-'+_prev).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+_prev).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+_prev).hasClass('selected')){
			// checkout = false;
			// // checkout = 4;
		// }
		// else {
			// if(!$j('#pos-'+index+'-'+row+'-'+next).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+next).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+next).hasClass('selected')){
				// checkout = true;
				// // checkout = 5;
			// }
			// else {
				// if(!$j('#pos-'+index+'-'+row+'-'+_next).attr('area-col') || $j('#pos-'+index+'-'+row+'-'+_next).hasClass('reserved') || $j('#pos-'+index+'-'+row+'-'+_next).hasClass('selected')){
					// checkout = false;
					// // checkout = 6;
				// }
				// else {
					// checkout = true;
					// // checkout = 7;
				// }
			// }
		// }		
	// }
	// return checkout;
// }
