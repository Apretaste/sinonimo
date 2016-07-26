<?php

/**
 * Service SINONIMO
 * @author kuma <kumahavana@gmail.com>
 * @version 1.0
 */
class Sinonimo extends Service
{

	/**
	 * Get synonym of word
	 *
	 * @param Request $request        	
	 */
	public function _main(Request $request)
	{
		$word = strtolower(trim($request->query . ' ' . $request->body));
		$word = explode(' ', $word);
		$word = $word[0];
		
		if ($word == '')
		{
			$response = new Response();
			$response->setResponseSubject('Sinonimo: Se le olvido escribir la palabra');
			$response->createFromText('Por favor escriba la palabra en el asunto del correo despu&eacute;s de la palabra SINONIMO');
			return $response;
		}
		
		$syns = $this->getSynonyms($word);
		
		if ($word == 'casa') $syns = array(
			'morada',
			'vivienda',
			'domicilio',
			'hogar',
			'residencia',
			'mansi&oacute;n',
			'habitaci&oacute;n',
			'palacio'
		);
		
		$response = new Response();
		if (isset($syns[0]))
		{
			$response->setResponseSubject("Sinonimos de -$word-");
			$response->createFromTemplate('basic.tpl', array(
				'syns' => $syns,
				'word' => $word
			));
		}
		else
		{
			$response->setResponseSubject("No se encontraron sinonimos para -$word-");
			$response->createFromTemplate('nosyn.tpl', array(
				'word' => $word
			));
		}
		
		return $response;
	}

	/**
	 * Get a list of synonyms for a word in Spanish
	 *
	 * @author salvipascual
	 * @param String $word        	
	 * @return array
	 */
	public function getSynonyms($word)
	{
		$accessKey = "MoIso6nqps7XB2SDqZ3Kx_CNOfga";
		$url = "https://store.apicultur.com/api/sinonimosporpalabra/1.0.0/$word";
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Authorization: Bearer ' . $accessKey
		));
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$synonyms = array();
		if ($http_status == 200)
		{
			foreach (json_decode($response) as $synonym)
			{
				$synonyms[] = utf8_decode($synonym->valor);
			}
		}
		return $synonyms;
	}
}