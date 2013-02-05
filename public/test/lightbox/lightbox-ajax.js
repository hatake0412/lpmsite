/*
  Ajax Lightbox 
  (c) 2008-2009 xul.fr
  GPL license
*/  


// height of current view for all browsers but IE

function viewHeight() 
{
    if(window.innerHeight)return(window.innerHeight);
    if(document.documentElement && document.documentElement.clientHeight) 
         return(document.documentElement.clientHeight);
    if(document.body) return(document.body.clientHeight); 
    return 50;
}

// images are loaded asynchronously with no delay

function preloading(i, url)
{
	var xhr=createXHR();   
	xhr.onreadystatechange=function()
	{ 
		if(xhr.readyState == 4)
		{
			i.src = url;
		} 
	}; 

	xhr.open("GET", url , true);
	xhr.send(null); 
} 


function loadAll()
{
	preloading(new Image(), "images/acores.jpg");
	preloading(new Image(), "images/prison.jpg");
	preloading(new Image(), "images/shark.jpg");
}


function openbox(url)
{
  var box = document.getElementById('box');
  var filter =  document.getElementById('shadowing');
  filter.style.display='block';
  
  var title = document.getElementById('boxtitle');
  title.innerHTML = url;
  
  var content = document.getElementById('boxcontent');
  content.style.padding="0";

  content.innerHTML = "...dynamic content...";
  content.innerHTML = "<img src=" + url + " />";

  if(navigator.appName.substring(0, 3) == "Mic")  // for IE
  {
    box.style.display='block';
    x = document.documentElement.scrollTop + document.body.scrollTop + 
    box.offsetHeight / 4;
    box.style.top = x + "px";
    filter.style.top = document.documentElement.scrollTop + document.body.scrollTop;
  }
  else
  {
    box.style.display='block';
    var top =  (viewHeight() - box.offsetHeight ) / 2;    
    box.style.top = top + 'px';
    box.style.position='fixed'; // fixed does not work on IE
    filter.style.position='fixed'; 
  }

	
}	

function closebox()
{
   document.getElementById('box').style.display='none';
   document.getElementById('filter').style.display='none';
}



window.onload=loadAll;
