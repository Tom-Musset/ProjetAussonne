<?php
	
	class vueCentraleAdherent
	{
		public function __construct()
		{
			
		}
		
		public function ajouterEquipeAdherent($message,$message2){
			echo '<form action=index.php?vue=Adherent&action=enregistrerEquipe method=POST>';
			echo 'Choisissez une équipe à ajouter à cet Adhérent : ';
			echo $message2;
			echo $message; 
			echo '  <button type="submit" class="btn btn-primary">Valider</button>
			</form>';
		}

		public function ajouterAdherent(){
			echo '<form action=index.php?vue=Adherent&action=enregistrer method=POST>
					<legend>Information de l Adherent</legend>
							
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Nom</th>
									  <th scope="col">Prénom</th>
									  <th scope="col">Age</th>
									  <th scope="col">Sexe</th>
									  <th scope="col">Login</th>
									</tr>
							    </thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="Nom" id="Nom" required="true">
										</td>
										<td>
											<input type=text name="Prenom" id="Prenom" required=true>
										</td>
										<td>
											<input type=text name="Age" id="Age" required=true>
										</td>
										<td>
											<input type=text name="Sexe" id="Sexe" required=true>
										</td>
										<td>
											<input type=text name="Login" id="Login" required=true>
										</td>
								</tbody>
								<thead>
									<tr>
										<th scope="col">Password</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type=text name="Password" id="Password" required=true>
										</td>
								</tbody>
							</table>
							<button type="submit" class="btn btn-primary">Valider</button>
					</form>';
		}

		public function modifierAdherent($message)
		{
			echo '<form action=index.php?vue=Adherent&action=choixFaitPourModif method = GET>';
			echo $message; 
			echo ' <input type=hidden name=vue value=Adherent></input>
				   <input type=hidden name=action value=choixFaitPourModif></input>
				   <button type="submit" class="btn btn-primary">Valider</button>
				  </form>
			';
		}

		public function choixFaitPourModifAdherent($nom, $prenom, $age, $sexe, $login, $pwd , $choix)
		{
			echo '<form action=index.php?vue=Adherent&action=EnregModif method = GET>
							<input type=text name=nomAdherent value='.$nom.'></input>
							<input type=integer name=prenomAdherent value='.$prenom.'></input>
							<input type=integer name=ageAdherent value='.$age.'></input>
							<input type=integer name=sexeAdherent value='.$sexe.'></input>
							<input type=text name=loginAdherent value='.$login.'></input>
							<input type=text name=pwdAdherent value='.$pwd.'></input>';
							echo '<input type=hidden name=idAdherent value='.$choix.'></input>	
							<input type=hidden name=vue value=Adherent></input>
							<input type=hidden name=action value=EnregModif></input>
							<button type="submit" class="btn btn-primary">Valider</button>
					</form>';
		}

		public function visualiserAdherent($message)
		{		
			$listeAdherent=explode("|",$message);
			
			echo '<div style="height:80%; overflow:auto;margin-top:20px;">
				<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
							<th scope="col">Age</th>
							<th scope="col">Sexe</th>
							<th scope="col">Login</th>
							
						</tr>
					</thead>
					</div>
					<tbody>';

			$nbE=0;
			
			while ($nbE<sizeof($listeAdherent))
			{	
				$i=0;
				while (($i<5) && ($nbE<sizeof($listeAdherent)))
				{
					echo '<td scope>';
					echo $listeAdherent[$nbE];
					$i++;
					$nbE++;
					echo '</td>';
				}
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
		}

		public function visualiserCoéquipier($lesAdherents,$id)
		{		
			echo '<div style="height:80%; overflow:auto;margin-top:20px;">
				<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénom</th>
							<th scope="col">Age</th>
							<th scope="col">Sexe</th>

							
						</tr>
					</thead>
					</div>
					<tbody>';

					foreach($id as $lId){
						foreach($lesAdherents as $lAdherent){
							if($lAdherent->getIdAdherent()==$lId){
								echo '<tr>';
								echo '<td scope>';
								echo trim($lAdherent->getNomAdherent());
								echo '</td>';
								echo '<td scope>';
								echo trim($lAdherent->getPrenomAdherent());
								echo '</td>';
								echo '<td scope>';
								echo trim($lAdherent->getAgeAdherent());
								echo '</td>';
								echo '<td scope>';
								echo trim($lAdherent->getSexeAdherent());
								echo '</td>';
								echo '</tr>';
							}
						}
					}
			

			echo '</tbody>';
			echo '</table>';
		}

		public function modifierSonProfil($id){
			echo '<div style="height:50%; width:50%;" margin:auto;>
			<form action=index.php?vue=Adherent&action=modifierPwd method = POST>
					<input type=password name=pwdAdherent></input>
					<input type=hidden name=idAdherent value='.$id.'></input>	
					<input type="submit">
			</form>';
	}
		
		public function voyagerAdherent()
		{		
			echo '<iframe width=100% height=150% src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2885.319959224129!2d1.3158100143582203!3d43.683111158516006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12aeaee6224c0f13%3A0x9f57b169fe3a7161!2sMairie!5e0!3m2!1sfr!2sfr!4v1626195896682!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
				
		}
		
	
}
?>