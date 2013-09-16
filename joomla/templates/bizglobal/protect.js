document.ondragstart = protect;
document.onselectstart = protect;
document.oncontextmenu = protect;
document.oncopy = protect;
function protect() {
return false
}
