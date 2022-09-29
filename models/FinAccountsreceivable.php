<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fin_accountsreceivable
 */
class FinAccountsreceivable extends DbTable
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
    public $issue;
    public $due;
    public $historic;
    public $income;
    public $status;
    public $obs;
    public $value;
    public $deferred;
    public $amountInstallments;
    public $totalValueDeferred;
    public $firstdateInstallment;
    public $actualInstallment;
    public $orderId;
    public $balance;
    public $_userId;
    public $debtorId;
    public $accountFather;
    public $schoolId;
    public $lastUserId;
    public $_register;
    public $lastUpdate;
    public $licenseId;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fin_accountsreceivable';
        $this->TableName = 'fin_accountsreceivable';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fin_accountsreceivable`";
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
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // issue
        $this->issue = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_issue',
            'issue',
            '`issue`',
            CastDateFieldForLike("`issue`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`issue`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->issue->InputTextType = "text";
        $this->issue->Required = true; // Required field
        $this->issue->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['issue'] = &$this->issue;

        // due
        $this->due = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_due',
            'due',
            '`due`',
            CastDateFieldForLike("`due`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`due`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->due->InputTextType = "text";
        $this->due->Required = true; // Required field
        $this->due->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['due'] = &$this->due;

        // historic
        $this->historic = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_historic',
            'historic',
            '`historic`',
            '`historic`',
            200,
            255,
            -1,
            false,
            '`historic`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->historic->InputTextType = "text";
        $this->Fields['historic'] = &$this->historic;

        // income
        $this->income = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_income',
            'income',
            '`income`',
            '`income`',
            3,
            11,
            -1,
            false,
            '`EV__income`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->income->InputTextType = "text";
        $this->income->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->income->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->income->Lookup = new Lookup('income', 'fin_type', false, 'id', ["type","","",""], [], [], [], [], [], [], '', '', "`type`");
                break;
            case "pt-BR":
                $this->income->Lookup = new Lookup('income', 'fin_type', false, 'id', ["type","","",""], [], [], [], [], [], [], '', '', "`type`");
                break;
            case "es":
                $this->income->Lookup = new Lookup('income', 'fin_type', false, 'id', ["type","","",""], [], [], [], [], [], [], '', '', "`type`");
                break;
            default:
                $this->income->Lookup = new Lookup('income', 'fin_type', false, 'id', ["type","","",""], [], [], [], [], [], [], '', '', "`type`");
                break;
        }
        $this->income->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['income'] = &$this->income;

        // status
        $this->status = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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
            'RADIO'
        );
        $this->status->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->status->Lookup = new Lookup('status', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->status->Lookup = new Lookup('status', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->status->Lookup = new Lookup('status', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // obs
        $this->obs = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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

        // value
        $this->value = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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

        // deferred
        $this->deferred = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_deferred',
            'deferred',
            '`deferred`',
            '`deferred`',
            16,
            1,
            -1,
            false,
            '`deferred`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->deferred->InputTextType = "text";
        $this->deferred->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->deferred->Lookup = new Lookup('deferred', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->deferred->Lookup = new Lookup('deferred', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->deferred->Lookup = new Lookup('deferred', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->deferred->Lookup = new Lookup('deferred', 'fin_accountsreceivable', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->deferred->OptionCount = 2;
        $this->deferred->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['deferred'] = &$this->deferred;

        // amountInstallments
        $this->amountInstallments = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_amountInstallments',
            'amountInstallments',
            '`amountInstallments`',
            '`amountInstallments`',
            3,
            11,
            -1,
            false,
            '`amountInstallments`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amountInstallments->InputTextType = "text";
        $this->amountInstallments->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['amountInstallments'] = &$this->amountInstallments;

        // totalValueDeferred
        $this->totalValueDeferred = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_totalValueDeferred',
            'totalValueDeferred',
            '`totalValueDeferred`',
            '`totalValueDeferred`',
            131,
            10,
            -1,
            false,
            '`totalValueDeferred`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->totalValueDeferred->InputTextType = "text";
        $this->totalValueDeferred->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['totalValueDeferred'] = &$this->totalValueDeferred;

        // firstdateInstallment
        $this->firstdateInstallment = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_firstdateInstallment',
            'firstdateInstallment',
            '`firstdateInstallment`',
            CastDateFieldForLike("`firstdateInstallment`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`firstdateInstallment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->firstdateInstallment->InputTextType = "text";
        $this->firstdateInstallment->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['firstdateInstallment'] = &$this->firstdateInstallment;

        // actualInstallment
        $this->actualInstallment = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_actualInstallment',
            'actualInstallment',
            '`actualInstallment`',
            '`actualInstallment`',
            3,
            11,
            -1,
            false,
            '`actualInstallment`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->actualInstallment->InputTextType = "text";
        $this->actualInstallment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['actualInstallment'] = &$this->actualInstallment;

        // orderId
        $this->orderId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_orderId',
            'orderId',
            '`orderId`',
            '`orderId`',
            3,
            11,
            -1,
            false,
            '`orderId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->orderId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->orderId->Lookup = new Lookup('orderId', 'fin_order', false, 'id', ["id","date","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->orderId) . "',COALESCE(" . CastDateFieldForLike("`date`", 0, "DB") . ",''))");
                break;
            case "pt-BR":
                $this->orderId->Lookup = new Lookup('orderId', 'fin_order', false, 'id', ["id","date","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->orderId) . "',COALESCE(" . CastDateFieldForLike("`date`", 0, "DB") . ",''))");
                break;
            case "es":
                $this->orderId->Lookup = new Lookup('orderId', 'fin_order', false, 'id', ["id","date","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->orderId) . "',COALESCE(" . CastDateFieldForLike("`date`", 0, "DB") . ",''))");
                break;
            default:
                $this->orderId->Lookup = new Lookup('orderId', 'fin_order', false, 'id', ["id","date","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`id`, ''),'" . ValueSeparator(1, $this->orderId) . "',COALESCE(" . CastDateFieldForLike("`date`", 0, "DB") . ",''))");
                break;
        }
        $this->orderId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['orderId'] = &$this->orderId;

        // balance
        $this->balance = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_balance',
            'balance',
            '`balance`',
            '`balance`',
            131,
            10,
            -1,
            false,
            '`balance`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->balance->InputTextType = "text";
        $this->balance->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->Fields['balance'] = &$this->balance;

        // userId
        $this->_userId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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

        // debtorId
        $this->debtorId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_debtorId',
            'debtorId',
            '`debtorId`',
            '`debtorId`',
            3,
            11,
            -1,
            false,
            '`debtorId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->debtorId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->debtorId->Lookup = new Lookup('debtorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->debtorId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->debtorId->Lookup = new Lookup('debtorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->debtorId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->debtorId->Lookup = new Lookup('debtorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->debtorId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->debtorId->Lookup = new Lookup('debtorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->debtorId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->debtorId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['debtorId'] = &$this->debtorId;

        // accountFather
        $this->accountFather = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_accountFather',
            'accountFather',
            '`accountFather`',
            '`accountFather`',
            3,
            11,
            -1,
            false,
            '`accountFather`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->accountFather->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->accountFather->Lookup = new Lookup('accountFather', 'fin_accountsreceivable', false, 'id', ["id","","",""], [], [], [], [], [], [], '', '', "`id`");
                break;
            case "pt-BR":
                $this->accountFather->Lookup = new Lookup('accountFather', 'fin_accountsreceivable', false, 'id', ["id","","",""], [], [], [], [], [], [], '', '', "`id`");
                break;
            case "es":
                $this->accountFather->Lookup = new Lookup('accountFather', 'fin_accountsreceivable', false, 'id', ["id","","",""], [], [], [], [], [], [], '', '', "`id`");
                break;
            default:
                $this->accountFather->Lookup = new Lookup('accountFather', 'fin_accountsreceivable', false, 'id', ["id","","",""], [], [], [], [], [], [], '', '', "`id`");
                break;
        }
        $this->accountFather->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['accountFather'] = &$this->accountFather;

        // schoolId
        $this->schoolId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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

        // lastUserId
        $this->lastUserId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_lastUserId',
            'lastUserId',
            '`lastUserId`',
            '`lastUserId`',
            3,
            11,
            -1,
            false,
            '`lastUserId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastUserId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->lastUserId->Lookup = new Lookup('lastUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->lastUserId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->lastUserId->Lookup = new Lookup('lastUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->lastUserId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->lastUserId->Lookup = new Lookup('lastUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->lastUserId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->lastUserId->Lookup = new Lookup('lastUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->lastUserId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->lastUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lastUserId'] = &$this->lastUserId;

        // register
        $this->_register = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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
            'fin_accountsreceivable',
            'fin_accountsreceivable',
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

        // licenseId
        $this->licenseId = new DbField(
            'fin_accountsreceivable',
            'fin_accountsreceivable',
            'x_licenseId',
            'licenseId',
            '`licenseId`',
            '`licenseId`',
            3,
            11,
            -1,
            false,
            '`licenseId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->licenseId->InputTextType = "text";
        $this->licenseId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['licenseId'] = &$this->licenseId;

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
            $sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $curSort : "";
            $this->setSessionOrderByList($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->useVirtualFields() ? $this->getSessionOrderByList() : $this->getSessionOrderBy(); // Get ORDER BY from Session
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

    // Session ORDER BY for List page
    public function getSessionOrderByList()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST"));
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "fin_credit") {
            $detailUrl = Container("fin_credit")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "FinAccountsreceivableList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fin_accountsreceivable`";
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

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en-US":
                $from = "(SELECT *, (SELECT `type` FROM `fin_type` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fin_accountsreceivable`.`income` LIMIT 1) AS `EV__income` FROM `fin_accountsreceivable`)";
                break;
            case "pt-BR":
                $from = "(SELECT *, (SELECT `type` FROM `fin_type` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fin_accountsreceivable`.`income` LIMIT 1) AS `EV__income` FROM `fin_accountsreceivable`)";
                break;
            case "es":
                $from = "(SELECT *, (SELECT `type` FROM `fin_type` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fin_accountsreceivable`.`income` LIMIT 1) AS `EV__income` FROM `fin_accountsreceivable`)";
                break;
            default:
                $from = "(SELECT *, (SELECT `type` FROM `fin_type` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fin_accountsreceivable`.`income` LIMIT 1) AS `EV__income` FROM `fin_accountsreceivable`)";
                break;
        }
        return $from . " `TMP_TABLE`";
    }

    public function sqlSelectList() // For backward compatibility
    {
        return $this->getSqlSelectList();
    }

    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
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
        if ($this->useVirtualFields()) {
            $select = "*";
            $from = $this->getSqlSelectList();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        } else {
            $select = $this->getSqlSelect();
            $from = $this->getSqlFrom();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        }
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
        $sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Check if virtual fields is used in SQL
    protected function useVirtualFields()
    {
        $where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
        $orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        if ($where != "") {
            $where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
        }
        if ($orderBy != "") {
            $orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
        }
        if (
            $this->income->AdvancedSearch->SearchValue != "" ||
            $this->income->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->income->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->income->VirtualExpression . " ")) {
            return true;
        }
        return false;
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
        if ($this->useVirtualFields()) {
            $sql = $this->buildSelectSql("*", $this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        } else {
            $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        }
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
        // Cascade Update detail table 'fin_credit'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'accountId'
            $cascadeUpdate = true;
            $rscascade['accountId'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("fin_credit")->loadRs("`accountId` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("fin_credit")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("fin_credit")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("fin_credit")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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

        // Cascade delete detail table 'fin_credit'
        $dtlrows = Container("fin_credit")->loadRs("`accountId` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("fin_credit")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("fin_credit")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("fin_credit")->rowDeleted($dtlrow);
            }
        }
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
        $this->issue->DbValue = $row['issue'];
        $this->due->DbValue = $row['due'];
        $this->historic->DbValue = $row['historic'];
        $this->income->DbValue = $row['income'];
        $this->status->DbValue = $row['status'];
        $this->obs->DbValue = $row['obs'];
        $this->value->DbValue = $row['value'];
        $this->deferred->DbValue = $row['deferred'];
        $this->amountInstallments->DbValue = $row['amountInstallments'];
        $this->totalValueDeferred->DbValue = $row['totalValueDeferred'];
        $this->firstdateInstallment->DbValue = $row['firstdateInstallment'];
        $this->actualInstallment->DbValue = $row['actualInstallment'];
        $this->orderId->DbValue = $row['orderId'];
        $this->balance->DbValue = $row['balance'];
        $this->_userId->DbValue = $row['userId'];
        $this->debtorId->DbValue = $row['debtorId'];
        $this->accountFather->DbValue = $row['accountFather'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->lastUserId->DbValue = $row['lastUserId'];
        $this->_register->DbValue = $row['register'];
        $this->lastUpdate->DbValue = $row['lastUpdate'];
        $this->licenseId->DbValue = $row['licenseId'];
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
        return $_SESSION[$name] ?? GetUrl("FinAccountsreceivableList");
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
        if ($pageName == "FinAccountsreceivableView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FinAccountsreceivableEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FinAccountsreceivableAdd") {
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
                return "FinAccountsreceivableView";
            case Config("API_ADD_ACTION"):
                return "FinAccountsreceivableAdd";
            case Config("API_EDIT_ACTION"):
                return "FinAccountsreceivableEdit";
            case Config("API_DELETE_ACTION"):
                return "FinAccountsreceivableDelete";
            case Config("API_LIST_ACTION"):
                return "FinAccountsreceivableList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FinAccountsreceivableList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FinAccountsreceivableView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FinAccountsreceivableView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FinAccountsreceivableAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FinAccountsreceivableAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FinAccountsreceivableEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FinAccountsreceivableEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        if ($parm != "") {
            $url = $this->keyUrl("FinAccountsreceivableAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FinAccountsreceivableAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        return $this->keyUrl("FinAccountsreceivableDelete", $this->getUrlParm());
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
        $this->issue->setDbValue($row['issue']);
        $this->due->setDbValue($row['due']);
        $this->historic->setDbValue($row['historic']);
        $this->income->setDbValue($row['income']);
        $this->status->setDbValue($row['status']);
        $this->obs->setDbValue($row['obs']);
        $this->value->setDbValue($row['value']);
        $this->deferred->setDbValue($row['deferred']);
        $this->amountInstallments->setDbValue($row['amountInstallments']);
        $this->totalValueDeferred->setDbValue($row['totalValueDeferred']);
        $this->firstdateInstallment->setDbValue($row['firstdateInstallment']);
        $this->actualInstallment->setDbValue($row['actualInstallment']);
        $this->orderId->setDbValue($row['orderId']);
        $this->balance->setDbValue($row['balance']);
        $this->_userId->setDbValue($row['userId']);
        $this->debtorId->setDbValue($row['debtorId']);
        $this->accountFather->setDbValue($row['accountFather']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->_register->setDbValue($row['register']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->licenseId->setDbValue($row['licenseId']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // issue

        // due

        // historic

        // income

        // status

        // obs

        // value

        // deferred

        // amountInstallments

        // totalValueDeferred

        // firstdateInstallment

        // actualInstallment

        // orderId

        // balance

        // userId

        // debtorId

        // accountFather

        // schoolId

        // lastUserId

        // register

        // lastUpdate

        // licenseId

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // issue
        $this->issue->ViewValue = $this->issue->CurrentValue;
        $this->issue->ViewValue = FormatDateTime($this->issue->ViewValue, $this->issue->formatPattern());
        $this->issue->ViewCustomAttributes = "";

        // due
        $this->due->ViewValue = $this->due->CurrentValue;
        $this->due->ViewValue = FormatDateTime($this->due->ViewValue, $this->due->formatPattern());
        $this->due->ViewCustomAttributes = "";

        // historic
        $this->historic->ViewValue = $this->historic->CurrentValue;
        $this->historic->ViewCustomAttributes = "";

        // income
        if ($this->income->VirtualValue != "") {
            $this->income->ViewValue = $this->income->VirtualValue;
        } else {
            $curVal = strval($this->income->CurrentValue);
            if ($curVal != "") {
                $this->income->ViewValue = $this->income->lookupCacheOption($curVal);
                if ($this->income->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->income->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->income->Lookup->renderViewRow($rswrk[0]);
                        $this->income->ViewValue = $this->income->displayValue($arwrk);
                    } else {
                        $this->income->ViewValue = FormatNumber($this->income->CurrentValue, $this->income->formatPattern());
                    }
                }
            } else {
                $this->income->ViewValue = null;
            }
        }
        $this->income->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->ViewCustomAttributes = "";

        // value
        $this->value->ViewValue = $this->value->CurrentValue;
        $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
        $this->value->ViewCustomAttributes = "";

        // deferred
        if (ConvertToBool($this->deferred->CurrentValue)) {
            $this->deferred->ViewValue = $this->deferred->tagCaption(1) != "" ? $this->deferred->tagCaption(1) : "Yes";
        } else {
            $this->deferred->ViewValue = $this->deferred->tagCaption(2) != "" ? $this->deferred->tagCaption(2) : "No";
        }
        $this->deferred->ViewCustomAttributes = "";

        // amountInstallments
        $this->amountInstallments->ViewValue = $this->amountInstallments->CurrentValue;
        $this->amountInstallments->ViewValue = FormatNumber($this->amountInstallments->ViewValue, $this->amountInstallments->formatPattern());
        $this->amountInstallments->ViewCustomAttributes = "";

        // totalValueDeferred
        $this->totalValueDeferred->ViewValue = $this->totalValueDeferred->CurrentValue;
        $this->totalValueDeferred->ViewValue = FormatNumber($this->totalValueDeferred->ViewValue, $this->totalValueDeferred->formatPattern());
        $this->totalValueDeferred->ViewCustomAttributes = "";

        // firstdateInstallment
        $this->firstdateInstallment->ViewValue = $this->firstdateInstallment->CurrentValue;
        $this->firstdateInstallment->ViewValue = FormatDateTime($this->firstdateInstallment->ViewValue, $this->firstdateInstallment->formatPattern());
        $this->firstdateInstallment->ViewCustomAttributes = "";

        // actualInstallment
        $this->actualInstallment->ViewValue = $this->actualInstallment->CurrentValue;
        $this->actualInstallment->ViewValue = FormatNumber($this->actualInstallment->ViewValue, $this->actualInstallment->formatPattern());
        $this->actualInstallment->ViewCustomAttributes = "";

        // orderId
        $this->orderId->ViewValue = $this->orderId->CurrentValue;
        $curVal = strval($this->orderId->CurrentValue);
        if ($curVal != "") {
            $this->orderId->ViewValue = $this->orderId->lookupCacheOption($curVal);
            if ($this->orderId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->orderId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->orderId->Lookup->renderViewRow($rswrk[0]);
                    $this->orderId->ViewValue = $this->orderId->displayValue($arwrk);
                } else {
                    $this->orderId->ViewValue = FormatNumber($this->orderId->CurrentValue, $this->orderId->formatPattern());
                }
            }
        } else {
            $this->orderId->ViewValue = null;
        }
        $this->orderId->ViewCustomAttributes = "";

        // balance
        $this->balance->ViewValue = $this->balance->CurrentValue;
        $this->balance->ViewValue = FormatNumber($this->balance->ViewValue, $this->balance->formatPattern());
        $this->balance->ViewCustomAttributes = "";

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

        // debtorId
        $this->debtorId->ViewValue = $this->debtorId->CurrentValue;
        $curVal = strval($this->debtorId->CurrentValue);
        if ($curVal != "") {
            $this->debtorId->ViewValue = $this->debtorId->lookupCacheOption($curVal);
            if ($this->debtorId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->debtorId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->debtorId->Lookup->renderViewRow($rswrk[0]);
                    $this->debtorId->ViewValue = $this->debtorId->displayValue($arwrk);
                } else {
                    $this->debtorId->ViewValue = FormatNumber($this->debtorId->CurrentValue, $this->debtorId->formatPattern());
                }
            }
        } else {
            $this->debtorId->ViewValue = null;
        }
        $this->debtorId->ViewCustomAttributes = "";

        // accountFather
        $this->accountFather->ViewValue = $this->accountFather->CurrentValue;
        $curVal = strval($this->accountFather->CurrentValue);
        if ($curVal != "") {
            $this->accountFather->ViewValue = $this->accountFather->lookupCacheOption($curVal);
            if ($this->accountFather->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->accountFather->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->accountFather->Lookup->renderViewRow($rswrk[0]);
                    $this->accountFather->ViewValue = $this->accountFather->displayValue($arwrk);
                } else {
                    $this->accountFather->ViewValue = FormatNumber($this->accountFather->CurrentValue, $this->accountFather->formatPattern());
                }
            }
        } else {
            $this->accountFather->ViewValue = null;
        }
        $this->accountFather->ViewCustomAttributes = "";

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

        // lastUserId
        $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
        $curVal = strval($this->lastUserId->CurrentValue);
        if ($curVal != "") {
            $this->lastUserId->ViewValue = $this->lastUserId->lookupCacheOption($curVal);
            if ($this->lastUserId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->lastUserId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->lastUserId->Lookup->renderViewRow($rswrk[0]);
                    $this->lastUserId->ViewValue = $this->lastUserId->displayValue($arwrk);
                } else {
                    $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->CurrentValue, $this->lastUserId->formatPattern());
                }
            }
        } else {
            $this->lastUserId->ViewValue = null;
        }
        $this->lastUserId->ViewCustomAttributes = "";

        // register
        $this->_register->ViewValue = $this->_register->CurrentValue;
        $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
        $this->_register->ViewCustomAttributes = "";

        // lastUpdate
        $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
        $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
        $this->lastUpdate->ViewCustomAttributes = "";

        // licenseId
        $this->licenseId->ViewValue = $this->licenseId->CurrentValue;
        $this->licenseId->ViewValue = FormatNumber($this->licenseId->ViewValue, $this->licenseId->formatPattern());
        $this->licenseId->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // issue
        $this->issue->LinkCustomAttributes = "";
        $this->issue->HrefValue = "";
        $this->issue->TooltipValue = "";

        // due
        $this->due->LinkCustomAttributes = "";
        $this->due->HrefValue = "";
        $this->due->TooltipValue = "";

        // historic
        $this->historic->LinkCustomAttributes = "";
        $this->historic->HrefValue = "";
        $this->historic->TooltipValue = "";

        // income
        $this->income->LinkCustomAttributes = "";
        $this->income->HrefValue = "";
        $this->income->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // obs
        $this->obs->LinkCustomAttributes = "";
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // value
        $this->value->LinkCustomAttributes = "";
        $this->value->HrefValue = "";
        $this->value->TooltipValue = "";

        // deferred
        $this->deferred->LinkCustomAttributes = "";
        $this->deferred->HrefValue = "";
        $this->deferred->TooltipValue = "";

        // amountInstallments
        $this->amountInstallments->LinkCustomAttributes = "";
        $this->amountInstallments->HrefValue = "";
        $this->amountInstallments->TooltipValue = "";

        // totalValueDeferred
        $this->totalValueDeferred->LinkCustomAttributes = "";
        $this->totalValueDeferred->HrefValue = "";
        $this->totalValueDeferred->TooltipValue = "";

        // firstdateInstallment
        $this->firstdateInstallment->LinkCustomAttributes = "";
        $this->firstdateInstallment->HrefValue = "";
        $this->firstdateInstallment->TooltipValue = "";

        // actualInstallment
        $this->actualInstallment->LinkCustomAttributes = "";
        $this->actualInstallment->HrefValue = "";
        $this->actualInstallment->TooltipValue = "";

        // orderId
        $this->orderId->LinkCustomAttributes = "";
        $this->orderId->HrefValue = "";
        $this->orderId->TooltipValue = "";

        // balance
        $this->balance->LinkCustomAttributes = "";
        $this->balance->HrefValue = "";
        $this->balance->TooltipValue = "";

        // userId
        $this->_userId->LinkCustomAttributes = "";
        $this->_userId->HrefValue = "";
        $this->_userId->TooltipValue = "";

        // debtorId
        $this->debtorId->LinkCustomAttributes = "";
        $this->debtorId->HrefValue = "";
        $this->debtorId->TooltipValue = "";

        // accountFather
        $this->accountFather->LinkCustomAttributes = "";
        $this->accountFather->HrefValue = "";
        $this->accountFather->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // lastUserId
        $this->lastUserId->LinkCustomAttributes = "";
        $this->lastUserId->HrefValue = "";
        $this->lastUserId->TooltipValue = "";

        // register
        $this->_register->LinkCustomAttributes = "";
        $this->_register->HrefValue = "";
        $this->_register->TooltipValue = "";

        // lastUpdate
        $this->lastUpdate->LinkCustomAttributes = "";
        $this->lastUpdate->HrefValue = "";
        $this->lastUpdate->TooltipValue = "";

        // licenseId
        $this->licenseId->LinkCustomAttributes = "";
        $this->licenseId->HrefValue = "";
        $this->licenseId->TooltipValue = "";

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

        // issue
        $this->issue->setupEditAttributes();
        $this->issue->EditCustomAttributes = "";
        $this->issue->EditValue = FormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern());
        $this->issue->PlaceHolder = RemoveHtml($this->issue->caption());

        // due
        $this->due->setupEditAttributes();
        $this->due->EditCustomAttributes = "";
        $this->due->EditValue = FormatDateTime($this->due->CurrentValue, $this->due->formatPattern());
        $this->due->PlaceHolder = RemoveHtml($this->due->caption());

        // historic
        $this->historic->setupEditAttributes();
        $this->historic->EditCustomAttributes = "";
        if (!$this->historic->Raw) {
            $this->historic->CurrentValue = HtmlDecode($this->historic->CurrentValue);
        }
        $this->historic->EditValue = $this->historic->CurrentValue;
        $this->historic->PlaceHolder = RemoveHtml($this->historic->caption());

        // income
        $this->income->setupEditAttributes();
        $this->income->EditCustomAttributes = "";
        $this->income->PlaceHolder = RemoveHtml($this->income->caption());

        // status
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(false);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // obs
        $this->obs->setupEditAttributes();
        $this->obs->EditCustomAttributes = "";
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // value
        $this->value->setupEditAttributes();
        $this->value->EditCustomAttributes = "";
        $this->value->EditValue = $this->value->CurrentValue;
        $this->value->PlaceHolder = RemoveHtml($this->value->caption());
        if (strval($this->value->EditValue) != "" && is_numeric($this->value->EditValue)) {
            $this->value->EditValue = FormatNumber($this->value->EditValue, null);
        }

        // deferred
        $this->deferred->EditCustomAttributes = "";
        $this->deferred->EditValue = $this->deferred->options(false);
        $this->deferred->PlaceHolder = RemoveHtml($this->deferred->caption());

        // amountInstallments
        $this->amountInstallments->setupEditAttributes();
        $this->amountInstallments->EditCustomAttributes = "";
        $this->amountInstallments->EditValue = $this->amountInstallments->CurrentValue;
        $this->amountInstallments->PlaceHolder = RemoveHtml($this->amountInstallments->caption());
        if (strval($this->amountInstallments->EditValue) != "" && is_numeric($this->amountInstallments->EditValue)) {
            $this->amountInstallments->EditValue = FormatNumber($this->amountInstallments->EditValue, null);
        }

        // totalValueDeferred
        $this->totalValueDeferred->setupEditAttributes();
        $this->totalValueDeferred->EditCustomAttributes = "";
        $this->totalValueDeferred->EditValue = $this->totalValueDeferred->CurrentValue;
        $this->totalValueDeferred->PlaceHolder = RemoveHtml($this->totalValueDeferred->caption());
        if (strval($this->totalValueDeferred->EditValue) != "" && is_numeric($this->totalValueDeferred->EditValue)) {
            $this->totalValueDeferred->EditValue = FormatNumber($this->totalValueDeferred->EditValue, null);
        }

        // firstdateInstallment
        $this->firstdateInstallment->setupEditAttributes();
        $this->firstdateInstallment->EditCustomAttributes = "";
        $this->firstdateInstallment->EditValue = FormatDateTime($this->firstdateInstallment->CurrentValue, $this->firstdateInstallment->formatPattern());
        $this->firstdateInstallment->PlaceHolder = RemoveHtml($this->firstdateInstallment->caption());

        // actualInstallment
        $this->actualInstallment->setupEditAttributes();
        $this->actualInstallment->EditCustomAttributes = "";
        $this->actualInstallment->EditValue = $this->actualInstallment->CurrentValue;
        $this->actualInstallment->PlaceHolder = RemoveHtml($this->actualInstallment->caption());
        if (strval($this->actualInstallment->EditValue) != "" && is_numeric($this->actualInstallment->EditValue)) {
            $this->actualInstallment->EditValue = FormatNumber($this->actualInstallment->EditValue, null);
        }

        // orderId
        $this->orderId->setupEditAttributes();
        $this->orderId->EditCustomAttributes = "";
        $this->orderId->EditValue = $this->orderId->CurrentValue;
        $this->orderId->PlaceHolder = RemoveHtml($this->orderId->caption());

        // balance
        $this->balance->setupEditAttributes();
        $this->balance->EditCustomAttributes = "";
        $this->balance->EditValue = $this->balance->CurrentValue;
        $this->balance->EditValue = FormatNumber($this->balance->EditValue, $this->balance->formatPattern());
        $this->balance->ViewCustomAttributes = "";

        // userId
        $this->_userId->setupEditAttributes();
        $this->_userId->EditCustomAttributes = "";
        $this->_userId->EditValue = $this->_userId->CurrentValue;
        $this->_userId->PlaceHolder = RemoveHtml($this->_userId->caption());

        // debtorId
        $this->debtorId->setupEditAttributes();
        $this->debtorId->EditCustomAttributes = "";
        $this->debtorId->EditValue = $this->debtorId->CurrentValue;
        $this->debtorId->PlaceHolder = RemoveHtml($this->debtorId->caption());

        // accountFather
        $this->accountFather->setupEditAttributes();
        $this->accountFather->EditCustomAttributes = "";
        $this->accountFather->EditValue = $this->accountFather->CurrentValue;
        $this->accountFather->PlaceHolder = RemoveHtml($this->accountFather->caption());

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->EditValue = $this->schoolId->CurrentValue;
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
        }

        // lastUserId

        // register
        $this->_register->setupEditAttributes();
        $this->_register->EditCustomAttributes = "";
        $this->_register->EditValue = FormatDateTime($this->_register->CurrentValue, $this->_register->formatPattern());
        $this->_register->PlaceHolder = RemoveHtml($this->_register->caption());

        // lastUpdate

        // licenseId
        $this->licenseId->setupEditAttributes();
        $this->licenseId->EditCustomAttributes = "";
        $this->licenseId->EditValue = $this->licenseId->CurrentValue;
        $this->licenseId->PlaceHolder = RemoveHtml($this->licenseId->caption());
        if (strval($this->licenseId->EditValue) != "" && is_numeric($this->licenseId->EditValue)) {
            $this->licenseId->EditValue = FormatNumber($this->licenseId->EditValue, null);
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
                    $doc->exportCaption($this->issue);
                    $doc->exportCaption($this->due);
                    $doc->exportCaption($this->historic);
                    $doc->exportCaption($this->income);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->orderId);
                    $doc->exportCaption($this->balance);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->debtorId);
                    $doc->exportCaption($this->accountFather);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->lastUserId);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->licenseId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->issue);
                    $doc->exportCaption($this->due);
                    $doc->exportCaption($this->historic);
                    $doc->exportCaption($this->income);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->value);
                    $doc->exportCaption($this->deferred);
                    $doc->exportCaption($this->amountInstallments);
                    $doc->exportCaption($this->totalValueDeferred);
                    $doc->exportCaption($this->firstdateInstallment);
                    $doc->exportCaption($this->actualInstallment);
                    $doc->exportCaption($this->orderId);
                    $doc->exportCaption($this->balance);
                    $doc->exportCaption($this->_userId);
                    $doc->exportCaption($this->debtorId);
                    $doc->exportCaption($this->accountFather);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->lastUserId);
                    $doc->exportCaption($this->_register);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->licenseId);
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
                        $doc->exportField($this->issue);
                        $doc->exportField($this->due);
                        $doc->exportField($this->historic);
                        $doc->exportField($this->income);
                        $doc->exportField($this->status);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->value);
                        $doc->exportField($this->orderId);
                        $doc->exportField($this->balance);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->debtorId);
                        $doc->exportField($this->accountFather);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->lastUserId);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->licenseId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->issue);
                        $doc->exportField($this->due);
                        $doc->exportField($this->historic);
                        $doc->exportField($this->income);
                        $doc->exportField($this->status);
                        $doc->exportField($this->value);
                        $doc->exportField($this->deferred);
                        $doc->exportField($this->amountInstallments);
                        $doc->exportField($this->totalValueDeferred);
                        $doc->exportField($this->firstdateInstallment);
                        $doc->exportField($this->actualInstallment);
                        $doc->exportField($this->orderId);
                        $doc->exportField($this->balance);
                        $doc->exportField($this->_userId);
                        $doc->exportField($this->debtorId);
                        $doc->exportField($this->accountFather);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->lastUserId);
                        $doc->exportField($this->_register);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->licenseId);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `fin_accountsreceivable`";
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
        $rsnew['register'] = CurrentDate();
        $rsnew['userId'] = GetLoggedUserID();
        $rsnew['schooId'] = CurrentUserID();
        if($rsnew['issue'] > $rsnew['due']){
        	$this->setFailureMessage("Please check Issue date and Due Date.");
        	return false;
        }
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
        if(isset($rsold['id']) && isset($rsnew['value'])){
            	return updateAccountStatus($rsold["id"], $rsnew['value'], 1);
        }
        if($rsnew['issue'] > $rsnew['due']){
        	$this->CancelMessage("Please check Issue date and Due Date.");
        	return false;
        }
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
        if(isset($this->id->CurrentValue) && isset($this->value->CurrentValue) && CurrentPageID() != "add"){
        	$this->balance->CurrentValue = amountPaid($this->id->CurrentValue, 1);
        	updateAccountStatus($this->id->CurrentValue, $this->value->CurrentValue, 1);
        	$this->status->ViewAttrs["style"] = paint($this->status->CurrentValue);
        }
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
