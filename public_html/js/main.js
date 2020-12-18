const host = "localhost";

jQuery(document).ready(function($) {
	function search() {
		var careers = $('input[name="careers[]"]:checked').map(function() {
	        return this.value;
	    }).get();
	    var workareas = $('input[name="workareas[]"]:checked').map(function() {
	        return this.value;
	    }).get();
	    var benefits = $('input[name="benefits[]"]:checked').map(function() {
	        return this.value;
	    }).get();
		var formData = {
			'user_id': $('#user_id').val(),
			'keyword': $('#keyword').val(),
			'page': $('#page').val(),
			'offer_type': $('#offer_type').val(),
			'start_date': $('#start_date').val(),
			'end_date': $('#end_date').val(),
			'city': $('#city').val(),
			'workareas': workareas,
			'careers': careers,
			'benefits': benefits
		}
		$.ajax({
			type: "POST",
			url: "http://"+host+"/internship_finder/offer/searchOffer",
			dataType: 'json',
			cache: false,
			data: formData,
			success: function (data) {
				if (data.result == 'success') {
					if (data.total > 0) {
						$('#total_title').html(data.total + ' Resultados');
						$('.posts-loop').append('<div class="posts-loop-content"></div>');
						var today = new Date();
						$.each(data.info, function(i, item) {
							var offer_type = (item.offer_type == 1) ? 'full-time' : 'part-time';
							var offer_type_name = (item.offer_type == 1) ? 'PP' : 'PV';
							var publication = item.publication == null ? '-' : item.publication;
							var end = item.end == null ? '-' : item.end;
							var city = data.cities[item.city];
							var status = '';
							if (item.publication_date == null) {
								status = '<span class = "rojo">Borrador</span>';
							} else if (item.publication_date != null && item.close_date == null && (item.end_date * 1000) < today.getTime()) {
								status = '<span class = "verde">Receptando Estudiantes</span>';
							} else if (item.publication_date != null && item.close_date == null && (item.end_date * 1000) > today.getTime()) {
								status = '<span class = "verde">Proceso de Selección</span>';
							} else if (item.publication_date != null && item.close_date != null) {
								status = '<span class = "rojo">Proceso Finalizado</span>';
							}
							$('.posts-loop-content').append('<article class="noo_job hentry"><div class="loop-item-wrap"><div class="item-featured"><a href="#"><img width="50" height="50" src="http://'+host+'/internship_finder/images/avatar/' + item.avatar + '" alt="' + item.user_name + '"></a></div><div class="loop-item-content"><h2 class="loop-item-title"><a href="http://'+host+'/internship_finder/offer/offerdetail/' + item.offer_id + '">' + item.offer_title + '</a></h2><p class="content-meta"><span class="job-company"><a href="http://'+host+'/internship_finder/offer/offerdetail/' + item.offer_id + '">' + item.user_name + '</a></span><br><span class="job-type ' + offer_type + '"><a href="http://'+host+'/internship_finder/offer/offerdetail/' + item.offer_id + '"><i class="fa fa-bookmark"></i>' + offer_type_name + '</a></span><span class="job-location"><i class="fa fa-map-marker"></i><a href="http://'+host+'/internship_finder/offer/offerdetail/' + item.offer_id + '"><em>' + city + '</em></a></span><span><br><time class="entry-date"><i class="fa fa-calendar"></i>' + publication + ' / ' + end + '</time></span>' + status + '</p></div><div class="show-view-more"><a class="btn btn-primary white" href="http://'+host+'/internship_finder/offer/offerdetail/' + item.offer_id + '">Ver Oferta</a></div></div></article>');
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
/*
	$('#keyword').on('keyup', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('#offer_type').on('change', function() {
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
	$('input[name="careers[]"]').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('input[name="workareas[]"]').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
	$('input[name="benefits[]"]').on('change', function() {
		$('#page').val(1);
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
*/
	$(document).on('click', '.page-numbers', function(e) {
		e.preventDefault();
		$('#page').val($(this).attr('data-target'));
		$('.posts-loop-content').remove();
		$('.pagination').remove();
		search();
	});
});