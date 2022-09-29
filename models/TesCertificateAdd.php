<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesCertificateAdd extends TesCertificate
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_certificate';

    // Page object name
    public $PageObjName = "TesCertificateAdd";

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "TesCertificateView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->description->setVisibility();
        $this->background->setVisibility();
        $this->_title->setVisibility();
        $this->titlePosX->setVisibility();
        $this->titlePosY->setVisibility();
        $this->titleFont->setVisibility();
        $this->titleFontSize->setVisibility();
        $this->titleAlign->setVisibility();
        $this->text01->setVisibility();
        $this->txt01PosX->setVisibility();
        $this->txt01PosY->setVisibility();
        $this->text02->setVisibility();
        $this->txt02PosX->setVisibility();
        $this->txt02PosY->setVisibility();
        $this->textFont->setVisibility();
        $this->textSize->setVisibility();
        $this->studentFont->setVisibility();
        $this->studentSize->setVisibility();
        $this->studentPosX->setVisibility();
        $this->studentPosY->setVisibility();
        $this->instructorFont->setVisibility();
        $this->instructorSize->setVisibility();
        $this->instructorPosX->setVisibility();
        $this->instructorPosY->setVisibility();
        $this->assistantPosX->setVisibility();
        $this->assistantPosY->setVisibility();
        $this->schoolId->setVisibility();
        $this->orientation->setVisibility();
        $this->size->setVisibility();
        $this->martialArtId->setVisibility();
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

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("TesCertificateList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "TesCertificateList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "TesCertificateView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view type
        } else {
            $this->RowType = ROWTYPE_ADD; // Render add type
        }

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->background->Upload->Index = $CurrentForm->Index;
        $this->background->Upload->uploadFile();
        $this->background->CurrentValue = $this->background->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'title' first before field var 'x__title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x__title");
        if (!$this->_title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_title->Visible = false; // Disable update for API request
            } else {
                $this->_title->setFormValue($val);
            }
        }

        // Check field name 'titlePosX' first before field var 'x_titlePosX'
        $val = $CurrentForm->hasValue("titlePosX") ? $CurrentForm->getValue("titlePosX") : $CurrentForm->getValue("x_titlePosX");
        if (!$this->titlePosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titlePosX->Visible = false; // Disable update for API request
            } else {
                $this->titlePosX->setFormValue($val);
            }
        }

        // Check field name 'titlePosY' first before field var 'x_titlePosY'
        $val = $CurrentForm->hasValue("titlePosY") ? $CurrentForm->getValue("titlePosY") : $CurrentForm->getValue("x_titlePosY");
        if (!$this->titlePosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titlePosY->Visible = false; // Disable update for API request
            } else {
                $this->titlePosY->setFormValue($val);
            }
        }

        // Check field name 'titleFont' first before field var 'x_titleFont'
        $val = $CurrentForm->hasValue("titleFont") ? $CurrentForm->getValue("titleFont") : $CurrentForm->getValue("x_titleFont");
        if (!$this->titleFont->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titleFont->Visible = false; // Disable update for API request
            } else {
                $this->titleFont->setFormValue($val);
            }
        }

        // Check field name 'titleFontSize' first before field var 'x_titleFontSize'
        $val = $CurrentForm->hasValue("titleFontSize") ? $CurrentForm->getValue("titleFontSize") : $CurrentForm->getValue("x_titleFontSize");
        if (!$this->titleFontSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titleFontSize->Visible = false; // Disable update for API request
            } else {
                $this->titleFontSize->setFormValue($val);
            }
        }

        // Check field name 'titleAlign' first before field var 'x_titleAlign'
        $val = $CurrentForm->hasValue("titleAlign") ? $CurrentForm->getValue("titleAlign") : $CurrentForm->getValue("x_titleAlign");
        if (!$this->titleAlign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titleAlign->Visible = false; // Disable update for API request
            } else {
                $this->titleAlign->setFormValue($val);
            }
        }

        // Check field name 'text01' first before field var 'x_text01'
        $val = $CurrentForm->hasValue("text01") ? $CurrentForm->getValue("text01") : $CurrentForm->getValue("x_text01");
        if (!$this->text01->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->text01->Visible = false; // Disable update for API request
            } else {
                $this->text01->setFormValue($val);
            }
        }

        // Check field name 'txt01PosX' first before field var 'x_txt01PosX'
        $val = $CurrentForm->hasValue("txt01PosX") ? $CurrentForm->getValue("txt01PosX") : $CurrentForm->getValue("x_txt01PosX");
        if (!$this->txt01PosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->txt01PosX->Visible = false; // Disable update for API request
            } else {
                $this->txt01PosX->setFormValue($val);
            }
        }

        // Check field name 'txt01PosY' first before field var 'x_txt01PosY'
        $val = $CurrentForm->hasValue("txt01PosY") ? $CurrentForm->getValue("txt01PosY") : $CurrentForm->getValue("x_txt01PosY");
        if (!$this->txt01PosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->txt01PosY->Visible = false; // Disable update for API request
            } else {
                $this->txt01PosY->setFormValue($val);
            }
        }

        // Check field name 'text02' first before field var 'x_text02'
        $val = $CurrentForm->hasValue("text02") ? $CurrentForm->getValue("text02") : $CurrentForm->getValue("x_text02");
        if (!$this->text02->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->text02->Visible = false; // Disable update for API request
            } else {
                $this->text02->setFormValue($val);
            }
        }

        // Check field name 'txt02PosX' first before field var 'x_txt02PosX'
        $val = $CurrentForm->hasValue("txt02PosX") ? $CurrentForm->getValue("txt02PosX") : $CurrentForm->getValue("x_txt02PosX");
        if (!$this->txt02PosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->txt02PosX->Visible = false; // Disable update for API request
            } else {
                $this->txt02PosX->setFormValue($val);
            }
        }

        // Check field name 'txt02PosY' first before field var 'x_txt02PosY'
        $val = $CurrentForm->hasValue("txt02PosY") ? $CurrentForm->getValue("txt02PosY") : $CurrentForm->getValue("x_txt02PosY");
        if (!$this->txt02PosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->txt02PosY->Visible = false; // Disable update for API request
            } else {
                $this->txt02PosY->setFormValue($val);
            }
        }

        // Check field name 'textFont' first before field var 'x_textFont'
        $val = $CurrentForm->hasValue("textFont") ? $CurrentForm->getValue("textFont") : $CurrentForm->getValue("x_textFont");
        if (!$this->textFont->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->textFont->Visible = false; // Disable update for API request
            } else {
                $this->textFont->setFormValue($val);
            }
        }

        // Check field name 'textSize' first before field var 'x_textSize'
        $val = $CurrentForm->hasValue("textSize") ? $CurrentForm->getValue("textSize") : $CurrentForm->getValue("x_textSize");
        if (!$this->textSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->textSize->Visible = false; // Disable update for API request
            } else {
                $this->textSize->setFormValue($val);
            }
        }

        // Check field name 'studentFont' first before field var 'x_studentFont'
        $val = $CurrentForm->hasValue("studentFont") ? $CurrentForm->getValue("studentFont") : $CurrentForm->getValue("x_studentFont");
        if (!$this->studentFont->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->studentFont->Visible = false; // Disable update for API request
            } else {
                $this->studentFont->setFormValue($val);
            }
        }

        // Check field name 'studentSize' first before field var 'x_studentSize'
        $val = $CurrentForm->hasValue("studentSize") ? $CurrentForm->getValue("studentSize") : $CurrentForm->getValue("x_studentSize");
        if (!$this->studentSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->studentSize->Visible = false; // Disable update for API request
            } else {
                $this->studentSize->setFormValue($val);
            }
        }

        // Check field name 'studentPosX' first before field var 'x_studentPosX'
        $val = $CurrentForm->hasValue("studentPosX") ? $CurrentForm->getValue("studentPosX") : $CurrentForm->getValue("x_studentPosX");
        if (!$this->studentPosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->studentPosX->Visible = false; // Disable update for API request
            } else {
                $this->studentPosX->setFormValue($val);
            }
        }

        // Check field name 'studentPosY' first before field var 'x_studentPosY'
        $val = $CurrentForm->hasValue("studentPosY") ? $CurrentForm->getValue("studentPosY") : $CurrentForm->getValue("x_studentPosY");
        if (!$this->studentPosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->studentPosY->Visible = false; // Disable update for API request
            } else {
                $this->studentPosY->setFormValue($val);
            }
        }

        // Check field name 'instructorFont' first before field var 'x_instructorFont'
        $val = $CurrentForm->hasValue("instructorFont") ? $CurrentForm->getValue("instructorFont") : $CurrentForm->getValue("x_instructorFont");
        if (!$this->instructorFont->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorFont->Visible = false; // Disable update for API request
            } else {
                $this->instructorFont->setFormValue($val);
            }
        }

        // Check field name 'instructorSize' first before field var 'x_instructorSize'
        $val = $CurrentForm->hasValue("instructorSize") ? $CurrentForm->getValue("instructorSize") : $CurrentForm->getValue("x_instructorSize");
        if (!$this->instructorSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorSize->Visible = false; // Disable update for API request
            } else {
                $this->instructorSize->setFormValue($val);
            }
        }

        // Check field name 'instructorPosX' first before field var 'x_instructorPosX'
        $val = $CurrentForm->hasValue("instructorPosX") ? $CurrentForm->getValue("instructorPosX") : $CurrentForm->getValue("x_instructorPosX");
        if (!$this->instructorPosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorPosX->Visible = false; // Disable update for API request
            } else {
                $this->instructorPosX->setFormValue($val);
            }
        }

        // Check field name 'instructorPosY' first before field var 'x_instructorPosY'
        $val = $CurrentForm->hasValue("instructorPosY") ? $CurrentForm->getValue("instructorPosY") : $CurrentForm->getValue("x_instructorPosY");
        if (!$this->instructorPosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorPosY->Visible = false; // Disable update for API request
            } else {
                $this->instructorPosY->setFormValue($val);
            }
        }

        // Check field name 'assistantPosX' first before field var 'x_assistantPosX'
        $val = $CurrentForm->hasValue("assistantPosX") ? $CurrentForm->getValue("assistantPosX") : $CurrentForm->getValue("x_assistantPosX");
        if (!$this->assistantPosX->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assistantPosX->Visible = false; // Disable update for API request
            } else {
                $this->assistantPosX->setFormValue($val);
            }
        }

        // Check field name 'assistantPosY' first before field var 'x_assistantPosY'
        $val = $CurrentForm->hasValue("assistantPosY") ? $CurrentForm->getValue("assistantPosY") : $CurrentForm->getValue("x_assistantPosY");
        if (!$this->assistantPosY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->assistantPosY->Visible = false; // Disable update for API request
            } else {
                $this->assistantPosY->setFormValue($val);
            }
        }

        // Check field name 'schoolId' first before field var 'x_schoolId'
        $val = $CurrentForm->hasValue("schoolId") ? $CurrentForm->getValue("schoolId") : $CurrentForm->getValue("x_schoolId");
        if (!$this->schoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schoolId->Visible = false; // Disable update for API request
            } else {
                $this->schoolId->setFormValue($val);
            }
        }

        // Check field name 'orientation' first before field var 'x_orientation'
        $val = $CurrentForm->hasValue("orientation") ? $CurrentForm->getValue("orientation") : $CurrentForm->getValue("x_orientation");
        if (!$this->orientation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orientation->Visible = false; // Disable update for API request
            } else {
                $this->orientation->setFormValue($val);
            }
        }

        // Check field name 'size' first before field var 'x_size'
        $val = $CurrentForm->hasValue("size") ? $CurrentForm->getValue("size") : $CurrentForm->getValue("x_size");
        if (!$this->size->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->size->Visible = false; // Disable update for API request
            } else {
                $this->size->setFormValue($val);
            }
        }

        // Check field name 'martialArtId' first before field var 'x_martialArtId'
        $val = $CurrentForm->hasValue("martialArtId") ? $CurrentForm->getValue("martialArtId") : $CurrentForm->getValue("x_martialArtId");
        if (!$this->martialArtId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->martialArtId->Visible = false; // Disable update for API request
            } else {
                $this->martialArtId->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		$this->background->OldUploadPath = "certificate/bgs";
		$this->background->UploadPath = $this->background->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->titlePosX->CurrentValue = $this->titlePosX->FormValue;
        $this->titlePosY->CurrentValue = $this->titlePosY->FormValue;
        $this->titleFont->CurrentValue = $this->titleFont->FormValue;
        $this->titleFontSize->CurrentValue = $this->titleFontSize->FormValue;
        $this->titleAlign->CurrentValue = $this->titleAlign->FormValue;
        $this->text01->CurrentValue = $this->text01->FormValue;
        $this->txt01PosX->CurrentValue = $this->txt01PosX->FormValue;
        $this->txt01PosY->CurrentValue = $this->txt01PosY->FormValue;
        $this->text02->CurrentValue = $this->text02->FormValue;
        $this->txt02PosX->CurrentValue = $this->txt02PosX->FormValue;
        $this->txt02PosY->CurrentValue = $this->txt02PosY->FormValue;
        $this->textFont->CurrentValue = $this->textFont->FormValue;
        $this->textSize->CurrentValue = $this->textSize->FormValue;
        $this->studentFont->CurrentValue = $this->studentFont->FormValue;
        $this->studentSize->CurrentValue = $this->studentSize->FormValue;
        $this->studentPosX->CurrentValue = $this->studentPosX->FormValue;
        $this->studentPosY->CurrentValue = $this->studentPosY->FormValue;
        $this->instructorFont->CurrentValue = $this->instructorFont->FormValue;
        $this->instructorSize->CurrentValue = $this->instructorSize->FormValue;
        $this->instructorPosX->CurrentValue = $this->instructorPosX->FormValue;
        $this->instructorPosY->CurrentValue = $this->instructorPosY->FormValue;
        $this->assistantPosX->CurrentValue = $this->assistantPosX->FormValue;
        $this->assistantPosY->CurrentValue = $this->assistantPosY->FormValue;
        $this->schoolId->CurrentValue = $this->schoolId->FormValue;
        $this->orientation->CurrentValue = $this->orientation->FormValue;
        $this->size->CurrentValue = $this->size->FormValue;
        $this->martialArtId->CurrentValue = $this->martialArtId->FormValue;
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

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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
        $this->id->RowCssClass = "row";

        // description
        $this->description->RowCssClass = "row";

        // background
        $this->background->RowCssClass = "row";

        // title
        $this->_title->RowCssClass = "row";

        // titlePosX
        $this->titlePosX->RowCssClass = "row";

        // titlePosY
        $this->titlePosY->RowCssClass = "row";

        // titleFont
        $this->titleFont->RowCssClass = "row";

        // titleFontSize
        $this->titleFontSize->RowCssClass = "row";

        // titleAlign
        $this->titleAlign->RowCssClass = "row";

        // text01
        $this->text01->RowCssClass = "row";

        // txt01PosX
        $this->txt01PosX->RowCssClass = "row";

        // txt01PosY
        $this->txt01PosY->RowCssClass = "row";

        // text02
        $this->text02->RowCssClass = "row";

        // txt02PosX
        $this->txt02PosX->RowCssClass = "row";

        // txt02PosY
        $this->txt02PosY->RowCssClass = "row";

        // textFont
        $this->textFont->RowCssClass = "row";

        // textSize
        $this->textSize->RowCssClass = "row";

        // studentFont
        $this->studentFont->RowCssClass = "row";

        // studentSize
        $this->studentSize->RowCssClass = "row";

        // studentPosX
        $this->studentPosX->RowCssClass = "row";

        // studentPosY
        $this->studentPosY->RowCssClass = "row";

        // instructorFont
        $this->instructorFont->RowCssClass = "row";

        // instructorSize
        $this->instructorSize->RowCssClass = "row";

        // instructorPosX
        $this->instructorPosX->RowCssClass = "row";

        // instructorPosY
        $this->instructorPosY->RowCssClass = "row";

        // assistantPosX
        $this->assistantPosX->RowCssClass = "row";

        // assistantPosY
        $this->assistantPosY->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // orientation
        $this->orientation->RowCssClass = "row";

        // size
        $this->size->RowCssClass = "row";

        // martialArtId
        $this->martialArtId->RowCssClass = "row";

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

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

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

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // titlePosX
            $this->titlePosX->LinkCustomAttributes = "";
            $this->titlePosX->HrefValue = "";

            // titlePosY
            $this->titlePosY->LinkCustomAttributes = "";
            $this->titlePosY->HrefValue = "";

            // titleFont
            $this->titleFont->LinkCustomAttributes = "";
            $this->titleFont->HrefValue = "";

            // titleFontSize
            $this->titleFontSize->LinkCustomAttributes = "";
            $this->titleFontSize->HrefValue = "";

            // titleAlign
            $this->titleAlign->LinkCustomAttributes = "";
            $this->titleAlign->HrefValue = "";

            // text01
            $this->text01->LinkCustomAttributes = "";
            $this->text01->HrefValue = "";

            // txt01PosX
            $this->txt01PosX->LinkCustomAttributes = "";
            $this->txt01PosX->HrefValue = "";

            // txt01PosY
            $this->txt01PosY->LinkCustomAttributes = "";
            $this->txt01PosY->HrefValue = "";

            // text02
            $this->text02->LinkCustomAttributes = "";
            $this->text02->HrefValue = "";

            // txt02PosX
            $this->txt02PosX->LinkCustomAttributes = "";
            $this->txt02PosX->HrefValue = "";

            // txt02PosY
            $this->txt02PosY->LinkCustomAttributes = "";
            $this->txt02PosY->HrefValue = "";

            // textFont
            $this->textFont->LinkCustomAttributes = "";
            $this->textFont->HrefValue = "";

            // textSize
            $this->textSize->LinkCustomAttributes = "";
            $this->textSize->HrefValue = "";

            // studentFont
            $this->studentFont->LinkCustomAttributes = "";
            $this->studentFont->HrefValue = "";

            // studentSize
            $this->studentSize->LinkCustomAttributes = "";
            $this->studentSize->HrefValue = "";

            // studentPosX
            $this->studentPosX->LinkCustomAttributes = "";
            $this->studentPosX->HrefValue = "";

            // studentPosY
            $this->studentPosY->LinkCustomAttributes = "";
            $this->studentPosY->HrefValue = "";

            // instructorFont
            $this->instructorFont->LinkCustomAttributes = "";
            $this->instructorFont->HrefValue = "";

            // instructorSize
            $this->instructorSize->LinkCustomAttributes = "";
            $this->instructorSize->HrefValue = "";

            // instructorPosX
            $this->instructorPosX->LinkCustomAttributes = "";
            $this->instructorPosX->HrefValue = "";

            // instructorPosY
            $this->instructorPosY->LinkCustomAttributes = "";
            $this->instructorPosY->HrefValue = "";

            // assistantPosX
            $this->assistantPosX->LinkCustomAttributes = "";
            $this->assistantPosX->HrefValue = "";

            // assistantPosY
            $this->assistantPosY->LinkCustomAttributes = "";
            $this->assistantPosY->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // orientation
            $this->orientation->LinkCustomAttributes = "";
            $this->orientation->HrefValue = "";

            // size
            $this->size->LinkCustomAttributes = "";
            $this->size->HrefValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            if (!$this->description->Raw) {
                $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
            }
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
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
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->background);
            }

            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // titlePosX
            $this->titlePosX->setupEditAttributes();
            $this->titlePosX->EditCustomAttributes = "";
            if (!$this->titlePosX->Raw) {
                $this->titlePosX->CurrentValue = HtmlDecode($this->titlePosX->CurrentValue);
            }
            $this->titlePosX->EditValue = HtmlEncode($this->titlePosX->CurrentValue);
            $this->titlePosX->PlaceHolder = RemoveHtml($this->titlePosX->caption());

            // titlePosY
            $this->titlePosY->setupEditAttributes();
            $this->titlePosY->EditCustomAttributes = "";
            if (!$this->titlePosY->Raw) {
                $this->titlePosY->CurrentValue = HtmlDecode($this->titlePosY->CurrentValue);
            }
            $this->titlePosY->EditValue = HtmlEncode($this->titlePosY->CurrentValue);
            $this->titlePosY->PlaceHolder = RemoveHtml($this->titlePosY->caption());

            // titleFont
            $this->titleFont->setupEditAttributes();
            $this->titleFont->EditCustomAttributes = "";
            if (!$this->titleFont->Raw) {
                $this->titleFont->CurrentValue = HtmlDecode($this->titleFont->CurrentValue);
            }
            $this->titleFont->EditValue = HtmlEncode($this->titleFont->CurrentValue);
            $this->titleFont->PlaceHolder = RemoveHtml($this->titleFont->caption());

            // titleFontSize
            $this->titleFontSize->setupEditAttributes();
            $this->titleFontSize->EditCustomAttributes = "";
            if (!$this->titleFontSize->Raw) {
                $this->titleFontSize->CurrentValue = HtmlDecode($this->titleFontSize->CurrentValue);
            }
            $this->titleFontSize->EditValue = HtmlEncode($this->titleFontSize->CurrentValue);
            $this->titleFontSize->PlaceHolder = RemoveHtml($this->titleFontSize->caption());

            // titleAlign
            $this->titleAlign->setupEditAttributes();
            $this->titleAlign->EditCustomAttributes = "";
            $this->titleAlign->EditValue = $this->titleAlign->options(true);
            $this->titleAlign->PlaceHolder = RemoveHtml($this->titleAlign->caption());

            // text01
            $this->text01->setupEditAttributes();
            $this->text01->EditCustomAttributes = "";
            $this->text01->EditValue = HtmlEncode($this->text01->CurrentValue);
            $this->text01->PlaceHolder = RemoveHtml($this->text01->caption());

            // txt01PosX
            $this->txt01PosX->setupEditAttributes();
            $this->txt01PosX->EditCustomAttributes = "";
            if (!$this->txt01PosX->Raw) {
                $this->txt01PosX->CurrentValue = HtmlDecode($this->txt01PosX->CurrentValue);
            }
            $this->txt01PosX->EditValue = HtmlEncode($this->txt01PosX->CurrentValue);
            $this->txt01PosX->PlaceHolder = RemoveHtml($this->txt01PosX->caption());

            // txt01PosY
            $this->txt01PosY->setupEditAttributes();
            $this->txt01PosY->EditCustomAttributes = "";
            if (!$this->txt01PosY->Raw) {
                $this->txt01PosY->CurrentValue = HtmlDecode($this->txt01PosY->CurrentValue);
            }
            $this->txt01PosY->EditValue = HtmlEncode($this->txt01PosY->CurrentValue);
            $this->txt01PosY->PlaceHolder = RemoveHtml($this->txt01PosY->caption());

            // text02
            $this->text02->setupEditAttributes();
            $this->text02->EditCustomAttributes = "";
            $this->text02->EditValue = HtmlEncode($this->text02->CurrentValue);
            $this->text02->PlaceHolder = RemoveHtml($this->text02->caption());

            // txt02PosX
            $this->txt02PosX->setupEditAttributes();
            $this->txt02PosX->EditCustomAttributes = "";
            if (!$this->txt02PosX->Raw) {
                $this->txt02PosX->CurrentValue = HtmlDecode($this->txt02PosX->CurrentValue);
            }
            $this->txt02PosX->EditValue = HtmlEncode($this->txt02PosX->CurrentValue);
            $this->txt02PosX->PlaceHolder = RemoveHtml($this->txt02PosX->caption());

            // txt02PosY
            $this->txt02PosY->setupEditAttributes();
            $this->txt02PosY->EditCustomAttributes = "";
            if (!$this->txt02PosY->Raw) {
                $this->txt02PosY->CurrentValue = HtmlDecode($this->txt02PosY->CurrentValue);
            }
            $this->txt02PosY->EditValue = HtmlEncode($this->txt02PosY->CurrentValue);
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
            $this->textSize->EditValue = HtmlEncode($this->textSize->CurrentValue);
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
            $this->studentSize->EditValue = HtmlEncode($this->studentSize->CurrentValue);
            $this->studentSize->PlaceHolder = RemoveHtml($this->studentSize->caption());

            // studentPosX
            $this->studentPosX->setupEditAttributes();
            $this->studentPosX->EditCustomAttributes = "";
            if (!$this->studentPosX->Raw) {
                $this->studentPosX->CurrentValue = HtmlDecode($this->studentPosX->CurrentValue);
            }
            $this->studentPosX->EditValue = HtmlEncode($this->studentPosX->CurrentValue);
            $this->studentPosX->PlaceHolder = RemoveHtml($this->studentPosX->caption());

            // studentPosY
            $this->studentPosY->setupEditAttributes();
            $this->studentPosY->EditCustomAttributes = "";
            if (!$this->studentPosY->Raw) {
                $this->studentPosY->CurrentValue = HtmlDecode($this->studentPosY->CurrentValue);
            }
            $this->studentPosY->EditValue = HtmlEncode($this->studentPosY->CurrentValue);
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
            $this->instructorSize->EditValue = HtmlEncode($this->instructorSize->CurrentValue);
            $this->instructorSize->PlaceHolder = RemoveHtml($this->instructorSize->caption());

            // instructorPosX
            $this->instructorPosX->setupEditAttributes();
            $this->instructorPosX->EditCustomAttributes = "";
            if (!$this->instructorPosX->Raw) {
                $this->instructorPosX->CurrentValue = HtmlDecode($this->instructorPosX->CurrentValue);
            }
            $this->instructorPosX->EditValue = HtmlEncode($this->instructorPosX->CurrentValue);
            $this->instructorPosX->PlaceHolder = RemoveHtml($this->instructorPosX->caption());

            // instructorPosY
            $this->instructorPosY->setupEditAttributes();
            $this->instructorPosY->EditCustomAttributes = "";
            if (!$this->instructorPosY->Raw) {
                $this->instructorPosY->CurrentValue = HtmlDecode($this->instructorPosY->CurrentValue);
            }
            $this->instructorPosY->EditValue = HtmlEncode($this->instructorPosY->CurrentValue);
            $this->instructorPosY->PlaceHolder = RemoveHtml($this->instructorPosY->caption());

            // assistantPosX
            $this->assistantPosX->setupEditAttributes();
            $this->assistantPosX->EditCustomAttributes = "";
            if (!$this->assistantPosX->Raw) {
                $this->assistantPosX->CurrentValue = HtmlDecode($this->assistantPosX->CurrentValue);
            }
            $this->assistantPosX->EditValue = HtmlEncode($this->assistantPosX->CurrentValue);
            $this->assistantPosX->PlaceHolder = RemoveHtml($this->assistantPosX->caption());

            // assistantPosY
            $this->assistantPosY->setupEditAttributes();
            $this->assistantPosY->EditCustomAttributes = "";
            if (!$this->assistantPosY->Raw) {
                $this->assistantPosY->CurrentValue = HtmlDecode($this->assistantPosY->CurrentValue);
            }
            $this->assistantPosY->EditValue = HtmlEncode($this->assistantPosY->CurrentValue);
            $this->assistantPosY->PlaceHolder = RemoveHtml($this->assistantPosY->caption());

            // schoolId
            $this->schoolId->EditCustomAttributes = "";
            $curVal = trim(strval($this->schoolId->CurrentValue));
            if ($curVal != "") {
                $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
            } else {
                $this->schoolId->ViewValue = $this->schoolId->Lookup !== null && is_array($this->schoolId->lookupOptions()) ? $curVal : null;
            }
            if ($this->schoolId->ViewValue !== null) { // Load from cache
                $this->schoolId->EditValue = array_values($this->schoolId->lookupOptions());
                if ($this->schoolId->ViewValue == "") {
                    $this->schoolId->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->schoolId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->schoolId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                    $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                } else {
                    $this->schoolId->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->schoolId->Lookup->renderViewRow($row);
                }
                $this->schoolId->EditValue = $arwrk;
            }
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
            $curVal = trim(strval($this->martialArtId->CurrentValue));
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
            } else {
                $this->martialArtId->ViewValue = $this->martialArtId->Lookup !== null && is_array($this->martialArtId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialArtId->ViewValue !== null) { // Load from cache
                $this->martialArtId->EditValue = array_values($this->martialArtId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialArtId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialArtId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialArtId->EditValue = $arwrk;
            }
            $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

            // Add refer script

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

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

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // titlePosX
            $this->titlePosX->LinkCustomAttributes = "";
            $this->titlePosX->HrefValue = "";

            // titlePosY
            $this->titlePosY->LinkCustomAttributes = "";
            $this->titlePosY->HrefValue = "";

            // titleFont
            $this->titleFont->LinkCustomAttributes = "";
            $this->titleFont->HrefValue = "";

            // titleFontSize
            $this->titleFontSize->LinkCustomAttributes = "";
            $this->titleFontSize->HrefValue = "";

            // titleAlign
            $this->titleAlign->LinkCustomAttributes = "";
            $this->titleAlign->HrefValue = "";

            // text01
            $this->text01->LinkCustomAttributes = "";
            $this->text01->HrefValue = "";

            // txt01PosX
            $this->txt01PosX->LinkCustomAttributes = "";
            $this->txt01PosX->HrefValue = "";

            // txt01PosY
            $this->txt01PosY->LinkCustomAttributes = "";
            $this->txt01PosY->HrefValue = "";

            // text02
            $this->text02->LinkCustomAttributes = "";
            $this->text02->HrefValue = "";

            // txt02PosX
            $this->txt02PosX->LinkCustomAttributes = "";
            $this->txt02PosX->HrefValue = "";

            // txt02PosY
            $this->txt02PosY->LinkCustomAttributes = "";
            $this->txt02PosY->HrefValue = "";

            // textFont
            $this->textFont->LinkCustomAttributes = "";
            $this->textFont->HrefValue = "";

            // textSize
            $this->textSize->LinkCustomAttributes = "";
            $this->textSize->HrefValue = "";

            // studentFont
            $this->studentFont->LinkCustomAttributes = "";
            $this->studentFont->HrefValue = "";

            // studentSize
            $this->studentSize->LinkCustomAttributes = "";
            $this->studentSize->HrefValue = "";

            // studentPosX
            $this->studentPosX->LinkCustomAttributes = "";
            $this->studentPosX->HrefValue = "";

            // studentPosY
            $this->studentPosY->LinkCustomAttributes = "";
            $this->studentPosY->HrefValue = "";

            // instructorFont
            $this->instructorFont->LinkCustomAttributes = "";
            $this->instructorFont->HrefValue = "";

            // instructorSize
            $this->instructorSize->LinkCustomAttributes = "";
            $this->instructorSize->HrefValue = "";

            // instructorPosX
            $this->instructorPosX->LinkCustomAttributes = "";
            $this->instructorPosX->HrefValue = "";

            // instructorPosY
            $this->instructorPosY->LinkCustomAttributes = "";
            $this->instructorPosY->HrefValue = "";

            // assistantPosX
            $this->assistantPosX->LinkCustomAttributes = "";
            $this->assistantPosX->HrefValue = "";

            // assistantPosY
            $this->assistantPosY->LinkCustomAttributes = "";
            $this->assistantPosY->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // orientation
            $this->orientation->LinkCustomAttributes = "";
            $this->orientation->HrefValue = "";

            // size
            $this->size->LinkCustomAttributes = "";
            $this->size->HrefValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->background->Required) {
            if ($this->background->Upload->FileName == "" && !$this->background->Upload->KeepFile) {
                $this->background->addErrorMessage(str_replace("%s", $this->background->caption(), $this->background->RequiredErrorMessage));
            }
        }
        if ($this->_title->Required) {
            if (!$this->_title->IsDetailKey && EmptyValue($this->_title->FormValue)) {
                $this->_title->addErrorMessage(str_replace("%s", $this->_title->caption(), $this->_title->RequiredErrorMessage));
            }
        }
        if ($this->titlePosX->Required) {
            if (!$this->titlePosX->IsDetailKey && EmptyValue($this->titlePosX->FormValue)) {
                $this->titlePosX->addErrorMessage(str_replace("%s", $this->titlePosX->caption(), $this->titlePosX->RequiredErrorMessage));
            }
        }
        if ($this->titlePosY->Required) {
            if (!$this->titlePosY->IsDetailKey && EmptyValue($this->titlePosY->FormValue)) {
                $this->titlePosY->addErrorMessage(str_replace("%s", $this->titlePosY->caption(), $this->titlePosY->RequiredErrorMessage));
            }
        }
        if ($this->titleFont->Required) {
            if (!$this->titleFont->IsDetailKey && EmptyValue($this->titleFont->FormValue)) {
                $this->titleFont->addErrorMessage(str_replace("%s", $this->titleFont->caption(), $this->titleFont->RequiredErrorMessage));
            }
        }
        if ($this->titleFontSize->Required) {
            if (!$this->titleFontSize->IsDetailKey && EmptyValue($this->titleFontSize->FormValue)) {
                $this->titleFontSize->addErrorMessage(str_replace("%s", $this->titleFontSize->caption(), $this->titleFontSize->RequiredErrorMessage));
            }
        }
        if ($this->titleAlign->Required) {
            if (!$this->titleAlign->IsDetailKey && EmptyValue($this->titleAlign->FormValue)) {
                $this->titleAlign->addErrorMessage(str_replace("%s", $this->titleAlign->caption(), $this->titleAlign->RequiredErrorMessage));
            }
        }
        if ($this->text01->Required) {
            if (!$this->text01->IsDetailKey && EmptyValue($this->text01->FormValue)) {
                $this->text01->addErrorMessage(str_replace("%s", $this->text01->caption(), $this->text01->RequiredErrorMessage));
            }
        }
        if ($this->txt01PosX->Required) {
            if (!$this->txt01PosX->IsDetailKey && EmptyValue($this->txt01PosX->FormValue)) {
                $this->txt01PosX->addErrorMessage(str_replace("%s", $this->txt01PosX->caption(), $this->txt01PosX->RequiredErrorMessage));
            }
        }
        if ($this->txt01PosY->Required) {
            if (!$this->txt01PosY->IsDetailKey && EmptyValue($this->txt01PosY->FormValue)) {
                $this->txt01PosY->addErrorMessage(str_replace("%s", $this->txt01PosY->caption(), $this->txt01PosY->RequiredErrorMessage));
            }
        }
        if ($this->text02->Required) {
            if (!$this->text02->IsDetailKey && EmptyValue($this->text02->FormValue)) {
                $this->text02->addErrorMessage(str_replace("%s", $this->text02->caption(), $this->text02->RequiredErrorMessage));
            }
        }
        if ($this->txt02PosX->Required) {
            if (!$this->txt02PosX->IsDetailKey && EmptyValue($this->txt02PosX->FormValue)) {
                $this->txt02PosX->addErrorMessage(str_replace("%s", $this->txt02PosX->caption(), $this->txt02PosX->RequiredErrorMessage));
            }
        }
        if ($this->txt02PosY->Required) {
            if (!$this->txt02PosY->IsDetailKey && EmptyValue($this->txt02PosY->FormValue)) {
                $this->txt02PosY->addErrorMessage(str_replace("%s", $this->txt02PosY->caption(), $this->txt02PosY->RequiredErrorMessage));
            }
        }
        if ($this->textFont->Required) {
            if (!$this->textFont->IsDetailKey && EmptyValue($this->textFont->FormValue)) {
                $this->textFont->addErrorMessage(str_replace("%s", $this->textFont->caption(), $this->textFont->RequiredErrorMessage));
            }
        }
        if ($this->textSize->Required) {
            if (!$this->textSize->IsDetailKey && EmptyValue($this->textSize->FormValue)) {
                $this->textSize->addErrorMessage(str_replace("%s", $this->textSize->caption(), $this->textSize->RequiredErrorMessage));
            }
        }
        if ($this->studentFont->Required) {
            if (!$this->studentFont->IsDetailKey && EmptyValue($this->studentFont->FormValue)) {
                $this->studentFont->addErrorMessage(str_replace("%s", $this->studentFont->caption(), $this->studentFont->RequiredErrorMessage));
            }
        }
        if ($this->studentSize->Required) {
            if (!$this->studentSize->IsDetailKey && EmptyValue($this->studentSize->FormValue)) {
                $this->studentSize->addErrorMessage(str_replace("%s", $this->studentSize->caption(), $this->studentSize->RequiredErrorMessage));
            }
        }
        if ($this->studentPosX->Required) {
            if (!$this->studentPosX->IsDetailKey && EmptyValue($this->studentPosX->FormValue)) {
                $this->studentPosX->addErrorMessage(str_replace("%s", $this->studentPosX->caption(), $this->studentPosX->RequiredErrorMessage));
            }
        }
        if ($this->studentPosY->Required) {
            if (!$this->studentPosY->IsDetailKey && EmptyValue($this->studentPosY->FormValue)) {
                $this->studentPosY->addErrorMessage(str_replace("%s", $this->studentPosY->caption(), $this->studentPosY->RequiredErrorMessage));
            }
        }
        if ($this->instructorFont->Required) {
            if (!$this->instructorFont->IsDetailKey && EmptyValue($this->instructorFont->FormValue)) {
                $this->instructorFont->addErrorMessage(str_replace("%s", $this->instructorFont->caption(), $this->instructorFont->RequiredErrorMessage));
            }
        }
        if ($this->instructorSize->Required) {
            if (!$this->instructorSize->IsDetailKey && EmptyValue($this->instructorSize->FormValue)) {
                $this->instructorSize->addErrorMessage(str_replace("%s", $this->instructorSize->caption(), $this->instructorSize->RequiredErrorMessage));
            }
        }
        if ($this->instructorPosX->Required) {
            if (!$this->instructorPosX->IsDetailKey && EmptyValue($this->instructorPosX->FormValue)) {
                $this->instructorPosX->addErrorMessage(str_replace("%s", $this->instructorPosX->caption(), $this->instructorPosX->RequiredErrorMessage));
            }
        }
        if ($this->instructorPosY->Required) {
            if (!$this->instructorPosY->IsDetailKey && EmptyValue($this->instructorPosY->FormValue)) {
                $this->instructorPosY->addErrorMessage(str_replace("%s", $this->instructorPosY->caption(), $this->instructorPosY->RequiredErrorMessage));
            }
        }
        if ($this->assistantPosX->Required) {
            if (!$this->assistantPosX->IsDetailKey && EmptyValue($this->assistantPosX->FormValue)) {
                $this->assistantPosX->addErrorMessage(str_replace("%s", $this->assistantPosX->caption(), $this->assistantPosX->RequiredErrorMessage));
            }
        }
        if ($this->assistantPosY->Required) {
            if (!$this->assistantPosY->IsDetailKey && EmptyValue($this->assistantPosY->FormValue)) {
                $this->assistantPosY->addErrorMessage(str_replace("%s", $this->assistantPosY->caption(), $this->assistantPosY->RequiredErrorMessage));
            }
        }
        if ($this->schoolId->Required) {
            if (!$this->schoolId->IsDetailKey && EmptyValue($this->schoolId->FormValue)) {
                $this->schoolId->addErrorMessage(str_replace("%s", $this->schoolId->caption(), $this->schoolId->RequiredErrorMessage));
            }
        }
        if ($this->orientation->Required) {
            if ($this->orientation->FormValue == "") {
                $this->orientation->addErrorMessage(str_replace("%s", $this->orientation->caption(), $this->orientation->RequiredErrorMessage));
            }
        }
        if ($this->size->Required) {
            if (!$this->size->IsDetailKey && EmptyValue($this->size->FormValue)) {
                $this->size->addErrorMessage(str_replace("%s", $this->size->caption(), $this->size->RequiredErrorMessage));
            }
        }
        if ($this->martialArtId->Required) {
            if (!$this->martialArtId->IsDetailKey && EmptyValue($this->martialArtId->FormValue)) {
                $this->martialArtId->addErrorMessage(str_replace("%s", $this->martialArtId->caption(), $this->martialArtId->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set new row
        $rsnew = [];

        // description
        $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, null, false);

        // background
        if ($this->background->Visible && !$this->background->Upload->KeepFile) {
            $this->background->Upload->DbValue = ""; // No need to delete old file
            if ($this->background->Upload->FileName == "") {
                $rsnew['background'] = null;
            } else {
                $rsnew['background'] = $this->background->Upload->FileName;
            }
        }

        // title
        $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, null, false);

        // titlePosX
        $this->titlePosX->setDbValueDef($rsnew, $this->titlePosX->CurrentValue, null, false);

        // titlePosY
        $this->titlePosY->setDbValueDef($rsnew, $this->titlePosY->CurrentValue, null, false);

        // titleFont
        $this->titleFont->setDbValueDef($rsnew, $this->titleFont->CurrentValue, null, false);

        // titleFontSize
        $this->titleFontSize->setDbValueDef($rsnew, $this->titleFontSize->CurrentValue, null, false);

        // titleAlign
        $this->titleAlign->setDbValueDef($rsnew, $this->titleAlign->CurrentValue, null, false);

        // text01
        $this->text01->setDbValueDef($rsnew, $this->text01->CurrentValue, null, false);

        // txt01PosX
        $this->txt01PosX->setDbValueDef($rsnew, $this->txt01PosX->CurrentValue, null, false);

        // txt01PosY
        $this->txt01PosY->setDbValueDef($rsnew, $this->txt01PosY->CurrentValue, null, false);

        // text02
        $this->text02->setDbValueDef($rsnew, $this->text02->CurrentValue, null, false);

        // txt02PosX
        $this->txt02PosX->setDbValueDef($rsnew, $this->txt02PosX->CurrentValue, null, false);

        // txt02PosY
        $this->txt02PosY->setDbValueDef($rsnew, $this->txt02PosY->CurrentValue, null, false);

        // textFont
        $this->textFont->setDbValueDef($rsnew, $this->textFont->CurrentValue, null, false);

        // textSize
        $this->textSize->setDbValueDef($rsnew, $this->textSize->CurrentValue, null, false);

        // studentFont
        $this->studentFont->setDbValueDef($rsnew, $this->studentFont->CurrentValue, null, false);

        // studentSize
        $this->studentSize->setDbValueDef($rsnew, $this->studentSize->CurrentValue, null, false);

        // studentPosX
        $this->studentPosX->setDbValueDef($rsnew, $this->studentPosX->CurrentValue, null, false);

        // studentPosY
        $this->studentPosY->setDbValueDef($rsnew, $this->studentPosY->CurrentValue, null, false);

        // instructorFont
        $this->instructorFont->setDbValueDef($rsnew, $this->instructorFont->CurrentValue, null, false);

        // instructorSize
        $this->instructorSize->setDbValueDef($rsnew, $this->instructorSize->CurrentValue, null, false);

        // instructorPosX
        $this->instructorPosX->setDbValueDef($rsnew, $this->instructorPosX->CurrentValue, null, false);

        // instructorPosY
        $this->instructorPosY->setDbValueDef($rsnew, $this->instructorPosY->CurrentValue, null, false);

        // assistantPosX
        $this->assistantPosX->setDbValueDef($rsnew, $this->assistantPosX->CurrentValue, null, false);

        // assistantPosY
        $this->assistantPosY->setDbValueDef($rsnew, $this->assistantPosY->CurrentValue, null, false);

        // schoolId
        $this->schoolId->setDbValueDef($rsnew, $this->schoolId->CurrentValue, null, false);

        // orientation
        $this->orientation->setDbValueDef($rsnew, $this->orientation->CurrentValue, null, false);

        // size
        $this->size->setDbValueDef($rsnew, $this->size->CurrentValue, null, false);

        // martialArtId
        $this->martialArtId->setDbValueDef($rsnew, $this->martialArtId->CurrentValue, null, false);
        if ($this->background->Visible && !$this->background->Upload->KeepFile) {
            $this->background->UploadPath = "certificate/bgs";
            $oldFiles = EmptyValue($this->background->Upload->DbValue) ? [] : [$this->background->htmlDecode($this->background->Upload->DbValue)];
            if (!EmptyValue($this->background->Upload->FileName)) {
                $newFiles = [$this->background->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->background, $this->background->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->background->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->background->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->background->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->background->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->background->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->background->setDbValueDef($rsnew, $this->background->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);
        $this->background->OldUploadPath = "certificate/bgs";
        $this->background->UploadPath = $this->background->OldUploadPath;

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->background->Visible && !$this->background->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->background->Upload->DbValue) ? [] : [$this->background->htmlDecode($this->background->Upload->DbValue)];
                    if (!EmptyValue($this->background->Upload->FileName)) {
                        $newFiles = [$this->background->Upload->FileName];
                        $newFiles2 = [$this->background->htmlDecode($rsnew['background'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->background, $this->background->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->background->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->background->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // background
            CleanUploadTempPath($this->background, $this->background->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TesCertificateList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
