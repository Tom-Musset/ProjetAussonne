<?php
	
	class vueCentraleSpecialite
	{
		public function __construct()
		{
			
		}
		public function ajouterSpecialite()
		{
			echo '<form action=index.php?vue=Specialite&action=enregistrer method=POST>
					<legend>Information de la specialite</legend>
							
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Nom de la spécialité</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text" name="libSpecialite" id="libSpecialite" required="true">
										</td>
									</tr>
								</tbody>
							</table>
							<button type="submit" class="btn btn-primary">Valider</button>
					</form>';
					
		}
        public function visualiserSpecialite($liste)
		{
			$listeSpecialite=explode("|",$liste);
			
				echo '<div class="ascenseur">
					<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Specialite</th>
						</tr>
					</thead>
					<tbody>';
					$nbE=0;
					while ($nbE<sizeof($listeSpecialite))
						{	
							$i=0;
							echo '<tr>';
							while (($i<1) && ($nbE<sizeof($listeSpecialite)))
							{
								echo '<td scope>';
									echo trim($listeSpecialite[$nbE]);
									$i++;
									$nbE++;
								echo '</td>';
							}
							echo '</tr>';
						
						}
					echo '</tbody>';
					echo '</table>';
					echo '</div>';
					
		}
		public function modifierSpecialite($message)
		{
			echo '<form action=index.php?vue=Specialite&action=choixFaitPourModif method = GET>';
			echo $message; 
			echo ' <input type=hidden name=vue value=Specialite></input>
				   <input type=hidden name=action value=choixFaitPourModif></input>
				   <button type="submit" class="btn btn-primary">Valider</button>
				  </form>
			';
		}

		public function choixFaitPourModifSpecialite($nom,$choix)
	{
		echo "<form action=index.php?vue=Specialite&action=EnregModif method = GET>
						<input type=text name=libSpecialite value=\"$nom\"></input>";
						echo "<input type=hidden name=idSpecialite value=\"$choix\"></input>	
						<input type=hidden name=vue value=Specialite></input>
						<input type=hidden name=action value=EnregModif></input>
						<button type='submit' class='btn btn-primary'>Valider</button>
			 </form>";
	}

    }
?>