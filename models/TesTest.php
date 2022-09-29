<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for tes_test
 */
class TesTest extends DbTable
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
    public $description;
    public $testCity;
    public $federationId;
    public $martialartsId;
    public $schoolId;
    public $instructorId;
    public $auxiliarInstructorId;
    public $testDate;
    public $testTime;
    public $ceremonyDate;
    public $testTypeId;
    public $testStatusId;
    public $createUserId;
    public $createDate;
    public $judgeId;
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
        $this->TableVar = 'tes_test';
        $this->TableName = 'tes_test';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`tes_test`";
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
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = true; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'tes_test',
            'tes_test',
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

        // description
        $this->description = new DbField(
            'tes_test',
            'tes_test',
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
            'TEXTAREA'
        );
        $this->description->InputTextType = "text";
        $this->Fields['description'] = &$this->description;

        // testCity
        $this->testCity = new DbField(
            'tes_test',
            'tes_test',
            'x_testCity',
            'testCity',
            '`testCity`',
            '`testCity`',
            3,
            11,
            -1,
            false,
            '`EV__testCity`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->testCity->InputTextType = "text";
        $this->testCity->Required = true; // Required field
        $this->testCity->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->testCity->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->testCity->Lookup = new Lookup('testCity', 'conf_city', false, 'id', ["city","","",""], [], [], [], [], [], [], '', '', "`city`");
                break;
            case "pt-BR":
                $this->testCity->Lookup = new Lookup('testCity', 'conf_city', false, 'id', ["city","","",""], [], [], [], [], [], [], '', '', "`city`");
                break;
            case "es":
                $this->testCity->Lookup = new Lookup('testCity', 'conf_city', false, 'id', ["city","","",""], [], [], [], [], [], [], '', '', "`city`");
                break;
            default:
                $this->testCity->Lookup = new Lookup('testCity', 'conf_city', false, 'id', ["city","","",""], [], [], [], [], [], [], '', '', "`city`");
                break;
        }
        $this->testCity->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['testCity'] = &$this->testCity;

        // federationId
        $this->federationId = new DbField(
            'tes_test',
            'tes_test',
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
            'SELECT'
        );
        $this->federationId->InputTextType = "text";
        $this->federationId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->federationId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","","",""], [], [], [], [], [], [], '', '', "`federation`");
                break;
            case "pt-BR":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","","",""], [], [], [], [], [], [], '', '', "`federation`");
                break;
            case "es":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","","",""], [], [], [], [], [], [], '', '', "`federation`");
                break;
            default:
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","","",""], [], [], [], [], [], [], '', '', "`federation`");
                break;
        }
        $this->federationId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['federationId'] = &$this->federationId;

        // martialartsId
        $this->martialartsId = new DbField(
            'tes_test',
            'tes_test',
            'x_martialartsId',
            'martialartsId',
            '`martialartsId`',
            '`martialartsId`',
            3,
            11,
            -1,
            false,
            '`martialartsId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->martialartsId->InputTextType = "text";
        $this->martialartsId->Required = true; // Required field
        $this->martialartsId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->martialartsId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->martialartsId->Lookup = new Lookup('martialartsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_certificateId"], [], [], [], [], '', '', "`martialArts`");
                break;
            case "pt-BR":
                $this->martialartsId->Lookup = new Lookup('martialartsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_certificateId"], [], [], [], [], '', '', "`martialArts`");
                break;
            case "es":
                $this->martialartsId->Lookup = new Lookup('martialartsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_certificateId"], [], [], [], [], '', '', "`martialArts`");
                break;
            default:
                $this->martialartsId->Lookup = new Lookup('martialartsId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_certificateId"], [], [], [], [], '', '', "`martialArts`");
                break;
        }
        $this->martialartsId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['martialartsId'] = &$this->martialartsId;

        // schoolId
        $this->schoolId = new DbField(
            'tes_test',
            'tes_test',
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
        $this->schoolId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->schoolId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","cityId","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            case "pt-BR":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","cityId","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            case "es":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","cityId","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            default:
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","cityId","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
        }
        $this->schoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolId'] = &$this->schoolId;

        // instructorId
        $this->instructorId = new DbField(
            'tes_test',
            'tes_test',
            'x_instructorId',
            'instructorId',
            '`instructorId`',
            '`instructorId`',
            3,
            11,
            -1,
            false,
            '`instructorId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorId->InputTextType = "text";
        $this->instructorId->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->instructorId->Lookup = new Lookup('instructorId', 'school_member', false, 'id', ["name","lastName","instructorStatus",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->instructorId) . "',COALESCE(`lastName`,''),'" . ValueSeparator(2, $this->instructorId) . "',COALESCE(`instructorStatus`,''))");
                break;
            case "pt-BR":
                $this->instructorId->Lookup = new Lookup('instructorId', 'school_member', false, 'id', ["name","lastName","instructorStatus",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->instructorId) . "',COALESCE(`lastName`,''),'" . ValueSeparator(2, $this->instructorId) . "',COALESCE(`instructorStatus`,''))");
                break;
            case "es":
                $this->instructorId->Lookup = new Lookup('instructorId', 'school_member', false, 'id', ["name","lastName","instructorStatus",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->instructorId) . "',COALESCE(`lastName`,''),'" . ValueSeparator(2, $this->instructorId) . "',COALESCE(`instructorStatus`,''))");
                break;
            default:
                $this->instructorId->Lookup = new Lookup('instructorId', 'school_member', false, 'id', ["name","lastName","instructorStatus",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->instructorId) . "',COALESCE(`lastName`,''),'" . ValueSeparator(2, $this->instructorId) . "',COALESCE(`instructorStatus`,''))");
                break;
        }
        $this->instructorId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['instructorId'] = &$this->instructorId;

        // auxiliarInstructorId
        $this->auxiliarInstructorId = new DbField(
            'tes_test',
            'tes_test',
            'x_auxiliarInstructorId',
            'auxiliarInstructorId',
            '`auxiliarInstructorId`',
            '`auxiliarInstructorId`',
            3,
            11,
            -1,
            false,
            '`auxiliarInstructorId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->auxiliarInstructorId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->auxiliarInstructorId->Lookup = new Lookup('auxiliarInstructorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->auxiliarInstructorId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->auxiliarInstructorId->Lookup = new Lookup('auxiliarInstructorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->auxiliarInstructorId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->auxiliarInstructorId->Lookup = new Lookup('auxiliarInstructorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->auxiliarInstructorId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->auxiliarInstructorId->Lookup = new Lookup('auxiliarInstructorId', 'school_member', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->auxiliarInstructorId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->auxiliarInstructorId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['auxiliarInstructorId'] = &$this->auxiliarInstructorId;

        // testDate
        $this->testDate = new DbField(
            'tes_test',
            'tes_test',
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
        $this->testDate->Required = true; // Required field
        $this->testDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['testDate'] = &$this->testDate;

        // testTime
        $this->testTime = new DbField(
            'tes_test',
            'tes_test',
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
        $this->testTime->Required = true; // Required field
        $this->testTime->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
        $this->Fields['testTime'] = &$this->testTime;

        // ceremonyDate
        $this->ceremonyDate = new DbField(
            'tes_test',
            'tes_test',
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
        $this->ceremonyDate->Required = true; // Required field
        $this->ceremonyDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['ceremonyDate'] = &$this->ceremonyDate;

        // testTypeId
        $this->testTypeId = new DbField(
            'tes_test',
            'tes_test',
            'x_testTypeId',
            'testTypeId',
            '`testTypeId`',
            '`testTypeId`',
            3,
            11,
            -1,
            false,
            '`testTypeId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->testTypeId->InputTextType = "text";
        $this->testTypeId->Required = true; // Required field
        $this->testTypeId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->testTypeId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->testTypeId->Lookup = new Lookup('testTypeId', 'tes_test', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->testTypeId->Lookup = new Lookup('testTypeId', 'tes_test', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->testTypeId->Lookup = new Lookup('testTypeId', 'tes_test', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->testTypeId->Lookup = new Lookup('testTypeId', 'tes_test', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->testTypeId->OptionCount = 4;
        $this->testTypeId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['testTypeId'] = &$this->testTypeId;

        // testStatusId
        $this->testStatusId = new DbField(
            'tes_test',
            'tes_test',
            'x_testStatusId',
            'testStatusId',
            '`testStatusId`',
            '`testStatusId`',
            3,
            11,
            -1,
            false,
            '`testStatusId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->testStatusId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->testStatusId->Lookup = new Lookup('testStatusId', 'conf_testestatus', false, 'id', ["statusEN","","",""], [], [], [], [], [], [], '', '', "`statusEN`");
                break;
            case "pt-BR":
                $this->testStatusId->Lookup = new Lookup('testStatusId', 'conf_testestatus', false, 'id', ["testStatus","","",""], [], [], [], [], [], [], '', '', "`testStatus`");
                break;
            case "es":
                $this->testStatusId->Lookup = new Lookup('testStatusId', 'conf_testestatus', false, 'id', ["statusES","","",""], [], [], [], [], [], [], '', '', "`statusES`");
                break;
            default:
                $this->testStatusId->Lookup = new Lookup('testStatusId', 'conf_testestatus', false, 'id', ["statusEN","","",""], [], [], [], [], [], [], '', '', "`statusEN`");
                break;
        }
        $this->testStatusId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['testStatusId'] = &$this->testStatusId;

        // createUserId
        $this->createUserId = new DbField(
            'tes_test',
            'tes_test',
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
        switch ($CurrentLanguage) {
            case "en-US":
                $this->createUserId->Lookup = new Lookup('createUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->createUserId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->createUserId->Lookup = new Lookup('createUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->createUserId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->createUserId->Lookup = new Lookup('createUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->createUserId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->createUserId->Lookup = new Lookup('createUserId', 'school_users', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->createUserId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->createUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['createUserId'] = &$this->createUserId;

        // createDate
        $this->createDate = new DbField(
            'tes_test',
            'tes_test',
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

        // judgeId
        $this->judgeId = new DbField(
            'tes_test',
            'tes_test',
            'x_judgeId',
            'judgeId',
            '`judgeId`',
            '`judgeId`',
            3,
            11,
            -1,
            false,
            '`judgeId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->judgeId->InputTextType = "text";
        $this->judgeId->Required = true; // Required field
        $this->judgeId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->judgeId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->judgeId->Lookup = new Lookup('judgeId', 'view_alljudgemembers', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->judgeId) . "',COALESCE(`lastName`,''))");
                break;
            case "pt-BR":
                $this->judgeId->Lookup = new Lookup('judgeId', 'view_alljudgemembers', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->judgeId) . "',COALESCE(`lastName`,''))");
                break;
            case "es":
                $this->judgeId->Lookup = new Lookup('judgeId', 'view_alljudgemembers', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->judgeId) . "',COALESCE(`lastName`,''))");
                break;
            default:
                $this->judgeId->Lookup = new Lookup('judgeId', 'view_alljudgemembers', false, 'id', ["name","lastName","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name`, ''),'" . ValueSeparator(1, $this->judgeId) . "',COALESCE(`lastName`,''))");
                break;
        }
        $this->judgeId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['judgeId'] = &$this->judgeId;

        // certificateId
        $this->certificateId = new DbField(
            'tes_test',
            'tes_test',
            'x_certificateId',
            'certificateId',
            '`certificateId`',
            '`certificateId`',
            3,
            11,
            -1,
            false,
            '`EV__certificateId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->certificateId->InputTextType = "text";
        $this->certificateId->Required = true; // Required field
        $this->certificateId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->certificateId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->certificateId->Lookup = new Lookup('certificateId', 'tes_certificate', false, 'id', ["description","","",""], ["x_martialartsId"], [], ["martialArtId"], ["x_martialArtId"], [], [], '', '', "`description`");
                break;
            case "pt-BR":
                $this->certificateId->Lookup = new Lookup('certificateId', 'tes_certificate', false, 'id', ["description","","",""], ["x_martialartsId"], [], ["martialArtId"], ["x_martialArtId"], [], [], '', '', "`description`");
                break;
            case "es":
                $this->certificateId->Lookup = new Lookup('certificateId', 'tes_certificate', false, 'id', ["description","","",""], ["x_martialartsId"], [], ["martialArtId"], ["x_martialArtId"], [], [], '', '', "`description`");
                break;
            default:
                $this->certificateId->Lookup = new Lookup('certificateId', 'tes_certificate', false, 'id', ["description","","",""], ["x_martialartsId"], [], ["martialArtId"], ["x_martialArtId"], [], [], '', '', "`description`");
                break;
        }
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
        if ($this->getCurrentDetailTable() == "tes_candidate") {
            $detailUrl = Container("tes_candidate")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "view_test_aproveds") {
            $detailUrl = Container("view_test_aproveds")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "TesTestList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`tes_test`";
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
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`testCity` LIMIT 1) AS `EV__testCity`, (SELECT `description` FROM `tes_certificate` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`certificateId` LIMIT 1) AS `EV__certificateId` FROM `tes_test`)";
                break;
            case "pt-BR":
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`testCity` LIMIT 1) AS `EV__testCity`, (SELECT `description` FROM `tes_certificate` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`certificateId` LIMIT 1) AS `EV__certificateId` FROM `tes_test`)";
                break;
            case "es":
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`testCity` LIMIT 1) AS `EV__testCity`, (SELECT `description` FROM `tes_certificate` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`certificateId` LIMIT 1) AS `EV__certificateId` FROM `tes_test`)";
                break;
            default:
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`testCity` LIMIT 1) AS `EV__testCity`, (SELECT `description` FROM `tes_certificate` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `tes_test`.`certificateId` LIMIT 1) AS `EV__certificateId` FROM `tes_test`)";
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
            $this->testCity->AdvancedSearch->SearchValue != "" ||
            $this->testCity->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->testCity->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->testCity->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->certificateId->AdvancedSearch->SearchValue != "" ||
            $this->certificateId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->certificateId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->certificateId->VirtualExpression . " ")) {
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
        // Cascade Update detail table 'tes_candidate'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'testId'
            $cascadeUpdate = true;
            $rscascade['testId'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("tes_candidate")->loadRs("`testId` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("tes_candidate")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("tes_candidate")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("tes_candidate")->rowUpdated($rsdtlold, $rsdtlnew);
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

        // Cascade delete detail table 'tes_candidate'
        $dtlrows = Container("tes_candidate")->loadRs("`testId` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("tes_candidate")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("tes_candidate")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("tes_candidate")->rowDeleted($dtlrow);
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
        $this->description->DbValue = $row['description'];
        $this->testCity->DbValue = $row['testCity'];
        $this->federationId->DbValue = $row['federationId'];
        $this->martialartsId->DbValue = $row['martialartsId'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->instructorId->DbValue = $row['instructorId'];
        $this->auxiliarInstructorId->DbValue = $row['auxiliarInstructorId'];
        $this->testDate->DbValue = $row['testDate'];
        $this->testTime->DbValue = $row['testTime'];
        $this->ceremonyDate->DbValue = $row['ceremonyDate'];
        $this->testTypeId->DbValue = $row['testTypeId'];
        $this->testStatusId->DbValue = $row['testStatusId'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->createDate->DbValue = $row['createDate'];
        $this->judgeId->DbValue = $row['judgeId'];
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
        return $_SESSION[$name] ?? GetUrl("TesTestList");
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
        if ($pageName == "TesTestView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TesTestEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TesTestAdd") {
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
                return "TesTestView";
            case Config("API_ADD_ACTION"):
                return "TesTestAdd";
            case Config("API_EDIT_ACTION"):
                return "TesTestEdit";
            case Config("API_DELETE_ACTION"):
                return "TesTestDelete";
            case Config("API_LIST_ACTION"):
                return "TesTestList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TesTestList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TesTestView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TesTestView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TesTestAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TesTestAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TesTestEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TesTestEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("TesTestAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TesTestAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("TesTestDelete", $this->getUrlParm());
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
        $this->description->setDbValue($row['description']);
        $this->testCity->setDbValue($row['testCity']);
        $this->federationId->setDbValue($row['federationId']);
        $this->martialartsId->setDbValue($row['martialartsId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->instructorId->setDbValue($row['instructorId']);
        $this->auxiliarInstructorId->setDbValue($row['auxiliarInstructorId']);
        $this->testDate->setDbValue($row['testDate']);
        $this->testTime->setDbValue($row['testTime']);
        $this->ceremonyDate->setDbValue($row['ceremonyDate']);
        $this->testTypeId->setDbValue($row['testTypeId']);
        $this->testStatusId->setDbValue($row['testStatusId']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->judgeId->setDbValue($row['judgeId']);
        $this->certificateId->setDbValue($row['certificateId']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // description

        // testCity

        // federationId

        // martialartsId

        // schoolId

        // instructorId

        // auxiliarInstructorId

        // testDate

        // testTime

        // ceremonyDate

        // testTypeId

        // testStatusId

        // createUserId

        // createDate

        // judgeId

        // certificateId

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // description
        $this->description->ViewValue = $this->description->CurrentValue;
        $this->description->ViewCustomAttributes = "";

        // testCity
        if ($this->testCity->VirtualValue != "") {
            $this->testCity->ViewValue = $this->testCity->VirtualValue;
        } else {
            $curVal = strval($this->testCity->CurrentValue);
            if ($curVal != "") {
                $this->testCity->ViewValue = $this->testCity->lookupCacheOption($curVal);
                if ($this->testCity->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->testCity->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->testCity->Lookup->renderViewRow($rswrk[0]);
                        $this->testCity->ViewValue = $this->testCity->displayValue($arwrk);
                    } else {
                        $this->testCity->ViewValue = FormatNumber($this->testCity->CurrentValue, $this->testCity->formatPattern());
                    }
                }
            } else {
                $this->testCity->ViewValue = null;
            }
        }
        $this->testCity->ViewCustomAttributes = "";

        // federationId
        $curVal = strval($this->federationId->CurrentValue);
        if ($curVal != "") {
            $this->federationId->ViewValue = $this->federationId->lookupCacheOption($curVal);
            if ($this->federationId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->federationId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->federationId->Lookup->renderViewRow($rswrk[0]);
                    $this->federationId->ViewValue = $this->federationId->displayValue($arwrk);
                } else {
                    $this->federationId->ViewValue = FormatNumber($this->federationId->CurrentValue, $this->federationId->formatPattern());
                }
            }
        } else {
            $this->federationId->ViewValue = null;
        }
        $this->federationId->ViewCustomAttributes = "";

        // martialartsId
        $curVal = strval($this->martialartsId->CurrentValue);
        if ($curVal != "") {
            $this->martialartsId->ViewValue = $this->martialartsId->lookupCacheOption($curVal);
            if ($this->martialartsId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->martialartsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->martialartsId->Lookup->renderViewRow($rswrk[0]);
                    $this->martialartsId->ViewValue = $this->martialartsId->displayValue($arwrk);
                } else {
                    $this->martialartsId->ViewValue = FormatNumber($this->martialartsId->CurrentValue, $this->martialartsId->formatPattern());
                }
            }
        } else {
            $this->martialartsId->ViewValue = null;
        }
        $this->martialartsId->ViewCustomAttributes = "";

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

        // instructorId
        $this->instructorId->ViewValue = $this->instructorId->CurrentValue;
        $curVal = strval($this->instructorId->CurrentValue);
        if ($curVal != "") {
            $this->instructorId->ViewValue = $this->instructorId->lookupCacheOption($curVal);
            if ($this->instructorId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`instructorStatus` = TRUE";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->instructorId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->instructorId->Lookup->renderViewRow($rswrk[0]);
                    $this->instructorId->ViewValue = $this->instructorId->displayValue($arwrk);
                } else {
                    $this->instructorId->ViewValue = FormatNumber($this->instructorId->CurrentValue, $this->instructorId->formatPattern());
                }
            }
        } else {
            $this->instructorId->ViewValue = null;
        }
        $this->instructorId->ViewCustomAttributes = "";

        // auxiliarInstructorId
        $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->CurrentValue;
        $curVal = strval($this->auxiliarInstructorId->CurrentValue);
        if ($curVal != "") {
            $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->lookupCacheOption($curVal);
            if ($this->auxiliarInstructorId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`instructorStatus` = TRUE";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->auxiliarInstructorId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->auxiliarInstructorId->Lookup->renderViewRow($rswrk[0]);
                    $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->displayValue($arwrk);
                } else {
                    $this->auxiliarInstructorId->ViewValue = FormatNumber($this->auxiliarInstructorId->CurrentValue, $this->auxiliarInstructorId->formatPattern());
                }
            }
        } else {
            $this->auxiliarInstructorId->ViewValue = null;
        }
        $this->auxiliarInstructorId->ViewCustomAttributes = "";

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

        // testTypeId
        if (strval($this->testTypeId->CurrentValue) != "") {
            $this->testTypeId->ViewValue = $this->testTypeId->optionCaption($this->testTypeId->CurrentValue);
        } else {
            $this->testTypeId->ViewValue = null;
        }
        $this->testTypeId->ViewCustomAttributes = "";

        // testStatusId
        $this->testStatusId->ViewValue = $this->testStatusId->CurrentValue;
        $curVal = strval($this->testStatusId->CurrentValue);
        if ($curVal != "") {
            $this->testStatusId->ViewValue = $this->testStatusId->lookupCacheOption($curVal);
            if ($this->testStatusId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->testStatusId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->testStatusId->Lookup->renderViewRow($rswrk[0]);
                    $this->testStatusId->ViewValue = $this->testStatusId->displayValue($arwrk);
                } else {
                    $this->testStatusId->ViewValue = FormatNumber($this->testStatusId->CurrentValue, $this->testStatusId->formatPattern());
                }
            }
        } else {
            $this->testStatusId->ViewValue = null;
        }
        $this->testStatusId->ViewCustomAttributes = "";

        // createUserId
        $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
        $curVal = strval($this->createUserId->CurrentValue);
        if ($curVal != "") {
            $this->createUserId->ViewValue = $this->createUserId->lookupCacheOption($curVal);
            if ($this->createUserId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

        // judgeId
        $curVal = strval($this->judgeId->CurrentValue);
        if ($curVal != "") {
            $this->judgeId->ViewValue = $this->judgeId->lookupCacheOption($curVal);
            if ($this->judgeId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->judgeId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->judgeId->Lookup->renderViewRow($rswrk[0]);
                    $this->judgeId->ViewValue = $this->judgeId->displayValue($arwrk);
                } else {
                    $this->judgeId->ViewValue = FormatNumber($this->judgeId->CurrentValue, $this->judgeId->formatPattern());
                }
            }
        } else {
            $this->judgeId->ViewValue = null;
        }
        $this->judgeId->ViewCustomAttributes = "";

        // certificateId
        if ($this->certificateId->VirtualValue != "") {
            $this->certificateId->ViewValue = $this->certificateId->VirtualValue;
        } else {
            $curVal = strval($this->certificateId->CurrentValue);
            if ($curVal != "") {
                $this->certificateId->ViewValue = $this->certificateId->lookupCacheOption($curVal);
                if ($this->certificateId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->certificateId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->certificateId->Lookup->renderViewRow($rswrk[0]);
                        $this->certificateId->ViewValue = $this->certificateId->displayValue($arwrk);
                    } else {
                        $this->certificateId->ViewValue = FormatNumber($this->certificateId->CurrentValue, $this->certificateId->formatPattern());
                    }
                }
            } else {
                $this->certificateId->ViewValue = null;
            }
        }
        $this->certificateId->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // description
        $this->description->LinkCustomAttributes = "";
        $this->description->HrefValue = "";
        $this->description->TooltipValue = "";

        // testCity
        $this->testCity->LinkCustomAttributes = "";
        $this->testCity->HrefValue = "";
        $this->testCity->TooltipValue = "";

        // federationId
        $this->federationId->LinkCustomAttributes = "";
        $this->federationId->HrefValue = "";
        $this->federationId->TooltipValue = "";

        // martialartsId
        $this->martialartsId->LinkCustomAttributes = "";
        $this->martialartsId->HrefValue = "";
        $this->martialartsId->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // instructorId
        $this->instructorId->LinkCustomAttributes = "";
        $this->instructorId->HrefValue = "";
        $this->instructorId->TooltipValue = "";

        // auxiliarInstructorId
        $this->auxiliarInstructorId->LinkCustomAttributes = "";
        $this->auxiliarInstructorId->HrefValue = "";
        $this->auxiliarInstructorId->TooltipValue = "";

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

        // testTypeId
        $this->testTypeId->LinkCustomAttributes = "";
        $this->testTypeId->HrefValue = "";
        $this->testTypeId->TooltipValue = "";

        // testStatusId
        $this->testStatusId->LinkCustomAttributes = "";
        $this->testStatusId->HrefValue = "";
        $this->testStatusId->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

        // judgeId
        $this->judgeId->LinkCustomAttributes = "";
        $this->judgeId->HrefValue = "";
        $this->judgeId->TooltipValue = "";

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

        // id
        $this->id->setupEditAttributes();
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // description
        $this->description->setupEditAttributes();
        $this->description->EditCustomAttributes = "";
        $this->description->EditValue = $this->description->CurrentValue;
        $this->description->PlaceHolder = RemoveHtml($this->description->caption());

        // testCity
        $this->testCity->setupEditAttributes();
        $this->testCity->EditCustomAttributes = "";
        $this->testCity->PlaceHolder = RemoveHtml($this->testCity->caption());

        // federationId
        $this->federationId->setupEditAttributes();
        $this->federationId->EditCustomAttributes = "";
        $this->federationId->PlaceHolder = RemoveHtml($this->federationId->caption());

        // martialartsId
        $this->martialartsId->setupEditAttributes();
        $this->martialartsId->EditCustomAttributes = "";
        $this->martialartsId->PlaceHolder = RemoveHtml($this->martialartsId->caption());

        // schoolId

        // instructorId
        $this->instructorId->setupEditAttributes();
        $this->instructorId->EditCustomAttributes = "";
        $this->instructorId->EditValue = $this->instructorId->CurrentValue;
        $this->instructorId->PlaceHolder = RemoveHtml($this->instructorId->caption());

        // auxiliarInstructorId
        $this->auxiliarInstructorId->setupEditAttributes();
        $this->auxiliarInstructorId->EditCustomAttributes = "";
        $this->auxiliarInstructorId->EditValue = $this->auxiliarInstructorId->CurrentValue;
        $this->auxiliarInstructorId->PlaceHolder = RemoveHtml($this->auxiliarInstructorId->caption());

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

        // testTypeId
        $this->testTypeId->setupEditAttributes();
        $this->testTypeId->EditCustomAttributes = "";
        $this->testTypeId->EditValue = $this->testTypeId->options(true);
        $this->testTypeId->PlaceHolder = RemoveHtml($this->testTypeId->caption());

        // testStatusId
        $this->testStatusId->setupEditAttributes();
        $this->testStatusId->EditCustomAttributes = "";
        $this->testStatusId->EditValue = $this->testStatusId->CurrentValue;
        $this->testStatusId->PlaceHolder = RemoveHtml($this->testStatusId->caption());

        // createUserId

        // createDate

        // judgeId
        $this->judgeId->setupEditAttributes();
        $this->judgeId->EditCustomAttributes = "";
        $this->judgeId->PlaceHolder = RemoveHtml($this->judgeId->caption());

        // certificateId
        $this->certificateId->setupEditAttributes();
        $this->certificateId->EditCustomAttributes = "";
        $this->certificateId->PlaceHolder = RemoveHtml($this->certificateId->caption());

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
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->testCity);
                    $doc->exportCaption($this->federationId);
                    $doc->exportCaption($this->martialartsId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->instructorId);
                    $doc->exportCaption($this->auxiliarInstructorId);
                    $doc->exportCaption($this->testDate);
                    $doc->exportCaption($this->testTime);
                    $doc->exportCaption($this->ceremonyDate);
                    $doc->exportCaption($this->testTypeId);
                    $doc->exportCaption($this->testStatusId);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->judgeId);
                    $doc->exportCaption($this->certificateId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->testCity);
                    $doc->exportCaption($this->federationId);
                    $doc->exportCaption($this->martialartsId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->instructorId);
                    $doc->exportCaption($this->auxiliarInstructorId);
                    $doc->exportCaption($this->testDate);
                    $doc->exportCaption($this->testTime);
                    $doc->exportCaption($this->ceremonyDate);
                    $doc->exportCaption($this->testTypeId);
                    $doc->exportCaption($this->testStatusId);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->judgeId);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->description);
                        $doc->exportField($this->testCity);
                        $doc->exportField($this->federationId);
                        $doc->exportField($this->martialartsId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->instructorId);
                        $doc->exportField($this->auxiliarInstructorId);
                        $doc->exportField($this->testDate);
                        $doc->exportField($this->testTime);
                        $doc->exportField($this->ceremonyDate);
                        $doc->exportField($this->testTypeId);
                        $doc->exportField($this->testStatusId);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->judgeId);
                        $doc->exportField($this->certificateId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->description);
                        $doc->exportField($this->testCity);
                        $doc->exportField($this->federationId);
                        $doc->exportField($this->martialartsId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->instructorId);
                        $doc->exportField($this->auxiliarInstructorId);
                        $doc->exportField($this->testDate);
                        $doc->exportField($this->testTime);
                        $doc->exportField($this->ceremonyDate);
                        $doc->exportField($this->testTypeId);
                        $doc->exportField($this->testStatusId);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->judgeId);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `tes_test`";
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
        $rsnew['federationId'] = CurrentOrganizationID();
        $rsnew['schoolId'] = CurrentUserSchoolID();
        if($rsnew['testTypeId'] > 1){
        	$this->CancelMessage = "Sorry, but you can not create tests with the type different of Local and Regional!";
        	return false;
        }
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
        try{
                 if (isset($rsnew['id'])) {
                            Execute("INSERT INTO tes_candidate
                            (
                            memberId
                            ,testId
                            ,rankId
                            ,nextrankId
                            ,testNominated
                            ,memberAge
                            ,schoolId
                            ,createUseriD
                            ,createDate
                            ,memberDOB
                            )
                            SELECT 
                                    school_member.id
                                    ,".$rsnew['id']."
                                    ,school_member.rankId 
                                    ,fed_rank.nextrankId
                                    ,true
                                    ,(year(CURRENT_DATE()) - year(school_member.birthdate))
                                    ,".CurrentUserID()."
                                    ,".GetLoggedUserID()."
                                    ,'".CurrentDate()."'
                                    ,school_member.birthdate  
                                FROM fed_rank INNER JOIN school_member ON school_member.rankId = fed_rank.id 
                                WHERE school_member.martialArtId = ".$rsnew['martialartsId']." AND school_member.memberStatusId = 1
                                AND school_member.schoolId = ".CurrentUserSchoolID()." ");
                        }
          }catch(Exception $e){
                    Log("Erro inserindo alunos do exame:".$e);
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
