$(document).ready(function(){
	$('#results').hide();
	$('#keyword').keyup(function(){
		let replacekey = $(this).val();
		let keywordval = replacekey.replace(/ /g, '-');
			switch (keywordval) {
			case '':
				$('#results').hide();
				break;
			
			default:
				$('#results').show();
				break;
		}
		$('#results').load('search.php',{
			keyword: keywordval
		});
	});
	$(document).on('click', '#results p', function(){
		$('#keyword').val($(this).text());
		$('#results').hide();
	});
});