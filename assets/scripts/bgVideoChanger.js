for(let displayButton of document.querySelectorAll(".connexion")){
    displayButton.addEventListener("click", ()=>{
        document.querySelector(".modal").classList.toggle("visible");
    })
}

//document.querySelector("h1").addEventListener("click", changeVid);
document.querySelector("#profile").addEventListener("click", ()=> document.querySelector("video").autoplay = true);
let i=2
function changeVid(){

    document.querySelector("video").pause();
    if(i>9) {i=0}
    document.querySelector("video").src = i + ".webm";

    i++;
}