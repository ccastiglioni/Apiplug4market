<?
class clausulas_sql
{
    /**
    * @param string $clausula_sql;
    * @access public
    */
    var $clausula_sql;

    /**
    * Cria cláusulas SQL INSERT
    *
    * @param string $tabela
    * @param array $campos
    * @param array $valores


    *
    * @access public
    */
    function adiciona($tabela, $campos, $valores)
    {
        $this->clausula_sql = "INSERT INTO " . $tabela . " (";

        $quantidade_campos = count($campos);

        for($i = 0; $i < $quantidade_campos; ++$i)
        {
            $this->clausula_sql .= $campos[$i];

            if($i < ($quantidade_campos-1))
            {
                $this->clausula_sql .= ", ";
            }
        }

        $this->clausula_sql .= ") VALUES (";

        for($i = 0; $i < $quantidade_campos; ++$i)
        {
            $this->clausula_sql .= clausulas_sql::escreve_valor($valores[$campos[$i]], $i, $quantidade_campos);
        }

        $this->clausula_sql .= ");";

        //echo $this->clausula_sql . "<br><br>";
        //exit();
        return $this->clausula_sql;
    }

    /**
    * Cria cláusulas SQL UPDATE
    *
    * @param string $tabela
    * @param array $campos
    * @param array $valores
    * @param string $sentenca


    *
    * @access public
    */
    function atualiza($tabela, $campos, $valores, $sentenca)
    {
        $this->clausula_sql = "UPDATE " . $tabela . " SET ";

        $quantidade_campos = count($campos);

        for($i = 0; $i < $quantidade_campos ; ++$i)
        {
            $this->clausula_sql .= $campos[$i] . " = ";
            $this->clausula_sql .= clausulas_sql::escreve_valor($valores[$campos[$i]], $i, $quantidade_campos);
        }


        $this->clausula_sql .= " " . $sentenca . ";";

		//echo $this->clausula_sql . "<br><br>";
		//exit();
        return $this->clausula_sql;
    }





    function apaga($tabela, $sentenca)
    {
        $this->clausula_sql = "DELETE FROM " . $tabela;

        $this->clausula_sql .= " " . $sentenca . ";";

		//echo $this->clausula_sql . "<br><br>";
		//exit();
        return $this->clausula_sql;
    }


    function maximo($tabela, $campo)
    {
        $this->clausula_sql = "select max($campo) as cod FROM " . $tabela;
        $this->clausula_sql .= " " . $sentenca . ";";
        $this->query();
        $rs=$this->retorna();
        return $rs['cod'];
    }



function salvalog($db,$sentenca)
{
$filename = "../../../mylog/{$db}.log";

$handle = fopen ($filename, "a+");

if (substr($sentenca,-1)!=";")
$sentenca = $sentenca . ";";
fputs($handle, $sentenca . "\n");

fclose($handle);

} // fim da function



    /**
    * Retorna um valor formatado para se inserir na query SQL
    *
    * @param mix $valor
    * @param int $atual
    * @param int $total


    *
    * @access private
    */
    function escreve_valor($valor, $atual, $total)
    {
        if(is_string($valor))
        {
            $retorno = "'" . addslashes($valor) . "'";
        }
        elseif(empty($valor))
        {
            $retorno = "''";
        }
        else
        {
            $retorno = $valor;
        }

        if($atual < ($total-1))
        {
            $retorno .= ", ";
        }

        return $retorno;
    }
}


/*
-----------------------------------------
*/


class database extends clausulas_sql
{
    /**
    * @param resource $conn
    */
	var $conn;
    /**
    * @param resource $result_id
    */
	var $result_id;
    /**
    * @param resource $result
    */
	var $result;
    /**
    * @param string $last_error
    */
	var $last_error;

	var $meudb;
	/**
    * Conexão
    *
    * @param string $host
    * @param int $port
    * @param string $user
    * @param string $pass
    * @param string $db
    * @param boolean $persistency
    */
	function _connect ($host, $port = false, $user, $pass = false, $db = false, $persistency = true)
    {
		if($port)
		{
			$conn_string = "$host:$port";
		}
		else
		{
			$conn_string = "$host";
		}

		if($persistency)
        {
			$funcao = "mysql_pconnect";
        }
		else
        {
			$funcao = "mysql_connect";
        }

		if(!$this->conn = @$funcao($conn_string, $user, $pass))
		{
            $this->last_error = @mysql_errno() . ": " . @mysql_error();
			return false;
		}

		if($db)
		{
			if($db = $this->select_db($db))
            {
			    return true;
            }
            else
            {
                return false;
            }
		}

		return $this->conn;
	}

    /**
    * Selecionar Banco de Dados
    *
    * @param string $db
    * @param resource $conn
    */
	function select_db($db, $conn = false)
    {
		if(!$conn)
        {
			$conn = $this->conn;
        }

		$num = @mysql_select_db($db, $conn);

		if(!$num)
		{
			$this->_close($conn);
            $this->last_error = "Invalid database: " . $db;
			return false;
		}

        $this->meudb=$db;
		return $num;
	}

	/**
    * Fechar conexão e liberar resultados
    *
    * @param resource $conn
    */
	function _close ($conn = false)
    {
		if(!$conn)
        {
			$conn = $this->conn;
        }

		if($conn)
		{
			if(@$this->result_id)
            {
				@mysql_free_result($this->result_id);
            }

			$num = @mysql_close($conn);

			return $num;
		}
		else
        {
			return false;
        }
	}

	/**
    * Executa uma consulta SQL
    *
    * @param string $sql
    * @param resource $conn
    * @param resource $result
    * @param resource $transaction
    */
	function query($sql = false, $conn = false, $result = false, $transaction = false)
    {
        if(!$sql)
        {
            $sql = $this->clausula_sql;
        }
		
        $instrucao = strtoupper (substr($sql,0,6));
        if ($instrucao=="INSERT" || $instrucao=="UPDATE" || $instrucao=="DELETE")
        $this->salvalog($this->meudb,$sql);

        if(!$result)
        {
            $result = &$this->result_id;
        }

		if(!$conn)
        {
			$conn = $this->conn;
        }

		if($result = @mysql_query($sql, $conn))
		{
			return $result;
		}
		else
		{
			$this->last_error = @mysql_errno() . ": " . @mysql_error();
			return false;
		}
	}

	/**
    * Fetch Array
    *
    * @param resource $result_id
    */
	function retorna ($result_id = false)
    {
		if(!$result_id)
        {
			$result_id = $this->result_id;
        }

		$this->result = @mysql_fetch_array($result_id, MYSQL_ASSOC);

		return $this->result;
	}

	/**
    * Fetch Row
    *
    * @param resource $result_id
    */
	function fetch_row ($result_id = false)
    {
		if(!$result_id)
        {
			$result_id = $this->result_id;
        }

		$this->result = @mysql_fetch_row($result_id);

		return $this->result;
	}

	/**
    * Fetch Object
    *
    * @param resource $result_id
    */
	function fetch_object ($result_id = false)
    {
		if(!$result_id)
        {
            $result_id = $this->result_id;
        }

		$this->result = @mysql_fetch_object($result_id);

		return $this->result;
	}

    /**
    * Fetch mysql_fetch_field
    *
    * @param Get column information from a result and return as an object
    */
    function fetch_field ($result_id = false)
    {
        if(!$result_id)
        {
            $result_id = $this->result_id;
        }

        $this->result = @mysql_fetch_field($result_id);

        return $this->result;
    }

	/**
    * Número total de itens encontrados
    *
    * @param resource $result_id
    */
	function numerodelinhas ($result_id = false)
    {
		if(!$result_id)
        {
			$result_id = $this->result_id;
        }

		return ($result_id) ? @mysql_num_rows($result_id) : 0;
    }

	/**
    * Último ID de um campo auto_increment
    */
	function ultimoid()
    {
		if($this->conn)
		{
			$result = @mysql_insert_id($this->conn);
			return $result;
		}
		else
        {
			return false;
        }
	}
}
?>
