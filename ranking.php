<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	$titulo = "Ranking";
	include("./inc/headers.php");
	
	$casas = $db->selectAll("casas",array(),array("casa_id","casa_score","casa_name"),array("casa_score" =>"DESC"));
	include("./inc/navbar.php"); ?>
		<main class="container">
			<?php
				if(empty($casas)){
					print "<h1>Parece que no hay ninguna casa por aquí...</h1><h3>¡Promociona nuestra web!";
				} else { ?>
					<div class="row s12">
					<h3>Ranking</h3>
						<div class="row s12 m12 l4">
							<div class="input-field">
							  <i class="material-icons prefix">find_in_page</i>
							  <input type="text" id="busqueda" onKeyUp="filterResults(this.value)" />
							</div>
						</div>
						<table class="responsive-table">
							<thead>
								<tr>
									<td>Posición</td>
									<td>Puntos</td>
									<td>Nombre</td>
								</tr>
							</thead>
							<tbody id="tabla_rankings">
							</tbody>
						</table>
					</div>
					
				<script>
					var listadoCasas = Array();
					<?php 
					$posicion = 1;
					foreach($casas as $casa){
						print "listadoCasas.push({position: '".$posicion."', name:'".htmlentities($casa['casa_name'])."', id:'".$casa['casa_id']."', score:'".$casa['casa_score']."'});";
						$posicion++;
					} ?>
					
					function filterResults(patron){
						var listadoFiltrado = Array();
						for(i=0;i<listadoCasas.length;i++){
							if(listadoCasas[i]['name'].toLowerCase().indexOf(patron.toLowerCase()) > -1){ //Encontrado resultado coincidente
								listadoFiltrado.push(listadoCasas[i]);
							}
						}
						var tabla_limpia = document.createElement('tbody');
						tabla_limpia.setAttribute('id','tabla_rankings');
						var tabla_sucia = document.getElementById('tabla_rankings');
						for(i=0;i<listadoFiltrado.length;i++){
							var casa = listadoFiltrado[i];
							var nuevaFila = tabla_limpia.insertRow(tabla_limpia.rows.length);
							var celdaPosicion  = nuevaFila.insertCell(0);
							var textoPosicion  = document.createTextNode(casa['position']);
							celdaPosicion.appendChild(textoPosicion);
							  
							var celdaPuntuacion = nuevaFila.insertCell(1);
							var textoPuntuacion  = document.createTextNode(casa['score']);
							celdaPuntuacion.appendChild(textoPuntuacion);
							
							var celdaNombre = nuevaFila.insertCell(2);
							var textoLinkCasa = document.createElement('a');
							textoLinkCasa.setAttribute('href', 'casa.php?id='+casa['id']);
								var textoNombre = document.createTextNode(casa['name']);
								textoLinkCasa.appendChild(textoNombre);
							celdaNombre.appendChild(textoLinkCasa);
						}
						tabla_sucia.parentNode.replaceChild(tabla_limpia, tabla_sucia);
					}
					filterResults("");
				</script>
					
				<?php }; ?>
		</main>
		<?php include ("footer.php"); ?>
	</body>
</html>