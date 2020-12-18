const host = "localhost";

jQuery(document).ready(function($) {
	function search() {
		var formData = {
			'offer_id': $('#offer_id').val(),
			'keyword': $('#keyword').val(),
			'start_date': $('#start_date').val(),
			'end_date': $('#end_date').val(),
			'status': $('#status').val(),
			'city': $('#city').val(),
			'page': $('#page').val()
		}
		$.ajax({
			type: "POST",
			url: "http://"+host+"/internship_finder/offer/searchStudent",
			dataType: 'json',
			cache: false,
			data: formData,
			success: function (data) {
				if (data.result == 'success') {
					if (data.total > 0) {
						$('#total_title').html(data.total + ' Resultados');
						$('.posts-loop').append('<div class="posts-loop-content"></div>');
						$.each(data.info, function(i, item) {
							if (item.selected == 1) {
								var status = 'full-time';
								var status_name = 'No Seleccionado';
								var select_url = 'selectstudent';
								var select_name = 'Seleccionar';
							} else if (item.selected == 2) {
								var status = 'contract';
								var status_name = 'Seleccionado';
								var select_url = 'removestudent';
								var select_name = 'Remover';
							}
							var city = data.cities[item.city];
							var button = data.close ? '' : '<div class="show-view-more"><a class="btn btn-primary" href="http://'+host+'/internship_finder/offer/' + select_url + '/' + item.student_id + '/' + item.offer_id + '">' + select_name + '</a></div>';
							$('.posts-loop-content').append('<article class="noo_job hentry"><div class="loop-item-wrap"><div class="item-featured"><a href="http://'+host+'/internship_finder/offer/student/' + item.student_id + '/' + item.offer_id + '"><img width="50" height="50" src="http://'+host+'/internship_finder/images/avatar/' + item.avatar + '" alt="' + item.user_name + '"></a></div><div class="loop-item-content"><h2 class="loop-item-title"><a href="http://'+host+'/internship_finder/offer/student/' + item.student_id + '/' + item.offer_id + '">' + item.user_name + '</a></h2><p class="content-meta"><span class="job-location"><i class="fa fa-map-marker"></i><a href="http://'+host+'/internship_finder/offer/student/' + item.student_id + '/' + item.offer_id + '"><em>' + city + '</em></a></span><span><time class="entry-date"><i class="fa fa-calendar"></i>' + item.application + '</time></span><span class="job-type ' + status + '"><a href="http://'+host+'/internship_finder/offer/student/' + item.student_id + '/' + item.offer_id + '"><i class="fa fa-bookmark"></i>' + status_name + '</a></span></p></div>' + button + '</div></article>');
						});
						$('.posts-loop').append('<div class="pagination list-center"></div>');
						if (data.current_page != 1) {
							$('.pagination').append('<a class="next page-numbers" href="#" data-target="' + (parseInt(data.current_page) - 1) + '"><i class="fa fa-long-arrow-left"></i></a>');
						}
						for (var i = 1; i <= data.total_pages; i++) {
							var current = data.current_page == i ? ' current' : '';
							$('.pagination').append('<a class="page-numbers' + current + '" href="#" data-target="' + i + '">' + i + '</a>');
						}
						if (data.current_page != data.total_pages) {
							$('.pagination').append('<a class="next page-numbers" href="#" data-target="' + (parseInt(data.current_page) + 1) + '"><i class="fa fa-long-arrow-right"></i></a>');
						}
					} else {
						$('#total_title').html('No hay resultados');
					}
				} else {
					$('#total_title').html('No hay resultados');
				}
			}
		});
	}
	search();
	$('#search-form').submit(function(e) {
		e.preventDefault();
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#keyword').on('keyup', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#city').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#start_date').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#end_date').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#status').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$(document).on('click', '.page-numbers', function(e) {
		e.preventDefault();
		$('#page').val($(this).attr('data-target'));
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
});