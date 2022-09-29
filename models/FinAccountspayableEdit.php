<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinAccountspayableEdit extends FinAccountspayable
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_accountspayable';

    // Page object name
    public $PageObjName = "FinAccountspayableEdit";

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

        // Table object (fin_accountspayable)
        if (!isset($GLOBALS["fin_accountspayable"]) || get_class($GLOBALS["fin_accountspayable"]) == PROJECT_NAMESPACE . "fin_accountspayable") {
            $GLOBALS["fin_accountspayable"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fin_accountspayable');
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
                $tbl = Container("fin_accountspayable");
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
                    if ($pageName == "FinAccountspayableView") {
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
		        $this->invoiceFile->OldUploadPath = "uploads/invoices/";
		        $this->invoiceFile->UploadPath = $this->invoiceFile->OldUploadPath;
		        $this->guaranteeFile->OldUploadPath = "uploads/guaranteefiles";
		        $this->guaranteeFile->UploadPath = $this->guaranteeFile->OldUploadPath;
		        $this->attachedFile->OldUploadPath = "uploads/attachedfiles/";
		        $this->attachedFile->UploadPath = $this->attachedFile->OldUploadPath;
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
    public $MultiPages; // Multi pages object

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
        $this->departamentId->setVisibility();
        $this->costCenterId->setVisibility();
        $this->historic->setVisibility();
        $this->issue->setVisibility();
        $this->due->setVisibility();
        $this->value->setVisibility();
        $this->employeeId->setVisibility();
        $this->status->Visible = false;
        $this->amountPaid->Visible = false;
        $this->creditorsId->setVisibility();
        $this->typeId->setVisibility();
        $this->obs->setVisibility();
        $this->invoiceFile->setVisibility();
        $this->guaranteeFile->setVisibility();
        $this->attachedFile->setVisibility();
        $this->deferred->Visible = false;
        $this->amountInstallments->Visible = false;
        $this->totalValueDeferred->Visible = false;
        $this->actualInstallment->Visible = false;
        $this->firstInstallmentDate->Visible = false;
        $this->accountFather->setVisibility();
        $this->_userId->Visible = false;
        $this->schoolId->Visible = false;
        $this->lastUserId->setVisibility();
        $this->registerDate->Visible = false;
        $this->lastUpdate->setVisibility();
        $this->incomeReceivable->Visible = false;
        $this->licenseId->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->departamentId);
        $this->setupLookupOptions($this->costCenterId);
        $this->setupLookupOptions($this->employeeId);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->creditorsId);
        $this->setupLookupOptions($this->typeId);
        $this->setupLookupOptions($this->deferred);
        $this->setupLookupOptions($this->_userId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->lastUserId);

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
                        $this->terminate("FinAccountspayableList"); // Return to list page
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

            // Set up detail parameters
            $this->setupDetailParms();
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
                        $this->terminate("FinAccountspayableList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("FinAccountspayableList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "FinAccountspayableList") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->invoiceFile->Upload->Index = $CurrentForm->Index;
        $this->invoiceFile->Upload->uploadFile();
        $this->invoiceFile->CurrentValue = $this->invoiceFile->Upload->FileName;
        $this->guaranteeFile->Upload->Index = $CurrentForm->Index;
        $this->guaranteeFile->Upload->uploadFile();
        $this->guaranteeFile->CurrentValue = $this->guaranteeFile->Upload->FileName;
        $this->attachedFile->Upload->Index = $CurrentForm->Index;
        $this->attachedFile->Upload->uploadFile();
        $this->attachedFile->CurrentValue = $this->attachedFile->Upload->FileName;
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

        // Check field name 'departamentId' first before field var 'x_departamentId'
        $val = $CurrentForm->hasValue("departamentId") ? $CurrentForm->getValue("departamentId") : $CurrentForm->getValue("x_departamentId");
        if (!$this->departamentId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->departamentId->Visible = false; // Disable update for API request
            } else {
                $this->departamentId->setFormValue($val);
            }
        }

        // Check field name 'costCenterId' first before field var 'x_costCenterId'
        $val = $CurrentForm->hasValue("costCenterId") ? $CurrentForm->getValue("costCenterId") : $CurrentForm->getValue("x_costCenterId");
        if (!$this->costCenterId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costCenterId->Visible = false; // Disable update for API request
            } else {
                $this->costCenterId->setFormValue($val);
            }
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

        // Check field name 'value' first before field var 'x_value'
        $val = $CurrentForm->hasValue("value") ? $CurrentForm->getValue("value") : $CurrentForm->getValue("x_value");
        if (!$this->value->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->value->Visible = false; // Disable update for API request
            } else {
                $this->value->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'employeeId' first before field var 'x_employeeId'
        $val = $CurrentForm->hasValue("employeeId") ? $CurrentForm->getValue("employeeId") : $CurrentForm->getValue("x_employeeId");
        if (!$this->employeeId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->employeeId->Visible = false; // Disable update for API request
            } else {
                $this->employeeId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'creditorsId' first before field var 'x_creditorsId'
        $val = $CurrentForm->hasValue("creditorsId") ? $CurrentForm->getValue("creditorsId") : $CurrentForm->getValue("x_creditorsId");
        if (!$this->creditorsId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->creditorsId->Visible = false; // Disable update for API request
            } else {
                $this->creditorsId->setFormValue($val);
            }
        }

        // Check field name 'typeId' first before field var 'x_typeId'
        $val = $CurrentForm->hasValue("typeId") ? $CurrentForm->getValue("typeId") : $CurrentForm->getValue("x_typeId");
        if (!$this->typeId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->typeId->Visible = false; // Disable update for API request
            } else {
                $this->typeId->setFormValue($val);
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

        // Check field name 'accountFather' first before field var 'x_accountFather'
        $val = $CurrentForm->hasValue("accountFather") ? $CurrentForm->getValue("accountFather") : $CurrentForm->getValue("x_accountFather");
        if (!$this->accountFather->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->accountFather->Visible = false; // Disable update for API request
            } else {
                $this->accountFather->setFormValue($val, true, $validate);
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
		$this->invoiceFile->OldUploadPath = "uploads/invoices/";
		$this->invoiceFile->UploadPath = $this->invoiceFile->OldUploadPath;
		$this->guaranteeFile->OldUploadPath = "uploads/guaranteefiles";
		$this->guaranteeFile->UploadPath = $this->guaranteeFile->OldUploadPath;
		$this->attachedFile->OldUploadPath = "uploads/attachedfiles/";
		$this->attachedFile->UploadPath = $this->attachedFile->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->departamentId->CurrentValue = $this->departamentId->FormValue;
        $this->costCenterId->CurrentValue = $this->costCenterId->FormValue;
        $this->historic->CurrentValue = $this->historic->FormValue;
        $this->issue->CurrentValue = $this->issue->FormValue;
        $this->issue->CurrentValue = UnFormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern());
        $this->due->CurrentValue = $this->due->FormValue;
        $this->due->CurrentValue = UnFormatDateTime($this->due->CurrentValue, $this->due->formatPattern());
        $this->value->CurrentValue = $this->value->FormValue;
        $this->employeeId->CurrentValue = $this->employeeId->FormValue;
        $this->creditorsId->CurrentValue = $this->creditorsId->FormValue;
        $this->typeId->CurrentValue = $this->typeId->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->accountFather->CurrentValue = $this->accountFather->FormValue;
        $this->lastUserId->CurrentValue = $this->lastUserId->FormValue;
        $this->lastUpdate->CurrentValue = $this->lastUpdate->FormValue;
        $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        $this->licenseId->CurrentValue = $this->licenseId->FormValue;
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
        $this->departamentId->setDbValue($row['departamentId']);
        $this->costCenterId->setDbValue($row['costCenterId']);
        $this->historic->setDbValue($row['historic']);
        $this->issue->setDbValue($row['issue']);
        $this->due->setDbValue($row['due']);
        $this->value->setDbValue($row['value']);
        $this->employeeId->setDbValue($row['employeeId']);
        $this->status->setDbValue($row['status']);
        $this->amountPaid->setDbValue($row['amountPaid']);
        $this->creditorsId->setDbValue($row['creditorsId']);
        $this->typeId->setDbValue($row['typeId']);
        $this->obs->setDbValue($row['obs']);
        $this->invoiceFile->Upload->DbValue = $row['invoiceFile'];
        $this->invoiceFile->setDbValue($this->invoiceFile->Upload->DbValue);
        $this->guaranteeFile->Upload->DbValue = $row['guaranteeFile'];
        $this->guaranteeFile->setDbValue($this->guaranteeFile->Upload->DbValue);
        $this->attachedFile->Upload->DbValue = $row['attachedFile'];
        $this->attachedFile->setDbValue($this->attachedFile->Upload->DbValue);
        $this->deferred->setDbValue($row['deferred']);
        $this->amountInstallments->setDbValue($row['amountInstallments']);
        $this->totalValueDeferred->setDbValue($row['totalValueDeferred']);
        $this->actualInstallment->setDbValue($row['actualInstallment']);
        $this->firstInstallmentDate->setDbValue($row['firstInstallmentDate']);
        $this->accountFather->setDbValue($row['accountFather']);
        $this->_userId->setDbValue($row['userId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->registerDate->setDbValue($row['registerDate']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->incomeReceivable->setDbValue($row['incomeReceivable']);
        $this->licenseId->setDbValue($row['licenseId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['departamentId'] = $this->departamentId->DefaultValue;
        $row['costCenterId'] = $this->costCenterId->DefaultValue;
        $row['historic'] = $this->historic->DefaultValue;
        $row['issue'] = $this->issue->DefaultValue;
        $row['due'] = $this->due->DefaultValue;
        $row['value'] = $this->value->DefaultValue;
        $row['employeeId'] = $this->employeeId->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['amountPaid'] = $this->amountPaid->DefaultValue;
        $row['creditorsId'] = $this->creditorsId->DefaultValue;
        $row['typeId'] = $this->typeId->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['invoiceFile'] = $this->invoiceFile->DefaultValue;
        $row['guaranteeFile'] = $this->guaranteeFile->DefaultValue;
        $row['attachedFile'] = $this->attachedFile->DefaultValue;
        $row['deferred'] = $this->deferred->DefaultValue;
        $row['amountInstallments'] = $this->amountInstallments->DefaultValue;
        $row['totalValueDeferred'] = $this->totalValueDeferred->DefaultValue;
        $row['actualInstallment'] = $this->actualInstallment->DefaultValue;
        $row['firstInstallmentDate'] = $this->firstInstallmentDate->DefaultValue;
        $row['accountFather'] = $this->accountFather->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['lastUserId'] = $this->lastUserId->DefaultValue;
        $row['registerDate'] = $this->registerDate->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['incomeReceivable'] = $this->incomeReceivable->DefaultValue;
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

        // departamentId
        $this->departamentId->RowCssClass = "row";

        // costCenterId
        $this->costCenterId->RowCssClass = "row";

        // historic
        $this->historic->RowCssClass = "row";

        // issue
        $this->issue->RowCssClass = "row";

        // due
        $this->due->RowCssClass = "row";

        // value
        $this->value->RowCssClass = "row";

        // employeeId
        $this->employeeId->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // amountPaid
        $this->amountPaid->RowCssClass = "row";

        // creditorsId
        $this->creditorsId->RowCssClass = "row";

        // typeId
        $this->typeId->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // invoiceFile
        $this->invoiceFile->RowCssClass = "row";

        // guaranteeFile
        $this->guaranteeFile->RowCssClass = "row";

        // attachedFile
        $this->attachedFile->RowCssClass = "row";

        // deferred
        $this->deferred->RowCssClass = "row";

        // amountInstallments
        $this->amountInstallments->RowCssClass = "row";

        // totalValueDeferred
        $this->totalValueDeferred->RowCssClass = "row";

        // actualInstallment
        $this->actualInstallment->RowCssClass = "row";

        // firstInstallmentDate
        $this->firstInstallmentDate->RowCssClass = "row";

        // accountFather
        $this->accountFather->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // lastUserId
        $this->lastUserId->RowCssClass = "row";

        // registerDate
        $this->registerDate->RowCssClass = "row";

        // lastUpdate
        $this->lastUpdate->RowCssClass = "row";

        // incomeReceivable
        $this->incomeReceivable->RowCssClass = "row";

        // licenseId
        $this->licenseId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // departamentId
            $curVal = strval($this->departamentId->CurrentValue);
            if ($curVal != "") {
                $this->departamentId->ViewValue = $this->departamentId->lookupCacheOption($curVal);
                if ($this->departamentId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->departamentId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->departamentId->Lookup->renderViewRow($rswrk[0]);
                        $this->departamentId->ViewValue = $this->departamentId->displayValue($arwrk);
                    } else {
                        $this->departamentId->ViewValue = FormatNumber($this->departamentId->CurrentValue, $this->departamentId->formatPattern());
                    }
                }
            } else {
                $this->departamentId->ViewValue = null;
            }
            $this->departamentId->ViewCustomAttributes = "";

            // costCenterId
            $curVal = strval($this->costCenterId->CurrentValue);
            if ($curVal != "") {
                $this->costCenterId->ViewValue = $this->costCenterId->lookupCacheOption($curVal);
                if ($this->costCenterId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->costCenterId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costCenterId->Lookup->renderViewRow($rswrk[0]);
                        $this->costCenterId->ViewValue = $this->costCenterId->displayValue($arwrk);
                    } else {
                        $this->costCenterId->ViewValue = FormatNumber($this->costCenterId->CurrentValue, $this->costCenterId->formatPattern());
                    }
                }
            } else {
                $this->costCenterId->ViewValue = null;
            }
            $this->costCenterId->ViewCustomAttributes = "";

            // historic
            $this->historic->ViewValue = $this->historic->CurrentValue;
            $this->historic->ViewCustomAttributes = "";

            // issue
            $this->issue->ViewValue = $this->issue->CurrentValue;
            $this->issue->ViewValue = FormatDateTime($this->issue->ViewValue, $this->issue->formatPattern());
            $this->issue->ViewCustomAttributes = "";

            // due
            $this->due->ViewValue = $this->due->CurrentValue;
            $this->due->ViewValue = FormatDateTime($this->due->ViewValue, $this->due->formatPattern());
            $this->due->ViewCustomAttributes = "";

            // value
            $this->value->ViewValue = $this->value->CurrentValue;
            $this->value->ViewValue = FormatNumber($this->value->ViewValue, $this->value->formatPattern());
            $this->value->ViewCustomAttributes = "";

            // employeeId
            $this->employeeId->ViewValue = $this->employeeId->CurrentValue;
            $curVal = strval($this->employeeId->CurrentValue);
            if ($curVal != "") {
                $this->employeeId->ViewValue = $this->employeeId->lookupCacheOption($curVal);
                if ($this->employeeId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->employeeId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->employeeId->Lookup->renderViewRow($rswrk[0]);
                        $this->employeeId->ViewValue = $this->employeeId->displayValue($arwrk);
                    } else {
                        $this->employeeId->ViewValue = FormatNumber($this->employeeId->CurrentValue, $this->employeeId->formatPattern());
                    }
                }
            } else {
                $this->employeeId->ViewValue = null;
            }
            $this->employeeId->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // amountPaid
            $this->amountPaid->ViewValue = $this->amountPaid->CurrentValue;
            $this->amountPaid->ViewValue = FormatNumber($this->amountPaid->ViewValue, $this->amountPaid->formatPattern());
            $this->amountPaid->ViewCustomAttributes = "";

            // creditorsId
            $curVal = strval($this->creditorsId->CurrentValue);
            if ($curVal != "") {
                $this->creditorsId->ViewValue = $this->creditorsId->lookupCacheOption($curVal);
                if ($this->creditorsId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->creditorsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->creditorsId->Lookup->renderViewRow($rswrk[0]);
                        $this->creditorsId->ViewValue = $this->creditorsId->displayValue($arwrk);
                    } else {
                        $this->creditorsId->ViewValue = FormatNumber($this->creditorsId->CurrentValue, $this->creditorsId->formatPattern());
                    }
                }
            } else {
                $this->creditorsId->ViewValue = null;
            }
            $this->creditorsId->ViewCustomAttributes = "";

            // typeId
            $curVal = strval($this->typeId->CurrentValue);
            if ($curVal != "") {
                $this->typeId->ViewValue = $this->typeId->lookupCacheOption($curVal);
                if ($this->typeId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->typeId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->typeId->Lookup->renderViewRow($rswrk[0]);
                        $this->typeId->ViewValue = $this->typeId->displayValue($arwrk);
                    } else {
                        $this->typeId->ViewValue = FormatNumber($this->typeId->CurrentValue, $this->typeId->formatPattern());
                    }
                }
            } else {
                $this->typeId->ViewValue = null;
            }
            $this->typeId->ViewCustomAttributes = "";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->ViewCustomAttributes = "";

            // invoiceFile
            $this->invoiceFile->UploadPath = "uploads/invoices/";
            if (!EmptyValue($this->invoiceFile->Upload->DbValue)) {
                $this->invoiceFile->ViewValue = $this->invoiceFile->Upload->DbValue;
            } else {
                $this->invoiceFile->ViewValue = "";
            }
            $this->invoiceFile->ViewCustomAttributes = "";

            // guaranteeFile
            $this->guaranteeFile->UploadPath = "uploads/guaranteefiles";
            if (!EmptyValue($this->guaranteeFile->Upload->DbValue)) {
                $this->guaranteeFile->ViewValue = $this->guaranteeFile->Upload->DbValue;
            } else {
                $this->guaranteeFile->ViewValue = "";
            }
            $this->guaranteeFile->ViewCustomAttributes = "";

            // attachedFile
            $this->attachedFile->UploadPath = "uploads/attachedfiles/";
            if (!EmptyValue($this->attachedFile->Upload->DbValue)) {
                $this->attachedFile->ViewValue = $this->attachedFile->Upload->DbValue;
            } else {
                $this->attachedFile->ViewValue = "";
            }
            $this->attachedFile->ViewCustomAttributes = "";

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

            // actualInstallment
            $this->actualInstallment->ViewValue = $this->actualInstallment->CurrentValue;
            $this->actualInstallment->ViewValue = FormatNumber($this->actualInstallment->ViewValue, $this->actualInstallment->formatPattern());
            $this->actualInstallment->ViewCustomAttributes = "";

            // firstInstallmentDate
            $this->firstInstallmentDate->ViewValue = $this->firstInstallmentDate->CurrentValue;
            $this->firstInstallmentDate->ViewValue = FormatDateTime($this->firstInstallmentDate->ViewValue, $this->firstInstallmentDate->formatPattern());
            $this->firstInstallmentDate->ViewCustomAttributes = "";

            // accountFather
            $this->accountFather->ViewValue = $this->accountFather->CurrentValue;
            $this->accountFather->ViewValue = FormatNumber($this->accountFather->ViewValue, $this->accountFather->formatPattern());
            $this->accountFather->ViewCustomAttributes = "";

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

            // registerDate
            $this->registerDate->ViewValue = $this->registerDate->CurrentValue;
            $this->registerDate->ViewValue = FormatDateTime($this->registerDate->ViewValue, $this->registerDate->formatPattern());
            $this->registerDate->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // incomeReceivable
            $this->incomeReceivable->ViewValue = $this->incomeReceivable->CurrentValue;
            $this->incomeReceivable->ViewValue = FormatNumber($this->incomeReceivable->ViewValue, $this->incomeReceivable->formatPattern());
            $this->incomeReceivable->ViewCustomAttributes = "";

            // licenseId
            $this->licenseId->ViewValue = $this->licenseId->CurrentValue;
            $this->licenseId->ViewValue = FormatNumber($this->licenseId->ViewValue, $this->licenseId->formatPattern());
            $this->licenseId->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // departamentId
            $this->departamentId->LinkCustomAttributes = "";
            $this->departamentId->HrefValue = "";

            // costCenterId
            $this->costCenterId->LinkCustomAttributes = "";
            $this->costCenterId->HrefValue = "";

            // historic
            $this->historic->LinkCustomAttributes = "";
            $this->historic->HrefValue = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // employeeId
            $this->employeeId->LinkCustomAttributes = "";
            $this->employeeId->HrefValue = "";

            // creditorsId
            $this->creditorsId->LinkCustomAttributes = "";
            $this->creditorsId->HrefValue = "";

            // typeId
            $this->typeId->LinkCustomAttributes = "";
            $this->typeId->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // invoiceFile
            $this->invoiceFile->LinkCustomAttributes = "";
            $this->invoiceFile->HrefValue = "";
            $this->invoiceFile->ExportHrefValue = $this->invoiceFile->UploadPath . $this->invoiceFile->Upload->DbValue;

            // guaranteeFile
            $this->guaranteeFile->LinkCustomAttributes = "";
            $this->guaranteeFile->HrefValue = "";
            $this->guaranteeFile->ExportHrefValue = $this->guaranteeFile->UploadPath . $this->guaranteeFile->Upload->DbValue;

            // attachedFile
            $this->attachedFile->LinkCustomAttributes = "";
            $this->attachedFile->HrefValue = "";
            $this->attachedFile->ExportHrefValue = $this->attachedFile->UploadPath . $this->attachedFile->Upload->DbValue;

            // accountFather
            $this->accountFather->LinkCustomAttributes = "";
            $this->accountFather->HrefValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // licenseId
            $this->licenseId->LinkCustomAttributes = "";
            $this->licenseId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // departamentId
            $this->departamentId->setupEditAttributes();
            $this->departamentId->EditCustomAttributes = "";
            $curVal = trim(strval($this->departamentId->CurrentValue));
            if ($curVal != "") {
                $this->departamentId->ViewValue = $this->departamentId->lookupCacheOption($curVal);
            } else {
                $this->departamentId->ViewValue = $this->departamentId->Lookup !== null && is_array($this->departamentId->lookupOptions()) ? $curVal : null;
            }
            if ($this->departamentId->ViewValue !== null) { // Load from cache
                $this->departamentId->EditValue = array_values($this->departamentId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->departamentId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->departamentId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->departamentId->EditValue = $arwrk;
            }
            $this->departamentId->PlaceHolder = RemoveHtml($this->departamentId->caption());

            // costCenterId
            $this->costCenterId->setupEditAttributes();
            $this->costCenterId->EditCustomAttributes = "";
            $curVal = trim(strval($this->costCenterId->CurrentValue));
            if ($curVal != "") {
                $this->costCenterId->ViewValue = $this->costCenterId->lookupCacheOption($curVal);
            } else {
                $this->costCenterId->ViewValue = $this->costCenterId->Lookup !== null && is_array($this->costCenterId->lookupOptions()) ? $curVal : null;
            }
            if ($this->costCenterId->ViewValue !== null) { // Load from cache
                $this->costCenterId->EditValue = array_values($this->costCenterId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->costCenterId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->costCenterId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->costCenterId->EditValue = $arwrk;
            }
            $this->costCenterId->PlaceHolder = RemoveHtml($this->costCenterId->caption());

            // historic
            $this->historic->setupEditAttributes();
            $this->historic->EditCustomAttributes = "";
            if (!$this->historic->Raw) {
                $this->historic->CurrentValue = HtmlDecode($this->historic->CurrentValue);
            }
            $this->historic->EditValue = HtmlEncode($this->historic->CurrentValue);
            $this->historic->PlaceHolder = RemoveHtml($this->historic->caption());

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

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->CurrentValue);
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());
            if (strval($this->value->EditValue) != "" && is_numeric($this->value->EditValue)) {
                $this->value->EditValue = FormatNumber($this->value->EditValue, null);
            }

            // employeeId
            $this->employeeId->setupEditAttributes();
            $this->employeeId->EditCustomAttributes = "";
            $this->employeeId->EditValue = HtmlEncode($this->employeeId->CurrentValue);
            $curVal = strval($this->employeeId->CurrentValue);
            if ($curVal != "") {
                $this->employeeId->EditValue = $this->employeeId->lookupCacheOption($curVal);
                if ($this->employeeId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->employeeId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->employeeId->Lookup->renderViewRow($rswrk[0]);
                        $this->employeeId->EditValue = $this->employeeId->displayValue($arwrk);
                    } else {
                        $this->employeeId->EditValue = HtmlEncode(FormatNumber($this->employeeId->CurrentValue, $this->employeeId->formatPattern()));
                    }
                }
            } else {
                $this->employeeId->EditValue = null;
            }
            $this->employeeId->PlaceHolder = RemoveHtml($this->employeeId->caption());

            // creditorsId
            $this->creditorsId->EditCustomAttributes = "";
            $curVal = trim(strval($this->creditorsId->CurrentValue));
            if ($curVal != "") {
                $this->creditorsId->ViewValue = $this->creditorsId->lookupCacheOption($curVal);
            } else {
                $this->creditorsId->ViewValue = $this->creditorsId->Lookup !== null && is_array($this->creditorsId->lookupOptions()) ? $curVal : null;
            }
            if ($this->creditorsId->ViewValue !== null) { // Load from cache
                $this->creditorsId->EditValue = array_values($this->creditorsId->lookupOptions());
                if ($this->creditorsId->ViewValue == "") {
                    $this->creditorsId->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->creditorsId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->creditorsId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->creditorsId->Lookup->renderViewRow($rswrk[0]);
                    $this->creditorsId->ViewValue = $this->creditorsId->displayValue($arwrk);
                } else {
                    $this->creditorsId->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->creditorsId->EditValue = $arwrk;
            }
            $this->creditorsId->PlaceHolder = RemoveHtml($this->creditorsId->caption());

            // typeId
            $this->typeId->setupEditAttributes();
            $this->typeId->EditCustomAttributes = "";
            $curVal = trim(strval($this->typeId->CurrentValue));
            if ($curVal != "") {
                $this->typeId->ViewValue = $this->typeId->lookupCacheOption($curVal);
            } else {
                $this->typeId->ViewValue = $this->typeId->Lookup !== null && is_array($this->typeId->lookupOptions()) ? $curVal : null;
            }
            if ($this->typeId->ViewValue !== null) { // Load from cache
                $this->typeId->EditValue = array_values($this->typeId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->typeId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->typeId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->typeId->EditValue = $arwrk;
            }
            $this->typeId->PlaceHolder = RemoveHtml($this->typeId->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditCustomAttributes = "";
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // invoiceFile
            $this->invoiceFile->setupEditAttributes();
            $this->invoiceFile->EditCustomAttributes = "";
            $this->invoiceFile->UploadPath = "uploads/invoices/";
            if (!EmptyValue($this->invoiceFile->Upload->DbValue)) {
                $this->invoiceFile->EditValue = $this->invoiceFile->Upload->DbValue;
            } else {
                $this->invoiceFile->EditValue = "";
            }
            if (!EmptyValue($this->invoiceFile->CurrentValue)) {
                $this->invoiceFile->Upload->FileName = $this->invoiceFile->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->invoiceFile);
            }

            // guaranteeFile
            $this->guaranteeFile->setupEditAttributes();
            $this->guaranteeFile->EditCustomAttributes = "";
            $this->guaranteeFile->UploadPath = "uploads/guaranteefiles";
            if (!EmptyValue($this->guaranteeFile->Upload->DbValue)) {
                $this->guaranteeFile->EditValue = $this->guaranteeFile->Upload->DbValue;
            } else {
                $this->guaranteeFile->EditValue = "";
            }
            if (!EmptyValue($this->guaranteeFile->CurrentValue)) {
                $this->guaranteeFile->Upload->FileName = $this->guaranteeFile->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->guaranteeFile);
            }

            // attachedFile
            $this->attachedFile->setupEditAttributes();
            $this->attachedFile->EditCustomAttributes = "";
            $this->attachedFile->UploadPath = "uploads/attachedfiles/";
            if (!EmptyValue($this->attachedFile->Upload->DbValue)) {
                $this->attachedFile->EditValue = $this->attachedFile->Upload->DbValue;
            } else {
                $this->attachedFile->EditValue = "";
            }
            if (!EmptyValue($this->attachedFile->CurrentValue)) {
                $this->attachedFile->Upload->FileName = $this->attachedFile->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->attachedFile);
            }

            // accountFather
            $this->accountFather->setupEditAttributes();
            $this->accountFather->EditCustomAttributes = "";
            $this->accountFather->EditValue = HtmlEncode($this->accountFather->CurrentValue);
            $this->accountFather->PlaceHolder = RemoveHtml($this->accountFather->caption());
            if (strval($this->accountFather->EditValue) != "" && is_numeric($this->accountFather->EditValue)) {
                $this->accountFather->EditValue = FormatNumber($this->accountFather->EditValue, null);
            }

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

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // departamentId
            $this->departamentId->LinkCustomAttributes = "";
            $this->departamentId->HrefValue = "";

            // costCenterId
            $this->costCenterId->LinkCustomAttributes = "";
            $this->costCenterId->HrefValue = "";

            // historic
            $this->historic->LinkCustomAttributes = "";
            $this->historic->HrefValue = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // employeeId
            $this->employeeId->LinkCustomAttributes = "";
            $this->employeeId->HrefValue = "";

            // creditorsId
            $this->creditorsId->LinkCustomAttributes = "";
            $this->creditorsId->HrefValue = "";

            // typeId
            $this->typeId->LinkCustomAttributes = "";
            $this->typeId->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // invoiceFile
            $this->invoiceFile->LinkCustomAttributes = "";
            $this->invoiceFile->HrefValue = "";
            $this->invoiceFile->ExportHrefValue = $this->invoiceFile->UploadPath . $this->invoiceFile->Upload->DbValue;

            // guaranteeFile
            $this->guaranteeFile->LinkCustomAttributes = "";
            $this->guaranteeFile->HrefValue = "";
            $this->guaranteeFile->ExportHrefValue = $this->guaranteeFile->UploadPath . $this->guaranteeFile->Upload->DbValue;

            // attachedFile
            $this->attachedFile->LinkCustomAttributes = "";
            $this->attachedFile->HrefValue = "";
            $this->attachedFile->ExportHrefValue = $this->attachedFile->UploadPath . $this->attachedFile->Upload->DbValue;

            // accountFather
            $this->accountFather->LinkCustomAttributes = "";
            $this->accountFather->HrefValue = "";

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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->departamentId->Required) {
            if (!$this->departamentId->IsDetailKey && EmptyValue($this->departamentId->FormValue)) {
                $this->departamentId->addErrorMessage(str_replace("%s", $this->departamentId->caption(), $this->departamentId->RequiredErrorMessage));
            }
        }
        if ($this->costCenterId->Required) {
            if (!$this->costCenterId->IsDetailKey && EmptyValue($this->costCenterId->FormValue)) {
                $this->costCenterId->addErrorMessage(str_replace("%s", $this->costCenterId->caption(), $this->costCenterId->RequiredErrorMessage));
            }
        }
        if ($this->historic->Required) {
            if (!$this->historic->IsDetailKey && EmptyValue($this->historic->FormValue)) {
                $this->historic->addErrorMessage(str_replace("%s", $this->historic->caption(), $this->historic->RequiredErrorMessage));
            }
        }
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
        if ($this->value->Required) {
            if (!$this->value->IsDetailKey && EmptyValue($this->value->FormValue)) {
                $this->value->addErrorMessage(str_replace("%s", $this->value->caption(), $this->value->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->value->FormValue)) {
            $this->value->addErrorMessage($this->value->getErrorMessage(false));
        }
        if ($this->employeeId->Required) {
            if (!$this->employeeId->IsDetailKey && EmptyValue($this->employeeId->FormValue)) {
                $this->employeeId->addErrorMessage(str_replace("%s", $this->employeeId->caption(), $this->employeeId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->employeeId->FormValue)) {
            $this->employeeId->addErrorMessage($this->employeeId->getErrorMessage(false));
        }
        if ($this->creditorsId->Required) {
            if (!$this->creditorsId->IsDetailKey && EmptyValue($this->creditorsId->FormValue)) {
                $this->creditorsId->addErrorMessage(str_replace("%s", $this->creditorsId->caption(), $this->creditorsId->RequiredErrorMessage));
            }
        }
        if ($this->typeId->Required) {
            if (!$this->typeId->IsDetailKey && EmptyValue($this->typeId->FormValue)) {
                $this->typeId->addErrorMessage(str_replace("%s", $this->typeId->caption(), $this->typeId->RequiredErrorMessage));
            }
        }
        if ($this->obs->Required) {
            if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
            }
        }
        if ($this->invoiceFile->Required) {
            if ($this->invoiceFile->Upload->FileName == "" && !$this->invoiceFile->Upload->KeepFile) {
                $this->invoiceFile->addErrorMessage(str_replace("%s", $this->invoiceFile->caption(), $this->invoiceFile->RequiredErrorMessage));
            }
        }
        if ($this->guaranteeFile->Required) {
            if ($this->guaranteeFile->Upload->FileName == "" && !$this->guaranteeFile->Upload->KeepFile) {
                $this->guaranteeFile->addErrorMessage(str_replace("%s", $this->guaranteeFile->caption(), $this->guaranteeFile->RequiredErrorMessage));
            }
        }
        if ($this->attachedFile->Required) {
            if ($this->attachedFile->Upload->FileName == "" && !$this->attachedFile->Upload->KeepFile) {
                $this->attachedFile->addErrorMessage(str_replace("%s", $this->attachedFile->caption(), $this->attachedFile->RequiredErrorMessage));
            }
        }
        if ($this->accountFather->Required) {
            if (!$this->accountFather->IsDetailKey && EmptyValue($this->accountFather->FormValue)) {
                $this->accountFather->addErrorMessage(str_replace("%s", $this->accountFather->caption(), $this->accountFather->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->accountFather->FormValue)) {
            $this->accountFather->addErrorMessage($this->accountFather->getErrorMessage(false));
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
        $detailPage = Container("FinDebitGrid");
        if (in_array("fin_debit", $detailTblVar) && $detailPage->DetailEdit) {
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
            $this->invoiceFile->OldUploadPath = "uploads/invoices/";
            $this->invoiceFile->UploadPath = $this->invoiceFile->OldUploadPath;
            $this->guaranteeFile->OldUploadPath = "uploads/guaranteefiles";
            $this->guaranteeFile->UploadPath = $this->guaranteeFile->OldUploadPath;
            $this->attachedFile->OldUploadPath = "uploads/attachedfiles/";
            $this->attachedFile->UploadPath = $this->attachedFile->OldUploadPath;
        }

        // Set new row
        $rsnew = [];

        // departamentId
        $this->departamentId->setDbValueDef($rsnew, $this->departamentId->CurrentValue, null, $this->departamentId->ReadOnly);

        // costCenterId
        $this->costCenterId->setDbValueDef($rsnew, $this->costCenterId->CurrentValue, null, $this->costCenterId->ReadOnly);

        // historic
        $this->historic->setDbValueDef($rsnew, $this->historic->CurrentValue, null, $this->historic->ReadOnly);

        // issue
        $this->issue->setDbValueDef($rsnew, UnFormatDateTime($this->issue->CurrentValue, $this->issue->formatPattern()), null, $this->issue->ReadOnly);

        // due
        $this->due->setDbValueDef($rsnew, UnFormatDateTime($this->due->CurrentValue, $this->due->formatPattern()), null, $this->due->ReadOnly);

        // value
        $this->value->setDbValueDef($rsnew, $this->value->CurrentValue, null, $this->value->ReadOnly);

        // employeeId
        $this->employeeId->setDbValueDef($rsnew, $this->employeeId->CurrentValue, null, $this->employeeId->ReadOnly);

        // creditorsId
        $this->creditorsId->setDbValueDef($rsnew, $this->creditorsId->CurrentValue, null, $this->creditorsId->ReadOnly);

        // typeId
        $this->typeId->setDbValueDef($rsnew, $this->typeId->CurrentValue, null, $this->typeId->ReadOnly);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, null, $this->obs->ReadOnly);

        // invoiceFile
        if ($this->invoiceFile->Visible && !$this->invoiceFile->ReadOnly && !$this->invoiceFile->Upload->KeepFile) {
            $this->invoiceFile->Upload->DbValue = $rsold['invoiceFile']; // Get original value
            if ($this->invoiceFile->Upload->FileName == "") {
                $rsnew['invoiceFile'] = null;
            } else {
                $rsnew['invoiceFile'] = $this->invoiceFile->Upload->FileName;
            }
        }

        // guaranteeFile
        if ($this->guaranteeFile->Visible && !$this->guaranteeFile->ReadOnly && !$this->guaranteeFile->Upload->KeepFile) {
            $this->guaranteeFile->Upload->DbValue = $rsold['guaranteeFile']; // Get original value
            if ($this->guaranteeFile->Upload->FileName == "") {
                $rsnew['guaranteeFile'] = null;
            } else {
                $rsnew['guaranteeFile'] = $this->guaranteeFile->Upload->FileName;
            }
        }

        // attachedFile
        if ($this->attachedFile->Visible && !$this->attachedFile->ReadOnly && !$this->attachedFile->Upload->KeepFile) {
            $this->attachedFile->Upload->DbValue = $rsold['attachedFile']; // Get original value
            if ($this->attachedFile->Upload->FileName == "") {
                $rsnew['attachedFile'] = null;
            } else {
                $rsnew['attachedFile'] = $this->attachedFile->Upload->FileName;
            }
        }

        // accountFather
        $this->accountFather->setDbValueDef($rsnew, $this->accountFather->CurrentValue, null, $this->accountFather->ReadOnly);

        // lastUserId
        $this->lastUserId->CurrentValue = GetLoggedUserID();
        $this->lastUserId->setDbValueDef($rsnew, $this->lastUserId->CurrentValue, null);

        // lastUpdate
        $this->lastUpdate->CurrentValue = CurrentDate();
        $this->lastUpdate->setDbValueDef($rsnew, $this->lastUpdate->CurrentValue, null);

        // licenseId
        $this->licenseId->setDbValueDef($rsnew, $this->licenseId->CurrentValue, null, $this->licenseId->ReadOnly);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }
        if ($this->invoiceFile->Visible && !$this->invoiceFile->Upload->KeepFile) {
            $this->invoiceFile->UploadPath = "uploads/invoices/";
            $oldFiles = EmptyValue($this->invoiceFile->Upload->DbValue) ? [] : [$this->invoiceFile->htmlDecode($this->invoiceFile->Upload->DbValue)];
            if (!EmptyValue($this->invoiceFile->Upload->FileName)) {
                $newFiles = [$this->invoiceFile->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->invoiceFile, $this->invoiceFile->Upload->Index);
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
                            $file1 = UniqueFilename($this->invoiceFile->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->invoiceFile->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->invoiceFile->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->invoiceFile->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->invoiceFile->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->invoiceFile->setDbValueDef($rsnew, $this->invoiceFile->Upload->FileName, null, $this->invoiceFile->ReadOnly);
            }
        }
        if ($this->guaranteeFile->Visible && !$this->guaranteeFile->Upload->KeepFile) {
            $this->guaranteeFile->UploadPath = "uploads/guaranteefiles";
            $oldFiles = EmptyValue($this->guaranteeFile->Upload->DbValue) ? [] : [$this->guaranteeFile->htmlDecode($this->guaranteeFile->Upload->DbValue)];
            if (!EmptyValue($this->guaranteeFile->Upload->FileName)) {
                $newFiles = [$this->guaranteeFile->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->guaranteeFile, $this->guaranteeFile->Upload->Index);
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
                            $file1 = UniqueFilename($this->guaranteeFile->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->guaranteeFile->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->guaranteeFile->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->guaranteeFile->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->guaranteeFile->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->guaranteeFile->setDbValueDef($rsnew, $this->guaranteeFile->Upload->FileName, null, $this->guaranteeFile->ReadOnly);
            }
        }
        if ($this->attachedFile->Visible && !$this->attachedFile->Upload->KeepFile) {
            $this->attachedFile->UploadPath = "uploads/attachedfiles/";
            $oldFiles = EmptyValue($this->attachedFile->Upload->DbValue) ? [] : [$this->attachedFile->htmlDecode($this->attachedFile->Upload->DbValue)];
            if (!EmptyValue($this->attachedFile->Upload->FileName)) {
                $newFiles = [$this->attachedFile->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->attachedFile, $this->attachedFile->Upload->Index);
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
                            $file1 = UniqueFilename($this->attachedFile->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->attachedFile->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->attachedFile->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->attachedFile->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->attachedFile->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->attachedFile->setDbValueDef($rsnew, $this->attachedFile->Upload->FileName, null, $this->attachedFile->ReadOnly);
            }
        }

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
                if ($this->invoiceFile->Visible && !$this->invoiceFile->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->invoiceFile->Upload->DbValue) ? [] : [$this->invoiceFile->htmlDecode($this->invoiceFile->Upload->DbValue)];
                    if (!EmptyValue($this->invoiceFile->Upload->FileName)) {
                        $newFiles = [$this->invoiceFile->Upload->FileName];
                        $newFiles2 = [$this->invoiceFile->htmlDecode($rsnew['invoiceFile'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->invoiceFile, $this->invoiceFile->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->invoiceFile->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->invoiceFile->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->guaranteeFile->Visible && !$this->guaranteeFile->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->guaranteeFile->Upload->DbValue) ? [] : [$this->guaranteeFile->htmlDecode($this->guaranteeFile->Upload->DbValue)];
                    if (!EmptyValue($this->guaranteeFile->Upload->FileName)) {
                        $newFiles = [$this->guaranteeFile->Upload->FileName];
                        $newFiles2 = [$this->guaranteeFile->htmlDecode($rsnew['guaranteeFile'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->guaranteeFile, $this->guaranteeFile->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->guaranteeFile->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->guaranteeFile->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->attachedFile->Visible && !$this->attachedFile->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->attachedFile->Upload->DbValue) ? [] : [$this->attachedFile->htmlDecode($this->attachedFile->Upload->DbValue)];
                    if (!EmptyValue($this->attachedFile->Upload->FileName)) {
                        $newFiles = [$this->attachedFile->Upload->FileName];
                        $newFiles2 = [$this->attachedFile->htmlDecode($rsnew['attachedFile'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->attachedFile, $this->attachedFile->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->attachedFile->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->attachedFile->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            if ($editRow) {
                $detailPage = Container("FinDebitGrid");
                if (in_array("fin_debit", $detailTblVar) && $detailPage->DetailEdit) {
                    $Security->loadCurrentUserLevel($this->ProjectID . "fin_debit"); // Load user level of detail table
                    $editRow = $detailPage->gridUpdate();
                    $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                }
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
                    if ($this->UseTransaction) { // Commit transaction
                        $conn->commit();
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        $conn->rollback();
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
            // invoiceFile
            CleanUploadTempPath($this->invoiceFile, $this->invoiceFile->Upload->Index);

            // guaranteeFile
            CleanUploadTempPath($this->guaranteeFile, $this->guaranteeFile->Upload->Index);

            // attachedFile
            CleanUploadTempPath($this->attachedFile, $this->attachedFile->Upload->Index);
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
            if (in_array("fin_debit", $detailTblVar)) {
                $detailPageObj = Container("FinDebitGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FinAccountspayableList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $this->MultiPages = $pages;
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
                case "x_departamentId":
                    break;
                case "x_costCenterId":
                    break;
                case "x_employeeId":
                    break;
                case "x_status":
                    break;
                case "x_creditorsId":
                    break;
                case "x_typeId":
                    break;
                case "x_deferred":
                    break;
                case "x__userId":
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
