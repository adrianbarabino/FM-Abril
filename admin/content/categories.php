
<a href="./index.php?page=forms&action=create&table=categories" class="create-new"><?php echo $new_button; ?></a>

<table id="list_all">
	<thead>
		<tr>
			<td>ID</td>
			<td>Nombre</td>
			<td>Descripción</td>
			<td>Slug</td>
			<td>Acción</td>
		</tr>
	</thead>
	<tbody>
		
	<?php

	

if($result = $category->getAll()){
	foreach ($result as $key => $item) {


			?>
			<tr>
				<td><?php echo $item["id"]; ?></td>
				<td><?php echo $item["name"]; ?></td>
				<td><?php echo $item["description"]; ?></td>
				<td><?php echo $item["slug"]; ?></td>
				<td>
					<a href="./index.php?page=forms&action=edit&table=categories&id=<?php echo $item['id']; ?>"><?php echo $edit_button; ?></a>
					<a href="./actions.php?action=delete&table=categories&id=<?php echo $item['id']; ?>&name=<?php echo $item["name"]; ?>"><?php echo $delete_button; ?></a>

				</td>
			</tr>
			<?php
		}
	}

	?>
	</tbody>
</table>