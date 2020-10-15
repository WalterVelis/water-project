function lettersOnly(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="abcdefghijklmnñopqrstuvwxyz";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}



function lettersOnlySpace(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="abcdefghijklmnñopqrstuvwxyz ";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}

/* function soloNumeros(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="1234567890";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}
 */
/* function soloNumerosP(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="1234567890.";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}


function soloSangre(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="abhor+- ";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}

function duiFormat(e){
    key=e.keyCode || e.which;
    keyboard=String.fromCharCode(key).toLowerCase();
    letters="1234567890-";
    specials="8-37-38-46-164";
    keyboard_especial=false;
    for(var i in specials){
        if(key==specials[i]){
            keyboard_especial=true;
            break;
        }
    }
    if(letters.indexOf(keyboard)==-1 && !keyboard_especial){
        return false;
    }

}
 */
