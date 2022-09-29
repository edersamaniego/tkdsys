<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fin_employee
 */
class FinEmployee extends DbTable
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
    public $uniqueId;
    public $name;
    public $middlename;
    public $lastname;
    public $country;
    public $state;
    public $city;
    public $address;
    public $neighborhood;
    public $zipcode;
    public $_register;
    public $user;
    public $lastUpdate;
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
        $this->TableVar = 'fin_employee';
        $this->TableName = 'fin_employee';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fin_employee`";
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
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'fin_employee',
            'fin_employee',
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

        // uniqueId
        $this->uniqueId = new DbField(
            'fin_employee',
            'fin_employee',
            'x_uniqueId',
            'uniqueId',
            '`uniqueId`',
            '`uniqueId`',
            200,
            255,
            -1,
            false,
            '`uniqueId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uniqueId->InputTextType = "text";
        $this->Fields['uniqueId'] = &$this->uniqueId;

        // name
        $this->name = new DbField(
            'fin_employee',
            'fin_employee',
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

        // middlename
        $this->middlename = new DbField(
            'fin_employee',
            'fin_employee',
            'x_middlename',
            'middlename',
            '`middlename`',
            '`middlename`',
            200,
            255,
            -1,
            false,
            '`middlename`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->middlename->InputTextType = "text";
        $this->Fields['middlename'] = &$this->middlename;

        // lastname
        $this->lastname = new DbField(
            'fin_employee',
            'fin_employee',
            'x_lastname',
            'lastname',
            '`lastname`',
            '`lastname`',
            200,
            255,
            -1,
            false,
            '`lastname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastname->InputTextType = "text";
        $this->Fields['lastname'] = &$this->lastname;

        // country
        $this->country = new DbField(
            'fin_employee',
            'fin_employee',
            'x_country',
            'country',
            '`country`',
            '`country`',
            200,
            255,
            -1,
            false,
            '`country`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->country->InputTextType = "text";
        $this->Fields['country'] = &$this->country;

        // state
        $this->state = new DbField(
            'fin_employee',
            'fin_employee',
            'x_state',
            'state',
            '`state`',
            '`state`',
            200,
            255,
            -1,
            false,
            '`state`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->state->InputTextType = "text";
        $this->Fields['state'] = &$this->state;

        // city
        $this->city = new DbField(
            'fin_employee',
            'fin_employee',
            'x_city',
            'city',
            '`city`',
            '`city`',
            200,
            255,
            -1,
            false,
            '`city`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->city->InputTextType = "text";
        $this->Fields['city'] = &$this->city;

        // address
        $this->address = new DbField(
            'fin_employee',
            'fin_employee',
            'x_address',
            'address',
            '`address`',
            '`address`',
            200,
            255,
            -1,
            false,
            '`address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->address->InputTextType = "text";
        $this->Fields['address'] = &$this->address;

        // neighborhood
        $this->neighborhood = new DbField(
            'fin_employee',
            'fin_employee',
            'x_neighborhood',
            'neighborhood',
            '`neighborhood`',
            '`neighborhood`',
            200,
            255,
            -1,
            false,
            '`neighborhood`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->neighborhood->InputTextType = "text";
        $this->Fields['neighborhood'] = &$this->neighborhood;

        // zipcode
        $this->zipcode = new DbField(
            'fin_employee',
            'fin_employee',
            'x_zipcode',
            'zipcode',
            '`zipcode`',
            '`zipcode`',
            200,
            255,
            -1,
            false,
            '`zipcode`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->zipcode->InputTextType = "text";
        $this->Fields['zipcode'] = &$this->zipcode;

        // register
        $this->_register = new DbField(
            'fin_employee',
            'fin_employee',
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

        // user
        $this->user = new DbField(
            'fin_employee',
            'fin_employee',
            'x_user',
            'user',
            '`user`',
            '`user`',
            3,
            11,
            -1,
            false,
            '`user`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->user->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->user->Lookup = new Lookup('user', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->user) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->user->Lookup = new Lookup('user', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->user) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->user->Lookup = new Lookup('user', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->user) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->user->Lookup = new Lookup('user', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->user) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->user->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['user'] = &$this->user;

        // lastUpdate
        $this->lastUpdate = new DbField(
            'fin_employee',
            'fin_employee',
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

        // schoolId
        $this->schoolId = new DbField(
            'fin_employee',
            'fin_employee',
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
            'fin_employee',
            'fin_employee',
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fin_employee`";
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
        $this->uniqueId->DbValue = $row['uniqueId'];
        $this->name->DbValue = $row['name'];
        $this->middlename->DbValue = $row['middlename'];
        $this->lastname->DbValue = $row['lastname'];
        $this->country->DbValue = $row['country'];
        $this->state->DbValue = $row['state'];
        $this->city->DbValue = $row['city'];
        $this->address->DbValue = $row['address'];
        $this->neighborhood->DbValue = $row['neighborhood'];
        $this->zipcode->DbValue = $row['zipcode'];
        $this->_register->DbValue = $row['register'];
        $this->user->DbValue = $row['user'];
        $this->lastUpdate->DbValue = $row['lastUpdate'];
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
        return $_SESSION[$name] ?? GetUrl("FinEmployeeList");
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
        if ($pageName == "FinEmployeeView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FinEmployeeEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FinEmployeeAdd") {
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
                return "FinEmployeeView";
            case Config("API_ADD_ACTION"):
                return "FinEmployeeAdd";
            case Config("API_EDIT_ACTION"):
                return "FinEmployeeEdit";
            case Config("API_DELETE_ACTION"):
                return "FinEmployeeDelete";
            case Config("API_LIST_ACTION"):
                return "FinEmployeeList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FinEmployeeList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FinEmployeeView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FinEmployeeView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FinEmployeeAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FinEmployeeAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("FinEmployeeEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("FinEmployeeAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("FinEmployeeDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
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
        $this->uniqueId->setDbValue($row['uniqueId']);
        $this->name->setDbValue($row['name']);
        $this->middlename->setDbValue($row['middlename']);
        $this->lastname->setDbValue($row['lastname']);
        $this->country->setDbValue($row['country']);
        $this->state->setDbValue($row['state']);
        $this->city->setDbValue($row['city']);
        $this->address->setDbValue($row['address']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->zipcode->setDbValue($row['zipcode']);
        $this->_register->setDbValue($row['register']);
        $this->user->setDbValue($row['user']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
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

        // uniqueId

        // name

        // middlename

        // lastname

        // country

        // state

        // city

        // address

        // neighborhood

        // zipcode

        // register

        // user

        // lastUpdate

        // schoolId

        // masterSchoolId

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // uniqueId
        $this->uniqueId->ViewValue = $this->uniqueId->CurrentValue;
        $this->uniqueId->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // middlename
        $this->middlename->ViewValue = $this->middlename->CurrentValue;
        $this->middlename->ViewCustomAttributes = "";

        // lastname
        $this->lastname->ViewValue = $this->lastname->CurrentValue;
        $this->lastname->ViewCustomAttributes = "";

        // country
        $this->country->ViewValue = $this->country->CurrentValue;
        $this->country->ViewCustomAttributes = "";

        // state
        $this->state->ViewValue = $this->state->CurrentValue;
        $this->state->ViewCustomAttributes = "";

        // city
        $this->city->ViewValue = $this->city->CurrentValue;
        $this->city->ViewCustomAttributes = "";

        // address
        $this->address->ViewValue = $this->address->CurrentValue;
        $this->address->ViewCustomAttributes = "";

        // neighborhood
        $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
        $this->neighborhood->ViewCustomAttributes = "";

        // zipcode
        $this->zipcode->ViewValue = $this->zipcode->CurrentValue;
        $this->zipcode->ViewCustomAttributes = "";

        // register
        $this->_register->ViewValue = $this->_register->CurrentValue;
        $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
        $this->_register->ViewCustomAttributes = "";

        // user
        $this->user->ViewValue = $this->user->CurrentValue;
        $curVal = strval($this->user->CurrentValue);
        if ($curVal != "") {
            $this->user->ViewValue = $this->user->lookupCacheOption($curVal);
            if ($this->user->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->user->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->user->Lookup->renderViewRow($rswrk[0]);
                    $this->user->ViewValue = $this->user->displayValue($arwrk);
                } else {
                    $this->user->ViewValue = FormatNumber($this->user->CurrentValue, $this->user->formatPattern());
                }
            }
        } else {
            $this->user->ViewValue = null;
        }
        $this->user->ViewCustomAttributes = "";

        // lastUpdate
        $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
        $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
        $this->lastUpdate->ViewCustomAttributes = "";

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

        // uniqueId
        $this->uniqueId->LinkCustomAttributes = "";
        $this->uniqueId->HrefValue = "";
        $this->uniqueId->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // middlename
        $this->middlename->LinkCustomAttributes = "";
        $this->middlename->HrefValue = "";
        $this->middlename->TooltipValue = "";

        // lastname
        $this->lastname->LinkCustomAttributes = "";
        $this->lastname->HrefValue = "";
        $this->lastname->TooltipValue = "";

        // country
        $this->country->LinkCustomAttributes = "";
        $this->country->HrefValue = "";
        $this->country->TooltipValue = "";

        // state
        $this->state->LinkCustomAttributes = "";
        $this->state->HrefValue = "";
        $this->state->TooltipValue = "";

        // city
        $this->city->LinkCustomAttributes = "";
        $this->city->HrefValue = "";
        $this->city->TooltipValue = "";

        // address
        $this->address->LinkCustomAttributes = "";
        $this->address->HrefValue = "";
        $this->address->TooltipValue = "";

        // neighborhood
        $this->neighborhood->LinkCustomAttributes = "";
        $this->neighborhood->HrefValue = "";
        $this->neighborhood->TooltipValue = "";

        // zipcode
        $this->zipcode->LinkCustomAttributes = "";
        $this->zipcode->HrefValue = "";
        $this->zipcode->TooltipValue = "";

        // register
        $this->_register->LinkCustomAttributes = "";
        $this->_register->HrefValue = "";
        $this->_register->TooltipValue = "";

        // user
        $this->user->LinkCustomAttributes = "";
        $this->user->HrefValue = "";
        $this->user->TooltipValue = "";

        // lastUpdate
        $this->lastUpdate->LinkCustomAttributes = "";
        $this->lastUpdate->HrefValue = "";
        $this->lastUpdate->TooltipValue = "";

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

        // uniqueId
        $this->uniqueId->setupEditAttributes();
        $this->uniqueId->EditCustomAttributes = "";
        if (!$this->uniqueId->Raw) {
            $this->uniqueId->CurrentValue = HtmlDecode($this->uniqueId->CurrentValue);
        }
        $this->uniqueId->EditValue = $this->uniqueId->CurrentValue;
        $this->uniqueId->PlaceHolder = RemoveHtml($this->uniqueId->caption());

        // name
        $this->name->setupEditAttributes();
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // middlename
        $this->middlename->setupEditAttributes();
        $this->middlename->EditCustomAttributes = "";
        if (!$this->middlename->Raw) {
            $this->middlename->CurrentValue = HtmlDecode($this->middlename->CurrentValue);
        }
        $this->middlename->EditValue = $this->middlename->CurrentValue;
        $this->middlename->PlaceHolder = RemoveHtml($this->middlename->caption());

        // lastname
        $this->lastname->setupEditAttributes();
        $this->lastname->EditCustomAttributes = "";
        if (!$this->lastname->Raw) {
            $this->lastname->CurrentValue = HtmlDecode($this->lastname->CurrentValue);
        }
        $this->lastname->EditValue = $this->lastname->CurrentValue;
        $this->lastname->PlaceHolder = RemoveHtml($this->lastname->caption());

        // country
        $this->country->setupEditAttributes();
        $this->country->EditCustomAttributes = "";
        if (!$this->country->Raw) {
            $this->country->CurrentValue = HtmlDecode($this->country->CurrentValue);
        }
        $this->country->EditValue = $this->country->CurrentValue;
        $this->country->PlaceHolder = RemoveHtml($this->country->caption());

        // state
        $this->state->setupEditAttributes();
        $this->state->EditCustomAttributes = "";
        if (!$this->state->Raw) {
            $this->state->CurrentValue = HtmlDecode($this->state->CurrentValue);
        }
        $this->state->EditValue = $this->state->CurrentValue;
        $this->state->PlaceHolder = RemoveHtml($this->state->caption());

        // city
        $this->city->setupEditAttributes();
        $this->city->EditCustomAttributes = "";
        if (!$this->city->Raw) {
            $this->city->CurrentValue = HtmlDecode($this->city->CurrentValue);
        }
        $this->city->EditValue = $this->city->CurrentValue;
        $this->city->PlaceHolder = RemoveHtml($this->city->caption());

        // address
        $this->address->setupEditAttributes();
        $this->address->EditCustomAttributes = "";
        if (!$this->address->Raw) {
            $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
        }
        $this->address->EditValue = $this->address->CurrentValue;
        $this->address->PlaceHolder = RemoveHtml($this->address->caption());

        // neighborhood
        $this->neighborhood->setupEditAttributes();
        $this->neighborhood->EditCustomAttributes = "";
        if (!$this->neighborhood->Raw) {
            $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
        }
        $this->neighborhood->EditValue = $this->neighborhood->CurrentValue;
        $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

        // zipcode
        $this->zipcode->setupEditAttributes();
        $this->zipcode->EditCustomAttributes = "";
        if (!$this->zipcode->Raw) {
            $this->zipcode->CurrentValue = HtmlDecode($this->zipcode->CurrentValue);
        }
        $this->zipcode->EditValue = $this->zipcode->CurrentValue;
        $this->zipcode->PlaceHolder = RemoveHtml($this->zipcode->caption());

        // register
        $this->_register->setupEditAttributes();
        $this->_register->EditCustomAttributes = "";
        $this->_register->EditValue = FormatDateTime($this->_register->CurrentValue, $this->_register->formatPattern());
        $this->_register->PlaceHolder = RemoveHtml($this->_register->caption());

        // user
        $this->user->setupEditAttributes();
        $this->user->EditCustomAttributes = "";
        $this->user->EditValue = $this->user->CurrentValue;
        $this->user->PlaceHolder = RemoveHtml($this->user->caption());

        // lastUpdate

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->EditValue = $this->schoolId->CurrentValue;
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
        }

        // masterSchoolId
        $this->masterSchoolId->setupEditAttributes();
        $this->masterSchoolId->EditCustomAttributes = "";
        $this->masterSchoolId->EditValue = $this->masterSchoolId->CurrentValue;
        $this->masterSchoolId->PlaceHolder = RemoveHtml($this->masterSchoolId->caption());

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
                    $doc->exportCaption($this->uniqueId);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->middlename);
                    $doc->exportCaption($this->lastname);
                    $doc->exportCaption($this->country);
                    $doc->exportCaption($this->state);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->zipcode);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->masterSchoolId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->uniqueId);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->middlename);
                    $doc->exportCaption($this->lastname);
                    $doc->exportCaption($this->country);
                    $doc->exportCaption($this->state);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->zipcode);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->lastUpdate);
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
                        $doc->exportField($this->uniqueId);
                        $doc->exportField($this->name);
                        $doc->exportField($this->middlename);
                        $doc->exportField($this->lastname);
                        $doc->exportField($this->country);
                        $doc->exportField($this->state);
                        $doc->exportField($this->city);
                        $doc->exportField($this->address);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->zipcode);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->user);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->masterSchoolId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->uniqueId);
                        $doc->exportField($this->name);
                        $doc->exportField($this->middlename);
                        $doc->exportField($this->lastname);
                        $doc->exportField($this->country);
                        $doc->exportField($this->state);
                        $doc->exportField($this->city);
                        $doc->exportField($this->address);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->zipcode);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->user);
                        $doc->exportField($this->lastUpdate);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `fin_employee`";
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
        $rsnew['user'] = GetLoggedUserID();
        $rsnew['schoolId'] = CurrentUserID();
        $rsnew['masterSchoolId'] = CurrentUserMasterSchoolID();
        $rsnew['register'] = ExecuteScalar('SELECT NOW()');
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
