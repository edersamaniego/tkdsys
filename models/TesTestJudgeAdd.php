<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesTestJudgeAdd extends TesTestJudge
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_test_judge';

    // Page object name
    public $PageObjName = "TesTestJudgeAdd";

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

        // Table object (tes_test_judge)
        if (!isset($GLOBALS["tes_test_judge"]) || get_class($GLOBALS["tes_test_judge"]) == PROJECT_NAMESPACE . "tes_test_judge") {
            $GLOBALS["tes_test_judge"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_test_judge');
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
                $tbl = Container("tes_test_judge");
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
                    if ($pageName == "TesTestJudgeView") {
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
        $this->judgeMemberId->setVisibility();
        $this->testId->setVisibility();
        $this->rankId->setVisibility();
        $this->instructorRegister->setVisibility();
        $this->federationRegister->setVisibility();
        $this->memberCityId->setVisibility();
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
                    $this->terminate("TesTestJudgeList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "TesTestJudgeList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "TesTestJudgeView") {
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'judgeMemberId' first before field var 'x_judgeMemberId'
        $val = $CurrentForm->hasValue("judgeMemberId") ? $CurrentForm->getValue("judgeMemberId") : $CurrentForm->getValue("x_judgeMemberId");
        if (!$this->judgeMemberId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->judgeMemberId->Visible = false; // Disable update for API request
            } else {
                $this->judgeMemberId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'testId' first before field var 'x_testId'
        $val = $CurrentForm->hasValue("testId") ? $CurrentForm->getValue("testId") : $CurrentForm->getValue("x_testId");
        if (!$this->testId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testId->Visible = false; // Disable update for API request
            } else {
                $this->testId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'rankId' first before field var 'x_rankId'
        $val = $CurrentForm->hasValue("rankId") ? $CurrentForm->getValue("rankId") : $CurrentForm->getValue("x_rankId");
        if (!$this->rankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rankId->Visible = false; // Disable update for API request
            } else {
                $this->rankId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'instructorRegister' first before field var 'x_instructorRegister'
        $val = $CurrentForm->hasValue("instructorRegister") ? $CurrentForm->getValue("instructorRegister") : $CurrentForm->getValue("x_instructorRegister");
        if (!$this->instructorRegister->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorRegister->Visible = false; // Disable update for API request
            } else {
                $this->instructorRegister->setFormValue($val);
            }
        }

        // Check field name 'federationRegister' first before field var 'x_federationRegister'
        $val = $CurrentForm->hasValue("federationRegister") ? $CurrentForm->getValue("federationRegister") : $CurrentForm->getValue("x_federationRegister");
        if (!$this->federationRegister->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->federationRegister->Visible = false; // Disable update for API request
            } else {
                $this->federationRegister->setFormValue($val);
            }
        }

        // Check field name 'memberCityId' first before field var 'x_memberCityId'
        $val = $CurrentForm->hasValue("memberCityId") ? $CurrentForm->getValue("memberCityId") : $CurrentForm->getValue("x_memberCityId");
        if (!$this->memberCityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberCityId->Visible = false; // Disable update for API request
            } else {
                $this->memberCityId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->judgeMemberId->CurrentValue = $this->judgeMemberId->FormValue;
        $this->testId->CurrentValue = $this->testId->FormValue;
        $this->rankId->CurrentValue = $this->rankId->FormValue;
        $this->instructorRegister->CurrentValue = $this->instructorRegister->FormValue;
        $this->federationRegister->CurrentValue = $this->federationRegister->FormValue;
        $this->memberCityId->CurrentValue = $this->memberCityId->FormValue;
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
        $this->judgeMemberId->setDbValue($row['judgeMemberId']);
        $this->testId->setDbValue($row['testId']);
        $this->rankId->setDbValue($row['rankId']);
        $this->instructorRegister->setDbValue($row['instructorRegister']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->memberCityId->setDbValue($row['memberCityId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['judgeMemberId'] = $this->judgeMemberId->DefaultValue;
        $row['testId'] = $this->testId->DefaultValue;
        $row['rankId'] = $this->rankId->DefaultValue;
        $row['instructorRegister'] = $this->instructorRegister->DefaultValue;
        $row['federationRegister'] = $this->federationRegister->DefaultValue;
        $row['memberCityId'] = $this->memberCityId->DefaultValue;
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

        // judgeMemberId
        $this->judgeMemberId->RowCssClass = "row";

        // testId
        $this->testId->RowCssClass = "row";

        // rankId
        $this->rankId->RowCssClass = "row";

        // instructorRegister
        $this->instructorRegister->RowCssClass = "row";

        // federationRegister
        $this->federationRegister->RowCssClass = "row";

        // memberCityId
        $this->memberCityId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // judgeMemberId
            $this->judgeMemberId->ViewValue = $this->judgeMemberId->CurrentValue;
            $this->judgeMemberId->ViewValue = FormatNumber($this->judgeMemberId->ViewValue, $this->judgeMemberId->formatPattern());
            $this->judgeMemberId->ViewCustomAttributes = "";

            // testId
            $this->testId->ViewValue = $this->testId->CurrentValue;
            $this->testId->ViewValue = FormatNumber($this->testId->ViewValue, $this->testId->formatPattern());
            $this->testId->ViewCustomAttributes = "";

            // rankId
            $this->rankId->ViewValue = $this->rankId->CurrentValue;
            $this->rankId->ViewValue = FormatNumber($this->rankId->ViewValue, $this->rankId->formatPattern());
            $this->rankId->ViewCustomAttributes = "";

            // instructorRegister
            $this->instructorRegister->ViewValue = $this->instructorRegister->CurrentValue;
            $this->instructorRegister->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // memberCityId
            $this->memberCityId->ViewValue = $this->memberCityId->CurrentValue;
            $this->memberCityId->ViewValue = FormatNumber($this->memberCityId->ViewValue, $this->memberCityId->formatPattern());
            $this->memberCityId->ViewCustomAttributes = "";

            // judgeMemberId
            $this->judgeMemberId->LinkCustomAttributes = "";
            $this->judgeMemberId->HrefValue = "";

            // testId
            $this->testId->LinkCustomAttributes = "";
            $this->testId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // instructorRegister
            $this->instructorRegister->LinkCustomAttributes = "";
            $this->instructorRegister->HrefValue = "";

            // federationRegister
            $this->federationRegister->LinkCustomAttributes = "";
            $this->federationRegister->HrefValue = "";

            // memberCityId
            $this->memberCityId->LinkCustomAttributes = "";
            $this->memberCityId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // judgeMemberId
            $this->judgeMemberId->setupEditAttributes();
            $this->judgeMemberId->EditCustomAttributes = "";
            $this->judgeMemberId->EditValue = HtmlEncode($this->judgeMemberId->CurrentValue);
            $this->judgeMemberId->PlaceHolder = RemoveHtml($this->judgeMemberId->caption());
            if (strval($this->judgeMemberId->EditValue) != "" && is_numeric($this->judgeMemberId->EditValue)) {
                $this->judgeMemberId->EditValue = FormatNumber($this->judgeMemberId->EditValue, null);
            }

            // testId
            $this->testId->setupEditAttributes();
            $this->testId->EditCustomAttributes = "";
            $this->testId->EditValue = HtmlEncode($this->testId->CurrentValue);
            $this->testId->PlaceHolder = RemoveHtml($this->testId->caption());
            if (strval($this->testId->EditValue) != "" && is_numeric($this->testId->EditValue)) {
                $this->testId->EditValue = FormatNumber($this->testId->EditValue, null);
            }

            // rankId
            $this->rankId->setupEditAttributes();
            $this->rankId->EditCustomAttributes = "";
            $this->rankId->EditValue = HtmlEncode($this->rankId->CurrentValue);
            $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());
            if (strval($this->rankId->EditValue) != "" && is_numeric($this->rankId->EditValue)) {
                $this->rankId->EditValue = FormatNumber($this->rankId->EditValue, null);
            }

            // instructorRegister
            $this->instructorRegister->setupEditAttributes();
            $this->instructorRegister->EditCustomAttributes = "";
            if (!$this->instructorRegister->Raw) {
                $this->instructorRegister->CurrentValue = HtmlDecode($this->instructorRegister->CurrentValue);
            }
            $this->instructorRegister->EditValue = HtmlEncode($this->instructorRegister->CurrentValue);
            $this->instructorRegister->PlaceHolder = RemoveHtml($this->instructorRegister->caption());

            // federationRegister
            $this->federationRegister->setupEditAttributes();
            $this->federationRegister->EditCustomAttributes = "";
            if (!$this->federationRegister->Raw) {
                $this->federationRegister->CurrentValue = HtmlDecode($this->federationRegister->CurrentValue);
            }
            $this->federationRegister->EditValue = HtmlEncode($this->federationRegister->CurrentValue);
            $this->federationRegister->PlaceHolder = RemoveHtml($this->federationRegister->caption());

            // memberCityId
            $this->memberCityId->setupEditAttributes();
            $this->memberCityId->EditCustomAttributes = "";
            $this->memberCityId->EditValue = HtmlEncode($this->memberCityId->CurrentValue);
            $this->memberCityId->PlaceHolder = RemoveHtml($this->memberCityId->caption());
            if (strval($this->memberCityId->EditValue) != "" && is_numeric($this->memberCityId->EditValue)) {
                $this->memberCityId->EditValue = FormatNumber($this->memberCityId->EditValue, null);
            }

            // Add refer script

            // judgeMemberId
            $this->judgeMemberId->LinkCustomAttributes = "";
            $this->judgeMemberId->HrefValue = "";

            // testId
            $this->testId->LinkCustomAttributes = "";
            $this->testId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // instructorRegister
            $this->instructorRegister->LinkCustomAttributes = "";
            $this->instructorRegister->HrefValue = "";

            // federationRegister
            $this->federationRegister->LinkCustomAttributes = "";
            $this->federationRegister->HrefValue = "";

            // memberCityId
            $this->memberCityId->LinkCustomAttributes = "";
            $this->memberCityId->HrefValue = "";
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
        if ($this->judgeMemberId->Required) {
            if (!$this->judgeMemberId->IsDetailKey && EmptyValue($this->judgeMemberId->FormValue)) {
                $this->judgeMemberId->addErrorMessage(str_replace("%s", $this->judgeMemberId->caption(), $this->judgeMemberId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->judgeMemberId->FormValue)) {
            $this->judgeMemberId->addErrorMessage($this->judgeMemberId->getErrorMessage(false));
        }
        if ($this->testId->Required) {
            if (!$this->testId->IsDetailKey && EmptyValue($this->testId->FormValue)) {
                $this->testId->addErrorMessage(str_replace("%s", $this->testId->caption(), $this->testId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->testId->FormValue)) {
            $this->testId->addErrorMessage($this->testId->getErrorMessage(false));
        }
        if ($this->rankId->Required) {
            if (!$this->rankId->IsDetailKey && EmptyValue($this->rankId->FormValue)) {
                $this->rankId->addErrorMessage(str_replace("%s", $this->rankId->caption(), $this->rankId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->rankId->FormValue)) {
            $this->rankId->addErrorMessage($this->rankId->getErrorMessage(false));
        }
        if ($this->instructorRegister->Required) {
            if (!$this->instructorRegister->IsDetailKey && EmptyValue($this->instructorRegister->FormValue)) {
                $this->instructorRegister->addErrorMessage(str_replace("%s", $this->instructorRegister->caption(), $this->instructorRegister->RequiredErrorMessage));
            }
        }
        if ($this->federationRegister->Required) {
            if (!$this->federationRegister->IsDetailKey && EmptyValue($this->federationRegister->FormValue)) {
                $this->federationRegister->addErrorMessage(str_replace("%s", $this->federationRegister->caption(), $this->federationRegister->RequiredErrorMessage));
            }
        }
        if ($this->memberCityId->Required) {
            if (!$this->memberCityId->IsDetailKey && EmptyValue($this->memberCityId->FormValue)) {
                $this->memberCityId->addErrorMessage(str_replace("%s", $this->memberCityId->caption(), $this->memberCityId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->memberCityId->FormValue)) {
            $this->memberCityId->addErrorMessage($this->memberCityId->getErrorMessage(false));
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

        // judgeMemberId
        $this->judgeMemberId->setDbValueDef($rsnew, $this->judgeMemberId->CurrentValue, null, false);

        // testId
        $this->testId->setDbValueDef($rsnew, $this->testId->CurrentValue, null, false);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, false);

        // instructorRegister
        $this->instructorRegister->setDbValueDef($rsnew, $this->instructorRegister->CurrentValue, null, false);

        // federationRegister
        $this->federationRegister->setDbValueDef($rsnew, $this->federationRegister->CurrentValue, null, false);

        // memberCityId
        $this->memberCityId->setDbValueDef($rsnew, $this->memberCityId->CurrentValue, null, false);

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TesTestJudgeList"), "", $this->TableVar, true);
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
