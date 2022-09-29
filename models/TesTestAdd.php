<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesTestAdd extends TesTest
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_test';

    // Page object name
    public $PageObjName = "TesTestAdd";

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

        // Table object (tes_test)
        if (!isset($GLOBALS["tes_test"]) || get_class($GLOBALS["tes_test"]) == PROJECT_NAMESPACE . "tes_test") {
            $GLOBALS["tes_test"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_test');
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
                $tbl = Container("tes_test");
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
                    if ($pageName == "TesTestView") {
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
    public $DetailPages; // Detail pages object

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
        $this->testCity->setVisibility();
        $this->federationId->Visible = false;
        $this->martialartsId->setVisibility();
        $this->schoolId->Visible = false;
        $this->instructorId->setVisibility();
        $this->auxiliarInstructorId->setVisibility();
        $this->testDate->setVisibility();
        $this->testTime->setVisibility();
        $this->ceremonyDate->setVisibility();
        $this->testTypeId->setVisibility();
        $this->testStatusId->Visible = false;
        $this->createUserId->Visible = false;
        $this->createDate->Visible = false;
        $this->judgeId->setVisibility();
        $this->certificateId->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->testCity);
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->martialartsId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->instructorId);
        $this->setupLookupOptions($this->auxiliarInstructorId);
        $this->setupLookupOptions($this->testTypeId);
        $this->setupLookupOptions($this->testStatusId);
        $this->setupLookupOptions($this->createUserId);
        $this->setupLookupOptions($this->judgeId);
        $this->setupLookupOptions($this->certificateId);

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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("TesTestList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "TesTestList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "TesTestView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->testTypeId->DefaultValue = 0;
        $this->testTypeId->OldValue = $this->testTypeId->DefaultValue;
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

        // Check field name 'testCity' first before field var 'x_testCity'
        $val = $CurrentForm->hasValue("testCity") ? $CurrentForm->getValue("testCity") : $CurrentForm->getValue("x_testCity");
        if (!$this->testCity->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testCity->Visible = false; // Disable update for API request
            } else {
                $this->testCity->setFormValue($val);
            }
        }

        // Check field name 'martialartsId' first before field var 'x_martialartsId'
        $val = $CurrentForm->hasValue("martialartsId") ? $CurrentForm->getValue("martialartsId") : $CurrentForm->getValue("x_martialartsId");
        if (!$this->martialartsId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->martialartsId->Visible = false; // Disable update for API request
            } else {
                $this->martialartsId->setFormValue($val);
            }
        }

        // Check field name 'instructorId' first before field var 'x_instructorId'
        $val = $CurrentForm->hasValue("instructorId") ? $CurrentForm->getValue("instructorId") : $CurrentForm->getValue("x_instructorId");
        if (!$this->instructorId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorId->Visible = false; // Disable update for API request
            } else {
                $this->instructorId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'auxiliarInstructorId' first before field var 'x_auxiliarInstructorId'
        $val = $CurrentForm->hasValue("auxiliarInstructorId") ? $CurrentForm->getValue("auxiliarInstructorId") : $CurrentForm->getValue("x_auxiliarInstructorId");
        if (!$this->auxiliarInstructorId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->auxiliarInstructorId->Visible = false; // Disable update for API request
            } else {
                $this->auxiliarInstructorId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'testDate' first before field var 'x_testDate'
        $val = $CurrentForm->hasValue("testDate") ? $CurrentForm->getValue("testDate") : $CurrentForm->getValue("x_testDate");
        if (!$this->testDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testDate->Visible = false; // Disable update for API request
            } else {
                $this->testDate->setFormValue($val, true, $validate);
            }
            $this->testDate->CurrentValue = UnFormatDateTime($this->testDate->CurrentValue, $this->testDate->formatPattern());
        }

        // Check field name 'testTime' first before field var 'x_testTime'
        $val = $CurrentForm->hasValue("testTime") ? $CurrentForm->getValue("testTime") : $CurrentForm->getValue("x_testTime");
        if (!$this->testTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testTime->Visible = false; // Disable update for API request
            } else {
                $this->testTime->setFormValue($val, true, $validate);
            }
            $this->testTime->CurrentValue = UnFormatDateTime($this->testTime->CurrentValue, $this->testTime->formatPattern());
        }

        // Check field name 'ceremonyDate' first before field var 'x_ceremonyDate'
        $val = $CurrentForm->hasValue("ceremonyDate") ? $CurrentForm->getValue("ceremonyDate") : $CurrentForm->getValue("x_ceremonyDate");
        if (!$this->ceremonyDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ceremonyDate->Visible = false; // Disable update for API request
            } else {
                $this->ceremonyDate->setFormValue($val, true, $validate);
            }
            $this->ceremonyDate->CurrentValue = UnFormatDateTime($this->ceremonyDate->CurrentValue, $this->ceremonyDate->formatPattern());
        }

        // Check field name 'testTypeId' first before field var 'x_testTypeId'
        $val = $CurrentForm->hasValue("testTypeId") ? $CurrentForm->getValue("testTypeId") : $CurrentForm->getValue("x_testTypeId");
        if (!$this->testTypeId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testTypeId->Visible = false; // Disable update for API request
            } else {
                $this->testTypeId->setFormValue($val);
            }
        }

        // Check field name 'judgeId' first before field var 'x_judgeId'
        $val = $CurrentForm->hasValue("judgeId") ? $CurrentForm->getValue("judgeId") : $CurrentForm->getValue("x_judgeId");
        if (!$this->judgeId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->judgeId->Visible = false; // Disable update for API request
            } else {
                $this->judgeId->setFormValue($val);
            }
        }

        // Check field name 'certificateId' first before field var 'x_certificateId'
        $val = $CurrentForm->hasValue("certificateId") ? $CurrentForm->getValue("certificateId") : $CurrentForm->getValue("x_certificateId");
        if (!$this->certificateId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->certificateId->Visible = false; // Disable update for API request
            } else {
                $this->certificateId->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->testCity->CurrentValue = $this->testCity->FormValue;
        $this->martialartsId->CurrentValue = $this->martialartsId->FormValue;
        $this->instructorId->CurrentValue = $this->instructorId->FormValue;
        $this->auxiliarInstructorId->CurrentValue = $this->auxiliarInstructorId->FormValue;
        $this->testDate->CurrentValue = $this->testDate->FormValue;
        $this->testDate->CurrentValue = UnFormatDateTime($this->testDate->CurrentValue, $this->testDate->formatPattern());
        $this->testTime->CurrentValue = $this->testTime->FormValue;
        $this->testTime->CurrentValue = UnFormatDateTime($this->testTime->CurrentValue, $this->testTime->formatPattern());
        $this->ceremonyDate->CurrentValue = $this->ceremonyDate->FormValue;
        $this->ceremonyDate->CurrentValue = UnFormatDateTime($this->ceremonyDate->CurrentValue, $this->ceremonyDate->formatPattern());
        $this->testTypeId->CurrentValue = $this->testTypeId->FormValue;
        $this->judgeId->CurrentValue = $this->judgeId->FormValue;
        $this->certificateId->CurrentValue = $this->certificateId->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->testCity->setDbValue($row['testCity']);
        if (array_key_exists('EV__testCity', $row)) {
            $this->testCity->VirtualValue = $row['EV__testCity']; // Set up virtual field value
        } else {
            $this->testCity->VirtualValue = ""; // Clear value
        }
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
        if (array_key_exists('EV__certificateId', $row)) {
            $this->certificateId->VirtualValue = $row['EV__certificateId']; // Set up virtual field value
        } else {
            $this->certificateId->VirtualValue = ""; // Clear value
        }
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['description'] = $this->description->DefaultValue;
        $row['testCity'] = $this->testCity->DefaultValue;
        $row['federationId'] = $this->federationId->DefaultValue;
        $row['martialartsId'] = $this->martialartsId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['instructorId'] = $this->instructorId->DefaultValue;
        $row['auxiliarInstructorId'] = $this->auxiliarInstructorId->DefaultValue;
        $row['testDate'] = $this->testDate->DefaultValue;
        $row['testTime'] = $this->testTime->DefaultValue;
        $row['ceremonyDate'] = $this->ceremonyDate->DefaultValue;
        $row['testTypeId'] = $this->testTypeId->DefaultValue;
        $row['testStatusId'] = $this->testStatusId->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['judgeId'] = $this->judgeId->DefaultValue;
        $row['certificateId'] = $this->certificateId->DefaultValue;
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

        // testCity
        $this->testCity->RowCssClass = "row";

        // federationId
        $this->federationId->RowCssClass = "row";

        // martialartsId
        $this->martialartsId->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // instructorId
        $this->instructorId->RowCssClass = "row";

        // auxiliarInstructorId
        $this->auxiliarInstructorId->RowCssClass = "row";

        // testDate
        $this->testDate->RowCssClass = "row";

        // testTime
        $this->testTime->RowCssClass = "row";

        // ceremonyDate
        $this->ceremonyDate->RowCssClass = "row";

        // testTypeId
        $this->testTypeId->RowCssClass = "row";

        // testStatusId
        $this->testStatusId->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // judgeId
        $this->judgeId->RowCssClass = "row";

        // certificateId
        $this->certificateId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // testCity
            $this->testCity->LinkCustomAttributes = "";
            $this->testCity->HrefValue = "";

            // martialartsId
            $this->martialartsId->LinkCustomAttributes = "";
            $this->martialartsId->HrefValue = "";

            // instructorId
            $this->instructorId->LinkCustomAttributes = "";
            $this->instructorId->HrefValue = "";

            // auxiliarInstructorId
            $this->auxiliarInstructorId->LinkCustomAttributes = "";
            $this->auxiliarInstructorId->HrefValue = "";

            // testDate
            $this->testDate->LinkCustomAttributes = "";
            $this->testDate->HrefValue = "";

            // testTime
            $this->testTime->LinkCustomAttributes = "";
            $this->testTime->HrefValue = "";

            // ceremonyDate
            $this->ceremonyDate->LinkCustomAttributes = "";
            $this->ceremonyDate->HrefValue = "";

            // testTypeId
            $this->testTypeId->LinkCustomAttributes = "";
            $this->testTypeId->HrefValue = "";

            // judgeId
            $this->judgeId->LinkCustomAttributes = "";
            $this->judgeId->HrefValue = "";

            // certificateId
            $this->certificateId->LinkCustomAttributes = "";
            $this->certificateId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // testCity
            $this->testCity->EditCustomAttributes = "";
            $curVal = trim(strval($this->testCity->CurrentValue));
            if ($curVal != "") {
                $this->testCity->ViewValue = $this->testCity->lookupCacheOption($curVal);
            } else {
                $this->testCity->ViewValue = $this->testCity->Lookup !== null && is_array($this->testCity->lookupOptions()) ? $curVal : null;
            }
            if ($this->testCity->ViewValue !== null) { // Load from cache
                $this->testCity->EditValue = array_values($this->testCity->lookupOptions());
                if ($this->testCity->ViewValue == "") {
                    $this->testCity->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->testCity->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->testCity->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->testCity->Lookup->renderViewRow($rswrk[0]);
                    $this->testCity->ViewValue = $this->testCity->displayValue($arwrk);
                } else {
                    $this->testCity->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->testCity->EditValue = $arwrk;
            }
            $this->testCity->PlaceHolder = RemoveHtml($this->testCity->caption());

            // martialartsId
            $this->martialartsId->setupEditAttributes();
            $this->martialartsId->EditCustomAttributes = "";
            $curVal = trim(strval($this->martialartsId->CurrentValue));
            if ($curVal != "") {
                $this->martialartsId->ViewValue = $this->martialartsId->lookupCacheOption($curVal);
            } else {
                $this->martialartsId->ViewValue = $this->martialartsId->Lookup !== null && is_array($this->martialartsId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialartsId->ViewValue !== null) { // Load from cache
                $this->martialartsId->EditValue = array_values($this->martialartsId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialartsId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialartsId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialartsId->EditValue = $arwrk;
            }
            $this->martialartsId->PlaceHolder = RemoveHtml($this->martialartsId->caption());

            // instructorId
            $this->instructorId->setupEditAttributes();
            $this->instructorId->EditCustomAttributes = "";
            $this->instructorId->EditValue = HtmlEncode($this->instructorId->CurrentValue);
            $curVal = strval($this->instructorId->CurrentValue);
            if ($curVal != "") {
                $this->instructorId->EditValue = $this->instructorId->lookupCacheOption($curVal);
                if ($this->instructorId->EditValue === null) { // Lookup from database
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
                        $this->instructorId->EditValue = $this->instructorId->displayValue($arwrk);
                    } else {
                        $this->instructorId->EditValue = HtmlEncode(FormatNumber($this->instructorId->CurrentValue, $this->instructorId->formatPattern()));
                    }
                }
            } else {
                $this->instructorId->EditValue = null;
            }
            $this->instructorId->PlaceHolder = RemoveHtml($this->instructorId->caption());

            // auxiliarInstructorId
            $this->auxiliarInstructorId->setupEditAttributes();
            $this->auxiliarInstructorId->EditCustomAttributes = "";
            $this->auxiliarInstructorId->EditValue = HtmlEncode($this->auxiliarInstructorId->CurrentValue);
            $curVal = strval($this->auxiliarInstructorId->CurrentValue);
            if ($curVal != "") {
                $this->auxiliarInstructorId->EditValue = $this->auxiliarInstructorId->lookupCacheOption($curVal);
                if ($this->auxiliarInstructorId->EditValue === null) { // Lookup from database
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
                        $this->auxiliarInstructorId->EditValue = $this->auxiliarInstructorId->displayValue($arwrk);
                    } else {
                        $this->auxiliarInstructorId->EditValue = HtmlEncode(FormatNumber($this->auxiliarInstructorId->CurrentValue, $this->auxiliarInstructorId->formatPattern()));
                    }
                }
            } else {
                $this->auxiliarInstructorId->EditValue = null;
            }
            $this->auxiliarInstructorId->PlaceHolder = RemoveHtml($this->auxiliarInstructorId->caption());

            // testDate
            $this->testDate->setupEditAttributes();
            $this->testDate->EditCustomAttributes = "";
            $this->testDate->EditValue = HtmlEncode(FormatDateTime($this->testDate->CurrentValue, $this->testDate->formatPattern()));
            $this->testDate->PlaceHolder = RemoveHtml($this->testDate->caption());

            // testTime
            $this->testTime->setupEditAttributes();
            $this->testTime->EditCustomAttributes = "";
            $this->testTime->EditValue = HtmlEncode(FormatDateTime($this->testTime->CurrentValue, $this->testTime->formatPattern()));
            $this->testTime->PlaceHolder = RemoveHtml($this->testTime->caption());

            // ceremonyDate
            $this->ceremonyDate->setupEditAttributes();
            $this->ceremonyDate->EditCustomAttributes = "";
            $this->ceremonyDate->EditValue = HtmlEncode(FormatDateTime($this->ceremonyDate->CurrentValue, $this->ceremonyDate->formatPattern()));
            $this->ceremonyDate->PlaceHolder = RemoveHtml($this->ceremonyDate->caption());

            // testTypeId
            $this->testTypeId->setupEditAttributes();
            $this->testTypeId->EditCustomAttributes = "";
            $this->testTypeId->EditValue = $this->testTypeId->options(true);
            $this->testTypeId->PlaceHolder = RemoveHtml($this->testTypeId->caption());

            // judgeId
            $this->judgeId->EditCustomAttributes = "";
            $curVal = trim(strval($this->judgeId->CurrentValue));
            if ($curVal != "") {
                $this->judgeId->ViewValue = $this->judgeId->lookupCacheOption($curVal);
            } else {
                $this->judgeId->ViewValue = $this->judgeId->Lookup !== null && is_array($this->judgeId->lookupOptions()) ? $curVal : null;
            }
            if ($this->judgeId->ViewValue !== null) { // Load from cache
                $this->judgeId->EditValue = array_values($this->judgeId->lookupOptions());
                if ($this->judgeId->ViewValue == "") {
                    $this->judgeId->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->judgeId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->judgeId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->judgeId->Lookup->renderViewRow($rswrk[0]);
                    $this->judgeId->ViewValue = $this->judgeId->displayValue($arwrk);
                } else {
                    $this->judgeId->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->judgeId->EditValue = $arwrk;
            }
            $this->judgeId->PlaceHolder = RemoveHtml($this->judgeId->caption());

            // certificateId
            $this->certificateId->setupEditAttributes();
            $this->certificateId->EditCustomAttributes = "";
            $curVal = trim(strval($this->certificateId->CurrentValue));
            if ($curVal != "") {
                $this->certificateId->ViewValue = $this->certificateId->lookupCacheOption($curVal);
            } else {
                $this->certificateId->ViewValue = $this->certificateId->Lookup !== null && is_array($this->certificateId->lookupOptions()) ? $curVal : null;
            }
            if ($this->certificateId->ViewValue !== null) { // Load from cache
                $this->certificateId->EditValue = array_values($this->certificateId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->certificateId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->certificateId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->certificateId->EditValue = $arwrk;
            }
            $this->certificateId->PlaceHolder = RemoveHtml($this->certificateId->caption());

            // Add refer script

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // testCity
            $this->testCity->LinkCustomAttributes = "";
            $this->testCity->HrefValue = "";

            // martialartsId
            $this->martialartsId->LinkCustomAttributes = "";
            $this->martialartsId->HrefValue = "";

            // instructorId
            $this->instructorId->LinkCustomAttributes = "";
            $this->instructorId->HrefValue = "";

            // auxiliarInstructorId
            $this->auxiliarInstructorId->LinkCustomAttributes = "";
            $this->auxiliarInstructorId->HrefValue = "";

            // testDate
            $this->testDate->LinkCustomAttributes = "";
            $this->testDate->HrefValue = "";

            // testTime
            $this->testTime->LinkCustomAttributes = "";
            $this->testTime->HrefValue = "";

            // ceremonyDate
            $this->ceremonyDate->LinkCustomAttributes = "";
            $this->ceremonyDate->HrefValue = "";

            // testTypeId
            $this->testTypeId->LinkCustomAttributes = "";
            $this->testTypeId->HrefValue = "";

            // judgeId
            $this->judgeId->LinkCustomAttributes = "";
            $this->judgeId->HrefValue = "";

            // certificateId
            $this->certificateId->LinkCustomAttributes = "";
            $this->certificateId->HrefValue = "";
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
        if ($this->testCity->Required) {
            if (!$this->testCity->IsDetailKey && EmptyValue($this->testCity->FormValue)) {
                $this->testCity->addErrorMessage(str_replace("%s", $this->testCity->caption(), $this->testCity->RequiredErrorMessage));
            }
        }
        if ($this->martialartsId->Required) {
            if (!$this->martialartsId->IsDetailKey && EmptyValue($this->martialartsId->FormValue)) {
                $this->martialartsId->addErrorMessage(str_replace("%s", $this->martialartsId->caption(), $this->martialartsId->RequiredErrorMessage));
            }
        }
        if ($this->instructorId->Required) {
            if (!$this->instructorId->IsDetailKey && EmptyValue($this->instructorId->FormValue)) {
                $this->instructorId->addErrorMessage(str_replace("%s", $this->instructorId->caption(), $this->instructorId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->instructorId->FormValue)) {
            $this->instructorId->addErrorMessage($this->instructorId->getErrorMessage(false));
        }
        if ($this->auxiliarInstructorId->Required) {
            if (!$this->auxiliarInstructorId->IsDetailKey && EmptyValue($this->auxiliarInstructorId->FormValue)) {
                $this->auxiliarInstructorId->addErrorMessage(str_replace("%s", $this->auxiliarInstructorId->caption(), $this->auxiliarInstructorId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->auxiliarInstructorId->FormValue)) {
            $this->auxiliarInstructorId->addErrorMessage($this->auxiliarInstructorId->getErrorMessage(false));
        }
        if ($this->testDate->Required) {
            if (!$this->testDate->IsDetailKey && EmptyValue($this->testDate->FormValue)) {
                $this->testDate->addErrorMessage(str_replace("%s", $this->testDate->caption(), $this->testDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->testDate->FormValue, $this->testDate->formatPattern())) {
            $this->testDate->addErrorMessage($this->testDate->getErrorMessage(false));
        }
        if ($this->testTime->Required) {
            if (!$this->testTime->IsDetailKey && EmptyValue($this->testTime->FormValue)) {
                $this->testTime->addErrorMessage(str_replace("%s", $this->testTime->caption(), $this->testTime->RequiredErrorMessage));
            }
        }
        if (!CheckTime($this->testTime->FormValue, $this->testTime->formatPattern())) {
            $this->testTime->addErrorMessage($this->testTime->getErrorMessage(false));
        }
        if ($this->ceremonyDate->Required) {
            if (!$this->ceremonyDate->IsDetailKey && EmptyValue($this->ceremonyDate->FormValue)) {
                $this->ceremonyDate->addErrorMessage(str_replace("%s", $this->ceremonyDate->caption(), $this->ceremonyDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ceremonyDate->FormValue, $this->ceremonyDate->formatPattern())) {
            $this->ceremonyDate->addErrorMessage($this->ceremonyDate->getErrorMessage(false));
        }
        if ($this->testTypeId->Required) {
            if (!$this->testTypeId->IsDetailKey && EmptyValue($this->testTypeId->FormValue)) {
                $this->testTypeId->addErrorMessage(str_replace("%s", $this->testTypeId->caption(), $this->testTypeId->RequiredErrorMessage));
            }
        }
        if ($this->judgeId->Required) {
            if (!$this->judgeId->IsDetailKey && EmptyValue($this->judgeId->FormValue)) {
                $this->judgeId->addErrorMessage(str_replace("%s", $this->judgeId->caption(), $this->judgeId->RequiredErrorMessage));
            }
        }
        if ($this->certificateId->Required) {
            if (!$this->certificateId->IsDetailKey && EmptyValue($this->certificateId->FormValue)) {
                $this->certificateId->addErrorMessage(str_replace("%s", $this->certificateId->caption(), $this->certificateId->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("TesCandidateGrid");
        if (in_array("tes_candidate", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ViewTestAprovedsGrid");
        if (in_array("view_test_aproveds", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // testCity
        $this->testCity->setDbValueDef($rsnew, $this->testCity->CurrentValue, null, false);

        // martialartsId
        $this->martialartsId->setDbValueDef($rsnew, $this->martialartsId->CurrentValue, null, false);

        // instructorId
        $this->instructorId->setDbValueDef($rsnew, $this->instructorId->CurrentValue, null, false);

        // auxiliarInstructorId
        $this->auxiliarInstructorId->setDbValueDef($rsnew, $this->auxiliarInstructorId->CurrentValue, null, false);

        // testDate
        $this->testDate->setDbValueDef($rsnew, UnFormatDateTime($this->testDate->CurrentValue, $this->testDate->formatPattern()), null, false);

        // testTime
        $this->testTime->setDbValueDef($rsnew, UnFormatDateTime($this->testTime->CurrentValue, $this->testTime->formatPattern()), null, false);

        // ceremonyDate
        $this->ceremonyDate->setDbValueDef($rsnew, UnFormatDateTime($this->ceremonyDate->CurrentValue, $this->ceremonyDate->formatPattern()), null, false);

        // testTypeId
        $this->testTypeId->setDbValueDef($rsnew, $this->testTypeId->CurrentValue, null, false);

        // judgeId
        $this->judgeId->setDbValueDef($rsnew, $this->judgeId->CurrentValue, null, false);

        // certificateId
        $this->certificateId->setDbValueDef($rsnew, $this->certificateId->CurrentValue, null, false);

        // schoolId
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['schoolId'] = CurrentUserID();
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("TesCandidateGrid");
            if (in_array("tes_candidate", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->testId->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "tes_candidate"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->testId->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ViewTestAprovedsGrid");
            if (in_array("view_test_aproveds", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->testId->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "view_test_aproveds"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->testId->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->schoolId->CurrentValue);
        }
        return true;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("tes_candidate", $detailTblVar)) {
                $detailPageObj = Container("TesCandidateGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->testId->IsDetailKey = true;
                    $detailPageObj->testId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->testId->setSessionValue($detailPageObj->testId->CurrentValue);
                }
            }
            if (in_array("view_test_aproveds", $detailTblVar)) {
                $detailPageObj = Container("ViewTestAprovedsGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->testId->IsDetailKey = true;
                    $detailPageObj->testId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->testId->setSessionValue($detailPageObj->testId->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TesTestList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('tes_candidate');
        $pages->add('view_test_aproveds');
        $this->DetailPages = $pages;
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
                case "x_testCity":
                    break;
                case "x_federationId":
                    break;
                case "x_martialartsId":
                    break;
                case "x_schoolId":
                    break;
                case "x_instructorId":
                    $lookupFilter = function () {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_auxiliarInstructorId":
                    $lookupFilter = function () {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_testTypeId":
                    break;
                case "x_testStatusId":
                    break;
                case "x_createUserId":
                    break;
                case "x_judgeId":
                    break;
                case "x_certificateId":
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
