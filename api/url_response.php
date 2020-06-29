<?php
/*
Arquivo: url_response.php
Este arquivo é responsável por processar a requisição e
retornar a página devida.
Nesse caso, retornará apenas um JSON em todos os casos
*/
function url_response(Array $urlpatterns) {
	foreach ($urlpatterns as $pcre => $app) {
		$urls = tratamentUrl($pcre);
		if (preg_match("@^{$urls}$@", str_replace('/'.DIR['api'], '', $_SERVER['REQUEST_URI']), $_GET)) {
			if (strpos($app, '.') === false) {
				$app .= '.php';
			}
			$app = 'actions/'.$app;
			if (!file_exists($app)) {
				include($app);
				exit;
			}
		}
	}
	// Caso não encontre a página, retornará um erro
	print(Classes\Base\Parse::toJson(array('status'=>404, 'msg'=>MSG['page404'])));
}

function tratamentUrl($pcre) {
	$urls = explode('/', $pcre);
	for ($i = 0; $i < count($urls); $i++) { // para cada get da url
		$url = $urls[$i];
		if (strpos($url, '{') === false) // se não for um parâmetro
			continue;
		$param = explode(':', $url);
		$url = str_replace('{', '(?P<', $url);
		if (count($param) > 1) {
			if ($param[1] == 'int}') {
				$url = str_replace(':'.$param[1], '>\d+)', $url);
			} else {
				$url = str_replace(':'.$param[1], '>[-\w]+)', $url);
			}
		} else {
			$url = str_replace('}', '>[-\w]+)', $url);
		}
		$urls[$i] = $url;
	}
	$urls = implode('/', $urls);
	return $urls;
}
?>
