
<table id="list_all">
	<thead>
		<tr>
			<td>ID</td>
			<td>Nombre</td>
			<td>Texto</td>
			<td>Articulo</td>
			<td>Descripción</td>
			<td>Acción</td>
		</tr>
	</thead>
	<tbody>
		
	<?php

	

if($result = $slider->getAll()){
	foreach ($result as $key => $item) {


			?>
			<tr>
				<td><?php echo $item["id"]; ?></td>
				<td><?php echo $item["name"]; ?></td>
				<td><?php echo $item["label"]; ?></td>
				<td><?php echo $item["article"]; ?></td>
				<td><?php echo $item["description"]; ?></td>
				<td>
					<a href="./index.php?page=forms&action=edit&table=sliders&id=<?php echo $item['id']; ?>"><?php echo $edit_button; ?></a>

				</td>
			</tr>
			<?php
		}
	}

	?>
	</tbody>
</table>