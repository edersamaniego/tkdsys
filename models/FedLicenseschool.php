<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fed_licenseschool
 */
class FedLicenseschool extends DbTable
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
    public $application;
    public $dateLicense;
    public $dateStart;
    public $dateFinish;
    public $schooltype;
    public $value;
    public $installment;
    public $masterSchool;
    public $school;
    public $_userId;
    public $registerDate;
    public $status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fed_licenseschool';
        $this->TableName = 'fed_licenseschool';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fed_licenseschool`";
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
            'fed_licenseschool',
            'fed_licenseschool',
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

        // application
        $this->application = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_application',
            'application',
            '`application`',
            '`application`',
            3,
            11,
            -1,
            false,
            '`application`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->application->InputTextType = "text";
        $this->application->IsForeignKey = true; // Foreign key field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->application->Lookup = new Lookup('application', 'fed_applicationschool', false, 'id', ["id","school","cityId","UFId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->application) . "',COALESCE(`school`,''),'" . ValueSeparator(2, $this->application) . "',COALESCE(`cityId`,''),'" . ValueSeparator(3, $this->application) . "',COALESCE(`UFId`,''))");
                break;
            case "pt-BR":
                $this->application->Lookup = new Lookup('application', 'fed_applicationschool', false, 'id', ["id","school","cityId","UFId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->application) . "',COALESCE(`school`,''),'" . ValueSeparator(2, $this->application) . "',COALESCE(`cityId`,''),'" . ValueSeparator(3, $this->application) . "',COALESCE(`UFId`,''))");
                break;
            case "es":
                $this->application->Lookup = new Lookup('application', 'fed_applicationschool', false, 'id', ["id","school","cityId","UFId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->application) . "',COALESCE(`school`,''),'" . ValueSeparator(2, $this->application) . "',COALESCE(`cityId`,''),'" . ValueSeparator(3, $this->application) . "',COALESCE(`UFId`,''))");
                break;
            default:
                $this->application->Lookup = new Lookup('application', 'fed_applicationschool', false, 'id', ["id","school","cityId","UFId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->application) . "',COALESCE(`school`,''),'" . ValueSeparator(2, $this->application) . "',COALESCE(`cityId`,''),'" . ValueSeparator(3, $this->application) . "',COALESCE(`UFId`,''))");
                break;
        }
        $this->application->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['application'] = &$this->application;

        // dateLicense
        $this->dateLicense = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_dateLicense',
            'dateLicense',
            '`dateLicense`',
            CastDateFieldForLike("`dateLicense`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateLicense`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateLicense->InputTextType = "text";
        $this->dateLicense->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateLicense'] = &$this->dateLicense;

        // dateStart
        $this->dateStart = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_dateStart',
            'dateStart',
            '`dateStart`',
            CastDateFieldForLike("`dateStart`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateStart`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateStart->InputTextType = "text";
        $this->dateStart->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateStart'] = &$this->dateStart;

        // dateFinish
        $this->dateFinish = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_dateFinish',
            'dateFinish',
            '`dateFinish`',
            CastDateFieldForLike("`dateFinish`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateFinish`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateFinish->InputTextType = "text";
        $this->dateFinish->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateFinish'] = &$this->dateFinish;

        // schooltype
        $this->schooltype = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_schooltype',
            'schooltype',
            '`schooltype`',
            '`schooltype`',
            3,
            11,
            -1,
            false,
            '`schooltype`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->schooltype->InputTextType = "text";
        $this->schooltype->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->schooltype->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schooltype->Lookup = new Lookup('schooltype', 'conf_schooltype', false, 'id', ["typeEn","","",""], [], ["fed_licenseschool x_value"], [], [], ["licensevalue"], ["x_value"], '', '', "`typeEn`");
                break;
            case "pt-BR":
                $this->schooltype->Lookup = new Lookup('schooltype', 'conf_schooltype', false, 'id', ["typeBr","","",""], [], ["fed_licenseschool x_value"], [], [], ["licensevalue"], ["x_value"], '', '', "`typeBr`");
                break;
            case "es":
                $this->schooltype->Lookup = new Lookup('schooltype', 'conf_schooltype', false, 'id', ["typeEs","","",""], [], ["fed_licenseschool x_value"], [], [], ["licensevalue"], ["x_value"], '', '', "`typeEs`");
                break;
            default:
                $this->schooltype->Lookup = new Lookup('schooltype', 'conf_schooltype', false, 'id', ["typeBr","","",""], [], ["fed_licenseschool x_value"], [], [], ["licensevalue"], ["x_value"], '', '', "`typeBr`");
                break;
        }
        $this->schooltype->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schooltype'] = &$this->schooltype;

        // value
        $this->value = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
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
        switch ($CurrentLanguage) {
            case "en-US":
                $this->value->Lookup = new Lookup('value', 'conf_schooltype', false, 'id', ["licensevalue","","",""], ["x_schooltype"], [], ["id"], ["x_id"], [], [], '', '', "`licensevalue`");
                break;
            case "pt-BR":
                $this->value->Lookup = new Lookup('value', 'conf_schooltype', false, 'id', ["licensevalue","","",""], ["x_schooltype"], [], ["id"], ["x_id"], [], [], '', '', "`licensevalue`");
                break;
            case "es":
                $this->value->Lookup = new Lookup('value', 'conf_schooltype', false, 'id', ["licensevalue","","",""], ["x_schooltype"], [], ["id"], ["x_id"], [], [], '', '', "`licensevalue`");
                break;
            default:
                $this->value->Lookup = new Lookup('value', 'conf_schooltype', false, 'id', ["licensevalue","","",""], ["x_schooltype"], [], ["id"], ["x_id"], [], [], '', '', "`licensevalue`");
                break;
        }
        $this->value->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['value'] = &$this->value;

        // installment
        $this->installment = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_installment',
            'installment',
            '`installment`',
            '`installment`',
            3,
            11,
            -1,
            false,
            '`installment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->installment->InputTextType = "text";
        $this->installment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['installment'] = &$this->installment;

        // masterSchool
        $this->masterSchool = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_masterSchool',
            'masterSchool',
            '`masterSchool`',
            '`masterSchool`',
            3,
            11,
            -1,
            false,
            '`masterSchool`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->masterSchool->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->masterSchool->Lookup = new Lookup('masterSchool', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchool) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->masterSchool) . "',COALESCE(`UFId`,''))");
                break;
            case "pt-BR":
                $this->masterSchool->Lookup = new Lookup('masterSchool', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchool) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->masterSchool) . "',COALESCE(`UFId`,''))");
                break;
            case "es":
                $this->masterSchool->Lookup = new Lookup('masterSchool', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchool) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->masterSchool) . "',COALESCE(`UFId`,''))");
                break;
            default:
                $this->masterSchool->Lookup = new Lookup('masterSchool', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchool) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->masterSchool) . "',COALESCE(`UFId`,''))");
                break;
        }
        $this->masterSchool->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['masterSchool'] = &$this->masterSchool;

        // school
        $this->school = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_school',
            'school',
            '`school`',
            '`school`',
            3,
            11,
            -1,
            false,
            '`school`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->school->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->school->Lookup = new Lookup('school', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->school) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->school) . "',COALESCE(`UFId`,''))");
                break;
            case "pt-BR":
                $this->school->Lookup = new Lookup('school', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->school) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->school) . "',COALESCE(`UFId`,''))");
                break;
            case "es":
                $this->school->Lookup = new Lookup('school', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->school) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->school) . "',COALESCE(`UFId`,''))");
                break;
            default:
                $this->school->Lookup = new Lookup('school', 'fed_school', false, 'id', ["school","cityId","UFId",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->school) . "',COALESCE(`cityId`,''),'" . ValueSeparator(2, $this->school) . "',COALESCE(`UFId`,''))");
                break;
        }
        $this->school->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['school'] = &$this->school;

        // userId
        $this->_userId = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
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
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '', "`name`");
                break;
            case "pt-BR":
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '', "`name`");
                break;
            case "es":
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '', "`name`");
                break;
            default:
                $this->_userId->Lookup = new Lookup('userId', 'school_users', false, 'id', ["name","","",""], [], [], [], [], [], [], '', '', "`name`");
                break;
        }
        $this->_userId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['userId'] = &$this->_userId;

        // registerDate
        $this->registerDate = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_registerDate',
            'registerDate',
            '`registerDate`',
            CastDateFieldForLike("`registerDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`registerDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->registerDate->InputTextType = "text";
        $this->registerDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['registerDate'] = &$this->registerDate;

        // status
        $this->status = new DbField(
            'fed_licenseschool',
            'fed_licenseschool',
            'x_status',
            'status',
            '`status`',
            '`status`',
            200,
            255,
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
        $this->Fields['status'] = &$this->status;

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
        if ($this->getCurrentMasterTable() == "fed_applicationschool") {
            if ($this->application->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->application->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "fed_applicationschool") {
            if ($this->application->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`application`", $this->application->getSessionValue(), DATATYPE_NUMBER, "DB");
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
            case "fed_applicationschool":
                $key = $keys["application"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["application"], $masterTable->id->DataType, $masterTable->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "fed_applicationschool":
                return "`application`=" . QuotedValue($masterTable->id->DbValue, $this->application->DataType, $this->Dbid);
        }
        return "";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fed_licenseschool`";
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
        $this->application->DbValue = $row['application'];
        $this->dateLicense->DbValue = $row['dateLicense'];
        $this->dateStart->DbValue = $row['dateStart'];
        $this->dateFinish->DbValue = $row['dateFinish'];
        $this->schooltype->DbValue = $row['schooltype'];
        $this->value->DbValue = $row['value'];
        $this->installment->DbValue = $row['installment'];
        $this->masterSchool->DbValue = $row['masterSchool'];
        $this->school->DbValue = $row['school'];
        $this->_userId->DbValue = $row['userId'];
        $this->registerDate->DbValue = $row['registerDate'];
        $this->status->DbValue = $row['status'];
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
        return $_SESSION[$name] ?? GetUrl("FedLicenseschoolList");
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
        if ($pageName == "FedLicenseschoolView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FedLicenseschoolEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FedLicenseschoolAdd") {
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
                return "FedLicenseschoolView";
            case Config("API_ADD_ACTION"):
                return "FedLicenseschoolAdd";
            case Config("API_EDIT_ACTION"):
                return "FedLicenseschoolEdit";
            case Config("API_DELETE_ACTION"):
                return "FedLicenseschoolDelete";
            case Config("API_LIST_ACTION"):
                return "FedLicenseschoolList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FedLicenseschoolList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedLicenseschoolView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedLicenseschoolView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FedLicenseschoolAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FedLicenseschoolAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("FedLicenseschoolEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("FedLicenseschoolAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("FedLicenseschoolDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "fed_applicationschool" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->application->CurrentValue);
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
        $this->application->setDbValue($row['application']);
        $this->dateLicense->setDbValue($row['dateLicense']);
        $this->dateStart->setDbValue($row['dateStart']);
        $this->dateFinish->setDbValue($row['dateFinish']);
        $this->schooltype->setDbValue($row['schooltype']);
        $this->value->setDbValue($row['value']);
        $this->installment->setDbValue($row['installment']);
        $this->masterSchool->setDbValue($row['masterSchool']);
        $this->school->setDbValue($row['school']);
        $this->_userId->setDbValue($row['userId']);
        $this->registerDate->setDbValue($row['registerDate']);
        $this->status->setDbValue($row['status']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // application

        // dateLicense

        // dateStart

        // dateFinish

        // schooltype

        // value

        // installment

        // masterSchool

        // school

        // userId

        // registerDate

        // status

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // application
        $this->application->ViewValue = $this->application->CurrentValue;
        $curVal = strval($this->application->CurrentValue);
        if ($curVal != "") {
            $this->application->ViewValue = $this->application->lookupCacheOption($curVal);
            if ($this->application->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->application->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->application->Lookup->renderViewRow($rswrk[0]);
                    $this->application->ViewValue = $this->application->displayValue($arwrk);
                } else {
                    $this->application->ViewValue = FormatNumber($this->application->CurrentValue, $this->application->formatPattern());
                }
            }
        } else {
            $this->application->ViewValue = null;
        }
        $this->application->ViewCustomAttributes = "";

        // dateLicense
        $this->dateLicense->ViewValue = $this->dateLicense->CurrentValue;
        $this->dateLicense->ViewValue = FormatDateTime($this->dateLicense->ViewValue, $this->dateLicense->formatPattern());
        $this->dateLicense->ViewCustomAttributes = "";

        // dateStart
        $this->dateStart->ViewValue = $this->dateStart->CurrentValue;
        $this->dateStart->ViewValue = FormatDateTime($this->dateStart->ViewValue, $this->dateStart->formatPattern());
        $this->dateStart->ViewCustomAttributes = "";

        // dateFinish
        $this->dateFinish->ViewValue = $this->dateFinish->CurrentValue;
        $this->dateFinish->ViewValue = FormatDateTime($this->dateFinish->ViewValue, $this->dateFinish->formatPattern());
        $this->dateFinish->ViewCustomAttributes = "";

        // schooltype
        $curVal = strval($this->schooltype->CurrentValue);
        if ($curVal != "") {
            $this->schooltype->ViewValue = $this->schooltype->lookupCacheOption($curVal);
            if ($this->schooltype->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->schooltype->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->schooltype->Lookup->renderViewRow($rswrk[0]);
                    $this->schooltype->ViewValue = $this->schooltype->displayValue($arwrk);
                } else {
                    $this->schooltype->ViewValue = FormatNumber($this->schooltype->CurrentValue, $this->schooltype->formatPattern());
                }
            }
        } else {
            $this->schooltype->ViewValue = null;
        }
        $this->schooltype->ViewCustomAttributes = "";

        // value
        $this->value->ViewValue = $this->value->CurrentValue;
        $curVal = strval($this->value->CurrentValue);
        if ($curVal != "") {
            $this->value->ViewValue = $this->value->lookupCacheOption($curVal);
            if ($this->value->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->value->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->value->Lookup->renderViewRow($rswrk[0]);
                    $this->value->ViewValue = $this->value->displayValue($arwrk);
                } else {
                    $this->value->ViewValue = FormatNumber($this->value->CurrentValue, $this->value->formatPattern());
                }
            }
        } else {
            $this->value->ViewValue = null;
        }
        $this->value->ViewCustomAttributes = "";

        // installment
        $this->installment->ViewValue = $this->installment->CurrentValue;
        $this->installment->ViewValue = FormatNumber($this->installment->ViewValue, $this->installment->formatPattern());
        $this->installment->ViewCustomAttributes = "";

        // masterSchool
        $this->masterSchool->ViewValue = $this->masterSchool->CurrentValue;
        $curVal = strval($this->masterSchool->CurrentValue);
        if ($curVal != "") {
            $this->masterSchool->ViewValue = $this->masterSchool->lookupCacheOption($curVal);
            if ($this->masterSchool->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->masterSchool->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->masterSchool->Lookup->renderViewRow($rswrk[0]);
                    $this->masterSchool->ViewValue = $this->masterSchool->displayValue($arwrk);
                } else {
                    $this->masterSchool->ViewValue = FormatNumber($this->masterSchool->CurrentValue, $this->masterSchool->formatPattern());
                }
            }
        } else {
            $this->masterSchool->ViewValue = null;
        }
        $this->masterSchool->ViewCustomAttributes = "";

        // school
        $this->school->ViewValue = $this->school->CurrentValue;
        $curVal = strval($this->school->CurrentValue);
        if ($curVal != "") {
            $this->school->ViewValue = $this->school->lookupCacheOption($curVal);
            if ($this->school->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->school->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->school->Lookup->renderViewRow($rswrk[0]);
                    $this->school->ViewValue = $this->school->displayValue($arwrk);
                } else {
                    $this->school->ViewValue = FormatNumber($this->school->CurrentValue, $this->school->formatPattern());
                }
            }
        } else {
            $this->school->ViewValue = null;
        }
        $this->school->ViewCustomAttributes = "";

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

        // registerDate
        $this->registerDate->ViewValue = $this->registerDate->CurrentValue;
        $this->registerDate->ViewValue = FormatDateTime($this->registerDate->ViewValue, $this->registerDate->formatPattern());
        $this->registerDate->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // application
        $this->application->LinkCustomAttributes = "";
        $this->application->HrefValue = "";
        $this->application->TooltipValue = "";

        // dateLicense
        $this->dateLicense->LinkCustomAttributes = "";
        $this->dateLicense->HrefValue = "";
        $this->dateLicense->TooltipValue = "";

        // dateStart
        $this->dateStart->LinkCustomAttributes = "";
        $this->dateStart->HrefValue = "";
        $this->dateStart->TooltipValue = "";

        // dateFinish
        $this->dateFinish->LinkCustomAttributes = "";
        $this->dateFinish->HrefValue = "";
        $this->dateFinish->TooltipValue = "";

        // schooltype
        $this->schooltype->LinkCustomAttributes = "";
        $this->schooltype->HrefValue = "";
        $this->schooltype->TooltipValue = "";

        // value
        $this->value->LinkCustomAttributes = "";
        $this->value->HrefValue = "";
        $this->value->TooltipValue = "";

        // installment
        $this->installment->LinkCustomAttributes = "";
        $this->installment->HrefValue = "";
        $this->installment->TooltipValue = "";

        // masterSchool
        $this->masterSchool->LinkCustomAttributes = "";
        $this->masterSchool->HrefValue = "";
        $this->masterSchool->TooltipValue = "";

        // school
        $this->school->LinkCustomAttributes = "";
        $this->school->HrefValue = "";
        $this->school->TooltipValue = "";

        // userId
        $this->_userId->LinkCustomAttributes = "";
        $this->_userId->HrefValue = "";
        $this->_userId->TooltipValue = "";

        // registerDate
        $this->registerDate->LinkCustomAttributes = "";
        $this->registerDate->HrefValue = "";
        $this->registerDate->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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

        // application
        $this->application->setupEditAttributes();
        $this->application->EditCustomAttributes = "";
        if ($this->application->getSessionValue() != "") {
            $this->application->CurrentValue = GetForeignKeyValue($this->application->getSessionValue());
            $this->application->ViewValue = $this->application->CurrentValue;
            $curVal = strval($this->application->CurrentValue);
            if ($curVal != "") {
                $this->application->ViewValue = $this->application->lookupCacheOption($curVal);
                if ($this->application->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->application->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->application->Lookup->renderViewRow($rswrk[0]);
                        $this->application->ViewValue = $this->application->displayValue($arwrk);
                    } else {
                        $this->application->ViewValue = FormatNumber($this->application->CurrentValue, $this->application->formatPattern());
                    }
                }
            } else {
                $this->application->ViewValue = null;
            }
            $this->application->ViewCustomAttributes = "";
        } else {
            $this->application->EditValue = $this->application->CurrentValue;
            $this->application->PlaceHolder = RemoveHtml($this->application->caption());
        }

        // dateLicense
        $this->dateLicense->setupEditAttributes();
        $this->dateLicense->EditCustomAttributes = "";
        $this->dateLicense->EditValue = FormatDateTime($this->dateLicense->CurrentValue, $this->dateLicense->formatPattern());
        $this->dateLicense->PlaceHolder = RemoveHtml($this->dateLicense->caption());

        // dateStart
        $this->dateStart->setupEditAttributes();
        $this->dateStart->EditCustomAttributes = "";
        $this->dateStart->EditValue = FormatDateTime($this->dateStart->CurrentValue, $this->dateStart->formatPattern());
        $this->dateStart->PlaceHolder = RemoveHtml($this->dateStart->caption());

        // dateFinish
        $this->dateFinish->setupEditAttributes();
        $this->dateFinish->EditCustomAttributes = "";
        $this->dateFinish->EditValue = FormatDateTime($this->dateFinish->CurrentValue, $this->dateFinish->formatPattern());
        $this->dateFinish->PlaceHolder = RemoveHtml($this->dateFinish->caption());

        // schooltype
        $this->schooltype->setupEditAttributes();
        $this->schooltype->EditCustomAttributes = "";
        $this->schooltype->PlaceHolder = RemoveHtml($this->schooltype->caption());

        // value
        $this->value->setupEditAttributes();
        $this->value->EditCustomAttributes = "";
        $this->value->EditValue = $this->value->CurrentValue;
        $this->value->PlaceHolder = RemoveHtml($this->value->caption());

        // installment
        $this->installment->setupEditAttributes();
        $this->installment->EditCustomAttributes = "";
        $this->installment->EditValue = $this->installment->CurrentValue;
        $this->installment->PlaceHolder = RemoveHtml($this->installment->caption());
        if (strval($this->installment->EditValue) != "" && is_numeric($this->installment->EditValue)) {
            $this->installment->EditValue = FormatNumber($this->installment->EditValue, null);
        }

        // masterSchool
        $this->masterSchool->setupEditAttributes();
        $this->masterSchool->EditCustomAttributes = "";
        $this->masterSchool->EditValue = $this->masterSchool->CurrentValue;
        $this->masterSchool->PlaceHolder = RemoveHtml($this->masterSchool->caption());

        // school
        $this->school->setupEditAttributes();
        $this->school->EditCustomAttributes = "";
        $this->school->EditValue = $this->school->CurrentValue;
        $this->school->PlaceHolder = RemoveHtml($this->school->caption());

        // userId

        // registerDate

        // status
        $this->status->setupEditAttributes();
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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
                    $doc->exportCaption($this->application);
                    $doc->exportCaption($this->dateLicense);
                    $doc->exportCaption($this->dateStart);
                    $doc->exportCaption($this->dateFinish);
                    $doc->exportCaption($this->schooltype);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->installment);
                    $doc->exportCaption($this->masterSchool);
                    $doc->exportCaption($this->school);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->registerDate);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->application);
                    $doc->exportCaption($this->dateLicense);
                    $doc->exportCaption($this->dateStart);
                    $doc->exportCaption($this->dateFinish);
                    $doc->exportCaption($this->schooltype);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->installment);
                    $doc->exportCaption($this->masterSchool);
                    $doc->exportCaption($this->school);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->registerDate);
                    $doc->exportCaption($this->status);
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
                        $doc->exportField($this->application);
                        $doc->exportField($this->dateLicense);
                        $doc->exportField($this->dateStart);
                        $doc->exportField($this->dateFinish);
                        $doc->exportField($this->schooltype);
                        $doc->exportField($this->value);
                        $doc->exportField($this->installment);
                        $doc->exportField($this->masterSchool);
                        $doc->exportField($this->school);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->registerDate);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->application);
                        $doc->exportField($this->dateLicense);
                        $doc->exportField($this->dateStart);
                        $doc->exportField($this->dateFinish);
                        $doc->exportField($this->schooltype);
                        $doc->exportField($this->value);
                        $doc->exportField($this->installment);
                        $doc->exportField($this->masterSchool);
                        $doc->exportField($this->school);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->registerDate);
                        $doc->exportField($this->status);
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
