// Remplacez la valeur UA-XXXXXX-Y par l'identifiant analytics de votre site.
gaProperty = 'UA-11059857-1'

// Désactive le tracking si le cookie d’Opt-out existe déjà.

var disableStr = 'ga-disable-' + gaProperty;

if (document.cookie.indexOf('hasConsent=false') > -1) {
window[disableStr] = true;
}

//Cette fonction retourne la date d’expiration du cookie de consentement 

function getCookieExpireDate() { 
 var cookieTimeout = 34214400000;// Le nombre de millisecondes que font 13 mois 
 var date = new Date();
date.setTime(date.getTime()+cookieTimeout);
var expires = "; expires="+date.toGMTString();
return expires;
}

// Cette fonction est appelée pour afficher la demande de consentement
function askConsent(){
    var bodytag = document.getElementsByTagName('body')[0];
    var div = document.createElement('div');
    div.setAttribute('id','cookie-banner');
    div.setAttribute('width','70%');
    // Le code HTML de la demande de consentement
    // Vous pouvez modifier le contenu ainsi que le style
    div.innerHTML =  '<div>Ce site utilise des cookies pour assurer son bon fonctionnement. \
	En poursuivant votre navigation, vous acceptez l\'utilisation des cookies. \
    <a href="javascript:validate()" class="cookie-banner-validate">OK</a>\
	<a href="/mentions-legales" class="cookie-banner-link">En savoir plus</a>.</div>';          
    bodytag.insertBefore(div,bodytag.firstChild); // Ajoute la bannière juste au début de la page 
    document.getElementsByTagName('body')[0].className+=' cookiebanner';              
}
      
      
// Retourne la chaine de caractère correspondant à nom=valeur
function getCookie(NomDuCookie)  {
    if (document.cookie.length > 0) {        
        begin = document.cookie.indexOf(NomDuCookie+"=");
        if (begin != -1)  {
            begin += NomDuCookie.length+1;
            end = document.cookie.indexOf(";", begin);
            if (end == -1) end = document.cookie.length;
            return unescape(document.cookie.substring(begin, end)); 
        }
     }
    return null;
}

   
// La fonction d'opt-out   
function validate() {
    document.cookie = disableStr + '=false;'+ getCookieExpireDate() +' ; path=/';       
    document.cookie = 'hasConsent=true;'+ getCookieExpireDate() +' ; path=/';
    var div = document.getElementById('cookie-banner');
    // Ci dessous le code de la bannière affichée une fois que l'utilisateur s'est opposé au dépôt
    // Vous pouvez modifier le contenu et le style
    if ( div!= null ) div.style.display='none';
    window[disableStr] = false;
}



//Ce bout de code vérifie que le consentement n'a pas déjà été obtenu avant d'afficher
// la baniére
var consentCookie =  getCookie('hasConsent');
if (!consentCookie) {//L'utilisateur n'a pas encore de cookie de consentement
 var referrer_host = document.referrer.split('/')[2]; 
   if ( referrer_host != document.location.hostname ) { //si il vient d'un autre site
   //on désactive le tracking et on affiche la demande de consentement            
     window[disableStr] = true;
     window[disableStr] = true;
     window.onload = askConsent;
   } else { //sinon on lui dépose un cookie 
      document.cookie = 'hasConsent=false; '+ getCookieExpireDate() +' ; path=/'; 
   }
}