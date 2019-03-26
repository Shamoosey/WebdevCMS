window.addEventListener("load", () => {

    let username = document.getElementById("username");
    let usernameError = document.getElementById("usernameTaken_error");
    username.addEventListener("blur", () => {

        fetch(`actions/usernamejson.php?username=${username.value}`)
            .then(result => {
                return result.json();                
            })
            .then(response => {
                if(response != null){
                    usernameError.style.display = "inline";
                    usernameError.style.color = "red"
                } else {
                    usernameError.style.display = "none";
                }
            })
    })
})




