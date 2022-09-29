<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for view_certificate_data
 */
class ViewCertificateData extends DbTable
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
    public $testId;
    public $memberId;
    public $name;
    public $lastName;
    public $actual;
    public $next;
    public $memberAge;
    public $memberDOB;
    public $description;
    public $instructorName;
    public $instructorLastName;
    public $auxiliarName;
    public $auxiliarLastName;
    public $testDate;
    public $testTime;
    public $ceremonyDate;
    public $city;
    public $uf;
    public $instructorRanking;
    public $auxiliarRanking;
    public $certificateId;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'view_certificate_data';
        $this->TableName = 'view_certificate_data';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`view_certificate_data`";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // testId
        $this->testId = new DbField(
            'view_certificate_data',
            'view_certificate_data',
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
            'NO'
        );
        $this->testId->InputTextType = "text";
        $this->testId->IsAutoIncrement = true; // Autoincrement field
        $this->testId->IsPrimaryKey = true; // Primary key field
        $this->testId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['testId'] = &$this->testId;

        // memberId
        $this->memberId = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_memberId',
            'memberId',
            '`memberId`',
            '`memberId`',
            3,
            11,
            -1,
            false,
            '`memberId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->memberId->InputTextType = "text";
        $this->memberId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['memberId'] = &$this->memberId;

        // name
        $this->name = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_name',
            'name',
            '`name`',
            '`name`',
            200,
            100,
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
            'view_certificate_data',
            'view_certificate_data',
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

        // actual
        $this->actual = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_actual',
            'actual',
            '`actual`',
            '`actual`',
            200,
            45,
            -1,
            false,
            '`actual`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->actual->InputTextType = "text";
        $this->Fields['actual'] = &$this->actual;

        // next
        $this->next = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_next',
            'next',
            '`next`',
            '`next`',
            200,
            45,
            -1,
            false,
            '`next`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->next->InputTextType = "text";
        $this->Fields['next'] = &$this->next;

        // memberAge
        $this->memberAge = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_memberAge',
            'memberAge',
            '`memberAge`',
            '`memberAge`',
            3,
            11,
            -1,
            false,
            '`memberAge`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->memberAge->InputTextType = "text";
        $this->memberAge->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['memberAge'] = &$this->memberAge;

        // memberDOB
        $this->memberDOB = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_memberDOB',
            'memberDOB',
            '`memberDOB`',
            CastDateFieldForLike("`memberDOB`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`memberDOB`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->memberDOB->InputTextType = "text";
        $this->memberDOB->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['memberDOB'] = &$this->memberDOB;

        // description
        $this->description = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_description',
            'description',
            '`description`',
            '`description`',
            200,
            255,
            -1,
            false,
            '`description`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->description->InputTextType = "text";
        $this->Fields['description'] = &$this->description;

        // instructorName
        $this->instructorName = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_instructorName',
            'instructorName',
            '`instructorName`',
            '`instructorName`',
            200,
            100,
            -1,
            false,
            '`instructorName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorName->InputTextType = "text";
        $this->Fields['instructorName'] = &$this->instructorName;

        // instructorLastName
        $this->instructorLastName = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_instructorLastName',
            'instructorLastName',
            '`instructorLastName`',
            '`instructorLastName`',
            200,
            255,
            -1,
            false,
            '`instructorLastName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorLastName->InputTextType = "text";
        $this->Fields['instructorLastName'] = &$this->instructorLastName;

        // auxiliarName
        $this->auxiliarName = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_auxiliarName',
            'auxiliarName',
            '`auxiliarName`',
            '`auxiliarName`',
            200,
            100,
            -1,
            false,
            '`auxiliarName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->auxiliarName->InputTextType = "text";
        $this->Fields['auxiliarName'] = &$this->auxiliarName;

        // auxiliarLastName
        $this->auxiliarLastName = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_auxiliarLastName',
            'auxiliarLastName',
            '`auxiliarLastName`',
            '`auxiliarLastName`',
            200,
            255,
            -1,
            false,
            '`auxiliarLastName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->auxiliarLastName->InputTextType = "text";
        $this->Fields['auxiliarLastName'] = &$this->auxiliarLastName;

        // testDate
        $this->testDate = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_testDate',
            'testDate',
            '`testDate`',
            CastDateFieldForLike("`testDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`testDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->testDate->InputTextType = "text";
        $this->testDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['testDate'] = &$this->testDate;

        // testTime
        $this->testTime = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_testTime',
            'testTime',
            '`testTime`',
            CastDateFieldForLike("`testTime`", 4, "DB"),
            134,
            10,
            4,
            false,
            '`testTime`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->testTime->InputTextType = "text";
        $this->testTime->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
        $this->Fields['testTime'] = &$this->testTime;

        // ceremonyDate
        $this->ceremonyDate = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_ceremonyDate',
            'ceremonyDate',
            '`ceremonyDate`',
            CastDateFieldForLike("`ceremonyDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`ceremonyDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ceremonyDate->InputTextType = "text";
        $this->ceremonyDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ceremonyDate'] = &$this->ceremonyDate;

        // city
        $this->city = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_city',
            'city',
            '`city`',
            '`city`',
            200,
            45,
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

        // uf
        $this->uf = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_uf',
            'uf',
            '`uf`',
            '`uf`',
            200,
            2,
            -1,
            false,
            '`uf`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->uf->InputTextType = "text";
        $this->Fields['uf'] = &$this->uf;

        // instructorRanking
        $this->instructorRanking = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_instructorRanking',
            'instructorRanking',
            '`instructorRanking`',
            '`instructorRanking`',
            200,
            45,
            -1,
            false,
            '`instructorRanking`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorRanking->InputTextType = "text";
        $this->Fields['instructorRanking'] = &$this->instructorRanking;

        // auxiliarRanking
        $this->auxiliarRanking = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_auxiliarRanking',
            'auxiliarRanking',
            '`auxiliarRanking`',
            '`auxiliarRanking`',
            200,
            45,
            -1,
            false,
            '`auxiliarRanking`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->auxiliarRanking->InputTextType = "text";
        $this->Fields['auxiliarRanking'] = &$this->auxiliarRanking;

        // certificateId
        $this->certificateId = new DbField(
            'view_certificate_data',
            'view_certificate_data',
            'x_certificateId',
            'certificateId',
            '`certificateId`',
            '`certificateId`',
            3,
            11,
            -1,
            false,
            '`certificateId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->certificateId->InputTextType = "text";
        $this->certificateId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['certificateId'] = &$this->certificateId;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`view_certificate_data`";
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
            $this->testId->setDbValue($conn->lastInsertId());
            $rs['testId'] = $this->testId->DbValue;
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
            if (array_key_exists('testId', $rs)) {
                AddFilter($where, QuotedName('testId', $this->Dbid) . '=' . QuotedValue($rs['testId'], $this->testId->DataType, $this->Dbid));
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
        $this->testId->DbValue = $row['testId'];
        $this->memberId->DbValue = $row['memberId'];
        $this->name->DbValue = $row['name'];
        $this->lastName->DbValue = $row['lastName'];
        $this->actual->DbValue = $row['actual'];
        $this->next->DbValue = $row['next'];
        $this->memberAge->DbValue = $row['memberAge'];
        $this->memberDOB->DbValue = $row['memberDOB'];
        $this->description->DbValue = $row['description'];
        $this->instructorName->DbValue = $row['instructorName'];
        $this->instructorLastName->DbValue = $row['instructorLastName'];
        $this->auxiliarName->DbValue = $row['auxiliarName'];
        $this->auxiliarLastName->DbValue = $row['auxiliarLastName'];
        $this->testDate->DbValue = $row['testDate'];
        $this->testTime->DbValue = $row['testTime'];
        $this->ceremonyDate->DbValue = $row['ceremonyDate'];
        $this->city->DbValue = $row['city'];
        $this->uf->DbValue = $row['uf'];
        $this->instructorRanking->DbValue = $row['instructorRanking'];
        $this->auxiliarRanking->DbValue = $row['auxiliarRanking'];
        $this->certificateId->DbValue = $row['certificateId'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`testId` = @testId@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->testId->CurrentValue : $this->testId->OldValue;
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
                $this->testId->CurrentValue = $keys[0];
            } else {
                $this->testId->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('testId', $row) ? $row['testId'] : null;
        } else {
            $val = $this->testId->OldValue !== null ? $this->testId->OldValue : $this->testId->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@testId@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewCertificateDataList");
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
        if ($pageName == "ViewCertificateDataView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ViewCertificateDataEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ViewCertificateDataAdd") {
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
                return "ViewCertificateDataView";
            case Config("API_ADD_ACTION"):
                return "ViewCertificateDataAdd";
            case Config("API_EDIT_ACTION"):
                return "ViewCertificateDataEdit";
            case Config("API_DELETE_ACTION"):
                return "ViewCertificateDataDelete";
            case Config("API_LIST_ACTION"):
                return "ViewCertificateDataList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ViewCertificateDataList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewCertificateDataView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ViewCertificateDataView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewCertificateDataAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ViewCertificateDataAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewCertificateDataEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ViewCertificateDataAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ViewCertificateDataDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"testId\":" . JsonEncode($this->testId->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->testId->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->testId->CurrentValue);
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
            if (($keyValue = Param("testId") ?? Route("testId")) !== null) {
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
                $this->testId->CurrentValue = $key;
            } else {
                $this->testId->OldValue = $key;
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
        $this->testId->setDbValue($row['testId']);
        $this->memberId->setDbValue($row['memberId']);
        $this->name->setDbValue($row['name']);
        $this->lastName->setDbValue($row['lastName']);
        $this->actual->setDbValue($row['actual']);
        $this->next->setDbValue($row['next']);
        $this->memberAge->setDbValue($row['memberAge']);
        $this->memberDOB->setDbValue($row['memberDOB']);
        $this->description->setDbValue($row['description']);
        $this->instructorName->setDbValue($row['instructorName']);
        $this->instructorLastName->setDbValue($row['instructorLastName']);
        $this->auxiliarName->setDbValue($row['auxiliarName']);
        $this->auxiliarLastName->setDbValue($row['auxiliarLastName']);
        $this->testDate->setDbValue($row['testDate']);
        $this->testTime->setDbValue($row['testTime']);
        $this->ceremonyDate->setDbValue($row['ceremonyDate']);
        $this->city->setDbValue($row['city']);
        $this->uf->setDbValue($row['uf']);
        $this->instructorRanking->setDbValue($row['instructorRanking']);
        $this->auxiliarRanking->setDbValue($row['auxiliarRanking']);
        $this->certificateId->setDbValue($row['certificateId']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // testId

        // memberId

        // name

        // lastName

        // actual

        // next

        // memberAge

        // memberDOB

        // description

        // instructorName

        // instructorLastName

        // auxiliarName

        // auxiliarLastName

        // testDate

        // testTime

        // ceremonyDate

        // city

        // uf

        // instructorRanking

        // auxiliarRanking

        // certificateId

        // testId
        $this->testId->ViewValue = $this->testId->CurrentValue;
        $this->testId->ViewCustomAttributes = "";

        // memberId
        $this->memberId->ViewValue = $this->memberId->CurrentValue;
        $this->memberId->ViewValue = FormatNumber($this->memberId->ViewValue, $this->memberId->formatPattern());
        $this->memberId->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // lastName
        $this->lastName->ViewValue = $this->lastName->CurrentValue;
        $this->lastName->ViewCustomAttributes = "";

        // actual
        $this->actual->ViewValue = $this->actual->CurrentValue;
        $this->actual->ViewCustomAttributes = "";

        // next
        $this->next->ViewValue = $this->next->CurrentValue;
        $this->next->ViewCustomAttributes = "";

        // memberAge
        $this->memberAge->ViewValue = $this->memberAge->CurrentValue;
        $this->memberAge->ViewValue = FormatNumber($this->memberAge->ViewValue, $this->memberAge->formatPattern());
        $this->memberAge->ViewCustomAttributes = "";

        // memberDOB
        $this->memberDOB->ViewValue = $this->memberDOB->CurrentValue;
        $this->memberDOB->ViewValue = FormatDateTime($this->memberDOB->ViewValue, $this->memberDOB->formatPattern());
        $this->memberDOB->ViewCustomAttributes = "";

        // description
        $this->description->ViewValue = $this->description->CurrentValue;
        $this->description->ViewCustomAttributes = "";

        // instructorName
        $this->instructorName->ViewValue = $this->instructorName->CurrentValue;
        $this->instructorName->ViewCustomAttributes = "";

        // instructorLastName
        $this->instructorLastName->ViewValue = $this->instructorLastName->CurrentValue;
        $this->instructorLastName->ViewCustomAttributes = "";

        // auxiliarName
        $this->auxiliarName->ViewValue = $this->auxiliarName->CurrentValue;
        $this->auxiliarName->ViewCustomAttributes = "";

        // auxiliarLastName
        $this->auxiliarLastName->ViewValue = $this->auxiliarLastName->CurrentValue;
        $this->auxiliarLastName->ViewCustomAttributes = "";

        // testDate
        $this->testDate->ViewValue = $this->testDate->CurrentValue;
        $this->testDate->ViewValue = FormatDateTime($this->testDate->ViewValue, $this->testDate->formatPattern());
        $this->testDate->ViewCustomAttributes = "";

        // testTime
        $this->testTime->ViewValue = $this->testTime->CurrentValue;
        $this->testTime->ViewValue = FormatDateTime($this->testTime->ViewValue, $this->testTime->formatPattern());
        $this->testTime->ViewCustomAttributes = "";

        // ceremonyDate
        $this->ceremonyDate->ViewValue = $this->ceremonyDate->CurrentValue;
        $this->ceremonyDate->ViewValue = FormatDateTime($this->ceremonyDate->ViewValue, $this->ceremonyDate->formatPattern());
        $this->ceremonyDate->ViewCustomAttributes = "";

        // city
        $this->city->ViewValue = $this->city->CurrentValue;
        $this->city->ViewCustomAttributes = "";

        // uf
        $this->uf->ViewValue = $this->uf->CurrentValue;
        $this->uf->ViewCustomAttributes = "";

        // instructorRanking
        $this->instructorRanking->ViewValue = $this->instructorRanking->CurrentValue;
        $this->instructorRanking->ViewCustomAttributes = "";

        // auxiliarRanking
        $this->auxiliarRanking->ViewValue = $this->auxiliarRanking->CurrentValue;
        $this->auxiliarRanking->ViewCustomAttributes = "";

        // certificateId
        $this->certificateId->ViewValue = $this->certificateId->CurrentValue;
        $this->certificateId->ViewValue = FormatNumber($this->certificateId->ViewValue, $this->certificateId->formatPattern());
        $this->certificateId->ViewCustomAttributes = "";

        // testId
        $this->testId->LinkCustomAttributes = "";
        $this->testId->HrefValue = "";
        $this->testId->TooltipValue = "";

        // memberId
        $this->memberId->LinkCustomAttributes = "";
        $this->memberId->HrefValue = "";
        $this->memberId->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // lastName
        $this->lastName->LinkCustomAttributes = "";
        $this->lastName->HrefValue = "";
        $this->lastName->TooltipValue = "";

        // actual
        $this->actual->LinkCustomAttributes = "";
        $this->actual->HrefValue = "";
        $this->actual->TooltipValue = "";

        // next
        $this->next->LinkCustomAttributes = "";
        $this->next->HrefValue = "";
        $this->next->TooltipValue = "";

        // memberAge
        $this->memberAge->LinkCustomAttributes = "";
        $this->memberAge->HrefValue = "";
        $this->memberAge->TooltipValue = "";

        // memberDOB
        $this->memberDOB->LinkCustomAttributes = "";
        $this->memberDOB->HrefValue = "";
        $this->memberDOB->TooltipValue = "";

        // description
        $this->description->LinkCustomAttributes = "";
        $this->description->HrefValue = "";
        $this->description->TooltipValue = "";

        // instructorName
        $this->instructorName->LinkCustomAttributes = "";
        $this->instructorName->HrefValue = "";
        $this->instructorName->TooltipValue = "";

        // instructorLastName
        $this->instructorLastName->LinkCustomAttributes = "";
        $this->instructorLastName->HrefValue = "";
        $this->instructorLastName->TooltipValue = "";

        // auxiliarName
        $this->auxiliarName->LinkCustomAttributes = "";
        $this->auxiliarName->HrefValue = "";
        $this->auxiliarName->TooltipValue = "";

        // auxiliarLastName
        $this->auxiliarLastName->LinkCustomAttributes = "";
        $this->auxiliarLastName->HrefValue = "";
        $this->auxiliarLastName->TooltipValue = "";

        // testDate
        $this->testDate->LinkCustomAttributes = "";
        $this->testDate->HrefValue = "";
        $this->testDate->TooltipValue = "";

        // testTime
        $this->testTime->LinkCustomAttributes = "";
        $this->testTime->HrefValue = "";
        $this->testTime->TooltipValue = "";

        // ceremonyDate
        $this->ceremonyDate->LinkCustomAttributes = "";
        $this->ceremonyDate->HrefValue = "";
        $this->ceremonyDate->TooltipValue = "";

        // city
        $this->city->LinkCustomAttributes = "";
        $this->city->HrefValue = "";
        $this->city->TooltipValue = "";

        // uf
        $this->uf->LinkCustomAttributes = "";
        $this->uf->HrefValue = "";
        $this->uf->TooltipValue = "";

        // instructorRanking
        $this->instructorRanking->LinkCustomAttributes = "";
        $this->instructorRanking->HrefValue = "";
        $this->instructorRanking->TooltipValue = "";

        // auxiliarRanking
        $this->auxiliarRanking->LinkCustomAttributes = "";
        $this->auxiliarRanking->HrefValue = "";
        $this->auxiliarRanking->TooltipValue = "";

        // certificateId
        $this->certificateId->LinkCustomAttributes = "";
        $this->certificateId->HrefValue = "";
        $this->certificateId->TooltipValue = "";

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

        // testId
        $this->testId->setupEditAttributes();
        $this->testId->EditCustomAttributes = "";
        $this->testId->EditValue = $this->testId->CurrentValue;
        $this->testId->ViewCustomAttributes = "";

        // memberId
        $this->memberId->setupEditAttributes();
        $this->memberId->EditCustomAttributes = "";
        $this->memberId->EditValue = $this->memberId->CurrentValue;
        $this->memberId->PlaceHolder = RemoveHtml($this->memberId->caption());
        if (strval($this->memberId->EditValue) != "" && is_numeric($this->memberId->EditValue)) {
            $this->memberId->EditValue = FormatNumber($this->memberId->EditValue, null);
        }

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

        // actual
        $this->actual->setupEditAttributes();
        $this->actual->EditCustomAttributes = "";
        if (!$this->actual->Raw) {
            $this->actual->CurrentValue = HtmlDecode($this->actual->CurrentValue);
        }
        $this->actual->EditValue = $this->actual->CurrentValue;
        $this->actual->PlaceHolder = RemoveHtml($this->actual->caption());

        // next
        $this->next->setupEditAttributes();
        $this->next->EditCustomAttributes = "";
        if (!$this->next->Raw) {
            $this->next->CurrentValue = HtmlDecode($this->next->CurrentValue);
        }
        $this->next->EditValue = $this->next->CurrentValue;
        $this->next->PlaceHolder = RemoveHtml($this->next->caption());

        // memberAge
        $this->memberAge->setupEditAttributes();
        $this->memberAge->EditCustomAttributes = "";
        $this->memberAge->EditValue = $this->memberAge->CurrentValue;
        $this->memberAge->PlaceHolder = RemoveHtml($this->memberAge->caption());
        if (strval($this->memberAge->EditValue) != "" && is_numeric($this->memberAge->EditValue)) {
            $this->memberAge->EditValue = FormatNumber($this->memberAge->EditValue, null);
        }

        // memberDOB
        $this->memberDOB->setupEditAttributes();
        $this->memberDOB->EditCustomAttributes = "";
        $this->memberDOB->EditValue = FormatDateTime($this->memberDOB->CurrentValue, $this->memberDOB->formatPattern());
        $this->memberDOB->PlaceHolder = RemoveHtml($this->memberDOB->caption());

        // description
        $this->description->setupEditAttributes();
        $this->description->EditCustomAttributes = "";
        if (!$this->description->Raw) {
            $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
        }
        $this->description->EditValue = $this->description->CurrentValue;
        $this->description->PlaceHolder = RemoveHtml($this->description->caption());

        // instructorName
        $this->instructorName->setupEditAttributes();
        $this->instructorName->EditCustomAttributes = "";
        if (!$this->instructorName->Raw) {
            $this->instructorName->CurrentValue = HtmlDecode($this->instructorName->CurrentValue);
        }
        $this->instructorName->EditValue = $this->instructorName->CurrentValue;
        $this->instructorName->PlaceHolder = RemoveHtml($this->instructorName->caption());

        // instructorLastName
        $this->instructorLastName->setupEditAttributes();
        $this->instructorLastName->EditCustomAttributes = "";
        if (!$this->instructorLastName->Raw) {
            $this->instructorLastName->CurrentValue = HtmlDecode($this->instructorLastName->CurrentValue);
        }
        $this->instructorLastName->EditValue = $this->instructorLastName->CurrentValue;
        $this->instructorLastName->PlaceHolder = RemoveHtml($this->instructorLastName->caption());

        // auxiliarName
        $this->auxiliarName->setupEditAttributes();
        $this->auxiliarName->EditCustomAttributes = "";
        if (!$this->auxiliarName->Raw) {
            $this->auxiliarName->CurrentValue = HtmlDecode($this->auxiliarName->CurrentValue);
        }
        $this->auxiliarName->EditValue = $this->auxiliarName->CurrentValue;
        $this->auxiliarName->PlaceHolder = RemoveHtml($this->auxiliarName->caption());

        // auxiliarLastName
        $this->auxiliarLastName->setupEditAttributes();
        $this->auxiliarLastName->EditCustomAttributes = "";
        if (!$this->auxiliarLastName->Raw) {
            $this->auxiliarLastName->CurrentValue = HtmlDecode($this->auxiliarLastName->CurrentValue);
        }
        $this->auxiliarLastName->EditValue = $this->auxiliarLastName->CurrentValue;
        $this->auxiliarLastName->PlaceHolder = RemoveHtml($this->auxiliarLastName->caption());

        // testDate
        $this->testDate->setupEditAttributes();
        $this->testDate->EditCustomAttributes = "";
        $this->testDate->EditValue = FormatDateTime($this->testDate->CurrentValue, $this->testDate->formatPattern());
        $this->testDate->PlaceHolder = RemoveHtml($this->testDate->caption());

        // testTime
        $this->testTime->setupEditAttributes();
        $this->testTime->EditCustomAttributes = "";
        $this->testTime->EditValue = FormatDateTime($this->testTime->CurrentValue, $this->testTime->formatPattern());
        $this->testTime->PlaceHolder = RemoveHtml($this->testTime->caption());

        // ceremonyDate
        $this->ceremonyDate->setupEditAttributes();
        $this->ceremonyDate->EditCustomAttributes = "";
        $this->ceremonyDate->EditValue = FormatDateTime($this->ceremonyDate->CurrentValue, $this->ceremonyDate->formatPattern());
        $this->ceremonyDate->PlaceHolder = RemoveHtml($this->ceremonyDate->caption());

        // city
        $this->city->setupEditAttributes();
        $this->city->EditCustomAttributes = "";
        if (!$this->city->Raw) {
            $this->city->CurrentValue = HtmlDecode($this->city->CurrentValue);
        }
        $this->city->EditValue = $this->city->CurrentValue;
        $this->city->PlaceHolder = RemoveHtml($this->city->caption());

        // uf
        $this->uf->setupEditAttributes();
        $this->uf->EditCustomAttributes = "";
        if (!$this->uf->Raw) {
            $this->uf->CurrentValue = HtmlDecode($this->uf->CurrentValue);
        }
        $this->uf->EditValue = $this->uf->CurrentValue;
        $this->uf->PlaceHolder = RemoveHtml($this->uf->caption());

        // instructorRanking
        $this->instructorRanking->setupEditAttributes();
        $this->instructorRanking->EditCustomAttributes = "";
        if (!$this->instructorRanking->Raw) {
            $this->instructorRanking->CurrentValue = HtmlDecode($this->instructorRanking->CurrentValue);
        }
        $this->instructorRanking->EditValue = $this->instructorRanking->CurrentValue;
        $this->instructorRanking->PlaceHolder = RemoveHtml($this->instructorRanking->caption());

        // auxiliarRanking
        $this->auxiliarRanking->setupEditAttributes();
        $this->auxiliarRanking->EditCustomAttributes = "";
        if (!$this->auxiliarRanking->Raw) {
            $this->auxiliarRanking->CurrentValue = HtmlDecode($this->auxiliarRanking->CurrentValue);
        }
        $this->auxiliarRanking->EditValue = $this->auxiliarRanking->CurrentValue;
        $this->auxiliarRanking->PlaceHolder = RemoveHtml($this->auxiliarRanking->caption());

        // certificateId
        $this->certificateId->setupEditAttributes();
        $this->certificateId->EditCustomAttributes = "";
        $this->certificateId->EditValue = $this->certificateId->CurrentValue;
        $this->certificateId->PlaceHolder = RemoveHtml($this->certificateId->caption());
        if (strval($this->certificateId->EditValue) != "" && is_numeric($this->certificateId->EditValue)) {
            $this->certificateId->EditValue = FormatNumber($this->certificateId->EditValue, null);
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
                    $doc->exportCaption($this->testId);
                    $doc->exportCaption($this->memberId);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->lastName);
                    $doc->exportCaption($this->actual);
                    $doc->exportCaption($this->next);
                    $doc->exportCaption($this->memberAge);
                    $doc->exportCaption($this->memberDOB);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->instructorName);
                    $doc->exportCaption($this->instructorLastName);
                    $doc->exportCaption($this->auxiliarName);
                    $doc->exportCaption($this->auxiliarLastName);
                    $doc->exportCaption($this->testDate);
                    $doc->exportCaption($this->testTime);
                    $doc->exportCaption($this->ceremonyDate);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->instructorRanking);
                    $doc->exportCaption($this->auxiliarRanking);
                    $doc->exportCaption($this->certificateId);
                } else {
                    $doc->exportCaption($this->testId);
                    $doc->exportCaption($this->memberId);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->lastName);
                    $doc->exportCaption($this->actual);
                    $doc->exportCaption($this->next);
                    $doc->exportCaption($this->memberAge);
                    $doc->exportCaption($this->memberDOB);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->instructorName);
                    $doc->exportCaption($this->instructorLastName);
                    $doc->exportCaption($this->auxiliarName);
                    $doc->exportCaption($this->auxiliarLastName);
                    $doc->exportCaption($this->testDate);
                    $doc->exportCaption($this->testTime);
                    $doc->exportCaption($this->ceremonyDate);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->uf);
                    $doc->exportCaption($this->instructorRanking);
                    $doc->exportCaption($this->auxiliarRanking);
                    $doc->exportCaption($this->certificateId);
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
                        $doc->exportField($this->testId);
                        $doc->exportField($this->memberId);
                        $doc->exportField($this->name);
                        $doc->exportField($this->lastName);
                        $doc->exportField($this->actual);
                        $doc->exportField($this->next);
                        $doc->exportField($this->memberAge);
                        $doc->exportField($this->memberDOB);
                        $doc->exportField($this->description);
                        $doc->exportField($this->instructorName);
                        $doc->exportField($this->instructorLastName);
                        $doc->exportField($this->auxiliarName);
                        $doc->exportField($this->auxiliarLastName);
                        $doc->exportField($this->testDate);
                        $doc->exportField($this->testTime);
                        $doc->exportField($this->ceremonyDate);
                        $doc->exportField($this->city);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->instructorRanking);
                        $doc->exportField($this->auxiliarRanking);
                        $doc->exportField($this->certificateId);
                    } else {
                        $doc->exportField($this->testId);
                        $doc->exportField($this->memberId);
                        $doc->exportField($this->name);
                        $doc->exportField($this->lastName);
                        $doc->exportField($this->actual);
                        $doc->exportField($this->next);
                        $doc->exportField($this->memberAge);
                        $doc->exportField($this->memberDOB);
                        $doc->exportField($this->description);
                        $doc->exportField($this->instructorName);
                        $doc->exportField($this->instructorLastName);
                        $doc->exportField($this->auxiliarName);
                        $doc->exportField($this->auxiliarLastName);
                        $doc->exportField($this->testDate);
                        $doc->exportField($this->testTime);
                        $doc->exportField($this->ceremonyDate);
                        $doc->exportField($this->city);
                        $doc->exportField($this->uf);
                        $doc->exportField($this->instructorRanking);
                        $doc->exportField($this->auxiliarRanking);
                        $doc->exportField($this->certificateId);
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
