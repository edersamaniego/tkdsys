<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for tes_certificate
 */
class TesCertificate extends DbTable
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
    public $background;
    public $_title;
    public $titlePosX;
    public $titlePosY;
    public $titleFont;
    public $titleFontSize;
    public $titleAlign;
    public $text01;
    public $txt01PosX;
    public $txt01PosY;
    public $text02;
    public $txt02PosX;
    public $txt02PosY;
    public $textFont;
    public $textSize;
    public $studentFont;
    public $studentSize;
    public $studentPosX;
    public $studentPosY;
    public $instructorFont;
    public $instructorSize;
    public $instructorPosX;
    public $instructorPosY;
    public $assistantPosX;
    public $assistantPosY;
    public $schoolId;
    public $orientation;
    public $size;
    public $martialArtId;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'tes_certificate';
        $this->TableName = 'tes_certificate';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`tes_certificate`";
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

        // id
        $this->id = new DbField(
            'tes_certificate',
            'tes_certificate',
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

        // description
        $this->description = new DbField(
            'tes_certificate',
            'tes_certificate',
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

        // background
        $this->background = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_background',
            'background',
            '`background`',
            '`background`',
            200,
            255,
            -1,
            true,
            '`background`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->background->InputTextType = "text";
        $this->background->UploadAllowedFileExt = "jpeg,png,jpg";
        $this->background->UploadMaxFileSize = 2000000000;
        $this->background->UploadPath = "certificate/bgs";
        $this->Fields['background'] = &$this->background;

        // title
        $this->_title = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x__title',
            'title',
            '`title`',
            '`title`',
            200,
            255,
            -1,
            false,
            '`title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_title->InputTextType = "text";
        $this->Fields['title'] = &$this->_title;

        // titlePosX
        $this->titlePosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_titlePosX',
            'titlePosX',
            '`titlePosX`',
            '`titlePosX`',
            200,
            255,
            -1,
            false,
            '`titlePosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->titlePosX->InputTextType = "text";
        $this->Fields['titlePosX'] = &$this->titlePosX;

        // titlePosY
        $this->titlePosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_titlePosY',
            'titlePosY',
            '`titlePosY`',
            '`titlePosY`',
            200,
            255,
            -1,
            false,
            '`titlePosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->titlePosY->InputTextType = "text";
        $this->Fields['titlePosY'] = &$this->titlePosY;

        // titleFont
        $this->titleFont = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_titleFont',
            'titleFont',
            '`titleFont`',
            '`titleFont`',
            200,
            255,
            -1,
            false,
            '`titleFont`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->titleFont->InputTextType = "text";
        $this->Fields['titleFont'] = &$this->titleFont;

        // titleFontSize
        $this->titleFontSize = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_titleFontSize',
            'titleFontSize',
            '`titleFontSize`',
            '`titleFontSize`',
            200,
            255,
            -1,
            false,
            '`titleFontSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->titleFontSize->InputTextType = "text";
        $this->Fields['titleFontSize'] = &$this->titleFontSize;

        // titleAlign
        $this->titleAlign = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_titleAlign',
            'titleAlign',
            '`titleAlign`',
            '`titleAlign`',
            200,
            255,
            -1,
            false,
            '`titleAlign`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->titleAlign->InputTextType = "text";
        $this->titleAlign->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->titleAlign->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->titleAlign->Lookup = new Lookup('titleAlign', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->titleAlign->Lookup = new Lookup('titleAlign', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->titleAlign->Lookup = new Lookup('titleAlign', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->titleAlign->Lookup = new Lookup('titleAlign', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->titleAlign->OptionCount = 4;
        $this->Fields['titleAlign'] = &$this->titleAlign;

        // text01
        $this->text01 = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_text01',
            'text01',
            '`text01`',
            '`text01`',
            200,
            255,
            -1,
            false,
            '`text01`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->text01->InputTextType = "text";
        $this->text01->Required = true; // Required field
        $this->Fields['text01'] = &$this->text01;

        // txt01PosX
        $this->txt01PosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_txt01PosX',
            'txt01PosX',
            '`txt01PosX`',
            '`txt01PosX`',
            200,
            255,
            -1,
            false,
            '`txt01PosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->txt01PosX->InputTextType = "text";
        $this->txt01PosX->Required = true; // Required field
        $this->Fields['txt01PosX'] = &$this->txt01PosX;

        // txt01PosY
        $this->txt01PosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_txt01PosY',
            'txt01PosY',
            '`txt01PosY`',
            '`txt01PosY`',
            200,
            255,
            -1,
            false,
            '`txt01PosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->txt01PosY->InputTextType = "text";
        $this->txt01PosY->Required = true; // Required field
        $this->Fields['txt01PosY'] = &$this->txt01PosY;

        // text02
        $this->text02 = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_text02',
            'text02',
            '`text02`',
            '`text02`',
            200,
            255,
            -1,
            false,
            '`text02`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->text02->InputTextType = "text";
        $this->Fields['text02'] = &$this->text02;

        // txt02PosX
        $this->txt02PosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_txt02PosX',
            'txt02PosX',
            '`txt02PosX`',
            '`txt02PosX`',
            200,
            255,
            -1,
            false,
            '`txt02PosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->txt02PosX->InputTextType = "text";
        $this->txt02PosX->Required = true; // Required field
        $this->Fields['txt02PosX'] = &$this->txt02PosX;

        // txt02PosY
        $this->txt02PosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_txt02PosY',
            'txt02PosY',
            '`txt02PosY`',
            '`txt02PosY`',
            200,
            255,
            -1,
            false,
            '`txt02PosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->txt02PosY->InputTextType = "text";
        $this->txt02PosY->Required = true; // Required field
        $this->Fields['txt02PosY'] = &$this->txt02PosY;

        // textFont
        $this->textFont = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_textFont',
            'textFont',
            '`textFont`',
            '`textFont`',
            200,
            255,
            -1,
            false,
            '`textFont`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->textFont->InputTextType = "text";
        $this->textFont->Required = true; // Required field
        $this->textFont->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->textFont->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->textFont->Lookup = new Lookup('textFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->textFont->Lookup = new Lookup('textFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->textFont->Lookup = new Lookup('textFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->textFont->Lookup = new Lookup('textFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->textFont->OptionCount = 5;
        $this->Fields['textFont'] = &$this->textFont;

        // textSize
        $this->textSize = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_textSize',
            'textSize',
            '`textSize`',
            '`textSize`',
            200,
            255,
            -1,
            false,
            '`textSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->textSize->InputTextType = "text";
        $this->textSize->Required = true; // Required field
        $this->Fields['textSize'] = &$this->textSize;

        // studentFont
        $this->studentFont = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_studentFont',
            'studentFont',
            '`studentFont`',
            '`studentFont`',
            200,
            255,
            -1,
            false,
            '`studentFont`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->studentFont->InputTextType = "text";
        $this->studentFont->Required = true; // Required field
        $this->studentFont->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->studentFont->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->studentFont->Lookup = new Lookup('studentFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->studentFont->Lookup = new Lookup('studentFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->studentFont->Lookup = new Lookup('studentFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->studentFont->Lookup = new Lookup('studentFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->studentFont->OptionCount = 5;
        $this->Fields['studentFont'] = &$this->studentFont;

        // studentSize
        $this->studentSize = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_studentSize',
            'studentSize',
            '`studentSize`',
            '`studentSize`',
            200,
            255,
            -1,
            false,
            '`studentSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->studentSize->InputTextType = "text";
        $this->studentSize->Required = true; // Required field
        $this->Fields['studentSize'] = &$this->studentSize;

        // studentPosX
        $this->studentPosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_studentPosX',
            'studentPosX',
            '`studentPosX`',
            '`studentPosX`',
            200,
            255,
            -1,
            false,
            '`studentPosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->studentPosX->InputTextType = "text";
        $this->studentPosX->Required = true; // Required field
        $this->Fields['studentPosX'] = &$this->studentPosX;

        // studentPosY
        $this->studentPosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_studentPosY',
            'studentPosY',
            '`studentPosY`',
            '`studentPosY`',
            200,
            255,
            -1,
            false,
            '`studentPosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->studentPosY->InputTextType = "text";
        $this->studentPosY->Required = true; // Required field
        $this->Fields['studentPosY'] = &$this->studentPosY;

        // instructorFont
        $this->instructorFont = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_instructorFont',
            'instructorFont',
            '`instructorFont`',
            '`instructorFont`',
            200,
            255,
            -1,
            false,
            '`instructorFont`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->instructorFont->InputTextType = "text";
        $this->instructorFont->Required = true; // Required field
        $this->instructorFont->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->instructorFont->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->instructorFont->Lookup = new Lookup('instructorFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->instructorFont->Lookup = new Lookup('instructorFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->instructorFont->Lookup = new Lookup('instructorFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->instructorFont->Lookup = new Lookup('instructorFont', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->instructorFont->OptionCount = 5;
        $this->Fields['instructorFont'] = &$this->instructorFont;

        // instructorSize
        $this->instructorSize = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_instructorSize',
            'instructorSize',
            '`instructorSize`',
            '`instructorSize`',
            200,
            255,
            -1,
            false,
            '`instructorSize`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorSize->InputTextType = "text";
        $this->instructorSize->Required = true; // Required field
        $this->Fields['instructorSize'] = &$this->instructorSize;

        // instructorPosX
        $this->instructorPosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_instructorPosX',
            'instructorPosX',
            '`instructorPosX`',
            '`instructorPosX`',
            200,
            255,
            -1,
            false,
            '`instructorPosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorPosX->InputTextType = "text";
        $this->instructorPosX->Required = true; // Required field
        $this->Fields['instructorPosX'] = &$this->instructorPosX;

        // instructorPosY
        $this->instructorPosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_instructorPosY',
            'instructorPosY',
            '`instructorPosY`',
            '`instructorPosY`',
            200,
            255,
            -1,
            false,
            '`instructorPosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->instructorPosY->InputTextType = "text";
        $this->instructorPosY->Required = true; // Required field
        $this->Fields['instructorPosY'] = &$this->instructorPosY;

        // assistantPosX
        $this->assistantPosX = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_assistantPosX',
            'assistantPosX',
            '`assistantPosX`',
            '`assistantPosX`',
            200,
            255,
            -1,
            false,
            '`assistantPosX`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->assistantPosX->InputTextType = "text";
        $this->assistantPosX->Required = true; // Required field
        $this->Fields['assistantPosX'] = &$this->assistantPosX;

        // assistantPosY
        $this->assistantPosY = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_assistantPosY',
            'assistantPosY',
            '`assistantPosY`',
            '`assistantPosY`',
            200,
            255,
            -1,
            false,
            '`assistantPosY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->assistantPosY->InputTextType = "text";
        $this->assistantPosY->Required = true; // Required field
        $this->Fields['assistantPosY'] = &$this->assistantPosY;

        // schoolId
        $this->schoolId = new DbField(
            'tes_certificate',
            'tes_certificate',
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
        $this->schoolId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->schoolId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","countryId","UFId","cityId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`countryId`,''),'" . ValueSeparator(2, $this->schoolId) . "',COALESCE(`UFId`,''),'" . ValueSeparator(3, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            case "pt-BR":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","countryId","UFId","cityId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`countryId`,''),'" . ValueSeparator(2, $this->schoolId) . "',COALESCE(`UFId`,''),'" . ValueSeparator(3, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            case "es":
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","countryId","UFId","cityId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`countryId`,''),'" . ValueSeparator(2, $this->schoolId) . "',COALESCE(`UFId`,''),'" . ValueSeparator(3, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
            default:
                $this->schoolId->Lookup = new Lookup('schoolId', 'fed_school', false, 'id', ["school","countryId","UFId","cityId"], [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`school`, ''),'" . ValueSeparator(1, $this->schoolId) . "',COALESCE(`countryId`,''),'" . ValueSeparator(2, $this->schoolId) . "',COALESCE(`UFId`,''),'" . ValueSeparator(3, $this->schoolId) . "',COALESCE(`cityId`,''))");
                break;
        }
        $this->schoolId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['schoolId'] = &$this->schoolId;

        // orientation
        $this->orientation = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_orientation',
            'orientation',
            '`orientation`',
            '`orientation`',
            200,
            2,
            -1,
            false,
            '`orientation`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->orientation->InputTextType = "text";
        $this->orientation->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->orientation->Lookup = new Lookup('orientation', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->orientation->Lookup = new Lookup('orientation', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->orientation->Lookup = new Lookup('orientation', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->orientation->Lookup = new Lookup('orientation', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->orientation->OptionCount = 2;
        $this->Fields['orientation'] = &$this->orientation;

        // size
        $this->size = new DbField(
            'tes_certificate',
            'tes_certificate',
            'x_size',
            'size',
            '`size`',
            '`size`',
            200,
            10,
            -1,
            false,
            '`size`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->size->InputTextType = "text";
        $this->size->Required = true; // Required field
        $this->size->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->size->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->size->Lookup = new Lookup('size', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "pt-BR":
                $this->size->Lookup = new Lookup('size', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            case "es":
                $this->size->Lookup = new Lookup('size', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->size->Lookup = new Lookup('size', 'tes_certificate', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->size->OptionCount = 3;
        $this->Fields['size'] = &$this->size;

        // martialArtId
        $this->martialArtId = new DbField(
            'tes_certificate',
            'tes_certificate',
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
        $this->martialArtId->Required = true; // Required field
        $this->martialArtId->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->martialArtId->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            case "pt-BR":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            case "es":
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
            default:
                $this->martialArtId->Lookup = new Lookup('martialArtId', 'fed_martialarts', false, 'id', ["martialArts","","",""], [], [], [], [], [], [], '', '', "`martialArts`");
                break;
        }
        $this->martialArtId->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['martialArtId'] = &$this->martialArtId;

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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`tes_certificate`";
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
                $from = "(SELECT *,  FROM `tes_certificate`)";
                break;
            case "pt-BR":
                $from = "(SELECT *,  FROM `tes_certificate`)";
                break;
            case "es":
                $from = "(SELECT *,  FROM `tes_certificate`)";
                break;
            default:
                $from = "(SELECT *,  FROM `tes_certificate`)";
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
        $this->description->DbValue = $row['description'];
        $this->background->Upload->DbValue = $row['background'];
        $this->_title->DbValue = $row['title'];
        $this->titlePosX->DbValue = $row['titlePosX'];
        $this->titlePosY->DbValue = $row['titlePosY'];
        $this->titleFont->DbValue = $row['titleFont'];
        $this->titleFontSize->DbValue = $row['titleFontSize'];
        $this->titleAlign->DbValue = $row['titleAlign'];
        $this->text01->DbValue = $row['text01'];
        $this->txt01PosX->DbValue = $row['txt01PosX'];
        $this->txt01PosY->DbValue = $row['txt01PosY'];
        $this->text02->DbValue = $row['text02'];
        $this->txt02PosX->DbValue = $row['txt02PosX'];
        $this->txt02PosY->DbValue = $row['txt02PosY'];
        $this->textFont->DbValue = $row['textFont'];
        $this->textSize->DbValue = $row['textSize'];
        $this->studentFont->DbValue = $row['studentFont'];
        $this->studentSize->DbValue = $row['studentSize'];
        $this->studentPosX->DbValue = $row['studentPosX'];
        $this->studentPosY->DbValue = $row['studentPosY'];
        $this->instructorFont->DbValue = $row['instructorFont'];
        $this->instructorSize->DbValue = $row['instructorSize'];
        $this->instructorPosX->DbValue = $row['instructorPosX'];
        $this->instructorPosY->DbValue = $row['instructorPosY'];
        $this->assistantPosX->DbValue = $row['assistantPosX'];
        $this->assistantPosY->DbValue = $row['assistantPosY'];
        $this->schoolId->DbValue = $row['schoolId'];
        $this->orientation->DbValue = $row['orientation'];
        $this->size->DbValue = $row['size'];
        $this->martialArtId->DbValue = $row['martialArtId'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->background->OldUploadPath = "certificate/bgs";
        $oldFiles = EmptyValue($row['background']) ? [] : [$row['background']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->background->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->background->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("TesCertificateList");
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
        if ($pageName == "TesCertificateView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TesCertificateEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TesCertificateAdd") {
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
                return "TesCertificateView";
            case Config("API_ADD_ACTION"):
                return "TesCertificateAdd";
            case Config("API_EDIT_ACTION"):
                return "TesCertificateEdit";
            case Config("API_DELETE_ACTION"):
                return "TesCertificateDelete";
            case Config("API_LIST_ACTION"):
                return "TesCertificateList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TesCertificateList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TesCertificateView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TesCertificateView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TesCertificateAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TesCertificateAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("TesCertificateEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("TesCertificateAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("TesCertificateDelete", $this->getUrlParm());
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
        $this->background->Upload->DbValue = $row['background'];
        $this->_title->setDbValue($row['title']);
        $this->titlePosX->setDbValue($row['titlePosX']);
        $this->titlePosY->setDbValue($row['titlePosY']);
        $this->titleFont->setDbValue($row['titleFont']);
        $this->titleFontSize->setDbValue($row['titleFontSize']);
        $this->titleAlign->setDbValue($row['titleAlign']);
        $this->text01->setDbValue($row['text01']);
        $this->txt01PosX->setDbValue($row['txt01PosX']);
        $this->txt01PosY->setDbValue($row['txt01PosY']);
        $this->text02->setDbValue($row['text02']);
        $this->txt02PosX->setDbValue($row['txt02PosX']);
        $this->txt02PosY->setDbValue($row['txt02PosY']);
        $this->textFont->setDbValue($row['textFont']);
        $this->textSize->setDbValue($row['textSize']);
        $this->studentFont->setDbValue($row['studentFont']);
        $this->studentSize->setDbValue($row['studentSize']);
        $this->studentPosX->setDbValue($row['studentPosX']);
        $this->studentPosY->setDbValue($row['studentPosY']);
        $this->instructorFont->setDbValue($row['instructorFont']);
        $this->instructorSize->setDbValue($row['instructorSize']);
        $this->instructorPosX->setDbValue($row['instructorPosX']);
        $this->instructorPosY->setDbValue($row['instructorPosY']);
        $this->assistantPosX->setDbValue($row['assistantPosX']);
        $this->assistantPosY->setDbValue($row['assistantPosY']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->orientation->setDbValue($row['orientation']);
        $this->size->setDbValue($row['size']);
        $this->martialArtId->setDbValue($row['martialArtId']);
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

        // background

        // title

        // titlePosX

        // titlePosY

        // titleFont

        // titleFontSize

        // titleAlign

        // text01

        // txt01PosX

        // txt01PosY

        // text02

        // txt02PosX

        // txt02PosY

        // textFont

        // textSize

        // studentFont

        // studentSize

        // studentPosX

        // studentPosY

        // instructorFont

        // instructorSize

        // instructorPosX

        // instructorPosY

        // assistantPosX

        // assistantPosY

        // schoolId

        // orientation

        // size

        // martialArtId

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, $this->id->formatPattern());
        $this->id->ViewCustomAttributes = "";

        // description
        $this->description->ViewValue = $this->description->CurrentValue;
        $this->description->ViewCustomAttributes = "";

        // background
        $this->background->UploadPath = "certificate/bgs";
        if (!EmptyValue($this->background->Upload->DbValue)) {
            $this->background->ImageWidth = 90;
            $this->background->ImageHeight = 90;
            $this->background->ImageAlt = $this->background->alt();
            $this->background->ImageCssClass = "ew-image";
            $this->background->ViewValue = $this->background->Upload->DbValue;
        } else {
            $this->background->ViewValue = "";
        }
        $this->background->ViewCustomAttributes = "";

        // title
        $this->_title->ViewValue = $this->_title->CurrentValue;
        $this->_title->ViewCustomAttributes = "";

        // titlePosX
        $this->titlePosX->ViewValue = $this->titlePosX->CurrentValue;
        $this->titlePosX->ViewCustomAttributes = "";

        // titlePosY
        $this->titlePosY->ViewValue = $this->titlePosY->CurrentValue;
        $this->titlePosY->ViewCustomAttributes = "";

        // titleFont
        $this->titleFont->ViewValue = $this->titleFont->CurrentValue;
        $this->titleFont->ViewCustomAttributes = "";

        // titleFontSize
        $this->titleFontSize->ViewValue = $this->titleFontSize->CurrentValue;
        $this->titleFontSize->ViewCustomAttributes = "";

        // titleAlign
        if (strval($this->titleAlign->CurrentValue) != "") {
            $this->titleAlign->ViewValue = $this->titleAlign->optionCaption($this->titleAlign->CurrentValue);
        } else {
            $this->titleAlign->ViewValue = null;
        }
        $this->titleAlign->ViewCustomAttributes = "";

        // text01
        $this->text01->ViewValue = $this->text01->CurrentValue;
        $this->text01->ViewCustomAttributes = "";

        // txt01PosX
        $this->txt01PosX->ViewValue = $this->txt01PosX->CurrentValue;
        $this->txt01PosX->ViewCustomAttributes = "";

        // txt01PosY
        $this->txt01PosY->ViewValue = $this->txt01PosY->CurrentValue;
        $this->txt01PosY->ViewCustomAttributes = "";

        // text02
        $this->text02->ViewValue = $this->text02->CurrentValue;
        $this->text02->ViewCustomAttributes = "";

        // txt02PosX
        $this->txt02PosX->ViewValue = $this->txt02PosX->CurrentValue;
        $this->txt02PosX->ViewCustomAttributes = "";

        // txt02PosY
        $this->txt02PosY->ViewValue = $this->txt02PosY->CurrentValue;
        $this->txt02PosY->ViewCustomAttributes = "";

        // textFont
        if (strval($this->textFont->CurrentValue) != "") {
            $this->textFont->ViewValue = $this->textFont->optionCaption($this->textFont->CurrentValue);
        } else {
            $this->textFont->ViewValue = null;
        }
        $this->textFont->ViewCustomAttributes = "";

        // textSize
        $this->textSize->ViewValue = $this->textSize->CurrentValue;
        $this->textSize->ViewCustomAttributes = "";

        // studentFont
        if (strval($this->studentFont->CurrentValue) != "") {
            $this->studentFont->ViewValue = $this->studentFont->optionCaption($this->studentFont->CurrentValue);
        } else {
            $this->studentFont->ViewValue = null;
        }
        $this->studentFont->ViewCustomAttributes = "";

        // studentSize
        $this->studentSize->ViewValue = $this->studentSize->CurrentValue;
        $this->studentSize->ViewCustomAttributes = "";

        // studentPosX
        $this->studentPosX->ViewValue = $this->studentPosX->CurrentValue;
        $this->studentPosX->ViewCustomAttributes = "";

        // studentPosY
        $this->studentPosY->ViewValue = $this->studentPosY->CurrentValue;
        $this->studentPosY->ViewCustomAttributes = "";

        // instructorFont
        if (strval($this->instructorFont->CurrentValue) != "") {
            $this->instructorFont->ViewValue = $this->instructorFont->optionCaption($this->instructorFont->CurrentValue);
        } else {
            $this->instructorFont->ViewValue = null;
        }
        $this->instructorFont->ViewCustomAttributes = "";

        // instructorSize
        $this->instructorSize->ViewValue = $this->instructorSize->CurrentValue;
        $this->instructorSize->ViewCustomAttributes = "";

        // instructorPosX
        $this->instructorPosX->ViewValue = $this->instructorPosX->CurrentValue;
        $this->instructorPosX->ViewCustomAttributes = "";

        // instructorPosY
        $this->instructorPosY->ViewValue = $this->instructorPosY->CurrentValue;
        $this->instructorPosY->ViewCustomAttributes = "";

        // assistantPosX
        $this->assistantPosX->ViewValue = $this->assistantPosX->CurrentValue;
        $this->assistantPosX->ViewCustomAttributes = "";

        // assistantPosY
        $this->assistantPosY->ViewValue = $this->assistantPosY->CurrentValue;
        $this->assistantPosY->ViewCustomAttributes = "";

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

        // orientation
        if (strval($this->orientation->CurrentValue) != "") {
            $this->orientation->ViewValue = $this->orientation->optionCaption($this->orientation->CurrentValue);
        } else {
            $this->orientation->ViewValue = null;
        }
        $this->orientation->ViewCustomAttributes = "";

        // size
        if (strval($this->size->CurrentValue) != "") {
            $this->size->ViewValue = $this->size->optionCaption($this->size->CurrentValue);
        } else {
            $this->size->ViewValue = null;
        }
        $this->size->ViewCustomAttributes = "";

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // description
        $this->description->LinkCustomAttributes = "";
        $this->description->HrefValue = "";
        $this->description->TooltipValue = "";

        // background
        $this->background->LinkCustomAttributes = "";
        $this->background->UploadPath = "certificate/bgs";
        if (!EmptyValue($this->background->Upload->DbValue)) {
            $this->background->HrefValue = GetFileUploadUrl($this->background, $this->background->htmlDecode($this->background->Upload->DbValue)); // Add prefix/suffix
            $this->background->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->background->HrefValue = FullUrl($this->background->HrefValue, "href");
            }
        } else {
            $this->background->HrefValue = "";
        }
        $this->background->ExportHrefValue = $this->background->UploadPath . $this->background->Upload->DbValue;
        $this->background->TooltipValue = "";
        if ($this->background->UseColorbox) {
            if (EmptyValue($this->background->TooltipValue)) {
                $this->background->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->background->LinkAttrs["data-rel"] = "tes_certificate_x_background";
            $this->background->LinkAttrs->appendClass("ew-lightbox");
        }

        // title
        $this->_title->LinkCustomAttributes = "";
        $this->_title->HrefValue = "";
        $this->_title->TooltipValue = "";

        // titlePosX
        $this->titlePosX->LinkCustomAttributes = "";
        $this->titlePosX->HrefValue = "";
        $this->titlePosX->TooltipValue = "";

        // titlePosY
        $this->titlePosY->LinkCustomAttributes = "";
        $this->titlePosY->HrefValue = "";
        $this->titlePosY->TooltipValue = "";

        // titleFont
        $this->titleFont->LinkCustomAttributes = "";
        $this->titleFont->HrefValue = "";
        $this->titleFont->TooltipValue = "";

        // titleFontSize
        $this->titleFontSize->LinkCustomAttributes = "";
        $this->titleFontSize->HrefValue = "";
        $this->titleFontSize->TooltipValue = "";

        // titleAlign
        $this->titleAlign->LinkCustomAttributes = "";
        $this->titleAlign->HrefValue = "";
        $this->titleAlign->TooltipValue = "";

        // text01
        $this->text01->LinkCustomAttributes = "";
        $this->text01->HrefValue = "";
        $this->text01->TooltipValue = "";

        // txt01PosX
        $this->txt01PosX->LinkCustomAttributes = "";
        $this->txt01PosX->HrefValue = "";
        $this->txt01PosX->TooltipValue = "";

        // txt01PosY
        $this->txt01PosY->LinkCustomAttributes = "";
        $this->txt01PosY->HrefValue = "";
        $this->txt01PosY->TooltipValue = "";

        // text02
        $this->text02->LinkCustomAttributes = "";
        $this->text02->HrefValue = "";
        $this->text02->TooltipValue = "";

        // txt02PosX
        $this->txt02PosX->LinkCustomAttributes = "";
        $this->txt02PosX->HrefValue = "";
        $this->txt02PosX->TooltipValue = "";

        // txt02PosY
        $this->txt02PosY->LinkCustomAttributes = "";
        $this->txt02PosY->HrefValue = "";
        $this->txt02PosY->TooltipValue = "";

        // textFont
        $this->textFont->LinkCustomAttributes = "";
        $this->textFont->HrefValue = "";
        $this->textFont->TooltipValue = "";

        // textSize
        $this->textSize->LinkCustomAttributes = "";
        $this->textSize->HrefValue = "";
        $this->textSize->TooltipValue = "";

        // studentFont
        $this->studentFont->LinkCustomAttributes = "";
        $this->studentFont->HrefValue = "";
        $this->studentFont->TooltipValue = "";

        // studentSize
        $this->studentSize->LinkCustomAttributes = "";
        $this->studentSize->HrefValue = "";
        $this->studentSize->TooltipValue = "";

        // studentPosX
        $this->studentPosX->LinkCustomAttributes = "";
        $this->studentPosX->HrefValue = "";
        $this->studentPosX->TooltipValue = "";

        // studentPosY
        $this->studentPosY->LinkCustomAttributes = "";
        $this->studentPosY->HrefValue = "";
        $this->studentPosY->TooltipValue = "";

        // instructorFont
        $this->instructorFont->LinkCustomAttributes = "";
        $this->instructorFont->HrefValue = "";
        $this->instructorFont->TooltipValue = "";

        // instructorSize
        $this->instructorSize->LinkCustomAttributes = "";
        $this->instructorSize->HrefValue = "";
        $this->instructorSize->TooltipValue = "";

        // instructorPosX
        $this->instructorPosX->LinkCustomAttributes = "";
        $this->instructorPosX->HrefValue = "";
        $this->instructorPosX->TooltipValue = "";

        // instructorPosY
        $this->instructorPosY->LinkCustomAttributes = "";
        $this->instructorPosY->HrefValue = "";
        $this->instructorPosY->TooltipValue = "";

        // assistantPosX
        $this->assistantPosX->LinkCustomAttributes = "";
        $this->assistantPosX->HrefValue = "";
        $this->assistantPosX->TooltipValue = "";

        // assistantPosY
        $this->assistantPosY->LinkCustomAttributes = "";
        $this->assistantPosY->HrefValue = "";
        $this->assistantPosY->TooltipValue = "";

        // schoolId
        $this->schoolId->LinkCustomAttributes = "";
        $this->schoolId->HrefValue = "";
        $this->schoolId->TooltipValue = "";

        // orientation
        $this->orientation->LinkCustomAttributes = "";
        $this->orientation->HrefValue = "";
        $this->orientation->TooltipValue = "";

        // size
        $this->size->LinkCustomAttributes = "";
        $this->size->HrefValue = "";
        $this->size->TooltipValue = "";

        // martialArtId
        $this->martialArtId->LinkCustomAttributes = "";
        $this->martialArtId->HrefValue = "";
        $this->martialArtId->TooltipValue = "";

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
        $this->id->EditValue = FormatNumber($this->id->EditValue, $this->id->formatPattern());
        $this->id->ViewCustomAttributes = "";

        // description
        $this->description->setupEditAttributes();
        $this->description->EditCustomAttributes = "";
        if (!$this->description->Raw) {
            $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
        }
        $this->description->EditValue = $this->description->CurrentValue;
        $this->description->PlaceHolder = RemoveHtml($this->description->caption());

        // background
        $this->background->setupEditAttributes();
        $this->background->EditCustomAttributes = "";
        $this->background->UploadPath = "certificate/bgs";
        if (!EmptyValue($this->background->Upload->DbValue)) {
            $this->background->ImageWidth = 90;
            $this->background->ImageHeight = 90;
            $this->background->ImageAlt = $this->background->alt();
            $this->background->ImageCssClass = "ew-image";
            $this->background->EditValue = $this->background->Upload->DbValue;
        } else {
            $this->background->EditValue = "";
        }
        if (!EmptyValue($this->background->CurrentValue)) {
            $this->background->Upload->FileName = $this->background->CurrentValue;
        }

        // title
        $this->_title->setupEditAttributes();
        $this->_title->EditCustomAttributes = "";
        if (!$this->_title->Raw) {
            $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
        }
        $this->_title->EditValue = $this->_title->CurrentValue;
        $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

        // titlePosX
        $this->titlePosX->setupEditAttributes();
        $this->titlePosX->EditCustomAttributes = "";
        if (!$this->titlePosX->Raw) {
            $this->titlePosX->CurrentValue = HtmlDecode($this->titlePosX->CurrentValue);
        }
        $this->titlePosX->EditValue = $this->titlePosX->CurrentValue;
        $this->titlePosX->PlaceHolder = RemoveHtml($this->titlePosX->caption());

        // titlePosY
        $this->titlePosY->setupEditAttributes();
        $this->titlePosY->EditCustomAttributes = "";
        if (!$this->titlePosY->Raw) {
            $this->titlePosY->CurrentValue = HtmlDecode($this->titlePosY->CurrentValue);
        }
        $this->titlePosY->EditValue = $this->titlePosY->CurrentValue;
        $this->titlePosY->PlaceHolder = RemoveHtml($this->titlePosY->caption());

        // titleFont
        $this->titleFont->setupEditAttributes();
        $this->titleFont->EditCustomAttributes = "";
        if (!$this->titleFont->Raw) {
            $this->titleFont->CurrentValue = HtmlDecode($this->titleFont->CurrentValue);
        }
        $this->titleFont->EditValue = $this->titleFont->CurrentValue;
        $this->titleFont->PlaceHolder = RemoveHtml($this->titleFont->caption());

        // titleFontSize
        $this->titleFontSize->setupEditAttributes();
        $this->titleFontSize->EditCustomAttributes = "";
        if (!$this->titleFontSize->Raw) {
            $this->titleFontSize->CurrentValue = HtmlDecode($this->titleFontSize->CurrentValue);
        }
        $this->titleFontSize->EditValue = $this->titleFontSize->CurrentValue;
        $this->titleFontSize->PlaceHolder = RemoveHtml($this->titleFontSize->caption());

        // titleAlign
        $this->titleAlign->setupEditAttributes();
        $this->titleAlign->EditCustomAttributes = "";
        $this->titleAlign->EditValue = $this->titleAlign->options(true);
        $this->titleAlign->PlaceHolder = RemoveHtml($this->titleAlign->caption());

        // text01
        $this->text01->setupEditAttributes();
        $this->text01->EditCustomAttributes = "";
        $this->text01->EditValue = $this->text01->CurrentValue;
        $this->text01->PlaceHolder = RemoveHtml($this->text01->caption());

        // txt01PosX
        $this->txt01PosX->setupEditAttributes();
        $this->txt01PosX->EditCustomAttributes = "";
        if (!$this->txt01PosX->Raw) {
            $this->txt01PosX->CurrentValue = HtmlDecode($this->txt01PosX->CurrentValue);
        }
        $this->txt01PosX->EditValue = $this->txt01PosX->CurrentValue;
        $this->txt01PosX->PlaceHolder = RemoveHtml($this->txt01PosX->caption());

        // txt01PosY
        $this->txt01PosY->setupEditAttributes();
        $this->txt01PosY->EditCustomAttributes = "";
        if (!$this->txt01PosY->Raw) {
            $this->txt01PosY->CurrentValue = HtmlDecode($this->txt01PosY->CurrentValue);
        }
        $this->txt01PosY->EditValue = $this->txt01PosY->CurrentValue;
        $this->txt01PosY->PlaceHolder = RemoveHtml($this->txt01PosY->caption());

        // text02
        $this->text02->setupEditAttributes();
        $this->text02->EditCustomAttributes = "";
        $this->text02->EditValue = $this->text02->CurrentValue;
        $this->text02->PlaceHolder = RemoveHtml($this->text02->caption());

        // txt02PosX
        $this->txt02PosX->setupEditAttributes();
        $this->txt02PosX->EditCustomAttributes = "";
        if (!$this->txt02PosX->Raw) {
            $this->txt02PosX->CurrentValue = HtmlDecode($this->txt02PosX->CurrentValue);
        }
        $this->txt02PosX->EditValue = $this->txt02PosX->CurrentValue;
        $this->txt02PosX->PlaceHolder = RemoveHtml($this->txt02PosX->caption());

        // txt02PosY
        $this->txt02PosY->setupEditAttributes();
        $this->txt02PosY->EditCustomAttributes = "";
        if (!$this->txt02PosY->Raw) {
            $this->txt02PosY->CurrentValue = HtmlDecode($this->txt02PosY->CurrentValue);
        }
        $this->txt02PosY->EditValue = $this->txt02PosY->CurrentValue;
        $this->txt02PosY->PlaceHolder = RemoveHtml($this->txt02PosY->caption());

        // textFont
        $this->textFont->setupEditAttributes();
        $this->textFont->EditCustomAttributes = "";
        $this->textFont->EditValue = $this->textFont->options(true);
        $this->textFont->PlaceHolder = RemoveHtml($this->textFont->caption());

        // textSize
        $this->textSize->setupEditAttributes();
        $this->textSize->EditCustomAttributes = "";
        if (!$this->textSize->Raw) {
            $this->textSize->CurrentValue = HtmlDecode($this->textSize->CurrentValue);
        }
        $this->textSize->EditValue = $this->textSize->CurrentValue;
        $this->textSize->PlaceHolder = RemoveHtml($this->textSize->caption());

        // studentFont
        $this->studentFont->setupEditAttributes();
        $this->studentFont->EditCustomAttributes = "";
        $this->studentFont->EditValue = $this->studentFont->options(true);
        $this->studentFont->PlaceHolder = RemoveHtml($this->studentFont->caption());

        // studentSize
        $this->studentSize->setupEditAttributes();
        $this->studentSize->EditCustomAttributes = "";
        if (!$this->studentSize->Raw) {
            $this->studentSize->CurrentValue = HtmlDecode($this->studentSize->CurrentValue);
        }
        $this->studentSize->EditValue = $this->studentSize->CurrentValue;
        $this->studentSize->PlaceHolder = RemoveHtml($this->studentSize->caption());

        // studentPosX
        $this->studentPosX->setupEditAttributes();
        $this->studentPosX->EditCustomAttributes = "";
        if (!$this->studentPosX->Raw) {
            $this->studentPosX->CurrentValue = HtmlDecode($this->studentPosX->CurrentValue);
        }
        $this->studentPosX->EditValue = $this->studentPosX->CurrentValue;
        $this->studentPosX->PlaceHolder = RemoveHtml($this->studentPosX->caption());

        // studentPosY
        $this->studentPosY->setupEditAttributes();
        $this->studentPosY->EditCustomAttributes = "";
        if (!$this->studentPosY->Raw) {
            $this->studentPosY->CurrentValue = HtmlDecode($this->studentPosY->CurrentValue);
        }
        $this->studentPosY->EditValue = $this->studentPosY->CurrentValue;
        $this->studentPosY->PlaceHolder = RemoveHtml($this->studentPosY->caption());

        // instructorFont
        $this->instructorFont->setupEditAttributes();
        $this->instructorFont->EditCustomAttributes = "";
        $this->instructorFont->EditValue = $this->instructorFont->options(true);
        $this->instructorFont->PlaceHolder = RemoveHtml($this->instructorFont->caption());

        // instructorSize
        $this->instructorSize->setupEditAttributes();
        $this->instructorSize->EditCustomAttributes = "";
        if (!$this->instructorSize->Raw) {
            $this->instructorSize->CurrentValue = HtmlDecode($this->instructorSize->CurrentValue);
        }
        $this->instructorSize->EditValue = $this->instructorSize->CurrentValue;
        $this->instructorSize->PlaceHolder = RemoveHtml($this->instructorSize->caption());

        // instructorPosX
        $this->instructorPosX->setupEditAttributes();
        $this->instructorPosX->EditCustomAttributes = "";
        if (!$this->instructorPosX->Raw) {
            $this->instructorPosX->CurrentValue = HtmlDecode($this->instructorPosX->CurrentValue);
        }
        $this->instructorPosX->EditValue = $this->instructorPosX->CurrentValue;
        $this->instructorPosX->PlaceHolder = RemoveHtml($this->instructorPosX->caption());

        // instructorPosY
        $this->instructorPosY->setupEditAttributes();
        $this->instructorPosY->EditCustomAttributes = "";
        if (!$this->instructorPosY->Raw) {
            $this->instructorPosY->CurrentValue = HtmlDecode($this->instructorPosY->CurrentValue);
        }
        $this->instructorPosY->EditValue = $this->instructorPosY->CurrentValue;
        $this->instructorPosY->PlaceHolder = RemoveHtml($this->instructorPosY->caption());

        // assistantPosX
        $this->assistantPosX->setupEditAttributes();
        $this->assistantPosX->EditCustomAttributes = "";
        if (!$this->assistantPosX->Raw) {
            $this->assistantPosX->CurrentValue = HtmlDecode($this->assistantPosX->CurrentValue);
        }
        $this->assistantPosX->EditValue = $this->assistantPosX->CurrentValue;
        $this->assistantPosX->PlaceHolder = RemoveHtml($this->assistantPosX->caption());

        // assistantPosY
        $this->assistantPosY->setupEditAttributes();
        $this->assistantPosY->EditCustomAttributes = "";
        if (!$this->assistantPosY->Raw) {
            $this->assistantPosY->CurrentValue = HtmlDecode($this->assistantPosY->CurrentValue);
        }
        $this->assistantPosY->EditValue = $this->assistantPosY->CurrentValue;
        $this->assistantPosY->PlaceHolder = RemoveHtml($this->assistantPosY->caption());

        // schoolId
        $this->schoolId->setupEditAttributes();
        $this->schoolId->EditCustomAttributes = "";
        $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());

        // orientation
        $this->orientation->EditCustomAttributes = "";
        $this->orientation->EditValue = $this->orientation->options(false);
        $this->orientation->PlaceHolder = RemoveHtml($this->orientation->caption());

        // size
        $this->size->setupEditAttributes();
        $this->size->EditCustomAttributes = "";
        $this->size->EditValue = $this->size->options(true);
        $this->size->PlaceHolder = RemoveHtml($this->size->caption());

        // martialArtId
        $this->martialArtId->setupEditAttributes();
        $this->martialArtId->EditCustomAttributes = "";
        $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

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
                    $doc->exportCaption($this->background);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->titlePosX);
                    $doc->exportCaption($this->titlePosY);
                    $doc->exportCaption($this->titleFont);
                    $doc->exportCaption($this->titleFontSize);
                    $doc->exportCaption($this->titleAlign);
                    $doc->exportCaption($this->text01);
                    $doc->exportCaption($this->txt01PosX);
                    $doc->exportCaption($this->txt01PosY);
                    $doc->exportCaption($this->text02);
                    $doc->exportCaption($this->txt02PosX);
                    $doc->exportCaption($this->txt02PosY);
                    $doc->exportCaption($this->textFont);
                    $doc->exportCaption($this->textSize);
                    $doc->exportCaption($this->studentFont);
                    $doc->exportCaption($this->studentSize);
                    $doc->exportCaption($this->studentPosX);
                    $doc->exportCaption($this->studentPosY);
                    $doc->exportCaption($this->instructorFont);
                    $doc->exportCaption($this->instructorSize);
                    $doc->exportCaption($this->instructorPosX);
                    $doc->exportCaption($this->instructorPosY);
                    $doc->exportCaption($this->assistantPosX);
                    $doc->exportCaption($this->assistantPosY);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->orientation);
                    $doc->exportCaption($this->size);
                    $doc->exportCaption($this->martialArtId);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->background);
                    $doc->exportCaption($this->_title);
                    $doc->exportCaption($this->titlePosX);
                    $doc->exportCaption($this->titlePosY);
                    $doc->exportCaption($this->titleFont);
                    $doc->exportCaption($this->titleFontSize);
                    $doc->exportCaption($this->titleAlign);
                    $doc->exportCaption($this->text01);
                    $doc->exportCaption($this->txt01PosX);
                    $doc->exportCaption($this->txt01PosY);
                    $doc->exportCaption($this->text02);
                    $doc->exportCaption($this->txt02PosX);
                    $doc->exportCaption($this->txt02PosY);
                    $doc->exportCaption($this->textFont);
                    $doc->exportCaption($this->textSize);
                    $doc->exportCaption($this->studentFont);
                    $doc->exportCaption($this->studentSize);
                    $doc->exportCaption($this->studentPosX);
                    $doc->exportCaption($this->studentPosY);
                    $doc->exportCaption($this->instructorFont);
                    $doc->exportCaption($this->instructorSize);
                    $doc->exportCaption($this->instructorPosX);
                    $doc->exportCaption($this->instructorPosY);
                    $doc->exportCaption($this->assistantPosX);
                    $doc->exportCaption($this->assistantPosY);
                    $doc->exportCaption($this->schoolId);
                    $doc->exportCaption($this->orientation);
                    $doc->exportCaption($this->size);
                    $doc->exportCaption($this->martialArtId);
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
                        $doc->exportField($this->background);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->titlePosX);
                        $doc->exportField($this->titlePosY);
                        $doc->exportField($this->titleFont);
                        $doc->exportField($this->titleFontSize);
                        $doc->exportField($this->titleAlign);
                        $doc->exportField($this->text01);
                        $doc->exportField($this->txt01PosX);
                        $doc->exportField($this->txt01PosY);
                        $doc->exportField($this->text02);
                        $doc->exportField($this->txt02PosX);
                        $doc->exportField($this->txt02PosY);
                        $doc->exportField($this->textFont);
                        $doc->exportField($this->textSize);
                        $doc->exportField($this->studentFont);
                        $doc->exportField($this->studentSize);
                        $doc->exportField($this->studentPosX);
                        $doc->exportField($this->studentPosY);
                        $doc->exportField($this->instructorFont);
                        $doc->exportField($this->instructorSize);
                        $doc->exportField($this->instructorPosX);
                        $doc->exportField($this->instructorPosY);
                        $doc->exportField($this->assistantPosX);
                        $doc->exportField($this->assistantPosY);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->orientation);
                        $doc->exportField($this->size);
                        $doc->exportField($this->martialArtId);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->description);
                        $doc->exportField($this->background);
                        $doc->exportField($this->_title);
                        $doc->exportField($this->titlePosX);
                        $doc->exportField($this->titlePosY);
                        $doc->exportField($this->titleFont);
                        $doc->exportField($this->titleFontSize);
                        $doc->exportField($this->titleAlign);
                        $doc->exportField($this->text01);
                        $doc->exportField($this->txt01PosX);
                        $doc->exportField($this->txt01PosY);
                        $doc->exportField($this->text02);
                        $doc->exportField($this->txt02PosX);
                        $doc->exportField($this->txt02PosY);
                        $doc->exportField($this->textFont);
                        $doc->exportField($this->textSize);
                        $doc->exportField($this->studentFont);
                        $doc->exportField($this->studentSize);
                        $doc->exportField($this->studentPosX);
                        $doc->exportField($this->studentPosY);
                        $doc->exportField($this->instructorFont);
                        $doc->exportField($this->instructorSize);
                        $doc->exportField($this->instructorPosX);
                        $doc->exportField($this->instructorPosY);
                        $doc->exportField($this->assistantPosX);
                        $doc->exportField($this->assistantPosY);
                        $doc->exportField($this->schoolId);
                        $doc->exportField($this->orientation);
                        $doc->exportField($this->size);
                        $doc->exportField($this->martialArtId);
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
        if ($fldparm == 'background') {
            $fldName = "background";
            $fileNameFld = "background";
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
