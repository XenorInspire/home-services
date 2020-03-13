function checkPassword(){

let passwd = document.getElementById('password_length').value;
let title = document.getElementById('password_size');

  if(passwd.length < 6){

    title.style.display = "block";

  }else{

    title.style.display = "none";

  }

}

function samePassword(){

  let passwd = document.getElementById('same').value;
  let passwd2 = document.getElementById('password_length').value;
  let title = document.getElementById('password_same');

    if(passwd != passwd2){

      title.style.display = "block";

    }else{

      title.style.display = "none";

    }

}
