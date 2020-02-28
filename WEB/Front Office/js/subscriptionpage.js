window.onload = function() {
  subscriptionStyle();
}

function subscriptionStyle() {
  let subscriptionDiv = document.getElementsByClassName("subscriptions");
  for(let i = 0; i < subscriptionDiv.length; i++) {
    subscriptionDiv[i].style.border = 'thick solid #000000';
    //subscriptionDiv[i].style.width = "200px";
  }
}
