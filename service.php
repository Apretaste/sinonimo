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
			$response->setCache();
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
			$response->createFromTemplate('basic.tpl', array('syns' => $syns, 'word' => $word));
		}
		else
		{
			$response->setResponseSubject("No se encontraron sinonimos para la palabra $word");
			$response->createFromTemplate('nosyn.tpl', array('word' => $word));
		}

		$response->setCache();
		return $response;
	}

	/**
	 * Get a list of synonyms for a word in Spanish
	 *
	 * @author kumahacker
	 * @param String $word
	 * @return array
	 */
	public function getSynonyms($word)
	{

		$url = "https://www.sinonimosonline.com/$word/";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);

		$s = 'class="sinonimo">';
		$p = 0;
		$synonyms = array();
		do {
			$p = strpos($response, $s, $p);
			if ($p===false)
				break;
			$p += strlen($s);
			$p1 = strpos($response, '</a>', $p);
			$word = substr($response, $p, $p1-$p);
			$synonyms[] = $word;;
		} while (true);

		return $synonyms;
	}
}
