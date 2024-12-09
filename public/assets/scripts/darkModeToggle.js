let darkMode = localStorage.getItem("darkMode");
function applyTheme(){
    document.querySelector("body").classList.toggle("darkMode");
    document.querySelector("#color_mode").checked = darkMode === true;
}
for(let darkModeToggle of document.querySelectorAll(".darkModeToggle")){
    darkModeToggle.addEventListener("change", ()=>{
        darkMode = !darkMode;
        localStorage.setItem("darkMode", darkMode);
        applyTheme()
    })
}
applyTheme()