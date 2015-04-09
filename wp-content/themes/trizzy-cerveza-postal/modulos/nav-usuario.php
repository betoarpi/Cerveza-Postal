<div class="CP-perfilOptionsWrapper">
	<div class="CP-perfilOptions">
		<div class="arrow"></div>
			<p class="name">Configuración de tu Cuenta</p>
			<ul>
				<li><a class="perfil" href="<?php bloginfo('siteurl') ?>/perfil/"><i class="fa fa-user"></i> Perfil</a></li>
				<li><a class="edit" href="<?php bloginfo('siteurl') ?>/editar-perfil/"><i class="fa fa-pencil"></i> Editar Perfil</a></li>
				<li><a class="account" href="<?php bloginfo('siteurl') ?>/mi-cuenta-2/"><i class="fa fa-credit-card"></i> Mi Cuenta</a></li>
				<li><a clas="record" href="<?php bloginfo('siteurl') ?>/mi-historial/"><i class="fa fa-history"></i> Mi Historial de Pedidos</a></li>
				<li><a class="favorites" href="<?php bloginfo('siteurl') ?>/mis-favoritas/"><i class="fa fa-beer"></i> Mis Favoritas</a></li>
				<li><a class="order" href="<?php bloginfo('siteurl') ?>/estado-del-pedido/"><i class="fa fa-shopping-cart"></i> Estado del Pedido</a></li>
				<li><a class="sign-out" href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
			</ul>
		</div>
	</div>
</div>