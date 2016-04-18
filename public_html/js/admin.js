/***********************************************
  *  Scripts of the admin interface (Used in admin.blade.php)
************************************************/

var selectedKeywords = [];	  //list of selected keywords (post it to session)
var plus_content = "&nbsp; &times;"; // "decoration"


/** update  post by postID
 *   parameter: postID (integer)
*/
function update(postID)
{
	var postObject;
	if ( isNaN(postID) )
		return;
	//getPostById call (synchronous)
	$.ajax( {
		method: 'post',
		url: 'getPostById',
		data: {'post_id': postID},
		success: function(data, status)
		{
			postObject = data;		
		},
		dataType: 'json',
		async: false,
	});
	 updatePost(postObject); //update the object 
}

/** delete  post by postID
 *   parameter: postID (integer)
*/
function delPost(postID)
{
	var postObject;
		//getPostById call (synchronous)
		$.ajax( {
			method: 'post',
			url: 'getPostById',
			data: {'post_id': postID},
			success: function(data, status)
			{
				postObject = data;
			},
			dataType: 'json',
			async: false,
		});
	 deletePost(postObject); //update the object 
}


/** insert the given post 
  * parameter: blogpost (JSON object)
 */
function updatePost(post)
{
	document.getElementById("update_title").value = post.title;
	tinyMCE.get('update_text').setContent(''); //clear content
	tinyMCE.get('update_text').setContent(post.text); //mceInsertContent
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
	id.value = post.post_id;
	document.forms["updatePostForm"].appendChild(id); 
	
	//Select keywords
	var keywords;
	selectedKeywords = []; // clear selected keywords
	$('#keyword-list2').html(' '); //clear keyword area
	
	$(document).ready(function(){
		$.ajax({
			method: 'post',
			url: 'getKeywords', 
			data: {'post_id' : post.post_id},
			success: function(data, status)
			{
				keywords = data;
			}, 
			dataType: 'json', 
			async: false 
		});
	});
	for (var i in keywords)
	{
		selectedKeywords.push(keywords[i].keyword);
		$('#keyword-list2').append("<span class='label label-default' >"+selectedKeywords[i]+plus_content+" </span>");
	}
	console.log(selectedKeywords);
}


/** Function to delete a post (to ask in a modal)
 *  parameter: blogpost (JSON object)
 */
function deletePost(post)
{
	document.getElementById('delPostTitle').innerHTML = post.title;
	var end = post.text.indexOf('</p>');
	if (end!==-1)
		var firstPar = post.text.substr(3, end);
	else 
		var firstPar = post.text;
	document.getElementById('delPostFirstPar').innerHTML = firstPar;
	document.getElementById('delPostID').value = post.post_id;
}

/** Cateogies */
$(function(){
	$("#add2CatButton").click(function(){
		var postID = $("#postSelect").val();
		var categoryID = $("#categorySelect").val();
		if ( isNaN(postID) || isNaN(categoryID) )
		{
				$("#error-post-cat").show("slow");
				return;
		}
		//Insert post to category 
		$.ajax({
			method: 'post',
			url: 'addToCategory',
			data: {'post_id': postID, 'category_id': categoryID},
			success: function(data, status)
			{
				$("#add-post-title").html(data.post_title);
				$("#add-category-name").html(data.category_name);
				$("#add-post-cat-alert").show("slow");
			},
			dataType: 'json',
		});
	});

	$(".close").click(function(){
		$(".alert").hide("slow");
	});
})

/** Keywords */
$(function(){ 

	selectedKeywords = []; // clear selected keywords
	
	//Type keyword whitch not exists (in new post form)
	$('#addNewKeyword').click(function(){
		var currents = $('#newKeyword').val().trim().split(";");
		for (i in currents)
		{
			currents[i] = currents[i].trim();
			if (selectedKeywords.indexOf(currents[i]) == -1 && currents[i]!='' && currents[i]!=' ')
			{
				selectedKeywords.push(currents[i]);
				$('#keyword-list').append("<span class='label label-default' >"+currents[i]+plus_content+" </span>");
				$.post('addKeyword', {'keywords': selectedKeywords}, function(data, status) { console.log(status); });
			}
		}
	});
	
	//Select keyword from the list (in new post form)
	$('#selectKeyword').change(function(){
		var current = $(this).val().trim();
		if (selectedKeywords.indexOf(current) == -1 && current!='' && current!=' ')
		{
			selectedKeywords.push(current);
			$('#keyword-list').append("<span class='label label-default' > "+current+plus_content+"</span>");
			$.post('addKeyword', {'keywords': selectedKeywords}, function(data, status) { console.log(status); });
		}
	});
	
	//Type keyword whitch not exists (in update form)
	$('#addNewKeyword2').click(function(){
		var currents = $('#newKeyword2').val().trim().split(";");
		for (i in currents)
		{
			currents[i] = currents[i].trim();
			if (selectedKeywords.indexOf(currents[i]) == -1 && currents[i]!='' && currents[i]!=' ')
			{
				selectedKeywords.push(currents[i]);
				$('#keyword-list2').append("<span class='label label-default' >"+currents[i]+plus_content+" </span>");
				$.post('addKeyword', {'keywords': selectedKeywords}, function(data, status) { console.log(status); });
			}
		}
	});
	
	//Select keyword from the list (in update from)
	$('#selectKeyword2').change(function(){
		var current = $(this).val().trim();
		if (selectedKeywords.indexOf(current) == -1 && current!='' && current!=' ')
		{
			selectedKeywords.push(current);
			$('#keyword-list2').append("<span class='label label-default' > "+current+plus_content+"</span>");
			$.post('addKeyword', {'keywords': selectedKeywords}, function(data, status) { console.log(status); });
		}
	});
	
	//Click the keyword label to unselect
	$(document).on('click', 'span.label' , function(){		
		var current = $(this).html();
		var index = current.indexOf('&');
		current = current.substr(0, index);
		$.post('delKeyword', {'keyword': current}, function(data, status) { console.log(data); });
		$(this).detach();
	});
	
	//If we use the select input to modify
	$("#updatePostButton").click(function(){
		var post = JSON.parse($("#postSelect").val());
		if (post && post!="" && post!=" ")
		{
			 $("#updateModal").modal();
			 update(post);
		}
	});
	
	//If we use the select input to delete
	$("#deletePostButton").click(function(){
		var post = JSON.parse($("#postSelect").val());
		if (post && post!="" && post!=" ")
		{
			 $("#deleteModal").modal();
			 update(post);
		}
	});
	
});

/** Image upload script s*/
$(document).on('change', '.btn-file :file', function() {
     var input = $(this);
	 var numFiles = input[0].files ? input[0].files.length : 1;
	 
	 // check images :
	 for (i=0; i<numFiles; ++i)
	 {
		
		var name = input[0].files[i].name;
		var ext = name.substring(name.lastIndexOf('.') + 1).toLowerCase();	
		if (ext!="bmp" && ext!="jpg" && ext!="png" && ext!="gif" )
		{
			$("span.errorFileName").html(name);
			$("#errorFormatPanel").show("slow");
			return;
		}
		//check file size
		var size = input[0].files[i].size;
		console.log(input[0].files[i]);
		if (size > 2000000)
		{
			$("span.errorFileName").html(name);
			$("#errorSizePanel").show("slow");
			return;
		}
		//check filename
		var pattern = /[a-zA-z0-9\-_\.]+/g;
		if ( !pattern.test(name) )
		{
			$("span.errorFileName").html(name);
			$("#errorNamePanel").show("slow");
		}
		
	 }
     var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	 input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
         log = numFiles > 1 ? numFiles + ' images ' : label;
        
        if ( input.length ) 
		{
            input.val(log);
			$("#errorFormatPanel").hide("slow");
			$("#errorImagePanel").hide("slow");
			$("#errorNamePanel").hide("slow");
        }
    });
	$(".close").click(function(){
		$("#errorFormatPanel").hide("slow");
		$("#errorImagePanel").hide("slow");
		$("#errorNamePanel").hide("slow");
	});
});