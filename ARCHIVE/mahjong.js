    function firstname(name){
	pos = name.indexOf(" ");
        fname = name.substring(0,pos);
        return fname;
    }


    
    function num_p(){
	
	players = document.getElementById('players');
	
	num = 0;
	for (i=0; i < players.options.length; i++){
	    if (players.options[i].selected){
		num++;
	    }
	}
	return num;
    }

    function add_player(){
	players = document.getElementById('players');
	
	winner = document.getElementById('winner');
	num_w = winner.options.length;
	if (num_p() > 4){
	    //Do not add - loop through winner and mark all players
		//Clear all players selects
		//foreach W in winner
		//foreach P in player
		//if W.value == P.value
		//P.selected = true;
	    //break;
	    //endif
		//endfor
		//endfor
		for (i = 0; i < players.options.length; i++){
		    players.options[i].selected = false;
		}
	    for (i = 0; i < winner.options.length; i++){
		for (j = 0; j < players.options.length; j++){
		    if (winner.options[i].value == players.options[j].value){
			players.options[j].selected = true;
			break;
		    }
		}
	    }
	} else {
	    //alert("In else - num = " + num);
	    //clear winners, loop through player and add to winner
		winner.options.length = 0;
	    j = 0;
	    for (i=0; i < players.options.length; i++){
		if (players.options[i].selected){
		    var newOpt = new Option(firstname(players.options[i].innerHTML), players.options[i].value);
		    winner.options[j] = newOpt;
		    j++;
		}
	    }
	}
	
    }

function add_tosser(){
    
    winner = document.getElementById('winner');
    tosser = document.getElementById('tosser');
    tosser.options.length = 1;
    j = 1;
    for (i = 0; i < winner.options.length; i++){
	if (!winner.options[i].selected){
	    var newOpt = new Option(winner.options[i].innerHTML, winner.options[i].value);
	    tosser.options[j] = newOpt;
	    j++;
	}
    }
}


function choose_tosser(tosser){
	if (tosser.selectedIndex == 0){
		if (!document.getElementById('kongself').checked){
			if (!document.getElementById('self').checked){
				document.getElementById('score').value = parseInt(document.getElementById('score').value) + 1;
				document.getElementById('self').checked = true;	
			}
		}
	} else {
		if (document.getElementById('self').checked || document.getElementById('kongself').checked){
			document.getElementById('score').value = parseInt(document.getElementById('score').value) - 1;
		}
	
		document.getElementById('self').checked = false;
		document.getElementById('kongself').checked = false;
	}
}

function update_score(check){

    max = 12;
    //this used to be "scores".  No idea why IE couldn't deal with it.
    thescores = document.getElementsByName("hand");

    score = document.getElementById('score');
    if (check.alt == max){
	for (i = 0; i < thescores.length; i++){
	    thescores[i].checked = false;
	}
	check.checked = true;
	score.value = "MAX";
    } else {
	for (i = 0; i < thescores.length; i++){
	    if (thescores[i].alt == max){
		thescores[i].checked = false;
	    }
	}
	switch(check.id){
	    case 'kongself':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('self').checked = false;
		document.getElementById('concealed').checked = false;
	    break;
	    case 'concealed':
	    case 'self':
		document.getElementById('kongself').checked = false;
	    break;
	    case 'rwind':
	    case 'swind':
		document.getElementById('pure').checked = false;
	    case 'pong':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	    break;
	    case 'chow':
		document.getElementById('pong').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('rwind').checked = false;
	        document.getElementById('swind').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('3drag').checked = false;
	        document.getElementById('kongself').checked = false;
	        document.getElementById('wd').checked = false;
	    break;
	    case 'pair':
		document.getElementById('chow').checked = false;
	        document.getElementById('pong').checked = false;
	        document.getElementById('rwind').checked = false;
	        document.getElementById('swind').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('3drag').checked = false;
	        document.getElementById('kongself').checked = false;
	    break;
	    case 'pure':
		document.getElementById('semi').checked = false;
	        document.getElementById('wd').checked = false;
	        document.getElementById('rwind').checked = false;
	        document.getElementById('swind').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('3drag').checked = false;
	    break;
	    case 'semi':
		document.getElementById('pure').checked = false;
	        document.getElementById('wd').checked = false;
	    break;
	    case '2flower':
		document.getElementById('noflower').checked = false;
	        document.getElementById('1flower').checked = false;
	        document.getElementById('8flower').checked = false;
	        document.getElementById('rbflower').checked = false;
	    break;
	    case '1flower':
		document.getElementById('noflower').checked = false;
	        document.getElementById('2flower').checked = false;
	        document.getElementById('8flower').checked = false;
	    break;
	    case 'rbflower':
		document.getElementById('noflower').checked = false;
	        document.getElementById('2flower').checked = false;
	        document.getElementById('8flower').checked = false;
	    break;
	    case '8flower':
		document.getElementById('noflower').checked = false;
	        document.getElementById('1flower').checked = false;
	        document.getElementById('2flower').checked = false;
	        document.getElementById('rbflower').checked = false;
	    break;
	    case 'noflower':
		document.getElementById('8flower').checked = false;
	        document.getElementById('1flower').checked = false;
	        document.getElementById('2flower').checked = false;
	        document.getElementById('rbflower').checked = false;
	    break;
	    case '1drag':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('3drag').checked = false;
	        document.getElementById('pure').checked = false;
	    break;
	    case '2drag':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('3drag').checked = false;
	        document.getElementById('pure').checked = false;
	    break;
	    case '2+drag':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('3drag').checked = false;
	        document.getElementById('pure').checked = false;
	    break;
	    case '3drag':
		document.getElementById('chow').checked = false;
	        document.getElementById('pair').checked = false;
	        document.getElementById('2drag').checked = false;
	        document.getElementById('2+drag').checked = false;
	        document.getElementById('1drag').checked = false;
	        document.getElementById('pure').checked = false;
	    break;
	    case 'wd':
		document.getElementById('semi').checked = false;
	        document.getElementById('pure').checked = false;
	    break;
	}
	num = 0;
	for (i = 0; i < thescores.length; i++){
	    if (thescores[i].checked){
		num += parseInt(thescores[i].alt);
	    }
	}
	score.value = num;
	
    }

}		

function validate(){
    if (num_p() != 4){
	alert ("Choose exactly 4 players!");
	return false;
    }
    if (document.getElementById('winner').selectedIndex == -1){
	alert ("Choose the winner!");
	return false;
    }
    if (document.getElementById('tosser').selectedIndex == -1){
	alert ("Choose the player that tossed the final tile");
	return false;
    }
    if (document.getElementById('score').value != 'MAX' && isNaN(document.getElementById('score').value)){
	alert ("Score must be a number or 'MAX'");
	return false;
    }
    if (document.getElementById('score') == ''){
	document.getElementById('score') = 0;
    }	
    if (document.getElementById('score').value < 3){
	return confirm("Score is less than a 3 point minimum.  Are you sure?");
    }
    return true;
}

			

function showhideall(chk){
	players = document.getElementById('players');
	players.options.length = 0;
        if (chk.checked){
		for (i = 0; i < allp.length; i++){
			players.options[i] = allp[i];
		}
	} else {
		for (i = 0; i < currentp.length; i++){
			players.options[i] = currentp[i];
		}
	}


	return true;
}
   
