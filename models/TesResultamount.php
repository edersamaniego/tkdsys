<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for tes_resultamount
 */
class TesResultamount extends DbTable
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
    public $federationId;
    public $schoolId;
    public $testId;
    public $sendingDate;
    public $paymentDate;
    public $printingDate;
    public $shippedDate;
    public $status;
    public $createUserId;
    public $createDate;
    public $totalAmount;
    public $paymentId;
    public $totalValue;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'tes_resultamount';
        $this->TableName = 'tes_resultamount';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`tes_resultamount`";
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
            'tes_resultamount',
            'tes_resultamount',
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

        // federationId
        $this->federationId = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_federationId',
            'federationId',
            '`federationId`',
            '`federationId`',
            3,
            11,
            -1,
            false,
            '`federationId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->federationId->InputTextType = "text";
        $this->federationId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['federationId'] = &$this->federationId;

        // schoolId
        $this->schoolId = new DbField(
            'tes_resultamount',
            'tes_resultamount',
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
        $this->schoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolId'] = &$this->schoolId;

        // testId
        $this->testId = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_testId',
            'testId',
            '`testId`',
            '`testId`',
            3,
            11,
            -1,
            false,
            '`testId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->testId->InputTextType = "text";
        $this->testId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['testId'] = &$this->testId;

        // sendingDate
        $this->sendingDate = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_sendingDate',
            'sendingDate',
            '`sendingDate`',
            CastDateFieldForLike("`sendingDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`sendingDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->sendingDate->InputTextType = "text";
        $this->sendingDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['sendingDate'] = &$this->sendingDate;

        // paymentDate
        $this->paymentDate = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_paymentDate',
            'paymentDate',
            '`paymentDate`',
            CastDateFieldForLike("`paymentDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`paymentDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentDate->InputTextType = "text";
        $this->paymentDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['paymentDate'] = &$this->paymentDate;

        // printingDate
        $this->printingDate = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_printingDate',
            'printingDate',
            '`printingDate`',
            CastDateFieldForLike("`printingDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`printingDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->printingDate->InputTextType = "text";
        $this->printingDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['printingDate'] = &$this->printingDate;

        // shippedDate
        $this->shippedDate = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_shippedDate',
            'shippedDate',
            '`shippedDate`',
            CastDateFieldForLike("`shippedDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`shippedDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->shippedDate->InputTextType = "text";
        $this->shippedDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['shippedDate'] = &$this->shippedDate;

        // status
        $this->status = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_status',
            'status',
            '`status`',
            '`status`',
            3,
            11,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status->InputTextType = "text";
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // createUserId
        $this->createUserId = new DbField(
            'tes_resultamount',
            'tes_resultamount',
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
            'tes_resultamount',
            'tes_resultamount',
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

        // totalAmount
        $this->totalAmount = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_totalAmount',
            'totalAmount',
            '`totalAmount`',
            '`totalAmount`',
            3,
            11,
            -1,
            false,
            '`totalAmount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->totalAmount->InputTextType = "text";
        $this->totalAmount->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['totalAmount'] = &$this->totalAmount;

        // paymentId
        $this->paymentId = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_paymentId',
            'paymentId',
            '`paymentId`',
            '`paymentId`',
            3,
            11,
            -1,
            false,
            '`paymentId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->paymentId->InputTextType = "text";
        $this->paymentId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['paymentId'] = &$this->paymentId;

        // totalValue
        $this->totalValue = new DbField(
            'tes_resultamount',
            'tes_resultamount',
            'x_totalValue',
            'totalValue',
            '`totalValue`',
            '`totalValue`',
            131,
            10,
            -1,
            false,
            '`totalValue`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->totalValue->InputTextType = "text";
        $this->totalValue->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['totalValue'] = &$this->totalValue;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`tes_resultamount`";
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
        $this->federationId->DbValue = $row['federationId'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->testId->DbValue = $row['testId'];
        $this->sendingDate->DbValue = $row['sendingDate'];
        $this->paymentDate->DbValue = $row['paymentDate'];
        $this->printingDate->DbValue = $row['printingDate'];
        $this->shippedDate->DbValue = $row['shippedDate'];
        $this->status->DbValue = $row['status'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->createDate->DbValue = $row['createDate'];
        $this->totalAmount->DbValue = $row['totalAmount'];
        $this->paymentId->DbValue = $row['paymentId'];
        $this->totalValue->DbValue = $row['totalValue'];
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
        return $_SESSION[$name] ?? GetUrl("TesResultamountList");
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
        if ($pageName == "TesResultamountView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TesResultamountEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TesResultamountAdd") {
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
                return "TesResultamountView";
            case Config("API_ADD_ACTION"):
                return "TesResultamountAdd";
            case Config("API_EDIT_ACTION"):
                return "TesResultamountEdit";
            case Config("API_DELETE_ACTION"):
                return "TesResultamountDelete";
            case Config("API_LIST_ACTION"):
                return "TesResultamountList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TesResultamountList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TesResultamountView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TesResultamountView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TesResultamountAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TesResultamountAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("TesResultamountEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("TesResultamountAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("TesResultamountDelete", $this->getUrlParm());
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
        $this->federationId->setDbValue($row['federationId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->testId->setDbValue($row['testId']);
        $this->sendingDate->setDbValue($row['sendingDate']);
        $this->paymentDate->setDbValue($row['paymentDate']);
        $this->printingDate->setDbValue($row['printingDate']);
        $this->shippedDate->setDbValue($row['shippedDate']);
        $this->status->setDbValue($row['status']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->totalAmount->setDbValue($row['totalAmount']);
        $this->paymentId->setDbValue($row['paymentId']);
        $this->totalValue->setDbValue($row['totalValue']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // federationId

        // schoolId

        // testId

        // sendingDate

        // paymentDate

        // printingDate

        // shippedDate

        // status

        // createUserId

        // createDate

        // totalAmount

        // paymentId

        // totalValue

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // federationId
        $this->federationId->ViewValue = $this->federationId->CurrentValue;
        $this->federationId->ViewValue = FormatNumber($this->federationId->ViewValue, $this->federationId->formatPattern());
        $this->federationId->ViewCustomAttributes = "";

        // schoolId
        $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
        $this->schoolId->ViewValue = FormatNumber($this->schoolId->ViewValue, $this->schoolId->formatPattern());
        $this->schoolId->ViewCustomAttributes = "";

        // testId
        $this->testId->ViewValue = $this->testId->CurrentValue;
        $this->testId->ViewValue = FormatNumber($this->testId->ViewValue, $this->testId->formatPattern());
        $this->testId->ViewCustomAttributes = "";

        // sendingDate
        $this->sendingDate->ViewValue = $this->sendingDate->CurrentValue;
        $this->sendingDate->ViewValue = FormatDateTime($this->sendingDate->ViewValue, $this->sendingDate->formatPattern());
        $this->sendingDate->ViewCustomAttributes = "";

        // paymentDate
        $this->paymentDate->ViewValue = $this->paymentDate->CurrentValue;
        $this->paymentDate->ViewValue = FormatDateTime($this->paymentDate->ViewValue, $this->paymentDate->formatPattern());
        $this->paymentDate->ViewCustomAttributes = "";

        // printingDate
        $this->printingDate->ViewValue = $this->printingDate->CurrentValue;
        $this->printingDate->ViewValue = FormatDateTime($this->printingDate->ViewValue, $this->printingDate->formatPattern());
        $this->printingDate->ViewCustomAttributes = "";

        // shippedDate
        $this->shippedDate->ViewValue = $this->shippedDate->CurrentValue;
        $this->shippedDate->ViewValue = FormatDateTime($this->shippedDate->ViewValue, $this->shippedDate->formatPattern());
        $this->shippedDate->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewValue = FormatNumber($this->status->ViewValue, $this->status->formatPattern());
        $this->status->ViewCustomAttributes = "";

        // createUserId
        $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
        $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
        $this->createUserId->ViewCustomAttributes = "";

        // createDate
        $this->createDate->ViewValue = $this->createDate->CurrentValue;
        $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
        $this->createDate->ViewCustomAttributes = "";

        // totalAmount
        $this->totalAmount->ViewValue = $this->totalAmount->CurrentValue;
        $this->totalAmount->ViewValue = FormatNumber($this->totalAmount->ViewValue, $this->totalAmount->formatPattern());
        $this->totalAmount->ViewCustomAttributes = "";

        // paymentId
        $this->paymentId->ViewValue = $this->paymentId->CurrentValue;
        $this->paymentId->ViewValue = FormatNumber($this->paymentId->ViewValue, $this->paymentId->formatPattern());
        $this->paymentId->ViewCustomAttributes = "";

        // totalValue
        $this->totalValue->ViewValue = $this->totalValue->CurrentValue;
        $this->totalValue->ViewValue = FormatNumber($this->totalValue->ViewValue, $this->totalValue->formatPattern());
        $this->totalValue->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // federationId
        $this->federationId->LinkCustomAttributes = "";
        $this->federationId->HrefValue = "";
        $this->federationId->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // testId
        $this->testId->LinkCustomAttributes = "";
        $this->testId->HrefValue = "";
        $this->testId->TooltipValue = "";

        // sendingDate
        $this->sendingDate->LinkCustomAttributes = "";
        $this->sendingDate->HrefValue = "";
        $this->sendingDate->TooltipValue = "";

        // paymentDate
        $this->paymentDate->LinkCustomAttributes = "";
        $this->paymentDate->HrefValue = "";
        $this->paymentDate->TooltipValue = "";

        // printingDate
        $this->printingDate->LinkCustomAttributes = "";
        $this->printingDate->HrefValue = "";
        $this->printingDate->TooltipValue = "";

        // shippedDate
        $this->shippedDate->LinkCustomAttributes = "";
        $this->shippedDate->HrefValue = "";
        $this->shippedDate->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

        // totalAmount
        $this->totalAmount->LinkCustomAttributes = "";
        $this->totalAmount->HrefValue = "";
        $this->totalAmount->TooltipValue = "";

        // paymentId
        $this->paymentId->LinkCustomAttributes = "";
        $this->paymentId->HrefValue = "";
        $this->paymentId->TooltipValue = "";

        // totalValue
        $this->totalValue->LinkCustomAttributes = "";
        $this->totalValue->HrefValue = "";
        $this->totalValue->TooltipValue = "";

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

        // federationId
        $this->federationId->setupEditAttributes();
        $this->federationId->EditCustomAttributes = "";
        $this->federationId->EditValue = $this->federationId->CurrentValue;
        $this->federationId->PlaceHolder = RemoveHtml($this->federationId->caption());
        if (strval($this->federationId->EditValue) != "" && is_numeric($this->federationId->EditValue)) {
            $this->federationId->EditValue = FormatNumber($this->federationId->EditValue, null);
        }

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->EditValue = $this->schoolId->CurrentValue;
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
            if (strval($this->schoolId->EditValue) != "" && is_numeric($this->schoolId->EditValue)) {
                $this->schoolId->EditValue = FormatNumber($this->schoolId->EditValue, null);
            }
        }

        // testId
        $this->testId->setupEditAttributes();
        $this->testId->EditCustomAttributes = "";
        $this->testId->EditValue = $this->testId->CurrentValue;
        $this->testId->PlaceHolder = RemoveHtml($this->testId->caption());
        if (strval($this->testId->EditValue) != "" && is_numeric($this->testId->EditValue)) {
            $this->testId->EditValue = FormatNumber($this->testId->EditValue, null);
        }

        // sendingDate
        $this->sendingDate->setupEditAttributes();
        $this->sendingDate->EditCustomAttributes = "";
        $this->sendingDate->EditValue = FormatDateTime($this->sendingDate->CurrentValue, $this->sendingDate->formatPattern());
        $this->sendingDate->PlaceHolder = RemoveHtml($this->sendingDate->caption());

        // paymentDate
        $this->paymentDate->setupEditAttributes();
        $this->paymentDate->EditCustomAttributes = "";
        $this->paymentDate->EditValue = FormatDateTime($this->paymentDate->CurrentValue, $this->paymentDate->formatPattern());
        $this->paymentDate->PlaceHolder = RemoveHtml($this->paymentDate->caption());

        // printingDate
        $this->printingDate->setupEditAttributes();
        $this->printingDate->EditCustomAttributes = "";
        $this->printingDate->EditValue = FormatDateTime($this->printingDate->CurrentValue, $this->printingDate->formatPattern());
        $this->printingDate->PlaceHolder = RemoveHtml($this->printingDate->caption());

        // shippedDate
        $this->shippedDate->setupEditAttributes();
        $this->shippedDate->EditCustomAttributes = "";
        $this->shippedDate->EditValue = FormatDateTime($this->shippedDate->CurrentValue, $this->shippedDate->formatPattern());
        $this->shippedDate->PlaceHolder = RemoveHtml($this->shippedDate->caption());

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());
        if (strval($this->status->EditValue) != "" && is_numeric($this->status->EditValue)) {
            $this->status->EditValue = FormatNumber($this->status->EditValue, null);
        }

        // createUserId
        $this->createUserId->setupEditAttributes();
        $this->createUserId->EditCustomAttributes = "";
        $this->createUserId->EditValue = $this->createUserId->CurrentValue;
        $this->createUserId->PlaceHolder = RemoveHtml($this->createUserId->caption());
        if (strval($this->createUserId->EditValue) != "" && is_numeric($this->createUserId->EditValue)) {
            $this->createUserId->EditValue = FormatNumber($this->createUserId->EditValue, null);
        }

        // createDate
        $this->createDate->setupEditAttributes();
        $this->createDate->EditCustomAttributes = "";
        $this->createDate->EditValue = FormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->createDate->PlaceHolder = RemoveHtml($this->createDate->caption());

        // totalAmount
        $this->totalAmount->setupEditAttributes();
        $this->totalAmount->EditCustomAttributes = "";
        $this->totalAmount->EditValue = $this->totalAmount->CurrentValue;
        $this->totalAmount->PlaceHolder = RemoveHtml($this->totalAmount->caption());
        if (strval($this->totalAmount->EditValue) != "" && is_numeric($this->totalAmount->EditValue)) {
            $this->totalAmount->EditValue = FormatNumber($this->totalAmount->EditValue, null);
        }

        // paymentId
        $this->paymentId->setupEditAttributes();
        $this->paymentId->EditCustomAttributes = "";
        $this->paymentId->EditValue = $this->paymentId->CurrentValue;
        $this->paymentId->PlaceHolder = RemoveHtml($this->paymentId->caption());
        if (strval($this->paymentId->EditValue) != "" && is_numeric($this->paymentId->EditValue)) {
            $this->paymentId->EditValue = FormatNumber($this->paymentId->EditValue, null);
        }

        // totalValue
        $this->totalValue->setupEditAttributes();
        $this->totalValue->EditCustomAttributes = "";
        $this->totalValue->EditValue = $this->totalValue->CurrentValue;
        $this->totalValue->PlaceHolder = RemoveHtml($this->totalValue->caption());
        if (strval($this->totalValue->EditValue) != "" && is_numeric($this->totalValue->EditValue)) {
            $this->totalValue->EditValue = FormatNumber($this->totalValue->EditValue, null);
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
                    $doc->exportCaption($this->federationId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->testId);
                    $doc->exportCaption($this->sendingDate);
                    $doc->exportCaption($this->paymentDate);
                    $doc->exportCaption($this->printingDate);
                    $doc->exportCaption($this->shippedDate);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->totalAmount);
                    $doc->exportCaption($this->paymentId);
                    $doc->exportCaption($this->totalValue);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->federationId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->testId);
                    $doc->exportCaption($this->sendingDate);
                    $doc->exportCaption($this->paymentDate);
                    $doc->exportCaption($this->printingDate);
                    $doc->exportCaption($this->shippedDate);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->totalAmount);
                    $doc->exportCaption($this->paymentId);
                    $doc->exportCaption($this->totalValue);
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
                        $doc->exportField($this->federationId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->testId);
                        $doc->exportField($this->sendingDate);
                        $doc->exportField($this->paymentDate);
                        $doc->exportField($this->printingDate);
                        $doc->exportField($this->shippedDate);
                        $doc->exportField($this->status);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->totalAmount);
                        $doc->exportField($this->paymentId);
                        $doc->exportField($this->totalValue);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->federationId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->testId);
                        $doc->exportField($this->sendingDate);
                        $doc->exportField($this->paymentDate);
                        $doc->exportField($this->printingDate);
                        $doc->exportField($this->shippedDate);
                        $doc->exportField($this->status);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->totalAmount);
                        $doc->exportField($this->paymentId);
                        $doc->exportField($this->totalValue);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `tes_resultamount`";
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
