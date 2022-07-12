<?php

 
/*
 
 
INFORMACOES>>>>>

https://api.sandbox.plug4market.com.br/docs
https://api.sandbox.plug4market.com.br/

CNPJ:
04.026.307/0001-12

Token do Hub:
c533642e337e9a78f7aa8965cf72ffbcf7dd55d919514b8a5400927c4541ecf1f9467ffc1cff4dd3f518f8738dc1ee52c70946ee92994fc749c4beda8de34a6f

ID da Loja no Marketplace
62b4b54e9b3fcc000196d2e1


Token de Acesso:
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzb2Z0d2FyZUhvdXNlIjoiMDQwMjYzMDcwMDAxMTIiLCJzdG9yZSI6IjA0MDI2MzA3MDAwMTEyIiwidXJsIjoiYXBpLnNhbmRib3gucGx1ZzRtYXJrZXQuY29tLmJyIiwidXNlcklkIjoiODk1NzkzOTUtY2M5OS00YTJhLThiYjktOGUyMTY1ZDc2MTFkIiwicmVmcmVzaFRva2VuIjoiZDlkNDE3ODM4MDMyNTU3MzU1YmVlMmY0NjExYzZjODlkMTQwMjU2NGYyOTQ3NjE4OGZkY2Q2OWVmMTEzYzk4NyIsInR5cGUiOiJzdG9yZSIsImlhdCI6MTY1NjEwMTc3NCwiZXhwIjoxNjU2MTg4MTc0fQ.GpU24VRK7q6ucvhdgpVDyR7JcdvFlkkDVz_xpbi4vMU

Token de Renovação:
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzb2Z0d2FyZUhvdXNlQ25waiI6IjA0MDI2MzA3MDAwMTEyIiwic3RvcmVDbnBqIjoiMDQwMjYzMDcwMDAxMTIiLCJ1c2VySWQiOiI4OTU3OTM5NS1jYzk5LTRhMmEtOGJiOS04ZTIxNjVkNzYxMWQiLCJyZWZyZXNoVG9rZW4iOiJkOWQ0MTc4MzgwMzI1NTczNTViZWUyZjQ2MTFjNmM4OWQxNDAyNTY0ZjI5NDc2MTg4ZmRjZDY5ZWYxMTNjOTg3IiwiaWF0IjoxNjU2MTAxNzc0LCJleHAiOjE2NTY3MDY1NzR9.F12r4MuYTDT0byn3_KOwwmjekpmlJmCUtYmXwdwl01Y

Sandbox:
https://api.sandbox.plug4market.com.br/
Produção:
https://api.plug4market.com.br/

<ANDRE>
Acesso painel de monitoramento: https://hub.sandbox.plug4market.com.br/

E-mail: andre@vapnet.com.br
Senha: V@pn&t951

Acesso Tokens ao painel da loja:  https://app.sandbox.plug4market.com.br/

E-mail: andre@vapnet.com.br
Senha: V@pn&t951

Documentação de apoio para desenvolvimento: 

 - https://atendimento.tecnospeed.com.br/hc/pt-br/articles/4410708572311-Primeiros-passos-com-a-API-do-Plug4Market
 - https://api.sandbox.plug4market.com.br/docs
</ANDRE>


<<<<<INFORMACOES

painel HUB:

    URL webhook de pedidos (API):
        https://api.sandbox.plug4market.com.br/notifications?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodWIiOiIyNDkyOTk3MzAwMDE3OCIsInR5cGUiOiJodWJNYXJrZXRQbGFjZSIsImlhdCI6MTY1MTY4NzMzOSwiZXhwIjoxNjY3MjM5MzM5fQ.5PVkP-vjyHTRh-K9GQDG-luOh2HQPehKoL5lp6eCHvQ
    ID da Loja
        62b4b54e9b3fcc000196d2e1

*/


$url= "https://api.plug4market.com.br/";
$url= "https://api.sandbox.plug4market.com.br/";

$url= "https://api.plug4market.com.br/products"; // producao
$url= "https://api.sandbox.plug4market.com.br/products";

//$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzb2Z0d2FyZUhvdXNlIjoiMDQwMjYzMDcwMDAxMTIiLCJzdG9yZSI6IjA0MDI2MzA3MDAwMTEyIiwidXJsIjoiYXBpLnNhbmRib3gucGx1ZzRtYXJrZXQuY29tLmJyIiwidXNlcklkIjoiODk1NzkzOTUtY2M5OS00YTJhLThiYjktOGUyMTY1ZDc2MTFkIiwicmVmcmVzaFRva2VuIjoiZDlkNDE3ODM4MDMyNTU3MzU1YmVlMmY0NjExYzZjODlkMTQwMjU2NGYyOTQ3NjE4OGZkY2Q2OWVmMTEzYzk4NyIsInR5cGUiOiJzdG9yZSIsImlhdCI6MTY1NjEwMTc3NCwiZXhwIjoxNjU2MTg4MTc0fQ.GpU24VRK7q6ucvhdgpVDyR7JcdvFlkkDVz_xpbi4vMU";
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzb2Z0d2FyZUhvdXNlIjoiMDQwMjYzMDcwMDAxMTIiLCJzdG9yZSI6IjA0MDI2MzA3MDAwMTEyIiwidXJsIjoiYXBpLnNhbmRib3gucGx1ZzRtYXJrZXQuY29tLmJyIiwidXNlcklkIjoiODk1NzkzOTUtY2M5OS00YTJhLThiYjktOGUyMTY1ZDc2MTFkIiwicmVmcmVzaFRva2VuIjoiYTE4ZWI1NmY3NGVhZWIxYjdjMjA3NmU5ZDI2MmQxYzgzNWRlNTMyZDZkYjQ4N2Y5YzQzZWE1NTA4MzU2NDA4MyIsInR5cGUiOiJzdG9yZSIsImlhdCI6MTY1NjQyMDMzMSwiZXhwIjoxNjU2NTA2NzMxfQ.dotnacvsB0hue16wcGhzzelu3VTn6R2n4ZUQE_s3-fI";
$token_refresh = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzb2Z0d2FyZUhvdXNlQ25waiI6IjA0MDI2MzA3MDAwMTEyIiwic3RvcmVDbnBqIjoiMDQwMjYzMDcwMDAxMTIiLCJ1c2VySWQiOiI4OTU3OTM5NS1jYzk5LTRhMmEtOGJiOS04ZTIxNjVkNzYxMWQiLCJyZWZyZXNoVG9rZW4iOiI2NDhkMmI5MmUwMDI4OWIyNWU3ZTM5OGMwMzQ0ZjVmNzczMmZmMjdlOGY4ZmQxZmQ0NmI3ZmQ1NDdkN2M5YmVjIiwiaWF0IjoxNjU2MzI5MDY0LCJleHAiOjE2NTY5MzM4NjR9.558s8ChFymzyCZekQfMsZUBd-EQGLNh0hnZWfddVn3c";

//$return_base = post_url_base($url);
$return = post_bear($url,$token);

echo "<pre>";
var_dump($return );
die;

    function post_bear($url , $token){
    
                $accesstoken = $token;
                $conf_venda = array(  
                    array('id' => 1,
                     'sellerId'=>'7',
                     'listingType' => 'CLASSICO',
                     'price'=>100,
                      'forSale' => 
                          array('salePrice' =>99, // preço de custo
                            'saleDateStart'=> "2020-04-30T13:22:00Z",
                            'saleDateEnd'=>"2025-05-30T13:22:00Z",
                            'manufacturerPartNumber'=>'fatura',
                            'crossDockingDays'=>0 )
                      ));
 

                $ch = curl_init();
                 $postfields = json_encode(array(
                    "productId"    => "CW234",
                    "productName" => "Camisas curta",
                    "sku" =>'CW201-34',
                    "name" =>'Camisas curta', 
                    "salesChannels" =>$conf_venda, 
                    "categoryId" =>'0003',   
                    "brand" =>"Nike - polo ", 
                    "description" =>'camisa nike decricao polo ' ,
                     //"images" => array(),
                      "width" =>1000, 
                      "height" =>222, 
                      "length" =>333, 
                      "weight" =>66, 
                      "stock" =>41, 
                      "price" =>554, 
                      "origin" =>"importado" 
         
                ));
                
        

                   $headerArgs =array(
                    "Content-Type: application/json",
                    'Content-Length: ' . strlen($postfields),
                    "Authorization: Bearer ".$token
                );

                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    //CURLOPT_ENCODING => "",
                    //CURLOPT_POST => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_POSTFIELDS =>$postfields,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER => $headerArgs
                ));

                $errors = curl_error($ch);     
                $result = curl_exec($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $convertArr = json_decode($result,true);

                if ($errors) {
                    $returnFormat[] = $errors;
                    $returnFormat[] = $status_code;
                    $returnFormat['URL'] = $url;
                    $returnFormat['token'] = $token;
                    $returnFormat['hora'] = @date('d-m-Y H:i:s - O');
                }else{
                   $returnFormat[] = $convertArr; 
                   $returnFormat[] = $status_code; 
                    $returnFormat['hora'] = @date('d-m-Y H:i:s - O');
                }
            return $returnFormat;
            }

    function post_url_2($url , $token){
         

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Authorization: Bearer {token}"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $errors = curl_error($ch);     
        $result = curl_exec($ch);
        curl_close($ch);
        $convertArr = json_decode($result,true);

        if ($errors) {
            $returnFormat = $errors;
        }else{
            $returnFormat = $convertArr; 
        }

           
        return $returnFormat;

    }

    function preparePostFields($array) {
  $params = array();

  foreach ($array as $key => $value) {
    $params[] = $key . '=' . urlencode($value);
  }

  return implode('&', $params);
}


//realmoney : 7i7griyhtzde6qjg3ce7b1qy42a32bv03l3gnye1x70s3.apps.vivapayments.com
function post_url_base($url){

    // https://api.sandbox.plug4market.com.br/notifications
    // ?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodWIiOiIyNDkyOTk3MzAwMDE3OCIsInR5cGUiOiJodWJNYXJrZXRQbGFjZSIsImlhdCI6MTY1MTY4NzMzOSwiZXhwIjoxNjY3MjM5MzM5fQ.5PVkP-vjyHTRh-K9GQDG-luOh2HQPehKoL5lp6eCHvQ

        $login = "andre@vapnet.com.br";
        $password = "V@pn&t951";
        $credentials = "$login:$password";
        
        $ch = curl_init();
        $options = array(
            CURLOPT_URL =>$url,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $credentials,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded'
            ),
            CURLOPT_POSTFIELDS => "grant_type=client_credentials"
        );

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        return json_decode($result,true);

}
 
?>