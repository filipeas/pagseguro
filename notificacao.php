<?php 
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

require_once('config.php');
require_once('utils.php');

$name = 'arquivo.txt';
$text = "\n" . 'notificacao recebida em ' . date('Y-m-d') . "\n";
$file = fopen($name, 'a');
fwrite($file, $text);
fclose($file);

if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){	

	$email = $PAGSEGURO_EMAIL;
	$token = $PAGSEGURO_TOKEN;

	$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$transaction= curl_exec($curl);
	curl_close($curl);

	if($transaction == 'Unauthorized'){
		print_r("nao autorizado");
		exit;
	}
	$transaction = simplexml_load_string($transaction);

	$status = $transaction->status;
	$idPedido = $transaction->reference;
	$data = $transaction->lastEventDate;
	$codigoTransacao = $transaction->code;
	$metodoPagamentoType = $transaction->paymentMethod->type;
	$metodoPagamentoCode = $transaction->paymentMethod->code;

	$name = 'arquivo.txt';
	// $text = var_export($_POST, true);
	$text = "\n" . 'status = ' . $status . ' || id de referencia = ' . $idPedido . ' || data de transacao = ' . $data . ' || codigo de trasacao = ' . $codigoTransacao . ' || metodo de pagamento (tipo) = ' . $metodoPagamentoType . ' || metodo de pagamento (codigo) = ' . $metodoPagamentoCode;
	$file = fopen($name, 'a');
	fwrite($file, $text);
	fclose($file);

} else{
	$name = 'arquivo.txt';
	$text = 'nao foi possivel gravar no arquivo.txt';
	$file = fopen($name, 'a');
	fwrite($file, $text);
	fclose($file);
}

?>