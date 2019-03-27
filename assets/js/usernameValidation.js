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
                    usernameError.style.color = "red";
                    document.getElementById("username").style.border = "0.75px red solid";
                } else {
                    usernameError.style.display = "none";
                    document.getElementById("username").style.border = "1px solid #e5e5e5";
                }
            })
    })
})
