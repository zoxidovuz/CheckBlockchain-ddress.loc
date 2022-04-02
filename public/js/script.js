$(document).ready(function ()
{
	$('#example-multiple-selected').multiselect({
		nonSelectedText: 'Chose tags:'
	});

	$('.search-panel__icon').click(function ()
	{
		if (window.innerWidth <= 800)
		{
			$('.search-panel__input').toggle('.show')
		}
	})
});