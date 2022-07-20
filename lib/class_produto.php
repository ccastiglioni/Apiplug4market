<?php

    class Produto {

        private $_id;
        private $_name;
        public  $p_sql;
        public  $tokenfresh;
        public  $token;
        public  $xml ="<?xml version='1.0' encoding='UTF-8'?><nfeProc xmlns='http://www.portalfiscal.inf.br/nfe' versao='4.00'><NFe xmlns='http://www.portalfiscal.inf.br/nfe'><infNFe versao='4.00' Id='NFe35220715043632000100550010000192161337673243'><ide><cUF>35</cUF><cNF>33767324</cNF><natOp>VENDA</natOp><mod>55</mod><serie>1</serie><nNF>19216</nNF><dhEmi>2022-07-13T10:30:00-03:00</dhEmi><dhSaiEnt>2022-07-13T10:30:00-03:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>3549904</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>3</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>0</indPres><procEmi>0</procEmi><verProc>NfeSistemas</verProc></ide><emit><CNPJ>15043632000100</CNPJ><xNome>ELETROCODEX COMERCIO DE MATERIAL ELETRONICO LTDA EPP</xNome><xFant>codex</xFant><enderEmit><xLgr>Rua Paraibuna</xLgr><nro>1730</nro><xBairro>Vila Nair</xBairro><cMun>3549904</cMun><xMun>São José dos Campos</xMun><UF>SP</UF><CEP>12231010</CEP><cPais>1058</cPais><xPais>Brasil</xPais><fone>1239415949</fone></enderEmit><IE>645361745113</IE><CRT>1</CRT></emit><dest><CNPJ>20593186000147</CNPJ><xNome>SPAZIO CAMPO DI BRAGANCA</xNome><enderDest><xLgr>Rua Raimundo Barbosa Nogueira</xLgr><nro>451</nro><xBairro>Palmeiras de São José</xBairro><cMun>3549904</cMun><xMun>São José dos Campos</xMun><UF>SP</UF><CEP>12237828</CEP><cPais>1058</cPais><xPais>Brasil</xPais><fone>1239397656</fone></enderDest><indIEDest>9</indIEDest><email>atendimentobr@a3administra.com.br</email></dest><autXML><CNPJ>11302426000116</CNPJ></autXML>
<det nItem='1'><prod><cProd>SEQ 5322</cProd><cEAN>SEM GTIN</cEAN><xProd>TERMINAL PINO ISOL 6,0MM AM C/10</xProd><NCM>85361000</NCM><CEST>0106600</CEST><CFOP>5405</CFOP><uCom>PC</uCom><qCom>2</qCom><vUnCom>10.3</vUnCom><vProd>20.60</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>PC</uTrib><qTrib>2</qTrib><vUnTrib>10.3</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>5.34</vTotTrib><ICMS><ICMSSN500><orig>0</orig><CSOSN>500</CSOSN></ICMSSN500></ICMS><PIS><PISOutr><CST>99</CST><qBCProd>0.0000</qBCProd><vAliqProd>0.0000</vAliqProd><vPIS>0</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><qBCProd>0.0000</qBCProd><vAliqProd>0.0000</vAliqProd><vCOFINS>0</vCOFINS></COFINSOutr></COFINS></imposto></det>
<total><ICMSTot><vBC>0.00</vBC><vICMS>0.00</vICMS><vICMSDeson>0.00</vICMSDeson><vFCP>0.00</vFCP><vBCST>0.00</vBCST><vST>0.00</vST><vFCPST>0.00</vFCPST><vFCPSTRet>0.00</vFCPSTRet><vProd>1022.30</vProd><vFrete>0.00</vFrete><vSeg>0.00</vSeg><vDesc>0.00</vDesc><vII>0.00</vII><vIPI>0.00</vIPI><vIPIDevol>0.00</vIPIDevol><vPIS>0.00</vPIS><vCOFINS>0.00</vCOFINS><vOutro>0.00</vOutro><vNF>1022.30</vNF><vTotTrib>225.83</vTotTrib></ICMSTot></total><transp><modFrete>9</modFrete></transp><cobr><fat><nFat>002</nFat><vOrig>1022.30</vOrig><vDesc>0.00</vDesc><vLiq>1022.30</vLiq></fat><dup><nDup>001</nDup><dVenc>2022-08-10</dVenc><vDup>511.15</vDup></dup><dup><nDup>002</nDup><dVenc>2022-08-24</dVenc><vDup>511.15</vDup></dup></cobr><pag><detPag><indPag>1</indPag><tPag>15</tPag><vPag>1022.30</vPag></detPag></pag><infAdic><infCpl>Valor Aprox Tributos Fed R$46,85(4,58%) Est R$178,98(17,51%) Fonte: IBPT Lei 12741/2012..</infCpl></infAdic></infNFe><Signature xmlns='http://www.w3.org/2000/09/xmldsig#'><SignedInfo><CanonicalizationMethod Algorithm='http://www.w3.org/TR/2001/REC-xml-c14n-20010315' /><SignatureMethod Algorithm='http://www.w3.org/2000/09/xmldsig#rsa-sha1' /><Reference URI='#NFe35220715043632000100550010000192161337673243'><Transforms><Transform Algorithm='http://www.w3.org/2000/09/xmldsig#enveloped-signature' /><Transform Algorithm='http://www.w3.org/TR/2001/REC-xml-c14n-20010315' /></Transforms><DigestMethod Algorithm='http://www.w3.org/2000/09/xmldsig#sha1' /><DigestValue>oyl6HWRSHhdXnLcxpumyXJuvuAE=</DigestValue></Reference></SignedInfo><SignatureValue>WNB8aViTACP4h6GF7IfLwGSrJvfsXgrfvSdbqYf/KP4usSm6Yq0oTiyqH+rGQO/+Uj09pPFGGmFgXgBJ38EJwmgOzRvtMc+XxusnJkjBfY0HgrPd9ZhqAl/t8zYmGcK2tHr884IFWOIp2cyGlyMRGOrUVRzA9KFK5964p+krdLrusrQ1ypqIjUXYn4tQBTLSvJ09uCbx4s+E/zQBjQ2o8kBjk6fcLmXi12uZCQsHL4gj6T7lExD5oYeAzGmAJ0KHhEPpBCGTRDw2W9rZtlMM3dG7XkyDJzrlbmZHPRurNh1J3EurK88KV1bZYHXQWQLUqzWB/HOshgTLk8ykc6l+/Q==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></NFe><protNFe versao='4.00' xmlns='http://www.portalfiscal.inf.br/nfe'><infProt><tpAmb>1</tpAmb><verAplic>SP_NFE_PL009_V4</verAplic><chNFe>35220715043632000100550010000192161337673243</chNFe><dhRecbto>2022-07-13T10:30:42-03:00</dhRecbto><nProt>135220925086483</nProt><digVal>oyl6HWRSHhdXnLcxpumyXJuvuAE=</digVal><cStat>100</cStat><xMotivo>Autorizado o uso da NF-e</xMotivo></infProt></protNFe></nfeProc>";


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

            //echo $consulta; die;

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
                "sku"          => $rows["prd_codigo"],
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


        public function setbodyschemaPedido($pedido='',$fatura='',$rastreio='',$entrega='') {
            
            if ($pedido !='') {
                $vars = json_encode(array(
                    "orderIdStore"    =>'{$pedido}'
                ));
            }
            if ($fatura !='') {

                $nfeSerialNumber='002155';
                $nfeAccessKey ='35220715043632000100550010000192161337673244';
                $nfeNumber ='44459';
                
                $vars = json_encode(array(
                    "nfeDate"         => (string) $this->getTimestamp(),
                    "nfeSerialNumber" =>$nfeSerialNumber,
                    "nfeAccessKey"    =>$nfeAccessKey,
                    "nfeNumber"       =>$nfeNumber,
                    "xml"             => $this->Parse($this->xml)
                ));
            }
            if ($rastreio !='') {

                $shippingCarrier='002154';
                $trackingNumber ='8878s78d78sd7sv7fd8vd';
                $trackingUrl ='44458';

                $vars = json_encode(array(
                    "shippingCarrier" =>$shippingCarrier,
                    "trackingNumber"    =>$trackingNumber,
                    "trackingUrl"       =>$trackingUrl,
                ));
            }
            if ($entrega !='') {
              
                $vars = json_encode(array(
                    "deliveredAt" =>$this->getTimestamp()
                ));
            }

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


        public function getTimestamp()
        {
                $microtime = floatval(substr((string)microtime(), 1, 8));
                $rounded   = round($microtime, 3);

                return gmdate('Y-m-d\TH:i:s') . substr((string) $rounded, 1, strlen($rounded));
        }

        public function Parse($url) {
        $fileContents= ($url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string(utf8_encode( $fileContents));
        $json = json_encode($simpleXml);
        //$json = ($simpleXml);

        return $json;
        }


    }
?>