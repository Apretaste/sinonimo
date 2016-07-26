<h1>Sin&oacute;nimos de '{$word}'</h1>
<p>A continuaci&oacute;n te mostramos los sin&oacute;nimos encontrados y una lista de acciones que puedes hacer con ellos, como buscar la palabra en Internet mediante Google, buscarla en Wikipedia o buscar m&aacute;s sin&oacute;nimos.</p>
<table width="100%">
	{foreach item=item from=$syns}
	<tr>
		<td>{$item}</td>
		<td>{button href="SINONIMO {$item}" caption="ver sinonimo" size="small" color="blue"}</td>
		<td>{button href="GOOGLE {$item}" caption="googlear" size="small" color="green"}</td>
		<td>{button href="WIKIPEDIA {$item}" caption="leer en wiki" size="small" color="grey"}</td>
	</tr>
	{/foreach}
</table>
{space10}
<center>{button href="GOOGLE {$word}" caption="Buscar <b>{$word}</b> en Google" size="large"} {button href="WIKIPEDIA {$word}" caption="Buscar <b>{$word}</b> en Wikipedia" size="large" color="grey"}</center>
