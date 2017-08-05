<?php 
    require_once('config.php');
    require_once('utils.php');
?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<?php 
    
    //$creditCardToken = htmlspecialchars($_POST["token"]);
    $senderHash = htmlspecialchars($_POST["senderHash"]);

    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        //'creditCardToken'           => $creditCardToken,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'boleto', 
        'currency'                  => 'BRL',
        // 'extraAmount'               => '1.00',
        'itemId1'                   => '0001',
        'itemDescription1'          => 'PHP Test',  
        'itemAmount1'               => '100.00',  
        'itemQuantity1'             => 1,
        // 'notificationURL'           => 'url para retorno',
        'reference'                 => 'REF1234',
        'senderName'                => 'Nome a enviar',
        'senderCPF'                 => '54793120652',
        'senderAreaCode'            => 83,
        'senderPhone'               => '999999999',
        'senderEmail'               => 'nome@sandbox.pagseguro.com.br',
        'shippingAddressStreet'     => 'Address',
        'shippingAddressNumber'     => '1234',
        'shippingAddressDistrict'   => 'Bairro',
        // 'shippingAddressComplement' => 'compplemento de endereço',
        'shippingAddressPostalCode' => '58075000',
        'shippingAddressCity'       => 'Teresina',
        'shippingAddressState'      => 'PI',
        'shippingAddressCountry'    => 'BRA',
        'shippingType'              => 1,
        'shippingCost'              => '1.00'        
    );

    $header = array('Content-Type' => 'application/json; charset=UTF-8;');
    $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
    $json = json_decode(json_encode(simplexml_load_string($response)));
?>
<body>
    <h1>Pagseguro Test</h1>
    <h3>Code: <?php echo $json->code;?></h3>
    <h3>Status: <?php echo $json->status;?></h3>
    <h3>Ultima data de notificacao: <?php echo $json->lastEventDate;?></h3>
    <h3>Payment Method Type: <?php echo $json->paymentMethod->type;?></h3>
    <h3>Payment Method Code: <?php echo $json->paymentMethod->code;?></h3>
    <p>Response: <?php print_r($json);  ?></p>
</body>
</html>