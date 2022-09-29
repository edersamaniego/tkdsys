<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinAccountsreceivableAdd extends FinAccountsreceivable
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_accountsreceivable';

    // Page object name
    public $PageObjName = "FinAccountsreceivableAdd";

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

        // Table object (fin_accountsreceivable)
        if (!isset($GLOBALS["fin_accountsreceivable"]) || get_class($GLOBALS["fin_accountsreceivable"]) == PROJECT_NAMESPACE . "fin_accountsreceivable") {
            $GLOBALS["fin_accountsreceivable"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fin_accountsreceivable');
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
                $tbl = Container("fin_accountsreceivable");
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
                    if ($pageName == "FinAccountsreceivableView") {
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
        $this->issue->setVisibility();
        $this->due->setVisibility();
        $this->historic->setVisibility();
        $this->income->setVisibility();
        $this->status->Visible = false;
        $this->obs->setVisibility();
        $this->value->setVisibility();
        $this->deferred->Visible = false;
        $this->amountInstallments->Visible = false;
        $this->totalValueDeferred->Visible = false;
        $this->firstdateInstallment->Visible = false;
        $this->actualInstallment->Visible = false;
        $this->orderId->setVisibility();
        $this->balance->Visible = false;
        $this->_userId->Visible = false;
        $this->debtorId->setVisibility();
        $this->accountFather->Visible = false;
        $this->schoolId->Visible = false;
        $this->lastUserId->setVisibility();
        $this->_register->Visible = false;
        $this->lastUpdate->setVisibility();
        $this->licenseId->setVisibility();
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
        $this->setupLookupOptions($this->income);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->deferred);
        $this->setupLookupOptions($this->orderId);
        $this->setupLookupOptions($this->_userId);
        $this->setupLookupOptions($this->debtorId);
        $this->setupLookupOptions($this->accountFather);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->lastUserId);

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
                    $this->terminate("FinAccountsreceivableList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "FinAccountsreceivableList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FinAccountsreceivableView") {
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'issue' first before field var 'x_issue'
        $val = $CurrentForm->hasValue("issue") ? $CurrentForm->getValue("issue") : $CurrentForm->getValue("x_issue");
        if (!$this->issue->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->issue->Visible = false; // Disable update for API request
            } else {
                $this->issue->setFormValue($val, true, $validate);
            }
            $this->issue->CurrentValue = UnFormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern());
        }

        // Check field name 'due' first before field var 'x_due'
        $val = $CurrentForm->hasValue("due") ? $CurrentForm->getValue("due") : $CurrentForm->getValue("x_due");
        if (!$this->due->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->due->Visible = false; // Disable update for API request
            } else {
                $this->due->setFormValue($val, true, $validate);
            }
            $this->due->CurrentValue = UnFormatDateTime($this->due->CurrentValue, $this->due->formatPattern());
        }

        // Check field name 'historic' first before field var 'x_historic'
        $val = $CurrentForm->hasValue("historic") ? $CurrentForm->getValue("historic") : $CurrentForm->getValue("x_historic");
        if (!$this->historic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->historic->Visible = false; // Disable update for API request
            } else {
                $this->historic->setFormValue($val);
            }
        }

        // Check field name 'income' first before field var 'x_income'
        $val = $CurrentForm->hasValue("income") ? $CurrentForm->getValue("income") : $CurrentForm->getValue("x_income");
        if (!$this->income->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->income->Visible = false; // Disable update for API request
            } else {
                $this->income->setFormValue($val);
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

        // Check field name 'value' first before field var 'x_value'
        $val = $CurrentForm->hasValue("value") ? $CurrentForm->getValue("value") : $CurrentForm->getValue("x_value");
        if (!$this->value->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->value->Visible = false; // Disable update for API request
            } else {
                $this->value->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'orderId' first before field var 'x_orderId'
        $val = $CurrentForm->hasValue("orderId") ? $CurrentForm->getValue("orderId") : $CurrentForm->getValue("x_orderId");
        if (!$this->orderId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderId->Visible = false; // Disable update for API request
            } else {
                $this->orderId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'debtorId' first before field var 'x_debtorId'
        $val = $CurrentForm->hasValue("debtorId") ? $CurrentForm->getValue("debtorId") : $CurrentForm->getValue("x_debtorId");
        if (!$this->debtorId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->debtorId->Visible = false; // Disable update for API request
            } else {
                $this->debtorId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'lastUserId' first before field var 'x_lastUserId'
        $val = $CurrentForm->hasValue("lastUserId") ? $CurrentForm->getValue("lastUserId") : $CurrentForm->getValue("x_lastUserId");
        if (!$this->lastUserId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastUserId->Visible = false; // Disable update for API request
            } else {
                $this->lastUserId->setFormValue($val);
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

        // Check field name 'licenseId' first before field var 'x_licenseId'
        $val = $CurrentForm->hasValue("licenseId") ? $CurrentForm->getValue("licenseId") : $CurrentForm->getValue("x_licenseId");
        if (!$this->licenseId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->licenseId->Visible = false; // Disable update for API request
            } else {
                $this->licenseId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->issue->CurrentValue = $this->issue->FormValue;
        $this->issue->CurrentValue = UnFormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern());
        $this->due->CurrentValue = $this->due->FormValue;
        $this->due->CurrentValue = UnFormatDateTime($this->due->CurrentValue, $this->due->formatPattern());
        $this->historic->CurrentValue = $this->historic->FormValue;
        $this->income->CurrentValue = $this->income->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->value->CurrentValue = $this->value->FormValue;
        $this->orderId->CurrentValue = $this->orderId->FormValue;
        $this->debtorId->CurrentValue = $this->debtorId->FormValue;
        $this->lastUserId->CurrentValue = $this->lastUserId->FormValue;
        $this->lastUpdate->CurrentValue = $this->lastUpdate->FormValue;
        $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        $this->licenseId->CurrentValue = $this->licenseId->FormValue;
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
        $this->issue->setDbValue($row['issue']);
        $this->due->setDbValue($row['due']);
        $this->historic->setDbValue($row['historic']);
        $this->income->setDbValue($row['income']);
        if (array_key_exists('EV__income', $row)) {
            $this->income->VirtualValue = $row['EV__income']; // Set up virtual field value
        } else {
            $this->income->VirtualValue = ""; // Clear value
        }
        $this->status->setDbValue($row['status']);
        $this->obs->setDbValue($row['obs']);
        $this->value->setDbValue($row['value']);
        $this->deferred->setDbValue($row['deferred']);
        $this->amountInstallments->setDbValue($row['amountInstallments']);
        $this->totalValueDeferred->setDbValue($row['totalValueDeferred']);
        $this->firstdateInstallment->setDbValue($row['firstdateInstallment']);
        $this->actualInstallment->setDbValue($row['actualInstallment']);
        $this->orderId->setDbValue($row['orderId']);
        $this->balance->setDbValue($row['balance']);
        $this->_userId->setDbValue($row['userId']);
        $this->debtorId->setDbValue($row['debtorId']);
        $this->accountFather->setDbValue($row['accountFather']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->_register->setDbValue($row['register']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->licenseId->setDbValue($row['licenseId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['issue'] = $this->issue->DefaultValue;
        $row['due'] = $this->due->DefaultValue;
        $row['historic'] = $this->historic->DefaultValue;
        $row['income'] = $this->income->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['value'] = $this->value->DefaultValue;
        $row['deferred'] = $this->deferred->DefaultValue;
        $row['amountInstallments'] = $this->amountInstallments->DefaultValue;
        $row['totalValueDeferred'] = $this->totalValueDeferred->DefaultValue;
        $row['firstdateInstallment'] = $this->firstdateInstallment->DefaultValue;
        $row['actualInstallment'] = $this->actualInstallment->DefaultValue;
        $row['orderId'] = $this->orderId->DefaultValue;
        $row['balance'] = $this->balance->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['debtorId'] = $this->debtorId->DefaultValue;
        $row['accountFather'] = $this->accountFather->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['lastUserId'] = $this->lastUserId->DefaultValue;
        $row['register'] = $this->_register->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['licenseId'] = $this->licenseId->DefaultValue;
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

        // issue
        $this->issue->RowCssClass = "row";

        // due
        $this->due->RowCssClass = "row";

        // historic
        $this->historic->RowCssClass = "row";

        // income
        $this->income->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // value
        $this->value->RowCssClass = "row";

        // deferred
        $this->deferred->RowCssClass = "row";

        // amountInstallments
        $this->amountInstallments->RowCssClass = "row";

        // totalValueDeferred
        $this->totalValueDeferred->RowCssClass = "row";

        // firstdateInstallment
        $this->firstdateInstallment->RowCssClass = "row";

        // actualInstallment
        $this->actualInstallment->RowCssClass = "row";

        // orderId
        $this->orderId->RowCssClass = "row";

        // balance
        $this->balance->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // debtorId
        $this->debtorId->RowCssClass = "row";

        // accountFather
        $this->accountFather->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // lastUserId
        $this->lastUserId->RowCssClass = "row";

        // register
        $this->_register->RowCssClass = "row";

        // lastUpdate
        $this->lastUpdate->RowCssClass = "row";

        // licenseId
        $this->licenseId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // issue
            $this->issue->ViewValue = $this->issue->CurrentValue;
            $this->issue->ViewValue = FormatDateTime($this->issue->ViewValue, $this->issue->formatPattern());
            $this->issue->ViewCustomAttributes = "";

            // due
            $this->due->ViewValue = $this->due->CurrentValue;
            $this->due->ViewValue = FormatDateTime($this->due->ViewValue, $this->due->formatPattern());
            $this->due->ViewCustomAttributes = "";

            // historic
            $this->historic->ViewValue = $this->historic->CurrentValue;
            $this->historic->ViewCustomAttributes = "";

            // income
            if ($this->income->VirtualValue != "") {
                $this->income->ViewValue = $this->income->VirtualValue;
            } else {
                $curVal = strval($this->income->CurrentValue);
                if ($curVal != "") {
                    $this->income->ViewValue = $this->income->lookupCacheOption($curVal);
                    if ($this->income->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->income->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->income->Lookup->renderViewRow($rswrk[0]);
                            $this->income->ViewValue = $this->income->displayValue($arwrk);
                        } else {
                            $this->income->ViewValue = FormatNumber($this->income->CurrentValue, $this->income->formatPattern());
                        }
                    }
                } else {
                    $this->income->ViewValue = null;
                }
            }
            $this->income->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->ViewCustomAttributes = "";

            // value
            $this->value->ViewValue = $this->value->CurrentValue;
            $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
            $this->value->ViewCustomAttributes = "";

            // deferred
            if (ConvertToBool($this->deferred->CurrentValue)) {
                $this->deferred->ViewValue = $this->deferred->tagCaption(1) != "" ? $this->deferred->tagCaption(1) : "Yes";
            } else {
                $this->deferred->ViewValue = $this->deferred->tagCaption(2) != "" ? $this->deferred->tagCaption(2) : "No";
            }
            $this->deferred->ViewCustomAttributes = "";

            // amountInstallments
            $this->amountInstallments->ViewValue = $this->amountInstallments->CurrentValue;
            $this->amountInstallments->ViewValue = FormatNumber($this->amountInstallments->ViewValue, $this->amountInstallments->formatPattern());
            $this->amountInstallments->ViewCustomAttributes = "";

            // totalValueDeferred
            $this->totalValueDeferred->ViewValue = $this->totalValueDeferred->CurrentValue;
            $this->totalValueDeferred->ViewValue = FormatNumber($this->totalValueDeferred->ViewValue, $this->totalValueDeferred->formatPattern());
            $this->totalValueDeferred->ViewCustomAttributes = "";

            // firstdateInstallment
            $this->firstdateInstallment->ViewValue = $this->firstdateInstallment->CurrentValue;
            $this->firstdateInstallment->ViewValue = FormatDateTime($this->firstdateInstallment->ViewValue, $this->firstdateInstallment->formatPattern());
            $this->firstdateInstallment->ViewCustomAttributes = "";

            // actualInstallment
            $this->actualInstallment->ViewValue = $this->actualInstallment->CurrentValue;
            $this->actualInstallment->ViewValue = FormatNumber($this->actualInstallment->ViewValue, $this->actualInstallment->formatPattern());
            $this->actualInstallment->ViewCustomAttributes = "";

            // orderId
            $this->orderId->ViewValue = $this->orderId->CurrentValue;
            $curVal = strval($this->orderId->CurrentValue);
            if ($curVal != "") {
                $this->orderId->ViewValue = $this->orderId->lookupCacheOption($curVal);
                if ($this->orderId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->orderId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->orderId->Lookup->renderViewRow($rswrk[0]);
                        $this->orderId->ViewValue = $this->orderId->displayValue($arwrk);
                    } else {
                        $this->orderId->ViewValue = FormatNumber($this->orderId->CurrentValue, $this->orderId->formatPattern());
                    }
                }
            } else {
                $this->orderId->ViewValue = null;
            }
            $this->orderId->ViewCustomAttributes = "";

            // balance
            $this->balance->ViewValue = $this->balance->CurrentValue;
            $this->balance->ViewValue = FormatNumber($this->balance->ViewValue, $this->balance->formatPattern());
            $this->balance->ViewCustomAttributes = "";

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

            // debtorId
            $this->debtorId->ViewValue = $this->debtorId->CurrentValue;
            $curVal = strval($this->debtorId->CurrentValue);
            if ($curVal != "") {
                $this->debtorId->ViewValue = $this->debtorId->lookupCacheOption($curVal);
                if ($this->debtorId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->debtorId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->debtorId->Lookup->renderViewRow($rswrk[0]);
                        $this->debtorId->ViewValue = $this->debtorId->displayValue($arwrk);
                    } else {
                        $this->debtorId->ViewValue = FormatNumber($this->debtorId->CurrentValue, $this->debtorId->formatPattern());
                    }
                }
            } else {
                $this->debtorId->ViewValue = null;
            }
            $this->debtorId->ViewCustomAttributes = "";

            // accountFather
            $this->accountFather->ViewValue = $this->accountFather->CurrentValue;
            $curVal = strval($this->accountFather->CurrentValue);
            if ($curVal != "") {
                $this->accountFather->ViewValue = $this->accountFather->lookupCacheOption($curVal);
                if ($this->accountFather->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->accountFather->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->accountFather->Lookup->renderViewRow($rswrk[0]);
                        $this->accountFather->ViewValue = $this->accountFather->displayValue($arwrk);
                    } else {
                        $this->accountFather->ViewValue = FormatNumber($this->accountFather->CurrentValue, $this->accountFather->formatPattern());
                    }
                }
            } else {
                $this->accountFather->ViewValue = null;
            }
            $this->accountFather->ViewCustomAttributes = "";

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

            // lastUserId
            $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
            $curVal = strval($this->lastUserId->CurrentValue);
            if ($curVal != "") {
                $this->lastUserId->ViewValue = $this->lastUserId->lookupCacheOption($curVal);
                if ($this->lastUserId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->lastUserId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->lastUserId->Lookup->renderViewRow($rswrk[0]);
                        $this->lastUserId->ViewValue = $this->lastUserId->displayValue($arwrk);
                    } else {
                        $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->CurrentValue, $this->lastUserId->formatPattern());
                    }
                }
            } else {
                $this->lastUserId->ViewValue = null;
            }
            $this->lastUserId->ViewCustomAttributes = "";

            // register
            $this->_register->ViewValue = $this->_register->CurrentValue;
            $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
            $this->_register->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // licenseId
            $this->licenseId->ViewValue = $this->licenseId->CurrentValue;
            $this->licenseId->ViewValue = FormatNumber($this->licenseId->ViewValue, $this->licenseId->formatPattern());
            $this->licenseId->ViewCustomAttributes = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";

            // historic
            $this->historic->LinkCustomAttributes = "";
            $this->historic->HrefValue = "";

            // income
            $this->income->LinkCustomAttributes = "";
            $this->income->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // orderId
            $this->orderId->LinkCustomAttributes = "";
            $this->orderId->HrefValue = "";

            // debtorId
            $this->debtorId->LinkCustomAttributes = "";
            $this->debtorId->HrefValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // licenseId
            $this->licenseId->LinkCustomAttributes = "";
            $this->licenseId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // issue
            $this->issue->setupEditAttributes();
            $this->issue->EditCustomAttributes = "";
            $this->issue->EditValue = HtmlEncode(FormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern()));
            $this->issue->PlaceHolder = RemoveHtml($this->issue->caption());

            // due
            $this->due->setupEditAttributes();
            $this->due->EditCustomAttributes = "";
            $this->due->EditValue = HtmlEncode(FormatDateTime($this->due->CurrentValue, $this->due->formatPattern()));
            $this->due->PlaceHolder = RemoveHtml($this->due->caption());

            // historic
            $this->historic->setupEditAttributes();
            $this->historic->EditCustomAttributes = "";
            if (!$this->historic->Raw) {
                $this->historic->CurrentValue = HtmlDecode($this->historic->CurrentValue);
            }
            $this->historic->EditValue = HtmlEncode($this->historic->CurrentValue);
            $this->historic->PlaceHolder = RemoveHtml($this->historic->caption());

            // income
            $this->income->setupEditAttributes();
            $this->income->EditCustomAttributes = "";
            $curVal = trim(strval($this->income->CurrentValue));
            if ($curVal != "") {
                $this->income->ViewValue = $this->income->lookupCacheOption($curVal);
            } else {
                $this->income->ViewValue = $this->income->Lookup !== null && is_array($this->income->lookupOptions()) ? $curVal : null;
            }
            if ($this->income->ViewValue !== null) { // Load from cache
                $this->income->EditValue = array_values($this->income->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->income->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->income->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->income->EditValue = $arwrk;
            }
            $this->income->PlaceHolder = RemoveHtml($this->income->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditCustomAttributes = "";
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->CurrentValue);
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());
            if (strval($this->value->EditValue) != "" && is_numeric($this->value->EditValue)) {
                $this->value->EditValue = FormatNumber($this->value->EditValue, null);
            }

            // orderId
            $this->orderId->setupEditAttributes();
            $this->orderId->EditCustomAttributes = "";
            $this->orderId->EditValue = HtmlEncode($this->orderId->CurrentValue);
            $curVal = strval($this->orderId->CurrentValue);
            if ($curVal != "") {
                $this->orderId->EditValue = $this->orderId->lookupCacheOption($curVal);
                if ($this->orderId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->orderId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->orderId->Lookup->renderViewRow($rswrk[0]);
                        $this->orderId->EditValue = $this->orderId->displayValue($arwrk);
                    } else {
                        $this->orderId->EditValue = HtmlEncode(FormatNumber($this->orderId->CurrentValue, $this->orderId->formatPattern()));
                    }
                }
            } else {
                $this->orderId->EditValue = null;
            }
            $this->orderId->PlaceHolder = RemoveHtml($this->orderId->caption());

            // debtorId
            $this->debtorId->setupEditAttributes();
            $this->debtorId->EditCustomAttributes = "";
            $this->debtorId->EditValue = HtmlEncode($this->debtorId->CurrentValue);
            $curVal = strval($this->debtorId->CurrentValue);
            if ($curVal != "") {
                $this->debtorId->EditValue = $this->debtorId->lookupCacheOption($curVal);
                if ($this->debtorId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->debtorId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->debtorId->Lookup->renderViewRow($rswrk[0]);
                        $this->debtorId->EditValue = $this->debtorId->displayValue($arwrk);
                    } else {
                        $this->debtorId->EditValue = HtmlEncode(FormatNumber($this->debtorId->CurrentValue, $this->debtorId->formatPattern()));
                    }
                }
            } else {
                $this->debtorId->EditValue = null;
            }
            $this->debtorId->PlaceHolder = RemoveHtml($this->debtorId->caption());

            // lastUserId

            // lastUpdate

            // licenseId
            $this->licenseId->setupEditAttributes();
            $this->licenseId->EditCustomAttributes = "";
            $this->licenseId->EditValue = HtmlEncode($this->licenseId->CurrentValue);
            $this->licenseId->PlaceHolder = RemoveHtml($this->licenseId->caption());
            if (strval($this->licenseId->EditValue) != "" && is_numeric($this->licenseId->EditValue)) {
                $this->licenseId->EditValue = FormatNumber($this->licenseId->EditValue, null);
            }

            // Add refer script

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";

            // historic
            $this->historic->LinkCustomAttributes = "";
            $this->historic->HrefValue = "";

            // income
            $this->income->LinkCustomAttributes = "";
            $this->income->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // orderId
            $this->orderId->LinkCustomAttributes = "";
            $this->orderId->HrefValue = "";

            // debtorId
            $this->debtorId->LinkCustomAttributes = "";
            $this->debtorId->HrefValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // licenseId
            $this->licenseId->LinkCustomAttributes = "";
            $this->licenseId->HrefValue = "";
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
        if ($this->issue->Required) {
            if (!$this->issue->IsDetailKey && EmptyValue($this->issue->FormValue)) {
                $this->issue->addErrorMessage(str_replace("%s", $this->issue->caption(), $this->issue->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->issue->FormValue, $this->issue->formatPattern())) {
            $this->issue->addErrorMessage($this->issue->getErrorMessage(false));
        }
        if ($this->due->Required) {
            if (!$this->due->IsDetailKey && EmptyValue($this->due->FormValue)) {
                $this->due->addErrorMessage(str_replace("%s", $this->due->caption(), $this->due->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->due->FormValue, $this->due->formatPattern())) {
            $this->due->addErrorMessage($this->due->getErrorMessage(false));
        }
        if ($this->historic->Required) {
            if (!$this->historic->IsDetailKey && EmptyValue($this->historic->FormValue)) {
                $this->historic->addErrorMessage(str_replace("%s", $this->historic->caption(), $this->historic->RequiredErrorMessage));
            }
        }
        if ($this->income->Required) {
            if (!$this->income->IsDetailKey && EmptyValue($this->income->FormValue)) {
                $this->income->addErrorMessage(str_replace("%s", $this->income->caption(), $this->income->RequiredErrorMessage));
            }
        }
        if ($this->obs->Required) {
            if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
            }
        }
        if ($this->value->Required) {
            if (!$this->value->IsDetailKey && EmptyValue($this->value->FormValue)) {
                $this->value->addErrorMessage(str_replace("%s", $this->value->caption(), $this->value->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->value->FormValue)) {
            $this->value->addErrorMessage($this->value->getErrorMessage(false));
        }
        if ($this->orderId->Required) {
            if (!$this->orderId->IsDetailKey && EmptyValue($this->orderId->FormValue)) {
                $this->orderId->addErrorMessage(str_replace("%s", $this->orderId->caption(), $this->orderId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderId->FormValue)) {
            $this->orderId->addErrorMessage($this->orderId->getErrorMessage(false));
        }
        if ($this->debtorId->Required) {
            if (!$this->debtorId->IsDetailKey && EmptyValue($this->debtorId->FormValue)) {
                $this->debtorId->addErrorMessage(str_replace("%s", $this->debtorId->caption(), $this->debtorId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->debtorId->FormValue)) {
            $this->debtorId->addErrorMessage($this->debtorId->getErrorMessage(false));
        }
        if ($this->lastUserId->Required) {
            if (!$this->lastUserId->IsDetailKey && EmptyValue($this->lastUserId->FormValue)) {
                $this->lastUserId->addErrorMessage(str_replace("%s", $this->lastUserId->caption(), $this->lastUserId->RequiredErrorMessage));
            }
        }
        if ($this->lastUpdate->Required) {
            if (!$this->lastUpdate->IsDetailKey && EmptyValue($this->lastUpdate->FormValue)) {
                $this->lastUpdate->addErrorMessage(str_replace("%s", $this->lastUpdate->caption(), $this->lastUpdate->RequiredErrorMessage));
            }
        }
        if ($this->licenseId->Required) {
            if (!$this->licenseId->IsDetailKey && EmptyValue($this->licenseId->FormValue)) {
                $this->licenseId->addErrorMessage(str_replace("%s", $this->licenseId->caption(), $this->licenseId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->licenseId->FormValue)) {
            $this->licenseId->addErrorMessage($this->licenseId->getErrorMessage(false));
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("FinCreditGrid");
        if (in_array("fin_credit", $detailTblVar) && $detailPage->DetailAdd) {
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

        // issue
        $this->issue->setDbValueDef($rsnew, UnFormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern()), null, false);

        // due
        $this->due->setDbValueDef($rsnew, UnFormatDateTime($this->due->CurrentValue, $this->due->formatPattern()), null, false);

        // historic
        $this->historic->setDbValueDef($rsnew, $this->historic->CurrentValue, null, false);

        // income
        $this->income->setDbValueDef($rsnew, $this->income->CurrentValue, null, false);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, null, false);

        // value
        $this->value->setDbValueDef($rsnew, $this->value->CurrentValue, null, false);

        // orderId
        $this->orderId->setDbValueDef($rsnew, $this->orderId->CurrentValue, null, false);

        // debtorId
        $this->debtorId->setDbValueDef($rsnew, $this->debtorId->CurrentValue, null, false);

        // lastUserId
        $this->lastUserId->CurrentValue = GetLoggedUserID();
        $this->lastUserId->setDbValueDef($rsnew, $this->lastUserId->CurrentValue, null);

        // lastUpdate
        $this->lastUpdate->CurrentValue = CurrentDate();
        $this->lastUpdate->setDbValueDef($rsnew, $this->lastUpdate->CurrentValue, null);

        // licenseId
        $this->licenseId->setDbValueDef($rsnew, $this->licenseId->CurrentValue, null, false);

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
            $detailPage = Container("FinCreditGrid");
            if (in_array("fin_credit", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->accountId->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "fin_credit"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->accountId->setSessionValue(""); // Clear master key if insert failed
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
            if (in_array("fin_credit", $detailTblVar)) {
                $detailPageObj = Container("FinCreditGrid");
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
                    $detailPageObj->accountId->IsDetailKey = true;
                    $detailPageObj->accountId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->accountId->setSessionValue($detailPageObj->accountId->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FinAccountsreceivableList"), "", $this->TableVar, true);
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
                case "x_income":
                    break;
                case "x_status":
                    break;
                case "x_deferred":
                    break;
                case "x_orderId":
                    break;
                case "x__userId":
                    break;
                case "x_debtorId":
                    break;
                case "x_accountFather":
                    break;
                case "x_schoolId":
                    break;
                case "x_lastUserId":
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
