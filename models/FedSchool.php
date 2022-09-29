<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for fed_school
 */
class FedSchool extends DbTable
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
    public $pdfLicense;
    public $applicationId;
    public $isheadquarter;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fed_school';
        $this->TableName = 'fed_school';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fed_school`";
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
        $this->ShowMultipleDetails = true; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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

        // masterSchoolId
        $this->masterSchoolId = new DbField(
            'fed_school',
            'fed_school',
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
            'SELECT'
        );
        $this->masterSchoolId->InputTextType = "text";
        $this->masterSchoolId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->masterSchoolId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], ["school_users x_schoolId"], [], [], [], [], '`school`', '', "`school`");
                break;
            case "pt-BR":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], ["school_users x_schoolId"], [], [], [], [], '`school`', '', "`school`");
                break;
            case "es":
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], ["school_users x_schoolId"], [], [], [], [], '`school`', '', "`school`");
                break;
            default:
                $this->masterSchoolId->Lookup = new Lookup('masterSchoolId', 'fed_school', false, 'id', ["school","","",""], [], ["school_users x_schoolId"], [], [], [], [], '`school`', '', "`school`");
                break;
        }
        $this->masterSchoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['masterSchoolId'] = &$this->masterSchoolId;

        // school
        $this->school = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['school'] = &$this->school;

        // countryId
        $this->countryId = new DbField(
            'fed_school',
            'fed_school',
            'x_countryId',
            'countryId',
            '`countryId`',
            '`countryId`',
            3,
            11,
            -1,
            false,
            '`countryId`',
            false,
            false,
            false,
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
            'fed_school',
            'fed_school',
            'x_UFId',
            'UFId',
            '`UFId`',
            '`UFId`',
            3,
            11,
            -1,
            false,
            '`UFId`',
            false,
            false,
            false,
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
            'fed_school',
            'fed_school',
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
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->cityId->InputTextType = "text";
        $this->cityId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cityId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "`city`");
                break;
            case "pt-BR":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "`city`");
                break;
            case "es":
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "`city`");
                break;
            default:
                $this->cityId->Lookup = new Lookup('cityId', 'conf_city', false, 'id', ["city","","",""], ["x_UFId"], [], ["ufId"], ["x_ufId"], [], [], '', '', "`city`");
                break;
        }
        $this->cityId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cityId'] = &$this->cityId;

        // neighborhood
        $this->neighborhood = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['neighborhood'] = &$this->neighborhood;

        // address
        $this->address = new DbField(
            'fed_school',
            'fed_school',
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

        // zipcode
        $this->zipcode = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['zipcode'] = &$this->zipcode;

        // website
        $this->website = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
        $this->Fields['email'] = &$this->_email;

        // phone
        $this->phone = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['phone'] = &$this->phone;

        // celphone
        $this->celphone = new DbField(
            'fed_school',
            'fed_school',
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

        // logo
        $this->logo = new DbField(
            'fed_school',
            'fed_school',
            'x_logo',
            'logo',
            '`logo`',
            '`logo`',
            200,
            45,
            -1,
            false,
            '`logo`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->logo->InputTextType = "text";
        $this->Fields['logo'] = &$this->logo;

        // openingDate
        $this->openingDate = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'TEXT'
        );
        $this->typeId->InputTextType = "text";
        $this->typeId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['typeId'] = &$this->typeId;

        // owner
        $this->owner = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['owner'] = &$this->owner;

        // identityNumber
        $this->identityNumber = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['identityNumber'] = &$this->identityNumber;

        // birthDateOwner
        $this->birthDateOwner = new DbField(
            'fed_school',
            'fed_school',
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
        $this->birthDateOwner->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['birthDateOwner'] = &$this->birthDateOwner;

        // ownerCountryId
        $this->ownerCountryId = new DbField(
            'fed_school',
            'fed_school',
            'x_ownerCountryId',
            'ownerCountryId',
            '`ownerCountryId`',
            '`ownerCountryId`',
            3,
            11,
            -1,
            false,
            '`ownerCountryId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerCountryId->InputTextType = "text";
        $this->ownerCountryId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerCountryId'] = &$this->ownerCountryId;

        // ownerStateId
        $this->ownerStateId = new DbField(
            'fed_school',
            'fed_school',
            'x_ownerStateId',
            'ownerStateId',
            '`ownerStateId`',
            '`ownerStateId`',
            3,
            11,
            -1,
            false,
            '`ownerStateId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownerStateId->InputTextType = "text";
        $this->ownerStateId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerStateId'] = &$this->ownerStateId;

        // ownCityId
        $this->ownCityId = new DbField(
            'fed_school',
            'fed_school',
            'x_ownCityId',
            'ownCityId',
            '`ownCityId`',
            '`ownCityId`',
            3,
            11,
            -1,
            false,
            '`ownCityId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->ownCityId->InputTextType = "text";
        $this->ownCityId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownCityId'] = &$this->ownCityId;

        // ownerTelephone
        $this->ownerTelephone = new DbField(
            'fed_school',
            'fed_school',
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
        $this->Fields['ownerTelephone'] = &$this->ownerTelephone;

        // ownerTelephoneWork
        $this->ownerTelephoneWork = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'TEXT'
        );
        $this->ownerGraduation->InputTextType = "text";
        $this->ownerGraduation->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerGraduation'] = &$this->ownerGraduation;

        // ownerGraduationLocation
        $this->ownerGraduationLocation = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'TEXT'
        );
        $this->ownerMaritalStatus->InputTextType = "text";
        $this->ownerMaritalStatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ownerMaritalStatus'] = &$this->ownerMaritalStatus;

        // ownerSpouseName
        $this->ownerSpouseName = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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
            'TEXT'
        );
        $this->propertySituation->InputTextType = "text";
        $this->propertySituation->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['propertySituation'] = &$this->propertySituation;

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig = new DbField(
            'fed_school',
            'fed_school',
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
            'fed_school',
            'fed_school',
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

        // pdfLicense
        $this->pdfLicense = new DbField(
            'fed_school',
            'fed_school',
            'x_pdfLicense',
            'pdfLicense',
            '`pdfLicense`',
            '`pdfLicense`',
            201,
            400,
            -1,
            false,
            '`pdfLicense`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->pdfLicense->InputTextType = "text";
        $this->Fields['pdfLicense'] = &$this->pdfLicense;

        // applicationId
        $this->applicationId = new DbField(
            'fed_school',
            'fed_school',
            'x_applicationId',
            'applicationId',
            '`applicationId`',
            '`applicationId`',
            3,
            11,
            -1,
            false,
            '`applicationId`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->applicationId->InputTextType = "text";
        $this->applicationId->IsForeignKey = true; // Foreign key field
        $this->applicationId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['applicationId'] = &$this->applicationId;

        // isheadquarter
        $this->isheadquarter = new DbField(
            'fed_school',
            'fed_school',
            'x_isheadquarter',
            'isheadquarter',
            '`isheadquarter`',
            '`isheadquarter`',
            16,
            1,
            -1,
            false,
            '`isheadquarter`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'CHECKBOX'
        );
        $this->isheadquarter->InputTextType = "text";
        $this->isheadquarter->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en-US":
                $this->isheadquarter->Lookup = new Lookup('isheadquarter', 'fed_school', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->isheadquarter->Lookup = new Lookup('isheadquarter', 'fed_school', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->isheadquarter->Lookup = new Lookup('isheadquarter', 'fed_school', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->isheadquarter->Lookup = new Lookup('isheadquarter', 'fed_school', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->isheadquarter->OptionCount = 2;
        $this->isheadquarter->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->Fields['isheadquarter'] = &$this->isheadquarter;

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
        if ($this->getCurrentMasterTable() == "fed_applicationschool") {
            if ($this->applicationId->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->applicationId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
            if ($this->applicationId->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`applicationId`", $this->applicationId->getSessionValue(), DATATYPE_NUMBER, "DB");
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
                $key = $keys["applicationId"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->id->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return "`id`=" . QuotedValue($keys["applicationId"], $masterTable->id->DataType, $masterTable->Dbid);
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
                return "`applicationId`=" . QuotedValue($masterTable->id->DbValue, $this->applicationId->DataType, $this->Dbid);
        }
        return "";
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
        if ($this->getCurrentDetailTable() == "school_users") {
            $detailUrl = Container("school_users")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "school_member") {
            $detailUrl = Container("school_member")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "FedSchoolList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fed_school`";
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
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_school`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_school`)";
                break;
            case "pt-BR":
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_school`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_school`)";
                break;
            case "es":
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_school`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_school`)";
                break;
            default:
                $from = "(SELECT *, (SELECT `city` FROM `conf_city` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `fed_school`.`cityId` LIMIT 1) AS `EV__cityId` FROM `fed_school`)";
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
        if (ContainsString($orderBy, " " . $this->cityId->VirtualExpression . " ")) {
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
        // Cascade Update detail table 'school_users'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'schoolId'
            $cascadeUpdate = true;
            $rscascade['schoolId'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("school_users")->loadRs("`schoolId` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("school_users")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("school_users")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("school_users")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'school_member'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'schoolId'
            $cascadeUpdate = true;
            $rscascade['schoolId'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("school_member")->loadRs("`schoolId` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("school_member")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("school_member")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("school_member")->rowUpdated($rsdtlold, $rsdtlnew);
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
        $this->logo->DbValue = $row['logo'];
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
        $this->pdfLicense->DbValue = $row['pdfLicense'];
        $this->applicationId->DbValue = $row['applicationId'];
        $this->isheadquarter->DbValue = $row['isheadquarter'];
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
        return $_SESSION[$name] ?? GetUrl("FedSchoolList");
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
        if ($pageName == "FedSchoolView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FedSchoolEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FedSchoolAdd") {
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
                return "FedSchoolView";
            case Config("API_ADD_ACTION"):
                return "FedSchoolAdd";
            case Config("API_EDIT_ACTION"):
                return "FedSchoolEdit";
            case Config("API_DELETE_ACTION"):
                return "FedSchoolDelete";
            case Config("API_LIST_ACTION"):
                return "FedSchoolList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FedSchoolList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedSchoolView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedSchoolView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FedSchoolAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FedSchoolAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FedSchoolEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedSchoolEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("FedSchoolAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FedSchoolAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("FedSchoolDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "fed_applicationschool" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->applicationId->CurrentValue);
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
        $this->logo->setDbValue($row['logo']);
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
        $this->pdfLicense->setDbValue($row['pdfLicense']);
        $this->applicationId->setDbValue($row['applicationId']);
        $this->isheadquarter->setDbValue($row['isheadquarter']);
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

        // pdfLicense

        // applicationId

        // isheadquarter

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

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

        // masterSchoolId
        $curVal = strval($this->masterSchoolId->CurrentValue);
        if ($curVal != "") {
            $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
            if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`typeId`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->masterSchoolId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // school
        $this->school->ViewValue = $this->school->CurrentValue;
        $this->school->ViewCustomAttributes = "";

        // countryId
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
        $this->countryId->ViewCustomAttributes = "";

        // UFId
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
        $this->logo->ViewValue = $this->logo->CurrentValue;
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
        $this->typeId->ViewValue = $this->typeId->CurrentValue;
        $this->typeId->ViewValue = FormatNumber($this->typeId->ViewValue, $this->typeId->formatPattern());
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
        $this->ownerCountryId->ViewValue = $this->ownerCountryId->CurrentValue;
        $this->ownerCountryId->ViewValue = FormatNumber($this->ownerCountryId->ViewValue, $this->ownerCountryId->formatPattern());
        $this->ownerCountryId->ViewCustomAttributes = "";

        // ownerStateId
        $this->ownerStateId->ViewValue = $this->ownerStateId->CurrentValue;
        $this->ownerStateId->ViewValue = FormatNumber($this->ownerStateId->ViewValue, $this->ownerStateId->formatPattern());
        $this->ownerStateId->ViewCustomAttributes = "";

        // ownCityId
        $this->ownCityId->ViewValue = $this->ownCityId->CurrentValue;
        $this->ownCityId->ViewValue = FormatNumber($this->ownCityId->ViewValue, $this->ownCityId->formatPattern());
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
        $this->ownerGraduation->ViewValue = $this->ownerGraduation->CurrentValue;
        $this->ownerGraduation->ViewValue = FormatNumber($this->ownerGraduation->ViewValue, $this->ownerGraduation->formatPattern());
        $this->ownerGraduation->ViewCustomAttributes = "";

        // ownerGraduationLocation
        $this->ownerGraduationLocation->ViewValue = $this->ownerGraduationLocation->CurrentValue;
        $this->ownerGraduationLocation->ViewCustomAttributes = "";

        // ownerGraduationObs
        $this->ownerGraduationObs->ViewValue = $this->ownerGraduationObs->CurrentValue;
        $this->ownerGraduationObs->ViewCustomAttributes = "";

        // ownerMaritalStatus
        $this->ownerMaritalStatus->ViewValue = $this->ownerMaritalStatus->CurrentValue;
        $this->ownerMaritalStatus->ViewValue = FormatNumber($this->ownerMaritalStatus->ViewValue, $this->ownerMaritalStatus->formatPattern());
        $this->ownerMaritalStatus->ViewCustomAttributes = "";

        // ownerSpouseName
        $this->ownerSpouseName->ViewValue = $this->ownerSpouseName->CurrentValue;
        $this->ownerSpouseName->ViewCustomAttributes = "";

        // ownerSpouseProfession
        $this->ownerSpouseProfession->ViewValue = $this->ownerSpouseProfession->CurrentValue;
        $this->ownerSpouseProfession->ViewCustomAttributes = "";

        // propertySituation
        $this->propertySituation->ViewValue = $this->propertySituation->CurrentValue;
        $this->propertySituation->ViewValue = FormatNumber($this->propertySituation->ViewValue, $this->propertySituation->formatPattern());
        $this->propertySituation->ViewCustomAttributes = "";

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->ViewValue = $this->numberOfStudentsInBeginnig->CurrentValue;
        $this->numberOfStudentsInBeginnig->ViewValue = FormatNumber($this->numberOfStudentsInBeginnig->ViewValue, $this->numberOfStudentsInBeginnig->formatPattern());
        $this->numberOfStudentsInBeginnig->ViewCustomAttributes = "";

        // ownerAbout
        $this->ownerAbout->ViewValue = $this->ownerAbout->CurrentValue;
        $this->ownerAbout->ViewCustomAttributes = "";

        // pdfLicense
        $this->pdfLicense->ViewValue = $this->pdfLicense->CurrentValue;
        $this->pdfLicense->ViewCustomAttributes = "";

        // applicationId
        $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
        $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
        $this->applicationId->ViewCustomAttributes = "";

        // isheadquarter
        if (ConvertToBool($this->isheadquarter->CurrentValue)) {
            $this->isheadquarter->ViewValue = $this->isheadquarter->tagCaption(1) != "" ? $this->isheadquarter->tagCaption(1) : "Yes";
        } else {
            $this->isheadquarter->ViewValue = $this->isheadquarter->tagCaption(2) != "" ? $this->isheadquarter->tagCaption(2) : "No";
        }
        $this->isheadquarter->ViewCustomAttributes = "";

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
        $this->logo->HrefValue = "";
        $this->logo->TooltipValue = "";

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

        // pdfLicense
        $this->pdfLicense->LinkCustomAttributes = "";
        $this->pdfLicense->HrefValue = "";
        $this->pdfLicense->TooltipValue = "";

        // applicationId
        $this->applicationId->LinkCustomAttributes = "";
        $this->applicationId->HrefValue = "";
        $this->applicationId->TooltipValue = "";

        // isheadquarter
        $this->isheadquarter->LinkCustomAttributes = "";
        $this->isheadquarter->HrefValue = "";
        $this->isheadquarter->TooltipValue = "";

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
        $this->federationId->PlaceHolder = RemoveHtml($this->federationId->caption());

        // masterSchoolId
        $this->masterSchoolId->setupEditAttributes();
        $this->masterSchoolId->EditCustomAttributes = "";
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
        if (!$this->logo->Raw) {
            $this->logo->CurrentValue = HtmlDecode($this->logo->CurrentValue);
        }
        $this->logo->EditValue = $this->logo->CurrentValue;
        $this->logo->PlaceHolder = RemoveHtml($this->logo->caption());

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

        // typeId
        $this->typeId->setupEditAttributes();
        $this->typeId->EditCustomAttributes = "";
        $this->typeId->EditValue = $this->typeId->CurrentValue;
        $this->typeId->PlaceHolder = RemoveHtml($this->typeId->caption());
        if (strval($this->typeId->EditValue) != "" && is_numeric($this->typeId->EditValue)) {
            $this->typeId->EditValue = FormatNumber($this->typeId->EditValue, null);
        }

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
        $this->ownerCountryId->EditValue = $this->ownerCountryId->CurrentValue;
        $this->ownerCountryId->PlaceHolder = RemoveHtml($this->ownerCountryId->caption());
        if (strval($this->ownerCountryId->EditValue) != "" && is_numeric($this->ownerCountryId->EditValue)) {
            $this->ownerCountryId->EditValue = FormatNumber($this->ownerCountryId->EditValue, null);
        }

        // ownerStateId
        $this->ownerStateId->setupEditAttributes();
        $this->ownerStateId->EditCustomAttributes = "";
        $this->ownerStateId->EditValue = $this->ownerStateId->CurrentValue;
        $this->ownerStateId->PlaceHolder = RemoveHtml($this->ownerStateId->caption());
        if (strval($this->ownerStateId->EditValue) != "" && is_numeric($this->ownerStateId->EditValue)) {
            $this->ownerStateId->EditValue = FormatNumber($this->ownerStateId->EditValue, null);
        }

        // ownCityId
        $this->ownCityId->setupEditAttributes();
        $this->ownCityId->EditCustomAttributes = "";
        $this->ownCityId->EditValue = $this->ownCityId->CurrentValue;
        $this->ownCityId->PlaceHolder = RemoveHtml($this->ownCityId->caption());
        if (strval($this->ownCityId->EditValue) != "" && is_numeric($this->ownCityId->EditValue)) {
            $this->ownCityId->EditValue = FormatNumber($this->ownCityId->EditValue, null);
        }

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
        $this->ownerGraduation->EditValue = $this->ownerGraduation->CurrentValue;
        $this->ownerGraduation->PlaceHolder = RemoveHtml($this->ownerGraduation->caption());
        if (strval($this->ownerGraduation->EditValue) != "" && is_numeric($this->ownerGraduation->EditValue)) {
            $this->ownerGraduation->EditValue = FormatNumber($this->ownerGraduation->EditValue, null);
        }

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
        $this->ownerMaritalStatus->setupEditAttributes();
        $this->ownerMaritalStatus->EditCustomAttributes = "";
        $this->ownerMaritalStatus->EditValue = $this->ownerMaritalStatus->CurrentValue;
        $this->ownerMaritalStatus->PlaceHolder = RemoveHtml($this->ownerMaritalStatus->caption());
        if (strval($this->ownerMaritalStatus->EditValue) != "" && is_numeric($this->ownerMaritalStatus->EditValue)) {
            $this->ownerMaritalStatus->EditValue = FormatNumber($this->ownerMaritalStatus->EditValue, null);
        }

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
        $this->propertySituation->setupEditAttributes();
        $this->propertySituation->EditCustomAttributes = "";
        $this->propertySituation->EditValue = $this->propertySituation->CurrentValue;
        $this->propertySituation->PlaceHolder = RemoveHtml($this->propertySituation->caption());
        if (strval($this->propertySituation->EditValue) != "" && is_numeric($this->propertySituation->EditValue)) {
            $this->propertySituation->EditValue = FormatNumber($this->propertySituation->EditValue, null);
        }

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

        // pdfLicense
        $this->pdfLicense->setupEditAttributes();
        $this->pdfLicense->EditCustomAttributes = "";
        $this->pdfLicense->EditValue = $this->pdfLicense->CurrentValue;
        $this->pdfLicense->PlaceHolder = RemoveHtml($this->pdfLicense->caption());

        // applicationId
        $this->applicationId->setupEditAttributes();
        $this->applicationId->EditCustomAttributes = "";
        if ($this->applicationId->getSessionValue() != "") {
            $this->applicationId->CurrentValue = GetForeignKeyValue($this->applicationId->getSessionValue());
            $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
            $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
            $this->applicationId->ViewCustomAttributes = "";
        } else {
            $this->applicationId->EditValue = $this->applicationId->CurrentValue;
            $this->applicationId->PlaceHolder = RemoveHtml($this->applicationId->caption());
            if (strval($this->applicationId->EditValue) != "" && is_numeric($this->applicationId->EditValue)) {
                $this->applicationId->EditValue = FormatNumber($this->applicationId->EditValue, null);
            }
        }

        // isheadquarter
        $this->isheadquarter->EditCustomAttributes = "";
        $this->isheadquarter->EditValue = $this->isheadquarter->options(false);
        $this->isheadquarter->PlaceHolder = RemoveHtml($this->isheadquarter->caption());

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
                    $doc->exportCaption($this->pdfLicense);
                    $doc->exportCaption($this->applicationId);
                    $doc->exportCaption($this->isheadquarter);
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
                    $doc->exportCaption($this->applicationId);
                    $doc->exportCaption($this->isheadquarter);
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
                        $doc->exportField($this->pdfLicense);
                        $doc->exportField($this->applicationId);
                        $doc->exportField($this->isheadquarter);
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
                        $doc->exportField($this->applicationId);
                        $doc->exportField($this->isheadquarter);
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
                $filterWrk = '`id` IN (' . $filterWrk . ')';
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `fed_school`";
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
        /*if(CurrentUserLevel() != -1){
       		AddFilter("id = ".CurrentUserID()." OR masterSchoolId = ".CurrentUserMasterSchoolID()." ");
        }*/
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
