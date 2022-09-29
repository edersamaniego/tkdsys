<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for school_member
 */
class SchoolMember extends DbTable
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
    public $birthdate;
    public $gender;
    public $address;
    public $neighborhood;
    public $countryId;
    public $UFId;
    public $cityId;
    public $zip;
    public $celphone;
    public $_email;
    public $facebook;
    public $instagram;
    public $father;
    public $fatherCellphone;
    public $receiveSmsFather;
    public $fatherEmail;
    public $receiveEmailFather;
    public $fatherOccupation;
    public $fatherBirthdate;
    public $mother;
    public $motherCellphone;
    public $receiveSmsMother;
    public $motherEmail;
    public $receiveEmailMother;
    public $motherOccupation;
    public $motherBirthdate;
    public $emergencyContact;
    public $emergencyFone;
    public $obs;
    public $modalityId;
    public $instructorStatus;
    public $martialArtId;
    public $rankId;
    public $schoolId;
    public $memberStatusId;
    public $photo;
    public $beltSize;
    public $dobokSize;
    public $programId;
    public $classId;
    public $federationRegister;
    public $memberLevelId;
    public $instructorLevelId;
    public $judgeLevelId;
    public $federationRegisterDate;
    public $federationStatus;
    public $createDate;
    public $createUserId;
    public $lastUpdate;
    public $lastUserId;
    public $marketingSourceId;
    public $marketingSourceDetail;
    public $memberTypeId;
    public $schoolUserId;
    public $age;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'school_member';
        $this->TableName = 'school_member';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`school_member`";
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
            'school_member',
            'school_member',
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
            'school_member',
            'school_member',
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
            'school_member',
            'school_member',
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

        // birthdate
        $this->birthdate = new DbField(
            'school_member',
            'school_member',
            'x_birthdate',
            'birthdate',
            '`birthdate`',
            CastDateFieldForLike("`birthdate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`birthdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->birthdate->InputTextType = "text";
        $this->birthdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['birthdate'] = &$this->birthdate;

        // gender
        $this->gender = new DbField(
            'school_member',
            'school_member',
            'x_gender',
            'gender',
            '`gender`',
            '`gender`',
            200,
            1,
            -1,
            false,
            '`gender`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->gender->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->gender->Lookup = new Lookup('gender', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->gender->Lookup = new Lookup('gender', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->gender->Lookup = new Lookup('gender', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->gender->Lookup = new Lookup('gender', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->gender->OptionCount = 3;
        $this->Fields['gender'] = &$this->gender;

        // address
        $this->address = new DbField(
            'school_member',
            'school_member',
            'x_address',
            'address',
            '`address`',
            '`address`',
            200,
            100,
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
            'school_member',
            'school_member',
            'x_neighborhood',
            'neighborhood',
            '`neighborhood`',
            '`neighborhood`',
            200,
            100,
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

        // countryId
        $this->countryId = new DbField(
            'school_member',
            'school_member',
            'x_countryId',
            'countryId',
            '`countryId`',
            '`countryId`',
            3,
            11,
            -1,
            false,
            '`EV__countryId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->countryId->InputTextType = "text";
        $this->countryId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->countryId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], [], [], '', '', "`country`");
                break;
            case "pt-BR":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], [], [], '', '', "`country`");
                break;
            case "es":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], [], [], '', '', "`country`");
                break;
            default:
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], [], [], '', '', "`country`");
                break;
        }
        $this->countryId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['countryId'] = &$this->countryId;

        // UFId
        $this->UFId = new DbField(
            'school_member',
            'school_member',
            'x_UFId',
            'UFId',
            '`UFId`',
            '`UFId`',
            3,
            11,
            -1,
            false,
            '`EV__UFId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->UFId->InputTextType = "text";
        $this->UFId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->UFId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], [], [], '', '', "`UF`");
                break;
            case "pt-BR":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], [], [], '', '', "`UF`");
                break;
            case "es":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], [], [], '', '', "`UF`");
                break;
            default:
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], [], [], '', '', "`UF`");
                break;
        }
        $this->UFId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['UFId'] = &$this->UFId;

        // cityId
        $this->cityId = new DbField(
            'school_member',
            'school_member',
            'x_cityId',
            'cityId',
            '`cityId`',
            '`cityId`',
            3,
            11,
            -1,
            false,
            '`EV__cityId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->cityId->InputTextType = "text";
        $this->cityId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cityId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,''))");
                break;
            case "pt-BR":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,''))");
                break;
            case "es":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,''))");
                break;
            default:
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,''))");
                break;
        }
        $this->cityId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cityId'] = &$this->cityId;

        // zip
        $this->zip = new DbField(
            'school_member',
            'school_member',
            'x_zip',
            'zip',
            '`zip`',
            '`zip`',
            200,
            45,
            -1,
            false,
            '`zip`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->zip->InputTextType = "text";
        $this->Fields['zip'] = &$this->zip;

        // celphone
        $this->celphone = new DbField(
            'school_member',
            'school_member',
            'x_celphone',
            'celphone',
            '`celphone`',
            '`celphone`',
            200,
            45,
            -1,
            false,
            '`celphone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->celphone->InputTextType = "text";
        $this->Fields['celphone'] = &$this->celphone;

        // email
        $this->_email = new DbField(
            'school_member',
            'school_member',
            'x__email',
            'email',
            '`email`',
            '`email`',
            200,
            100,
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
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->Fields['email'] = &$this->_email;

        // facebook
        $this->facebook = new DbField(
            'school_member',
            'school_member',
            'x_facebook',
            'facebook',
            '`facebook`',
            '`facebook`',
            200,
            100,
            -1,
            false,
            '`facebook`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->facebook->InputTextType = "text";
        $this->Fields['facebook'] = &$this->facebook;

        // instagram
        $this->instagram = new DbField(
            'school_member',
            'school_member',
            'x_instagram',
            'instagram',
            '`instagram`',
            '`instagram`',
            200,
            100,
            -1,
            false,
            '`instagram`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instagram->InputTextType = "text";
        $this->Fields['instagram'] = &$this->instagram;

        // father
        $this->father = new DbField(
            'school_member',
            'school_member',
            'x_father',
            'father',
            '`father`',
            '`father`',
            200,
            100,
            -1,
            false,
            '`father`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->father->InputTextType = "text";
        $this->Fields['father'] = &$this->father;

        // fatherCellphone
        $this->fatherCellphone = new DbField(
            'school_member',
            'school_member',
            'x_fatherCellphone',
            'fatherCellphone',
            '`fatherCellphone`',
            '`fatherCellphone`',
            200,
            100,
            -1,
            false,
            '`fatherCellphone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fatherCellphone->InputTextType = "text";
        $this->Fields['fatherCellphone'] = &$this->fatherCellphone;

        // receiveSmsFather
        $this->receiveSmsFather = new DbField(
            'school_member',
            'school_member',
            'x_receiveSmsFather',
            'receiveSmsFather',
            '`receiveSmsFather`',
            '`receiveSmsFather`',
            3,
            11,
            -1,
            false,
            '`receiveSmsFather`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->receiveSmsFather->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->receiveSmsFather->Lookup = new Lookup('receiveSmsFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->receiveSmsFather->Lookup = new Lookup('receiveSmsFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->receiveSmsFather->Lookup = new Lookup('receiveSmsFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->receiveSmsFather->Lookup = new Lookup('receiveSmsFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->receiveSmsFather->OptionCount = 2;
        $this->receiveSmsFather->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receiveSmsFather'] = &$this->receiveSmsFather;

        // fatherEmail
        $this->fatherEmail = new DbField(
            'school_member',
            'school_member',
            'x_fatherEmail',
            'fatherEmail',
            '`fatherEmail`',
            '`fatherEmail`',
            200,
            100,
            -1,
            false,
            '`fatherEmail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fatherEmail->InputTextType = "text";
        $this->fatherEmail->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->Fields['fatherEmail'] = &$this->fatherEmail;

        // receiveEmailFather
        $this->receiveEmailFather = new DbField(
            'school_member',
            'school_member',
            'x_receiveEmailFather',
            'receiveEmailFather',
            '`receiveEmailFather`',
            '`receiveEmailFather`',
            3,
            11,
            -1,
            false,
            '`receiveEmailFather`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->receiveEmailFather->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->receiveEmailFather->Lookup = new Lookup('receiveEmailFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->receiveEmailFather->Lookup = new Lookup('receiveEmailFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->receiveEmailFather->Lookup = new Lookup('receiveEmailFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->receiveEmailFather->Lookup = new Lookup('receiveEmailFather', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->receiveEmailFather->OptionCount = 2;
        $this->receiveEmailFather->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receiveEmailFather'] = &$this->receiveEmailFather;

        // fatherOccupation
        $this->fatherOccupation = new DbField(
            'school_member',
            'school_member',
            'x_fatherOccupation',
            'fatherOccupation',
            '`fatherOccupation`',
            '`fatherOccupation`',
            200,
            100,
            -1,
            false,
            '`fatherOccupation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fatherOccupation->InputTextType = "text";
        $this->Fields['fatherOccupation'] = &$this->fatherOccupation;

        // fatherBirthdate
        $this->fatherBirthdate = new DbField(
            'school_member',
            'school_member',
            'x_fatherBirthdate',
            'fatherBirthdate',
            '`fatherBirthdate`',
            CastDateFieldForLike("`fatherBirthdate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`fatherBirthdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->fatherBirthdate->InputTextType = "text";
        $this->fatherBirthdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['fatherBirthdate'] = &$this->fatherBirthdate;

        // mother
        $this->mother = new DbField(
            'school_member',
            'school_member',
            'x_mother',
            'mother',
            '`mother`',
            '`mother`',
            200,
            100,
            -1,
            false,
            '`mother`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->mother->InputTextType = "text";
        $this->Fields['mother'] = &$this->mother;

        // motherCellphone
        $this->motherCellphone = new DbField(
            'school_member',
            'school_member',
            'x_motherCellphone',
            'motherCellphone',
            '`motherCellphone`',
            '`motherCellphone`',
            200,
            100,
            -1,
            false,
            '`motherCellphone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->motherCellphone->InputTextType = "text";
        $this->Fields['motherCellphone'] = &$this->motherCellphone;

        // receiveSmsMother
        $this->receiveSmsMother = new DbField(
            'school_member',
            'school_member',
            'x_receiveSmsMother',
            'receiveSmsMother',
            '`receiveSmsMother`',
            '`receiveSmsMother`',
            3,
            11,
            -1,
            false,
            '`receiveSmsMother`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->receiveSmsMother->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->receiveSmsMother->Lookup = new Lookup('receiveSmsMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->receiveSmsMother->Lookup = new Lookup('receiveSmsMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->receiveSmsMother->Lookup = new Lookup('receiveSmsMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->receiveSmsMother->Lookup = new Lookup('receiveSmsMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->receiveSmsMother->OptionCount = 2;
        $this->receiveSmsMother->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receiveSmsMother'] = &$this->receiveSmsMother;

        // motherEmail
        $this->motherEmail = new DbField(
            'school_member',
            'school_member',
            'x_motherEmail',
            'motherEmail',
            '`motherEmail`',
            '`motherEmail`',
            200,
            100,
            -1,
            false,
            '`motherEmail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->motherEmail->InputTextType = "text";
        $this->motherEmail->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->Fields['motherEmail'] = &$this->motherEmail;

        // receiveEmailMother
        $this->receiveEmailMother = new DbField(
            'school_member',
            'school_member',
            'x_receiveEmailMother',
            'receiveEmailMother',
            '`receiveEmailMother`',
            '`receiveEmailMother`',
            3,
            11,
            -1,
            false,
            '`receiveEmailMother`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->receiveEmailMother->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->receiveEmailMother->Lookup = new Lookup('receiveEmailMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->receiveEmailMother->Lookup = new Lookup('receiveEmailMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->receiveEmailMother->Lookup = new Lookup('receiveEmailMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->receiveEmailMother->Lookup = new Lookup('receiveEmailMother', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->receiveEmailMother->OptionCount = 2;
        $this->receiveEmailMother->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['receiveEmailMother'] = &$this->receiveEmailMother;

        // motherOccupation
        $this->motherOccupation = new DbField(
            'school_member',
            'school_member',
            'x_motherOccupation',
            'motherOccupation',
            '`motherOccupation`',
            '`motherOccupation`',
            200,
            100,
            -1,
            false,
            '`motherOccupation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->motherOccupation->InputTextType = "text";
        $this->Fields['motherOccupation'] = &$this->motherOccupation;

        // motherBirthdate
        $this->motherBirthdate = new DbField(
            'school_member',
            'school_member',
            'x_motherBirthdate',
            'motherBirthdate',
            '`motherBirthdate`',
            CastDateFieldForLike("`motherBirthdate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`motherBirthdate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->motherBirthdate->InputTextType = "text";
        $this->motherBirthdate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['motherBirthdate'] = &$this->motherBirthdate;

        // emergencyContact
        $this->emergencyContact = new DbField(
            'school_member',
            'school_member',
            'x_emergencyContact',
            'emergencyContact',
            '`emergencyContact`',
            '`emergencyContact`',
            200,
            100,
            -1,
            false,
            '`emergencyContact`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->emergencyContact->InputTextType = "text";
        $this->Fields['emergencyContact'] = &$this->emergencyContact;

        // emergencyFone
        $this->emergencyFone = new DbField(
            'school_member',
            'school_member',
            'x_emergencyFone',
            'emergencyFone',
            '`emergencyFone`',
            '`emergencyFone`',
            200,
            45,
            -1,
            false,
            '`emergencyFone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->emergencyFone->InputTextType = "text";
        $this->Fields['emergencyFone'] = &$this->emergencyFone;

        // obs
        $this->obs = new DbField(
            'school_member',
            'school_member',
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

        // modalityId
        $this->modalityId = new DbField(
            'school_member',
            'school_member',
            'x_modalityId',
            'modalityId',
            '`modalityId`',
            '`modalityId`',
            3,
            11,
            -1,
            false,
            '`EV__modalityId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->modalityId->InputTextType = "text";
        $this->modalityId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->modalityId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->modalityId->Lookup = new Lookup('modalityId', 'school_modality', false, 'id', ["nameEN","","",""], [], [], [], [], [], [], '', '', "`nameEN`");
                break;
            case "pt-BR":
                $this->modalityId->Lookup = new Lookup('modalityId', 'school_modality', false, 'id', ["nameBR","","",""], [], [], [], [], [], [], '', '', "`nameBR`");
                break;
            case "es":
                $this->modalityId->Lookup = new Lookup('modalityId', 'school_modality', false, 'id', ["nameES","","",""], [], [], [], [], [], [], '', '', "`nameES`");
                break;
            default:
                $this->modalityId->Lookup = new Lookup('modalityId', 'school_modality', false, 'id', ["nameEN","","",""], [], [], [], [], [], [], '', '', "`nameEN`");
                break;
        }
        $this->modalityId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['modalityId'] = &$this->modalityId;

        // instructorStatus
        $this->instructorStatus = new DbField(
            'school_member',
            'school_member',
            'x_instructorStatus',
            'instructorStatus',
            '`instructorStatus`',
            '`instructorStatus`',
            16,
            1,
            -1,
            false,
            '`instructorStatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->instructorStatus->InputTextType = "text";
        $this->instructorStatus->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->instructorStatus->Lookup = new Lookup('instructorStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->instructorStatus->Lookup = new Lookup('instructorStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->instructorStatus->Lookup = new Lookup('instructorStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->instructorStatus->Lookup = new Lookup('instructorStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->instructorStatus->OptionCount = 2;
        $this->instructorStatus->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['instructorStatus'] = &$this->instructorStatus;

        // martialArtId
        $this->martialArtId = new DbField(
            'school_member',
            'school_member',
            'x_martialArtId',
            'martialArtId',
            '`martialArtId`',
            '`martialArtId`',
            3,
            11,
            -1,
            false,
            '`martialArtId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->martialArtId->InputTextType = "text";
        $this->martialArtId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->martialArtId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_rankId"], [], [], ["id"], ["x_rankId"], '', '', "`martialArts`");
                break;
            case "pt-BR":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_rankId"], [], [], ["id"], ["x_rankId"], '', '', "`martialArts`");
                break;
            case "es":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_rankId"], [], [], ["id"], ["x_rankId"], '', '', "`martialArts`");
                break;
            default:
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], ["x_rankId"], [], [], ["id"], ["x_rankId"], '', '', "`martialArts`");
                break;
        }
        $this->martialArtId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['martialArtId'] = &$this->martialArtId;

        // rankId
        $this->rankId = new DbField(
            'school_member',
            'school_member',
            'x_rankId',
            'rankId',
            '`rankId`',
            '`rankId`',
            3,
            11,
            -1,
            false,
            '`rankId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->rankId->InputTextType = "text";
        $this->rankId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->rankId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->rankId->Lookup = new Lookup('rankId', 'fed_rank', false, 'id', ["rankUS","","",""], ["x_martialArtId"], [], ["martialArtsId"], ["x_martialArtsId"], [], [], '', '', "`rankUS`");
                break;
            case "pt-BR":
                $this->rankId->Lookup = new Lookup('rankId', 'fed_rank', false, 'id', ["rankBR","","",""], ["x_martialArtId"], [], ["martialArtsId"], ["x_martialArtsId"], [], [], '', '', "`rankBR`");
                break;
            case "es":
                $this->rankId->Lookup = new Lookup('rankId', 'fed_rank', false, 'id', ["rankES","","",""], ["x_martialArtId"], [], ["martialArtsId"], ["x_martialArtsId"], [], [], '', '', "`rankES`");
                break;
            default:
                $this->rankId->Lookup = new Lookup('rankId', 'fed_rank', false, 'id', ["rankUS","","",""], ["x_martialArtId"], [], ["martialArtsId"], ["x_martialArtsId"], [], [], '', '', "`rankUS`");
                break;
        }
        $this->rankId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['rankId'] = &$this->rankId;

        // schoolId
        $this->schoolId = new DbField(
            'school_member',
            'school_member',
            'x_schoolId',
            'schoolId',
            '`schoolId`',
            '`schoolId`',
            3,
            11,
            -1,
            false,
            '`EV__schoolId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->schoolId->InputTextType = "text";
        $this->schoolId->IsForeignKey = true; // Foreign key field
        $this->schoolId->Nullable = false; // NOT NULL field
        $this->schoolId->Required = true; // Required field
        $this->schoolId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->schoolId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
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

        // memberStatusId
        $this->memberStatusId = new DbField(
            'school_member',
            'school_member',
            'x_memberStatusId',
            'memberStatusId',
            '`memberStatusId`',
            '`memberStatusId`',
            3,
            11,
            -1,
            false,
            '`memberStatusId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->memberStatusId->InputTextType = "text";
        $this->memberStatusId->Nullable = false; // NOT NULL field
        $this->memberStatusId->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->memberStatusId->Lookup = new Lookup('memberStatusId', 'conf_memberstatus', false, 'id', ["statusEN","","",""], [], [], [], [], [], [], '', '', "`statusEN`");
                break;
            case "pt-BR":
                $this->memberStatusId->Lookup = new Lookup('memberStatusId', 'conf_memberstatus', false, 'id', ["status","","",""], [], [], [], [], [], [], '', '', "`status`");
                break;
            case "es":
                $this->memberStatusId->Lookup = new Lookup('memberStatusId', 'conf_memberstatus', false, 'id', ["statusES","","",""], [], [], [], [], [], [], '', '', "`statusES`");
                break;
            default:
                $this->memberStatusId->Lookup = new Lookup('memberStatusId', 'conf_memberstatus', false, 'id', ["status","","",""], [], [], [], [], [], [], '', '', "`status`");
                break;
        }
        $this->memberStatusId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['memberStatusId'] = &$this->memberStatusId;

        // photo
        $this->photo = new DbField(
            'school_member',
            'school_member',
            'x_photo',
            'photo',
            '`photo`',
            '`photo`',
            200,
            45,
            -1,
            true,
            '`photo`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->photo->InputTextType = "text";
        $this->photo->ImageResize = true;
        $this->photo->UploadPath = "files/fotos";
        $this->Fields['photo'] = &$this->photo;

        // beltSize
        $this->beltSize = new DbField(
            'school_member',
            'school_member',
            'x_beltSize',
            'beltSize',
            '`beltSize`',
            '`beltSize`',
            200,
            255,
            -1,
            false,
            '`beltSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->beltSize->InputTextType = "text";
        $this->Fields['beltSize'] = &$this->beltSize;

        // dobokSize
        $this->dobokSize = new DbField(
            'school_member',
            'school_member',
            'x_dobokSize',
            'dobokSize',
            '`dobokSize`',
            '`dobokSize`',
            200,
            6,
            -1,
            false,
            '`dobokSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dobokSize->InputTextType = "text";
        $this->Fields['dobokSize'] = &$this->dobokSize;

        // programId
        $this->programId = new DbField(
            'school_member',
            'school_member',
            'x_programId',
            'programId',
            '`programId`',
            '`programId`',
            3,
            11,
            -1,
            false,
            '`programId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->programId->InputTextType = "text";
        $this->programId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->programId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->programId->Lookup = new Lookup('programId', 'school_program', false, 'id', ["program","","",""], [], [], [], [], [], [], '', '', "`program`");
                break;
            case "pt-BR":
                $this->programId->Lookup = new Lookup('programId', 'school_program', false, 'id', ["program","","",""], [], [], [], [], [], [], '', '', "`program`");
                break;
            case "es":
                $this->programId->Lookup = new Lookup('programId', 'school_program', false, 'id', ["program","","",""], [], [], [], [], [], [], '', '', "`program`");
                break;
            default:
                $this->programId->Lookup = new Lookup('programId', 'school_program', false, 'id', ["program","","",""], [], [], [], [], [], [], '', '', "`program`");
                break;
        }
        $this->programId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['programId'] = &$this->programId;

        // classId
        $this->classId = new DbField(
            'school_member',
            'school_member',
            'x_classId',
            'classId',
            '`classId`',
            '`classId`',
            3,
            11,
            -1,
            false,
            '`classId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->classId->InputTextType = "text";
        $this->classId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->classId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->classId->Lookup = new Lookup('classId', 'school_class', false, 'id', ["daysByWeek","beginnigTime","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`daysByWeek`, ''),'" . ValueSeparator(1, $this->classId) . "',COALESCE(" . CastDateFieldForLike("`beginnigTime`", 4, "DB") . ",''))");
                break;
            case "pt-BR":
                $this->classId->Lookup = new Lookup('classId', 'school_class', false, 'id', ["daysByWeek","beginnigTime","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`daysByWeek`, ''),'" . ValueSeparator(1, $this->classId) . "',COALESCE(" . CastDateFieldForLike("`beginnigTime`", 4, "DB") . ",''))");
                break;
            case "es":
                $this->classId->Lookup = new Lookup('classId', 'school_class', false, 'id', ["daysByWeek","beginnigTime","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`daysByWeek`, ''),'" . ValueSeparator(1, $this->classId) . "',COALESCE(" . CastDateFieldForLike("`beginnigTime`", 4, "DB") . ",''))");
                break;
            default:
                $this->classId->Lookup = new Lookup('classId', 'school_class', false, 'id', ["daysByWeek","beginnigTime","",""], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`daysByWeek`, ''),'" . ValueSeparator(1, $this->classId) . "',COALESCE(" . CastDateFieldForLike("`beginnigTime`", 4, "DB") . ",''))");
                break;
        }
        $this->classId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['classId'] = &$this->classId;

        // federationRegister
        $this->federationRegister = new DbField(
            'school_member',
            'school_member',
            'x_federationRegister',
            'federationRegister',
            '`federationRegister`',
            '`federationRegister`',
            200,
            45,
            -1,
            false,
            '`federationRegister`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->federationRegister->InputTextType = "text";
        $this->Fields['federationRegister'] = &$this->federationRegister;

        // memberLevelId
        $this->memberLevelId = new DbField(
            'school_member',
            'school_member',
            'x_memberLevelId',
            'memberLevelId',
            '`memberLevelId`',
            '`memberLevelId`',
            3,
            11,
            -1,
            false,
            '`memberLevelId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->memberLevelId->InputTextType = "text";
        $this->memberLevelId->Nullable = false; // NOT NULL field
        $this->memberLevelId->Required = true; // Required field
        $this->memberLevelId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->memberLevelId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->memberLevelId->Lookup = new Lookup('memberLevelId', 'fed_memberlevel', false, 'id', ["descriptionEN","","",""], [], [], [], [], [], [], '', '', "`descriptionEN`");
                break;
            case "pt-BR":
                $this->memberLevelId->Lookup = new Lookup('memberLevelId', 'fed_memberlevel', false, 'id', ["descriptionBR","","",""], [], [], [], [], [], [], '', '', "`descriptionBR`");
                break;
            case "es":
                $this->memberLevelId->Lookup = new Lookup('memberLevelId', 'fed_memberlevel', false, 'id', ["descriptionES","","",""], [], [], [], [], [], [], '', '', "`descriptionES`");
                break;
            default:
                $this->memberLevelId->Lookup = new Lookup('memberLevelId', 'fed_memberlevel', false, 'id', ["memberLevel","","",""], [], [], [], [], [], [], '', '', "`memberLevel`");
                break;
        }
        $this->memberLevelId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['memberLevelId'] = &$this->memberLevelId;

        // instructorLevelId
        $this->instructorLevelId = new DbField(
            'school_member',
            'school_member',
            'x_instructorLevelId',
            'instructorLevelId',
            '`instructorLevelId`',
            '`instructorLevelId`',
            3,
            11,
            -1,
            false,
            '`instructorLevelId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->instructorLevelId->InputTextType = "text";
        $this->instructorLevelId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->instructorLevelId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->instructorLevelId->Lookup = new Lookup('instructorLevelId', 'fed_instructorlevels', false, 'id', ["level","","",""], [], [], [], [], [], [], '', '', "`level`");
                break;
            case "pt-BR":
                $this->instructorLevelId->Lookup = new Lookup('instructorLevelId', 'fed_instructorlevels', false, 'id', ["level","","",""], [], [], [], [], [], [], '', '', "`level`");
                break;
            case "es":
                $this->instructorLevelId->Lookup = new Lookup('instructorLevelId', 'fed_instructorlevels', false, 'id', ["level","","",""], [], [], [], [], [], [], '', '', "`level`");
                break;
            default:
                $this->instructorLevelId->Lookup = new Lookup('instructorLevelId', 'fed_instructorlevels', false, 'id', ["level","","",""], [], [], [], [], [], [], '', '', "`level`");
                break;
        }
        $this->instructorLevelId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['instructorLevelId'] = &$this->instructorLevelId;

        // judgeLevelId
        $this->judgeLevelId = new DbField(
            'school_member',
            'school_member',
            'x_judgeLevelId',
            'judgeLevelId',
            '`judgeLevelId`',
            '`judgeLevelId`',
            3,
            11,
            -1,
            false,
            '`judgeLevelId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->judgeLevelId->InputTextType = "text";
        $this->judgeLevelId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->judgeLevelId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->judgeLevelId->Lookup = new Lookup('judgeLevelId', 'fed_judgelevel', false, 'id', ["judgeLevel","","",""], [], [], [], [], [], [], '', '', "`judgeLevel`");
                break;
            case "pt-BR":
                $this->judgeLevelId->Lookup = new Lookup('judgeLevelId', 'fed_judgelevel', false, 'id', ["judgeLevel","","",""], [], [], [], [], [], [], '', '', "`judgeLevel`");
                break;
            case "es":
                $this->judgeLevelId->Lookup = new Lookup('judgeLevelId', 'fed_judgelevel', false, 'id', ["judgeLevel","","",""], [], [], [], [], [], [], '', '', "`judgeLevel`");
                break;
            default:
                $this->judgeLevelId->Lookup = new Lookup('judgeLevelId', 'fed_judgelevel', false, 'id', ["judgeLevel","","",""], [], [], [], [], [], [], '', '', "`judgeLevel`");
                break;
        }
        $this->judgeLevelId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['judgeLevelId'] = &$this->judgeLevelId;

        // federationRegisterDate
        $this->federationRegisterDate = new DbField(
            'school_member',
            'school_member',
            'x_federationRegisterDate',
            'federationRegisterDate',
            '`federationRegisterDate`',
            CastDateFieldForLike("`federationRegisterDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`federationRegisterDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->federationRegisterDate->InputTextType = "text";
        $this->federationRegisterDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['federationRegisterDate'] = &$this->federationRegisterDate;

        // federationStatus
        $this->federationStatus = new DbField(
            'school_member',
            'school_member',
            'x_federationStatus',
            'federationStatus',
            '`federationStatus`',
            '`federationStatus`',
            16,
            1,
            -1,
            false,
            '`federationStatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->federationStatus->InputTextType = "text";
        $this->federationStatus->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->federationStatus->Lookup = new Lookup('federationStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->federationStatus->Lookup = new Lookup('federationStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->federationStatus->Lookup = new Lookup('federationStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->federationStatus->Lookup = new Lookup('federationStatus', 'school_member', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->federationStatus->OptionCount = 2;
        $this->federationStatus->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['federationStatus'] = &$this->federationStatus;

        // createDate
        $this->createDate = new DbField(
            'school_member',
            'school_member',
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

        // createUserId
        $this->createUserId = new DbField(
            'school_member',
            'school_member',
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

        // lastUpdate
        $this->lastUpdate = new DbField(
            'school_member',
            'school_member',
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

        // lastUserId
        $this->lastUserId = new DbField(
            'school_member',
            'school_member',
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
        $this->lastUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['lastUserId'] = &$this->lastUserId;

        // marketingSourceId
        $this->marketingSourceId = new DbField(
            'school_member',
            'school_member',
            'x_marketingSourceId',
            'marketingSourceId',
            '`marketingSourceId`',
            '`marketingSourceId`',
            3,
            11,
            -1,
            false,
            '`marketingSourceId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->marketingSourceId->InputTextType = "text";
        $this->marketingSourceId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->marketingSourceId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->marketingSourceId->Lookup = new Lookup('marketingSourceId', 'conf_marketingsource', false, 'id', ["marketingsourceEN","","",""], [], [], [], [], [], [], '', '', "`marketingsourceEN`");
                break;
            case "pt-BR":
                $this->marketingSourceId->Lookup = new Lookup('marketingSourceId', 'conf_marketingsource', false, 'id', ["marketingsourceEN","","",""], [], [], [], [], [], [], '', '', "`marketingsourceEN`");
                break;
            case "es":
                $this->marketingSourceId->Lookup = new Lookup('marketingSourceId', 'conf_marketingsource', false, 'id', ["marketingsourceEN","","",""], [], [], [], [], [], [], '', '', "`marketingsourceEN`");
                break;
            default:
                $this->marketingSourceId->Lookup = new Lookup('marketingSourceId', 'conf_marketingsource', false, 'id', ["marketingsourceEN","","",""], [], [], [], [], [], [], '', '', "`marketingsourceEN`");
                break;
        }
        $this->marketingSourceId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['marketingSourceId'] = &$this->marketingSourceId;

        // marketingSourceDetail
        $this->marketingSourceDetail = new DbField(
            'school_member',
            'school_member',
            'x_marketingSourceDetail',
            'marketingSourceDetail',
            '`marketingSourceDetail`',
            '`marketingSourceDetail`',
            200,
            255,
            -1,
            false,
            '`marketingSourceDetail`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->marketingSourceDetail->InputTextType = "text";
        $this->Fields['marketingSourceDetail'] = &$this->marketingSourceDetail;

        // memberTypeId
        $this->memberTypeId = new DbField(
            'school_member',
            'school_member',
            'x_memberTypeId',
            'memberTypeId',
            '`memberTypeId`',
            '`memberTypeId`',
            3,
            11,
            -1,
            false,
            '`memberTypeId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->memberTypeId->InputTextType = "text";
        $this->memberTypeId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['memberTypeId'] = &$this->memberTypeId;

        // schoolUserId
        $this->schoolUserId = new DbField(
            'school_member',
            'school_member',
            'x_schoolUserId',
            'schoolUserId',
            '`schoolUserId`',
            '`schoolUserId`',
            3,
            11,
            -1,
            false,
            '`schoolUserId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->schoolUserId->InputTextType = "text";
        $this->schoolUserId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolUserId'] = &$this->schoolUserId;

        // age
        $this->age = new DbField(
            'school_member',
            'school_member',
            'x_age',
            'age',
            '`age`',
            '`age`',
            3,
            11,
            -1,
            false,
            '`age`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->age->InputTextType = "text";
        $this->age->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['age'] = &$this->age;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`school_member`";
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
                $from = "(SELECT *,  FROM `school_member`)";
                break;
            case "pt-BR":
                $from = "(SELECT *,  FROM `school_member`)";
                break;
            case "es":
                $from = "(SELECT *,  FROM `school_member`)";
                break;
            default:
                $from = "(SELECT *,  FROM `school_member`)";
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
            $this->countryId->AdvancedSearch->SearchValue != "" ||
            $this->countryId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->countryId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->countryId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->UFId->AdvancedSearch->SearchValue != "" ||
            $this->UFId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->UFId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->UFId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->cityId->AdvancedSearch->SearchValue != "" ||
            $this->cityId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->cityId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->cityId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->modalityId->AdvancedSearch->SearchValue != "" ||
            $this->modalityId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->modalityId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->modalityId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->schoolId->AdvancedSearch->SearchValue != "" ||
            $this->schoolId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->schoolId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->schoolId->VirtualExpression . " ")) {
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
        $this->birthdate->DbValue = $row['birthdate'];
        $this->gender->DbValue = $row['gender'];
        $this->address->DbValue = $row['address'];
        $this->neighborhood->DbValue = $row['neighborhood'];
        $this->countryId->DbValue = $row['countryId'];
        $this->UFId->DbValue = $row['UFId'];
        $this->cityId->DbValue = $row['cityId'];
        $this->zip->DbValue = $row['zip'];
        $this->celphone->DbValue = $row['celphone'];
        $this->_email->DbValue = $row['email'];
        $this->facebook->DbValue = $row['facebook'];
        $this->instagram->DbValue = $row['instagram'];
        $this->father->DbValue = $row['father'];
        $this->fatherCellphone->DbValue = $row['fatherCellphone'];
        $this->receiveSmsFather->DbValue = $row['receiveSmsFather'];
        $this->fatherEmail->DbValue = $row['fatherEmail'];
        $this->receiveEmailFather->DbValue = $row['receiveEmailFather'];
        $this->fatherOccupation->DbValue = $row['fatherOccupation'];
        $this->fatherBirthdate->DbValue = $row['fatherBirthdate'];
        $this->mother->DbValue = $row['mother'];
        $this->motherCellphone->DbValue = $row['motherCellphone'];
        $this->receiveSmsMother->DbValue = $row['receiveSmsMother'];
        $this->motherEmail->DbValue = $row['motherEmail'];
        $this->receiveEmailMother->DbValue = $row['receiveEmailMother'];
        $this->motherOccupation->DbValue = $row['motherOccupation'];
        $this->motherBirthdate->DbValue = $row['motherBirthdate'];
        $this->emergencyContact->DbValue = $row['emergencyContact'];
        $this->emergencyFone->DbValue = $row['emergencyFone'];
        $this->obs->DbValue = $row['obs'];
        $this->modalityId->DbValue = $row['modalityId'];
        $this->instructorStatus->DbValue = $row['instructorStatus'];
        $this->martialArtId->DbValue = $row['martialArtId'];
        $this->rankId->DbValue = $row['rankId'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->memberStatusId->DbValue = $row['memberStatusId'];
        $this->photo->Upload->DbValue = $row['photo'];
        $this->beltSize->DbValue = $row['beltSize'];
        $this->dobokSize->DbValue = $row['dobokSize'];
        $this->programId->DbValue = $row['programId'];
        $this->classId->DbValue = $row['classId'];
        $this->federationRegister->DbValue = $row['federationRegister'];
        $this->memberLevelId->DbValue = $row['memberLevelId'];
        $this->instructorLevelId->DbValue = $row['instructorLevelId'];
        $this->judgeLevelId->DbValue = $row['judgeLevelId'];
        $this->federationRegisterDate->DbValue = $row['federationRegisterDate'];
        $this->federationStatus->DbValue = $row['federationStatus'];
        $this->createDate->DbValue = $row['createDate'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->lastUpdate->DbValue = $row['lastUpdate'];
        $this->lastUserId->DbValue = $row['lastUserId'];
        $this->marketingSourceId->DbValue = $row['marketingSourceId'];
        $this->marketingSourceDetail->DbValue = $row['marketingSourceDetail'];
        $this->memberTypeId->DbValue = $row['memberTypeId'];
        $this->schoolUserId->DbValue = $row['schoolUserId'];
        $this->age->DbValue = $row['age'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->photo->OldUploadPath = "files/fotos";
        $oldFiles = EmptyValue($row['photo']) ? [] : [$row['photo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->photo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->photo->oldPhysicalUploadPath() . $oldFile);
            }
        }
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
        return $_SESSION[$name] ?? GetUrl("SchoolMemberList");
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
        if ($pageName == "SchoolMemberView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SchoolMemberEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SchoolMemberAdd") {
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
                return "SchoolMemberView";
            case Config("API_ADD_ACTION"):
                return "SchoolMemberAdd";
            case Config("API_EDIT_ACTION"):
                return "SchoolMemberEdit";
            case Config("API_DELETE_ACTION"):
                return "SchoolMemberDelete";
            case Config("API_LIST_ACTION"):
                return "SchoolMemberList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SchoolMemberList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SchoolMemberView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SchoolMemberView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SchoolMemberAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SchoolMemberAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SchoolMemberEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("SchoolMemberAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("SchoolMemberDelete", $this->getUrlParm());
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
        $this->birthdate->setDbValue($row['birthdate']);
        $this->gender->setDbValue($row['gender']);
        $this->address->setDbValue($row['address']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->countryId->setDbValue($row['countryId']);
        $this->UFId->setDbValue($row['UFId']);
        $this->cityId->setDbValue($row['cityId']);
        $this->zip->setDbValue($row['zip']);
        $this->celphone->setDbValue($row['celphone']);
        $this->_email->setDbValue($row['email']);
        $this->facebook->setDbValue($row['facebook']);
        $this->instagram->setDbValue($row['instagram']);
        $this->father->setDbValue($row['father']);
        $this->fatherCellphone->setDbValue($row['fatherCellphone']);
        $this->receiveSmsFather->setDbValue($row['receiveSmsFather']);
        $this->fatherEmail->setDbValue($row['fatherEmail']);
        $this->receiveEmailFather->setDbValue($row['receiveEmailFather']);
        $this->fatherOccupation->setDbValue($row['fatherOccupation']);
        $this->fatherBirthdate->setDbValue($row['fatherBirthdate']);
        $this->mother->setDbValue($row['mother']);
        $this->motherCellphone->setDbValue($row['motherCellphone']);
        $this->receiveSmsMother->setDbValue($row['receiveSmsMother']);
        $this->motherEmail->setDbValue($row['motherEmail']);
        $this->receiveEmailMother->setDbValue($row['receiveEmailMother']);
        $this->motherOccupation->setDbValue($row['motherOccupation']);
        $this->motherBirthdate->setDbValue($row['motherBirthdate']);
        $this->emergencyContact->setDbValue($row['emergencyContact']);
        $this->emergencyFone->setDbValue($row['emergencyFone']);
        $this->obs->setDbValue($row['obs']);
        $this->modalityId->setDbValue($row['modalityId']);
        $this->instructorStatus->setDbValue($row['instructorStatus']);
        $this->martialArtId->setDbValue($row['martialArtId']);
        $this->rankId->setDbValue($row['rankId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->memberStatusId->setDbValue($row['memberStatusId']);
        $this->photo->Upload->DbValue = $row['photo'];
        $this->beltSize->setDbValue($row['beltSize']);
        $this->dobokSize->setDbValue($row['dobokSize']);
        $this->programId->setDbValue($row['programId']);
        $this->classId->setDbValue($row['classId']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->memberLevelId->setDbValue($row['memberLevelId']);
        $this->instructorLevelId->setDbValue($row['instructorLevelId']);
        $this->judgeLevelId->setDbValue($row['judgeLevelId']);
        $this->federationRegisterDate->setDbValue($row['federationRegisterDate']);
        $this->federationStatus->setDbValue($row['federationStatus']);
        $this->createDate->setDbValue($row['createDate']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->marketingSourceId->setDbValue($row['marketingSourceId']);
        $this->marketingSourceDetail->setDbValue($row['marketingSourceDetail']);
        $this->memberTypeId->setDbValue($row['memberTypeId']);
        $this->schoolUserId->setDbValue($row['schoolUserId']);
        $this->age->setDbValue($row['age']);
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

        // birthdate

        // gender

        // address

        // neighborhood

        // countryId

        // UFId

        // cityId

        // zip

        // celphone

        // email

        // facebook

        // instagram

        // father

        // fatherCellphone

        // receiveSmsFather

        // fatherEmail

        // receiveEmailFather

        // fatherOccupation

        // fatherBirthdate

        // mother

        // motherCellphone

        // receiveSmsMother

        // motherEmail

        // receiveEmailMother

        // motherOccupation

        // motherBirthdate

        // emergencyContact

        // emergencyFone

        // obs

        // modalityId

        // instructorStatus

        // martialArtId

        // rankId

        // schoolId

        // memberStatusId

        // photo

        // beltSize

        // dobokSize

        // programId

        // classId

        // federationRegister

        // memberLevelId

        // instructorLevelId

        // judgeLevelId

        // federationRegisterDate

        // federationStatus

        // createDate

        // createUserId

        // lastUpdate

        // lastUserId

        // marketingSourceId

        // marketingSourceDetail

        // memberTypeId

        // schoolUserId

        // age

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // lastName
        $this->lastName->ViewValue = $this->lastName->CurrentValue;
        $this->lastName->ViewCustomAttributes = "";

        // birthdate
        $this->birthdate->ViewValue = $this->birthdate->CurrentValue;
        $this->birthdate->ViewValue = FormatDateTime($this->birthdate->ViewValue, $this->birthdate->formatPattern());
        $this->birthdate->ViewCustomAttributes = "";

        // gender
        if (strval($this->gender->CurrentValue) != "") {
            $this->gender->ViewValue = $this->gender->optionCaption($this->gender->CurrentValue);
        } else {
            $this->gender->ViewValue = null;
        }
        $this->gender->ViewCustomAttributes = "";

        // address
        $this->address->ViewValue = $this->address->CurrentValue;
        $this->address->ViewCustomAttributes = "";

        // neighborhood
        $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
        $this->neighborhood->ViewCustomAttributes = "";

        // countryId
        if ($this->countryId->VirtualValue != "") {
            $this->countryId->ViewValue = $this->countryId->VirtualValue;
        } else {
            $curVal = strval($this->countryId->CurrentValue);
            if ($curVal != "") {
                $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
                if ($this->countryId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->countryId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->countryId->Lookup->renderViewRow($rswrk[0]);
                        $this->countryId->ViewValue = $this->countryId->displayValue($arwrk);
                    } else {
                        $this->countryId->ViewValue = FormatNumber($this->countryId->CurrentValue, $this->countryId->formatPattern());
                    }
                }
            } else {
                $this->countryId->ViewValue = null;
            }
        }
        $this->countryId->ViewCustomAttributes = "";

        // UFId
        if ($this->UFId->VirtualValue != "") {
            $this->UFId->ViewValue = $this->UFId->VirtualValue;
        } else {
            $curVal = strval($this->UFId->CurrentValue);
            if ($curVal != "") {
                $this->UFId->ViewValue = $this->UFId->lookupCacheOption($curVal);
                if ($this->UFId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->UFId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->UFId->Lookup->renderViewRow($rswrk[0]);
                        $this->UFId->ViewValue = $this->UFId->displayValue($arwrk);
                    } else {
                        $this->UFId->ViewValue = FormatNumber($this->UFId->CurrentValue, $this->UFId->formatPattern());
                    }
                }
            } else {
                $this->UFId->ViewValue = null;
            }
        }
        $this->UFId->ViewCustomAttributes = "";

        // cityId
        if ($this->cityId->VirtualValue != "") {
            $this->cityId->ViewValue = $this->cityId->VirtualValue;
        } else {
            $curVal = strval($this->cityId->CurrentValue);
            if ($curVal != "") {
                $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
                if ($this->cityId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->cityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cityId->Lookup->renderViewRow($rswrk[0]);
                        $this->cityId->ViewValue = $this->cityId->displayValue($arwrk);
                    } else {
                        $this->cityId->ViewValue = FormatNumber($this->cityId->CurrentValue, $this->cityId->formatPattern());
                    }
                }
            } else {
                $this->cityId->ViewValue = null;
            }
        }
        $this->cityId->ViewCustomAttributes = "";

        // zip
        $this->zip->ViewValue = $this->zip->CurrentValue;
        $this->zip->ViewCustomAttributes = "";

        // celphone
        $this->celphone->ViewValue = $this->celphone->CurrentValue;
        $this->celphone->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // facebook
        $this->facebook->ViewValue = $this->facebook->CurrentValue;
        $this->facebook->ViewCustomAttributes = "";

        // instagram
        $this->instagram->ViewValue = $this->instagram->CurrentValue;
        $this->instagram->ViewCustomAttributes = "";

        // father
        $this->father->ViewValue = $this->father->CurrentValue;
        $this->father->ViewCustomAttributes = "";

        // fatherCellphone
        $this->fatherCellphone->ViewValue = $this->fatherCellphone->CurrentValue;
        $this->fatherCellphone->ViewCustomAttributes = "";

        // receiveSmsFather
        if (strval($this->receiveSmsFather->CurrentValue) != "") {
            $this->receiveSmsFather->ViewValue = $this->receiveSmsFather->optionCaption($this->receiveSmsFather->CurrentValue);
        } else {
            $this->receiveSmsFather->ViewValue = null;
        }
        $this->receiveSmsFather->ViewCustomAttributes = "";

        // fatherEmail
        $this->fatherEmail->ViewValue = $this->fatherEmail->CurrentValue;
        $this->fatherEmail->ViewCustomAttributes = "";

        // receiveEmailFather
        if (strval($this->receiveEmailFather->CurrentValue) != "") {
            $this->receiveEmailFather->ViewValue = $this->receiveEmailFather->optionCaption($this->receiveEmailFather->CurrentValue);
        } else {
            $this->receiveEmailFather->ViewValue = null;
        }
        $this->receiveEmailFather->ViewCustomAttributes = "";

        // fatherOccupation
        $this->fatherOccupation->ViewValue = $this->fatherOccupation->CurrentValue;
        $this->fatherOccupation->ViewCustomAttributes = "";

        // fatherBirthdate
        $this->fatherBirthdate->ViewValue = $this->fatherBirthdate->CurrentValue;
        $this->fatherBirthdate->ViewValue = FormatDateTime($this->fatherBirthdate->ViewValue, $this->fatherBirthdate->formatPattern());
        $this->fatherBirthdate->ViewCustomAttributes = "";

        // mother
        $this->mother->ViewValue = $this->mother->CurrentValue;
        $this->mother->ViewCustomAttributes = "";

        // motherCellphone
        $this->motherCellphone->ViewValue = $this->motherCellphone->CurrentValue;
        $this->motherCellphone->ViewCustomAttributes = "";

        // receiveSmsMother
        if (strval($this->receiveSmsMother->CurrentValue) != "") {
            $this->receiveSmsMother->ViewValue = $this->receiveSmsMother->optionCaption($this->receiveSmsMother->CurrentValue);
        } else {
            $this->receiveSmsMother->ViewValue = null;
        }
        $this->receiveSmsMother->ViewCustomAttributes = "";

        // motherEmail
        $this->motherEmail->ViewValue = $this->motherEmail->CurrentValue;
        $this->motherEmail->ViewCustomAttributes = "";

        // receiveEmailMother
        if (strval($this->receiveEmailMother->CurrentValue) != "") {
            $this->receiveEmailMother->ViewValue = $this->receiveEmailMother->optionCaption($this->receiveEmailMother->CurrentValue);
        } else {
            $this->receiveEmailMother->ViewValue = null;
        }
        $this->receiveEmailMother->ViewCustomAttributes = "";

        // motherOccupation
        $this->motherOccupation->ViewValue = $this->motherOccupation->CurrentValue;
        $this->motherOccupation->ViewCustomAttributes = "";

        // motherBirthdate
        $this->motherBirthdate->ViewValue = $this->motherBirthdate->CurrentValue;
        $this->motherBirthdate->ViewValue = FormatDateTime($this->motherBirthdate->ViewValue, $this->motherBirthdate->formatPattern());
        $this->motherBirthdate->ViewCustomAttributes = "";

        // emergencyContact
        $this->emergencyContact->ViewValue = $this->emergencyContact->CurrentValue;
        $this->emergencyContact->ViewCustomAttributes = "";

        // emergencyFone
        $this->emergencyFone->ViewValue = $this->emergencyFone->CurrentValue;
        $this->emergencyFone->ViewCustomAttributes = "";

        // obs
        $this->obs->ViewValue = $this->obs->CurrentValue;
        $this->obs->ViewCustomAttributes = "";

        // modalityId
        if ($this->modalityId->VirtualValue != "") {
            $this->modalityId->ViewValue = $this->modalityId->VirtualValue;
        } else {
            $curVal = strval($this->modalityId->CurrentValue);
            if ($curVal != "") {
                $this->modalityId->ViewValue = $this->modalityId->lookupCacheOption($curVal);
                if ($this->modalityId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->modalityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->modalityId->Lookup->renderViewRow($rswrk[0]);
                        $this->modalityId->ViewValue = $this->modalityId->displayValue($arwrk);
                    } else {
                        $this->modalityId->ViewValue = FormatNumber($this->modalityId->CurrentValue, $this->modalityId->formatPattern());
                    }
                }
            } else {
                $this->modalityId->ViewValue = null;
            }
        }
        $this->modalityId->ViewCustomAttributes = "";

        // instructorStatus
        if (ConvertToBool($this->instructorStatus->CurrentValue)) {
            $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(1) != "" ? $this->instructorStatus->tagCaption(1) : "Yes";
        } else {
            $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(2) != "" ? $this->instructorStatus->tagCaption(2) : "No";
        }
        $this->instructorStatus->ViewCustomAttributes = "";

        // martialArtId
        $curVal = strval($this->martialArtId->CurrentValue);
        if ($curVal != "") {
            $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
            if ($this->martialArtId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->martialArtId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->martialArtId->Lookup->renderViewRow($rswrk[0]);
                    $this->martialArtId->ViewValue = $this->martialArtId->displayValue($arwrk);
                } else {
                    $this->martialArtId->ViewValue = FormatNumber($this->martialArtId->CurrentValue, $this->martialArtId->formatPattern());
                }
            }
        } else {
            $this->martialArtId->ViewValue = null;
        }
        $this->martialArtId->ViewCustomAttributes = "";

        // rankId
        $curVal = strval($this->rankId->CurrentValue);
        if ($curVal != "") {
            $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
            if ($this->rankId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->rankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->rankId->Lookup->renderViewRow($rswrk[0]);
                    $this->rankId->ViewValue = $this->rankId->displayValue($arwrk);
                } else {
                    $this->rankId->ViewValue = FormatNumber($this->rankId->CurrentValue, $this->rankId->formatPattern());
                }
            }
        } else {
            $this->rankId->ViewValue = null;
        }
        $this->rankId->ViewCustomAttributes = "";

        // schoolId
        if ($this->schoolId->VirtualValue != "") {
            $this->schoolId->ViewValue = $this->schoolId->VirtualValue;
        } else {
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
        }
        $this->schoolId->ViewCustomAttributes = "";

        // memberStatusId
        $curVal = strval($this->memberStatusId->CurrentValue);
        if ($curVal != "") {
            $this->memberStatusId->ViewValue = $this->memberStatusId->lookupCacheOption($curVal);
            if ($this->memberStatusId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->memberStatusId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->memberStatusId->Lookup->renderViewRow($rswrk[0]);
                    $this->memberStatusId->ViewValue = $this->memberStatusId->displayValue($arwrk);
                } else {
                    $this->memberStatusId->ViewValue = FormatNumber($this->memberStatusId->CurrentValue, $this->memberStatusId->formatPattern());
                }
            }
        } else {
            $this->memberStatusId->ViewValue = null;
        }
        $this->memberStatusId->ViewCustomAttributes = "";

        // photo
        $this->photo->UploadPath = "files/fotos";
        if (!EmptyValue($this->photo->Upload->DbValue)) {
            $this->photo->ImageWidth = 80;
            $this->photo->ImageHeight = 90;
            $this->photo->ImageAlt = $this->photo->alt();
            $this->photo->ImageCssClass = "ew-image";
            $this->photo->ViewValue = $this->photo->Upload->DbValue;
        } else {
            $this->photo->ViewValue = "";
        }
        $this->photo->ViewCustomAttributes = "";

        // beltSize
        $this->beltSize->ViewValue = $this->beltSize->CurrentValue;
        $this->beltSize->ViewCustomAttributes = "";

        // dobokSize
        $this->dobokSize->ViewValue = $this->dobokSize->CurrentValue;
        $this->dobokSize->ViewCustomAttributes = "";

        // programId
        $curVal = strval($this->programId->CurrentValue);
        if ($curVal != "") {
            $this->programId->ViewValue = $this->programId->lookupCacheOption($curVal);
            if ($this->programId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->programId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->programId->Lookup->renderViewRow($rswrk[0]);
                    $this->programId->ViewValue = $this->programId->displayValue($arwrk);
                } else {
                    $this->programId->ViewValue = FormatNumber($this->programId->CurrentValue, $this->programId->formatPattern());
                }
            }
        } else {
            $this->programId->ViewValue = null;
        }
        $this->programId->ViewCustomAttributes = "";

        // classId
        $curVal = strval($this->classId->CurrentValue);
        if ($curVal != "") {
            $this->classId->ViewValue = $this->classId->lookupCacheOption($curVal);
            if ($this->classId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->classId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->classId->Lookup->renderViewRow($rswrk[0]);
                    $this->classId->ViewValue = $this->classId->displayValue($arwrk);
                } else {
                    $this->classId->ViewValue = FormatNumber($this->classId->CurrentValue, $this->classId->formatPattern());
                }
            }
        } else {
            $this->classId->ViewValue = null;
        }
        $this->classId->ViewCustomAttributes = "";

        // federationRegister
        $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
        $this->federationRegister->ViewCustomAttributes = "";

        // memberLevelId
        $curVal = strval($this->memberLevelId->CurrentValue);
        if ($curVal != "") {
            $this->memberLevelId->ViewValue = $this->memberLevelId->lookupCacheOption($curVal);
            if ($this->memberLevelId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->memberLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->memberLevelId->Lookup->renderViewRow($rswrk[0]);
                    $this->memberLevelId->ViewValue = $this->memberLevelId->displayValue($arwrk);
                } else {
                    $this->memberLevelId->ViewValue = FormatNumber($this->memberLevelId->CurrentValue, $this->memberLevelId->formatPattern());
                }
            }
        } else {
            $this->memberLevelId->ViewValue = null;
        }
        $this->memberLevelId->ViewCustomAttributes = "";

        // instructorLevelId
        $curVal = strval($this->instructorLevelId->CurrentValue);
        if ($curVal != "") {
            $this->instructorLevelId->ViewValue = $this->instructorLevelId->lookupCacheOption($curVal);
            if ($this->instructorLevelId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->instructorLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->instructorLevelId->Lookup->renderViewRow($rswrk[0]);
                    $this->instructorLevelId->ViewValue = $this->instructorLevelId->displayValue($arwrk);
                } else {
                    $this->instructorLevelId->ViewValue = FormatNumber($this->instructorLevelId->CurrentValue, $this->instructorLevelId->formatPattern());
                }
            }
        } else {
            $this->instructorLevelId->ViewValue = null;
        }
        $this->instructorLevelId->ViewCustomAttributes = "";

        // judgeLevelId
        $curVal = strval($this->judgeLevelId->CurrentValue);
        if ($curVal != "") {
            $this->judgeLevelId->ViewValue = $this->judgeLevelId->lookupCacheOption($curVal);
            if ($this->judgeLevelId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->judgeLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->judgeLevelId->Lookup->renderViewRow($rswrk[0]);
                    $this->judgeLevelId->ViewValue = $this->judgeLevelId->displayValue($arwrk);
                } else {
                    $this->judgeLevelId->ViewValue = FormatNumber($this->judgeLevelId->CurrentValue, $this->judgeLevelId->formatPattern());
                }
            }
        } else {
            $this->judgeLevelId->ViewValue = null;
        }
        $this->judgeLevelId->ViewCustomAttributes = "";

        // federationRegisterDate
        $this->federationRegisterDate->ViewValue = $this->federationRegisterDate->CurrentValue;
        $this->federationRegisterDate->ViewValue = FormatDateTime($this->federationRegisterDate->ViewValue, $this->federationRegisterDate->formatPattern());
        $this->federationRegisterDate->ViewCustomAttributes = "";

        // federationStatus
        if (ConvertToBool($this->federationStatus->CurrentValue)) {
            $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(1) != "" ? $this->federationStatus->tagCaption(1) : "Yes";
        } else {
            $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(2) != "" ? $this->federationStatus->tagCaption(2) : "No";
        }
        $this->federationStatus->ViewCustomAttributes = "";

        // createDate
        $this->createDate->ViewValue = $this->createDate->CurrentValue;
        $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
        $this->createDate->ViewCustomAttributes = "";

        // createUserId
        $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
        $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
        $this->createUserId->ViewCustomAttributes = "";

        // lastUpdate
        $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
        $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
        $this->lastUpdate->ViewCustomAttributes = "";

        // lastUserId
        $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
        $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->ViewValue, $this->lastUserId->formatPattern());
        $this->lastUserId->ViewCustomAttributes = "";

        // marketingSourceId
        $curVal = strval($this->marketingSourceId->CurrentValue);
        if ($curVal != "") {
            $this->marketingSourceId->ViewValue = $this->marketingSourceId->lookupCacheOption($curVal);
            if ($this->marketingSourceId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->marketingSourceId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->marketingSourceId->Lookup->renderViewRow($rswrk[0]);
                    $this->marketingSourceId->ViewValue = $this->marketingSourceId->displayValue($arwrk);
                } else {
                    $this->marketingSourceId->ViewValue = FormatNumber($this->marketingSourceId->CurrentValue, $this->marketingSourceId->formatPattern());
                }
            }
        } else {
            $this->marketingSourceId->ViewValue = null;
        }
        $this->marketingSourceId->ViewCustomAttributes = "";

        // marketingSourceDetail
        $this->marketingSourceDetail->ViewValue = $this->marketingSourceDetail->CurrentValue;
        $this->marketingSourceDetail->ViewCustomAttributes = "";

        // memberTypeId
        $this->memberTypeId->ViewValue = $this->memberTypeId->CurrentValue;
        $this->memberTypeId->ViewValue = FormatNumber($this->memberTypeId->ViewValue, $this->memberTypeId->formatPattern());
        $this->memberTypeId->ViewCustomAttributes = "";

        // schoolUserId
        $this->schoolUserId->ViewValue = $this->schoolUserId->CurrentValue;
        $this->schoolUserId->ViewValue = FormatNumber($this->schoolUserId->ViewValue, $this->schoolUserId->formatPattern());
        $this->schoolUserId->ViewCustomAttributes = "";

        // age
        $this->age->ViewValue = $this->age->CurrentValue;
        $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
        $this->age->ViewCustomAttributes = "";

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

        // birthdate
        $this->birthdate->LinkCustomAttributes = "";
        $this->birthdate->HrefValue = "";
        $this->birthdate->TooltipValue = "";

        // gender
        $this->gender->LinkCustomAttributes = "";
        $this->gender->HrefValue = "";
        $this->gender->TooltipValue = "";

        // address
        $this->address->LinkCustomAttributes = "";
        $this->address->HrefValue = "";
        $this->address->TooltipValue = "";

        // neighborhood
        $this->neighborhood->LinkCustomAttributes = "";
        $this->neighborhood->HrefValue = "";
        $this->neighborhood->TooltipValue = "";

        // countryId
        $this->countryId->LinkCustomAttributes = "";
        $this->countryId->HrefValue = "";
        $this->countryId->TooltipValue = "";

        // UFId
        $this->UFId->LinkCustomAttributes = "";
        $this->UFId->HrefValue = "";
        $this->UFId->TooltipValue = "";

        // cityId
        $this->cityId->LinkCustomAttributes = "";
        $this->cityId->HrefValue = "";
        $this->cityId->TooltipValue = "";

        // zip
        $this->zip->LinkCustomAttributes = "";
        $this->zip->HrefValue = "";
        $this->zip->TooltipValue = "";

        // celphone
        $this->celphone->LinkCustomAttributes = "";
        $this->celphone->HrefValue = "";
        $this->celphone->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // facebook
        $this->facebook->LinkCustomAttributes = "";
        $this->facebook->HrefValue = "";
        $this->facebook->TooltipValue = "";

        // instagram
        $this->instagram->LinkCustomAttributes = "";
        $this->instagram->HrefValue = "";
        $this->instagram->TooltipValue = "";

        // father
        $this->father->LinkCustomAttributes = "";
        $this->father->HrefValue = "";
        $this->father->TooltipValue = "";

        // fatherCellphone
        $this->fatherCellphone->LinkCustomAttributes = "";
        $this->fatherCellphone->HrefValue = "";
        $this->fatherCellphone->TooltipValue = "";

        // receiveSmsFather
        $this->receiveSmsFather->LinkCustomAttributes = "";
        $this->receiveSmsFather->HrefValue = "";
        $this->receiveSmsFather->TooltipValue = "";

        // fatherEmail
        $this->fatherEmail->LinkCustomAttributes = "";
        $this->fatherEmail->HrefValue = "";
        $this->fatherEmail->TooltipValue = "";

        // receiveEmailFather
        $this->receiveEmailFather->LinkCustomAttributes = "";
        $this->receiveEmailFather->HrefValue = "";
        $this->receiveEmailFather->TooltipValue = "";

        // fatherOccupation
        $this->fatherOccupation->LinkCustomAttributes = "";
        $this->fatherOccupation->HrefValue = "";
        $this->fatherOccupation->TooltipValue = "";

        // fatherBirthdate
        $this->fatherBirthdate->LinkCustomAttributes = "";
        $this->fatherBirthdate->HrefValue = "";
        $this->fatherBirthdate->TooltipValue = "";

        // mother
        $this->mother->LinkCustomAttributes = "";
        $this->mother->HrefValue = "";
        $this->mother->TooltipValue = "";

        // motherCellphone
        $this->motherCellphone->LinkCustomAttributes = "";
        $this->motherCellphone->HrefValue = "";
        $this->motherCellphone->TooltipValue = "";

        // receiveSmsMother
        $this->receiveSmsMother->LinkCustomAttributes = "";
        $this->receiveSmsMother->HrefValue = "";
        $this->receiveSmsMother->TooltipValue = "";

        // motherEmail
        $this->motherEmail->LinkCustomAttributes = "";
        $this->motherEmail->HrefValue = "";
        $this->motherEmail->TooltipValue = "";

        // receiveEmailMother
        $this->receiveEmailMother->LinkCustomAttributes = "";
        $this->receiveEmailMother->HrefValue = "";
        $this->receiveEmailMother->TooltipValue = "";

        // motherOccupation
        $this->motherOccupation->LinkCustomAttributes = "";
        $this->motherOccupation->HrefValue = "";
        $this->motherOccupation->TooltipValue = "";

        // motherBirthdate
        $this->motherBirthdate->LinkCustomAttributes = "";
        $this->motherBirthdate->HrefValue = "";
        $this->motherBirthdate->TooltipValue = "";

        // emergencyContact
        $this->emergencyContact->LinkCustomAttributes = "";
        $this->emergencyContact->HrefValue = "";
        $this->emergencyContact->TooltipValue = "";

        // emergencyFone
        $this->emergencyFone->LinkCustomAttributes = "";
        $this->emergencyFone->HrefValue = "";
        $this->emergencyFone->TooltipValue = "";

        // obs
        $this->obs->LinkCustomAttributes = "";
        $this->obs->HrefValue = "";
        $this->obs->TooltipValue = "";

        // modalityId
        $this->modalityId->LinkCustomAttributes = "";
        $this->modalityId->HrefValue = "";
        $this->modalityId->TooltipValue = "";

        // instructorStatus
        $this->instructorStatus->LinkCustomAttributes = "";
        $this->instructorStatus->HrefValue = "";
        $this->instructorStatus->TooltipValue = "";

        // martialArtId
        $this->martialArtId->LinkCustomAttributes = "";
        $this->martialArtId->HrefValue = "";
        $this->martialArtId->TooltipValue = "";

        // rankId
        $this->rankId->LinkCustomAttributes = "";
        $this->rankId->HrefValue = "";
        $this->rankId->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // memberStatusId
        $this->memberStatusId->LinkCustomAttributes = "";
        $this->memberStatusId->HrefValue = "";
        $this->memberStatusId->TooltipValue = "";

        // photo
        $this->photo->LinkCustomAttributes = "";
        $this->photo->UploadPath = "files/fotos";
        if (!EmptyValue($this->photo->Upload->DbValue)) {
            $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
            $this->photo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
            }
        } else {
            $this->photo->HrefValue = "";
        }
        $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;
        $this->photo->TooltipValue = "";
        if ($this->photo->UseColorbox) {
            if (EmptyValue($this->photo->TooltipValue)) {
                $this->photo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->photo->LinkAttrs["data-rel"] = "school_member_x_photo";
            $this->photo->LinkAttrs->appendClass("ew-lightbox");
        }

        // beltSize
        $this->beltSize->LinkCustomAttributes = "";
        $this->beltSize->HrefValue = "";
        $this->beltSize->TooltipValue = "";

        // dobokSize
        $this->dobokSize->LinkCustomAttributes = "";
        $this->dobokSize->HrefValue = "";
        $this->dobokSize->TooltipValue = "";

        // programId
        $this->programId->LinkCustomAttributes = "";
        $this->programId->HrefValue = "";
        $this->programId->TooltipValue = "";

        // classId
        $this->classId->LinkCustomAttributes = "";
        $this->classId->HrefValue = "";
        $this->classId->TooltipValue = "";

        // federationRegister
        $this->federationRegister->LinkCustomAttributes = "";
        $this->federationRegister->HrefValue = "";
        $this->federationRegister->TooltipValue = "";

        // memberLevelId
        $this->memberLevelId->LinkCustomAttributes = "";
        $this->memberLevelId->HrefValue = "";
        $this->memberLevelId->TooltipValue = "";

        // instructorLevelId
        $this->instructorLevelId->LinkCustomAttributes = "";
        $this->instructorLevelId->HrefValue = "";
        $this->instructorLevelId->TooltipValue = "";

        // judgeLevelId
        $this->judgeLevelId->LinkCustomAttributes = "";
        $this->judgeLevelId->HrefValue = "";
        $this->judgeLevelId->TooltipValue = "";

        // federationRegisterDate
        $this->federationRegisterDate->LinkCustomAttributes = "";
        $this->federationRegisterDate->HrefValue = "";
        $this->federationRegisterDate->TooltipValue = "";

        // federationStatus
        $this->federationStatus->LinkCustomAttributes = "";
        $this->federationStatus->HrefValue = "";
        $this->federationStatus->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // lastUpdate
        $this->lastUpdate->LinkCustomAttributes = "";
        $this->lastUpdate->HrefValue = "";
        $this->lastUpdate->TooltipValue = "";

        // lastUserId
        $this->lastUserId->LinkCustomAttributes = "";
        $this->lastUserId->HrefValue = "";
        $this->lastUserId->TooltipValue = "";

        // marketingSourceId
        $this->marketingSourceId->LinkCustomAttributes = "";
        $this->marketingSourceId->HrefValue = "";
        $this->marketingSourceId->TooltipValue = "";

        // marketingSourceDetail
        $this->marketingSourceDetail->LinkCustomAttributes = "";
        $this->marketingSourceDetail->HrefValue = "";
        $this->marketingSourceDetail->TooltipValue = "";

        // memberTypeId
        $this->memberTypeId->LinkCustomAttributes = "";
        $this->memberTypeId->HrefValue = "";
        $this->memberTypeId->TooltipValue = "";

        // schoolUserId
        $this->schoolUserId->LinkCustomAttributes = "";
        $this->schoolUserId->HrefValue = "";
        $this->schoolUserId->TooltipValue = "";

        // age
        $this->age->LinkCustomAttributes = "";
        $this->age->HrefValue = "";
        $this->age->TooltipValue = "";

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

        // birthdate
        $this->birthdate->setupEditAttributes();
        $this->birthdate->EditCustomAttributes = "";
        $this->birthdate->EditValue = FormatDateTime($this->birthdate->CurrentValue, $this->birthdate->formatPattern());
        $this->birthdate->PlaceHolder = RemoveHtml($this->birthdate->caption());

        // gender
        $this->gender->EditCustomAttributes = "";
        $this->gender->EditValue = $this->gender->options(false);
        $this->gender->PlaceHolder = RemoveHtml($this->gender->caption());

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

        // countryId
        $this->countryId->setupEditAttributes();
        $this->countryId->EditCustomAttributes = "";
        $this->countryId->PlaceHolder = RemoveHtml($this->countryId->caption());

        // UFId
        $this->UFId->setupEditAttributes();
        $this->UFId->EditCustomAttributes = "";
        $this->UFId->PlaceHolder = RemoveHtml($this->UFId->caption());

        // cityId
        $this->cityId->setupEditAttributes();
        $this->cityId->EditCustomAttributes = "";
        $this->cityId->PlaceHolder = RemoveHtml($this->cityId->caption());

        // zip
        $this->zip->setupEditAttributes();
        $this->zip->EditCustomAttributes = "";
        if (!$this->zip->Raw) {
            $this->zip->CurrentValue = HtmlDecode($this->zip->CurrentValue);
        }
        $this->zip->EditValue = $this->zip->CurrentValue;
        $this->zip->PlaceHolder = RemoveHtml($this->zip->caption());

        // celphone
        $this->celphone->setupEditAttributes();
        $this->celphone->EditCustomAttributes = "";
        if (!$this->celphone->Raw) {
            $this->celphone->CurrentValue = HtmlDecode($this->celphone->CurrentValue);
        }
        $this->celphone->EditValue = $this->celphone->CurrentValue;
        $this->celphone->PlaceHolder = RemoveHtml($this->celphone->caption());

        // email
        $this->_email->setupEditAttributes();
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // facebook
        $this->facebook->setupEditAttributes();
        $this->facebook->EditCustomAttributes = "";
        if (!$this->facebook->Raw) {
            $this->facebook->CurrentValue = HtmlDecode($this->facebook->CurrentValue);
        }
        $this->facebook->EditValue = $this->facebook->CurrentValue;
        $this->facebook->PlaceHolder = RemoveHtml($this->facebook->caption());

        // instagram
        $this->instagram->setupEditAttributes();
        $this->instagram->EditCustomAttributes = "";
        if (!$this->instagram->Raw) {
            $this->instagram->CurrentValue = HtmlDecode($this->instagram->CurrentValue);
        }
        $this->instagram->EditValue = $this->instagram->CurrentValue;
        $this->instagram->PlaceHolder = RemoveHtml($this->instagram->caption());

        // father
        $this->father->setupEditAttributes();
        $this->father->EditCustomAttributes = "";
        if (!$this->father->Raw) {
            $this->father->CurrentValue = HtmlDecode($this->father->CurrentValue);
        }
        $this->father->EditValue = $this->father->CurrentValue;
        $this->father->PlaceHolder = RemoveHtml($this->father->caption());

        // fatherCellphone
        $this->fatherCellphone->setupEditAttributes();
        $this->fatherCellphone->EditCustomAttributes = "";
        if (!$this->fatherCellphone->Raw) {
            $this->fatherCellphone->CurrentValue = HtmlDecode($this->fatherCellphone->CurrentValue);
        }
        $this->fatherCellphone->EditValue = $this->fatherCellphone->CurrentValue;
        $this->fatherCellphone->PlaceHolder = RemoveHtml($this->fatherCellphone->caption());

        // receiveSmsFather
        $this->receiveSmsFather->EditCustomAttributes = "";
        $this->receiveSmsFather->EditValue = $this->receiveSmsFather->options(false);
        $this->receiveSmsFather->PlaceHolder = RemoveHtml($this->receiveSmsFather->caption());

        // fatherEmail
        $this->fatherEmail->setupEditAttributes();
        $this->fatherEmail->EditCustomAttributes = "";
        if (!$this->fatherEmail->Raw) {
            $this->fatherEmail->CurrentValue = HtmlDecode($this->fatherEmail->CurrentValue);
        }
        $this->fatherEmail->EditValue = $this->fatherEmail->CurrentValue;
        $this->fatherEmail->PlaceHolder = RemoveHtml($this->fatherEmail->caption());

        // receiveEmailFather
        $this->receiveEmailFather->EditCustomAttributes = "";
        $this->receiveEmailFather->EditValue = $this->receiveEmailFather->options(false);
        $this->receiveEmailFather->PlaceHolder = RemoveHtml($this->receiveEmailFather->caption());

        // fatherOccupation
        $this->fatherOccupation->setupEditAttributes();
        $this->fatherOccupation->EditCustomAttributes = "";
        if (!$this->fatherOccupation->Raw) {
            $this->fatherOccupation->CurrentValue = HtmlDecode($this->fatherOccupation->CurrentValue);
        }
        $this->fatherOccupation->EditValue = $this->fatherOccupation->CurrentValue;
        $this->fatherOccupation->PlaceHolder = RemoveHtml($this->fatherOccupation->caption());

        // fatherBirthdate
        $this->fatherBirthdate->setupEditAttributes();
        $this->fatherBirthdate->EditCustomAttributes = "";
        $this->fatherBirthdate->EditValue = FormatDateTime($this->fatherBirthdate->CurrentValue, $this->fatherBirthdate->formatPattern());
        $this->fatherBirthdate->PlaceHolder = RemoveHtml($this->fatherBirthdate->caption());

        // mother
        $this->mother->setupEditAttributes();
        $this->mother->EditCustomAttributes = "";
        if (!$this->mother->Raw) {
            $this->mother->CurrentValue = HtmlDecode($this->mother->CurrentValue);
        }
        $this->mother->EditValue = $this->mother->CurrentValue;
        $this->mother->PlaceHolder = RemoveHtml($this->mother->caption());

        // motherCellphone
        $this->motherCellphone->setupEditAttributes();
        $this->motherCellphone->EditCustomAttributes = "";
        if (!$this->motherCellphone->Raw) {
            $this->motherCellphone->CurrentValue = HtmlDecode($this->motherCellphone->CurrentValue);
        }
        $this->motherCellphone->EditValue = $this->motherCellphone->CurrentValue;
        $this->motherCellphone->PlaceHolder = RemoveHtml($this->motherCellphone->caption());

        // receiveSmsMother
        $this->receiveSmsMother->EditCustomAttributes = "";
        $this->receiveSmsMother->EditValue = $this->receiveSmsMother->options(false);
        $this->receiveSmsMother->PlaceHolder = RemoveHtml($this->receiveSmsMother->caption());

        // motherEmail
        $this->motherEmail->setupEditAttributes();
        $this->motherEmail->EditCustomAttributes = "";
        if (!$this->motherEmail->Raw) {
            $this->motherEmail->CurrentValue = HtmlDecode($this->motherEmail->CurrentValue);
        }
        $this->motherEmail->EditValue = $this->motherEmail->CurrentValue;
        $this->motherEmail->PlaceHolder = RemoveHtml($this->motherEmail->caption());

        // receiveEmailMother
        $this->receiveEmailMother->EditCustomAttributes = "";
        $this->receiveEmailMother->EditValue = $this->receiveEmailMother->options(false);
        $this->receiveEmailMother->PlaceHolder = RemoveHtml($this->receiveEmailMother->caption());

        // motherOccupation
        $this->motherOccupation->setupEditAttributes();
        $this->motherOccupation->EditCustomAttributes = "";
        if (!$this->motherOccupation->Raw) {
            $this->motherOccupation->CurrentValue = HtmlDecode($this->motherOccupation->CurrentValue);
        }
        $this->motherOccupation->EditValue = $this->motherOccupation->CurrentValue;
        $this->motherOccupation->PlaceHolder = RemoveHtml($this->motherOccupation->caption());

        // motherBirthdate
        $this->motherBirthdate->setupEditAttributes();
        $this->motherBirthdate->EditCustomAttributes = "";
        $this->motherBirthdate->EditValue = FormatDateTime($this->motherBirthdate->CurrentValue, $this->motherBirthdate->formatPattern());
        $this->motherBirthdate->PlaceHolder = RemoveHtml($this->motherBirthdate->caption());

        // emergencyContact
        $this->emergencyContact->setupEditAttributes();
        $this->emergencyContact->EditCustomAttributes = "";
        if (!$this->emergencyContact->Raw) {
            $this->emergencyContact->CurrentValue = HtmlDecode($this->emergencyContact->CurrentValue);
        }
        $this->emergencyContact->EditValue = $this->emergencyContact->CurrentValue;
        $this->emergencyContact->PlaceHolder = RemoveHtml($this->emergencyContact->caption());

        // emergencyFone
        $this->emergencyFone->setupEditAttributes();
        $this->emergencyFone->EditCustomAttributes = "";
        if (!$this->emergencyFone->Raw) {
            $this->emergencyFone->CurrentValue = HtmlDecode($this->emergencyFone->CurrentValue);
        }
        $this->emergencyFone->EditValue = $this->emergencyFone->CurrentValue;
        $this->emergencyFone->PlaceHolder = RemoveHtml($this->emergencyFone->caption());

        // obs
        $this->obs->setupEditAttributes();
        $this->obs->EditCustomAttributes = "";
        $this->obs->EditValue = $this->obs->CurrentValue;
        $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

        // modalityId
        $this->modalityId->setupEditAttributes();
        $this->modalityId->EditCustomAttributes = "";
        $this->modalityId->PlaceHolder = RemoveHtml($this->modalityId->caption());

        // instructorStatus
        $this->instructorStatus->EditCustomAttributes = "";
        $this->instructorStatus->EditValue = $this->instructorStatus->options(false);
        $this->instructorStatus->PlaceHolder = RemoveHtml($this->instructorStatus->caption());

        // martialArtId
        $this->martialArtId->setupEditAttributes();
        $this->martialArtId->EditCustomAttributes = "";
        $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

        // rankId
        $this->rankId->setupEditAttributes();
        $this->rankId->EditCustomAttributes = "";
        $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        if ($this->schoolId->getSessionValue() != "") {
            $this->schoolId->CurrentValue = GetForeignKeyValue($this->schoolId->getSessionValue());
            if ($this->schoolId->VirtualValue != "") {
                $this->schoolId->ViewValue = $this->schoolId->VirtualValue;
            } else {
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
            }
            $this->schoolId->ViewCustomAttributes = "";
        } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
        }

        // memberStatusId
        $this->memberStatusId->EditCustomAttributes = "";
        $this->memberStatusId->PlaceHolder = RemoveHtml($this->memberStatusId->caption());

        // photo
        $this->photo->setupEditAttributes();
        $this->photo->EditCustomAttributes = "";
        $this->photo->UploadPath = "files/fotos";
        if (!EmptyValue($this->photo->Upload->DbValue)) {
            $this->photo->ImageWidth = 80;
            $this->photo->ImageHeight = 90;
            $this->photo->ImageAlt = $this->photo->alt();
            $this->photo->ImageCssClass = "ew-image";
            $this->photo->EditValue = $this->photo->Upload->DbValue;
        } else {
            $this->photo->EditValue = "";
        }
        if (!EmptyValue($this->photo->CurrentValue)) {
            $this->photo->Upload->FileName = $this->photo->CurrentValue;
        }

        // beltSize
        $this->beltSize->setupEditAttributes();
        $this->beltSize->EditCustomAttributes = "";
        if (!$this->beltSize->Raw) {
            $this->beltSize->CurrentValue = HtmlDecode($this->beltSize->CurrentValue);
        }
        $this->beltSize->EditValue = $this->beltSize->CurrentValue;
        $this->beltSize->PlaceHolder = RemoveHtml($this->beltSize->caption());

        // dobokSize
        $this->dobokSize->setupEditAttributes();
        $this->dobokSize->EditCustomAttributes = "";
        if (!$this->dobokSize->Raw) {
            $this->dobokSize->CurrentValue = HtmlDecode($this->dobokSize->CurrentValue);
        }
        $this->dobokSize->EditValue = $this->dobokSize->CurrentValue;
        $this->dobokSize->PlaceHolder = RemoveHtml($this->dobokSize->caption());

        // programId
        $this->programId->setupEditAttributes();
        $this->programId->EditCustomAttributes = "";
        $this->programId->PlaceHolder = RemoveHtml($this->programId->caption());

        // classId
        $this->classId->setupEditAttributes();
        $this->classId->EditCustomAttributes = "";
        $this->classId->PlaceHolder = RemoveHtml($this->classId->caption());

        // federationRegister
        $this->federationRegister->setupEditAttributes();
        $this->federationRegister->EditCustomAttributes = "";
        if (!$this->federationRegister->Raw) {
            $this->federationRegister->CurrentValue = HtmlDecode($this->federationRegister->CurrentValue);
        }
        $this->federationRegister->EditValue = $this->federationRegister->CurrentValue;
        $this->federationRegister->PlaceHolder = RemoveHtml($this->federationRegister->caption());

        // memberLevelId
        $this->memberLevelId->setupEditAttributes();
        $this->memberLevelId->EditCustomAttributes = "";
        $this->memberLevelId->PlaceHolder = RemoveHtml($this->memberLevelId->caption());

        // instructorLevelId
        $this->instructorLevelId->setupEditAttributes();
        $this->instructorLevelId->EditCustomAttributes = "";
        $this->instructorLevelId->PlaceHolder = RemoveHtml($this->instructorLevelId->caption());

        // judgeLevelId
        $this->judgeLevelId->setupEditAttributes();
        $this->judgeLevelId->EditCustomAttributes = "";
        $this->judgeLevelId->PlaceHolder = RemoveHtml($this->judgeLevelId->caption());

        // federationRegisterDate
        $this->federationRegisterDate->setupEditAttributes();
        $this->federationRegisterDate->EditCustomAttributes = "";
        $this->federationRegisterDate->EditValue = FormatDateTime($this->federationRegisterDate->CurrentValue, $this->federationRegisterDate->formatPattern());
        $this->federationRegisterDate->PlaceHolder = RemoveHtml($this->federationRegisterDate->caption());

        // federationStatus
        $this->federationStatus->EditCustomAttributes = "";
        $this->federationStatus->EditValue = $this->federationStatus->options(false);
        $this->federationStatus->PlaceHolder = RemoveHtml($this->federationStatus->caption());

        // createDate

        // createUserId

        // lastUpdate

        // lastUserId

        // marketingSourceId
        $this->marketingSourceId->setupEditAttributes();
        $this->marketingSourceId->EditCustomAttributes = "";
        $this->marketingSourceId->PlaceHolder = RemoveHtml($this->marketingSourceId->caption());

        // marketingSourceDetail
        $this->marketingSourceDetail->setupEditAttributes();
        $this->marketingSourceDetail->EditCustomAttributes = "";
        if (!$this->marketingSourceDetail->Raw) {
            $this->marketingSourceDetail->CurrentValue = HtmlDecode($this->marketingSourceDetail->CurrentValue);
        }
        $this->marketingSourceDetail->EditValue = $this->marketingSourceDetail->CurrentValue;
        $this->marketingSourceDetail->PlaceHolder = RemoveHtml($this->marketingSourceDetail->caption());

        // memberTypeId
        $this->memberTypeId->setupEditAttributes();
        $this->memberTypeId->EditCustomAttributes = "";
        $this->memberTypeId->EditValue = $this->memberTypeId->CurrentValue;
        $this->memberTypeId->PlaceHolder = RemoveHtml($this->memberTypeId->caption());
        if (strval($this->memberTypeId->EditValue) != "" && is_numeric($this->memberTypeId->EditValue)) {
            $this->memberTypeId->EditValue = FormatNumber($this->memberTypeId->EditValue, null);
        }

        // schoolUserId
        $this->schoolUserId->setupEditAttributes();
        $this->schoolUserId->EditCustomAttributes = "";
        $this->schoolUserId->EditValue = $this->schoolUserId->CurrentValue;
        $this->schoolUserId->PlaceHolder = RemoveHtml($this->schoolUserId->caption());
        if (strval($this->schoolUserId->EditValue) != "" && is_numeric($this->schoolUserId->EditValue)) {
            $this->schoolUserId->EditValue = FormatNumber($this->schoolUserId->EditValue, null);
        }

        // age
        $this->age->setupEditAttributes();
        $this->age->EditCustomAttributes = "";
        $this->age->EditValue = $this->age->CurrentValue;
        $this->age->EditValue = FormatNumber($this->age->EditValue, $this->age->formatPattern());
        $this->age->ViewCustomAttributes = "";

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
                    $doc->exportCaption($this->birthdate);
                    $doc->exportCaption($this->gender);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->countryId);
                    $doc->exportCaption($this->UFId);
                    $doc->exportCaption($this->cityId);
                    $doc->exportCaption($this->zip);
                    $doc->exportCaption($this->celphone);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->facebook);
                    $doc->exportCaption($this->instagram);
                    $doc->exportCaption($this->father);
                    $doc->exportCaption($this->fatherCellphone);
                    $doc->exportCaption($this->receiveSmsFather);
                    $doc->exportCaption($this->fatherEmail);
                    $doc->exportCaption($this->receiveEmailFather);
                    $doc->exportCaption($this->fatherOccupation);
                    $doc->exportCaption($this->fatherBirthdate);
                    $doc->exportCaption($this->mother);
                    $doc->exportCaption($this->motherCellphone);
                    $doc->exportCaption($this->receiveSmsMother);
                    $doc->exportCaption($this->motherEmail);
                    $doc->exportCaption($this->receiveEmailMother);
                    $doc->exportCaption($this->motherOccupation);
                    $doc->exportCaption($this->motherBirthdate);
                    $doc->exportCaption($this->emergencyContact);
                    $doc->exportCaption($this->emergencyFone);
                    $doc->exportCaption($this->obs);
                    $doc->exportCaption($this->modalityId);
                    $doc->exportCaption($this->instructorStatus);
                    $doc->exportCaption($this->martialArtId);
                    $doc->exportCaption($this->rankId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->memberStatusId);
                    $doc->exportCaption($this->photo);
                    $doc->exportCaption($this->beltSize);
                    $doc->exportCaption($this->dobokSize);
                    $doc->exportCaption($this->programId);
                    $doc->exportCaption($this->classId);
                    $doc->exportCaption($this->federationRegister);
                    $doc->exportCaption($this->memberLevelId);
                    $doc->exportCaption($this->instructorLevelId);
                    $doc->exportCaption($this->judgeLevelId);
                    $doc->exportCaption($this->federationRegisterDate);
                    $doc->exportCaption($this->federationStatus);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->lastUserId);
                    $doc->exportCaption($this->marketingSourceId);
                    $doc->exportCaption($this->marketingSourceDetail);
                    $doc->exportCaption($this->age);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->lastName);
                    $doc->exportCaption($this->birthdate);
                    $doc->exportCaption($this->gender);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->countryId);
                    $doc->exportCaption($this->UFId);
                    $doc->exportCaption($this->cityId);
                    $doc->exportCaption($this->zip);
                    $doc->exportCaption($this->celphone);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->facebook);
                    $doc->exportCaption($this->instagram);
                    $doc->exportCaption($this->father);
                    $doc->exportCaption($this->fatherCellphone);
                    $doc->exportCaption($this->receiveSmsFather);
                    $doc->exportCaption($this->fatherEmail);
                    $doc->exportCaption($this->receiveEmailFather);
                    $doc->exportCaption($this->fatherOccupation);
                    $doc->exportCaption($this->fatherBirthdate);
                    $doc->exportCaption($this->mother);
                    $doc->exportCaption($this->motherCellphone);
                    $doc->exportCaption($this->receiveSmsMother);
                    $doc->exportCaption($this->motherEmail);
                    $doc->exportCaption($this->receiveEmailMother);
                    $doc->exportCaption($this->motherOccupation);
                    $doc->exportCaption($this->motherBirthdate);
                    $doc->exportCaption($this->emergencyContact);
                    $doc->exportCaption($this->emergencyFone);
                    $doc->exportCaption($this->modalityId);
                    $doc->exportCaption($this->instructorStatus);
                    $doc->exportCaption($this->martialArtId);
                    $doc->exportCaption($this->rankId);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->memberStatusId);
                    $doc->exportCaption($this->photo);
                    $doc->exportCaption($this->beltSize);
                    $doc->exportCaption($this->dobokSize);
                    $doc->exportCaption($this->programId);
                    $doc->exportCaption($this->classId);
                    $doc->exportCaption($this->federationRegister);
                    $doc->exportCaption($this->memberLevelId);
                    $doc->exportCaption($this->instructorLevelId);
                    $doc->exportCaption($this->judgeLevelId);
                    $doc->exportCaption($this->federationRegisterDate);
                    $doc->exportCaption($this->federationStatus);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->lastUpdate);
                    $doc->exportCaption($this->lastUserId);
                    $doc->exportCaption($this->marketingSourceId);
                    $doc->exportCaption($this->marketingSourceDetail);
                    $doc->exportCaption($this->memberTypeId);
                    $doc->exportCaption($this->schoolUserId);
                    $doc->exportCaption($this->age);
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
                        $doc->exportField($this->birthdate);
                        $doc->exportField($this->gender);
                        $doc->exportField($this->address);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->countryId);
                        $doc->exportField($this->UFId);
                        $doc->exportField($this->cityId);
                        $doc->exportField($this->zip);
                        $doc->exportField($this->celphone);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->facebook);
                        $doc->exportField($this->instagram);
                        $doc->exportField($this->father);
                        $doc->exportField($this->fatherCellphone);
                        $doc->exportField($this->receiveSmsFather);
                        $doc->exportField($this->fatherEmail);
                        $doc->exportField($this->receiveEmailFather);
                        $doc->exportField($this->fatherOccupation);
                        $doc->exportField($this->fatherBirthdate);
                        $doc->exportField($this->mother);
                        $doc->exportField($this->motherCellphone);
                        $doc->exportField($this->receiveSmsMother);
                        $doc->exportField($this->motherEmail);
                        $doc->exportField($this->receiveEmailMother);
                        $doc->exportField($this->motherOccupation);
                        $doc->exportField($this->motherBirthdate);
                        $doc->exportField($this->emergencyContact);
                        $doc->exportField($this->emergencyFone);
                        $doc->exportField($this->obs);
                        $doc->exportField($this->modalityId);
                        $doc->exportField($this->instructorStatus);
                        $doc->exportField($this->martialArtId);
                        $doc->exportField($this->rankId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->memberStatusId);
                        $doc->exportField($this->photo);
                        $doc->exportField($this->beltSize);
                        $doc->exportField($this->dobokSize);
                        $doc->exportField($this->programId);
                        $doc->exportField($this->classId);
                        $doc->exportField($this->federationRegister);
                        $doc->exportField($this->memberLevelId);
                        $doc->exportField($this->instructorLevelId);
                        $doc->exportField($this->judgeLevelId);
                        $doc->exportField($this->federationRegisterDate);
                        $doc->exportField($this->federationStatus);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->lastUserId);
                        $doc->exportField($this->marketingSourceId);
                        $doc->exportField($this->marketingSourceDetail);
                        $doc->exportField($this->age);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->lastName);
                        $doc->exportField($this->birthdate);
                        $doc->exportField($this->gender);
                        $doc->exportField($this->address);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->countryId);
                        $doc->exportField($this->UFId);
                        $doc->exportField($this->cityId);
                        $doc->exportField($this->zip);
                        $doc->exportField($this->celphone);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->facebook);
                        $doc->exportField($this->instagram);
                        $doc->exportField($this->father);
                        $doc->exportField($this->fatherCellphone);
                        $doc->exportField($this->receiveSmsFather);
                        $doc->exportField($this->fatherEmail);
                        $doc->exportField($this->receiveEmailFather);
                        $doc->exportField($this->fatherOccupation);
                        $doc->exportField($this->fatherBirthdate);
                        $doc->exportField($this->mother);
                        $doc->exportField($this->motherCellphone);
                        $doc->exportField($this->receiveSmsMother);
                        $doc->exportField($this->motherEmail);
                        $doc->exportField($this->receiveEmailMother);
                        $doc->exportField($this->motherOccupation);
                        $doc->exportField($this->motherBirthdate);
                        $doc->exportField($this->emergencyContact);
                        $doc->exportField($this->emergencyFone);
                        $doc->exportField($this->modalityId);
                        $doc->exportField($this->instructorStatus);
                        $doc->exportField($this->martialArtId);
                        $doc->exportField($this->rankId);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->memberStatusId);
                        $doc->exportField($this->photo);
                        $doc->exportField($this->beltSize);
                        $doc->exportField($this->dobokSize);
                        $doc->exportField($this->programId);
                        $doc->exportField($this->classId);
                        $doc->exportField($this->federationRegister);
                        $doc->exportField($this->memberLevelId);
                        $doc->exportField($this->instructorLevelId);
                        $doc->exportField($this->judgeLevelId);
                        $doc->exportField($this->federationRegisterDate);
                        $doc->exportField($this->federationStatus);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->lastUpdate);
                        $doc->exportField($this->lastUserId);
                        $doc->exportField($this->marketingSourceId);
                        $doc->exportField($this->marketingSourceDetail);
                        $doc->exportField($this->memberTypeId);
                        $doc->exportField($this->schoolUserId);
                        $doc->exportField($this->age);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `school_member`";
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

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'photo') {
            $fldName = "photo";
            $fileNameFld = "photo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
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
            $rsnew['createDate'] = ExecuteScalar("SELECT NOW()");
            $rsnew['createUserId'] = CurrentUserID();

            // calculando a idade
            try {           
                $dateOfBirth = $rsnew['birthdate'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($dateOfBirth), date_create($today));
                echo 'Your age is '.$diff->format('%y');
                $rsnew['age'] = $diff->format('%y');
            } catch (\Throwable $th) {
               return false;
               $this->setFailureMessage("Age Calc Error. Please try again");
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
        if (hasLogin() && !isAdmin()) {
            $schoolId = CurrentUserID(); // Essa função está configurada para retornar o ID da escola no Advanced
                 if ($schoolId != null) {
                     $country = ExecuteScalar('SELECT countryId FROM fed_school WHERE id = ' . $schoolId . ' ');
                     $state = ExecuteScalar('SELECT ufId FROM fed_school WHERE id = ' . $schoolId . '');
                     $city = ExecuteScalar('SELECT cityId FROM fed_school WHERE id = ' . $schoolId . '');
                     (isset($country)) ? $this->countryId->CurrentValue = $country : $this->countryId->CurrentValue;
                     (isset($state)) ? $this->UFId->CurrentValue = $state : $this->UFId->CurrentValue;
                     (isset($city)) ? $this->cityId->CurrentValue = $city : $this->cityId->CurrentValue;
                 }
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
