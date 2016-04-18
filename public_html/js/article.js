/***********************************************************
  *  Scripts of the public article (blogpost) interface (Used in article.blade.php)
************************************************************/

/** insert the given comment the the update form. 
  * parameter: blog's comment (JSON object)
 */	
function update(comment)
{
	document.getElementById("updateName").value = comment.writer;
	document.getElementById("updateText").value = comment.text;
	//Remove old hidden field (if exists)
	if  (old = document.getElementById('updateID'))
	{ 
		old.parentNode.removeChild(old);
	}
	//make a new input field with the comment_id
	var id = document.createElement('input');
	id.type = 'hidden';
	id.name = 'updateID';
	id.id = 'updateID';
	id.value = comment.comment_id;
	document.forms["updateCommentForm"].appendChild(id); 
}	

function delComment(comment)
{
	document.getElementById('delCommentID').value = comment.comment_id;
}

/* Allow multiple recaptchas in a single page */
var recaptcha1;
var recaptcha2;
var myCallBack = function() {
//Render the recaptcha1 on the element with ID "recaptcha1"
recaptcha1 = grecaptcha.render('recaptcha1', {
     'sitekey' : '6LcWnQoTAAAAACPFyytn6ZoPYtgG8PpcnvMPznYM', 
     'theme' : 'light'
});
        
//Render the recaptcha2 on the element with ID "recaptcha2"
    recaptcha2 = grecaptcha.render('recaptcha2', {
    'sitekey' : '6LcWnQoTAAAAACPFyytn6ZoPYtgG8PpcnvMPznYM', 
    'theme' : 'light'
    });
};


$(function(){
	
	/* Send request for the Google recaptcha (requires jQuery) */
	$("#commentForm").submit(function(){
		$.post('https://www.google.com/recaptcha/api/siteverify', 
				{'secret': '6LcWnQoTAAAAAD_NXtKd_sdboxYUiktTYqOjbrAv', 'response' : 'g-recaptcha-response' },
				function(data, status){
					console.log(status);
					//$.post('https://www.google.com/recaptcha/api/siteverify', {'response': data}, function() {} );
		});
	});
	
});


 