/**
 * Created by Mahmudul Hasan Dip on 06/05/2017.
 */

$('.message a').click(function(){
    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");


});

$(document).ready(function(){
	$('#pagination-wrap').load("pagination.php");
});
function postNo(noOfPage){
	$('.pagi_class').removeClass("active");
	$("#pagi_id_"+noOfPage).addClass("active");

	$.ajax({
		type: "POST",
		data: {pageNo: noOfPage},
		url: "pagination_posts.php",
		success: function(posts){
			$('#posts').html(posts);
		}
	});
}