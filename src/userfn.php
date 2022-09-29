<?php

namespace PHPMaker2022\school;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions
// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
    if (!isLocal()) { // if is not in local PC
		$info["host"] = "localhost";
		$info["user"] = "mas_admin";
		$info["pass"] = "#Fun2See#";
		$info["db"] = "mas_admin";
	}else{
		$info["host"] = "localhost";
		$info["user"] = "root";
		$info["pass"] = "";
		$info["db"] = "mas_admin_dev";
	}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function hasLogin(){
	if(!empty(CurrentUserName()) && !isAdmin()) {
        return true;
    }else{
        return false;
    }
}

// função para retornar o ID real do usuário logado
// utilizamos esta função pois, tivemos que criar o esquema de escola mestre e filha
function GetLoggedUserID(){
	if(hasLogin()){
		return ExecuteScalar("SELECT id FROM school_users WHERE email = '".CurrentUserName()."'");
	}else{
		return -10; // caso não possua login [erro no sistema ou fato inesperado]
	}
}

function CurrentUserSchoolID(){
	$userId = GetLoggedUserID();
	if(isset($userId)){
		return ExecuteScalar("SELECT schoolId FROM school_users WHERE id = ".$userId."");
	}else{
		return -2;
	}
}

function CurrentUserMasterSchoolID(){
	$schoolId = CurrentUserSchoolID();
	if(isset($schoolId)){
		return ExecuteScalar("SELECT masterSchoolId FROM fed_school WHERE id = ".$schoolId."");
	}else{
		return -2;
	}
}

function CurrentOrganizationID(){
	$masterSchool = CurrentUserMasterSchoolID();
	if(isset($masterSchool)){
		return ExecuteScalar("SELECT federationId FROM fed_school WHERE id = ".$masterSchool." ");
	}else{
		return -2;
	}
}

/* ----------------------- Funções financeiro -----------------------*/

/*
	@params
	id: int 
	type: flag {Receivable/credit [1] or payable/debit [2]}
	return decimal;
*/
function amountPaid($accountid, $type)
{
    if (isset($type) && isset($accountid)) {
        switch ($type) {
            case 1: // a receber
                $sum_cred = ExecuteScalar("SELECT SUM(c.value) from fin_credit c WHERE c.accountId IN (" . $accountid . ")");
                !isset($sum_cred) ? $sum_cred = 0 : $sum_cred;
                return $sum_cred;
            case 2: // a pagar
                $sum_debit = ExecuteScalar("SELECT SUM(value) FROM fin_debit WHERE accountId = " . $accountid . "");
                !isset($sum_debit) ? $sum_debit = 0 : $sum_debit;
                return $sum_debit;
            default:
                return -1;
        }
    } else {
        return -1;
    }
} //calcula o saldo das contas a pagar e receber

/*
	@params
	row: Current Row
	status: int
*/
function paint($status)
{
    if ($status == 0) { // pago
        $style = "background-color: green;color: white;border-radius: 50px;display: block;text-align: center;";
        return $style;
    }
    if ($status == 1) { // não pago
        $style = "background-color: #da000a;color: white;border-radius: 50px;display: block;text-align: center; padding-left:10px; padding-right:10px;";
        return $style;
    }
    if ($status == 2) { // parcial 
        $style = "background-color: #ecc653;color: black;border-radius: 50px;display: block;text-align: center;";
        return $style;
    }
} //pinta a linha de acordo com o status da conta

/*
	@params
	id: int
	$balance: decimal
	$value: decimal
	type: int Receivable [1] or payable [2]
*/
function updateAccountStatus($id, $value, $type)
{
    if (isset($id) && isset($type) && isset($value)) {
        ($type == 1) ? $tabela = "fin_accountsreceivable" : $tabela = "fin_accountspayable";
        $amount = amountPaid($id, $type);
        if ($amount != -1) { // só mexe no banco de dados caso seja diferente
            if ($amount == 0) { // conta não paga
                Execute("UPDATE " . $tabela . " SET  status = 1 WHERE id = " . $id . "");
                return true;
            } else if ($amount >= $value) { // conta paga
                Execute("UPDATE " . $tabela . " SET  status = 0  WHERE id = " . $id . "");
                return true;
            } else { // parcial
                Execute("UPDATE " . $tabela . " SET  status = 2  WHERE id = " . $id . "");
                return true;
            }
        }
        return false;
    }
    return false;
} //atualiza o status da conta
/* ----------------------- Fim das Funções financeiro -----------------------*/
function get_file_dir() {
    global $argv;
    $dir = dirname(getcwd() . '/' . $argv[0]);
    $curDir = getcwd();
    chdir($dir);
    $dir = getcwd();
    chdir($curDir);
    return $dir;
}
