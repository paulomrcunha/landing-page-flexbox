<?php include "templates/header.php"; ?>

<?php
/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */
if (isset($_POST['submit']))  {
	try {
		require "../config.php";
		require "../common.php";
		$connection = new PDO($dsn, $username, $password, $options);
		$sql = "SELECT * FROM users WHERE ballot = :ballot";
		$ballot = $_POST['ballot'];
		$statement = $connection->prepare($sql);
		$statement->bindParam(':ballot', $ballot, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();
	}
	catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
		
		<!-- Form Search -->
		<h6 class="mt-5 grey">Plataforma Nutricionistas Lev<sup>&reg;</sup></h6>
		<p>Pesquise com número da sua cédula profissional.</p>
		<form class="form-row py-2" method="post">
			<div class="col-md-10">
				<input class="form-control mr-sm-2" type="search" id="ballot" name="ballot" placeholder="ex. 9999N">
			</div>
			<div class="col-md-2">	
				<input class="btn btn-outline-primary btn-block" type="submit" name="submit" value="Submeter">
			</div>
		</form>
		<!-- /End -->

		<?php
		if (isset($_POST['submit'])) {
			if ($result && $statement->rowCount() > 0) {
				foreach ($result as $row) {
					?>

				<div class="row">
					<div class="col-md-12 mt-2">
						<ul class="list-unstyled">
							<li>Nº da Cédula: <?php echo escape($row["ballot"]); ?></li>
							<li>Nome Profissional: <?php echo escape($row['firstname'] .' '. $row['lastname']); ?></li>					
							<li>E-mail: <?php echo escape($row["email"]); ?></li>
							<li>Localidade: <?php echo escape($row["location"]); ?></li>
						</ul>
					</div>
				</div>
			<?php } ?>
			
			
			<h2 class="mt-2">Resultados</h2>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Paciente</th>
							<th scope="col">E-mail</th>
							<th scope="col">Localidade</th>
							<th scope="col">Desconto</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($result as $row) { ?>
						<tr>
							<td><?php echo escape($row["firstname"]); ?></td>
							<td><?php echo escape($row["email"]); ?></td>
							<td><?php echo escape($row["location"]); ?></td>
							<td><?php echo escape($row["discount"]); ?> </td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		
		<?php } else { ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Nenhum resultado encontrado na sua pesquisa.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php
			}
		}
		?>
	</main>

<?php include "templates/footer.php"; ?>