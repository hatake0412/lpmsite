/*
  Lightbox with fading effect 
  (c) 2008-2011 xul.fr
  GPL 2.0 license
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

function gradient(id, level)
{
	var box = document.getElementById(id);
	box.style.opacity = level;
	box.style.MozOpacity = level;
	box.style.KhtmlOpacity = level;
	box.style.filter = "alpha(opacity=" + level * 100 + ")";
	box.style.display="block";
	return;
}


function fadein(id) 
{
	var level = 0;
	while(level <= 1)
	{
		setTimeout( "gradient('" + id + "'," + level + ")", (level* 1000) + 10);
		level += 0.01;
	}
}


// Open the lightbox

function openbox(url, fadin)
{
  var box = document.getElementById('box'); 
  var filter= document.getElementById('shadowing');
  filter.style.display='block';
  
  var title = document.getElementById('boxtitle');
  title.innerHTML = url;
  
  var content = document.getElementById('boxcontent');
  content.style.padding="0";

  content.innerHTML = "<img src=" + url + " />";

  if(fadin)
  {
	 gradient("box", 0);
  }
  else
  { 	
    box.style.display='block';
  }  
  
  if(navigator.appName.substring(0, 3) == "Mic")  // for IE
  {
    x = document.documentElement.scrollTop + document.body.scrollTop + 
    box.offsetHeight / 4;
    box.style.top = x + "px";
    shadowing.style.top = document.documentElement.scrollTop + document.body.scrollTop;
  }
  else
  {
    var top =  (viewHeight() - box.offsetHeight ) / 2;    
    box.style.top = top + 'px';
    box.style.position='fixed'; // fixed does not work on IE
    filter.style.position='fixed'; 
  }  

  if(fadin)
  {
	 fadein("box");  
  }
    	
}	

// Close the lightbox

function closebox()
{
   document.getElementById('box').style.display='none';
   document.getElementById('shadowing').style.display='none';
}



// Loading images asynchronously with no delay

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


window.onload=loadAll;

