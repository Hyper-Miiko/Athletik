function calcPoint() {
	var age = this.parentNode.parentNode.querySelector('.age').innerHTML; //On chope la valeur d'age
	var time = this.parentNode.parentNode.querySelector('.time').value; //On chope la valeur du temps
	var points  = this.parentNode.parentNode.querySelector('.points').innerHTML; //On chope la valeur des points
	//Age mini 10 pour s'inscire
	//C'est ma petite foret de if qui calc les points selon le coef et l'age
	if(age <= 11) points = (1000/time)*1.5; 
	else if(age <= 13) points = (1000/time)*1.42;
	else if(age <= 15) points = (1000/time)*1.35;
	else if(age <= 17) points = (1000/time)*1.21;
	else if(age <= 19) points = (1000/time)*1.18;
	else if(age <= 22) points = (1000/time)*1.09;
	else if(age <= 40) points = (1000/time);
	else points = (1000/time)*1.35; //au dessus de 40 ans
	if(points - parseInt(points) > 0)points++; //On arrondie au supérieur (on fait quand même le test d'ici qu'y en 1 qui arrive à avoir un chiffre rond)
	points = parseInt(points); //C'est un float on le tronque
	this.parentNode.parentNode.querySelector('.points').innerHTML = points; //On édite les points
	//Convertion du temps min => sec
	var integer = parseInt(time);
	var float = time - integer
	time = integer*60 + float*100;
	if(!isNaN(points))this.parentNode.parentNode.querySelector('.edit').href = './controler/editScore.php?user='+this.parentNode.parentNode.querySelector('.id').innerHTML+'&event='+document.querySelector('.event').value+'&time='+time+'&points='+points; //Hum... disons qu'on récup tous est qu'on en fait un lien passant les argument avec $_GET
	else this.parentNode.parentNode.querySelector('.edit').href = ""; //Si la valeur n'est pas valid on désactive le lien
}
function recaptchaSubmit() {
	document.getElementById("register").submit();
}
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("slideImg");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length} ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex-1].style.display = "block";
}