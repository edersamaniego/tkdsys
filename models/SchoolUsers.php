<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for school_users
 */
class SchoolUsers extends DbTable
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
    public $name;
    public $lastName;
    public $schoolIdMaster;
    public $schoolId;
    public $_login;
    public $_email;
    public $activateEmail;
    public $profileField;
    public $_password;
    public $createUserId;
    public $createDate;
    public $level;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'school_users';
        $this->TableName = 'school_users';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`school_users`";
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
            'school_users',
            'school_users',
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

        // name
        $this->name = new DbField(
            'school_users',
            'school_users',
            'x_name',
            'name',
            '`name`',
            '`name`',
            200,
            50,
            -1,
            false,
            '`name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->name->InputTextType = "text";
        $this->Fields['name'] = &$this->name;

        // lastName
        $this->lastName = new DbField(
            'school_users',
            'school_users',
            'x_lastName',
            'lastName',
            '`lastName`',
            '`lastName`',
            200,
            255,
            -1,
            false,
            '`lastName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastName->InputTextType = "text";
        $this->Fields['lastName'] = &$this->lastName;

        // schoolIdMaster
        $this->schoolIdMaster = new DbField(
            'school_users',
            'school_users',
            'x_schoolIdMaster',
            'schoolIdMaster',
            '`schoolIdMaster`',
            '`schoolIdMaster`',
            3,
            11,
            -1,
            false,
            '`schoolIdMaster`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->schoolIdMaster->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schoolIdMaster->Lookup = new Lookup('schoolIdMaster', 'fed_school', false, 'id', ["school","owner","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolIdMaster) . "',COALESCE(`owner`,''))");
                break;
            case "pt-BR":
                $this->schoolIdMaster->Lookup = new Lookup('schoolIdMaster', 'fed_school', false, 'id', ["school","owner","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolIdMaster) . "',COALESCE(`owner`,''))");
                break;
            case "es":
                $this->schoolIdMaster->Lookup = new Lookup('schoolIdMaster', 'fed_school', false, 'id', ["school","owner","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolIdMaster) . "',COALESCE(`owner`,''))");
                break;
            default:
                $this->schoolIdMaster->Lookup = new Lookup('schoolIdMaster', 'fed_school', false, 'id', ["school","owner","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolIdMaster) . "',COALESCE(`owner`,''))");
                break;
        }
        $this->schoolIdMaster->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolIdMaster'] = &$this->schoolIdMaster;

        // schoolId
        $this->schoolId = new DbField(
            'school_users',
            'school_users',
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
            'SELECT'
        );
        $this->schoolId->InputTextType = "text";
        $this->schoolId->IsForeignKey = true; // Foreign key field
        $this->schoolId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->schoolId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","owner","",""], ["fed_school x_masterSchoolId"], [], ["masterSchoolId"], ["x_masterSchoolId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`owner`,''))");
                break;
            case "pt-BR":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","owner","",""], ["fed_school x_masterSchoolId"], [], ["masterSchoolId"], ["x_masterSchoolId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`owner`,''))");
                break;
            case "es":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","owner","",""], ["fed_school x_masterSchoolId"], [], ["masterSchoolId"], ["x_masterSchoolId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`owner`,''))");
                break;
            default:
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","owner","",""], ["fed_school x_masterSchoolId"], [], ["masterSchoolId"], ["x_masterSchoolId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`owner`,''))");
                break;
        }
        $this->schoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolId'] = &$this->schoolId;

        // login
        $this->_login = new DbField(
            'school_users',
            'school_users',
            'x__login',
            'login',
            '`login`',
            '`login`',
            200,
            255,
            -1,
            false,
            '`login`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_login->InputTextType = "text";
        $this->Fields['login'] = &$this->_login;

        // email
        $this->_email = new DbField(
            'school_users',
            'school_users',
            'x__email',
            'email',
            '`email`',
            '`email`',
            200,
            255,
            -1,
            false,
            '`email`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_email->InputTextType = "text";
        $this->_email->Required = true; // Required field
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->Fields['email'] = &$this->_email;

        // activateEmail
        $this->activateEmail = new DbField(
            'school_users',
            'school_users',
            'x_activateEmail',
            'activateEmail',
            '`activateEmail`',
            '`activateEmail`',
            16,
            4,
            -1,
            false,
            '`activateEmail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->activateEmail->InputTextType = "text";
        $this->activateEmail->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['activateEmail'] = &$this->activateEmail;

        // profileField
        $this->profileField = new DbField(
            'school_users',
            'school_users',
            'x_profileField',
            'profileField',
            '`profileField`',
            '`profileField`',
            201,
            -1,
            -1,
            false,
            '`profileField`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->profileField->InputTextType = "text";
        $this->Fields['profileField'] = &$this->profileField;

        // password
        $this->_password = new DbField(
            'school_users',
            'school_users',
            'x__password',
            'password',
            '`password`',
            '`password`',
            200,
            255,
            -1,
            false,
            '`password`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'PASSWORD'
        );
        $this->_password->InputTextType = "text";
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->_password->Raw = true;
        }
        $this->_password->Required = true; // Required field
        $this->Fields['password'] = &$this->_password;

        // createUserId
        $this->createUserId = new DbField(
            'school_users',
            'school_users',
            'x_createUserId',
            'createUserId',
            '`createUserId`',
            '`createUserId`',
            3,
            11,
            -1,
            false,
            '`createUserId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->createUserId->InputTextType = "text";
        $this->createUserId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->createUserId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->createUserId->Lookup = new Lookup('createUserId', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            case "pt-BR":
                $this->createUserId->Lookup = new Lookup('createUserId', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            case "es":
                $this->createUserId->Lookup = new Lookup('createUserId', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            default:
                $this->createUserId->Lookup = new Lookup('createUserId', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
        }
        $this->createUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['createUserId'] = &$this->createUserId;

        // createDate
        $this->createDate = new DbField(
            'school_users',
            'school_users',
            'x_createDate',
            'createDate',
            '`createDate`',
            CastDateFieldForLike("`createDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`createDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->createDate->InputTextType = "text";
        $this->createDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['createDate'] = &$this->createDate;

        // level
        $this->level = new DbField(
            'school_users',
            'school_users',
            'x_level',
            'level',
            '`level`',
            '`level`',
            3,
            11,
            -1,
            false,
            '`level`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->level->InputTextType = "text";
        $this->level->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->level->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            case "pt-BR":
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            case "es":
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
            default:
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '', "`userlevelname`");
                break;
        }
        $this->level->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['level'] = &$this->level;

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
        if ($this->getCurrentMasterTable() == "fed_school") {
            if ($this->schoolId->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->schoolId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "fed_school") {
            if ($this->schoolId->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`schoolId`", $this->schoolId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
            case "fed_school":
                $key = $keys["schoolId"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["schoolId"], $masterTable->id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "fed_school":
                return "`schoolId`=" . QuotedValue($masterTable->id->DbValue, $this->schoolId->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`school_users`";
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
        $this->DefaultFilter = "";
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
        $this->name->DbValue = $row['name'];
        $this->lastName->DbValue = $row['lastName'];
        $this->schoolIdMaster->DbValue = $row['schoolIdMaster'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->_login->DbValue = $row['login'];
        $this->_email->DbValue = $row['email'];
        $this->activateEmail->DbValue = $row['activateEmail'];
        $this->profileField->DbValue = $row['profileField'];
        $this->_password->DbValue = $row['password'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->createDate->DbValue = $row['createDate'];
        $this->level->DbValue = $row['level'];
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
        return $_SESSION[$name] ?? GetUrl("SchoolUsersList");
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
        if ($pageName == "SchoolUsersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SchoolUsersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SchoolUsersAdd") {
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
                return "SchoolUsersView";
            case Config("API_ADD_ACTION"):
                return "SchoolUsersAdd";
            case Config("API_EDIT_ACTION"):
                return "SchoolUsersEdit";
            case Config("API_DELETE_ACTION"):
                return "SchoolUsersDelete";
            case Config("API_LIST_ACTION"):
                return "SchoolUsersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SchoolUsersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SchoolUsersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SchoolUsersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SchoolUsersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SchoolUsersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SchoolUsersEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("SchoolUsersAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("SchoolUsersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "fed_school" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->schoolId->CurrentValue);
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
        $this->name->setDbValue($row['name']);
        $this->lastName->setDbValue($row['lastName']);
        $this->schoolIdMaster->setDbValue($row['schoolIdMaster']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->_login->setDbValue($row['login']);
        $this->_email->setDbValue($row['email']);
        $this->activateEmail->setDbValue($row['activateEmail']);
        $this->profileField->setDbValue($row['profileField']);
        $this->_password->setDbValue($row['password']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->level->setDbValue($row['level']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // name

        // lastName

        // schoolIdMaster

        // schoolId

        // login

        // email

        // activateEmail

        // profileField

        // password

        // createUserId

        // createDate

        // level

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // lastName
        $this->lastName->ViewValue = $this->lastName->CurrentValue;
        $this->lastName->ViewCustomAttributes = "";

        // schoolIdMaster
        $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->CurrentValue;
        $curVal = strval($this->schoolIdMaster->CurrentValue);
        if ($curVal != "") {
            $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->lookupCacheOption($curVal);
            if ($this->schoolIdMaster->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`typeId`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->schoolIdMaster->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->schoolIdMaster->Lookup->renderViewRow($rswrk[0]);
                    $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->displayValue($arwrk);
                } else {
                    $this->schoolIdMaster->ViewValue = FormatNumber($this->schoolIdMaster->CurrentValue, $this->schoolIdMaster->formatPattern());
                }
            }
        } else {
            $this->schoolIdMaster->ViewValue = null;
        }
        $this->schoolIdMaster->ViewCustomAttributes = "";

        // schoolId
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

        // login
        $this->_login->ViewValue = $this->_login->CurrentValue;
        $this->_login->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // activateEmail
        $this->activateEmail->ViewValue = $this->activateEmail->CurrentValue;
        $this->activateEmail->ViewValue = FormatNumber($this->activateEmail->ViewValue, $this->activateEmail->formatPattern());
        $this->activateEmail->ViewCustomAttributes = "";

        // profileField
        $this->profileField->ViewValue = $this->profileField->CurrentValue;
        $this->profileField->ViewCustomAttributes = "";

        // password
        $this->_password->ViewValue = $Language->phrase("PasswordMask");
        $this->_password->ViewCustomAttributes = "";

        // createUserId
        $curVal = strval($this->createUserId->CurrentValue);
        if ($curVal != "") {
            $this->createUserId->ViewValue = $this->createUserId->lookupCacheOption($curVal);
            if ($this->createUserId->ViewValue === null) { // Lookup from database
                $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->createUserId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->createUserId->Lookup->renderViewRow($rswrk[0]);
                    $this->createUserId->ViewValue = $this->createUserId->displayValue($arwrk);
                } else {
                    $this->createUserId->ViewValue = FormatNumber($this->createUserId->CurrentValue, $this->createUserId->formatPattern());
                }
            }
        } else {
            $this->createUserId->ViewValue = null;
        }
        $this->createUserId->ViewCustomAttributes = "";

        // createDate
        $this->createDate->ViewValue = $this->createDate->CurrentValue;
        $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
        $this->createDate->ViewCustomAttributes = "";

        // level
        if ($Security->canAdmin()) { // System admin
            $curVal = strval($this->level->CurrentValue);
            if ($curVal != "") {
                $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                if ($this->level->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                        $this->level->ViewValue = $this->level->displayValue($arwrk);
                    } else {
                        $this->level->ViewValue = FormatNumber($this->level->CurrentValue, $this->level->formatPattern());
                    }
                }
            } else {
                $this->level->ViewValue = null;
            }
        } else {
            $this->level->ViewValue = $Language->phrase("PasswordMask");
        }
        $this->level->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // lastName
        $this->lastName->LinkCustomAttributes = "";
        $this->lastName->HrefValue = "";
        $this->lastName->TooltipValue = "";

        // schoolIdMaster
        $this->schoolIdMaster->LinkCustomAttributes = "";
        $this->schoolIdMaster->HrefValue = "";
        $this->schoolIdMaster->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // login
        $this->_login->LinkCustomAttributes = "";
        $this->_login->HrefValue = "";
        $this->_login->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // activateEmail
        $this->activateEmail->LinkCustomAttributes = "";
        $this->activateEmail->HrefValue = "";
        $this->activateEmail->TooltipValue = "";

        // profileField
        $this->profileField->LinkCustomAttributes = "";
        $this->profileField->HrefValue = "";
        $this->profileField->TooltipValue = "";

        // password
        $this->_password->LinkCustomAttributes = "";
        $this->_password->HrefValue = "";
        $this->_password->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

        // level
        $this->level->LinkCustomAttributes = "";
        $this->level->HrefValue = "";
        $this->level->TooltipValue = "";

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

        // name
        $this->name->setupEditAttributes();
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // lastName
        $this->lastName->setupEditAttributes();
        $this->lastName->EditCustomAttributes = "";
        if (!$this->lastName->Raw) {
            $this->lastName->CurrentValue = HtmlDecode($this->lastName->CurrentValue);
        }
        $this->lastName->EditValue = $this->lastName->CurrentValue;
        $this->lastName->PlaceHolder = RemoveHtml($this->lastName->caption());

        // schoolIdMaster
        $this->schoolIdMaster->setupEditAttributes();
        $this->schoolIdMaster->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            if (SameString($this->schoolId->CurrentValue, CurrentUserID())) {
                $this->schoolIdMaster->EditValue = $this->schoolIdMaster->CurrentValue;
                $curVal = strval($this->schoolIdMaster->CurrentValue);
                if ($curVal != "") {
                    $this->schoolIdMaster->EditValue = $this->schoolIdMaster->lookupCacheOption($curVal);
                    if ($this->schoolIdMaster->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`typeId`=1";
                        };
                        $lookupFilter = $lookupFilter->bindTo($this);
                        $sqlWrk = $this->schoolIdMaster->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->schoolIdMaster->Lookup->renderViewRow($rswrk[0]);
                            $this->schoolIdMaster->EditValue = $this->schoolIdMaster->displayValue($arwrk);
                        } else {
                            $this->schoolIdMaster->EditValue = FormatNumber($this->schoolIdMaster->CurrentValue, $this->schoolIdMaster->formatPattern());
                        }
                    }
                } else {
                    $this->schoolIdMaster->EditValue = null;
                }
                $this->schoolIdMaster->ViewCustomAttributes = "";
            } else {
            }
        } else {
            $this->schoolIdMaster->EditValue = $this->schoolIdMaster->CurrentValue;
            $this->schoolIdMaster->PlaceHolder = RemoveHtml($this->schoolIdMaster->caption());
        }

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if ($this->schoolId->getSessionValue() != "") {
            $this->schoolId->CurrentValue = GetForeignKeyValue($this->schoolId->getSessionValue());
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
        } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
        }

        // login
        $this->_login->setupEditAttributes();
        $this->_login->EditCustomAttributes = "";
        if (!$this->_login->Raw) {
            $this->_login->CurrentValue = HtmlDecode($this->_login->CurrentValue);
        }
        $this->_login->EditValue = $this->_login->CurrentValue;
        $this->_login->PlaceHolder = RemoveHtml($this->_login->caption());

        // email
        $this->_email->setupEditAttributes();
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // activateEmail
        $this->activateEmail->setupEditAttributes();
        $this->activateEmail->EditCustomAttributes = "";
        $this->activateEmail->EditValue = $this->activateEmail->CurrentValue;
        $this->activateEmail->PlaceHolder = RemoveHtml($this->activateEmail->caption());
        if (strval($this->activateEmail->EditValue) != "" && is_numeric($this->activateEmail->EditValue)) {
            $this->activateEmail->EditValue = FormatNumber($this->activateEmail->EditValue, null);
        }

        // profileField
        $this->profileField->setupEditAttributes();
        $this->profileField->EditCustomAttributes = "";
        $this->profileField->EditValue = $this->profileField->CurrentValue;
        $this->profileField->PlaceHolder = RemoveHtml($this->profileField->caption());

        // password
        $this->_password->setupEditAttributes();
        $this->_password->EditCustomAttributes = "";
        $this->_password->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // createUserId

        // createDate

        // level
        $this->level->setupEditAttributes();
        $this->level->EditCustomAttributes = "";
        if (!$Security->canAdmin()) { // System admin
            $this->level->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->level->PlaceHolder = RemoveHtml($this->level->caption());
        }

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
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->lastName);
                    $doc->exportCaption($this->schoolIdMaster);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->_login);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->activateEmail);
                    $doc->exportCaption($this->profileField);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->level);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->lastName);
                    $doc->exportCaption($this->schoolIdMaster);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->_login);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->activateEmail);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->level);
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
                        $doc->exportField($this->name);
                        $doc->exportField($this->lastName);
                        $doc->exportField($this->schoolIdMaster);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->_login);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->activateEmail);
                        $doc->exportField($this->profileField);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->level);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->lastName);
                        $doc->exportField($this->schoolIdMaster);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->_login);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->activateEmail);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->level);
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

    // User ID filter
    public function getUserIDFilter($userId)
    {
        global $Security;
        $userIdFilter = '`schoolId` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID"));
        $parentUserIdFilter = '`schoolId` IN (SELECT `schoolId` FROM ' . "`school_users`" . ' WHERE `schoolIdMaster` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID")) . ')';
        $userIdFilter = "(" . $userIdFilter . ") OR (" . $parentUserIdFilter . ")";
        return $userIdFilter;
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

    // Add Parent User ID filter
    public function addParentUserIDFilter($userId)
    {
        global $Security;
        if (!$Security->isAdmin()) {
            $result = $Security->parentUserIDList($userId);
            if ($result != "") {
                $result = '`schoolId` IN (' . $result . ')';
            }
            return $result;
        }
        return "";
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `school_users`";
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
        if ($currentMasterTable == "fed_school") {
            $filterWrk = Container("fed_school")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "fed_school") {
            $mastertable = Container("fed_school");
            if (!$mastertable->userIDAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->schoolId, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
    }

    // Send register email
    public function sendRegisterEmail($row)
    {
        // Get user language
        global $UserProfile;
        $userName = GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
        $langId = $UserProfile->getLanguageId($userName);
        $email = $this->prepareRegisterEmail($row, $langId);
        $args = [];
        $args["rs"] = $row;
        $emailSent = false;
        if ($this->emailSending($email, $args)) { // Use Email_Sending server event of user table
            $emailSent = $email->send();
        }
        return $emailSent;
    }

    // Get activate link
    public function getActivateLink($username, $password, $email)
    {
        return FullUrl("register", "activate") . "?action=confirm&user=" . urlencode($username) . "&activatetoken=" . Encrypt($email) . "," . Encrypt($username) . "," . Encrypt($password);
    }

    // Prepare register email
    public function prepareRegisterEmail($row = null, $langId = "")
    {
        global $CurrentForm;
        $email = new Email();
        $email->load(Config("EMAIL_REGISTER_TEMPLATE"), $langId);
        $email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
        $emailAddress = $row === null ? $this->_email->CurrentValue : GetUserInfo(Config("USER_EMAIL_FIELD_NAME"), $row);
        $emailAddress = $emailAddress ?: Config("RECIPIENT_EMAIL"); // Send to recipient directly if no email address
        $email->replaceRecipient($emailAddress); // Replace Recipient
        if (!SameText($emailAddress, Config("RECIPIENT_EMAIL"))) { // Add Bcc
            $email->addBcc(Config("RECIPIENT_EMAIL"));
        }
        $email->replaceContent('<!--FieldCaption_name-->', $this->name->caption());
        $email->replaceContent('<!--name-->', $row === null ? strval($this->name->FormValue) : GetUserInfo('name', $row));
        $email->replaceContent('<!--FieldCaption_lastName-->', $this->lastName->caption());
        $email->replaceContent('<!--lastName-->', $row === null ? strval($this->lastName->FormValue) : GetUserInfo('lastName', $row));
        $email->replaceContent('<!--FieldCaption_email-->', $this->_email->caption());
        $email->replaceContent('<!--email-->', $row === null ? strval($this->_email->FormValue) : GetUserInfo('email', $row));
        $email->replaceContent('<!--FieldCaption_password-->', $this->_password->caption());
        $email->replaceContent('<!--password-->', $row === null ? strval($this->_password->FormValue) : GetUserInfo('password', $row));
        $username = $row === null ? $this->_email->CurrentValue : GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
        $password = $row === null ? ($CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password")) : GetUserInfo(Config("LOGIN_PASSWORD_FIELD_NAME"), $row); // Use raw password post value
        $email->replaceContent("<!--ActivateLink-->", $this->getActivateLink($username, $password, $emailAddress));
        return $email;
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
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
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
