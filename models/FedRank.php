<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fed_rank
 */
class FedRank extends DbTable
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
    public $rankBR;
    public $rankUS;
    public $rankES;
    public $ranking;
    public $nextrankId;
    public $levelTournamentId;
    public $martialArtsId;
    public $createUserId;
    public $createDate;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fed_rank';
        $this->TableName = 'fed_rank';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fed_rank`";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'fed_rank',
            'fed_rank',
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

        // rankBR
        $this->rankBR = new DbField(
            'fed_rank',
            'fed_rank',
            'x_rankBR',
            'rankBR',
            '`rankBR`',
            '`rankBR`',
            200,
            45,
            -1,
            false,
            '`rankBR`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rankBR->InputTextType = "text";
        $this->Fields['rankBR'] = &$this->rankBR;

        // rankUS
        $this->rankUS = new DbField(
            'fed_rank',
            'fed_rank',
            'x_rankUS',
            'rankUS',
            '`rankUS`',
            '`rankUS`',
            200,
            45,
            -1,
            false,
            '`rankUS`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rankUS->InputTextType = "text";
        $this->Fields['rankUS'] = &$this->rankUS;

        // rankES
        $this->rankES = new DbField(
            'fed_rank',
            'fed_rank',
            'x_rankES',
            'rankES',
            '`rankES`',
            '`rankES`',
            200,
            45,
            -1,
            false,
            '`rankES`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->rankES->InputTextType = "text";
        $this->Fields['rankES'] = &$this->rankES;

        // ranking
        $this->ranking = new DbField(
            'fed_rank',
            'fed_rank',
            'x_ranking',
            'ranking',
            '`ranking`',
            '`ranking`',
            200,
            45,
            -1,
            false,
            '`ranking`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ranking->InputTextType = "text";
        $this->Fields['ranking'] = &$this->ranking;

        // nextrankId
        $this->nextrankId = new DbField(
            'fed_rank',
            'fed_rank',
            'x_nextrankId',
            'nextrankId',
            '`nextrankId`',
            '`nextrankId`',
            3,
            11,
            -1,
            false,
            '`nextrankId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->nextrankId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->nextrankId->Lookup = new Lookup('nextrankId', 'fed_rank', false, 'id', ["rankUS","","",""], [], [], [], [], [], [], '', '', "`rankUS`");
                break;
            case "pt-BR":
                $this->nextrankId->Lookup = new Lookup('nextrankId', 'fed_rank', false, 'id', ["rankBR","","",""], [], [], [], [], [], [], '', '', "`rankBR`");
                break;
            case "es":
                $this->nextrankId->Lookup = new Lookup('nextrankId', 'fed_rank', false, 'id', ["rankES","","",""], [], [], [], [], [], [], '', '', "`rankES`");
                break;
            default:
                $this->nextrankId->Lookup = new Lookup('nextrankId', 'fed_rank', false, 'id', ["rankBR","","",""], [], [], [], [], [], [], '', '', "`rankBR`");
                break;
        }
        $this->nextrankId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['nextrankId'] = &$this->nextrankId;

        // levelTournamentId
        $this->levelTournamentId = new DbField(
            'fed_rank',
            'fed_rank',
            'x_levelTournamentId',
            'levelTournamentId',
            '`levelTournamentId`',
            '`levelTournamentId`',
            3,
            11,
            -1,
            false,
            '`levelTournamentId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->levelTournamentId->InputTextType = "text";
        $this->levelTournamentId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['levelTournamentId'] = &$this->levelTournamentId;

        // martialArtsId
        $this->martialArtsId = new DbField(
            'fed_rank',
            'fed_rank',
            'x_martialArtsId',
            'martialArtsId',
            '`martialArtsId`',
            '`martialArtsId`',
            3,
            11,
            -1,
            false,
            '`martialArtsId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->martialArtsId->InputTextType = "text";
        $this->martialArtsId->IsForeignKey = true; // Foreign key field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->martialArtsId->Lookup = new Lookup('martialArtsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            case "pt-BR":
                $this->martialArtsId->Lookup = new Lookup('martialArtsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            case "es":
                $this->martialArtsId->Lookup = new Lookup('martialArtsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            default:
                $this->martialArtsId->Lookup = new Lookup('martialArtsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
        }
        $this->martialArtsId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['martialArtsId'] = &$this->martialArtsId;

        // createUserId
        $this->createUserId = new DbField(
            'fed_rank',
            'fed_rank',
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
            'TEXT'
        );
        $this->createUserId->InputTextType = "text";
        $this->createUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['createUserId'] = &$this->createUserId;

        // createDate
        $this->createDate = new DbField(
            'fed_rank',
            'fed_rank',
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
        if ($this->getCurrentMasterTable() == "fed_martialarts") {
            if ($this->martialArtsId->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->martialArtsId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "fed_martialarts") {
            if ($this->martialArtsId->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`martialArtsId`", $this->martialArtsId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
            case "fed_martialarts":
                $key = $keys["martialArtsId"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["martialArtsId"], $masterTable->id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "fed_martialarts":
                return "`martialArtsId`=" . QuotedValue($masterTable->id->DbValue, $this->martialArtsId->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fed_rank`";
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
        $this->rankBR->DbValue = $row['rankBR'];
        $this->rankUS->DbValue = $row['rankUS'];
        $this->rankES->DbValue = $row['rankES'];
        $this->ranking->DbValue = $row['ranking'];
        $this->nextrankId->DbValue = $row['nextrankId'];
        $this->levelTournamentId->DbValue = $row['levelTournamentId'];
        $this->martialArtsId->DbValue = $row['martialArtsId'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->createDate->DbValue = $row['createDate'];
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
        return $_SESSION[$name] ?? GetUrl("FedRankList");
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
        if ($pageName == "FedRankView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FedRankEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FedRankAdd") {
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
                return "FedRankView";
            case Config("API_ADD_ACTION"):
                return "FedRankAdd";
            case Config("API_EDIT_ACTION"):
                return "FedRankEdit";
            case Config("API_DELETE_ACTION"):
                return "FedRankDelete";
            case Config("API_LIST_ACTION"):
                return "FedRankList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FedRankList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedRankView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedRankView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FedRankAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FedRankAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("FedRankEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("FedRankAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("FedRankDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "fed_martialarts" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->martialArtsId->CurrentValue);
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
        $this->rankBR->setDbValue($row['rankBR']);
        $this->rankUS->setDbValue($row['rankUS']);
        $this->rankES->setDbValue($row['rankES']);
        $this->ranking->setDbValue($row['ranking']);
        $this->nextrankId->setDbValue($row['nextrankId']);
        $this->levelTournamentId->setDbValue($row['levelTournamentId']);
        $this->martialArtsId->setDbValue($row['martialArtsId']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // rankBR

        // rankUS

        // rankES

        // ranking

        // nextrankId

        // levelTournamentId

        // martialArtsId

        // createUserId

        // createDate

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // rankBR
        $this->rankBR->ViewValue = $this->rankBR->CurrentValue;
        $this->rankBR->ViewCustomAttributes = "";

        // rankUS
        $this->rankUS->ViewValue = $this->rankUS->CurrentValue;
        $this->rankUS->ViewCustomAttributes = "";

        // rankES
        $this->rankES->ViewValue = $this->rankES->CurrentValue;
        $this->rankES->ViewCustomAttributes = "";

        // ranking
        $this->ranking->ViewValue = $this->ranking->CurrentValue;
        $this->ranking->ViewCustomAttributes = "";

        // nextrankId
        $this->nextrankId->ViewValue = $this->nextrankId->CurrentValue;
        $curVal = strval($this->nextrankId->CurrentValue);
        if ($curVal != "") {
            $this->nextrankId->ViewValue = $this->nextrankId->lookupCacheOption($curVal);
            if ($this->nextrankId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->nextrankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->nextrankId->Lookup->renderViewRow($rswrk[0]);
                    $this->nextrankId->ViewValue = $this->nextrankId->displayValue($arwrk);
                } else {
                    $this->nextrankId->ViewValue = FormatNumber($this->nextrankId->CurrentValue, $this->nextrankId->formatPattern());
                }
            }
        } else {
            $this->nextrankId->ViewValue = null;
        }
        $this->nextrankId->ViewCustomAttributes = "";

        // levelTournamentId
        $this->levelTournamentId->ViewValue = $this->levelTournamentId->CurrentValue;
        $this->levelTournamentId->ViewValue = FormatNumber($this->levelTournamentId->ViewValue, $this->levelTournamentId->formatPattern());
        $this->levelTournamentId->ViewCustomAttributes = "";

        // martialArtsId
        $this->martialArtsId->ViewValue = $this->martialArtsId->CurrentValue;
        $curVal = strval($this->martialArtsId->CurrentValue);
        if ($curVal != "") {
            $this->martialArtsId->ViewValue = $this->martialArtsId->lookupCacheOption($curVal);
            if ($this->martialArtsId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->martialArtsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->martialArtsId->Lookup->renderViewRow($rswrk[0]);
                    $this->martialArtsId->ViewValue = $this->martialArtsId->displayValue($arwrk);
                } else {
                    $this->martialArtsId->ViewValue = FormatNumber($this->martialArtsId->CurrentValue, $this->martialArtsId->formatPattern());
                }
            }
        } else {
            $this->martialArtsId->ViewValue = null;
        }
        $this->martialArtsId->ViewCustomAttributes = "";

        // createUserId
        $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
        $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
        $this->createUserId->ViewCustomAttributes = "";

        // createDate
        $this->createDate->ViewValue = $this->createDate->CurrentValue;
        $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
        $this->createDate->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // rankBR
        $this->rankBR->LinkCustomAttributes = "";
        $this->rankBR->HrefValue = "";
        $this->rankBR->TooltipValue = "";

        // rankUS
        $this->rankUS->LinkCustomAttributes = "";
        $this->rankUS->HrefValue = "";
        $this->rankUS->TooltipValue = "";

        // rankES
        $this->rankES->LinkCustomAttributes = "";
        $this->rankES->HrefValue = "";
        $this->rankES->TooltipValue = "";

        // ranking
        $this->ranking->LinkCustomAttributes = "";
        $this->ranking->HrefValue = "";
        $this->ranking->TooltipValue = "";

        // nextrankId
        $this->nextrankId->LinkCustomAttributes = "";
        $this->nextrankId->HrefValue = "";
        $this->nextrankId->TooltipValue = "";

        // levelTournamentId
        $this->levelTournamentId->LinkCustomAttributes = "";
        $this->levelTournamentId->HrefValue = "";
        $this->levelTournamentId->TooltipValue = "";

        // martialArtsId
        $this->martialArtsId->LinkCustomAttributes = "";
        $this->martialArtsId->HrefValue = "";
        $this->martialArtsId->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

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

        // rankBR
        $this->rankBR->setupEditAttributes();
        $this->rankBR->EditCustomAttributes = "";
        if (!$this->rankBR->Raw) {
            $this->rankBR->CurrentValue = HtmlDecode($this->rankBR->CurrentValue);
        }
        $this->rankBR->EditValue = $this->rankBR->CurrentValue;
        $this->rankBR->PlaceHolder = RemoveHtml($this->rankBR->caption());

        // rankUS
        $this->rankUS->setupEditAttributes();
        $this->rankUS->EditCustomAttributes = "";
        if (!$this->rankUS->Raw) {
            $this->rankUS->CurrentValue = HtmlDecode($this->rankUS->CurrentValue);
        }
        $this->rankUS->EditValue = $this->rankUS->CurrentValue;
        $this->rankUS->PlaceHolder = RemoveHtml($this->rankUS->caption());

        // rankES
        $this->rankES->setupEditAttributes();
        $this->rankES->EditCustomAttributes = "";
        if (!$this->rankES->Raw) {
            $this->rankES->CurrentValue = HtmlDecode($this->rankES->CurrentValue);
        }
        $this->rankES->EditValue = $this->rankES->CurrentValue;
        $this->rankES->PlaceHolder = RemoveHtml($this->rankES->caption());

        // ranking
        $this->ranking->setupEditAttributes();
        $this->ranking->EditCustomAttributes = "";
        if (!$this->ranking->Raw) {
            $this->ranking->CurrentValue = HtmlDecode($this->ranking->CurrentValue);
        }
        $this->ranking->EditValue = $this->ranking->CurrentValue;
        $this->ranking->PlaceHolder = RemoveHtml($this->ranking->caption());

        // nextrankId
        $this->nextrankId->setupEditAttributes();
        $this->nextrankId->EditCustomAttributes = "";
        $this->nextrankId->EditValue = $this->nextrankId->CurrentValue;
        $this->nextrankId->PlaceHolder = RemoveHtml($this->nextrankId->caption());

        // levelTournamentId
        $this->levelTournamentId->setupEditAttributes();
        $this->levelTournamentId->EditCustomAttributes = "";
        $this->levelTournamentId->EditValue = $this->levelTournamentId->CurrentValue;
        $this->levelTournamentId->PlaceHolder = RemoveHtml($this->levelTournamentId->caption());
        if (strval($this->levelTournamentId->EditValue) != "" && is_numeric($this->levelTournamentId->EditValue)) {
            $this->levelTournamentId->EditValue = FormatNumber($this->levelTournamentId->EditValue, null);
        }

        // martialArtsId
        $this->martialArtsId->setupEditAttributes();
        $this->martialArtsId->EditCustomAttributes = "";
        if ($this->martialArtsId->getSessionValue() != "") {
            $this->martialArtsId->CurrentValue = GetForeignKeyValue($this->martialArtsId->getSessionValue());
            $this->martialArtsId->ViewValue = $this->martialArtsId->CurrentValue;
            $curVal = strval($this->martialArtsId->CurrentValue);
            if ($curVal != "") {
                $this->martialArtsId->ViewValue = $this->martialArtsId->lookupCacheOption($curVal);
                if ($this->martialArtsId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialArtsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialArtsId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialArtsId->ViewValue = $this->martialArtsId->displayValue($arwrk);
                    } else {
                        $this->martialArtsId->ViewValue = FormatNumber($this->martialArtsId->CurrentValue, $this->martialArtsId->formatPattern());
                    }
                }
            } else {
                $this->martialArtsId->ViewValue = null;
            }
            $this->martialArtsId->ViewCustomAttributes = "";
        } else {
            $this->martialArtsId->EditValue = $this->martialArtsId->CurrentValue;
            $this->martialArtsId->PlaceHolder = RemoveHtml($this->martialArtsId->caption());
        }

        // createUserId

        // createDate
        $this->createDate->setupEditAttributes();
        $this->createDate->EditCustomAttributes = "";
        $this->createDate->EditValue = FormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->createDate->PlaceHolder = RemoveHtml($this->createDate->caption());

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
                    $doc->exportCaption($this->rankBR);
                    $doc->exportCaption($this->rankUS);
                    $doc->exportCaption($this->rankES);
                    $doc->exportCaption($this->ranking);
                    $doc->exportCaption($this->nextrankId);
                    $doc->exportCaption($this->levelTournamentId);
                    $doc->exportCaption($this->martialArtsId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->rankBR);
                    $doc->exportCaption($this->rankUS);
                    $doc->exportCaption($this->rankES);
                    $doc->exportCaption($this->ranking);
                    $doc->exportCaption($this->nextrankId);
                    $doc->exportCaption($this->levelTournamentId);
                    $doc->exportCaption($this->martialArtsId);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
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
                        $doc->exportField($this->rankBR);
                        $doc->exportField($this->rankUS);
                        $doc->exportField($this->rankES);
                        $doc->exportField($this->ranking);
                        $doc->exportField($this->nextrankId);
                        $doc->exportField($this->levelTournamentId);
                        $doc->exportField($this->martialArtsId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->rankBR);
                        $doc->exportField($this->rankUS);
                        $doc->exportField($this->rankES);
                        $doc->exportField($this->ranking);
                        $doc->exportField($this->nextrankId);
                        $doc->exportField($this->levelTournamentId);
                        $doc->exportField($this->martialArtsId);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
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
