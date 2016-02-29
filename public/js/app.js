$(document).foundation();
$(document).ready(function(){
    keyUp();
});
var data = Array();
function keyUp()
{
    var sb = document.getElementsByName('searchBar');
    if(sb.length != 0){
       sb[0].onkeyup = function(e){
                queryInterpretor(sb[0].value);   
       }
    }
}
function searchRequest(){
    var sxml = new XMLHttpRequest();
    sxml.onreadystatechange = function(){
        if(sxml.readyState == 4 && sxml.status == 200){
            console.log('response text is :'+sxml.responseText);
        }
    }
    sxml.open('GET', 'partials/search_input.php', true);
    sxml.send();
}
function queryInterpretor(key_val)
{
    //#no search filter
    dataRetreive(key_val);
}
function dataRetreive(key_val)
{
    var regexp = new RegExp(key_val, 'i');
    var dataContent = document.getElementsByClassName('accordion-item');
    for(var i in dataContent)
    {
        if(typeof dataContent[i] == "object"){
            var result = regexp.exec(dataContent[i].children[0].innerHTML);
            if(result){
                showElem(dataContent[i]);
            }else{
                hideElem(dataContent[i]);
            }
        }
    }
}
function hideElem(elem)
{
  if(!elem.classList.contains('hide')){
      elem.classList.add('hide');
  }
    
}
function showElem(elem)
{
  if(elem.classList.contains('hide')){
      elem.classList.remove('hide');
  }
}
