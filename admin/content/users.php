
<a href="./index.php?page=forms&action=create&table=users" class="create-new"><?php echo $new_button; ?></a>

<table id="list_all">
	<thead>
		<tr>
			<td>ID</td>
			<td>Nombre de Usuario</td>
			<td>Email</td>
			<td>Nombre Completo</td>
			<td>Rango</td>
			<td>Contraseña</td>
			<td>Ultima IP</td>
			<td>Acción</td>
		</tr>
	</thead>
	<tbody>
		
	<?php

	

if($resultado = $user->getAll()){
	foreach ($resultado as $key => $item) {


			?>
			<tr>
				<td><?php echo $item["id"]; ?></td>
				<td><?php echo $item["username"]; ?></td>
				<td><?php echo $item["email"]; ?></td>
				<td><?php echo $item["fullname"]; ?></td>
				<td><?php echo $item["rank"]; ?></td>
				<td><?php echo $item["password"]; ?></td>
				<td><?php echo $item["last_ip"]; ?></td>
				<td>
					<a href="./index.php?page=forms&action=edit&table=users&id=<?php echo $item['id']; ?>"><?php echo $edit_button; ?></a>
					<a href="./actions.php?action=delete&table=users&id=<?php echo $item['id']; ?>&name=<?php echo $item["username"]; ?>"><?php echo $delete_button; ?></a>

				</td>
			</tr>
			<?php
		}
	}

	?>
	</tbody>
</table>