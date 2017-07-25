function calcPoint() {
	var age = this.parentNode.parentNode.querySelector('.age').innerHTML;
	var time = this.parentNode.parentNode.querySelector('.time').value;
	var points  = this.parentNode.parentNode.querySelector('.points').innerHTML;
	if(age <= 11) points = (1000/time)*1.5;
	else if(age <= 13) points = (1000/time)*1.42;
	else if(age <= 15) points = (1000/time)*1.35;
	else if(age <= 17) points = (1000/time)*1.21;
	else if(age <= 19) points = (1000/time)*1.18;
	else if(age <= 22) points = (1000/time)*1.09;
	else if(age <= 40) points = (1000/time);
	else points = (1000/time)*1.35;
	if(points - parseInt(points) >= 0.5)points++;
	points = parseInt(points);
	this.parentNode.parentNode.querySelector('.points').innerHTML = points;
	console.log(this.parentNode.parentNode.querySelector('.points').innerHTML);
	var integer = parseInt(time);
	var float = time - integer
	time = integer*60 + float*100;
	if(!isNaN(points))this.parentNode.parentNode.querySelector('.edit').href = './controler/editScore.php?user='+this.parentNode.parentNode.querySelector('.id').innerHTML+'&event='+document.querySelector('.event').value+'&time='+time+'&points='+points;
	else this.parentNode.parentNode.querySelector('.edit').href = "";
}