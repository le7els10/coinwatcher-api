<?php defined("BASEPATH") or die("<h1>El script no puede ser accedido directamente</h1>"); ?>

<div style="max-width:850px;">

	<h3><?= $title; ?></h3>

	<div class="ui buttons">
		<a href="<?= $back_link; ?>" class="ui button blue"><i class="icon left arrow"></i></a>

	</div>

</div>

<br>
<br>

<div style="max-width:100%;">

	<table process="<?= $process_table; ?>" style='width:100%;' class="ui table striped celled grey inverted">
		<thead>
			<tr>
				<th>Categoría</th>
				<th>Descripción</th>
				<th>Valor</th>
				<th>Usuario</th>
				<th>Fecha</th>

			</tr>
		</thead>
	</table>

</div>

<script>
	window.onload = () => {

		let table = $(`[process]`)
		let processURL = table.attr('process')
		dataTableServerProccesing(table, processURL, 10)

	}
</script>
