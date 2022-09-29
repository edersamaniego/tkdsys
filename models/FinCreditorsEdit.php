<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinCreditorsEdit extends FinCreditors
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_creditors';

    // Page object name
    public $PageObjName = "FinCreditorsEdit";

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

        // Table object (fin_creditors)
        if (!isset($GLOBALS["fin_creditors"]) || get_class($GLOBALS["fin_creditors"]) == PROJECT_NAMESPACE . "fin_creditors") {
            $GLOBALS["fin_creditors"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fin_creditors');
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
                $tbl = Container("fin_creditors");
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
                    if ($pageName == "FinCreditorsView") {
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->id->setVisibility();
        $this->organizationId->Visible = false;
        $this->masterSchoolId->setVisibility();
        $this->_userId->Visible = false;
        $this->schoolId->Visible = false;
        $this->creditor->setVisibility();
        $this->uniqueCode->setVisibility();
        $this->IDcode->setVisibility();
        $this->adress->setVisibility();
        $this->number->setVisibility();
        $this->neighborhood->setVisibility();
        $this->country->setVisibility();
        $this->state->setVisibility();
        $this->city->setVisibility();
        $this->telephone1->setVisibility();
        $this->telephone2->setVisibility();
        $this->website->setVisibility();
        $this->email1->setVisibility();
        $this->email2->setVisibility();
        $this->obs->setVisibility();
        $this->_register->Visible = false;
        $this->lastupdate->setVisibility();
        $this->_default->Visible = false;
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
        $this->setupLookupOptions($this->organizationId);
        $this->setupLookupOptions($this->masterSchoolId);
        $this->setupLookupOptions($this->_userId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->_default);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form";

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    if ($rs = $this->loadRecordset()) { // Load records
                        $this->TotalRecords = $rs->recordCount(); // Get record count
                    }
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("FinCreditorsList"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $rs->move($this->StartRecord - 1);
                            $loaded = true;
                        }
                    } else { // Match key values
                        if ($this->id->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->id->CurrentValue, $rs->fields['id'])) {
                                    $this->setStartRecordNumber($this->StartRecord); // Save record position
                                    $loaded = true;
                                    break;
                                } else {
                                    $this->StartRecord++;
                                    $rs->moveNext();
                                }
                            }
                        }
                    }

                    // Load current row values
                    if ($loaded) {
                        $this->loadRowValues($rs);
                    }
                } else {
                    // Load current record
                    $loaded = $this->loadRow();
                } // End modal checking
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal edit page
                    if (!$loaded) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("FinCreditorsList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("FinCreditorsList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "FinCreditorsList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this->TableVar, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_START_REC"); // Same as start record
            $this->Pager->PagePhraseId = "Record"; // Show as record
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'masterSchoolId' first before field var 'x_masterSchoolId'
        $val = $CurrentForm->hasValue("masterSchoolId") ? $CurrentForm->getValue("masterSchoolId") : $CurrentForm->getValue("x_masterSchoolId");
        if (!$this->masterSchoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->masterSchoolId->Visible = false; // Disable update for API request
            } else {
                $this->masterSchoolId->setFormValue($val);
            }
        }

        // Check field name 'creditor' first before field var 'x_creditor'
        $val = $CurrentForm->hasValue("creditor") ? $CurrentForm->getValue("creditor") : $CurrentForm->getValue("x_creditor");
        if (!$this->creditor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->creditor->Visible = false; // Disable update for API request
            } else {
                $this->creditor->setFormValue($val);
            }
        }

        // Check field name 'uniqueCode' first before field var 'x_uniqueCode'
        $val = $CurrentForm->hasValue("uniqueCode") ? $CurrentForm->getValue("uniqueCode") : $CurrentForm->getValue("x_uniqueCode");
        if (!$this->uniqueCode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->uniqueCode->Visible = false; // Disable update for API request
            } else {
                $this->uniqueCode->setFormValue($val);
            }
        }

        // Check field name 'IDcode' first before field var 'x_IDcode'
        $val = $CurrentForm->hasValue("IDcode") ? $CurrentForm->getValue("IDcode") : $CurrentForm->getValue("x_IDcode");
        if (!$this->IDcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IDcode->Visible = false; // Disable update for API request
            } else {
                $this->IDcode->setFormValue($val);
            }
        }

        // Check field name 'adress' first before field var 'x_adress'
        $val = $CurrentForm->hasValue("adress") ? $CurrentForm->getValue("adress") : $CurrentForm->getValue("x_adress");
        if (!$this->adress->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->adress->Visible = false; // Disable update for API request
            } else {
                $this->adress->setFormValue($val);
            }
        }

        // Check field name 'number' first before field var 'x_number'
        $val = $CurrentForm->hasValue("number") ? $CurrentForm->getValue("number") : $CurrentForm->getValue("x_number");
        if (!$this->number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->number->Visible = false; // Disable update for API request
            } else {
                $this->number->setFormValue($val);
            }
        }

        // Check field name 'neighborhood' first before field var 'x_neighborhood'
        $val = $CurrentForm->hasValue("neighborhood") ? $CurrentForm->getValue("neighborhood") : $CurrentForm->getValue("x_neighborhood");
        if (!$this->neighborhood->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->neighborhood->Visible = false; // Disable update for API request
            } else {
                $this->neighborhood->setFormValue($val);
            }
        }

        // Check field name 'country' first before field var 'x_country'
        $val = $CurrentForm->hasValue("country") ? $CurrentForm->getValue("country") : $CurrentForm->getValue("x_country");
        if (!$this->country->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->country->Visible = false; // Disable update for API request
            } else {
                $this->country->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'state' first before field var 'x_state'
        $val = $CurrentForm->hasValue("state") ? $CurrentForm->getValue("state") : $CurrentForm->getValue("x_state");
        if (!$this->state->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->state->Visible = false; // Disable update for API request
            } else {
                $this->state->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'city' first before field var 'x_city'
        $val = $CurrentForm->hasValue("city") ? $CurrentForm->getValue("city") : $CurrentForm->getValue("x_city");
        if (!$this->city->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->city->Visible = false; // Disable update for API request
            } else {
                $this->city->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'telephone1' first before field var 'x_telephone1'
        $val = $CurrentForm->hasValue("telephone1") ? $CurrentForm->getValue("telephone1") : $CurrentForm->getValue("x_telephone1");
        if (!$this->telephone1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telephone1->Visible = false; // Disable update for API request
            } else {
                $this->telephone1->setFormValue($val);
            }
        }

        // Check field name 'telephone2' first before field var 'x_telephone2'
        $val = $CurrentForm->hasValue("telephone2") ? $CurrentForm->getValue("telephone2") : $CurrentForm->getValue("x_telephone2");
        if (!$this->telephone2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telephone2->Visible = false; // Disable update for API request
            } else {
                $this->telephone2->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'email1' first before field var 'x_email1'
        $val = $CurrentForm->hasValue("email1") ? $CurrentForm->getValue("email1") : $CurrentForm->getValue("x_email1");
        if (!$this->email1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->email1->Visible = false; // Disable update for API request
            } else {
                $this->email1->setFormValue($val);
            }
        }

        // Check field name 'email2' first before field var 'x_email2'
        $val = $CurrentForm->hasValue("email2") ? $CurrentForm->getValue("email2") : $CurrentForm->getValue("x_email2");
        if (!$this->email2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->email2->Visible = false; // Disable update for API request
            } else {
                $this->email2->setFormValue($val);
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

        // Check field name 'lastupdate' first before field var 'x_lastupdate'
        $val = $CurrentForm->hasValue("lastupdate") ? $CurrentForm->getValue("lastupdate") : $CurrentForm->getValue("x_lastupdate");
        if (!$this->lastupdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastupdate->Visible = false; // Disable update for API request
            } else {
                $this->lastupdate->setFormValue($val);
            }
            $this->lastupdate->CurrentValue = UnFormatDateTime($this->lastupdate->CurrentValue, $this->lastupdate->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->masterSchoolId->CurrentValue = $this->masterSchoolId->FormValue;
        $this->creditor->CurrentValue = $this->creditor->FormValue;
        $this->uniqueCode->CurrentValue = $this->uniqueCode->FormValue;
        $this->IDcode->CurrentValue = $this->IDcode->FormValue;
        $this->adress->CurrentValue = $this->adress->FormValue;
        $this->number->CurrentValue = $this->number->FormValue;
        $this->neighborhood->CurrentValue = $this->neighborhood->FormValue;
        $this->country->CurrentValue = $this->country->FormValue;
        $this->state->CurrentValue = $this->state->FormValue;
        $this->city->CurrentValue = $this->city->FormValue;
        $this->telephone1->CurrentValue = $this->telephone1->FormValue;
        $this->telephone2->CurrentValue = $this->telephone2->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->email1->CurrentValue = $this->email1->FormValue;
        $this->email2->CurrentValue = $this->email2->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->lastupdate->CurrentValue = $this->lastupdate->FormValue;
        $this->lastupdate->CurrentValue = UnFormatDateTime($this->lastupdate->CurrentValue, $this->lastupdate->formatPattern());
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
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
        $this->organizationId->setDbValue($row['organizationId']);
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
        $this->_userId->setDbValue($row['userId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->creditor->setDbValue($row['creditor']);
        $this->uniqueCode->setDbValue($row['uniqueCode']);
        $this->IDcode->setDbValue($row['IDcode']);
        $this->adress->setDbValue($row['adress']);
        $this->number->setDbValue($row['number']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->country->setDbValue($row['country']);
        $this->state->setDbValue($row['state']);
        $this->city->setDbValue($row['city']);
        $this->telephone1->setDbValue($row['telephone1']);
        $this->telephone2->setDbValue($row['telephone2']);
        $this->website->setDbValue($row['website']);
        $this->email1->setDbValue($row['email1']);
        $this->email2->setDbValue($row['email2']);
        $this->obs->setDbValue($row['obs']);
        $this->_register->setDbValue($row['register']);
        $this->lastupdate->setDbValue($row['lastupdate']);
        $this->_default->setDbValue($row['default']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['organizationId'] = $this->organizationId->DefaultValue;
        $row['masterSchoolId'] = $this->masterSchoolId->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['creditor'] = $this->creditor->DefaultValue;
        $row['uniqueCode'] = $this->uniqueCode->DefaultValue;
        $row['IDcode'] = $this->IDcode->DefaultValue;
        $row['adress'] = $this->adress->DefaultValue;
        $row['number'] = $this->number->DefaultValue;
        $row['neighborhood'] = $this->neighborhood->DefaultValue;
        $row['country'] = $this->country->DefaultValue;
        $row['state'] = $this->state->DefaultValue;
        $row['city'] = $this->city->DefaultValue;
        $row['telephone1'] = $this->telephone1->DefaultValue;
        $row['telephone2'] = $this->telephone2->DefaultValue;
        $row['website'] = $this->website->DefaultValue;
        $row['email1'] = $this->email1->DefaultValue;
        $row['email2'] = $this->email2->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['register'] = $this->_register->DefaultValue;
        $row['lastupdate'] = $this->lastupdate->DefaultValue;
        $row['default'] = $this->_default->DefaultValue;
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

        // organizationId
        $this->organizationId->RowCssClass = "row";

        // masterSchoolId
        $this->masterSchoolId->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // creditor
        $this->creditor->RowCssClass = "row";

        // uniqueCode
        $this->uniqueCode->RowCssClass = "row";

        // IDcode
        $this->IDcode->RowCssClass = "row";

        // adress
        $this->adress->RowCssClass = "row";

        // number
        $this->number->RowCssClass = "row";

        // neighborhood
        $this->neighborhood->RowCssClass = "row";

        // country
        $this->country->RowCssClass = "row";

        // state
        $this->state->RowCssClass = "row";

        // city
        $this->city->RowCssClass = "row";

        // telephone1
        $this->telephone1->RowCssClass = "row";

        // telephone2
        $this->telephone2->RowCssClass = "row";

        // website
        $this->website->RowCssClass = "row";

        // email1
        $this->email1->RowCssClass = "row";

        // email2
        $this->email2->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // register
        $this->_register->RowCssClass = "row";

        // lastupdate
        $this->lastupdate->RowCssClass = "row";

        // default
        $this->_default->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // organizationId
            $this->organizationId->ViewValue = $this->organizationId->CurrentValue;
            $curVal = strval($this->organizationId->CurrentValue);
            if ($curVal != "") {
                $this->organizationId->ViewValue = $this->organizationId->lookupCacheOption($curVal);
                if ($this->organizationId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->organizationId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->organizationId->Lookup->renderViewRow($rswrk[0]);
                        $this->organizationId->ViewValue = $this->organizationId->displayValue($arwrk);
                    } else {
                        $this->organizationId->ViewValue = FormatNumber($this->organizationId->CurrentValue, $this->organizationId->formatPattern());
                    }
                }
            } else {
                $this->organizationId->ViewValue = null;
            }
            $this->organizationId->ViewCustomAttributes = "";

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

            // creditor
            $this->creditor->ViewValue = $this->creditor->CurrentValue;
            $this->creditor->ViewCustomAttributes = "";

            // uniqueCode
            $this->uniqueCode->ViewValue = $this->uniqueCode->CurrentValue;
            $this->uniqueCode->ViewCustomAttributes = "";

            // IDcode
            $this->IDcode->ViewValue = $this->IDcode->CurrentValue;
            $this->IDcode->ViewCustomAttributes = "";

            // adress
            $this->adress->ViewValue = $this->adress->CurrentValue;
            $this->adress->ViewCustomAttributes = "";

            // number
            $this->number->ViewValue = $this->number->CurrentValue;
            $this->number->ViewCustomAttributes = "";

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // country
            $this->country->ViewValue = $this->country->CurrentValue;
            $this->country->ViewValue = FormatNumber($this->country->ViewValue, $this->country->formatPattern());
            $this->country->ViewCustomAttributes = "";

            // state
            $this->state->ViewValue = $this->state->CurrentValue;
            $this->state->ViewValue = FormatNumber($this->state->ViewValue, $this->state->formatPattern());
            $this->state->ViewCustomAttributes = "";

            // city
            $this->city->ViewValue = $this->city->CurrentValue;
            $this->city->ViewValue = FormatNumber($this->city->ViewValue, $this->city->formatPattern());
            $this->city->ViewCustomAttributes = "";

            // telephone1
            $this->telephone1->ViewValue = $this->telephone1->CurrentValue;
            $this->telephone1->ViewCustomAttributes = "";

            // telephone2
            $this->telephone2->ViewValue = $this->telephone2->CurrentValue;
            $this->telephone2->ViewCustomAttributes = "";

            // website
            $this->website->ViewValue = $this->website->CurrentValue;
            $this->website->ViewCustomAttributes = "";

            // email1
            $this->email1->ViewValue = $this->email1->CurrentValue;
            $this->email1->ViewCustomAttributes = "";

            // email2
            $this->email2->ViewValue = $this->email2->CurrentValue;
            $this->email2->ViewCustomAttributes = "";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->ViewCustomAttributes = "";

            // register
            $this->_register->ViewValue = $this->_register->CurrentValue;
            $this->_register->ViewValue = FormatDateTime($this->_register->ViewValue, $this->_register->formatPattern());
            $this->_register->ViewCustomAttributes = "";

            // lastupdate
            $this->lastupdate->ViewValue = $this->lastupdate->CurrentValue;
            $this->lastupdate->ViewValue = FormatDateTime($this->lastupdate->ViewValue, $this->lastupdate->formatPattern());
            $this->lastupdate->ViewCustomAttributes = "";

            // default
            if (ConvertToBool($this->_default->CurrentValue)) {
                $this->_default->ViewValue = $this->_default->tagCaption(1) != "" ? $this->_default->tagCaption(1) : "Yes";
            } else {
                $this->_default->ViewValue = $this->_default->tagCaption(2) != "" ? $this->_default->tagCaption(2) : "No";
            }
            $this->_default->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // masterSchoolId
            $this->masterSchoolId->LinkCustomAttributes = "";
            $this->masterSchoolId->HrefValue = "";

            // creditor
            $this->creditor->LinkCustomAttributes = "";
            $this->creditor->HrefValue = "";

            // uniqueCode
            $this->uniqueCode->LinkCustomAttributes = "";
            $this->uniqueCode->HrefValue = "";

            // IDcode
            $this->IDcode->LinkCustomAttributes = "";
            $this->IDcode->HrefValue = "";

            // adress
            $this->adress->LinkCustomAttributes = "";
            $this->adress->HrefValue = "";

            // number
            $this->number->LinkCustomAttributes = "";
            $this->number->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // country
            $this->country->LinkCustomAttributes = "";
            $this->country->HrefValue = "";

            // state
            $this->state->LinkCustomAttributes = "";
            $this->state->HrefValue = "";

            // city
            $this->city->LinkCustomAttributes = "";
            $this->city->HrefValue = "";

            // telephone1
            $this->telephone1->LinkCustomAttributes = "";
            $this->telephone1->HrefValue = "";

            // telephone2
            $this->telephone2->LinkCustomAttributes = "";
            $this->telephone2->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email1
            $this->email1->LinkCustomAttributes = "";
            $this->email1->HrefValue = "";

            // email2
            $this->email2->LinkCustomAttributes = "";
            $this->email2->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // lastupdate
            $this->lastupdate->LinkCustomAttributes = "";
            $this->lastupdate->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // masterSchoolId

            // creditor
            $this->creditor->setupEditAttributes();
            $this->creditor->EditCustomAttributes = "";
            if (!$this->creditor->Raw) {
                $this->creditor->CurrentValue = HtmlDecode($this->creditor->CurrentValue);
            }
            $this->creditor->EditValue = HtmlEncode($this->creditor->CurrentValue);
            $this->creditor->PlaceHolder = RemoveHtml($this->creditor->caption());

            // uniqueCode
            $this->uniqueCode->setupEditAttributes();
            $this->uniqueCode->EditCustomAttributes = "";
            if (!$this->uniqueCode->Raw) {
                $this->uniqueCode->CurrentValue = HtmlDecode($this->uniqueCode->CurrentValue);
            }
            $this->uniqueCode->EditValue = HtmlEncode($this->uniqueCode->CurrentValue);
            $this->uniqueCode->PlaceHolder = RemoveHtml($this->uniqueCode->caption());

            // IDcode
            $this->IDcode->setupEditAttributes();
            $this->IDcode->EditCustomAttributes = "";
            if (!$this->IDcode->Raw) {
                $this->IDcode->CurrentValue = HtmlDecode($this->IDcode->CurrentValue);
            }
            $this->IDcode->EditValue = HtmlEncode($this->IDcode->CurrentValue);
            $this->IDcode->PlaceHolder = RemoveHtml($this->IDcode->caption());

            // adress
            $this->adress->setupEditAttributes();
            $this->adress->EditCustomAttributes = "";
            if (!$this->adress->Raw) {
                $this->adress->CurrentValue = HtmlDecode($this->adress->CurrentValue);
            }
            $this->adress->EditValue = HtmlEncode($this->adress->CurrentValue);
            $this->adress->PlaceHolder = RemoveHtml($this->adress->caption());

            // number
            $this->number->setupEditAttributes();
            $this->number->EditCustomAttributes = "";
            if (!$this->number->Raw) {
                $this->number->CurrentValue = HtmlDecode($this->number->CurrentValue);
            }
            $this->number->EditValue = HtmlEncode($this->number->CurrentValue);
            $this->number->PlaceHolder = RemoveHtml($this->number->caption());

            // neighborhood
            $this->neighborhood->setupEditAttributes();
            $this->neighborhood->EditCustomAttributes = "";
            if (!$this->neighborhood->Raw) {
                $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
            }
            $this->neighborhood->EditValue = HtmlEncode($this->neighborhood->CurrentValue);
            $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

            // country
            $this->country->setupEditAttributes();
            $this->country->EditCustomAttributes = "";
            $this->country->EditValue = HtmlEncode($this->country->CurrentValue);
            $this->country->PlaceHolder = RemoveHtml($this->country->caption());
            if (strval($this->country->EditValue) != "" && is_numeric($this->country->EditValue)) {
                $this->country->EditValue = FormatNumber($this->country->EditValue, null);
            }

            // state
            $this->state->setupEditAttributes();
            $this->state->EditCustomAttributes = "";
            $this->state->EditValue = HtmlEncode($this->state->CurrentValue);
            $this->state->PlaceHolder = RemoveHtml($this->state->caption());
            if (strval($this->state->EditValue) != "" && is_numeric($this->state->EditValue)) {
                $this->state->EditValue = FormatNumber($this->state->EditValue, null);
            }

            // city
            $this->city->setupEditAttributes();
            $this->city->EditCustomAttributes = "";
            $this->city->EditValue = HtmlEncode($this->city->CurrentValue);
            $this->city->PlaceHolder = RemoveHtml($this->city->caption());
            if (strval($this->city->EditValue) != "" && is_numeric($this->city->EditValue)) {
                $this->city->EditValue = FormatNumber($this->city->EditValue, null);
            }

            // telephone1
            $this->telephone1->setupEditAttributes();
            $this->telephone1->EditCustomAttributes = "";
            if (!$this->telephone1->Raw) {
                $this->telephone1->CurrentValue = HtmlDecode($this->telephone1->CurrentValue);
            }
            $this->telephone1->EditValue = HtmlEncode($this->telephone1->CurrentValue);
            $this->telephone1->PlaceHolder = RemoveHtml($this->telephone1->caption());

            // telephone2
            $this->telephone2->setupEditAttributes();
            $this->telephone2->EditCustomAttributes = "";
            if (!$this->telephone2->Raw) {
                $this->telephone2->CurrentValue = HtmlDecode($this->telephone2->CurrentValue);
            }
            $this->telephone2->EditValue = HtmlEncode($this->telephone2->CurrentValue);
            $this->telephone2->PlaceHolder = RemoveHtml($this->telephone2->caption());

            // website
            $this->website->setupEditAttributes();
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // email1
            $this->email1->setupEditAttributes();
            $this->email1->EditCustomAttributes = "";
            if (!$this->email1->Raw) {
                $this->email1->CurrentValue = HtmlDecode($this->email1->CurrentValue);
            }
            $this->email1->EditValue = HtmlEncode($this->email1->CurrentValue);
            $this->email1->PlaceHolder = RemoveHtml($this->email1->caption());

            // email2
            $this->email2->setupEditAttributes();
            $this->email2->EditCustomAttributes = "";
            if (!$this->email2->Raw) {
                $this->email2->CurrentValue = HtmlDecode($this->email2->CurrentValue);
            }
            $this->email2->EditValue = HtmlEncode($this->email2->CurrentValue);
            $this->email2->PlaceHolder = RemoveHtml($this->email2->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditCustomAttributes = "";
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // lastupdate

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // masterSchoolId
            $this->masterSchoolId->LinkCustomAttributes = "";
            $this->masterSchoolId->HrefValue = "";

            // creditor
            $this->creditor->LinkCustomAttributes = "";
            $this->creditor->HrefValue = "";

            // uniqueCode
            $this->uniqueCode->LinkCustomAttributes = "";
            $this->uniqueCode->HrefValue = "";

            // IDcode
            $this->IDcode->LinkCustomAttributes = "";
            $this->IDcode->HrefValue = "";

            // adress
            $this->adress->LinkCustomAttributes = "";
            $this->adress->HrefValue = "";

            // number
            $this->number->LinkCustomAttributes = "";
            $this->number->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // country
            $this->country->LinkCustomAttributes = "";
            $this->country->HrefValue = "";

            // state
            $this->state->LinkCustomAttributes = "";
            $this->state->HrefValue = "";

            // city
            $this->city->LinkCustomAttributes = "";
            $this->city->HrefValue = "";

            // telephone1
            $this->telephone1->LinkCustomAttributes = "";
            $this->telephone1->HrefValue = "";

            // telephone2
            $this->telephone2->LinkCustomAttributes = "";
            $this->telephone2->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email1
            $this->email1->LinkCustomAttributes = "";
            $this->email1->HrefValue = "";

            // email2
            $this->email2->LinkCustomAttributes = "";
            $this->email2->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // lastupdate
            $this->lastupdate->LinkCustomAttributes = "";
            $this->lastupdate->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->masterSchoolId->Required) {
            if (!$this->masterSchoolId->IsDetailKey && EmptyValue($this->masterSchoolId->FormValue)) {
                $this->masterSchoolId->addErrorMessage(str_replace("%s", $this->masterSchoolId->caption(), $this->masterSchoolId->RequiredErrorMessage));
            }
        }
        if ($this->creditor->Required) {
            if (!$this->creditor->IsDetailKey && EmptyValue($this->creditor->FormValue)) {
                $this->creditor->addErrorMessage(str_replace("%s", $this->creditor->caption(), $this->creditor->RequiredErrorMessage));
            }
        }
        if ($this->uniqueCode->Required) {
            if (!$this->uniqueCode->IsDetailKey && EmptyValue($this->uniqueCode->FormValue)) {
                $this->uniqueCode->addErrorMessage(str_replace("%s", $this->uniqueCode->caption(), $this->uniqueCode->RequiredErrorMessage));
            }
        }
        if ($this->IDcode->Required) {
            if (!$this->IDcode->IsDetailKey && EmptyValue($this->IDcode->FormValue)) {
                $this->IDcode->addErrorMessage(str_replace("%s", $this->IDcode->caption(), $this->IDcode->RequiredErrorMessage));
            }
        }
        if ($this->adress->Required) {
            if (!$this->adress->IsDetailKey && EmptyValue($this->adress->FormValue)) {
                $this->adress->addErrorMessage(str_replace("%s", $this->adress->caption(), $this->adress->RequiredErrorMessage));
            }
        }
        if ($this->number->Required) {
            if (!$this->number->IsDetailKey && EmptyValue($this->number->FormValue)) {
                $this->number->addErrorMessage(str_replace("%s", $this->number->caption(), $this->number->RequiredErrorMessage));
            }
        }
        if ($this->neighborhood->Required) {
            if (!$this->neighborhood->IsDetailKey && EmptyValue($this->neighborhood->FormValue)) {
                $this->neighborhood->addErrorMessage(str_replace("%s", $this->neighborhood->caption(), $this->neighborhood->RequiredErrorMessage));
            }
        }
        if ($this->country->Required) {
            if (!$this->country->IsDetailKey && EmptyValue($this->country->FormValue)) {
                $this->country->addErrorMessage(str_replace("%s", $this->country->caption(), $this->country->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->country->FormValue)) {
            $this->country->addErrorMessage($this->country->getErrorMessage(false));
        }
        if ($this->state->Required) {
            if (!$this->state->IsDetailKey && EmptyValue($this->state->FormValue)) {
                $this->state->addErrorMessage(str_replace("%s", $this->state->caption(), $this->state->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->state->FormValue)) {
            $this->state->addErrorMessage($this->state->getErrorMessage(false));
        }
        if ($this->city->Required) {
            if (!$this->city->IsDetailKey && EmptyValue($this->city->FormValue)) {
                $this->city->addErrorMessage(str_replace("%s", $this->city->caption(), $this->city->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->city->FormValue)) {
            $this->city->addErrorMessage($this->city->getErrorMessage(false));
        }
        if ($this->telephone1->Required) {
            if (!$this->telephone1->IsDetailKey && EmptyValue($this->telephone1->FormValue)) {
                $this->telephone1->addErrorMessage(str_replace("%s", $this->telephone1->caption(), $this->telephone1->RequiredErrorMessage));
            }
        }
        if ($this->telephone2->Required) {
            if (!$this->telephone2->IsDetailKey && EmptyValue($this->telephone2->FormValue)) {
                $this->telephone2->addErrorMessage(str_replace("%s", $this->telephone2->caption(), $this->telephone2->RequiredErrorMessage));
            }
        }
        if ($this->website->Required) {
            if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
            }
        }
        if ($this->email1->Required) {
            if (!$this->email1->IsDetailKey && EmptyValue($this->email1->FormValue)) {
                $this->email1->addErrorMessage(str_replace("%s", $this->email1->caption(), $this->email1->RequiredErrorMessage));
            }
        }
        if ($this->email2->Required) {
            if (!$this->email2->IsDetailKey && EmptyValue($this->email2->FormValue)) {
                $this->email2->addErrorMessage(str_replace("%s", $this->email2->caption(), $this->email2->RequiredErrorMessage));
            }
        }
        if ($this->obs->Required) {
            if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
            }
        }
        if ($this->lastupdate->Required) {
            if (!$this->lastupdate->IsDetailKey && EmptyValue($this->lastupdate->FormValue)) {
                $this->lastupdate->addErrorMessage(str_replace("%s", $this->lastupdate->caption(), $this->lastupdate->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
        }

        // Set new row
        $rsnew = [];

        // masterSchoolId
        $this->masterSchoolId->CurrentValue = CurrentUserMasterSchoolID();
        $this->masterSchoolId->setDbValueDef($rsnew, $this->masterSchoolId->CurrentValue, null);

        // creditor
        $this->creditor->setDbValueDef($rsnew, $this->creditor->CurrentValue, null, $this->creditor->ReadOnly);

        // uniqueCode
        $this->uniqueCode->setDbValueDef($rsnew, $this->uniqueCode->CurrentValue, null, $this->uniqueCode->ReadOnly);

        // IDcode
        $this->IDcode->setDbValueDef($rsnew, $this->IDcode->CurrentValue, null, $this->IDcode->ReadOnly);

        // adress
        $this->adress->setDbValueDef($rsnew, $this->adress->CurrentValue, null, $this->adress->ReadOnly);

        // number
        $this->number->setDbValueDef($rsnew, $this->number->CurrentValue, null, $this->number->ReadOnly);

        // neighborhood
        $this->neighborhood->setDbValueDef($rsnew, $this->neighborhood->CurrentValue, null, $this->neighborhood->ReadOnly);

        // country
        $this->country->setDbValueDef($rsnew, $this->country->CurrentValue, null, $this->country->ReadOnly);

        // state
        $this->state->setDbValueDef($rsnew, $this->state->CurrentValue, null, $this->state->ReadOnly);

        // city
        $this->city->setDbValueDef($rsnew, $this->city->CurrentValue, null, $this->city->ReadOnly);

        // telephone1
        $this->telephone1->setDbValueDef($rsnew, $this->telephone1->CurrentValue, null, $this->telephone1->ReadOnly);

        // telephone2
        $this->telephone2->setDbValueDef($rsnew, $this->telephone2->CurrentValue, null, $this->telephone2->ReadOnly);

        // website
        $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, null, $this->website->ReadOnly);

        // email1
        $this->email1->setDbValueDef($rsnew, $this->email1->CurrentValue, null, $this->email1->ReadOnly);

        // email2
        $this->email2->setDbValueDef($rsnew, $this->email2->CurrentValue, null, $this->email2->ReadOnly);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, null, $this->obs->ReadOnly);

        // lastupdate
        $this->lastupdate->CurrentValue = CurrentDate();
        $this->lastupdate->setDbValueDef($rsnew, $this->lastupdate->CurrentValue, null);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FinCreditorsList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_organizationId":
                    break;
                case "x_masterSchoolId":
                    break;
                case "x__userId":
                    break;
                case "x_schoolId":
                    break;
                case "x__default":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            if ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
