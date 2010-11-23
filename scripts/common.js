/* BOOKMARKING SCRIPT */
var url="http://lightiseverything.com.au"
var title="Light Is Everything"
function bookmark(){
if (window.sidebar) { // Mozilla Firefox Bookmark
window.sidebar.addPanel(title, url,"");
} else if( window.external ) { // IE Favorite
window.external.AddFavorite( url, title); }
else if(window.opera && window.print) { // Opera Hotlist
return true; }
}
/* ACCESSIBLE POPUP LINKS */
function externalLinks() {
if (!document.getElementsByTagName) return;
var anchors = document.getElementsByTagName("a");
for (var i=0; i<anchors.length; i++) {
  var anchor = anchors[i];
  if (anchor.getAttribute("href") &&
      anchor.getAttribute("rel") == "external")  {
    anchor.target = "_blank";
    anchor.title = "This link opens in a new window";
  }
  if (anchor.getAttribute("href") &&
      anchor.getAttribute("rel") == "email")  {
    anchor.title = "This link opens a new email";
  }
  if (anchor.getAttribute("class") &&
      anchor.getAttribute("class") == "homey")  {
    anchor.addEventListener("mouseover", logo_in, false);
    anchor.addEventListener("mouseout", logo_out, false);
  }
}
}
/* LOGO ROLLOVER EFFECT */
function logo_in() {
	document.getElementById('home_img').src = 'images/common/lightiseverything_logo_alt.gif';
}
function logo_out() {
	document.getElementById('home_img').src = 'images/common/lightiseverything_logo.gif';
}
window.onload = externalLinks;