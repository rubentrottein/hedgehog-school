import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/*
* <p>05 : 03 : <span>00</span>><p>
* */
let count = document.querySelector("span");
let counter = 0;

setInterval(addMinute, 1000)
function addMinute(){
    count.innerHTML = counter--;
}