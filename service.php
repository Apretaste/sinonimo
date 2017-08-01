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

		// do not allow blank searches
		if(empty($word))
		{
			$response = new Response();
			$response->setResponseSubject("Que desea buscar en Wikipedia?");
			$response->createFromTemplate("home.tpl", array());
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
			$response->setResponseSubject("Sinonimos de la palabra $word");
			$response->createFromTemplate('basic.tpl', array(
				'syns' => $syns,
				'word' => $word
			));
		}
		else
		{
			$response->setResponseSubject("No se encontraron sinonimos para la palabra $word");
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
		$accessKey = "WcSnnf_8poEwPrqfRUwRHBjCLx0a";
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
		$responses = @json_decode($response);

		if (is_array($responses))
			if ($http_status == 200)
			{
				foreach ($responses as $synonym)
				{
					$synonyms[] = $synonym->valor;
				}
			}

		return $synonyms;
	}
}
