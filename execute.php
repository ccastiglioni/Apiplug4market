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
 
$act = $_GET['action'];
 
switch ($act) {
	case 'refreshtoken':
			//// Token de renovação (RefreshToken)
		 	if($prod->checktokenDb()){
		 		// já esta no banco, pega sempre daqui !!
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
		  $prd_codigo = $_GET['id_codigo'];

			$tokensArr = $prod->gettokensDb();
			$arrBody   = $prod->setProduto(1,$prd_codigo);
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
		  $emp_codigo ='2010';
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
					  $response_inc[$ped->id] = $curl->request('GET', $url_pedidos . (string) $ped->id , array());
				}

			 $ped = new Pedido($sql);
			 $ped->setVenda($response_inc,$emp_codigo);

				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Cadastro de vendas realizado com Sucesso! Total de vendas : {$totalvendas}</p><br>";
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
			/*
			** Confirmação do pedido
			** status 6 recebido
			** status 7 confirma pedido
			** status 8 confirmado fatura
		 */
			$tokensArr = $prod->gettokensDb();
			$arrBody = $prod->setbodyschemaPedido(001,$fatura='',$rastreio='',$entrega='');
			$headerArgs =array(
				"Content-Type"  =>"application/json",
				"Authorization" =>"Bearer ".$tokensArr[0]
			);
			$curl->headers = $headerArgs;

			$ped = new Pedido($sql);
 
			 foreach ($ped->getconfirmPedido() as $key => $id_pedido) {
					if (!empty($id_pedido)){
							$url_confirma_pedido = $url_pedidos . $id_pedido . "/confirm";
							$response = $curl->request('POST', $url_confirma_pedido, $arrBody);
					    if ($response->headers['Status-Code'] == "200") {
					    	 $arr_resp = $ped->setconfirmPedido($id_pedido);
					    	 if ($arr_resp['status'] =='success') {
					    	 	   echo json_encode($arr_resp);
					    	 }else{
					    	 	   echo json_encode($arr_resp);
					    	 }
					    }

					}else{
					 	echo json_encode('Nenhum pedido pendente em tvenda!');
					 	//die;
					}
			 }

			if ($response->headers['Status'] == "200 OK") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Pedido confirmado com Sucesso! </p><br>";
				echo "<pre>";
				var_dump($response);
				die;

			}else{
				echo "<pre>";
				var_dump($response);
				die;	
			}

		break; 
	
		case 'confirma_fatura': 
		/*
			** Confirmação do Faturamento
			** status 6 recebido
			** status 7 confirma pedido
			** status 8 confirma fatura
		 */
		$tokensArr = $prod->gettokensDb();
		$arrBody   = $prod->setbodyschemaPedido($pedido='','fatura',$rastreio='',$entrega='');
	 

		$headerArgs =array(
			"Content-Type"  =>"application/json",
			"Authorization" =>"Bearer ".$tokensArr[0]
		);
		$curl->headers = $headerArgs;

  	$ped = new Pedido($sql);

		foreach ($ped->getconfirmFatura() as $key => $id_pedido) {
				if (!empty($id_pedido)){
						$url_confirma_pedido = $url_pedidos . $id_pedido . "/invoice";
						$response = $curl->request('POST', $url_confirma_pedido, $arrBody);
				    if ($response->headers['Status-Code'] == "200") {
				    	 $arr_resp = $ped->setconfirmPedido($id_pedido,8);
				    	 if ($arr_resp['status'] =='success') {
				    	 	   echo json_encode($arr_resp);
				    	 }else{
				    	 	   echo json_encode($arr_resp);
				    	 }
				    }

				}else{
				 	echo json_encode('Nenhum pedido pendente em tvenda!');
				 	//die;
				}
		 }

	
		if ($response->headers['Status'] == "200 OK") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Pedido confirmado com Sucesso! </p><br>";
				echo "<pre>";
				var_dump($response);
				die;

		}else{
				echo "<pre>";
				var_dump($response);
				die;	
		}

		break;	

		case 'confirma_envio':

		// Confirmação do envio
		//https://api.sandbox.plug4market.com.br/orders/{orderId}/shipment
		/*
			** Confirmação do Faturamento
			** status 6 recebido
			** status 7 confirma pedido
			** status 8 confirma fatura
			** status 9 Confirmação do envio (dados de rastreamento do pedido)
		 */
		$tokensArr = $prod->gettokensDb();
		$arrBody   = $prod->setbodyschemaPedido($pedido='',$fatura='','rastreio',$entrega='');
	 
		$headerArgs =array(
			"Content-Type"  =>"application/json",
			"Authorization" =>"Bearer ".$tokensArr[0]
		);
		$curl->headers = $headerArgs;

  	$ped = new Pedido($sql);

		foreach ($ped->getconfirmEnvio() as $key => $id_pedido) {
				if (!empty($id_pedido)){
						$url_confirma_pedido = $url_pedidos . $id_pedido . "/shipment";
						$response = $curl->request('POST', $url_confirma_pedido, $arrBody);
				    if ($response->headers['Status-Code'] == "200") {
				    	 $arr_resp = $ped->setconfirmPedido($id_pedido,9);
				    	 if ($arr_resp['status'] =='success') {
				    	 	   echo json_encode($arr_resp);
				    	 }else{
				    	 	   echo json_encode($arr_resp);
				    	 }
				    }

				}else{
				 	echo json_encode('Nenhum pedido faturado ( status=8 ) em tvenda!');
				 	//die;
				}
		 }

	
		if ($response->headers['Status'] == "200 OK") {
				echo "<br><p style='color:#155724;background-color:#d4edda;border-color:#c3e6cb;padding:13px;'>Pedido confirmado com Sucesso! </p><br>";
				echo "<pre>";
				var_dump($response);
				die;

		}else{
				echo "<pre>";
				var_dump($response);
				die;	
		}

		break;	


		case 'confirma_entrega':
		// Confirmação da entrega
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
            <p>Está fixo no php o produto pois tem campos obrigatórios(peso,largura,altura.. etc) que devem satisfazer a API. ID: 35</p>
            <p><a class="btn btn-secondary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=add_produto&id_codigo=35" role="button">Adicionar produto &raquo;</a></p>
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
            <p><b>Consulta</b> o que esta no hub da API. A cada 15 minutos irá realizar esta requisição para obter os pedidos novos.</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=consulta_pedido" role="button">Consultar um pedido &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Pedidos 1</h2>
            <p><b>Confirma pedidos</b> Após um novo pedido ter sido identificado no Hub, é necessário realizar a confirmação da integração do pedido com o ID que está em vnd_campo1 e status = 6, muda pra status=7</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=confirma_pedido" role="button">Confirmar pedidos &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Pedidos 2</h2>
            <p><b>Confirmação do faturamento</b> Após a integração do pedido em seu sistema, para prosseguir com o processo de venda é essencial o envio da nota fiscal ao comprador.</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=confirma_fatura" role="button">Enviar nota fiscal &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>Pedidos 3</h2>
            <p><b>Confirmação de Pedido (envio do cod rastreamento correios)</b>Após o faturamento, é necessário enviar os dados de envio para o comprador poder rastrear sua compra. Esta rota permite receber os dados de rastreamento, podendo ser o número/código de rastreio, o nome da transportadora e uma URL para rastreio (se houver).</p>
            <p><a class="btn btn-success" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=confirma_envio" role="button">Enviar Cod de Rastreio &raquo;</a></p>
          </div>

               <div class="col-md-4">
            <h2>Vendas</h2>
            <p><b>Cadastrar</b> as vendas No banco com os produdos do Hub plug4market</p>
            <p><a class="btn btn-primary" href="http://desenvolvimento.vaplink.com.br/dev/cleber/plug4market/execute.php?action=add_venda" role="button">Enviar vendas &raquo;</a></p>
          </div>

           <div class="col-md-4">
            <h2>Refresh</h2>
            <p><b>Atualiza</b> As chaves do tokens e token refresh. <br>OBS:<i>(essa requisição deve ser feita em até 24h para pegar o novo token e registrar no banco)</i> </p>
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









 
