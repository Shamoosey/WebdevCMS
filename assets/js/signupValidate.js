let requireTextFields = ["fname", "lname", "email", "username", "password"];
let defaultBorder = "1px solid #e5e5e5";
/*
 * Handles the submit event of the form
 */
function validate(e){
	hideErrors()

	if(formHasErrors()){
		e.preventDefault();

		return false;
	}
	return true;
}

//trim function
function trim(str) 
{
	return str.replace(/^\s+|\s+$/g,"");
}

//checks the form for input in the text boxes and returns a value
function hasInput(fieldElement){
	if(fieldElement.value == null || trim(fieldElement.value) == ""){
		return false;
	}
	return true;
}

//resets the form when the user presses the clear button
function resetForm(e){
	hideErrors();
	return true;
}

//Checks the form for any errors and returns a value based on that
function formHasErrors()
{
	var errorFlag = false;
    //validating all of the text fields to confirm the have options
	for(let i = 0; i < requireTextFields.length; i++){
		var textField = document.getElementById(requireTextFields[i])
		
		if(!hasInput(textField)){
			//display correct error message
			document.getElementById(requireTextFields[i] + "_error").style.display = "inline";
			document.getElementById(requireTextFields[i]).style.border = "0.75px red solid";
			if(!errorFlag && (i != 3)){
				textField.focus();
			}
			//raise error flag
			errorFlag = true;
		} else {
			document.getElementById(requireTextFields[i] + "_error").style.display = "none";
			document.getElementById(requireTextFields[i]).style.border = defaultBorder;
		}
	}
	
	//validating the email to confirm its valid
	let emailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	let emailFieldValue = document.getElementById("email").value;
	if(!emailRegex.test(emailFieldValue)){
		if(document.getElementById("email_error").style.display == "none"){
			document.getElementById("emailformat_error").style.display = "inline";
			document.getElementById("email").style.border = "0.75px red solid";
			if(!errorFlag){
				document.getElementById("email").focus();
			}
			errorFlag = true;
		}
	} else {
		document.getElementById("emailformat_error").style.display = "none";
		document.getElementById("email").style.border = defaultBorder;
    }
	
	let passwordOne = document.getElementById("password").value;
	let passwordTwo = document.getElementById("validatePassword").value;
	if(document.getElementById("password_error").style.display == "none"){
		if(trim(passwordOne).length >= 5){
			if(trim(passwordOne) != trim(passwordTwo)){
				
				document.getElementById("passwordMatch_error").style.display = "inline";
				document.getElementById("password").style.border = "0.75px red solid";
				document.getElementById("validatePassword").style.border = "0.75px red solid";
				document.getElementById("password").style.border = defaultBorder;
				errorFlag = true;
			}
		} else {
			document.getElementById("passwordLength_error").style.display = "inline";
			document.getElementById("password").style.border = "0.75px red solid";
			errorFlag = true;
		}
	}

	let usernameTakenError = document.getElementById("usernameTaken_error");
	let usernameError = document.getElementById("username");
	if(document.getElementById("username_error").style.display == "none"){
		fetch(`actions/usernamejson.php?username=${username.value}`)
				.then(result => {
					return result.json();                
				})
				.then(response => {
					if(response != null){
						errorFlag = true;
						usernameTakenError.style.display = "inline";
						usernameTakenError.style.color = "red"
						usernameError.style.border = "0.75px red solid";
					} else {
						usernameTakenError.style.display = "none";
						usernameError.style.border = defaultBorder;
					}
				})
	}

	return errorFlag;
}

/*
 * Hides all of the error elements.
 */
function hideErrors()
{
	//get a array of the errors
	let errorFields = document.getElementsByClassName("error");
	let usernameError = document.getElementById("usernameTaken_error").style.display = "none"

	for(let i = 0; i < errorFields.length; i++){
		errorFields[i].style.display ="none";
	}
	for(let i = 0; i < requireTextFields.length; i++){
		document.getElementById(requireTextFields[i]).style.border = defaultBorder;
	}
	document.getElementById("validatePassword").style.border = defaultBorder;
}

/*
 * Handles the load event of the document.
 */
function load()
{
	//hideErrors();
	document.getElementById("submit").addEventListener("click", validate);
	document.getElementById("clear").addEventListener("click", hideErrors);
}
document.addEventListener("DOMContentLoaded", load);