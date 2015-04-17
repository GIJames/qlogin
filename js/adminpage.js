var users = [];

var filters = {
	name: "",
	email: ""
}

function reFilter(){
	var filterForm = document.getElementById("filters").elements;
	filters.name = filterForm.namedItem("name").value;
	filters.email = filterForm.namedItem("email").value;
	finishRefresh();
}

function filtered(user){
	if(user.name.toLowerCase().search(filters.name.toLowerCase()) == -1){
		return true;
	}
	if(user.email.toLowerCase().search(filters.email.toLowerCase()) == -1){
		return true;
	}
	return false;
}

function finishRefresh(){
	var contentsString = "<tr><th>user</th><th>email</th><th>action</th></tr>";
	for(user in users){
		if(!filtered(users[user])){
			contentsString = contentsString + "<tr><td>" + users[user].name + "</td><td>" + users[user].email + "</td><td>" + "<select onchange=\"takeAction(this.value, " + users[user].name + ")\" type=\"text\"><option value=\"none\">none</option><option value=\"ban\">ban</option><option value=\"admin\">admin</option><option value=\"delete\">delete</option></select>" + "</td></tr>";
		}
	}
	document.getElementById("users").innerHTML = contentsString;
}


function continueRefresh(response){
	var jsonResponse = JSON.parse(response);
	users = jsonResponse;
	console.log(users);
	finishRefresh();
}

function requestUsers(){
	var request = new XMLHttpRequest();
	var url = "ajax/users.json.php";
	
	request.onreadystatechange=function() {
		if (request.readyState == 4 && request.status == 200){
			continueRefresh(request.responseText);
		}
	}
	request.open("GET" , url, true);
	request.send();
}

window.onload = function() {
	requestUsers();
}