let requireTextFields = ["password"];
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
        console.log(i);
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

	return errorFlag;
}

/*
 * Hides all of the error elements.
 */
function hideErrors()
{
	//get a array of the errors
	let errorFields = document.getElementsByClassName("error")

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
}
document.addEventListener("DOMContentLoaded", load);