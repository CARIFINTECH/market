$( document ).ready(function() {ellipsis('.text');});

function ellipsis(selector){
 var nodeList = document.querySelectorAll(selector);
 arrNodes = [].slice.call(nodeList);
 for (var i in arrNodes)
 {
   var n = arrNodes[i]; 
   while(n.scrollHeight-n.offsetHeight>0)
   {
     var text = (n.innerText != undefined) ? n.innerText : n.textContent;
     if(n.innerText != undefined)
     {
         n.innerText=text.replace(/\W*\s(\S)*$/, '...');
     }
     else
     {
       // for Firefox
       n.textContent = text.replace(/\W*\s(\S)*$/, '...');
     }
   }
 }
}

function printSpotligth(){
  $(window).width()
  $('.item').find('div').each(function( index ) {
    console.log( index + ": " + $( this ).text() );
  });
}