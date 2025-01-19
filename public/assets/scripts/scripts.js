let accordion = document.querySelector(".accordion");
let content = document.querySelector(".content");
let open = document.querySelector(".open");

accordion.addEventListener("click", function() {
    //content.classList.toggle('open');
})

// close flash
for(let flash of document.getElementsByClassName("flash")) {
    let close = document.createElement("a");
    close.classList.add("closeFlash");
    close.innerHTML += "&times; X";
    close.addEventListener("click", ()=>{
        flash.style.display="none";
    })
    flash.append(close);
}