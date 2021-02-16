
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
	var options = {};
    var instances = M.Sidenav.init(elems, options);
  });
  
  function checkPassword(currentElem){
	  var a = zxcvbn(currentElem.value);
	  if(a.score < 2){
		  currentElem.setCustomValidity("¡Contraseña demasiado débil!");
		  currentElem.reportValidity();
	  } else {
		  currentElem.setCustomValidity("");
		  currentElem.reportValidity();
	  }
	  checkPasswordMatch(currentElem);
  }
  
  function checkPasswordMatch(currentElem){
	  var otherElement;
	  if(currentElem.id == 'password'){
		otherElement = document.getElementById('password2');
	  } else {
		otherElement = document.getElementById('password');
	  }
		if(currentElem.value.length > 0 && otherElement.value.length > 0){
			if(currentElem.value == otherElement.value){
				currentElem.setCustomValidity("");
				currentElem.reportValidity();
			} else {
				currentElem.setCustomValidity("Las contraseñas no coinciden.");
				currentElem.reportValidity();
			}
		}
  }
	function isPositiveInteger(n) {
		return n >>> 0 === parseFloat(n);
	}
  function submitScore(casa_id,puntuacion){
		if(!isPositiveInteger(casa_id) || !isPositiveInteger(puntuacion)){return false;}
		if(puntuacion < 1 || puntuacion > 5){return false;} //Comprobaciones rápidas también en JS...
		var req = new XMLHttpRequest();
		
		req.open("POST", "vote.php", false);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.send("id="+casa_id+"&votos="+puntuacion);
		if(req.responseText.length > 0){
			var puntuacionIndicador = document.getElementById('puntos');
			puntuacionIndicador.innerText = req.responseText+" Puntos";
			
			var votos_elementos = document.getElementsByClassName("votos");
			for(i=0;i<votos_elementos.length;i++){
			  votos_elementos[i].classList.remove("green");
			  votos_elementos[i].classList.remove("blue");
			  if(votos_elementos[i].innerText == puntuacion){
				  votos_elementos[i].classList.add("green");
			  } else {
				  votos_elementos[i].classList.add("blue");
			  }
			};
		};
  }
  
  function eliminarPregunta(pregunta_numero, elemento_pregunta){
	  if(!isPositiveInteger(pregunta_numero)){return false;}
	  var req = new XMLHttpRequest();
		
		req.open("POST", "eliminar_pregunta.php", false);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.send("pregunta_id="+pregunta_numero);
		if(req.responseText.length > 0){
			if(req.responseText == "1"){
				elemento_pregunta.parentNode.parentNode.outerHTML = "";
				delete elemento_pregunta;
			}
		}
		
  }