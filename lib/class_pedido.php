<?php

    class Pedido {

        private $_id;
        private $_name;
        private $user_id;
        public  $p_sql;
        public $saleChannelId = array(
            1=>"Amazon",
            26>"Shopee",
            7=>"Mercado Livre"
        );

         
        public function __construct($sql)
        {
            $this->p_sql = $sql;
        }

        public function setVenda($arr_pedidos ) {
                    
            //$meiopgt=$ped->paymentMethods;
            //print_r($ped );
            // foreach ($ped->billing as $kcli => $cli) {
            //echo "<pre>";
            //print_r($ped->billing->email );

            /*        echo "<br><br><br> var_dump:<pre>";
            var_dump( $ped);
            die; */
             $i=0;
             foreach ($arr_pedidos as $key => $ped) {
                 $ped = json_decode($ped->body);
                 $dateNow = date('Y-m-d');
                 $horaNow = date('H:i:s');

                 if ($i == 0) { 

                    if ($this->checkuserExist($ped->billing->email) == false) {
                          $this->add_user($ped->billing);
                    }else{
                          $this->get_user($ped->billing->email);
                    }
                    $tipo_transp = isset($ped->shipment->shippingName) ? "via: ".$ped->shipment->shippingName : '';
                    $cod_venda = $this->p_sql->maximo("tvenda", "vnd_codigo") + 1;
                    $valores['vnd_codigo']     = $cod_venda;      
                    $valores['vnd_valor']      = $ped->totalAmount;            
                    $valores['vnd_frete']      = $ped->shippingCost;
                    $valores['vnd_campo2']     = 'meio de pagamento :' . $meiopgt[0]->method;;
                    $valores['vnd_cli_codigo'] =  $this->user_id ;
                    $valores['vnd_datavenda']  = date('Y-m-d',strtotime($ped->saleChannelCreated ));
                    $valores['vnd_horavenda']  = date('H:i:s',strtotime($ped->saleChannelCreated ));
                    $valores['vnd_status']     = 2; 
                    $valores['vnd_campo3']     = $ped->saleChannelName . $tipo_transp;
                    $valores['vnd_tipo']       = 1;         
                    $valores['vnd_lojavirtual']= 1;            
                    $valores['vnd_dataentrega']  = date('Y-m-d',strtotime($ped->estimatedDeliveredAt));
                    $valores['vnd_campo1'] = 'id da venda:'.$ped->id;
                    //$valores['vnd_emp_codigo'] = $IdLoja;

                    $this->p_sql->adiciona("tvenda", array_keys($valores), $valores);
                    $this->p_sql->query();
                    //echo $this->p_sql->clausula_sql."<br><br>";    
                    //echo 'ERRO: tvenda '.$this->p_sql->last_error."<br><br>";
                }

            

                $fatr_codigo = $this->p_sql->maximo("tfaturasareceber", "fatr_codigo") + 1;
                $val_ftr['fatr_codigo']       = $fatr_codigo;      
                $val_ftr['fatr_vnd_codigo']   = $cod_venda;      
                $val_ftr['fatr_parcela']      = 1;      
                $val_ftr['fatr_valorparcela'] = $ped->totalAmount;
                $val_ftr['fatr_datavencimento']= $dateNow;      
                $val_ftr['fatr_tipo']          = 1;      
                $val_ftr['fatr_datapagamento'] =$dateNow ;    
                $val_ftr['fatr_valorpagamento']= $ped->totalAmount;
                $val_ftr['fatr_tipopagamento'] = 1; //dinheiro     
                $val_ftr['fatr_valororiginal'] = $ped->totalAmount;    
                $val_ftr['fatr_status']        = 1;    
                $val_ftr['fatr_observacao']   = 'pagamento via Plug4market';    

                $this->p_sql->adiciona("tfaturasareceber", array_keys($val_ftr), $val_ftr);
                $this->p_sql->query();
                //echo $this->p_sql->clausula_sql."<br><br>";    
                //echo 'ERRO: tfaturasareceber '.$this->p_sql->last_error."<br><br>";

                
                foreach ($ped->orderItems as $kprod => $prod) {
                         
                         //echo $prod->price ."<br>";
                         echo $prod->productId ."<br>";
                        $valoresp['vpd_codigo']     = $this->p_sql->maximo("tvendaproduto", "vpd_codigo") + 1;      
                        $valoresp['vpd_valor']      = $prod->price;
                        $valoresp['vpd_vnd_codigo'] = $cod_venda;
                        $valoresp['vpd_prd_codigo'] = $prod->productId;   // ?
                        $valoresp['vpd_quantidade'] = 1;
                        $valoresp['vpd_obs'] = 'insert via plug4market ';
                        $this->p_sql->adiciona("tvendaproduto", array_keys($valoresp), $valoresp); 
                        $this->p_sql->query();
                        //echo $this->p_sql->clausula_sql."<br><br>";    
                        //echo 'ERRO: tvendaproduto '.$this->p_sql->last_error."<br><br>";
                } 
                   
             $i++;     
            }

            //return $vars;
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

        public function checkuserExist($email) {
             
            $email    = trim($email);
            $consulta = "SELECT * FROM `tcliente` WHERE cli_email ='{$email}'";
            $this->p_sql->query($consulta);
            $num     = $this->p_sql->numerodelinhas();
            
            if($num>0){
               $return = true;     
            } else
               $return= false;     

            return $return;
        }

        public function add_user($arr_user) {
             
            $campo['cli_nome']      = $arr_user->name;
            $campo['cli_email']     = $arr_user->email;
            $campo['cli_cpfcnpj']   = $arr_user->documentId;
            $campo['cli_endereco']  = $arr_user->street;
            $campo['cli_numero']    = $arr_user->streetNumber;
            $campo['cli_complemento']  = $arr_user->streetComplement;
            $campo['cli_bairro']  = $arr_user->district;
            $campo['cli_cidade']  = $arr_user->city;
            $campo['cli_estado']  = $arr_user->state;
            $campo['cli_cep']     = $arr_user->zipCode;
            $campo['cli_pais']    = $arr_user->country;
            $campo['cli_telresidencial']  = $arr_user->phone;
            $campo['cli_datanascimento']  = $arr_user->dateOfBirth;
            $campo['cli_datacadastro']    = date('Y-m-d');
            $campo['cli_observacao']  = 'Cadastro Via plug4market';
            //$campo['cli_emp_codigo']  = 2010; COMO pegar?
            $campo['cli_codigo'] = $user_id = $this->p_sql->maximo("tcliente", "cli_codigo") + 1; 
            $this->p_sql->adiciona("tcliente", array_keys($campo), $campo);
            $this->p_sql->query(); 
            //echo $this->p_sql->clausula_sql."<br><br>";    
            //echo 'ERRO: tcliente '.$this->p_sql->last_error."<br><br>";

            
            if($this->p_sql->last_error){
               $return= false;     
            } else
               $return= true;

            $this->user_id = $user_id; 

            return $return;
        }


         public function get_user($email){
            $consulta = "SELECT cli_codigo FROM `tcliente` WHERE cli_email='{$email}' ";
            $this->p_sql->query($consulta); 
        
            $row           = $this->p_sql->retorna();
            $this->user_id = $row['cli_codigo']; 
             
             return $row; 
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