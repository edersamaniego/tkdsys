<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fed_applicationschool
 */
class FedApplicationschool extends DbTable
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
    public $masterSchoolId;
    public $school;
    public $countryId;
    public $UFId;
    public $cityId;
    public $neighborhood;
    public $address;
    public $zipcode;
    public $website;
    public $_email;
    public $phone;
    public $celphone;
    public $logo;
    public $openingDate;
    public $federationRegister;
    public $createUserId;
    public $createDate;
    public $typeId;
    public $owner;
    public $identityNumber;
    public $birthDateOwner;
    public $ownerCountryId;
    public $ownerStateId;
    public $ownCityId;
    public $ownerTelephone;
    public $ownerTelephoneWork;
    public $ownerProfession;
    public $employer;
    public $ownerGraduation;
    public $ownerGraduationLocation;
    public $ownerGraduationObs;
    public $ownerMaritalStatus;
    public $ownerSpouseName;
    public $ownerSpouseProfession;
    public $propertySituation;
    public $numberOfStudentsInBeginnig;
    public $ownerAbout;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fed_applicationschool';
        $this->TableName = 'fed_applicationschool';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fed_applicationschool`";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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

        // federationId
        $this->federationId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_federationId',
            'federationId',
            '`federationId`',
            '`federationId`',
            3,
            11,
            -1,
            false,
            '`EV__federationId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->federationId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","ceo","",""], [], ["x_masterSchoolId"], [], [], [], [], '', '', "CONCAT(COALESCE(`federation`, ''),'" . ValueSeparator(1, $this->federationId) . "',COALESCE(`ceo`,''))");
                break;
            case "pt-BR":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","ceo","",""], [], ["x_masterSchoolId"], [], [], [], [], '', '', "CONCAT(COALESCE(`federation`, ''),'" . ValueSeparator(1, $this->federationId) . "',COALESCE(`ceo`,''))");
                break;
            case "es":
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","ceo","",""], [], ["x_masterSchoolId"], [], [], [], [], '', '', "CONCAT(COALESCE(`federation`, ''),'" . ValueSeparator(1, $this->federationId) . "',COALESCE(`ceo`,''))");
                break;
            default:
                $this->federationId->Lookup = new Lookup('federationId', 'fed_federation', false, 'id', ["federation","ceo","",""], [], ["x_masterSchoolId"], [], [], [], [], '', '', "CONCAT(COALESCE(`federation`, ''),'" . ValueSeparator(1, $this->federationId) . "',COALESCE(`ceo`,''))");
                break;
        }
        $this->federationId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['federationId'] = &$this->federationId;

        // masterSchoolId
        $this->masterSchoolId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_masterSchoolId',
            'masterSchoolId',
            '`masterSchoolId`',
            '`masterSchoolId`',
            3,
            11,
            -1,
            false,
            '`EV__masterSchoolId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->masterSchoolId->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'masterSchoolId', ["school","owner","",""], ["x_federationId"], [], ["federationId"], ["x_federationId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchoolId) . "',COALESCE(`owner`,''))");
                break;
            case "pt-BR":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'masterSchoolId', ["school","owner","",""], ["x_federationId"], [], ["federationId"], ["x_federationId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchoolId) . "',COALESCE(`owner`,''))");
                break;
            case "es":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'masterSchoolId', ["school","owner","",""], ["x_federationId"], [], ["federationId"], ["x_federationId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchoolId) . "',COALESCE(`owner`,''))");
                break;
            default:
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'masterSchoolId', ["school","owner","",""], ["x_federationId"], [], ["federationId"], ["x_federationId"], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->masterSchoolId) . "',COALESCE(`owner`,''))");
                break;
        }
        $this->masterSchoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['masterSchoolId'] = &$this->masterSchoolId;

        // school
        $this->school = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_school',
            'school',
            '`school`',
            '`school`',
            200,
            45,
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
        $this->school->Required = true; // Required field
        $this->Fields['school'] = &$this->school;

        // countryId
        $this->countryId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->countryId->Required = true; // Required field
        $this->countryId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->countryId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            case "pt-BR":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            case "es":
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            default:
                $this->countryId->Lookup = new Lookup('countryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_UFId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
        }
        $this->countryId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['countryId'] = &$this->countryId;

        // UFId
        $this->UFId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->UFId->Required = true; // Required field
        $this->UFId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->UFId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], ["id"], ["x_cityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,''))");
                break;
            case "pt-BR":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], ["id"], ["x_cityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,''))");
                break;
            case "es":
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], ["id"], ["x_cityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,''))");
                break;
            default:
                $this->UFId->Lookup = new Lookup('UFId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_countryId"], ["x_cityId"], ["countryId"], ["x_countryId"], ["id"], ["x_cityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,''))");
                break;
        }
        $this->UFId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['UFId'] = &$this->UFId;

        // cityId
        $this->cityId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->cityId->Required = true; // Required field
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

        // neighborhood
        $this->neighborhood = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_neighborhood',
            'neighborhood',
            '`neighborhood`',
            '`neighborhood`',
            200,
            45,
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
        $this->neighborhood->Required = true; // Required field
        $this->Fields['neighborhood'] = &$this->neighborhood;

        // address
        $this->address = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->address->Required = true; // Required field
        $this->Fields['address'] = &$this->address;

        // zipcode
        $this->zipcode = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_zipcode',
            'zipcode',
            '`zipcode`',
            '`zipcode`',
            200,
            8,
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
        $this->zipcode->Required = true; // Required field
        $this->Fields['zipcode'] = &$this->zipcode;

        // website
        $this->website = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_website',
            'website',
            '`website`',
            '`website`',
            200,
            100,
            -1,
            false,
            '`website`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->website->InputTextType = "text";
        $this->Fields['website'] = &$this->website;

        // email
        $this->_email = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->_email->Required = true; // Required field
        $this->Fields['email'] = &$this->_email;

        // phone
        $this->phone = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_phone',
            'phone',
            '`phone`',
            '`phone`',
            200,
            45,
            -1,
            false,
            '`phone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->phone->InputTextType = "text";
        $this->phone->Required = true; // Required field
        $this->Fields['phone'] = &$this->phone;

        // celphone
        $this->celphone = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
        $this->celphone->Required = true; // Required field
        $this->Fields['celphone'] = &$this->celphone;

        // logo
        $this->logo = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_logo',
            'logo',
            '`logo`',
            '`logo`',
            200,
            45,
            -1,
            true,
            '`logo`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->logo->InputTextType = "text";
        $this->Fields['logo'] = &$this->logo;

        // openingDate
        $this->openingDate = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_openingDate',
            'openingDate',
            '`openingDate`',
            CastDateFieldForLike("`openingDate`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`openingDate`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->openingDate->InputTextType = "text";
        $this->openingDate->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['openingDate'] = &$this->openingDate;

        // federationRegister
        $this->federationRegister = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_federationRegister',
            'federationRegister',
            '`federationRegister`',
            '`federationRegister`',
            200,
            6,
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

        // createUserId
        $this->createUserId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
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
            'fed_applicationschool',
            'fed_applicationschool',
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

        // typeId
        $this->typeId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_typeId',
            'typeId',
            '`typeId`',
            '`typeId`',
            3,
            11,
            -1,
            false,
            '`typeId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->typeId->InputTextType = "text";
        $this->typeId->Required = true; // Required field
        $this->typeId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->typeId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->typeId->Lookup = new Lookup('typeId', 'conf_schooltype', false, 'id', ["typeEn","","",""], [], [], [], [], [], [], '', '', "`typeEn`");
                break;
            case "pt-BR":
                $this->typeId->Lookup = new Lookup('typeId', 'conf_schooltype', false, 'id', ["typeBr","","",""], [], [], [], [], [], [], '', '', "`typeBr`");
                break;
            case "es":
                $this->typeId->Lookup = new Lookup('typeId', 'conf_schooltype', false, 'id', ["typeEs","","",""], [], [], [], [], [], [], '', '', "`typeEs`");
                break;
            default:
                $this->typeId->Lookup = new Lookup('typeId', 'conf_schooltype', false, 'id', ["typeBr","","",""], [], [], [], [], [], [], '', '', "`typeBr`");
                break;
        }
        $this->typeId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['typeId'] = &$this->typeId;

        // owner
        $this->owner = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_owner',
            'owner',
            '`owner`',
            '`owner`',
            200,
            45,
            -1,
            false,
            '`owner`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->owner->InputTextType = "text";
        $this->owner->Required = true; // Required field
        $this->Fields['owner'] = &$this->owner;

        // identityNumber
        $this->identityNumber = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_identityNumber',
            'identityNumber',
            '`identityNumber`',
            '`identityNumber`',
            200,
            255,
            -1,
            false,
            '`identityNumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->identityNumber->InputTextType = "text";
        $this->identityNumber->Required = true; // Required field
        $this->Fields['identityNumber'] = &$this->identityNumber;

        // birthDateOwner
        $this->birthDateOwner = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_birthDateOwner',
            'birthDateOwner',
            '`birthDateOwner`',
            CastDateFieldForLike("`birthDateOwner`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`birthDateOwner`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->birthDateOwner->InputTextType = "text";
        $this->birthDateOwner->Required = true; // Required field
        $this->birthDateOwner->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['birthDateOwner'] = &$this->birthDateOwner;

        // ownerCountryId
        $this->ownerCountryId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerCountryId',
            'ownerCountryId',
            '`ownerCountryId`',
            '`ownerCountryId`',
            3,
            11,
            -1,
            false,
            '`EV__ownerCountryId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->ownerCountryId->InputTextType = "text";
        $this->ownerCountryId->Required = true; // Required field
        $this->ownerCountryId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ownerCountryId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->ownerCountryId->Lookup = new Lookup('ownerCountryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_ownerStateId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            case "pt-BR":
                $this->ownerCountryId->Lookup = new Lookup('ownerCountryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_ownerStateId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            case "es":
                $this->ownerCountryId->Lookup = new Lookup('ownerCountryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_ownerStateId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
            default:
                $this->ownerCountryId->Lookup = new Lookup('ownerCountryId', 'conf_country', false, 'id', ["country","","",""], [], ["x_ownerStateId"], [], [], ["id"], ["x_UFId"], '', '', "`country`");
                break;
        }
        $this->ownerCountryId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerCountryId'] = &$this->ownerCountryId;

        // ownerStateId
        $this->ownerStateId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerStateId',
            'ownerStateId',
            '`ownerStateId`',
            '`ownerStateId`',
            3,
            11,
            -1,
            false,
            '`EV__ownerStateId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->ownerStateId->InputTextType = "text";
        $this->ownerStateId->Required = true; // Required field
        $this->ownerStateId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ownerStateId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->ownerStateId->Lookup = new Lookup('ownerStateId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_ownerCountryId"], ["x_ownCityId"], ["countryId"], ["x_countryId"], ["id"], ["x_ownCityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->ownerStateId) . "',COALESCE(`abbreviation`,''))");
                break;
            case "pt-BR":
                $this->ownerStateId->Lookup = new Lookup('ownerStateId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_ownerCountryId"], ["x_ownCityId"], ["countryId"], ["x_countryId"], ["id"], ["x_ownCityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->ownerStateId) . "',COALESCE(`abbreviation`,''))");
                break;
            case "es":
                $this->ownerStateId->Lookup = new Lookup('ownerStateId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_ownerCountryId"], ["x_ownCityId"], ["countryId"], ["x_countryId"], ["id"], ["x_ownCityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->ownerStateId) . "',COALESCE(`abbreviation`,''))");
                break;
            default:
                $this->ownerStateId->Lookup = new Lookup('ownerStateId', 'conf_uf', false, 'id', ["UF","abbreviation","",""], ["x_ownerCountryId"], ["x_ownCityId"], ["countryId"], ["x_countryId"], ["id"], ["x_ownCityId"], '', '', "CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->ownerStateId) . "',COALESCE(`abbreviation`,''))");
                break;
        }
        $this->ownerStateId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerStateId'] = &$this->ownerStateId;

        // ownCityId
        $this->ownCityId = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownCityId',
            'ownCityId',
            '`ownCityId`',
            '`ownCityId`',
            3,
            11,
            -1,
            false,
            '`EV__ownCityId`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->ownCityId->InputTextType = "text";
        $this->ownCityId->Required = true; // Required field
        $this->ownCityId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ownCityId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->ownCityId->Lookup = new Lookup('ownCityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_ownerStateId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->ownCityId) . "',COALESCE(`uf`,''))");
                break;
            case "pt-BR":
                $this->ownCityId->Lookup = new Lookup('ownCityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_ownerStateId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->ownCityId) . "',COALESCE(`uf`,''))");
                break;
            case "es":
                $this->ownCityId->Lookup = new Lookup('ownCityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_ownerStateId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->ownCityId) . "',COALESCE(`uf`,''))");
                break;
            default:
                $this->ownCityId->Lookup = new Lookup('ownCityId', 'conf_city', false, 'id', ["city","uf","",""], ["x_ownerStateId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->ownCityId) . "',COALESCE(`uf`,''))");
                break;
        }
        $this->ownCityId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownCityId'] = &$this->ownCityId;

        // ownerTelephone
        $this->ownerTelephone = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerTelephone',
            'ownerTelephone',
            '`ownerTelephone`',
            '`ownerTelephone`',
            200,
            255,
            -1,
            false,
            '`ownerTelephone`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerTelephone->InputTextType = "text";
        $this->ownerTelephone->Required = true; // Required field
        $this->Fields['ownerTelephone'] = &$this->ownerTelephone;

        // ownerTelephoneWork
        $this->ownerTelephoneWork = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerTelephoneWork',
            'ownerTelephoneWork',
            '`ownerTelephoneWork`',
            '`ownerTelephoneWork`',
            200,
            255,
            -1,
            false,
            '`ownerTelephoneWork`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerTelephoneWork->InputTextType = "text";
        $this->Fields['ownerTelephoneWork'] = &$this->ownerTelephoneWork;

        // ownerProfession
        $this->ownerProfession = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerProfession',
            'ownerProfession',
            '`ownerProfession`',
            '`ownerProfession`',
            200,
            255,
            -1,
            false,
            '`ownerProfession`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerProfession->InputTextType = "text";
        $this->Fields['ownerProfession'] = &$this->ownerProfession;

        // employer
        $this->employer = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_employer',
            'employer',
            '`employer`',
            '`employer`',
            200,
            255,
            -1,
            false,
            '`employer`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->employer->InputTextType = "text";
        $this->Fields['employer'] = &$this->employer;

        // ownerGraduation
        $this->ownerGraduation = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerGraduation',
            'ownerGraduation',
            '`ownerGraduation`',
            '`ownerGraduation`',
            3,
            11,
            -1,
            false,
            '`ownerGraduation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->ownerGraduation->InputTextType = "text";
        $this->ownerGraduation->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ownerGraduation->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->ownerGraduation->Lookup = new Lookup('ownerGraduation', 'conf_scholarity', false, 'id', ["escolarityEN","","",""], [], [], [], [], [], [], '', '', "`escolarityEN`");
                break;
            case "pt-BR":
                $this->ownerGraduation->Lookup = new Lookup('ownerGraduation', 'conf_scholarity', false, 'id', ["escolarityEN","","",""], [], [], [], [], [], [], '', '', "`escolarityEN`");
                break;
            case "es":
                $this->ownerGraduation->Lookup = new Lookup('ownerGraduation', 'conf_scholarity', false, 'id', ["escolarityEN","","",""], [], [], [], [], [], [], '', '', "`escolarityEN`");
                break;
            default:
                $this->ownerGraduation->Lookup = new Lookup('ownerGraduation', 'conf_scholarity', false, 'id', ["escolarityEN","","",""], [], [], [], [], [], [], '', '', "`escolarityEN`");
                break;
        }
        $this->ownerGraduation->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerGraduation'] = &$this->ownerGraduation;

        // ownerGraduationLocation
        $this->ownerGraduationLocation = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerGraduationLocation',
            'ownerGraduationLocation',
            '`ownerGraduationLocation`',
            '`ownerGraduationLocation`',
            200,
            255,
            -1,
            false,
            '`ownerGraduationLocation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerGraduationLocation->InputTextType = "text";
        $this->Fields['ownerGraduationLocation'] = &$this->ownerGraduationLocation;

        // ownerGraduationObs
        $this->ownerGraduationObs = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerGraduationObs',
            'ownerGraduationObs',
            '`ownerGraduationObs`',
            '`ownerGraduationObs`',
            201,
            65535,
            -1,
            false,
            '`ownerGraduationObs`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->ownerGraduationObs->InputTextType = "text";
        $this->Fields['ownerGraduationObs'] = &$this->ownerGraduationObs;

        // ownerMaritalStatus
        $this->ownerMaritalStatus = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerMaritalStatus',
            'ownerMaritalStatus',
            '`ownerMaritalStatus`',
            '`ownerMaritalStatus`',
            3,
            11,
            -1,
            false,
            '`ownerMaritalStatus`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->ownerMaritalStatus->InputTextType = "text";
        $this->ownerMaritalStatus->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->ownerMaritalStatus->Lookup = new Lookup('ownerMaritalStatus', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->ownerMaritalStatus->Lookup = new Lookup('ownerMaritalStatus', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->ownerMaritalStatus->Lookup = new Lookup('ownerMaritalStatus', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->ownerMaritalStatus->Lookup = new Lookup('ownerMaritalStatus', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->ownerMaritalStatus->OptionCount = 4;
        $this->ownerMaritalStatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerMaritalStatus'] = &$this->ownerMaritalStatus;

        // ownerSpouseName
        $this->ownerSpouseName = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerSpouseName',
            'ownerSpouseName',
            '`ownerSpouseName`',
            '`ownerSpouseName`',
            200,
            255,
            -1,
            false,
            '`ownerSpouseName`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerSpouseName->InputTextType = "text";
        $this->Fields['ownerSpouseName'] = &$this->ownerSpouseName;

        // ownerSpouseProfession
        $this->ownerSpouseProfession = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerSpouseProfession',
            'ownerSpouseProfession',
            '`ownerSpouseProfession`',
            '`ownerSpouseProfession`',
            200,
            255,
            -1,
            false,
            '`ownerSpouseProfession`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerSpouseProfession->InputTextType = "text";
        $this->Fields['ownerSpouseProfession'] = &$this->ownerSpouseProfession;

        // propertySituation
        $this->propertySituation = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_propertySituation',
            'propertySituation',
            '`propertySituation`',
            '`propertySituation`',
            3,
            11,
            -1,
            false,
            '`propertySituation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->propertySituation->InputTextType = "text";
        $this->propertySituation->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->propertySituation->Lookup = new Lookup('propertySituation', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->propertySituation->Lookup = new Lookup('propertySituation', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->propertySituation->Lookup = new Lookup('propertySituation', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->propertySituation->Lookup = new Lookup('propertySituation', 'fed_applicationschool', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->propertySituation->OptionCount = 4;
        $this->propertySituation->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['propertySituation'] = &$this->propertySituation;

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_numberOfStudentsInBeginnig',
            'numberOfStudentsInBeginnig',
            '`numberOfStudentsInBeginnig`',
            '`numberOfStudentsInBeginnig`',
            3,
            11,
            -1,
            false,
            '`numberOfStudentsInBeginnig`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->numberOfStudentsInBeginnig->InputTextType = "text";
        $this->numberOfStudentsInBeginnig->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['numberOfStudentsInBeginnig'] = &$this->numberOfStudentsInBeginnig;

        // ownerAbout
        $this->ownerAbout = new DbField(
            'fed_applicationschool',
            'fed_applicationschool',
            'x_ownerAbout',
            'ownerAbout',
            '`ownerAbout`',
            '`ownerAbout`',
            201,
            65535,
            -1,
            false,
            '`ownerAbout`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->ownerAbout->InputTextType = "text";
        $this->Fields['ownerAbout'] = &$this->ownerAbout;

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
        if ($this->getCurrentDetailTable() == "fed_school") {
            $detailUrl = Container("fed_school")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "fed_licenseschool") {
            $detailUrl = Container("fed_licenseschool")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "FedApplicationschoolList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fed_applicationschool`";
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
                $from = "(SELECT *, (SELECT `country` FROM `conf_country` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`countryId` LIMIT 1) AS `EV__countryId`, (SELECT CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,'')) FROM `conf_uf` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`UFId` LIMIT 1) AS `EV__UFId`, (SELECT CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,'')) FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_applicationschool`)";
                break;
            case "pt-BR":
                $from = "(SELECT *, (SELECT `country` FROM `conf_country` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`countryId` LIMIT 1) AS `EV__countryId`, (SELECT CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,'')) FROM `conf_uf` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`UFId` LIMIT 1) AS `EV__UFId`, (SELECT CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,'')) FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_applicationschool`)";
                break;
            case "es":
                $from = "(SELECT *, (SELECT `country` FROM `conf_country` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`countryId` LIMIT 1) AS `EV__countryId`, (SELECT CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,'')) FROM `conf_uf` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`UFId` LIMIT 1) AS `EV__UFId`, (SELECT CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,'')) FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_applicationschool`)";
                break;
            default:
                $from = "(SELECT *, (SELECT `country` FROM `conf_country` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`countryId` LIMIT 1) AS `EV__countryId`, (SELECT CONCAT(COALESCE(`UF`, ''),'" . ValueSeparator(1, $this->UFId) . "',COALESCE(`abbreviation`,'')) FROM `conf_uf` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`UFId` LIMIT 1) AS `EV__UFId`, (SELECT CONCAT(COALESCE(`city`, ''),'" . ValueSeparator(1, $this->cityId) . "',COALESCE(`uf`,'')) FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_applicationschool`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_applicationschool`)";
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
            $this->federationId->AdvancedSearch->SearchValue != "" ||
            $this->federationId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->federationId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->federationId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->masterSchoolId->AdvancedSearch->SearchValue != "" ||
            $this->masterSchoolId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->masterSchoolId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->masterSchoolId->VirtualExpression . " ")) {
            return true;
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
            $this->ownerCountryId->AdvancedSearch->SearchValue != "" ||
            $this->ownerCountryId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->ownerCountryId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->ownerCountryId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->ownerStateId->AdvancedSearch->SearchValue != "" ||
            $this->ownerStateId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->ownerStateId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->ownerStateId->VirtualExpression . " ")) {
            return true;
        }
        if (
            $this->ownCityId->AdvancedSearch->SearchValue != "" ||
            $this->ownCityId->AdvancedSearch->SearchValue2 != "" ||
            ContainsString($where, " " . $this->ownCityId->VirtualExpression . " ")
        ) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->ownCityId->VirtualExpression . " ")) {
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
        // Cascade Update detail table 'fed_licenseschool'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'application'
            $cascadeUpdate = true;
            $rscascade['application'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("fed_licenseschool")->loadRs("`application` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("fed_licenseschool")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("fed_licenseschool")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("fed_licenseschool")->rowUpdated($rsdtlold, $rsdtlnew);
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

        // Cascade delete detail table 'fed_licenseschool'
        $dtlrows = Container("fed_licenseschool")->loadRs("`application` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("fed_licenseschool")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("fed_licenseschool")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("fed_licenseschool")->rowDeleted($dtlrow);
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
        $this->federationId->DbValue = $row['federationId'];
        $this->masterSchoolId->DbValue = $row['masterSchoolId'];
        $this->school->DbValue = $row['school'];
        $this->countryId->DbValue = $row['countryId'];
        $this->UFId->DbValue = $row['UFId'];
        $this->cityId->DbValue = $row['cityId'];
        $this->neighborhood->DbValue = $row['neighborhood'];
        $this->address->DbValue = $row['address'];
        $this->zipcode->DbValue = $row['zipcode'];
        $this->website->DbValue = $row['website'];
        $this->_email->DbValue = $row['email'];
        $this->phone->DbValue = $row['phone'];
        $this->celphone->DbValue = $row['celphone'];
        $this->logo->Upload->DbValue = $row['logo'];
        $this->openingDate->DbValue = $row['openingDate'];
        $this->federationRegister->DbValue = $row['federationRegister'];
        $this->createUserId->DbValue = $row['createUserId'];
        $this->createDate->DbValue = $row['createDate'];
        $this->typeId->DbValue = $row['typeId'];
        $this->owner->DbValue = $row['owner'];
        $this->identityNumber->DbValue = $row['identityNumber'];
        $this->birthDateOwner->DbValue = $row['birthDateOwner'];
        $this->ownerCountryId->DbValue = $row['ownerCountryId'];
        $this->ownerStateId->DbValue = $row['ownerStateId'];
        $this->ownCityId->DbValue = $row['ownCityId'];
        $this->ownerTelephone->DbValue = $row['ownerTelephone'];
        $this->ownerTelephoneWork->DbValue = $row['ownerTelephoneWork'];
        $this->ownerProfession->DbValue = $row['ownerProfession'];
        $this->employer->DbValue = $row['employer'];
        $this->ownerGraduation->DbValue = $row['ownerGraduation'];
        $this->ownerGraduationLocation->DbValue = $row['ownerGraduationLocation'];
        $this->ownerGraduationObs->DbValue = $row['ownerGraduationObs'];
        $this->ownerMaritalStatus->DbValue = $row['ownerMaritalStatus'];
        $this->ownerSpouseName->DbValue = $row['ownerSpouseName'];
        $this->ownerSpouseProfession->DbValue = $row['ownerSpouseProfession'];
        $this->propertySituation->DbValue = $row['propertySituation'];
        $this->numberOfStudentsInBeginnig->DbValue = $row['numberOfStudentsInBeginnig'];
        $this->ownerAbout->DbValue = $row['ownerAbout'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['logo']) ? [] : [$row['logo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->logo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->logo->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("FedApplicationschoolList");
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
        if ($pageName == "FedApplicationschoolView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FedApplicationschoolEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FedApplicationschoolAdd") {
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
                return "FedApplicationschoolView";
            case Config("API_ADD_ACTION"):
                return "FedApplicationschoolAdd";
            case Config("API_EDIT_ACTION"):
                return "FedApplicationschoolEdit";
            case Config("API_DELETE_ACTION"):
                return "FedApplicationschoolDelete";
            case Config("API_LIST_ACTION"):
                return "FedApplicationschoolList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FedApplicationschoolList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedApplicationschoolView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedApplicationschoolView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FedApplicationschoolAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FedApplicationschoolAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedApplicationschoolEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedApplicationschoolEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("FedApplicationschoolAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedApplicationschoolAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("FedApplicationschoolDelete", $this->getUrlParm());
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
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
        $this->school->setDbValue($row['school']);
        $this->countryId->setDbValue($row['countryId']);
        $this->UFId->setDbValue($row['UFId']);
        $this->cityId->setDbValue($row['cityId']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->address->setDbValue($row['address']);
        $this->zipcode->setDbValue($row['zipcode']);
        $this->website->setDbValue($row['website']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->celphone->setDbValue($row['celphone']);
        $this->logo->Upload->DbValue = $row['logo'];
        $this->openingDate->setDbValue($row['openingDate']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->typeId->setDbValue($row['typeId']);
        $this->owner->setDbValue($row['owner']);
        $this->identityNumber->setDbValue($row['identityNumber']);
        $this->birthDateOwner->setDbValue($row['birthDateOwner']);
        $this->ownerCountryId->setDbValue($row['ownerCountryId']);
        $this->ownerStateId->setDbValue($row['ownerStateId']);
        $this->ownCityId->setDbValue($row['ownCityId']);
        $this->ownerTelephone->setDbValue($row['ownerTelephone']);
        $this->ownerTelephoneWork->setDbValue($row['ownerTelephoneWork']);
        $this->ownerProfession->setDbValue($row['ownerProfession']);
        $this->employer->setDbValue($row['employer']);
        $this->ownerGraduation->setDbValue($row['ownerGraduation']);
        $this->ownerGraduationLocation->setDbValue($row['ownerGraduationLocation']);
        $this->ownerGraduationObs->setDbValue($row['ownerGraduationObs']);
        $this->ownerMaritalStatus->setDbValue($row['ownerMaritalStatus']);
        $this->ownerSpouseName->setDbValue($row['ownerSpouseName']);
        $this->ownerSpouseProfession->setDbValue($row['ownerSpouseProfession']);
        $this->propertySituation->setDbValue($row['propertySituation']);
        $this->numberOfStudentsInBeginnig->setDbValue($row['numberOfStudentsInBeginnig']);
        $this->ownerAbout->setDbValue($row['ownerAbout']);
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

        // masterSchoolId

        // school

        // countryId

        // UFId

        // cityId

        // neighborhood

        // address

        // zipcode

        // website

        // email

        // phone

        // celphone

        // logo

        // openingDate

        // federationRegister

        // createUserId

        // createDate

        // typeId

        // owner

        // identityNumber

        // birthDateOwner

        // ownerCountryId

        // ownerStateId

        // ownCityId

        // ownerTelephone

        // ownerTelephoneWork

        // ownerProfession

        // employer

        // ownerGraduation

        // ownerGraduationLocation

        // ownerGraduationObs

        // ownerMaritalStatus

        // ownerSpouseName

        // ownerSpouseProfession

        // propertySituation

        // numberOfStudentsInBeginnig

        // ownerAbout

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // federationId
        if ($this->federationId->VirtualValue != "") {
            $this->federationId->ViewValue = $this->federationId->VirtualValue;
        } else {
            $this->federationId->ViewValue = $this->federationId->CurrentValue;
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
        }
        $this->federationId->ViewCustomAttributes = "";

        // masterSchoolId
        if ($this->masterSchoolId->VirtualValue != "") {
            $this->masterSchoolId->ViewValue = $this->masterSchoolId->VirtualValue;
        } else {
            $this->masterSchoolId->ViewValue = $this->masterSchoolId->CurrentValue;
            $curVal = strval($this->masterSchoolId->CurrentValue);
            if ($curVal != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
                if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`masterSchoolId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
        }
        $this->masterSchoolId->ViewCustomAttributes = "";

        // school
        $this->school->ViewValue = $this->school->CurrentValue;
        $this->school->ViewCustomAttributes = "";

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

        // neighborhood
        $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
        $this->neighborhood->ViewCustomAttributes = "";

        // address
        $this->address->ViewValue = $this->address->CurrentValue;
        $this->address->ViewCustomAttributes = "";

        // zipcode
        $this->zipcode->ViewValue = $this->zipcode->CurrentValue;
        $this->zipcode->ViewCustomAttributes = "";

        // website
        $this->website->ViewValue = $this->website->CurrentValue;
        $this->website->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // phone
        $this->phone->ViewValue = $this->phone->CurrentValue;
        $this->phone->ViewCustomAttributes = "";

        // celphone
        $this->celphone->ViewValue = $this->celphone->CurrentValue;
        $this->celphone->ViewCustomAttributes = "";

        // logo
        if (!EmptyValue($this->logo->Upload->DbValue)) {
            $this->logo->ImageWidth = 120;
            $this->logo->ImageHeight = 120;
            $this->logo->ImageAlt = $this->logo->alt();
            $this->logo->ImageCssClass = "ew-image";
            $this->logo->ViewValue = $this->logo->Upload->DbValue;
        } else {
            $this->logo->ViewValue = "";
        }
        $this->logo->ViewCustomAttributes = "";

        // openingDate
        $this->openingDate->ViewValue = $this->openingDate->CurrentValue;
        $this->openingDate->ViewValue = FormatDateTime($this->openingDate->ViewValue, $this->openingDate->formatPattern());
        $this->openingDate->ViewCustomAttributes = "";

        // federationRegister
        $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
        $this->federationRegister->ViewCustomAttributes = "";

        // createUserId
        $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
        $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
        $this->createUserId->ViewCustomAttributes = "";

        // createDate
        $this->createDate->ViewValue = $this->createDate->CurrentValue;
        $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
        $this->createDate->ViewCustomAttributes = "";

        // typeId
        $curVal = strval($this->typeId->CurrentValue);
        if ($curVal != "") {
            $this->typeId->ViewValue = $this->typeId->lookupCacheOption($curVal);
            if ($this->typeId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`id` = 5";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->typeId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->typeId->Lookup->renderViewRow($rswrk[0]);
                    $this->typeId->ViewValue = $this->typeId->displayValue($arwrk);
                } else {
                    $this->typeId->ViewValue = FormatNumber($this->typeId->CurrentValue, $this->typeId->formatPattern());
                }
            }
        } else {
            $this->typeId->ViewValue = null;
        }
        $this->typeId->ViewCustomAttributes = "";

        // owner
        $this->owner->ViewValue = $this->owner->CurrentValue;
        $this->owner->ViewCustomAttributes = "";

        // identityNumber
        $this->identityNumber->ViewValue = $this->identityNumber->CurrentValue;
        $this->identityNumber->ViewCustomAttributes = "";

        // birthDateOwner
        $this->birthDateOwner->ViewValue = $this->birthDateOwner->CurrentValue;
        $this->birthDateOwner->ViewValue = FormatDateTime($this->birthDateOwner->ViewValue, $this->birthDateOwner->formatPattern());
        $this->birthDateOwner->ViewCustomAttributes = "";

        // ownerCountryId
        if ($this->ownerCountryId->VirtualValue != "") {
            $this->ownerCountryId->ViewValue = $this->ownerCountryId->VirtualValue;
        } else {
            $curVal = strval($this->ownerCountryId->CurrentValue);
            if ($curVal != "") {
                $this->ownerCountryId->ViewValue = $this->ownerCountryId->lookupCacheOption($curVal);
                if ($this->ownerCountryId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ownerCountryId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ownerCountryId->Lookup->renderViewRow($rswrk[0]);
                        $this->ownerCountryId->ViewValue = $this->ownerCountryId->displayValue($arwrk);
                    } else {
                        $this->ownerCountryId->ViewValue = FormatNumber($this->ownerCountryId->CurrentValue, $this->ownerCountryId->formatPattern());
                    }
                }
            } else {
                $this->ownerCountryId->ViewValue = null;
            }
        }
        $this->ownerCountryId->ViewCustomAttributes = "";

        // ownerStateId
        if ($this->ownerStateId->VirtualValue != "") {
            $this->ownerStateId->ViewValue = $this->ownerStateId->VirtualValue;
        } else {
            $curVal = strval($this->ownerStateId->CurrentValue);
            if ($curVal != "") {
                $this->ownerStateId->ViewValue = $this->ownerStateId->lookupCacheOption($curVal);
                if ($this->ownerStateId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ownerStateId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ownerStateId->Lookup->renderViewRow($rswrk[0]);
                        $this->ownerStateId->ViewValue = $this->ownerStateId->displayValue($arwrk);
                    } else {
                        $this->ownerStateId->ViewValue = FormatNumber($this->ownerStateId->CurrentValue, $this->ownerStateId->formatPattern());
                    }
                }
            } else {
                $this->ownerStateId->ViewValue = null;
            }
        }
        $this->ownerStateId->ViewCustomAttributes = "";

        // ownCityId
        if ($this->ownCityId->VirtualValue != "") {
            $this->ownCityId->ViewValue = $this->ownCityId->VirtualValue;
        } else {
            $curVal = strval($this->ownCityId->CurrentValue);
            if ($curVal != "") {
                $this->ownCityId->ViewValue = $this->ownCityId->lookupCacheOption($curVal);
                if ($this->ownCityId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ownCityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ownCityId->Lookup->renderViewRow($rswrk[0]);
                        $this->ownCityId->ViewValue = $this->ownCityId->displayValue($arwrk);
                    } else {
                        $this->ownCityId->ViewValue = FormatNumber($this->ownCityId->CurrentValue, $this->ownCityId->formatPattern());
                    }
                }
            } else {
                $this->ownCityId->ViewValue = null;
            }
        }
        $this->ownCityId->ViewCustomAttributes = "";

        // ownerTelephone
        $this->ownerTelephone->ViewValue = $this->ownerTelephone->CurrentValue;
        $this->ownerTelephone->ViewCustomAttributes = "";

        // ownerTelephoneWork
        $this->ownerTelephoneWork->ViewValue = $this->ownerTelephoneWork->CurrentValue;
        $this->ownerTelephoneWork->ViewCustomAttributes = "";

        // ownerProfession
        $this->ownerProfession->ViewValue = $this->ownerProfession->CurrentValue;
        $this->ownerProfession->ViewCustomAttributes = "";

        // employer
        $this->employer->ViewValue = $this->employer->CurrentValue;
        $this->employer->ViewCustomAttributes = "";

        // ownerGraduation
        $curVal = strval($this->ownerGraduation->CurrentValue);
        if ($curVal != "") {
            $this->ownerGraduation->ViewValue = $this->ownerGraduation->lookupCacheOption($curVal);
            if ($this->ownerGraduation->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->ownerGraduation->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->ownerGraduation->Lookup->renderViewRow($rswrk[0]);
                    $this->ownerGraduation->ViewValue = $this->ownerGraduation->displayValue($arwrk);
                } else {
                    $this->ownerGraduation->ViewValue = FormatNumber($this->ownerGraduation->CurrentValue, $this->ownerGraduation->formatPattern());
                }
            }
        } else {
            $this->ownerGraduation->ViewValue = null;
        }
        $this->ownerGraduation->ViewCustomAttributes = "";

        // ownerGraduationLocation
        $this->ownerGraduationLocation->ViewValue = $this->ownerGraduationLocation->CurrentValue;
        $this->ownerGraduationLocation->ViewCustomAttributes = "";

        // ownerGraduationObs
        $this->ownerGraduationObs->ViewValue = $this->ownerGraduationObs->CurrentValue;
        $this->ownerGraduationObs->ViewCustomAttributes = "";

        // ownerMaritalStatus
        if (strval($this->ownerMaritalStatus->CurrentValue) != "") {
            $this->ownerMaritalStatus->ViewValue = $this->ownerMaritalStatus->optionCaption($this->ownerMaritalStatus->CurrentValue);
        } else {
            $this->ownerMaritalStatus->ViewValue = null;
        }
        $this->ownerMaritalStatus->ViewCustomAttributes = "";

        // ownerSpouseName
        $this->ownerSpouseName->ViewValue = $this->ownerSpouseName->CurrentValue;
        $this->ownerSpouseName->ViewCustomAttributes = "";

        // ownerSpouseProfession
        $this->ownerSpouseProfession->ViewValue = $this->ownerSpouseProfession->CurrentValue;
        $this->ownerSpouseProfession->ViewCustomAttributes = "";

        // propertySituation
        if (strval($this->propertySituation->CurrentValue) != "") {
            $this->propertySituation->ViewValue = $this->propertySituation->optionCaption($this->propertySituation->CurrentValue);
        } else {
            $this->propertySituation->ViewValue = null;
        }
        $this->propertySituation->ViewCustomAttributes = "";

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->ViewValue = $this->numberOfStudentsInBeginnig->CurrentValue;
        $this->numberOfStudentsInBeginnig->ViewValue = FormatNumber($this->numberOfStudentsInBeginnig->ViewValue, $this->numberOfStudentsInBeginnig->formatPattern());
        $this->numberOfStudentsInBeginnig->ViewCustomAttributes = "";

        // ownerAbout
        $this->ownerAbout->ViewValue = $this->ownerAbout->CurrentValue;
        $this->ownerAbout->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // federationId
        $this->federationId->LinkCustomAttributes = "";
        $this->federationId->HrefValue = "";
        $this->federationId->TooltipValue = "";

        // masterSchoolId
        $this->masterSchoolId->LinkCustomAttributes = "";
        $this->masterSchoolId->HrefValue = "";
        $this->masterSchoolId->TooltipValue = "";

        // school
        $this->school->LinkCustomAttributes = "";
        $this->school->HrefValue = "";
        $this->school->TooltipValue = "";

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

        // neighborhood
        $this->neighborhood->LinkCustomAttributes = "";
        $this->neighborhood->HrefValue = "";
        $this->neighborhood->TooltipValue = "";

        // address
        $this->address->LinkCustomAttributes = "";
        $this->address->HrefValue = "";
        $this->address->TooltipValue = "";

        // zipcode
        $this->zipcode->LinkCustomAttributes = "";
        $this->zipcode->HrefValue = "";
        $this->zipcode->TooltipValue = "";

        // website
        $this->website->LinkCustomAttributes = "";
        $this->website->HrefValue = "";
        $this->website->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // phone
        $this->phone->LinkCustomAttributes = "";
        $this->phone->HrefValue = "";
        $this->phone->TooltipValue = "";

        // celphone
        $this->celphone->LinkCustomAttributes = "";
        $this->celphone->HrefValue = "";
        $this->celphone->TooltipValue = "";

        // logo
        $this->logo->LinkCustomAttributes = "";
        if (!EmptyValue($this->logo->Upload->DbValue)) {
            $this->logo->HrefValue = GetFileUploadUrl($this->logo, $this->logo->htmlDecode($this->logo->Upload->DbValue)); // Add prefix/suffix
            $this->logo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->logo->HrefValue = FullUrl($this->logo->HrefValue, "href");
            }
        } else {
            $this->logo->HrefValue = "";
        }
        $this->logo->ExportHrefValue = $this->logo->UploadPath . $this->logo->Upload->DbValue;
        $this->logo->TooltipValue = "";
        if ($this->logo->UseColorbox) {
            if (EmptyValue($this->logo->TooltipValue)) {
                $this->logo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->logo->LinkAttrs["data-rel"] = "fed_applicationschool_x_logo";
            $this->logo->LinkAttrs->appendClass("ew-lightbox");
        }

        // openingDate
        $this->openingDate->LinkCustomAttributes = "";
        $this->openingDate->HrefValue = "";
        $this->openingDate->TooltipValue = "";

        // federationRegister
        $this->federationRegister->LinkCustomAttributes = "";
        $this->federationRegister->HrefValue = "";
        $this->federationRegister->TooltipValue = "";

        // createUserId
        $this->createUserId->LinkCustomAttributes = "";
        $this->createUserId->HrefValue = "";
        $this->createUserId->TooltipValue = "";

        // createDate
        $this->createDate->LinkCustomAttributes = "";
        $this->createDate->HrefValue = "";
        $this->createDate->TooltipValue = "";

        // typeId
        $this->typeId->LinkCustomAttributes = "";
        $this->typeId->HrefValue = "";
        $this->typeId->TooltipValue = "";

        // owner
        $this->owner->LinkCustomAttributes = "";
        $this->owner->HrefValue = "";
        $this->owner->TooltipValue = "";

        // identityNumber
        $this->identityNumber->LinkCustomAttributes = "";
        $this->identityNumber->HrefValue = "";
        $this->identityNumber->TooltipValue = "";

        // birthDateOwner
        $this->birthDateOwner->LinkCustomAttributes = "";
        $this->birthDateOwner->HrefValue = "";
        $this->birthDateOwner->TooltipValue = "";

        // ownerCountryId
        $this->ownerCountryId->LinkCustomAttributes = "";
        $this->ownerCountryId->HrefValue = "";
        $this->ownerCountryId->TooltipValue = "";

        // ownerStateId
        $this->ownerStateId->LinkCustomAttributes = "";
        $this->ownerStateId->HrefValue = "";
        $this->ownerStateId->TooltipValue = "";

        // ownCityId
        $this->ownCityId->LinkCustomAttributes = "";
        $this->ownCityId->HrefValue = "";
        $this->ownCityId->TooltipValue = "";

        // ownerTelephone
        $this->ownerTelephone->LinkCustomAttributes = "";
        $this->ownerTelephone->HrefValue = "";
        $this->ownerTelephone->TooltipValue = "";

        // ownerTelephoneWork
        $this->ownerTelephoneWork->LinkCustomAttributes = "";
        $this->ownerTelephoneWork->HrefValue = "";
        $this->ownerTelephoneWork->TooltipValue = "";

        // ownerProfession
        $this->ownerProfession->LinkCustomAttributes = "";
        $this->ownerProfession->HrefValue = "";
        $this->ownerProfession->TooltipValue = "";

        // employer
        $this->employer->LinkCustomAttributes = "";
        $this->employer->HrefValue = "";
        $this->employer->TooltipValue = "";

        // ownerGraduation
        $this->ownerGraduation->LinkCustomAttributes = "";
        $this->ownerGraduation->HrefValue = "";
        $this->ownerGraduation->TooltipValue = "";

        // ownerGraduationLocation
        $this->ownerGraduationLocation->LinkCustomAttributes = "";
        $this->ownerGraduationLocation->HrefValue = "";
        $this->ownerGraduationLocation->TooltipValue = "";

        // ownerGraduationObs
        $this->ownerGraduationObs->LinkCustomAttributes = "";
        $this->ownerGraduationObs->HrefValue = "";
        $this->ownerGraduationObs->TooltipValue = "";

        // ownerMaritalStatus
        $this->ownerMaritalStatus->LinkCustomAttributes = "";
        $this->ownerMaritalStatus->HrefValue = "";
        $this->ownerMaritalStatus->TooltipValue = "";

        // ownerSpouseName
        $this->ownerSpouseName->LinkCustomAttributes = "";
        $this->ownerSpouseName->HrefValue = "";
        $this->ownerSpouseName->TooltipValue = "";

        // ownerSpouseProfession
        $this->ownerSpouseProfession->LinkCustomAttributes = "";
        $this->ownerSpouseProfession->HrefValue = "";
        $this->ownerSpouseProfession->TooltipValue = "";

        // propertySituation
        $this->propertySituation->LinkCustomAttributes = "";
        $this->propertySituation->HrefValue = "";
        $this->propertySituation->TooltipValue = "";

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->LinkCustomAttributes = "";
        $this->numberOfStudentsInBeginnig->HrefValue = "";
        $this->numberOfStudentsInBeginnig->TooltipValue = "";

        // ownerAbout
        $this->ownerAbout->LinkCustomAttributes = "";
        $this->ownerAbout->HrefValue = "";
        $this->ownerAbout->TooltipValue = "";

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

        // masterSchoolId
        $this->masterSchoolId->setupEditAttributes();
        $this->masterSchoolId->EditCustomAttributes = "";
        $this->masterSchoolId->EditValue = $this->masterSchoolId->CurrentValue;
        $this->masterSchoolId->PlaceHolder = RemoveHtml($this->masterSchoolId->caption());

        // school
        $this->school->setupEditAttributes();
        $this->school->EditCustomAttributes = "";
        if (!$this->school->Raw) {
            $this->school->CurrentValue = HtmlDecode($this->school->CurrentValue);
        }
        $this->school->EditValue = $this->school->CurrentValue;
        $this->school->PlaceHolder = RemoveHtml($this->school->caption());

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

        // neighborhood
        $this->neighborhood->setupEditAttributes();
        $this->neighborhood->EditCustomAttributes = "";
        if (!$this->neighborhood->Raw) {
            $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
        }
        $this->neighborhood->EditValue = $this->neighborhood->CurrentValue;
        $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

        // address
        $this->address->setupEditAttributes();
        $this->address->EditCustomAttributes = "";
        if (!$this->address->Raw) {
            $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
        }
        $this->address->EditValue = $this->address->CurrentValue;
        $this->address->PlaceHolder = RemoveHtml($this->address->caption());

        // zipcode
        $this->zipcode->setupEditAttributes();
        $this->zipcode->EditCustomAttributes = "";
        if (!$this->zipcode->Raw) {
            $this->zipcode->CurrentValue = HtmlDecode($this->zipcode->CurrentValue);
        }
        $this->zipcode->EditValue = $this->zipcode->CurrentValue;
        $this->zipcode->PlaceHolder = RemoveHtml($this->zipcode->caption());

        // website
        $this->website->setupEditAttributes();
        $this->website->EditCustomAttributes = "";
        if (!$this->website->Raw) {
            $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
        }
        $this->website->EditValue = $this->website->CurrentValue;
        $this->website->PlaceHolder = RemoveHtml($this->website->caption());

        // email
        $this->_email->setupEditAttributes();
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // phone
        $this->phone->setupEditAttributes();
        $this->phone->EditCustomAttributes = "";
        if (!$this->phone->Raw) {
            $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
        }
        $this->phone->EditValue = $this->phone->CurrentValue;
        $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

        // celphone
        $this->celphone->setupEditAttributes();
        $this->celphone->EditCustomAttributes = "";
        if (!$this->celphone->Raw) {
            $this->celphone->CurrentValue = HtmlDecode($this->celphone->CurrentValue);
        }
        $this->celphone->EditValue = $this->celphone->CurrentValue;
        $this->celphone->PlaceHolder = RemoveHtml($this->celphone->caption());

        // logo
        $this->logo->setupEditAttributes();
        $this->logo->EditCustomAttributes = "";
        if (!EmptyValue($this->logo->Upload->DbValue)) {
            $this->logo->ImageWidth = 120;
            $this->logo->ImageHeight = 120;
            $this->logo->ImageAlt = $this->logo->alt();
            $this->logo->ImageCssClass = "ew-image";
            $this->logo->EditValue = $this->logo->Upload->DbValue;
        } else {
            $this->logo->EditValue = "";
        }
        if (!EmptyValue($this->logo->CurrentValue)) {
            $this->logo->Upload->FileName = $this->logo->CurrentValue;
        }

        // openingDate
        $this->openingDate->setupEditAttributes();
        $this->openingDate->EditCustomAttributes = "";
        $this->openingDate->EditValue = FormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern());
        $this->openingDate->PlaceHolder = RemoveHtml($this->openingDate->caption());

        // federationRegister
        $this->federationRegister->setupEditAttributes();
        $this->federationRegister->EditCustomAttributes = "";
        if (!$this->federationRegister->Raw) {
            $this->federationRegister->CurrentValue = HtmlDecode($this->federationRegister->CurrentValue);
        }
        $this->federationRegister->EditValue = $this->federationRegister->CurrentValue;
        $this->federationRegister->PlaceHolder = RemoveHtml($this->federationRegister->caption());

        // createUserId

        // createDate
        $this->createDate->setupEditAttributes();
        $this->createDate->EditCustomAttributes = "";
        $this->createDate->EditValue = FormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->createDate->PlaceHolder = RemoveHtml($this->createDate->caption());

        // typeId
        $this->typeId->setupEditAttributes();
        $this->typeId->EditCustomAttributes = "";
        $this->typeId->PlaceHolder = RemoveHtml($this->typeId->caption());

        // owner
        $this->owner->setupEditAttributes();
        $this->owner->EditCustomAttributes = "";
        if (!$this->owner->Raw) {
            $this->owner->CurrentValue = HtmlDecode($this->owner->CurrentValue);
        }
        $this->owner->EditValue = $this->owner->CurrentValue;
        $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

        // identityNumber
        $this->identityNumber->setupEditAttributes();
        $this->identityNumber->EditCustomAttributes = "";
        if (!$this->identityNumber->Raw) {
            $this->identityNumber->CurrentValue = HtmlDecode($this->identityNumber->CurrentValue);
        }
        $this->identityNumber->EditValue = $this->identityNumber->CurrentValue;
        $this->identityNumber->PlaceHolder = RemoveHtml($this->identityNumber->caption());

        // birthDateOwner
        $this->birthDateOwner->setupEditAttributes();
        $this->birthDateOwner->EditCustomAttributes = "";
        $this->birthDateOwner->EditValue = FormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern());
        $this->birthDateOwner->PlaceHolder = RemoveHtml($this->birthDateOwner->caption());

        // ownerCountryId
        $this->ownerCountryId->setupEditAttributes();
        $this->ownerCountryId->EditCustomAttributes = "";
        $this->ownerCountryId->PlaceHolder = RemoveHtml($this->ownerCountryId->caption());

        // ownerStateId
        $this->ownerStateId->setupEditAttributes();
        $this->ownerStateId->EditCustomAttributes = "";
        $this->ownerStateId->PlaceHolder = RemoveHtml($this->ownerStateId->caption());

        // ownCityId
        $this->ownCityId->setupEditAttributes();
        $this->ownCityId->EditCustomAttributes = "";
        $this->ownCityId->PlaceHolder = RemoveHtml($this->ownCityId->caption());

        // ownerTelephone
        $this->ownerTelephone->setupEditAttributes();
        $this->ownerTelephone->EditCustomAttributes = "";
        if (!$this->ownerTelephone->Raw) {
            $this->ownerTelephone->CurrentValue = HtmlDecode($this->ownerTelephone->CurrentValue);
        }
        $this->ownerTelephone->EditValue = $this->ownerTelephone->CurrentValue;
        $this->ownerTelephone->PlaceHolder = RemoveHtml($this->ownerTelephone->caption());

        // ownerTelephoneWork
        $this->ownerTelephoneWork->setupEditAttributes();
        $this->ownerTelephoneWork->EditCustomAttributes = "";
        if (!$this->ownerTelephoneWork->Raw) {
            $this->ownerTelephoneWork->CurrentValue = HtmlDecode($this->ownerTelephoneWork->CurrentValue);
        }
        $this->ownerTelephoneWork->EditValue = $this->ownerTelephoneWork->CurrentValue;
        $this->ownerTelephoneWork->PlaceHolder = RemoveHtml($this->ownerTelephoneWork->caption());

        // ownerProfession
        $this->ownerProfession->setupEditAttributes();
        $this->ownerProfession->EditCustomAttributes = "";
        if (!$this->ownerProfession->Raw) {
            $this->ownerProfession->CurrentValue = HtmlDecode($this->ownerProfession->CurrentValue);
        }
        $this->ownerProfession->EditValue = $this->ownerProfession->CurrentValue;
        $this->ownerProfession->PlaceHolder = RemoveHtml($this->ownerProfession->caption());

        // employer
        $this->employer->setupEditAttributes();
        $this->employer->EditCustomAttributes = "";
        if (!$this->employer->Raw) {
            $this->employer->CurrentValue = HtmlDecode($this->employer->CurrentValue);
        }
        $this->employer->EditValue = $this->employer->CurrentValue;
        $this->employer->PlaceHolder = RemoveHtml($this->employer->caption());

        // ownerGraduation
        $this->ownerGraduation->setupEditAttributes();
        $this->ownerGraduation->EditCustomAttributes = "";
        $this->ownerGraduation->PlaceHolder = RemoveHtml($this->ownerGraduation->caption());

        // ownerGraduationLocation
        $this->ownerGraduationLocation->setupEditAttributes();
        $this->ownerGraduationLocation->EditCustomAttributes = "";
        if (!$this->ownerGraduationLocation->Raw) {
            $this->ownerGraduationLocation->CurrentValue = HtmlDecode($this->ownerGraduationLocation->CurrentValue);
        }
        $this->ownerGraduationLocation->EditValue = $this->ownerGraduationLocation->CurrentValue;
        $this->ownerGraduationLocation->PlaceHolder = RemoveHtml($this->ownerGraduationLocation->caption());

        // ownerGraduationObs
        $this->ownerGraduationObs->setupEditAttributes();
        $this->ownerGraduationObs->EditCustomAttributes = "";
        $this->ownerGraduationObs->EditValue = $this->ownerGraduationObs->CurrentValue;
        $this->ownerGraduationObs->PlaceHolder = RemoveHtml($this->ownerGraduationObs->caption());

        // ownerMaritalStatus
        $this->ownerMaritalStatus->EditCustomAttributes = "";
        $this->ownerMaritalStatus->EditValue = $this->ownerMaritalStatus->options(false);
        $this->ownerMaritalStatus->PlaceHolder = RemoveHtml($this->ownerMaritalStatus->caption());

        // ownerSpouseName
        $this->ownerSpouseName->setupEditAttributes();
        $this->ownerSpouseName->EditCustomAttributes = "";
        if (!$this->ownerSpouseName->Raw) {
            $this->ownerSpouseName->CurrentValue = HtmlDecode($this->ownerSpouseName->CurrentValue);
        }
        $this->ownerSpouseName->EditValue = $this->ownerSpouseName->CurrentValue;
        $this->ownerSpouseName->PlaceHolder = RemoveHtml($this->ownerSpouseName->caption());

        // ownerSpouseProfession
        $this->ownerSpouseProfession->setupEditAttributes();
        $this->ownerSpouseProfession->EditCustomAttributes = "";
        if (!$this->ownerSpouseProfession->Raw) {
            $this->ownerSpouseProfession->CurrentValue = HtmlDecode($this->ownerSpouseProfession->CurrentValue);
        }
        $this->ownerSpouseProfession->EditValue = $this->ownerSpouseProfession->CurrentValue;
        $this->ownerSpouseProfession->PlaceHolder = RemoveHtml($this->ownerSpouseProfession->caption());

        // propertySituation
        $this->propertySituation->EditCustomAttributes = "";
        $this->propertySituation->EditValue = $this->propertySituation->options(false);
        $this->propertySituation->PlaceHolder = RemoveHtml($this->propertySituation->caption());

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->setupEditAttributes();
        $this->numberOfStudentsInBeginnig->EditCustomAttributes = "";
        $this->numberOfStudentsInBeginnig->EditValue = $this->numberOfStudentsInBeginnig->CurrentValue;
        $this->numberOfStudentsInBeginnig->PlaceHolder = RemoveHtml($this->numberOfStudentsInBeginnig->caption());
        if (strval($this->numberOfStudentsInBeginnig->EditValue) != "" && is_numeric($this->numberOfStudentsInBeginnig->EditValue)) {
            $this->numberOfStudentsInBeginnig->EditValue = FormatNumber($this->numberOfStudentsInBeginnig->EditValue, null);
        }

        // ownerAbout
        $this->ownerAbout->setupEditAttributes();
        $this->ownerAbout->EditCustomAttributes = "";
        $this->ownerAbout->EditValue = $this->ownerAbout->CurrentValue;
        $this->ownerAbout->PlaceHolder = RemoveHtml($this->ownerAbout->caption());

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
                    $doc->exportCaption($this->masterSchoolId);
                    $doc->exportCaption($this->school);
                    $doc->exportCaption($this->countryId);
                    $doc->exportCaption($this->UFId);
                    $doc->exportCaption($this->cityId);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->zipcode);
                    $doc->exportCaption($this->website);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->celphone);
                    $doc->exportCaption($this->logo);
                    $doc->exportCaption($this->openingDate);
                    $doc->exportCaption($this->federationRegister);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->typeId);
                    $doc->exportCaption($this->owner);
                    $doc->exportCaption($this->identityNumber);
                    $doc->exportCaption($this->birthDateOwner);
                    $doc->exportCaption($this->ownerCountryId);
                    $doc->exportCaption($this->ownerStateId);
                    $doc->exportCaption($this->ownCityId);
                    $doc->exportCaption($this->ownerTelephone);
                    $doc->exportCaption($this->ownerTelephoneWork);
                    $doc->exportCaption($this->ownerProfession);
                    $doc->exportCaption($this->employer);
                    $doc->exportCaption($this->ownerGraduation);
                    $doc->exportCaption($this->ownerGraduationLocation);
                    $doc->exportCaption($this->ownerGraduationObs);
                    $doc->exportCaption($this->ownerMaritalStatus);
                    $doc->exportCaption($this->ownerSpouseName);
                    $doc->exportCaption($this->ownerSpouseProfession);
                    $doc->exportCaption($this->propertySituation);
                    $doc->exportCaption($this->numberOfStudentsInBeginnig);
                    $doc->exportCaption($this->ownerAbout);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->federationId);
                    $doc->exportCaption($this->masterSchoolId);
                    $doc->exportCaption($this->school);
                    $doc->exportCaption($this->countryId);
                    $doc->exportCaption($this->UFId);
                    $doc->exportCaption($this->cityId);
                    $doc->exportCaption($this->neighborhood);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->zipcode);
                    $doc->exportCaption($this->website);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->celphone);
                    $doc->exportCaption($this->logo);
                    $doc->exportCaption($this->openingDate);
                    $doc->exportCaption($this->federationRegister);
                    $doc->exportCaption($this->createUserId);
                    $doc->exportCaption($this->createDate);
                    $doc->exportCaption($this->typeId);
                    $doc->exportCaption($this->owner);
                    $doc->exportCaption($this->identityNumber);
                    $doc->exportCaption($this->birthDateOwner);
                    $doc->exportCaption($this->ownerCountryId);
                    $doc->exportCaption($this->ownerStateId);
                    $doc->exportCaption($this->ownCityId);
                    $doc->exportCaption($this->ownerTelephone);
                    $doc->exportCaption($this->ownerTelephoneWork);
                    $doc->exportCaption($this->ownerProfession);
                    $doc->exportCaption($this->employer);
                    $doc->exportCaption($this->ownerGraduation);
                    $doc->exportCaption($this->ownerGraduationLocation);
                    $doc->exportCaption($this->ownerMaritalStatus);
                    $doc->exportCaption($this->ownerSpouseName);
                    $doc->exportCaption($this->ownerSpouseProfession);
                    $doc->exportCaption($this->propertySituation);
                    $doc->exportCaption($this->numberOfStudentsInBeginnig);
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
                        $doc->exportField($this->masterSchoolId);
                        $doc->exportField($this->school);
                        $doc->exportField($this->countryId);
                        $doc->exportField($this->UFId);
                        $doc->exportField($this->cityId);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->address);
                        $doc->exportField($this->zipcode);
                        $doc->exportField($this->website);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->celphone);
                        $doc->exportField($this->logo);
                        $doc->exportField($this->openingDate);
                        $doc->exportField($this->federationRegister);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->typeId);
                        $doc->exportField($this->owner);
                        $doc->exportField($this->identityNumber);
                        $doc->exportField($this->birthDateOwner);
                        $doc->exportField($this->ownerCountryId);
                        $doc->exportField($this->ownerStateId);
                        $doc->exportField($this->ownCityId);
                        $doc->exportField($this->ownerTelephone);
                        $doc->exportField($this->ownerTelephoneWork);
                        $doc->exportField($this->ownerProfession);
                        $doc->exportField($this->employer);
                        $doc->exportField($this->ownerGraduation);
                        $doc->exportField($this->ownerGraduationLocation);
                        $doc->exportField($this->ownerGraduationObs);
                        $doc->exportField($this->ownerMaritalStatus);
                        $doc->exportField($this->ownerSpouseName);
                        $doc->exportField($this->ownerSpouseProfession);
                        $doc->exportField($this->propertySituation);
                        $doc->exportField($this->numberOfStudentsInBeginnig);
                        $doc->exportField($this->ownerAbout);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->federationId);
                        $doc->exportField($this->masterSchoolId);
                        $doc->exportField($this->school);
                        $doc->exportField($this->countryId);
                        $doc->exportField($this->UFId);
                        $doc->exportField($this->cityId);
                        $doc->exportField($this->neighborhood);
                        $doc->exportField($this->address);
                        $doc->exportField($this->zipcode);
                        $doc->exportField($this->website);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->celphone);
                        $doc->exportField($this->logo);
                        $doc->exportField($this->openingDate);
                        $doc->exportField($this->federationRegister);
                        $doc->exportField($this->createUserId);
                        $doc->exportField($this->createDate);
                        $doc->exportField($this->typeId);
                        $doc->exportField($this->owner);
                        $doc->exportField($this->identityNumber);
                        $doc->exportField($this->birthDateOwner);
                        $doc->exportField($this->ownerCountryId);
                        $doc->exportField($this->ownerStateId);
                        $doc->exportField($this->ownCityId);
                        $doc->exportField($this->ownerTelephone);
                        $doc->exportField($this->ownerTelephoneWork);
                        $doc->exportField($this->ownerProfession);
                        $doc->exportField($this->employer);
                        $doc->exportField($this->ownerGraduation);
                        $doc->exportField($this->ownerGraduationLocation);
                        $doc->exportField($this->ownerMaritalStatus);
                        $doc->exportField($this->ownerSpouseName);
                        $doc->exportField($this->ownerSpouseProfession);
                        $doc->exportField($this->propertySituation);
                        $doc->exportField($this->numberOfStudentsInBeginnig);
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'logo') {
            $fldName = "logo";
            $fileNameFld = "logo";
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
        if(!isAdmin()){
            AddFilter($filter, "`createUserId` = ".GetLoggedUserID()." "); 
        }
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
        $rsnew['createDate'] = CurrentDate();
        $hasApplied = ExecuteScalar("SELECT id FROM fed_applicationschool WHERE createUserId = " . GetLoggedUserID() . " ");
        if($hasApplied){
        	return false; // limitando o usuário a criar apenas 1 aplicação
        }
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
       /*
       Gostaríamos de saber quem escreveu esse código. Não faz sentido nenhum. Att: Leonardo e Eder.
       if (CurrentUserID() == null) {
             if (isset($rsnew['id'])) {
                 !isset($rsnew['masterSchoolId']) ? $rsnew['masterSchoolId'] = 0 : $rsnew['masterSchoolId'];
                 Execute("UPDATE school_users SET schoolId = " . $rsnew['id'] . ", schoolIdMaster = " . $rsnew['masterSchoolId'] . " WHERE email = '" . CurrentUserName() . "'");
             }
         }*/
         	$defaultType = ExecuteScalar('SELECT id FROM conf_schooltype AS c WHERE c.default = 1');
            !isset($rsnew['ownerGraduation']) ? $rsnew['ownerGraduation'] = 0 : $rsnew['ownerGraduation'];
            try {
             Execute("INSERT INTO fed_school
             (
               federationId
              ,school
              ,countryId
              ,UFId
              ,cityId
              ,neighborhood
              ,address
              ,zipcode
              ,website
              ,email
              ,phone
              ,celphone
              ,logo
              ,openingDate
              ,createUserId
              ,createDate
              ,typeId
              ,owner
              ,identityNumber
              ,birthDateOwner
              ,ownerCountryId
              ,ownerStateId
              ,ownCityId
              ,ownerTelephone
              ,ownerTelephoneWork
              ,ownerProfession
              ,employer
              ,ownerGraduation
              ,ownerGraduationLocation
              ,ownerGraduationObs
              ,ownerMaritalStatus
              ,ownerSpouseName
              ,ownerSpouseProfession
              ,propertySituation
              ,numberOfStudentsInBeginnig
              ,ownerAbout
              ,applicationId
             )
             VALUES
             (
              " . $this->federationId->CurrentValue . " -- federationId - INT(11)
              ,'" . $rsnew['school'] . "' -- school - VARCHAR(45)
              ," . $rsnew['countryId'] . " -- countryId - INT(11)
              ," . $rsnew['UFId'] . " -- UFId - INT(11)
              ," . $rsnew['cityId'] . " -- cityId - INT(11)
              ,'" . $rsnew['neighborhood'] . "' -- neighborhood - VARCHAR(45)
              ,'" . $rsnew['address'] . "' -- address - VARCHAR(100)
              ,'" . $rsnew['zipcode'] . "' -- zipcode - VARCHAR(8)
              ,'" . $rsnew['website'] . "' -- website - VARCHAR(100)
              ,'" . $rsnew['email'] . "' -- email - VARCHAR(100)
              ,'" . $rsnew['phone'] . "' -- phone - VARCHAR(45)
              ,'" . $rsnew['celphone'] . "' -- celphone - VARCHAR(45)
              ,'" . $rsnew['logo'] . "' -- logo - VARCHAR(45)
              ,'" . $rsnew['openingDate'] . "' -- openingDate - DATE
              ," . GetLoggedUserID() . " -- createUserId - INT(11)
              ,'" . CurrentDate() . "' -- createDate - DATE
              ," . $defaultType . " -- typeId - INT(11)
              ,'" . $rsnew['owner'] . "' -- owner - VARCHAR(45)
              ,'" . $rsnew['identityNumber'] . "' -- identityNumber - VARCHAR(255)
              ,'" . $rsnew['birthDateOwner'] . "' -- birthDateOwner - DATE
              ," . $rsnew['ownerCountryId'] . " -- ownerCountryId - INT(11)
              ," . $rsnew['ownerStateId'] . " -- ownerStateId - INT(11)
              ," . $rsnew['ownCityId'] . " -- ownCityId - INT(11)
              ,'" . $rsnew['ownerTelephone'] . "' -- ownerTelephone - VARCHAR(255)
              ,'" . $rsnew['ownerTelephoneWork'] . "' -- ownerTelephoneWork - VARCHAR(255)
              ,'" . $rsnew['ownerProfession'] . "' -- ownerProfession - VARCHAR(255)
              ,'" . $rsnew['employer'] . "' -- employer - VARCHAR(255)
              ," . $rsnew['ownerGraduation'] . " -- ownerGraduation - INT(11)
              ,'" . $rsnew['ownerGraduationLocation'] . "' -- ownerGraduationLocation - VARCHAR(255)
              ,'" . $rsnew['ownerGraduationObs'] . "' -- ownerGraduationObs - TEXT
              ," . $rsnew['ownerMaritalStatus'] . " -- ownerMaritalStatus - INT(11)
              ,'" . $rsnew['ownerSpouseName'] . "' -- ownerSpouseName - VARCHAR(255)
              ,'" . $rsnew['ownerSpouseProfession'] . "' -- ownerSpouseProfession - VARCHAR(255)
              ," . $rsnew['propertySituation'] . " -- propertySituation - INT(11)
              ," . $rsnew['numberOfStudentsInBeginnig'] . " -- numberOfStudentsInBeginnig - INT(11)
              ,'" . $rsnew['ownerAbout'] . "' -- ownerAbout - TEXT
              ," . $rsnew['id'] . " -- applicationId - INT(11)
             )");

              // Atualizando a escola do usuário que inseriu a aplicação
              $newSchoolId = ExecuteScalar("SELECT LAST_INSERT_ID()");

              //Caso o comando SQL não rode, pego fazendo a query normal
              !isset($newSchoolId) ? $newSchoolId = ExecuteScalar("SELECT id FROM fed_school WHERE applicationId = " . $rsnew['id'] . "") : $newSchoolId;
                Execute("UPDATE school_users SET schoolId = " . $newSchoolId . " WHERE id = " . GetLoggedUserID() . " ");
            } catch (DBALException $error) {
                Log($error);
                echo "<div class='alert alert-danger' role='alert'> Error when inserting please try again! </div>";
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
