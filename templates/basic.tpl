<h1>Sin&oacute;nimos de '{$word}'</h1>
<p>A continuaci&oacute;n te mostramos los sin&oacute;nimos encontrados. Tambi&eacute;n puedes buscar en Google y Wikipedia para obtener m&aacute;s informaci&oacute;n.</p>
<table width="100%">
	<tr><th align="left"><b>{$word}</b></th>
	<th></th>
	<th align="left">{button href="GOOGLE {$word}" caption="googlear" size="small" color="grey"}</th>
	<th align="left">{button href="WIKIPEDIA {$word}" caption="leer en wiki" size="small" color="grey"}</th>
	</tr>
	{foreach item=item from=$syns}
	<tr>
		<td>{$item}</td>
		<td>{button href="SINONIMO {$item}" caption="ver sinonimo" size="small" color="blue"}</td>
		<td>{button href="GOOGLE {$item}" caption="googlear" size="small" color="green"}</td>
		<td>{button href="WIKIPEDIA {$item}" caption="leer en wiki" size="small" color="grey"}</td>
	</tr>
	{/foreach}
</table>
