//Micah Netz
//mainjs.js
function gotData(data){
	console.log(data);
	var table = "<table border='1'align='center'>"
				+"<tr><th>Dino Name</th><th>Order</th><th>Suborder</th><th>Where</th><th>When</th><th>Food</th></tr>"
				+"<tr>";
	
	for(var i in data){
		var name = data[i]['Name'];
		var order = data[i]['Order'];
		var suborder= data[i]['Suborder'];
		var where = data[i]['Where'];
		var when = data[i]['When'];
		var food = data[i]['Food'];
		var id = data[i]['id'];
		table += "<td>" + name + "</td>";
		table += "<td>" + order + "</td>";
		table += "<td>" + suborder + "</td>";
		table += "<td>" + where + "</td>";
		table += "<td>" + when + "</td>";
		table += "<td>" + food + "</td>";
		table += ''
		+		'<td><form name="editdino">'
		+			'<input type="button" value="Edit" id="Edit Button" onclick="updateDino('+ data[i]['id'] +');">'
		+			'<input type="hidden" value="' + data[i]['id'] + '" name="Row_to_Edit">'
		+		'</form></td>'		
		+	'<td><form name="deletedino">'
		+			'<input type="button" value="Delete" id="Delete Button" onclick="deleteDino('+ data[i]['id'] + ');">'
		+			'<input type="hidden" value="' + data[i]['id'] + '" name="Row_to_Delete">'
		+		'</form></td>'
		+'</tr>';
	}
	table+="</tr></table>";
	$("#rowdisplaywindow").html(table);
}//end of gotData

function readDinos() {
	
	$.ajax({
		type: 'POST',
		url: 'commandsAdmin.php',
		dataType: 'json',
		data: 'data',
		success: gotData
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
    readDinos();
	$('#name').keyup(queryTMDB);	
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
		success: alertOfSuccess(),
	}).done(alertOfSuccess());
}

function updateDino(id){
	var conf = confirm("Are you sure you want to edit this movie?");
	if (conf == true) {
		
		var name = null;
		var order = null;
		var suborder = null;
		var when = null;
		var where = null;
		var food = null;
		
		while (name == null || name == "" || name == "Enter name here" || !checkInputString(name)) {
			name = prompt("Please enter the new movie name.", "Enter name here");
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
				"food": food,
			},
			success: alertOfSuccess(),
			type: "PUT",
			dataType: "json"
		}).done(alertOfSuccess());
    }
	readMovies();
}

function deleteDino(id) {
    var conf = confirm("Are you sure you want to delete this movie?");
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
	var url1 = 'https://api.themoviedb.org/3/movie/';
	var url2 = '?api_key=38c7b812d037cbd445141717cac36859&language=en-US';
	var url = url1 + '' + id + '' + url2;
	
	document.getElementById("resultholder").innerHTML = "";
	document.getElementById("Retrieved dinos").innerHTML = "";
	
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