function myFunction(element) {
    if (element.checked) {
        if(element.name=="mayor"){
            document.getElementById("menor").checked = false;
        }else{
            document.getElementById("mayor").checked = false;
        }
    }
}
