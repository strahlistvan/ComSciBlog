var userLang = navigator.language || navigator.userLanguage; 
var str = (userLang.substr(0,2)=="hu")?"Keresés folyamatban... ":"Searching in progress...";
	

function escapeHtml(text) 
{
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}	

function search(key)
{
	var root = document.location.hostname; //maybe it's not enough...
	
	//in localhost:
	//root+="/Comsciblog/public_html"
	
	//console.log(root);

    key = escapeHtml(key);
	$(".key-span").html(key);
	$("#search-result-modal").modal();

	$.post("http://"+root+'/searching',  
			{'key':  key}, 
			function callback(data, status)
			{
				str = (userLang.substr(0,2)=="hu")?"Keresési eredmények: ":"Search results:";
				$("#search-result-content").html("<h4>"+str+"</h4>");
				if (data.length == 0)
				{
					str = (userLang.substr(0,2)=="hu")?"Nincs találat. ":"Not found results.";
					$("#search-result-content").html(str);
					return;
				}
				//If we have result
				for (i in data)
				{
					var link_str = "<a href='http://"+root+"/article/"+data[i].post_id+"/"+encodeURI(data[i].title)+"'>";
					$("#search-result-content").append(link_str+data[i].title+'</a>');
					$("#search-result-content").append(data[i].first_par+"<hr />");
				}
				
				console.log(status);
			},
			'json');
}

$(function(){

	str = (userLang.substr(0,2)=="hu")?"Keresés folyamatban... ":"Searching in progress...";
	
	$("#search-text").keyup(function(event){
		if(event.keyCode == 13){ //13 = Enter code
			$("#search-button").click();
		}
	});
		
	$("#search-button").click(function(){
		$("#search-result-content").html(str);
		var key = $("#search-text").val().trim();
		 if (key!='' && key!=' ')
			search(key);	
	});
	
	$("#search-text-nav").keyup(function(event){
		if(event.keyCode == 13){ //13 = Enter code
			$("#search-button-nav").click();
		}
	});
	
	$("#search-button-nav").click(function(){
		$("#search-result-content").html(str);
		var key = $("#search-text-nav").val().trim();
		if (key!='' && key!=' ')
			search(key);
	});
	
});
