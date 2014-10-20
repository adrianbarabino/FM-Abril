
<a href="./index.php?page=forms&action=create&table=content" class="create-new"><?php echo $new_button; ?></a>

<table id="list_all">
	<thead>
		<tr>
			<td>ID</td>
			<td>Categoria</td>
			<td>Autor</td>
			<td>Titulo</td>
			<td>Contenido (Corto)</td>
			<td>Fecha</td>
			<td>Tags</td>
			<td>Slug</td>
			<td>Acción</td>
		</tr>
	</thead>
	<tbody>
		
	<?php

	

if($resultado = $content->getAll()){
	foreach ($resultado as $key => $item) {


			?>
			<tr>
				<td><?php echo $item["id"]; ?></td>
				<td><?php echo $item["category"]; ?></td>
				<td><?php echo $item["author"]; ?></td>
				<td><?php echo $item["title"]; ?></td>
				<td><?php echo $item["short_content"]; ?></td>
				<td><?php echo $item["date"]; ?></td>
				<td><?php echo $item["tags"]; ?></td>
				<td><?php echo $item["slug"]; ?></td>
				<td>
					<a href="./index.php?page=forms&action=edit&table=content&id=<?php echo $item['id']; ?>"><?php echo $edit_button; ?></a>
					<a href="./actions.php?action=delete&table=content&id=<?php echo $item['id']; ?>&name=<?php echo $item["username"]; ?>"><?php echo $delete_button; ?></a>

				</td>
			</tr>
			<?php
		}
	}

	?>
	</tbody>
</table>