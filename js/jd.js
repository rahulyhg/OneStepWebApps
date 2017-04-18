function test(id,cchars){
	$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
	$.ajax({
			url:'../chat/getAllMsg',
			type:'POST',
			data:'get_all_msg=true&user=' + id ,
			success:function(data){				
				//$("#jd-chat2").find(".jd-user2:first .jd-body2").append("<div class='me2'> " + data + "</div>");
				if(cchars == "last"){
					$("#"+id+".jd-body2").html("<a onclick='test("+id+");'>Load All Messages</a>");
					$("#"+id+".jd-body2").append("<div class='me2'> " + data + "</div>");
				}else{
					$("#"+id+".jd-body2").html("<div class='me2'> " + data + "</div>");
					//$("#jd-chat2").find(".jd-user2:first .jd-body2").append("<div class='me2'> " + data + "</div>");
				}
				$("#msg").val('');
				jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
			}
		});
}
function stackoverflow_removeArrayItem(array, itemToRemove) {
	$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
    // Count of removed items
    var removeCounter = 0;
    // Iterate every array item
    for (var index = 0; index < array.length; index++) {
        // If current array item equals itemToRemove then
        if (array[index] === itemToRemove) {
            // Remove array item at current index
            array.splice(index, 1);

            // Increment count of removed items
            removeCounter++;

            // Decrement index to iterate current position 
            // one more time, because we just removed item 
            // that occupies it, and next item took it place
            index--;
        }
    }
    // Return count of removed items
    return removeCounter;
}
var count_user = 0;
var chat_user = [];
var chat_user_str = "";
function cleanArray(actual){
	$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
    var newArray = new Array();
    for(var i = 0; i<actual.length; i++){
        if (actual[i]){
            newArray.push(actual[i]);
        }
    }
    return newArray;
}
window.onload = function() {
	$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
	$.ajax({
        url:'../chat/onload',
		type:'POST',
		success:function(response){
			//console.log('response');
			//console.log(response);
			//console.log('response');
            var temp = new Array();
            // this will return an array with strings "1", "2", etc.
            temp = response.split("-----");
            var newArr = cleanArray(temp);
            //console.log(cleanArray(temp));
			//console.log(newArr);
			
            $.each(newArr, function(key, val) {
				$("#"+val+".jd-online_user").click(function(){
					//$("#"+val+".jd-body2").html(val);
                    $.ajax({
						url:'../chat/chat_msg',
                        type:'POST',
						data:'get_all_msg=true&user=' + val ,
						success:function(data){
                            $("#"+val+".jd-body2").append("<div class='me2'> " + data + "</div>");
                            $("#msg").val('');
                            jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
						}
                    });
				});
				//console.log(temp[temp.length-1]);
				$("#"+val+".jd-online_user").click();
				//$("#"+val+".jd-body2").html(val);
            });
			test(temp[temp.length-1],'last');		
		}
    });
};
$(document).ready(function(){
	
	jQuery("div.jd-body").scrollTop(0);
	$(function() {
  var wtf    = $('.jd-body');
  var height = wtf[0].scrollHeight;
  wtf.scrollTop(height);
});
	$.ajaxSetup ({
		cache: false	
	});
	
	var open=Array();
	$("#jd-chat .jd-online_user").click(function(){
		//console.log("1111");
		$(function() {
  var wtf    = $('.jd-body');
  var height = wtf[0].scrollHeight;
  wtf.scrollTop(height);
});
	})
	
	$("#jd-chat .jd-online_user").click(function(){
		//console.log("2222");
		var user_name = $.trim($(this).text());
		var id = $.trim($(this).attr("id"));
		if($.inArray(id,open) !== -1 )
			return
		open.push(id);
		chat_user.push(id);		
		chat_user_str += id + "-----";		
		$("#jd-chat2").prepend('<div class="jd-user2">\
			<div class="jd-header2" id="' + id + '">' + user_name + '<div class="cp_flt"><span class="up_down1">&#9660;</span><div class="close-this2"> X </div></div></div>\
			<div class="jd-body2 chatuser'+ id +'" id="' + id + '"><a onClick="test('+ id +')">Load All Messages</a></div>\
			<div class="jd-footer2"><input id="msg2" placeholder="Write A Message"></div>\
		</div>');
		jQuery("div.jd-body").scrollTop(jQuery("div.jd-body")[0].scrollHeight);
		$.ajax({
			url:'../chat/chat_msg',
			type:'POST',
			data:'get_all_msg=true&user=' + id ,
			success:function(data){
				$("#jd-chat2").find(".jd-user2:first .jd-body2").append("<div class='me2'> " + data + "</div>");
				$("#msg").val('');
				jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
			}
		});
		var temp = new Array();
            // this will return an array with strings "1", "2", etc.
            temp = chat_user_str.split("-----");
            var newArr = cleanArray(temp);
			for(var i=0;i<newArr.length;i++){
				var cp = newArr[i];
				jQuery("div.jd-body2").scrollTop(jQuery("#"+cp+".jd-body2")[0].scrollHeight);
			}
            $.each(newArr, function(key, val) {
				//console.log(val);
				aval = "1";
				jQuery("div.jd-body2").scrollTop(jQuery("#"+aval+".jd-body2")[0].scrollHeight);
            });
	});
	
	$("#jd-chat").on("click",".jd-online_user", function(){
		//console.log("3333");
  var user_name = $.trim($(this).text());
		var id = $.trim($(this).attr("id"));
		if($.inArray(id,open) !== -1 )
			return
		open.push(id);
		chat_user.push(id);
        chat_user_str += id + "-----";
		$("#jd-chat2").prepend('<div class="jd-user2">\
			<div class="jd-header2" id="' + id + '">' + user_name + '<div class="cp_flt"><span class="up_down1">&#9660;</span><div class="close-this2"> X </div></div></div>\
			<div class="jd-body2 chatuser'+ id+'" id="' + id + '"><a onClick="test('+ id +')">Load All Messages</a></div>\
			<div class="jd-footer2"><input id="msg2" placeholder="Write A Message"></div>\
		</div>');
		jQuery("div.jd-body").scrollTop(jQuery("div.jd-body")[0].scrollHeight);
		$.ajax({
			url:'../chat/chat_msg',
			type:'POST',
			data:'get_all_msg=true&user=' + id ,
			success:function(data){
				$("#jd-chat2").find(".jd-user2:first .jd-body2").append("<div class='me2'> " + data + "</div>");
				$("#msg").val('');
				jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
			}
		});
		var temp = new Array();
            // this will return an array with strings "1", "2", etc.
            temp = chat_user_str.split("-----");
            var newArr = cleanArray(temp);
			for(var i=0;i<newArr.length;i++){
				var cp = newArr[i];
				jQuery("div.jd-body2").scrollTop(jQuery("#"+cp+".jd-body2")[0].scrollHeight);
			}
            $.each(newArr, function(key, val) {
				console.log(val);
				aval = "1";
				jQuery("div.jd-body2").scrollTop(jQuery("#"+aval+".jd-body2")[0].scrollHeight);
            });
	});
	
	$("#jd-chat").delegate(".close-this","click",function(){
		//console.log("4444");
		removeItem = $(this).parents(".jd-header").attr("id");
		$(this).parents(".jd-user").remove();
		
		open = $.grep(open, function(value) {
		  return value != removeItem;
		});	
		 $.ajax({
            url:'../chat/remove_from_open_chat_list',
            type:'POST',
            data:{ id: $(this).parents(".jd-header").attr("id")},
            dataType:'JSON',
            success:function(data){
            }
	});
	});
	
	$("#jd-chat2").delegate(".close-this2","click",function(){
		//console.log("5555");
		removeItem = $(this).parents(".jd-header2").attr("id");
		$(this).parents(".jd-user2").remove();
		var id = $(this).parents(".jd-header2").attr("id");
		var itemsRemoved = stackoverflow_removeArrayItem(chat_user, id);
		open = $.grep(open, function(value) {
		  return value != removeItem;
		});	
		$.ajax({
            url:'../chat/remove_from_open_chat_list',
            type:'POST',
            data:{ id: $(this).parents(".jd-header2").attr("id")},
            dataType:'JSON',
            success:function(data){
            }
		});	
	});
		
	$("#jd-chat").delegate(".jd-header","click",function(){
		var box=$(this).parents(".jd-user,.jd-online");
		$(box).find(".jd-body,.jd-footer").slideToggle("slow");
		$(".cpheader,.cpbody").hide();
		//$('.jd-header2').click();
	});
	
	$("#jd-chat2").delegate(".jd-header2","click",function(){
		var id = $(this).attr('id');
		var $aSelected = $('#'+id+'.jd-header2 > .cp_flt').find('span');
		if( $aSelected.hasClass('up_down1') ){
			$('#'+id+'.jd-header2 > .cp_flt > span').removeClass('up_down1');
			$('#'+id+'.jd-header2 > .cp_flt > span').addClass('up_down2');
			$('#'+id+'.jd-header2 > .cp_flt > span').html('&#9650;');
		}else{
			$('#'+id+'.jd-header2 > .cp_flt > span').removeClass('up_down2');
			$('#'+id+'.jd-header2 > .cp_flt > span').addClass('up_down1');
			$('#'+id+'.jd-header2 > .cp_flt > span').html('&#9660;');
		
		}
		var box=$(this).parents(".jd-user2,.jd-online2");
		$(box).find(".jd-body2,.jd-footer2").slideToggle("slow");
	});
	

	
	$("#search_chat").keyup(function(){
		var val =  $.trim($(this).val());
		$(".jd-online .jd-body").find("span").each(function(){
			if ($(this).text().search(new RegExp(val, "i")) < 0 ) 
			{
                $(this).fadeOut(); 
            } 
			else 
			{
                $(this).show();              
            }
		});
	});
	
	$("#jd-chat2").delegate(".jd-user2 input","keyup",function(e){
		if(e.keyCode == 13 )
		{
			var box=$(this).parents(".jd-user2");
			var msg=$(box).find("input").val();
			var to = $.trim($(box).find(".jd-header2").attr("id"));
			$.ajax({
				url:'../chat/chat_msg',
				type:'POST',
				data:'send=true&to=' + to + '&msg=' + msg,
				success:function(data){					
					$(box).find(".jd-body2").append("<div class='rightclasschat1'><div class='me class1'  style='float:right;'> " + msg + "</div></div>");
					$("#msg2").val('');
					jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
					jQuery("div.jd-body2").scrollTop(jQuery("#"+to+".jd-body2")[0].scrollHeight);
					var temp = new Array();
            // this will return an array with strings "1", "2", etc.
            temp = chat_user_str.split("-----");
            var newArr = cleanArray(temp);
			for(var i=0;i<newArr.length;i++){
				var cp = newArr[i];
				jQuery("div.jd-body2").scrollTop(jQuery("#"+cp+".jd-body2")[0].scrollHeight);
			}
            $.each(newArr, function(key, val) {
				aval = "1";
				jQuery("div.jd-body2").scrollTop(jQuery("#"+aval+".jd-body2")[0].scrollHeight);
            });
	    jQuery("div.jd-body2").scrollTop(jQuery("#"+to+".jd-body2")[0].scrollHeight);
				}
			});
		}
	});
	
	function message_cycle(){
		$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
		var rand = Math.random();
		$.ajax({
			url:'../chat/chat_msg',
			type:'POST',
			data:{ unread: "true", rands: rand },			
			dataType:'JSON',
			success:function(data){
				//console.log(data);
				$.each(data , function( index, obj ) {					
					var user = index;					
					var box  = $("#jd-chat2").find("div").parents(".jd-user2");
					//console.log("1");
					//$(".jd-online2").find(".light").hide();
					var ids = $(".jd-body > div").attr('id');					
						$("span#"+index+".jd-online_user").click();
					$.each(obj, function( key, value ) {
						//console.log("2");
						
						jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);
						//$("#jd-chat2").find(".jd-user2:first .jd-body2").append("<div class='leftclasschat1'><div class='me class2'> " + value + "</div><div>");
						//$("#"+index+".jd-body2").append("<div class='leftclasschat1'><div class='me class2'> " + value + "</div><div>");
						jQuery("div.jd-body2").scrollTop(jQuery("div.jd-body2")[0].scrollHeight);						
						if($.inArray(user,open) !== -1 ){
							$(box).find("#"+user+".jd-body2").append("<div class='other'> " + value + "</div>");
						}
						else{
							$(".jd-online2").find("div#" + user + " .light").show();						
						}
						jQuery("div.jd-body2").scrollTop(jQuery("div#"+user+".jd-body2")[0].scrollHeight);
						if(chat_user_str !== ""){
							var temp = new Array();
							temp = chat_user_str.split("-----");
							var newArr = cleanArray(temp);
							for(var i=0;i<newArr.length;i++){
								var cp = newArr[i];
								jQuery("div.jd-body2").scrollTop(jQuery("#"+cp+".jd-body2")[0].scrollHeight);
							}
							$.each(newArr, function(key, val) {
								aval = "1";
								jQuery("div.jd-body2").scrollTop(jQuery("#"+val+".jd-body2")[0].scrollHeight);
							});
						}
					});
				});				
			}
		});
	}
	
	function users_cycle(){
		$.ajaxSetup ({
			cache: false	//use for i.e browser to clean cache
		});
		var rand = Math.random();
		$.ajax({
			url:'../chat/chat_msg',
			type:'POST',
			data:{ date_time: "true"},			
			dataType:'JSON',
			success:function(data){
				//alert(data);
			}
		});
	}
	setInterval(users_cycle,9000);
	setInterval(message_cycle,5000);
	$(".jd-header").click();
});  
