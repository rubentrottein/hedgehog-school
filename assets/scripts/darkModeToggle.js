let darkMode = localStorage.getItem("darkMode");
function applyTheme(){
    if(darkMode === true){
        document.querySelector("body").classList.add("darkMode")
        document.querySelector("#color_mode").checked = true;
    } else {
        document.querySelector("body").classList.remove("darkMode")
        document.querySelector("#color_mode").checked = false;
    }
}
for(let darkModeToggle of document.querySelectorAll(".darkModeToggle")){
    darkModeToggle.addEventListener("change", ()=>{
        darkMode = !darkMode;
        localStorage.setItem("darkMode", darkMode);
        applyTheme()
    })
}
applyTheme()