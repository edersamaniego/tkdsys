<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesCertificateDelete extends TesCertificate
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_certificate';

    // Page object name
    public $PageObjName = "TesCertificateDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (tes_certificate)
        if (!isset($GLOBALS["tes_certificate"]) || get_class($GLOBALS["tes_certificate"]) == PROJECT_NAMESPACE . "tes_certificate") {
            $GLOBALS["tes_certificate"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_certificate');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("tes_certificate");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
		        $this->background->OldUploadPath = "certificate/bgs";
		        $this->background->UploadPath = $this->background->OldUploadPath;
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->description->setVisibility();
        $this->background->setVisibility();
        $this->_title->Visible = false;
        $this->titlePosX->Visible = false;
        $this->titlePosY->Visible = false;
        $this->titleFont->Visible = false;
        $this->titleFontSize->Visible = false;
        $this->titleAlign->Visible = false;
        $this->text01->Visible = false;
        $this->txt01PosX->Visible = false;
        $this->txt01PosY->Visible = false;
        $this->text02->Visible = false;
        $this->txt02PosX->Visible = false;
        $this->txt02PosY->Visible = false;
        $this->textFont->Visible = false;
        $this->textSize->Visible = false;
        $this->studentFont->Visible = false;
        $this->studentSize->Visible = false;
        $this->studentPosX->Visible = false;
        $this->studentPosY->Visible = false;
        $this->instructorFont->Visible = false;
        $this->instructorSize->Visible = false;
        $this->instructorPosX->Visible = false;
        $this->instructorPosY->Visible = false;
        $this->assistantPosX->Visible = false;
        $this->assistantPosY->Visible = false;
        $this->schoolId->Visible = false;
        $this->orientation->setVisibility();
        $this->size->setVisibility();
        $this->martialArtId->Visible = false;
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->titleAlign);
        $this->setupLookupOptions($this->textFont);
        $this->setupLookupOptions($this->studentFont);
        $this->setupLookupOptions($this->instructorFont);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->orientation);
        $this->setupLookupOptions($this->size);
        $this->setupLookupOptions($this->martialArtId);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("TesCertificateList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "delete"; // Delete record directly
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->terminate($this->getReturnUrl()); // Return to caller
                return;
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("TesCertificateList"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->id->setDbValue($row['id']);
        $this->description->setDbValue($row['description']);
        $this->background->Upload->DbValue = $row['background'];
        $this->background->setDbValue($this->background->Upload->DbValue);
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
        if (array_key_exists('EV__schoolId', $row)) {
            $this->schoolId->VirtualValue = $row['EV__schoolId']; // Set up virtual field value
        } else {
            $this->schoolId->VirtualValue = ""; // Clear value
        }
        $this->orientation->setDbValue($row['orientation']);
        $this->size->setDbValue($row['size']);
        $this->martialArtId->setDbValue($row['martialArtId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['description'] = $this->description->DefaultValue;
        $row['background'] = $this->background->DefaultValue;
        $row['title'] = $this->_title->DefaultValue;
        $row['titlePosX'] = $this->titlePosX->DefaultValue;
        $row['titlePosY'] = $this->titlePosY->DefaultValue;
        $row['titleFont'] = $this->titleFont->DefaultValue;
        $row['titleFontSize'] = $this->titleFontSize->DefaultValue;
        $row['titleAlign'] = $this->titleAlign->DefaultValue;
        $row['text01'] = $this->text01->DefaultValue;
        $row['txt01PosX'] = $this->txt01PosX->DefaultValue;
        $row['txt01PosY'] = $this->txt01PosY->DefaultValue;
        $row['text02'] = $this->text02->DefaultValue;
        $row['txt02PosX'] = $this->txt02PosX->DefaultValue;
        $row['txt02PosY'] = $this->txt02PosY->DefaultValue;
        $row['textFont'] = $this->textFont->DefaultValue;
        $row['textSize'] = $this->textSize->DefaultValue;
        $row['studentFont'] = $this->studentFont->DefaultValue;
        $row['studentSize'] = $this->studentSize->DefaultValue;
        $row['studentPosX'] = $this->studentPosX->DefaultValue;
        $row['studentPosY'] = $this->studentPosY->DefaultValue;
        $row['instructorFont'] = $this->instructorFont->DefaultValue;
        $row['instructorSize'] = $this->instructorSize->DefaultValue;
        $row['instructorPosX'] = $this->instructorPosX->DefaultValue;
        $row['instructorPosY'] = $this->instructorPosY->DefaultValue;
        $row['assistantPosX'] = $this->assistantPosX->DefaultValue;
        $row['assistantPosY'] = $this->assistantPosY->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['orientation'] = $this->orientation->DefaultValue;
        $row['size'] = $this->size->DefaultValue;
        $row['martialArtId'] = $this->martialArtId->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // orientation
            $this->orientation->LinkCustomAttributes = "";
            $this->orientation->HrefValue = "";
            $this->orientation->TooltipValue = "";

            // size
            $this->size->LinkCustomAttributes = "";
            $this->size->HrefValue = "";
            $this->size->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteSomeRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TesCertificateList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_titleAlign":
                    break;
                case "x_textFont":
                    break;
                case "x_studentFont":
                    break;
                case "x_instructorFont":
                    break;
                case "x_schoolId":
                    break;
                case "x_orientation":
                    break;
                case "x_size":
                    break;
                case "x_martialArtId":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
