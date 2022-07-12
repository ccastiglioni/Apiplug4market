<?php

    class Produto {

        private $_id;
        private $_name;
        public  $p_sql;
        public  $tokenfresh;
        public  $token;

        public function setID() { $this->_id++; }
        public function getID() { return $this->_id; }

        public function setNAME($element) { $this->_name = $element; }
        public function getNAME() { return $this->_name; }

        public function __construct($sql ,$token, $tokenfresh)
        {
            $this->token = $token;
            $this->tokenfresh = $tokenfresh;
            $this->p_sql = $sql;
        }

        public function setProduto($limit=1 , $id='') {
        
            if ($id !="") {
            	$Wr = "and prd_codigo = ".$id;
            }
            
           // $Wr = " and prd_editado='S' AND prd_descricao !='' and prd_naoenviar='S'  ORDER BY rand() LIMIT {$limit}"
            
            $consulta = "SELECT * FROM `tproduto`
                          INNER JOIN `tcategoriaproduto` ON (`tproduto`.prd_ctp_codigo = `tcategoriaproduto`.ctp_codigo) 
                          WHERE  0=0 {$Wr}" ;
            $this->p_sql->query($consulta);
            $rows = $this->p_sql->retorna();


            $salesChannels = array( 
                array('id' => 1 ,                // ID do canal de venda que se deseja publicar o produto. Para obter a lista completa consulte a documentação.
                'sellerId'=>'7',                 // Id da loja dentro de um mesmo canal de venda. Nota: Atualmente este campo abrange somente o Mercado Livre (ID = 7).
                'listingType' => 'CLASSICO',    // Enum: "CLASSICO" "PREMIUM"
                'price'=>100,
                'forSale' => 
                array(
                    'salePrice' =>99, // preço de custo
                    'saleDateStart'=> "2021-06-27T13:22:00Z",
                    'saleDateEnd'=>"2023-05-30T13:22:00Z",
                    'manufacturerPartNumber'=>'fatura',
                    'crossDockingDays'=>0 
                )
            ));

            $vars = json_encode(array(
                "productId"    => $rows['prd_codigo'],
                "productName"  => $rows["prd_nome"],
                "sku"          => 'cod-'.$rows["prd_codigo"],
                "name"         => $rows['prd_descricao'], 
                "salesChannels"=> $salesChannels,
                "categoryId"  => $rows['prd_ctp_codigo'],   
                "brand"       => $rows["ctp_nome"], 
                "description" => $rows["prd_descricao"],
                "width"  =>(int) $rows['prd_largura'], 
                "height" =>(int) $rows['prd_altura'], 
                "length" =>(int) $rows['prd_comprimento'], 
                "weight" =>(int) $rows['prd_pesobruto'], 
                "stock"  =>(int) $rows['prd_quantidade'], 
                "price"  =>(int) $rows['prd_valor'], 
                "origin" => 'nacional' // Enum: "nacional" "importado"
            ));

            return $vars;
        }

        public function setProduto_update($sku) {
         
            $consulta = "SELECT * FROM `tproduto`
                          INNER JOIN `tcategoriaproduto` ON (`tproduto`.prd_ctp_codigo = `tcategoriaproduto`.ctp_codigo) 
                          WHERE  prd_codigo={$sku}  " ;
            $this->p_sql->query($consulta);
            $rows = $this->p_sql->retorna();

            $salesChannels = array( 
                array('id' => 1 ,                // ID do canal de venda que se deseja publicar o produto. Para obter a lista completa consulte a documentação.
                'sellerId'=>'7',                 // Id da loja dentro de um mesmo canal de venda. Nota: Atualmente este campo abrange somente o Mercado Livre (ID = 7).
                'listingType' => 'CLASSICO',    // Enum: "CLASSICO" ou "PREMIUM"
                'price'=>100,
                'forSale' => 
                array(
                    'salePrice' =>99, // preço de custo
                    'saleDateStart'=> "2021-06-27T13:22:00Z",
                    'saleDateEnd'=>"2023-05-30T13:22:00Z",
                    'manufacturerPartNumber'=>'fatura',
                    'crossDockingDays'=>0 
                )
            ));

            $imagens  = [
            			0 =>"https://images.lojanike.com.br/1024x1024/produto/tenis-nike-air-force-1-07-masculino-CW2288-111.jpg",
            			1 =>"https://images.lojanike.com.br/1024x1024/produto/tenis-nike-air-force-1-07-masculino-CW2288-222.jpg",
                       ];

           $metafields =  array( 
           	 array( 
		           	"key"=> "Linha",
					"value"=> "Air Force 1")
           );      

            $vars = json_encode(array(
                "productId"    => $rows['prd_codigo'],
                "categoryId"   => $rows['prd_ctp_codigo'],   
                "productName"  => $rows["prd_nome"],
                "sku"          => 'cod-'.$rows["prd_codigo"],
                "metafields"   => $metafields, 
                "name"         => $rows['prd_descricao'], 
                "salesChannels"=> $salesChannels,
                "brand"       => $rows["ctp_nome"], 
                "description" => $rows["prd_descricao"],
                "images" => $imagens, 
                "width"  =>(int) $rows['prd_largura'], 
                "height" =>(int) $rows['prd_altura'], 
                "length" =>(int) $rows['prd_comprimento'], 
                "weight" =>(int) $rows['prd_pesobruto'], 
                "ean" => "sku001", 
                "model" => "modelo S.A", 
                "stock"  =>(int) $rows['prd_quantidade'], 
                "price"  =>(int) $rows['prd_valor'], 
                "origin" => 'nacional', // Enum: "nacional" "importado"
                "warranty" => 12, //Tempo de garantia do Produto (em meses, aceita valores decimais).
                "salePrice" => (int) $rows['prd_valor'] -5, //Preço de venda Promocional. Deve ser enviado juntamente com as datas de vigência (saleDateStart e saleDateEnd)
                "saleDateStart" => '2022-06-30T21:52:49.000-04:00',  // padrão ISO 8601: yyyy-mm-ddThh:mm:ssZ
                "saleDateEnd" => '2022-07-30T21:52:50.000-04:00'
            ));

            return $vars;
        }

        public function setTokenBody($refreshToken) {
            
            $vars = json_encode(array(
                "refreshToken" => $refreshToken
            ));

            return $vars;
        }


        public function setToken($arrayTokens)
        {
            
             if ( $this->checktokenDb() ) {

               $campo_r['add_data2'] = date('Y-m-d H:i:s');
               $campo_r['add_texto'] = $arrayTokens['refreshtoken'];
          
               $this->p_sql->atualiza("tadicionais", array_keys($campo_r), $campo_r, " WHERE add_tabela = 'refreshtoken' ");
               $this->p_sql->query();  

               $campo_t['add_data2'] = date('Y-m-d H:i:s');
               $campo_t['add_texto'] = $arrayTokens['token'];

               $this->p_sql->atualiza("tadicionais", array_keys($campo_t), $campo_t, " WHERE add_tabela = 'token' ");
               $this->p_sql->query();  
                 
             }else{

                $campo['add_data2']  = date('Y-m-d H:i:s');
                $campo['add_texto']  = $arrayTokens['refreshtoken'];
                $campo['add_tabela'] = "refreshtoken";
                $campo['add_codigo'] = $this->p_sql->maximo("tadicionais", "add_codigo") + 1; 
                $this->p_sql->adiciona("tadicionais", array_keys($campo), $campo);
                $this->p_sql->query(); 

                $campo['add_data2'] = date('Y-m-d H:i:s');
                $campo['add_texto'] = $arrayTokens['token'];
                $campo['add_tabela'] = "token";
                $campo['add_codigo'] = $this->p_sql->maximo("tadicionais", "add_codigo") + 1; 
                $this->p_sql->adiciona("tadicionais", array_keys($campo), $campo);
                $this->p_sql->query(); 

             }
             
        }

         public function checktokenDb(){
            $consulta = "SELECT * FROM `tadicionais` WHERE add_tabela='refreshtoken' OR add_tabela='refresh'";
            $this->p_sql->query($consulta);
            $num = $this->p_sql->numerodelinhas();
             
             if ( $num > 0 ) {
               $return = true;
             }else{
               $return = false;
             }
             
             return $return; 
         }

        public function setPedido() {
             
            $vars = json_encode(array(
                "orderIdStore"    => '7'
            ));

            return $vars;
        }

        public function gettokensDb()
        {
            $consulta = "SELECT * FROM `tadicionais` WHERE add_tabela='refreshtoken'";
            $this->p_sql->query($consulta);
            $row        = $this->p_sql->retorna();
            $tokenfresh = $row['add_texto'];

            $consulta = "SELECT * FROM `tadicionais` WHERE add_tabela='token'";
            $this->p_sql->query($consulta);
            $row   = $this->p_sql->retorna();
            $token = $row['add_texto'];

            $tokensArr = [$token,$tokenfresh];  
            //$tokenfresh = $this->tokenfresh;

             return $tokensArr; 
        }

 
    }
?>