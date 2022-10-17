window.onload = initalise;


var messageStatus = ""; 
function submitData(){
	"use strict";
	var isAllOK = false;

	var firstNameVali = firstName();
	var lastNameVali = lastName();
	var usernameVali = userName();
	var dobVali = checkDOB();	
	var emailVali = emailFunc();
	var phoneVali = phoneNumber();
	var mainVali =   firstNameVali && lastNameVali && usernameVali && dobVali && emailVali && phoneVali ;
	if (mainVali == true ){
		isAllOK = true;
		
	 alert('Form submitted Successfully');
	 location.reload(); 
	}
	else{
		alert(messageStatus); 
		messageStatus = ""; 
		isAllOK = false;
	}
	return isAllOK;
}



function phoneNumber(){
	var phoneOK= true;
	var number = document.getElementById("fphone").value;
	var pattern = /^[0-9]+$/;
	if (number.length == 0 || number.length > 10 || !pattern.test(number) ){
		messageStatus = messageStatus + "Your Phone Number must contain 1 to 10 digits only \n";
		phoneOK = false;
	}
	return phoneOK;
}

function emailFunc () {
	var email = document.getElementById("femail").value;
	var emailOK = true;
	var pattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-za-zA-Z0-9.-]{1,4}$/;
	if (email.length == 0){
		messageStatus = messageStatus + "Plese type your email address\n";
		emailOK = false;
	}

	else{
		if (!pattern.test(email)){
			messageStatus = messageStatus + "Please Enter a valid Email address\n";
			emailOK = false;
		}
	}
	return emailOK;
}

function checkDOB(){
	var dobOK = true;
	var date = document.getElementById('fdob').value;
	if(date ==""){
		dobOK = false;
		messageStatus += "Please Fill in your date of birth \n";
	}
	return dobOK;
}

function firstName () {

	var name = document.getElementById('fname').value;
	var pattern = /^[a-zA-Z ]+$/ ;
	var status = true;
	if ((name == "" || name.length > 20 )){ 
		messageStatus += "Your First Name must contain between 1 to 20 characters\n";
		status = false; 
	}
	else{
		if (!pattern.test(name)){
			messageStatus += "Your First Name must only contain letters\n";
			status = false; 
		}
	}
	return status;
}


function lastName(){
	var name = document.getElementById('flname').value;
	var pattern = /^[a-zA-Z ]+$/ ;
	var status = true;
	if ((name == "" || name.length > 20 )){ 
		messageStatus += "Your Last Name must contain between 1 to 20 characters\n";
		status = false; 
	}
	else{
		if (!pattern.test(name)){
			messageStatus += "Your Last Name must only contain letters\n";
			status = false; 
		}
	}
	return status;
}

function userName(){

	var name = document.getElementById('funame').value;
	var pattern = /^[a-zA-Z0-9._%+-]+$/ ;
	var status = true;
	if ((name == "" || name.length > 10 )){ 
		messageStatus += "Your Username must contain between 1 to 10 characters\n";
		status = false; 
	}
	else{
		if (!pattern.test(name)){
			messageStatus += "Your Username must only contain alphanumeric letters\n";
			status = false; 
		}
	}
	return status;
}

function validate_password() {
 
	var pass = document.getElementById('pass').value;
	var confirm_pass = document.getElementById('confirm_pass').value;
	if (pass != confirm_pass) {
		document.getElementById('wrong_pass_alert').style.color = 'red';
		document.getElementById('wrong_pass_alert').innerHTML
		  = '☒ Use same password';
		document.getElementById('create').disabled = true;
		document.getElementById('create').style.opacity = (0.4);
	} else {
		document.getElementById('wrong_pass_alert').style.color = 'green';
		document.getElementById('wrong_pass_alert').innerHTML =
			'🗹 Password Matched';
		document.getElementById('create').disabled = false;
		document.getElementById('create').style.opacity = (1);
	}
}

function wrong_pass_alert() {
	if (document.getElementById('pass').value != "" &&
		document.getElementById('confirm_pass').value != "") {
		alert("Your response is submitted");
	} else {
		alert("Please fill all the fields");
	}
}
