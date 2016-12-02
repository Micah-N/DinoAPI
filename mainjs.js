//Micah Netz
//mainjs.js
function gotData(data){
	console.log("Entered gotData");
	console.log(data);
	/* To show the entire JSON results use the following two lines*/
	for(response in data.responseJSON){
		$("#displaywindow").html(JSON.stringify(data.responseJSON));
		var dinoName = data.responseJSON[response]['Name'];
		var order = data.responseJSON[response]['Order'];
		var suborder = data.responseJSON[response]['Suborder'];
		var where = data.responseJSON[response]['Where'];
		var when = data.responseJSON[response]['When'];
		var food = data.responseJSON[response]['Food'];
		var id = data.responseJSON[response]['id'];
		console.log("Name: " + dinoName 
		+ "\nOrder: " + order
		+ "\nSuborder: " + suborder
		+ "\nWhere: " + where
		+ "\nWhen: " + when
		+ "\nFood: " + food
		);		
	}/*
	$("#displaywindow").html(array);
	var d = JSON.stringify(array[0]);
	var j = JSON.parse(d);
	console.dir(d);
	console.log("Test:" + JSON.stringify(d[0]));
	var resName = JSON.stringify(d[0]['Name']);
	console.log(resName);
	*/
	/**/
	/*
	var table = "<table border='1'align='center'>"
				+"<tr><th>Dino Name</th><th>Order</th><th>Suborder</th><th>Where</th><th>When</th><th>Food</th></tr>"
				+"<tr>";
	
	for(var i in d){
		var name = d[i]['Name'];
		var order = d[i]['Order'];
		var suborder= d[i]['Suborder'];
		var where = d[i]['Where'];
		var when = d[i]['When'];
		var food = d[i]['Food'];
		var id = d[i]['id'];
		table += "<td>" + name + "</td>";
		table += "<td>" + order + "</td>";
		table += "<td>" + suborder + "</td>";
		table += "<td>" + where + "</td>";
		table += "<td>" + when + "</td>";
		table += "<td>" + food + "</td>";
		table += ''
		+		'<td><form name="editdino">'
		+			'<input type="button" value="Edit" id="Edit Button" onclick="updateDino('+ d[i]['id'] +');">'
		+			'<input type="hidden" value="' + d[i]['id'] + '" name="Row_to_Edit">'
		+		'</form></td>'		
		+	'<td><form name="deletedino">'
		+			'<input type="button" value="Delete" id="Delete Button" onclick="deleteDino('+ d[i]['id'] + ');">'
		+			'<input type="hidden" value="' + d[i]['id'] + '" name="Row_to_Delete">'
		+		'</form></td>'
		+'</tr>';
	}
	table+="</tr></table>";
	$("#rowdisplaywindow").html(table);
	/**/
}//end of gotData

function readDinos() {
	console.log("Entered readDinos");
	$.ajax({
		type: 'GET',
		url: 'commandsAdmin.php',
		dataType: 'json',
		data: 'data',
		complete: gotData
	});//end of ajax call
}//end of readDinos()
/*
function queryTMDB(){
	var url = 'http://api.themoviedb.org/3/',
		mode = 'search/movie?',
        input,
        key = '&api_key=38c7b812d037cbd445141717cac36859',
		language = '&language=en-US&query=',
		pageNum = '&page=1';
		
		var input = $('#name').val();
		var result = '';
		
        $.ajax({
            type: 'GET',
			url: url + mode + key + language + input + pageNum,
            async: false,
            contentType: 'application/json',
            dataType: 'jsonp',
            success: function(json) {
				r = json['results'];
				for(var i in r){
					var name = r[i]['title'];
					var year = r[i]['release_date'];
					var id = r[i]['id'];
					var row = r[i];
					
					result += '<br>'
					+			'<input type="text" maxlength="100" value="' + row['title'] + ' ' + row['release_date'] + ' ' 
					+ row['id'] +'" id="Select Button" onclick="selectMovie(' + id + ');">'
					+			'<input type="hidden" value="' + id + '" name="Row_to_Select">';
					
					$('#resultholder').html(result);
				}
            },
            error: function(e) {
                console.log(e.message);
            }
        });	
}//end of queryTMDB
*/
//Ready Function
$(document).ready(function () {
	console.log("Ready!");
    readDinos();
	//$('#name').keyup(queryTMDB);	
});

function alertOfSuccess(){
	alert("Successfully changed dino table.");
}

function alertOfFail(){
	alert("Failed to change dino table.");
}


function checkInputString(input){
	var pattern = /^([A-Za-z0-9-\s':",\!\?\.\(\)%]){1,50}$/;
	
	if(pattern.test(input)){
		return true;
	}
	alert("Invalid entry.");
	return false;
}

function addDino(){
	console.log("Entered addDino");
	var name = $("#name").val().trim();
    var order = $("#order").val().trim();
    var suborder = $("#suborder").val().trim();
	var when = $("#when").val().trim();
	var where = $("#where").val().trim();
	var food = $("#food").val().trim();
	
	while (name == null || name == "" || name == "Enter dino name here" || !checkInputString(name)) {
		name = prompt("Please enter a valid dino name.", "Enter name here");
		name = name.trim();
	}
		 
	$.ajax({
		url:  "commandsAdmin.php",
		data:
		{
		"name": name,
		"order": order,
		"suborder": suborder,
		"when": when,
		"where": where,
		"food": food
		},
		type: "POST",
		complete: alertOfSuccess(),
	}).done(alertOfSuccess());
}
/*
function searchDino(){
	
	var name = $("#sname").val().trim();
    var order = $("#sorder").val().trim();
    var suborder = $("#ssuborder").val().trim();
	var when = $("#swhen").val().trim();
	var where = $("#swhere").val().trim();
	var food = $("#sfood").val().trim();
	
	//Check each input field to verify which search to perform
	var keyword = null;
	if(name != null && name != ""){
		keyword = "Name";
	}
	else if(order != null && order != ""){
		keyword = "Order";
	}
	else if(suborder != null && suborder != ""){
		keyword = "Suborder";
	}
	else if(when != null && when != ""){
		keyword = "When";
	}
	else if(where != null && where != ""){
		keyword = "Where";
	}
	else if(food != null && food != ""){
		keyword = "Food";
	}
	else{
		keyword = "ALL";
	}
	
	$.ajax({
		type: 'GET',
		url: 'commandsAdmin.php',
		dataType: 'json',
		data: 
		{
		"name": name,
		"order": order,
		"suborder": suborder,
		"when": when,
		"where": where,
		"food": food,
		"keyword": keyword
		},
		complete: gotData
	});//end of ajax call

}
*/
function updateDino(id){
	console.log("Entered updateDino");
	var conf = confirm("Are you sure you want to edit this dinosaur?");
	if (conf == true) {
		
		var name = null;
		var order = null;
		var suborder = null;
		var when = null;
		var where = null;
		var food = null;
		
		while (name == null || name == "" || name == "Enter name here" || !checkInputString(name)) {
			name = prompt("Please enter the new dinosaur name.", "Enter name here");
			name = name.trim();
		}
				
		$.ajax({
			url: "commandsAdmin.php",
			data:
			{
				"id": id,
				"name": name,
				"order": order,
				"suborder": suborder,	
				"when": when,
				"where": where,
				"food": food
			},
			success: alertOfSuccess(),
			type: "PUT",
			dataType: "jsonp"
		}).done(alertOfSuccess());
    }
	readDinos();
}

function deleteDino(id) {
	console.log("Entered deleteDino");
    var conf = confirm("Are you sure you want to delete this dinosaur?");
    if (conf == true) {
		$.ajax({
			url: "commandsAdmin.php",
			data:
			{
				"id": id
			},
			success: alertOfSuccess(),
			type: "DELETE",
			dataType: "json"
		}).done(alertOfSuccess());
		readDinos();
    }
}

function changeElement(targetElement, value){
  var element = document.getElementById(targetElement);
  if(typeof element !== 'undefined' && element !== null){
    document.getElementById(targetElement).value = value;
  }
}

function selectDino(id){	
	console.log("Entered selectDino");
	var url1 = 'https://api.themoviedb.org/3/movie/';
	var url2 = '?api_key=38c7b812d037cbd445141717cac36859&language=en-US';
	var url = url1 + '' + id + '' + url2;
	
	document.getElementById("resultholder").innerHTML = "";
	document.getElementById("Retrieved dinosaurs").innerHTML = "";
	
	$.ajax({
		type: 'GET',
		url: url,
		async: false,
		contentType: 'application/json',
		dataType: 'jsonp',
		success: function(json) {
			try{
				var name = json['name'];
				var order = json['order'];
				var suborder = json['suborder'];
				var when = json['when'];
				var where = json['where'];
				var food = json['food'];
				var resName = JSON.stringify(name);
				//might need to do this with the other vars too depending on design
				changeElement('name', resName);
				changeElement('order', order);
				changeElement('suborder', suborder);
				changeElement('when', when);
				changeElement('where', where);
				changeElement('food', food);
			}
			catch(e){
				alert("Error encountered: " + e);
			}			
			//console.dir(json);
		},
		error: function(e) {
			console.log(e.message);
		}
    });
}//end of selectDino