<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SchoolClassAdd extends SchoolClass
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'school_class';

    // Page object name
    public $PageObjName = "SchoolClassAdd";

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

        // Table object (school_class)
        if (!isset($GLOBALS["school_class"]) || get_class($GLOBALS["school_class"]) == PROJECT_NAMESPACE . "school_class") {
            $GLOBALS["school_class"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'school_class');
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
                $tbl = Container("school_class");
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
                    if ($pageName == "SchoolClassView") {
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
        $this->schoolId->setVisibility();
        $this->daysByWeek->setVisibility();
        $this->beginnigTime->setVisibility();
        $this->endingTime->setVisibility();
        $this->status->setVisibility();
        $this->limit->setVisibility();
        $this->modalityId->setVisibility();
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
                    $this->terminate("SchoolClassList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "SchoolClassList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "SchoolClassView") {
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

        // Check field name 'schoolId' first before field var 'x_schoolId'
        $val = $CurrentForm->hasValue("schoolId") ? $CurrentForm->getValue("schoolId") : $CurrentForm->getValue("x_schoolId");
        if (!$this->schoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schoolId->Visible = false; // Disable update for API request
            } else {
                $this->schoolId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'daysByWeek' first before field var 'x_daysByWeek'
        $val = $CurrentForm->hasValue("daysByWeek") ? $CurrentForm->getValue("daysByWeek") : $CurrentForm->getValue("x_daysByWeek");
        if (!$this->daysByWeek->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->daysByWeek->Visible = false; // Disable update for API request
            } else {
                $this->daysByWeek->setFormValue($val);
            }
        }

        // Check field name 'beginnigTime' first before field var 'x_beginnigTime'
        $val = $CurrentForm->hasValue("beginnigTime") ? $CurrentForm->getValue("beginnigTime") : $CurrentForm->getValue("x_beginnigTime");
        if (!$this->beginnigTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->beginnigTime->Visible = false; // Disable update for API request
            } else {
                $this->beginnigTime->setFormValue($val, true, $validate);
            }
            $this->beginnigTime->CurrentValue = UnFormatDateTime($this->beginnigTime->CurrentValue, $this->beginnigTime->formatPattern());
        }

        // Check field name 'endingTime' first before field var 'x_endingTime'
        $val = $CurrentForm->hasValue("endingTime") ? $CurrentForm->getValue("endingTime") : $CurrentForm->getValue("x_endingTime");
        if (!$this->endingTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->endingTime->Visible = false; // Disable update for API request
            } else {
                $this->endingTime->setFormValue($val, true, $validate);
            }
            $this->endingTime->CurrentValue = UnFormatDateTime($this->endingTime->CurrentValue, $this->endingTime->formatPattern());
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'limit' first before field var 'x_limit'
        $val = $CurrentForm->hasValue("limit") ? $CurrentForm->getValue("limit") : $CurrentForm->getValue("x_limit");
        if (!$this->limit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->limit->Visible = false; // Disable update for API request
            } else {
                $this->limit->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'modalityId' first before field var 'x_modalityId'
        $val = $CurrentForm->hasValue("modalityId") ? $CurrentForm->getValue("modalityId") : $CurrentForm->getValue("x_modalityId");
        if (!$this->modalityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modalityId->Visible = false; // Disable update for API request
            } else {
                $this->modalityId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->schoolId->CurrentValue = $this->schoolId->FormValue;
        $this->daysByWeek->CurrentValue = $this->daysByWeek->FormValue;
        $this->beginnigTime->CurrentValue = $this->beginnigTime->FormValue;
        $this->beginnigTime->CurrentValue = UnFormatDateTime($this->beginnigTime->CurrentValue, $this->beginnigTime->formatPattern());
        $this->endingTime->CurrentValue = $this->endingTime->FormValue;
        $this->endingTime->CurrentValue = UnFormatDateTime($this->endingTime->CurrentValue, $this->endingTime->formatPattern());
        $this->status->CurrentValue = $this->status->FormValue;
        $this->limit->CurrentValue = $this->limit->FormValue;
        $this->modalityId->CurrentValue = $this->modalityId->FormValue;
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
        $this->schoolId->setDbValue($row['schoolId']);
        $this->daysByWeek->setDbValue($row['daysByWeek']);
        $this->beginnigTime->setDbValue($row['beginnigTime']);
        $this->endingTime->setDbValue($row['endingTime']);
        $this->status->setDbValue($row['status']);
        $this->limit->setDbValue($row['limit']);
        $this->modalityId->setDbValue($row['modalityId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['daysByWeek'] = $this->daysByWeek->DefaultValue;
        $row['beginnigTime'] = $this->beginnigTime->DefaultValue;
        $row['endingTime'] = $this->endingTime->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['limit'] = $this->limit->DefaultValue;
        $row['modalityId'] = $this->modalityId->DefaultValue;
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

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // daysByWeek
        $this->daysByWeek->RowCssClass = "row";

        // beginnigTime
        $this->beginnigTime->RowCssClass = "row";

        // endingTime
        $this->endingTime->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // limit
        $this->limit->RowCssClass = "row";

        // modalityId
        $this->modalityId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
            $this->schoolId->ViewValue = FormatNumber($this->schoolId->ViewValue, $this->schoolId->formatPattern());
            $this->schoolId->ViewCustomAttributes = "";

            // daysByWeek
            $this->daysByWeek->ViewValue = $this->daysByWeek->CurrentValue;
            $this->daysByWeek->ViewCustomAttributes = "";

            // beginnigTime
            $this->beginnigTime->ViewValue = $this->beginnigTime->CurrentValue;
            $this->beginnigTime->ViewValue = FormatDateTime($this->beginnigTime->ViewValue, $this->beginnigTime->formatPattern());
            $this->beginnigTime->ViewCustomAttributes = "";

            // endingTime
            $this->endingTime->ViewValue = $this->endingTime->CurrentValue;
            $this->endingTime->ViewValue = FormatDateTime($this->endingTime->ViewValue, $this->endingTime->formatPattern());
            $this->endingTime->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewValue = FormatNumber($this->status->ViewValue, $this->status->formatPattern());
            $this->status->ViewCustomAttributes = "";

            // limit
            $this->limit->ViewValue = $this->limit->CurrentValue;
            $this->limit->ViewValue = FormatNumber($this->limit->ViewValue, $this->limit->formatPattern());
            $this->limit->ViewCustomAttributes = "";

            // modalityId
            $this->modalityId->ViewValue = $this->modalityId->CurrentValue;
            $this->modalityId->ViewValue = FormatNumber($this->modalityId->ViewValue, $this->modalityId->formatPattern());
            $this->modalityId->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // daysByWeek
            $this->daysByWeek->LinkCustomAttributes = "";
            $this->daysByWeek->HrefValue = "";

            // beginnigTime
            $this->beginnigTime->LinkCustomAttributes = "";
            $this->beginnigTime->HrefValue = "";

            // endingTime
            $this->endingTime->LinkCustomAttributes = "";
            $this->endingTime->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // limit
            $this->limit->LinkCustomAttributes = "";
            $this->limit->HrefValue = "";

            // modalityId
            $this->modalityId->LinkCustomAttributes = "";
            $this->modalityId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // schoolId
            $this->schoolId->setupEditAttributes();
            $this->schoolId->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
            } else {
                $this->schoolId->EditValue = HtmlEncode($this->schoolId->CurrentValue);
                $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
                if (strval($this->schoolId->EditValue) != "" && is_numeric($this->schoolId->EditValue)) {
                    $this->schoolId->EditValue = FormatNumber($this->schoolId->EditValue, null);
                }
            }

            // daysByWeek
            $this->daysByWeek->setupEditAttributes();
            $this->daysByWeek->EditCustomAttributes = "";
            if (!$this->daysByWeek->Raw) {
                $this->daysByWeek->CurrentValue = HtmlDecode($this->daysByWeek->CurrentValue);
            }
            $this->daysByWeek->EditValue = HtmlEncode($this->daysByWeek->CurrentValue);
            $this->daysByWeek->PlaceHolder = RemoveHtml($this->daysByWeek->caption());

            // beginnigTime
            $this->beginnigTime->setupEditAttributes();
            $this->beginnigTime->EditCustomAttributes = "";
            $this->beginnigTime->EditValue = HtmlEncode(FormatDateTime($this->beginnigTime->CurrentValue, $this->beginnigTime->formatPattern()));
            $this->beginnigTime->PlaceHolder = RemoveHtml($this->beginnigTime->caption());

            // endingTime
            $this->endingTime->setupEditAttributes();
            $this->endingTime->EditCustomAttributes = "";
            $this->endingTime->EditValue = HtmlEncode(FormatDateTime($this->endingTime->CurrentValue, $this->endingTime->formatPattern()));
            $this->endingTime->PlaceHolder = RemoveHtml($this->endingTime->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());
            if (strval($this->status->EditValue) != "" && is_numeric($this->status->EditValue)) {
                $this->status->EditValue = FormatNumber($this->status->EditValue, null);
            }

            // limit
            $this->limit->setupEditAttributes();
            $this->limit->EditCustomAttributes = "";
            $this->limit->EditValue = HtmlEncode($this->limit->CurrentValue);
            $this->limit->PlaceHolder = RemoveHtml($this->limit->caption());
            if (strval($this->limit->EditValue) != "" && is_numeric($this->limit->EditValue)) {
                $this->limit->EditValue = FormatNumber($this->limit->EditValue, null);
            }

            // modalityId
            $this->modalityId->setupEditAttributes();
            $this->modalityId->EditCustomAttributes = "";
            $this->modalityId->EditValue = HtmlEncode($this->modalityId->CurrentValue);
            $this->modalityId->PlaceHolder = RemoveHtml($this->modalityId->caption());
            if (strval($this->modalityId->EditValue) != "" && is_numeric($this->modalityId->EditValue)) {
                $this->modalityId->EditValue = FormatNumber($this->modalityId->EditValue, null);
            }

            // Add refer script

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // daysByWeek
            $this->daysByWeek->LinkCustomAttributes = "";
            $this->daysByWeek->HrefValue = "";

            // beginnigTime
            $this->beginnigTime->LinkCustomAttributes = "";
            $this->beginnigTime->HrefValue = "";

            // endingTime
            $this->endingTime->LinkCustomAttributes = "";
            $this->endingTime->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // limit
            $this->limit->LinkCustomAttributes = "";
            $this->limit->HrefValue = "";

            // modalityId
            $this->modalityId->LinkCustomAttributes = "";
            $this->modalityId->HrefValue = "";
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
        if ($this->schoolId->Required) {
            if (!$this->schoolId->IsDetailKey && EmptyValue($this->schoolId->FormValue)) {
                $this->schoolId->addErrorMessage(str_replace("%s", $this->schoolId->caption(), $this->schoolId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->schoolId->FormValue)) {
            $this->schoolId->addErrorMessage($this->schoolId->getErrorMessage(false));
        }
        if ($this->daysByWeek->Required) {
            if (!$this->daysByWeek->IsDetailKey && EmptyValue($this->daysByWeek->FormValue)) {
                $this->daysByWeek->addErrorMessage(str_replace("%s", $this->daysByWeek->caption(), $this->daysByWeek->RequiredErrorMessage));
            }
        }
        if ($this->beginnigTime->Required) {
            if (!$this->beginnigTime->IsDetailKey && EmptyValue($this->beginnigTime->FormValue)) {
                $this->beginnigTime->addErrorMessage(str_replace("%s", $this->beginnigTime->caption(), $this->beginnigTime->RequiredErrorMessage));
            }
        }
        if (!CheckTime($this->beginnigTime->FormValue, $this->beginnigTime->formatPattern())) {
            $this->beginnigTime->addErrorMessage($this->beginnigTime->getErrorMessage(false));
        }
        if ($this->endingTime->Required) {
            if (!$this->endingTime->IsDetailKey && EmptyValue($this->endingTime->FormValue)) {
                $this->endingTime->addErrorMessage(str_replace("%s", $this->endingTime->caption(), $this->endingTime->RequiredErrorMessage));
            }
        }
        if (!CheckTime($this->endingTime->FormValue, $this->endingTime->formatPattern())) {
            $this->endingTime->addErrorMessage($this->endingTime->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->status->FormValue)) {
            $this->status->addErrorMessage($this->status->getErrorMessage(false));
        }
        if ($this->limit->Required) {
            if (!$this->limit->IsDetailKey && EmptyValue($this->limit->FormValue)) {
                $this->limit->addErrorMessage(str_replace("%s", $this->limit->caption(), $this->limit->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->limit->FormValue)) {
            $this->limit->addErrorMessage($this->limit->getErrorMessage(false));
        }
        if ($this->modalityId->Required) {
            if (!$this->modalityId->IsDetailKey && EmptyValue($this->modalityId->FormValue)) {
                $this->modalityId->addErrorMessage(str_replace("%s", $this->modalityId->caption(), $this->modalityId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->modalityId->FormValue)) {
            $this->modalityId->addErrorMessage($this->modalityId->getErrorMessage(false));
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

        // schoolId
        $this->schoolId->setDbValueDef($rsnew, $this->schoolId->CurrentValue, 0, false);

        // daysByWeek
        $this->daysByWeek->setDbValueDef($rsnew, $this->daysByWeek->CurrentValue, null, false);

        // beginnigTime
        $this->beginnigTime->setDbValueDef($rsnew, UnFormatDateTime($this->beginnigTime->CurrentValue, $this->beginnigTime->formatPattern()), null, false);

        // endingTime
        $this->endingTime->setDbValueDef($rsnew, UnFormatDateTime($this->endingTime->CurrentValue, $this->endingTime->formatPattern()), null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // limit
        $this->limit->setDbValueDef($rsnew, $this->limit->CurrentValue, null, false);

        // modalityId
        $this->modalityId->setDbValueDef($rsnew, $this->modalityId->CurrentValue, 0, false);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->schoolId->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->schoolId->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->schoolId->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }
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

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->schoolId->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SchoolClassList"), "", $this->TableVar, true);
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
