<?php
date_default_timezone_set('America/Sao_Paulo');

require_once  'lib/class_curl.php';
require_once  'lib/class_produto.php';
require_once  'lib/class_pedido.php';
require_once  'lib/curl_response.php';
require_once  'padrao/banco.php';
require_once  'padrao/conf.php';

$curl = new Curl;

$prod = new Produto($sql,TOKEN,REFRESHTOKEN);

$url_prod  = URL_PROD;
 
$url_refresh = "https://api.sandbox.plug4market.com.br/auth/refresh";
$url_pedidos = "https://api.sandbox.plug4market.com.br/orders/";
$url_confirma_pedido = "https://api.sandbox.plug4market.com.br/orders/7/confirm";  

$act = $_GET['action'];
 
switch ($act) {
	case 'refreshtoken':
			//// Token de renova��o (RefreshToken)
		 	if($prod->checktokenDb()){
		 		// j� esta no banco, pega sempre daqui !!
		 		$tokensArr  = $prod->gettokensDb();
				$token      = $tokensArr[0];
				$tokenfresh = $tokensArr[1];
		 	}else{
				// primeira vez pega do conf para inicializar a rotina!
		 		$tokenfresh = $prod->tokenfresh;
		 		$token      = $prod->token; 
		 	}

			$arrTokenBody = $prod->setTokenBody($tokenfresh);
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Content-Length"=> strlen($arrTokenBody),
				"Authorization" =>"Bearer ".$token
			);
			$curl->headers = $headerArgs;
			$response_token = $curl->request('POST', $url_refresh, $arrTokenBody);
			$vars_keys = json_decode($response_token->body);
			
			$arrayTokens = array(
				'token' 	   => $vars_keys->accessToken,
				'refreshtoken' => $vars_keys->refreshToken
			);

			$prod->setToken($arrayTokens);
			
		break;
 
		case 'add_produto':
		
			 //Cadastrar um produto
			$tokensArr = $prod->gettokensDb();
			$arrBody   = $prod->setProduto(1,24);
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Content-Length"=> strlen($arrBody),
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			$response = $curl->request('POST', $url_prod, $arrBody);

			if ($response->headers['Status'] == "201 Created") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Cadastro de produto realizado com Sucesso! </p><br>";
			}else{
				echo "<pre>";
				var_dump($response);
				die('Erro!');	
			}

		break;	

			case 'update_produto':
		
			 //Cadastrar um produto 
			$sku = '3';
			$sku_post = 'CW100-01';
			$tokensArr = $prod->gettokensDb();
			$arrBody = $prod->setProduto_update($sku);
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Content-Length"=> strlen($arrBody),
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			$response = $curl->put( $url_prod .'/'. $sku_post , $arrBody);

			if ($response->headers['Status'] == "201 OK") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>  Produto atualizado com  Sucesso! </p><br>";
			}else{
				echo "<pre>";
				var_dump($response);
				die('Erro!');	
			}

		break;
	
		case 'list_produto':
			 //Listar produtos
			//$arrBody = $prod->getProduto();
			$tokensArr = $prod->gettokensDb();
		 
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			$response = $curl->request('GET', $url_prod, array());

			if ($response->headers['Status'] == "200 OK") {
				$arrPedidos  = json_decode($response->body);
				$totallist = count($arrPedidos->data);   //Total
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Listagem realizado com Sucesso! total produtos {$totallist} </p><br>";
				echo "<pre>";
				foreach ($arrPedidos->data as $key => $value) {
					 print_r( " SKU :" . $value->sku);
					 print_r( ", Nome :" . $value->productName);
					echo "<br>";
				}
				echo "<br><br> <b>DETALHES: </b><br>";
				var_dump($arrPedidos);
			}else{
			echo "<pre>";
			var_dump($response);
			die('Erro!');	
			}
		break;
	
		case 'add_venda':
			//cadastrar venda
			$tokensArr = $prod->gettokensDb();
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			$response = $curl->request('GET', $url_pedidos , array());

			if ($response->headers['Status'] == "200 OK") {

				$arrPedidos  = json_decode($response->body);
				$totalvendas = count($arrPedidos->data);   //Total

				foreach ($arrPedidos->data as $ped_key => $ped) {
					  echo "venda ID : ".$ped->id . "<br>";
					  $response_inc[] = $curl->request('GET', $url_pedidos . (string) $ped->id , array());
				}

			 $ped = new Pedido($sql);
			 $ped->setVenda($response_inc);

				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Listagem realizado com Sucesso! Total de vendas : {$totalvendas}</p><br>";
				echo "<pre>";
				$arrPedidos  = json_decode($response->body);
				var_dump($arrPedidos);
			}else{

			echo "<pre>";
			var_dump($response);
			die('Erro!');	
			}
		break;


		case 'list_pedidos':
			//Lista pedidos

			$tokensArr = $prod->gettokensDb();
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			$response = $curl->request('GET', $url_pedidos , array());

			if ($response->headers['Status'] == "200 OK") {

				$arrPedidos  = json_decode($response->body);
				$totalvendas = count($arrPedidos->data);   //Total

				foreach ($arrPedidos->data as $ped_key => $ped) {
					  echo "venda ID : ".$ped->id . "<br>";
				}


				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Listagem realizado com Sucesso! Total de vendas : {$totalvendas}</p><br>";
				echo "<pre>";
				
				var_dump($arrPedidos);
			}else{

			echo "<pre>";
			var_dump($response);
			die('Erro!');	
			}
		break;
	
		case 'consulta_pedido':
			 //Consultar um pedido por id
			$id = "40cb7471-e485-491a-8f02-74e976420220";
			$tokensArr = $prod->gettokensDb();
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			// url_pedidos: https://api.sandbox.plug4market.com.br/orders/{orderId}
			$response = $curl->request('GET', $url_pedidos . $id , array());

			if ($response->headers['Status-Code'] == "200") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Consulta do pedido {$id} realizado com Sucesso! </p><br>";
				echo "<pre>";
				$arrPedidos = json_decode($response->body);
				var_dump($arrPedidos);
			}else{

			echo "<pre>";
			var_dump($response);
			}
			die;	

		break;
	
		case 'confirma_pedido':
			//Confirma��o do pedido
			$tokensArr = $prod->gettokensDb();
			$arrBody = $prod->setPedido();
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);

			$curl->headers = $headerArgs;
			// url_confirma_pedido :  https://api.sandbox.plug4market.com.br/orders/{orderId}/confirm
			$response = $curl->request('POST', $url_confirma_pedido, $arrBody);

			if ($response->headers['Status'] == "201 Created") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Pedido realizado com Sucesso! </p><br>";
			}else{
			echo "<pre>";
			var_dump($response);
			die;	
			}

		break; 
	
		case 'confirma_fatura':
		// Confirma��o do faturamento
		//https://api.sandbox.plug4market.com.br/orders/{orderId}/invoice
		/*		{
		  "nfeDate": "2019-08-24T14:15:22Z",
		  "nfeNumber": "string",
		  "nfeSerialNumber": "string",
		  "nfeAccessKey": "string",
		  "xml": "string"
		}*/

		break;	
		case 'confirma_envio':
		// Confirma��o do envio
		//https://api.sandbox.plug4market.com.br/orders/{orderId}/shipment

		/*		
			{ 
			  "trackingNumber": "BR132323232OO",
			  "shippingCarrier": "Correios - SEDEX",
			  "trackingUrl": "http://shipping.transportadora.com.br/BR132323232OO"
			}
		*/

		break;
		case 'confirma_entrega':
		// Confirma��o da entrega
		//https://api.sandbox.plug4market.com.br/orders/{orderId}/delivered

		/*		
		{
		  "deliveredAt": "2022-02-06T21:00:48.066Z"
		 }
		*/

		break;
	
	default:
		//Listar Canais de vendas
	    //https://api.sandbox.plug4market.com.br/sales-channels
		break;
}


 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
 

    <title>Plug 4 Market</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/jumbotron/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/jumbotron/jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
           
          <p>
          <b>TOKEN :</b> <?=TOKEN ?> <br>
          <b>REFRESHTOKEN :</b> <?=REFRESHTOKEN ?> <br>
         </p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2>Produtos</h2>
            <p>Pega sempre pelo sku que foi cadastrado no hub </p>
            <p><a class="btn btn-secondary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=list_produto" role="button">Listar produtos &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Produtos</h2>
            <p>Est� fixo no php o produto pois tem campos obrigat�rios que devem satisfazer a API. ID: 24</p>
            <p><a class="btn btn-secondary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=add_produto" role="button">Adicionar produto &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Produtos</h2>
            <p>Atualiza sempre pelo sku no post esta: sku = '3', sku_post = 'CW100-01';</p>
            <p><a class="btn btn-secondary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=update_produto" role="button">Atualizar produto &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Pedidos</h2>
            <p><b>Lista</b> o que esta no hub da API , lista todas vendas e vem como um Hash pra cada venda como : 35823aa6-43b5-476b-ac9e-0c65fa2d4924  </p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=list_pedidos" role="button">Listar pedidos &raquo;</a></p>
          </div>

          <div class="col-md-4">
            <h2>Pedidos</h2>
            <p><b>Consulta</b> o que esta no hub da API. A cada 15 minutos ir� realizar esta requisi��o para obter os pedidos novos.</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=consulta_pedido" role="button">Consultar um pedido &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Pedidos</h2>
            <p><b>Confirma pedido</b> o que esta no hub da API</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=confirma_pedido" role="button">Consulta pedidos &raquo;</a></p>
          </div>

               <div class="col-md-4">
            <h2>Vendas</h2>
            <p><b>Cadastrar</b> as vendas No banco com os produdos do Hub plug4market</p>
            <p><a class="btn btn-primary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=add_venda" role="button">Enviar vendas &raquo;</a></p>
          </div>

           <div class="col-md-4">
            <h2>Refresh</h2>
            <p><b>Atualiza</b> As chaves do tokens e token refresh. <br>OBS:<i>(essa requisi��o deve ser feita em at� 24h para pegar o novo token e registrar no banco)</i> </p>
            <p><a class="btn btn-info" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=refreshtoken" role="button">Enviar vendas &raquo;</a></p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->

    </main>

    <footer class="container">
      <p>&copy; Company 2017-2018</p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>









 
