<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinDebitAdd extends FinDebit
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_debit';

    // Page object name
    public $PageObjName = "FinDebitAdd";

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

        // Table object (fin_debit)
        if (!isset($GLOBALS["fin_debit"]) || get_class($GLOBALS["fin_debit"]) == PROJECT_NAMESPACE . "fin_debit") {
            $GLOBALS["fin_debit"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fin_debit');
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
                $tbl = Container("fin_debit");
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
                    if ($pageName == "FinDebitView") {
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
        $this->accountId->setVisibility();
        $this->dueDate->setVisibility();
        $this->value->setVisibility();
        $this->paymentMethod->setVisibility();
        $this->checkingAccountId->setVisibility();
        $this->obs->setVisibility();
        $this->_userId->Visible = false;
        $this->_register->Visible = false;
        $this->lastUpdate->setVisibility();
        $this->lastUser->setVisibility();
        $this->schoolId->Visible = false;
        $this->masterSchoolId->Visible = false;
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
        $this->setupLookupOptions($this->accountId);
        $this->setupLookupOptions($this->paymentMethod);
        $this->setupLookupOptions($this->checkingAccountId);
        $this->setupLookupOptions($this->_userId);
        $this->setupLookupOptions($this->lastUser);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->masterSchoolId);

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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

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
                    $this->terminate("FinDebitList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "FinDebitList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FinDebitView") {
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

        // Check field name 'accountId' first before field var 'x_accountId'
        $val = $CurrentForm->hasValue("accountId") ? $CurrentForm->getValue("accountId") : $CurrentForm->getValue("x_accountId");
        if (!$this->accountId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->accountId->Visible = false; // Disable update for API request
            } else {
                $this->accountId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'dueDate' first before field var 'x_dueDate'
        $val = $CurrentForm->hasValue("dueDate") ? $CurrentForm->getValue("dueDate") : $CurrentForm->getValue("x_dueDate");
        if (!$this->dueDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dueDate->Visible = false; // Disable update for API request
            } else {
                $this->dueDate->setFormValue($val, true, $validate);
            }
            $this->dueDate->CurrentValue = UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        }

        // Check field name 'value' first before field var 'x_value'
        $val = $CurrentForm->hasValue("value") ? $CurrentForm->getValue("value") : $CurrentForm->getValue("x_value");
        if (!$this->value->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->value->Visible = false; // Disable update for API request
            } else {
                $this->value->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'paymentMethod' first before field var 'x_paymentMethod'
        $val = $CurrentForm->hasValue("paymentMethod") ? $CurrentForm->getValue("paymentMethod") : $CurrentForm->getValue("x_paymentMethod");
        if (!$this->paymentMethod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->paymentMethod->Visible = false; // Disable update for API request
            } else {
                $this->paymentMethod->setFormValue($val);
            }
        }

        // Check field name 'checkingAccountId' first before field var 'x_checkingAccountId'
        $val = $CurrentForm->hasValue("checkingAccountId") ? $CurrentForm->getValue("checkingAccountId") : $CurrentForm->getValue("x_checkingAccountId");
        if (!$this->checkingAccountId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checkingAccountId->Visible = false; // Disable update for API request
            } else {
                $this->checkingAccountId->setFormValue($val);
            }
        }

        // Check field name 'obs' first before field var 'x_obs'
        $val = $CurrentForm->hasValue("obs") ? $CurrentForm->getValue("obs") : $CurrentForm->getValue("x_obs");
        if (!$this->obs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obs->Visible = false; // Disable update for API request
            } else {
                $this->obs->setFormValue($val);
            }
        }

        // Check field name 'lastUpdate' first before field var 'x_lastUpdate'
        $val = $CurrentForm->hasValue("lastUpdate") ? $CurrentForm->getValue("lastUpdate") : $CurrentForm->getValue("x_lastUpdate");
        if (!$this->lastUpdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastUpdate->Visible = false; // Disable update for API request
            } else {
                $this->lastUpdate->setFormValue($val);
            }
            $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        }

        // Check field name 'lastUser' first before field var 'x_lastUser'
        $val = $CurrentForm->hasValue("lastUser") ? $CurrentForm->getValue("lastUser") : $CurrentForm->getValue("x_lastUser");
        if (!$this->lastUser->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastUser->Visible = false; // Disable update for API request
            } else {
                $this->lastUser->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->accountId->CurrentValue = $this->accountId->FormValue;
        $this->dueDate->CurrentValue = $this->dueDate->FormValue;
        $this->dueDate->CurrentValue = UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern());
        $this->value->CurrentValue = $this->value->FormValue;
        $this->paymentMethod->CurrentValue = $this->paymentMethod->FormValue;
        $this->checkingAccountId->CurrentValue = $this->checkingAccountId->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->lastUpdate->CurrentValue = $this->lastUpdate->FormValue;
        $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        $this->lastUser->CurrentValue = $this->lastUser->FormValue;
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
        $this->accountId->setDbValue($row['accountId']);
        $this->dueDate->setDbValue($row['dueDate']);
        $this->value->setDbValue($row['value']);
        $this->paymentMethod->setDbValue($row['paymentMethod']);
        $this->checkingAccountId->setDbValue($row['checkingAccountId']);
        $this->obs->setDbValue($row['obs']);
        $this->_userId->setDbValue($row['userId']);
        $this->_register->setDbValue($row['register']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->lastUser->setDbValue($row['lastUser']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['accountId'] = $this->accountId->DefaultValue;
        $row['dueDate'] = $this->dueDate->DefaultValue;
        $row['value'] = $this->value->DefaultValue;
        $row['paymentMethod'] = $this->paymentMethod->DefaultValue;
        $row['checkingAccountId'] = $this->checkingAccountId->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['register'] = $this->_register->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['lastUser'] = $this->lastUser->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['masterSchoolId'] = $this->masterSchoolId->DefaultValue;
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

        // accountId
        $this->accountId->RowCssClass = "row";

        // dueDate
        $this->dueDate->RowCssClass = "row";

        // value
        $this->value->RowCssClass = "row";

        // paymentMethod
        $this->paymentMethod->RowCssClass = "row";

        // checkingAccountId
        $this->checkingAccountId->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // register
        $this->_register->RowCssClass = "row";

        // lastUpdate
        $this->lastUpdate->RowCssClass = "row";

        // lastUser
        $this->lastUser->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // masterSchoolId
        $this->masterSchoolId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // accountId
            $this->accountId->ViewValue = $this->accountId->CurrentValue;
            $curVal = strval($this->accountId->CurrentValue);
            if ($curVal != "") {
                $this->accountId->ViewValue = $this->accountId->lookupCacheOption($curVal);
                if ($this->accountId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->accountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->accountId->Lookup->renderViewRow($rswrk[0]);
                        $this->accountId->ViewValue = $this->accountId->displayValue($arwrk);
                    } else {
                        $this->accountId->ViewValue = FormatNumber($this->accountId->CurrentValue, $this->accountId->formatPattern());
                    }
                }
            } else {
                $this->accountId->ViewValue = null;
            }
            $this->accountId->ViewCustomAttributes = "";

            // dueDate
            $this->dueDate->ViewValue = $this->dueDate->CurrentValue;
            $this->dueDate->ViewValue = FormatDateTime($this->dueDate->ViewValue, $this->dueDate->formatPattern());
            $this->dueDate->ViewCustomAttributes = "";

            // value
            $this->value->ViewValue = $this->value->CurrentValue;
            $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
            $this->value->ViewCustomAttributes = "";

            // paymentMethod
            $curVal = strval($this->paymentMethod->CurrentValue);
            if ($curVal != "") {
                $this->paymentMethod->ViewValue = $this->paymentMethod->lookupCacheOption($curVal);
                if ($this->paymentMethod->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->paymentMethod->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->paymentMethod->Lookup->renderViewRow($rswrk[0]);
                        $this->paymentMethod->ViewValue = $this->paymentMethod->displayValue($arwrk);
                    } else {
                        $this->paymentMethod->ViewValue = FormatNumber($this->paymentMethod->CurrentValue, $this->paymentMethod->formatPattern());
                    }
                }
            } else {
                $this->paymentMethod->ViewValue = null;
            }
            $this->paymentMethod->ViewCustomAttributes = "";

            // checkingAccountId
            $curVal = strval($this->checkingAccountId->CurrentValue);
            if ($curVal != "") {
                $this->checkingAccountId->ViewValue = $this->checkingAccountId->lookupCacheOption($curVal);
                if ($this->checkingAccountId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checkingAccountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checkingAccountId->Lookup->renderViewRow($rswrk[0]);
                        $this->checkingAccountId->ViewValue = $this->checkingAccountId->displayValue($arwrk);
                    } else {
                        $this->checkingAccountId->ViewValue = FormatNumber($this->checkingAccountId->CurrentValue, $this->checkingAccountId->formatPattern());
                    }
                }
            } else {
                $this->checkingAccountId->ViewValue = null;
            }
            $this->checkingAccountId->ViewCustomAttributes = "";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->ViewCustomAttributes = "";

            // userId
            $this->_userId->ViewValue = $this->_userId->CurrentValue;
            $curVal = strval($this->_userId->CurrentValue);
            if ($curVal != "") {
                $this->_userId->ViewValue = $this->_userId->lookupCacheOption($curVal);
                if ($this->_userId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->_userId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_userId->Lookup->renderViewRow($rswrk[0]);
                        $this->_userId->ViewValue = $this->_userId->displayValue($arwrk);
                    } else {
                        $this->_userId->ViewValue = FormatNumber($this->_userId->CurrentValue, $this->_userId->formatPattern());
                    }
                }
            } else {
                $this->_userId->ViewValue = null;
            }
            $this->_userId->ViewCustomAttributes = "";

            // register
            $this->_register->ViewValue = $this->_register->CurrentValue;
            $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
            $this->_register->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // lastUser
            $this->lastUser->ViewValue = $this->lastUser->CurrentValue;
            $curVal = strval($this->lastUser->CurrentValue);
            if ($curVal != "") {
                $this->lastUser->ViewValue = $this->lastUser->lookupCacheOption($curVal);
                if ($this->lastUser->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->lastUser->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->lastUser->Lookup->renderViewRow($rswrk[0]);
                        $this->lastUser->ViewValue = $this->lastUser->displayValue($arwrk);
                    } else {
                        $this->lastUser->ViewValue = FormatNumber($this->lastUser->CurrentValue, $this->lastUser->formatPattern());
                    }
                }
            } else {
                $this->lastUser->ViewValue = null;
            }
            $this->lastUser->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
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

            // masterSchoolId
            $this->masterSchoolId->ViewValue = $this->masterSchoolId->CurrentValue;
            $curVal = strval($this->masterSchoolId->CurrentValue);
            if ($curVal != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
                if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
            $this->masterSchoolId->ViewCustomAttributes = "";

            // accountId
            $this->accountId->LinkCustomAttributes = "";
            $this->accountId->HrefValue = "";

            // dueDate
            $this->dueDate->LinkCustomAttributes = "";
            $this->dueDate->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // paymentMethod
            $this->paymentMethod->LinkCustomAttributes = "";
            $this->paymentMethod->HrefValue = "";

            // checkingAccountId
            $this->checkingAccountId->LinkCustomAttributes = "";
            $this->checkingAccountId->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // lastUser
            $this->lastUser->LinkCustomAttributes = "";
            $this->lastUser->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // accountId
            $this->accountId->setupEditAttributes();
            $this->accountId->EditCustomAttributes = "";
            if ($this->accountId->getSessionValue() != "") {
                $this->accountId->CurrentValue = GetForeignKeyValue($this->accountId->getSessionValue());
                $this->accountId->ViewValue = $this->accountId->CurrentValue;
                $curVal = strval($this->accountId->CurrentValue);
                if ($curVal != "") {
                    $this->accountId->ViewValue = $this->accountId->lookupCacheOption($curVal);
                    if ($this->accountId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->accountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->accountId->Lookup->renderViewRow($rswrk[0]);
                            $this->accountId->ViewValue = $this->accountId->displayValue($arwrk);
                        } else {
                            $this->accountId->ViewValue = FormatNumber($this->accountId->CurrentValue, $this->accountId->formatPattern());
                        }
                    }
                } else {
                    $this->accountId->ViewValue = null;
                }
                $this->accountId->ViewCustomAttributes = "";
            } else {
                $this->accountId->EditValue = HtmlEncode($this->accountId->CurrentValue);
                $curVal = strval($this->accountId->CurrentValue);
                if ($curVal != "") {
                    $this->accountId->EditValue = $this->accountId->lookupCacheOption($curVal);
                    if ($this->accountId->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->accountId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->accountId->Lookup->renderViewRow($rswrk[0]);
                            $this->accountId->EditValue = $this->accountId->displayValue($arwrk);
                        } else {
                            $this->accountId->EditValue = HtmlEncode(FormatNumber($this->accountId->CurrentValue, $this->accountId->formatPattern()));
                        }
                    }
                } else {
                    $this->accountId->EditValue = null;
                }
                $this->accountId->PlaceHolder = RemoveHtml($this->accountId->caption());
            }

            // dueDate
            $this->dueDate->setupEditAttributes();
            $this->dueDate->EditCustomAttributes = "";
            $this->dueDate->EditValue = HtmlEncode(FormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern()));
            $this->dueDate->PlaceHolder = RemoveHtml($this->dueDate->caption());

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->CurrentValue);
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());
            if (strval($this->value->EditValue) != "" && is_numeric($this->value->EditValue)) {
                $this->value->EditValue = FormatNumber($this->value->EditValue, null);
            }

            // paymentMethod
            $this->paymentMethod->setupEditAttributes();
            $this->paymentMethod->EditCustomAttributes = "";
            $curVal = trim(strval($this->paymentMethod->CurrentValue));
            if ($curVal != "") {
                $this->paymentMethod->ViewValue = $this->paymentMethod->lookupCacheOption($curVal);
            } else {
                $this->paymentMethod->ViewValue = $this->paymentMethod->Lookup !== null && is_array($this->paymentMethod->lookupOptions()) ? $curVal : null;
            }
            if ($this->paymentMethod->ViewValue !== null) { // Load from cache
                $this->paymentMethod->EditValue = array_values($this->paymentMethod->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->paymentMethod->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->paymentMethod->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->paymentMethod->EditValue = $arwrk;
            }
            $this->paymentMethod->PlaceHolder = RemoveHtml($this->paymentMethod->caption());

            // checkingAccountId
            $this->checkingAccountId->setupEditAttributes();
            $this->checkingAccountId->EditCustomAttributes = "";
            $curVal = trim(strval($this->checkingAccountId->CurrentValue));
            if ($curVal != "") {
                $this->checkingAccountId->ViewValue = $this->checkingAccountId->lookupCacheOption($curVal);
            } else {
                $this->checkingAccountId->ViewValue = $this->checkingAccountId->Lookup !== null && is_array($this->checkingAccountId->lookupOptions()) ? $curVal : null;
            }
            if ($this->checkingAccountId->ViewValue !== null) { // Load from cache
                $this->checkingAccountId->EditValue = array_values($this->checkingAccountId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checkingAccountId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checkingAccountId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checkingAccountId->EditValue = $arwrk;
            }
            $this->checkingAccountId->PlaceHolder = RemoveHtml($this->checkingAccountId->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditCustomAttributes = "";
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // lastUpdate

            // lastUser

            // Add refer script

            // accountId
            $this->accountId->LinkCustomAttributes = "";
            $this->accountId->HrefValue = "";

            // dueDate
            $this->dueDate->LinkCustomAttributes = "";
            $this->dueDate->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // paymentMethod
            $this->paymentMethod->LinkCustomAttributes = "";
            $this->paymentMethod->HrefValue = "";

            // checkingAccountId
            $this->checkingAccountId->LinkCustomAttributes = "";
            $this->checkingAccountId->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // lastUser
            $this->lastUser->LinkCustomAttributes = "";
            $this->lastUser->HrefValue = "";
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
        if ($this->accountId->Required) {
            if (!$this->accountId->IsDetailKey && EmptyValue($this->accountId->FormValue)) {
                $this->accountId->addErrorMessage(str_replace("%s", $this->accountId->caption(), $this->accountId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->accountId->FormValue)) {
            $this->accountId->addErrorMessage($this->accountId->getErrorMessage(false));
        }
        if ($this->dueDate->Required) {
            if (!$this->dueDate->IsDetailKey && EmptyValue($this->dueDate->FormValue)) {
                $this->dueDate->addErrorMessage(str_replace("%s", $this->dueDate->caption(), $this->dueDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dueDate->FormValue, $this->dueDate->formatPattern())) {
            $this->dueDate->addErrorMessage($this->dueDate->getErrorMessage(false));
        }
        if ($this->value->Required) {
            if (!$this->value->IsDetailKey && EmptyValue($this->value->FormValue)) {
                $this->value->addErrorMessage(str_replace("%s", $this->value->caption(), $this->value->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->value->FormValue)) {
            $this->value->addErrorMessage($this->value->getErrorMessage(false));
        }
        if ($this->paymentMethod->Required) {
            if (!$this->paymentMethod->IsDetailKey && EmptyValue($this->paymentMethod->FormValue)) {
                $this->paymentMethod->addErrorMessage(str_replace("%s", $this->paymentMethod->caption(), $this->paymentMethod->RequiredErrorMessage));
            }
        }
        if ($this->checkingAccountId->Required) {
            if (!$this->checkingAccountId->IsDetailKey && EmptyValue($this->checkingAccountId->FormValue)) {
                $this->checkingAccountId->addErrorMessage(str_replace("%s", $this->checkingAccountId->caption(), $this->checkingAccountId->RequiredErrorMessage));
            }
        }
        if ($this->obs->Required) {
            if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
            }
        }
        if ($this->lastUpdate->Required) {
            if (!$this->lastUpdate->IsDetailKey && EmptyValue($this->lastUpdate->FormValue)) {
                $this->lastUpdate->addErrorMessage(str_replace("%s", $this->lastUpdate->caption(), $this->lastUpdate->RequiredErrorMessage));
            }
        }
        if ($this->lastUser->Required) {
            if (!$this->lastUser->IsDetailKey && EmptyValue($this->lastUser->FormValue)) {
                $this->lastUser->addErrorMessage(str_replace("%s", $this->lastUser->caption(), $this->lastUser->RequiredErrorMessage));
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

        // accountId
        $this->accountId->setDbValueDef($rsnew, $this->accountId->CurrentValue, null, false);

        // dueDate
        $this->dueDate->setDbValueDef($rsnew, UnFormatDateTime($this->dueDate->CurrentValue, $this->dueDate->formatPattern()), null, false);

        // value
        $this->value->setDbValueDef($rsnew, $this->value->CurrentValue, null, false);

        // paymentMethod
        $this->paymentMethod->setDbValueDef($rsnew, $this->paymentMethod->CurrentValue, null, false);

        // checkingAccountId
        $this->checkingAccountId->setDbValueDef($rsnew, $this->checkingAccountId->CurrentValue, null, false);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, null, false);

        // lastUpdate
        $this->lastUpdate->CurrentValue = CurrentDate();
        $this->lastUpdate->setDbValueDef($rsnew, $this->lastUpdate->CurrentValue, null);

        // lastUser
        $this->lastUser->CurrentValue = GetLoggedUserID();
        $this->lastUser->setDbValueDef($rsnew, $this->lastUser->CurrentValue, null);

        // schoolId
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['schoolId'] = CurrentUserID();
        }

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

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $detailKeys = [];
            $detailKeys["accountId"] = $this->accountId->CurrentValue;
            $masterTable = Container("fin_accountspayable");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $validMasterKey = true;
                if ($rsmaster = $masterTable->loadRs($masterFilter)->fetchAssociative()) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['schoolId']);
                } elseif ($this->getCurrentMasterTable() == "fin_accountspayable") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
            $detailKeys = [];
            $detailKeys["accountId"] = $this->accountId->CurrentValue;
            $masterTable = Container("fin_checkingaccount");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $validMasterKey = true;
                if ($rsmaster = $masterTable->loadRs($masterFilter)->fetchAssociative()) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['schoolId']);
                } elseif ($this->getCurrentMasterTable() == "fin_checkingaccount") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "fin_accountspayable") {
                $validMaster = true;
                $masterTbl = Container("fin_accountspayable");
                if (($parm = Get("fk_id", Get("accountId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->accountId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->accountId->setSessionValue($this->accountId->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "fin_checkingaccount") {
                $validMaster = true;
                $masterTbl = Container("fin_checkingaccount");
                if (($parm = Get("fk_id", Get("accountId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->accountId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->accountId->setSessionValue($this->accountId->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "fin_accountspayable") {
                $validMaster = true;
                $masterTbl = Container("fin_accountspayable");
                if (($parm = Post("fk_id", Post("accountId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->accountId->setFormValue($masterTbl->id->FormValue);
                    $this->accountId->setSessionValue($this->accountId->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "fin_checkingaccount") {
                $validMaster = true;
                $masterTbl = Container("fin_checkingaccount");
                if (($parm = Post("fk_id", Post("accountId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->accountId->setFormValue($masterTbl->id->FormValue);
                    $this->accountId->setSessionValue($this->accountId->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "fin_accountspayable") {
                if ($this->accountId->CurrentValue == "") {
                    $this->accountId->setSessionValue("");
                }
            }
            if ($masterTblVar != "fin_checkingaccount") {
                if ($this->accountId->CurrentValue == "") {
                    $this->accountId->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FinDebitList"), "", $this->TableVar, true);
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
                case "x_accountId":
                    break;
                case "x_paymentMethod":
                    break;
                case "x_checkingAccountId":
                    break;
                case "x__userId":
                    break;
                case "x_lastUser":
                    break;
                case "x_schoolId":
                    break;
                case "x_masterSchoolId":
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
