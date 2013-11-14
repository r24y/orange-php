$(function(){
	var $s = $('#userSearchOverall');
	var $search =  $('#userSearch');
	$s.removeClass('simple active');
	var aTimer = 0;
	var selected = 1;
	var $list = $('#autocompleteResults');
	
	function updateSelection(){
		var $a = $list.find('a');
		$a.removeClass('active teal');
		if(selected===0) selected = $a.length;
		if(selected>$a.length) selected = 1;
		$a = $list.find('a:nth-child('+selected+')');
		$a.addClass('active teal');
	};
	
	function visitSelectedProfile(){
		var $a = $list.find('a:nth-child('+selected+')');
		document.location.href=$a.attr('href');
	};
	
	$('#userSearch').keyup(function(e){
		switch(e.which){
			case 38: // up
				selected--;
				updateSelection();
				return false;
			case 40: //down
				selected++;
				updateSelection();
				return false;
			case 13: //enter
				visitSelectedProfile();
				return false;
		}
		if(aTimer){
			clearTimeout(aTimer);
		}
		aTimer = setTimeout(function(){
			var str = $search.val();
			if(str.length===0){
				$s.removeClass('simple active');
				return;
			}
			$.getJSON('/orange/users', {term: str}, function(data){

				$s.addClass('simple active');
				$list.html('');
				for(var i=0;i<data.length;i++){
					var user = data[i];
					var $item = $("<a/>");
					var name = user.name.replace(str, "<u>"+str+"</u>");
					var uname = user.username.replace(str, "<u>"+str+"</u>");
					$item.addClass('item');
					$item.html(name+" ("+uname+")");
					$list.append($item);
					$item.attr('href','/orange/profile/'+user.username);
				}
				selected = 1;
				updateSelection();
			});
			aTimer = 0;
		}, 10);
	});
	$search.blur(function(){
		setTimeout(function(){$s.removeClass('simple active');}, 100);
	});
	var $modal = $('#newUserModal');
	$modal.modal().modal('setting', 'closable', false);
	$('#signUp').click(function(){
		$modal.modal('show');
	});
});

