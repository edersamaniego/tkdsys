<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fin_credit
 */
class FinCredit extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $accountId;
    public $dueDate;
    public $value;
    public $paymentMethod;
    public $checkingAccountId;
    public $obs;
    public $_userId;
    public $_register;
    public $lastUpdate;
    public $lastUser;
    public $schoolId;
    public $masterSchoolId;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fin_credit';
        $this->TableName = 'fin_credit';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fin_credit`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'fin_credit',
            'fin_credit',
            'x_id',
            'id',
            '`id`',
            '`id`',
            3,
            11,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // accountId
        $this->accountId = new DbField(
            'fin_credit',
            'fin_credit',
            'x_accountId',
            'accountId',
            '`accountId`',
            '`accountId`',
            3,
            11,
            -1,
            false,
            '`accountId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->accountId->InputTextType = "text";
        $this->accountId->IsForeignKey = true; // Foreign key field
        $this->accountId->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->accountId->Lookup = new Lookup('accountId', 'fin_accountsreceivable', false, 'id', ["id","value","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->accountId) . "',COALESCE(`value`,''))");
                break;
            case "pt-BR":
                $this->accountId->Lookup = new Lookup('accountId', 'fin_accountsreceivable', false, 'id', ["id","value","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->accountId) . "',COALESCE(`value`,''))");
                break;
            case "es":
                $this->accountId->Lookup = new Lookup('accountId', 'fin_accountsreceivable', false, 'id', ["id","value","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->accountId) . "',COALESCE(`value`,''))");
                break;
            default:
                $this->accountId->Lookup = new Lookup('accountId', 'fin_accountsreceivable', false, 'id', ["id","value","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->accountId) . "',COALESCE(`value`,''))");
                break;
        }
        $this->accountId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['accountId'] = &$this->accountId;

        // dueDate
        $this->dueDate = new DbField(
            'fin_credit',
            'fin_credit',
            'x_dueDate',
            'dueDate',
            '`dueDate`',
            CastDateFieldForLike("`dueDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dueDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dueDate->InputTextType = "text";
        $this->dueDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dueDate'] = &$this->dueDate;

        // value
        $this->value = new DbField(
            'fin_credit',
            'fin_credit',
            'x_value',
            'value',
            '`value`',
            '`value`',
            131,
            10,
            -1,
            false,
            '`value`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->value->InputTextType = "text";
        $this->value->Required = true; // Required field
        $this->value->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['value'] = &$this->value;

        // paymentMethod
        $this->paymentMethod = new DbField(
            'fin_credit',
            'fin_credit',
            'x_paymentMethod',
            'paymentMethod',
            '`paymentMethod`',
            '`paymentMethod`',
            3,
            11,
            -1,
            false,
            '`paymentMethod`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->paymentMethod->InputTextType = "text";
        $this->paymentMethod->Required = true; // Required field
        $this->paymentMethod->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->paymentMethod->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->paymentMethod->Lookup = new Lookup('paymentMethod', 'fin_paymentmethod', false, 'id', ["paymentmethod","","",""], [], [], [], [], [], [], '', '', "`paymentmethod`");
                break;
            case "pt-BR":
                $this->paymentMethod->Lookup = new Lookup('paymentMethod', 'fin_paymentmethod', false, 'id', ["paymentmethod","","",""], [], [], [], [], [], [], '', '', "`paymentmethod`");
                break;
            case "es":
                $this->paymentMethod->Lookup = new Lookup('paymentMethod', 'fin_paymentmethod', false, 'id', ["paymentmethod","","",""], [], [], [], [], [], [], '', '', "`paymentmethod`");
                break;
            default:
                $this->paymentMethod->Lookup = new Lookup('paymentMethod', 'fin_paymentmethod', false, 'id', ["paymentmethod","","",""], [], [], [], [], [], [], '', '', "`paymentmethod`");
                break;
        }
        $this->paymentMethod->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['paymentMethod'] = &$this->paymentMethod;

        // checkingAccountId
        $this->checkingAccountId = new DbField(
            'fin_credit',
            'fin_credit',
            'x_checkingAccountId',
            'checkingAccountId',
            '`checkingAccountId`',
            '`checkingAccountId`',
            3,
            11,
            -1,
            false,
            '`checkingAccountId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->checkingAccountId->InputTextType = "text";
        $this->checkingAccountId->Required = true; // Required field
        $this->checkingAccountId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->checkingAccountId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->checkingAccountId->Lookup = new Lookup('checkingAccountId', 'fin_checkingaccount', false, 'id', ["responsable","bank","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`responsable`, ''),'" . ValueSeparator(1, $this->checkingAccountId) . "',COALESCE(`bank`,''))");
                break;
            case "pt-BR":
                $this->checkingAccountId->Lookup = new Lookup('checkingAccountId', 'fin_checkingaccount', false, 'id', ["responsable","bank","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`responsable`, ''),'" . ValueSeparator(1, $this->checkingAccountId) . "',COALESCE(`bank`,''))");
                break;
            case "es":
                $this->checkingAccountId->Lookup = new Lookup('checkingAccountId', 'fin_checkingaccount', false, 'id', ["responsable","bank","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`responsable`, ''),'" . ValueSeparator(1, $this->checkingAccountId) . "',COALESCE(`bank`,''))");
                break;
            default:
                $this->checkingAccountId->Lookup = new Lookup('checkingAccountId', 'fin_checkingaccount', false, 'id', ["responsable","bank","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`responsable`, ''),'" . ValueSeparator(1, $this->checkingAccountId) . "',COALESCE(`bank`,''))");
                break;
        }
        $this->checkingAccountId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['checkingAccountId'] = &$this->checkingAccountId;

        // obs
        $this->obs = new DbField(
            'fin_credit',
            'fin_credit',
            'x_obs',
            'obs',
            '`obs`',
            '`obs`',
            201,
            65535,
            -1,
            false,
            '`obs`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->obs->InputTextType = "text";
        $this->Fields['obs'] = &$this->obs;

        // userId
        $this->_userId = new DbField(
            'fin_credit',
            'fin_credit',
            'x__userId',
            'userId',
            '`userId`',
            '`userId`',
            3,
            11,
            -1,
            false,
            '`userId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_userId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->_userId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->_userId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->_userId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->_userId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->_userId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['userId'] = &$this->_userId;

        // register
        $this->_register = new DbField(
            'fin_credit',
            'fin_credit',
            'x__register',
            'register',
            '`register`',
            CastDateFieldForLike("`register`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`register`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_register->InputTextType = "text";
        $this->_register->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['register'] = &$this->_register;

        // lastUpdate
        $this->lastUpdate = new DbField(
            'fin_credit',
            'fin_credit',
            'x_lastUpdate',
            'lastUpdate',
            '`lastUpdate`',
            CastDateFieldForLike("`lastUpdate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`lastUpdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastUpdate->InputTextType = "text";
        $this->lastUpdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['lastUpdate'] = &$this->lastUpdate;

        // lastUser
        $this->lastUser = new DbField(
            'fin_credit',
            'fin_credit',
            'x_lastUser',
            'lastUser',
            '`lastUser`',
            '`lastUser`',
            3,
            11,
            -1,
            false,
            '`lastUser`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastUser->InputTextType = "text";
        $this->lastUser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lastUser'] = &$this->lastUser;

        // schoolId
        $this->schoolId = new DbField(
            'fin_credit',
            'fin_credit',
            'x_schoolId',
            'schoolId',
            '`schoolId`',
            '`schoolId`',
            3,
            11,
            -1,
            false,
            '`schoolId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->schoolId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            case "pt-BR":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            case "es":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            default:
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
        }
        $this->schoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolId'] = &$this->schoolId;

        // masterSchoolId
        $this->masterSchoolId = new DbField(
            'fin_credit',
            'fin_credit',
            'x_masterSchoolId',
            'masterSchoolId',
            '`masterSchoolId`',
            '`masterSchoolId`',
            3,
            11,
            -1,
            false,
            '`masterSchoolId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->masterSchoolId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            case "pt-BR":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            case "es":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
            default:
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], [], [], [], [], [], '', '', "`school`");
                break;
        }
        $this->masterSchoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['masterSchoolId'] = &$this->masterSchoolId;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "fin_accountsreceivable") {
            if ($this->accountId->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->accountId->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "fin_checkingaccount") {
            if ($this->accountId->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->accountId->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "fin_accountsreceivable") {
            if ($this->accountId->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`accountId`", $this->accountId->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "fin_checkingaccount") {
            if ($this->accountId->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`accountId`", $this->accountId->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "fin_accountsreceivable":
                $key = $keys["accountId"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["accountId"], $masterTable->id->DataType, $masterTable->Dbid);
                }
                break;
            case "fin_checkingaccount":
                $key = $keys["accountId"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["accountId"], $masterTable->id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "fin_accountsreceivable":
                return "`accountId`=" . QuotedValue($masterTable->id->DbValue, $this->accountId->DataType, $this->Dbid);
            case "fin_checkingaccount":
                return "`accountId`=" . QuotedValue($masterTable->id->DbValue, $this->accountId->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fin_credit`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "schoolId = ".CurrentUserId()."";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter, $id);
        }
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->accountId->DbValue = $row['accountId'];
        $this->dueDate->DbValue = $row['dueDate'];
        $this->value->DbValue = $row['value'];
        $this->paymentMethod->DbValue = $row['paymentMethod'];
        $this->checkingAccountId->DbValue = $row['checkingAccountId'];
        $this->obs->DbValue = $row['obs'];
        $this->_userId->DbValue = $row['userId'];
        $this->_register->DbValue = $row['register'];
        $this->lastUpdate->DbValue = $row['lastUpdate'];
        $this->lastUser->DbValue = $row['lastUser'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->masterSchoolId->DbValue = $row['masterSchoolId'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("FinCreditList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "FinCreditView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FinCreditEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FinCreditAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "FinCreditView";
            case Config("API_ADD_ACTION"):
                return "FinCreditAdd";
            case Config("API_EDIT_ACTION"):
                return "FinCreditEdit";
            case Config("API_DELETE_ACTION"):
                return "FinCreditDelete";
            case Config("API_LIST_ACTION"):
                return "FinCreditList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FinCreditList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FinCreditView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FinCreditView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FinCreditAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FinCreditAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("FinCreditEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("FinCreditAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("FinCreditDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "fin_accountsreceivable" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->accountId->CurrentValue);
        }
        if ($this->getCurrentMasterTable() == "fin_checkingaccount" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->accountId->CurrentValue);
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->accountId->setDbValue($row['accountId']);
        $this->dueDate->setDbValue($row['dueDate']);
        $this->value->setDbValue($row['value']);
        $this->paymentMethod->setDbValue($row['paymentMethod']);
        $this->checkingAccountId->setDbValue($row['checkingAccountId']);
        $this->obs->setDbValue($row['obs']);
        $this->_userId->setDbValue($row['userId']);
        $this->_register->setDbValue($row['register']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->lastUser->setDbValue($row['lastUser']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // accountId

        // dueDate

        // value

        // paymentMethod

        // checkingAccountId

        // obs

        // userId

        // register

        // lastUpdate

        // lastUser

        // schoolId

        // masterSchoolId

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // accountId
        $this->accountId->ViewValue = $this->accountId->CurrentValue;
        $curVal = strval($this->accountId->CurrentValue);
        if ($curVal != "") {
            $this->accountId->ViewValue = $this->accountId->lookupCacheOption($curVal);
            if ($this->accountId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->accountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->accountId->Lookup->renderViewRow($rswrk[0]);
                    $this->accountId->ViewValue = $this->accountId->displayValue($arwrk);
                } else {
                    $this->accountId->ViewValue = FormatNumber($this->accountId->CurrentValue, $this->accountId->formatPattern());
                }
            }
        } else {
            $this->accountId->ViewValue = null;
        }
        $this->accountId->ViewCustomAttributes = "";

        // dueDate
        $this->dueDate->ViewValue = $this->dueDate->CurrentValue;
        $this->dueDate->ViewValue = FormatDateTime($this->dueDate->ViewValue, $this->dueDate->formatPattern());
        $this->dueDate->ViewCustomAttributes = "";

        // value
        $this->value->ViewValue = $this->value->CurrentValue;
        $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
        $this->value->ViewCustomAttributes = "";

        // paymentMethod
        $curVal = strval($this->paymentMethod->CurrentValue);
        if ($curVal != "") {
            $this->paymentMethod->ViewValue = $this->paymentMethod->lookupCacheOption($curVal);
            if ($this->paymentMethod->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->paymentMethod->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->paymentMethod->Lookup->renderViewRow($rswrk[0]);
                    $this->paymentMethod->ViewValue = $this->paymentMethod->displayValue($arwrk);
                } else {
                    $this->paymentMethod->ViewValue = FormatNumber($this->paymentMethod->CurrentValue, $this->paymentMethod->formatPattern());
                }
            }
        } else {
            $this->paymentMethod->ViewValue = null;
        }
        $this->paymentMethod->ViewCustomAttributes = "";

        // checkingAccountId
        $curVal = strval($this->checkingAccountId->CurrentValue);
        if ($curVal != "") {
            $this->checkingAccountId->ViewValue = $this->checkingAccountId->lookupCacheOption($curVal);
            if ($this->checkingAccountId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->checkingAccountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->checkingAccountId->Lookup->renderViewRow($rswrk[0]);
                    $this->checkingAccountId->ViewValue = $this->checkingAccountId->displayValue($arwrk);
                } else {
                    $this->checkingAccountId->ViewValue = FormatNumber($this->checkingAccountId->CurrentValue, $this->checkingAccountId->formatPattern());
                }
            }
        } else {
            $this->checkingAccountId->ViewValue = null;
        }
        $this->checkingAccountId->ViewCustomAttributes = "";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->ViewCustomAttributes = "";

        // userId
        $this->_userId->ViewValue = $this->_userId->CurrentValue;
        $curVal = strval($this->_userId->CurrentValue);
        if ($curVal != "") {
            $this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
            if ($this->_userId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->_userId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->_userId->Lookup->renderViewRow($rswrk[0]);
                    $this->_userId->ViewValue = $this->_userId->displayValue($arwrk);
                } else {
                    $this->_userId->ViewValue = FormatNumber($this->_userId->CurrentValue, $this->_userId->formatPattern());
                }
            }
        } else {
            $this->_userId->ViewValue = null;
        }
        $this->_userId->ViewCustomAttributes = "";

        // register
        $this->_register->ViewValue = $this->_register->CurrentValue;
        $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
        $this->_register->ViewCustomAttributes = "";

        // lastUpdate
        $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
        $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
        $this->lastUpdate->ViewCustomAttributes = "";

        // lastUser
        $this->lastUser->ViewValue = $this->lastUser->CurrentValue;
        $this->lastUser->ViewValue = FormatNumber($this->lastUser->ViewValue, $this->lastUser->formatPattern());
        $this->lastUser->ViewCustomAttributes = "";

        // schoolId
        $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
        $curVal = strval($this->schoolId->CurrentValue);
        if ($curVal != "") {
            $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
            if ($this->schoolId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->schoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                    $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                } else {
                    $this->schoolId->ViewValue = FormatNumber($this->schoolId->CurrentValue, $this->schoolId->formatPattern());
                }
            }
        } else {
            $this->schoolId->ViewValue = null;
        }
        $this->schoolId->ViewCustomAttributes = "";

        // masterSchoolId
        $this->masterSchoolId->ViewValue = $this->masterSchoolId->CurrentValue;
        $curVal = strval($this->masterSchoolId->CurrentValue);
        if ($curVal != "") {
            $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
            if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->masterSchoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->masterSchoolId->Lookup->renderViewRow($rswrk[0]);
                    $this->masterSchoolId->ViewValue = $this->masterSchoolId->displayValue($arwrk);
                } else {
                    $this->masterSchoolId->ViewValue = FormatNumber($this->masterSchoolId->CurrentValue, $this->masterSchoolId->formatPattern());
                }
            }
        } else {
            $this->masterSchoolId->ViewValue = null;
        }
        $this->masterSchoolId->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // accountId
        $this->accountId->LinkCustomAttributes = "";
        $this->accountId->HrefValue = "";
        $this->accountId->TooltipValue = "";

        // dueDate
        $this->dueDate->LinkCustomAttributes = "";
        $this->dueDate->HrefValue = "";
        $this->dueDate->TooltipValue = "";

        // value
        $this->value->LinkCustomAttributes = "";
        $this->value->HrefValue = "";
        $this->value->TooltipValue = "";

        // paymentMethod
        $this->paymentMethod->LinkCustomAttributes = "";
        $this->paymentMethod->HrefValue = "";
        $this->paymentMethod->TooltipValue = "";

        // checkingAccountId
        $this->checkingAccountId->LinkCustomAttributes = "";
        $this->checkingAccountId->HrefValue = "";
        $this->checkingAccountId->TooltipValue = "";

        // obs
        $this->obs->LinkCustomAttributes = "";
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // userId
        $this->_userId->LinkCustomAttributes = "";
        $this->_userId->HrefValue = "";
        $this->_userId->TooltipValue = "";

        // register
        $this->_register->LinkCustomAttributes = "";
        $this->_register->HrefValue = "";
        $this->_register->TooltipValue = "";

        // lastUpdate
        $this->lastUpdate->LinkCustomAttributes = "";
        $this->lastUpdate->HrefValue = "";
        $this->lastUpdate->TooltipValue = "";

        // lastUser
        $this->lastUser->LinkCustomAttributes = "";
        $this->lastUser->HrefValue = "";
        $this->lastUser->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // masterSchoolId
        $this->masterSchoolId->LinkCustomAttributes = "";
        $this->masterSchoolId->HrefValue = "";
        $this->masterSchoolId->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->setupEditAttributes();
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // accountId
        $this->accountId->setupEditAttributes();
        $this->accountId->EditCustomAttributes = "";
        if ($this->accountId->getSessionValue() != "") {
            $this->accountId->CurrentValue = GetForeignKeyValue($this->accountId->getSessionValue());
            $this->accountId->ViewValue = $this->accountId->CurrentValue;
            $curVal = strval($this->accountId->CurrentValue);
            if ($curVal != "") {
                $this->accountId->ViewValue = $this->accountId->lookupCacheOption($curVal);
                if ($this->accountId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->accountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->accountId->Lookup->renderViewRow($rswrk[0]);
                        $this->accountId->ViewValue = $this->accountId->displayValue($arwrk);
                    } else {
                        $this->accountId->ViewValue = FormatNumber($this->accountId->CurrentValue, $this->accountId->formatPattern());
                    }
                }
            } else {
                $this->accountId->ViewValue = null;
            }
            $this->accountId->ViewCustomAttributes = "";
        } else {
            $this->accountId->EditValue = $this->accountId->CurrentValue;
            $this->accountId->PlaceHolder = RemoveHtml($this->accountId->caption());
        }

        // dueDate
        $this->dueDate->setupEditAttributes();
        $this->dueDate->EditCustomAttributes = "";
        $this->dueDate->EditValue = FormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        $this->dueDate->PlaceHolder = RemoveHtml($this->dueDate->caption());

        // value
        $this->value->setupEditAttributes();
        $this->value->EditCustomAttributes = "";
        $this->value->EditValue = $this->value->CurrentValue;
        $this->value->PlaceHolder = RemoveHtml($this->value->caption());
        if (strval($this->value->EditValue) != "" && is_numeric($this->value->EditValue)) {
            $this->value->EditValue = FormatNumber($this->value->EditValue, null);
        }

        // paymentMethod
        $this->paymentMethod->setupEditAttributes();
        $this->paymentMethod->EditCustomAttributes = "";
        $this->paymentMethod->PlaceHolder = RemoveHtml($this->paymentMethod->caption());

        // checkingAccountId
        $this->checkingAccountId->setupEditAttributes();
        $this->checkingAccountId->EditCustomAttributes = "";
        $this->checkingAccountId->PlaceHolder = RemoveHtml($this->checkingAccountId->caption());

        // obs
        $this->obs->setupEditAttributes();
        $this->obs->EditCustomAttributes = "";
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // userId
        $this->_userId->setupEditAttributes();
        $this->_userId->EditCustomAttributes = "";
        $this->_userId->EditValue = $this->_userId->CurrentValue;
        $this->_userId->PlaceHolder = RemoveHtml($this->_userId->caption());

        // register
        $this->_register->setupEditAttributes();
        $this->_register->EditCustomAttributes = "";
        $this->_register->EditValue = FormatDateTime($this->_register->CurrentValue, $this->_register->formatPattern());
        $this->_register->PlaceHolder = RemoveHtml($this->_register->caption());

        // lastUpdate

        // lastUser

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->EditValue = $this->schoolId->CurrentValue;
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
        }

        // masterSchoolId

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->accountId);
                    $doc->exportCaption($this->dueDate);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->paymentMethod);
                    $doc->exportCaption($this->checkingAccountId);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->lastUser);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->masterSchoolId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->accountId);
                    $doc->exportCaption($this->dueDate);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->paymentMethod);
                    $doc->exportCaption($this->checkingAccountId);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->lastUser);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->masterSchoolId);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->accountId);
                        $doc->exportField($this->dueDate);
                        $doc->exportField($this->value);
                        $doc->exportField($this->paymentMethod);
                        $doc->exportField($this->checkingAccountId);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->lastUser);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->masterSchoolId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->accountId);
                        $doc->exportField($this->dueDate);
                        $doc->exportField($this->value);
                        $doc->exportField($this->paymentMethod);
                        $doc->exportField($this->checkingAccountId);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->lastUser);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->masterSchoolId);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->ExportDoc = &$doc;
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Add User ID filter
    public function addUserIDFilter($filter = "", $id = "")
    {
        global $Security;
        $filterWrk = "";
        if ($id == "")
            $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`schoolId` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `fin_credit`";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        $conn = Conn($UserTable->Dbid);
        $config = $conn->getConfiguration();
        $config->setResultCacheImpl($this->Cache);
        if ($rs = $conn->executeCacheQuery($sql, [], [], $this->CacheProfile)->fetchAllNumeric()) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
    }

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "fin_accountsreceivable") {
            $filterWrk = Container("fin_accountsreceivable")->addUserIDFilter($filterWrk);
        }
        if ($currentMasterTable == "fin_checkingaccount") {
            $filterWrk = Container("fin_checkingaccount")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "fin_accountsreceivable") {
            $mastertable = Container("fin_accountsreceivable");
            if (!$mastertable->userIDAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->accountId, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        if ($currentMasterTable == "fin_checkingaccount") {
            $mastertable = Container("fin_checkingaccount");
            if (!$mastertable->userIDAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->accountId, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        $rsnew['register'] = ExecuteScalar('SELECT NOW()');
        $rsnew['userId'] = GetLoggedUserID();
        $rsnew['schoolId'] = CurrentUserID();
        $rsnew['masterSchoolId'] = CurrentUserMasterSchoolID();
        if(isset($rsnew["accountId"])){
        	$accountValue = ExecuteScalar("SELECT value FROM fin_accountsreceivable WHERE id = ".$rsnew['accountId']."");
        	return updateAccountStatus($rsnew["accountId"], $accountValue, 1);
        }
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
          if(isset($rsnew["accountId"])){
            	$accountValue = ExecuteScalar("SELECT value FROM fin_accountsreceivable WHERE id = ".$rsnew['accountId']."");
            	updateAccountStatus($rsnew["accountId"], $accountValue, 1);
            }
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        if(isset($rsold["accountId"])){
           	$accountValue = ExecuteScalar("SELECT value FROM fin_accountsreceivable WHERE id = ".$rsold['accountId']."");
            updateAccountStatus($rsold["accountId"], $accountValue, 1);
         }
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
         if(isset($rs["accountId"])){
            	$accountValue = ExecuteScalar("SELECT value FROM fin_accountsreceivable WHERE id = ".$rs['accountId']."");
            	updateAccountStatus($rs["accountId"], $accountValue, 1);
         }
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
