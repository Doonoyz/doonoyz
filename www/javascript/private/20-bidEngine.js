$(document).ready(function () {
$('.bidToThis').unbind('click').click(function (event)
    {
		Doonoyz.message.create('Engine_Bid.bidToThis.onclick');
		token = $('#csrfSecurityCode')[0].innerHTML;
		$.get('/ajax/bid', { id : $(this)[0].id}, function (t) {
			try {
				t = JSON.parse(t);
				Doonoyz.message.getInstance('Engine_Bid.bidToThis.onclick').display(t['default']);
			} catch (exception) {
				Doonoyz.message.getInstance('Engine_Bid.bidToThis.onclick').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('Engine_Bid.bidToThis.onclick').display(getString('bigError'));
			}
		});
		return (false);
    });
});