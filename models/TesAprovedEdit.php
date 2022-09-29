<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesAprovedEdit extends TesAproved
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_aproved';

    // Page object name
    public $PageObjName = "TesAprovedEdit";

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

        // Table object (tes_aproved)
        if (!isset($GLOBALS["tes_aproved"]) || get_class($GLOBALS["tes_aproved"]) == PROJECT_NAMESPACE . "tes_aproved") {
            $GLOBALS["tes_aproved"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_aproved');
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
                $tbl = Container("tes_aproved");
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
                    if ($pageName == "TesAprovedView") {
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
        $this->resultAmountId->setVisibility();
        $this->federationId->setVisibility();
        $this->schoolId->setVisibility();
        $this->testId->setVisibility();
        $this->memberId->setVisibility();
        $this->memberName->setVisibility();
        $this->createUserId->setVisibility();
        $this->createDate->setVisibility();
        $this->newRankId->setVisibility();
        $this->oldRankId->setVisibility();
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
                        $this->terminate("TesAprovedList"); // Return to list page
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
                        $this->terminate("TesAprovedList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("TesAprovedList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "TesAprovedList") {
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

        // Check field name 'resultAmountId' first before field var 'x_resultAmountId'
        $val = $CurrentForm->hasValue("resultAmountId") ? $CurrentForm->getValue("resultAmountId") : $CurrentForm->getValue("x_resultAmountId");
        if (!$this->resultAmountId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->resultAmountId->Visible = false; // Disable update for API request
            } else {
                $this->resultAmountId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'federationId' first before field var 'x_federationId'
        $val = $CurrentForm->hasValue("federationId") ? $CurrentForm->getValue("federationId") : $CurrentForm->getValue("x_federationId");
        if (!$this->federationId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->federationId->Visible = false; // Disable update for API request
            } else {
                $this->federationId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'schoolId' first before field var 'x_schoolId'
        $val = $CurrentForm->hasValue("schoolId") ? $CurrentForm->getValue("schoolId") : $CurrentForm->getValue("x_schoolId");
        if (!$this->schoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schoolId->Visible = false; // Disable update for API request
            } else {
                $this->schoolId->setFormValue($val, true, $validate);
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

        // Check field name 'memberId' first before field var 'x_memberId'
        $val = $CurrentForm->hasValue("memberId") ? $CurrentForm->getValue("memberId") : $CurrentForm->getValue("x_memberId");
        if (!$this->memberId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberId->Visible = false; // Disable update for API request
            } else {
                $this->memberId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'memberName' first before field var 'x_memberName'
        $val = $CurrentForm->hasValue("memberName") ? $CurrentForm->getValue("memberName") : $CurrentForm->getValue("x_memberName");
        if (!$this->memberName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberName->Visible = false; // Disable update for API request
            } else {
                $this->memberName->setFormValue($val);
            }
        }

        // Check field name 'createUserId' first before field var 'x_createUserId'
        $val = $CurrentForm->hasValue("createUserId") ? $CurrentForm->getValue("createUserId") : $CurrentForm->getValue("x_createUserId");
        if (!$this->createUserId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createUserId->Visible = false; // Disable update for API request
            } else {
                $this->createUserId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'createDate' first before field var 'x_createDate'
        $val = $CurrentForm->hasValue("createDate") ? $CurrentForm->getValue("createDate") : $CurrentForm->getValue("x_createDate");
        if (!$this->createDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createDate->Visible = false; // Disable update for API request
            } else {
                $this->createDate->setFormValue($val, true, $validate);
            }
            $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        }

        // Check field name 'newRankId' first before field var 'x_newRankId'
        $val = $CurrentForm->hasValue("newRankId") ? $CurrentForm->getValue("newRankId") : $CurrentForm->getValue("x_newRankId");
        if (!$this->newRankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->newRankId->Visible = false; // Disable update for API request
            } else {
                $this->newRankId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'oldRankId' first before field var 'x_oldRankId'
        $val = $CurrentForm->hasValue("oldRankId") ? $CurrentForm->getValue("oldRankId") : $CurrentForm->getValue("x_oldRankId");
        if (!$this->oldRankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->oldRankId->Visible = false; // Disable update for API request
            } else {
                $this->oldRankId->setFormValue($val, true, $validate);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->resultAmountId->CurrentValue = $this->resultAmountId->FormValue;
        $this->federationId->CurrentValue = $this->federationId->FormValue;
        $this->schoolId->CurrentValue = $this->schoolId->FormValue;
        $this->testId->CurrentValue = $this->testId->FormValue;
        $this->memberId->CurrentValue = $this->memberId->FormValue;
        $this->memberName->CurrentValue = $this->memberName->FormValue;
        $this->createUserId->CurrentValue = $this->createUserId->FormValue;
        $this->createDate->CurrentValue = $this->createDate->FormValue;
        $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->newRankId->CurrentValue = $this->newRankId->FormValue;
        $this->oldRankId->CurrentValue = $this->oldRankId->FormValue;
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
        $this->resultAmountId->setDbValue($row['resultAmountId']);
        $this->federationId->setDbValue($row['federationId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->testId->setDbValue($row['testId']);
        $this->memberId->setDbValue($row['memberId']);
        $this->memberName->setDbValue($row['memberName']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->newRankId->setDbValue($row['newRankId']);
        $this->oldRankId->setDbValue($row['oldRankId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['resultAmountId'] = $this->resultAmountId->DefaultValue;
        $row['federationId'] = $this->federationId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['testId'] = $this->testId->DefaultValue;
        $row['memberId'] = $this->memberId->DefaultValue;
        $row['memberName'] = $this->memberName->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['newRankId'] = $this->newRankId->DefaultValue;
        $row['oldRankId'] = $this->oldRankId->DefaultValue;
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

        // resultAmountId
        $this->resultAmountId->RowCssClass = "row";

        // federationId
        $this->federationId->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // testId
        $this->testId->RowCssClass = "row";

        // memberId
        $this->memberId->RowCssClass = "row";

        // memberName
        $this->memberName->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // newRankId
        $this->newRankId->RowCssClass = "row";

        // oldRankId
        $this->oldRankId->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // resultAmountId
            $this->resultAmountId->ViewValue = $this->resultAmountId->CurrentValue;
            $this->resultAmountId->ViewValue = FormatNumber($this->resultAmountId->ViewValue, $this->resultAmountId->formatPattern());
            $this->resultAmountId->ViewCustomAttributes = "";

            // federationId
            $this->federationId->ViewValue = $this->federationId->CurrentValue;
            $this->federationId->ViewValue = FormatNumber($this->federationId->ViewValue, $this->federationId->formatPattern());
            $this->federationId->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
            $this->schoolId->ViewValue = FormatNumber($this->schoolId->ViewValue, $this->schoolId->formatPattern());
            $this->schoolId->ViewCustomAttributes = "";

            // testId
            $this->testId->ViewValue = $this->testId->CurrentValue;
            $this->testId->ViewValue = FormatNumber($this->testId->ViewValue, $this->testId->formatPattern());
            $this->testId->ViewCustomAttributes = "";

            // memberId
            $this->memberId->ViewValue = $this->memberId->CurrentValue;
            $this->memberId->ViewValue = FormatNumber($this->memberId->ViewValue, $this->memberId->formatPattern());
            $this->memberId->ViewCustomAttributes = "";

            // memberName
            $this->memberName->ViewValue = $this->memberName->CurrentValue;
            $this->memberName->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // newRankId
            $this->newRankId->ViewValue = $this->newRankId->CurrentValue;
            $this->newRankId->ViewValue = FormatNumber($this->newRankId->ViewValue, $this->newRankId->formatPattern());
            $this->newRankId->ViewCustomAttributes = "";

            // oldRankId
            $this->oldRankId->ViewValue = $this->oldRankId->CurrentValue;
            $this->oldRankId->ViewValue = FormatNumber($this->oldRankId->ViewValue, $this->oldRankId->formatPattern());
            $this->oldRankId->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // resultAmountId
            $this->resultAmountId->LinkCustomAttributes = "";
            $this->resultAmountId->HrefValue = "";

            // federationId
            $this->federationId->LinkCustomAttributes = "";
            $this->federationId->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // testId
            $this->testId->LinkCustomAttributes = "";
            $this->testId->HrefValue = "";

            // memberId
            $this->memberId->LinkCustomAttributes = "";
            $this->memberId->HrefValue = "";

            // memberName
            $this->memberName->LinkCustomAttributes = "";
            $this->memberName->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // newRankId
            $this->newRankId->LinkCustomAttributes = "";
            $this->newRankId->HrefValue = "";

            // oldRankId
            $this->oldRankId->LinkCustomAttributes = "";
            $this->oldRankId->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // resultAmountId
            $this->resultAmountId->setupEditAttributes();
            $this->resultAmountId->EditCustomAttributes = "";
            $this->resultAmountId->EditValue = HtmlEncode($this->resultAmountId->CurrentValue);
            $this->resultAmountId->PlaceHolder = RemoveHtml($this->resultAmountId->caption());
            if (strval($this->resultAmountId->EditValue) != "" && is_numeric($this->resultAmountId->EditValue)) {
                $this->resultAmountId->EditValue = FormatNumber($this->resultAmountId->EditValue, null);
            }

            // federationId
            $this->federationId->setupEditAttributes();
            $this->federationId->EditCustomAttributes = "";
            $this->federationId->EditValue = HtmlEncode($this->federationId->CurrentValue);
            $this->federationId->PlaceHolder = RemoveHtml($this->federationId->caption());
            if (strval($this->federationId->EditValue) != "" && is_numeric($this->federationId->EditValue)) {
                $this->federationId->EditValue = FormatNumber($this->federationId->EditValue, null);
            }

            // schoolId
            $this->schoolId->setupEditAttributes();
            $this->schoolId->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("edit")) { // Non system admin
            } else {
                $this->schoolId->EditValue = HtmlEncode($this->schoolId->CurrentValue);
                $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
                if (strval($this->schoolId->EditValue) != "" && is_numeric($this->schoolId->EditValue)) {
                    $this->schoolId->EditValue = FormatNumber($this->schoolId->EditValue, null);
                }
            }

            // testId
            $this->testId->setupEditAttributes();
            $this->testId->EditCustomAttributes = "";
            $this->testId->EditValue = HtmlEncode($this->testId->CurrentValue);
            $this->testId->PlaceHolder = RemoveHtml($this->testId->caption());
            if (strval($this->testId->EditValue) != "" && is_numeric($this->testId->EditValue)) {
                $this->testId->EditValue = FormatNumber($this->testId->EditValue, null);
            }

            // memberId
            $this->memberId->setupEditAttributes();
            $this->memberId->EditCustomAttributes = "";
            $this->memberId->EditValue = HtmlEncode($this->memberId->CurrentValue);
            $this->memberId->PlaceHolder = RemoveHtml($this->memberId->caption());
            if (strval($this->memberId->EditValue) != "" && is_numeric($this->memberId->EditValue)) {
                $this->memberId->EditValue = FormatNumber($this->memberId->EditValue, null);
            }

            // memberName
            $this->memberName->setupEditAttributes();
            $this->memberName->EditCustomAttributes = "";
            if (!$this->memberName->Raw) {
                $this->memberName->CurrentValue = HtmlDecode($this->memberName->CurrentValue);
            }
            $this->memberName->EditValue = HtmlEncode($this->memberName->CurrentValue);
            $this->memberName->PlaceHolder = RemoveHtml($this->memberName->caption());

            // createUserId
            $this->createUserId->setupEditAttributes();
            $this->createUserId->EditCustomAttributes = "";
            $this->createUserId->EditValue = HtmlEncode($this->createUserId->CurrentValue);
            $this->createUserId->PlaceHolder = RemoveHtml($this->createUserId->caption());
            if (strval($this->createUserId->EditValue) != "" && is_numeric($this->createUserId->EditValue)) {
                $this->createUserId->EditValue = FormatNumber($this->createUserId->EditValue, null);
            }

            // createDate
            $this->createDate->setupEditAttributes();
            $this->createDate->EditCustomAttributes = "";
            $this->createDate->EditValue = HtmlEncode(FormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern()));
            $this->createDate->PlaceHolder = RemoveHtml($this->createDate->caption());

            // newRankId
            $this->newRankId->setupEditAttributes();
            $this->newRankId->EditCustomAttributes = "";
            $this->newRankId->EditValue = HtmlEncode($this->newRankId->CurrentValue);
            $this->newRankId->PlaceHolder = RemoveHtml($this->newRankId->caption());
            if (strval($this->newRankId->EditValue) != "" && is_numeric($this->newRankId->EditValue)) {
                $this->newRankId->EditValue = FormatNumber($this->newRankId->EditValue, null);
            }

            // oldRankId
            $this->oldRankId->setupEditAttributes();
            $this->oldRankId->EditCustomAttributes = "";
            $this->oldRankId->EditValue = HtmlEncode($this->oldRankId->CurrentValue);
            $this->oldRankId->PlaceHolder = RemoveHtml($this->oldRankId->caption());
            if (strval($this->oldRankId->EditValue) != "" && is_numeric($this->oldRankId->EditValue)) {
                $this->oldRankId->EditValue = FormatNumber($this->oldRankId->EditValue, null);
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // resultAmountId
            $this->resultAmountId->LinkCustomAttributes = "";
            $this->resultAmountId->HrefValue = "";

            // federationId
            $this->federationId->LinkCustomAttributes = "";
            $this->federationId->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // testId
            $this->testId->LinkCustomAttributes = "";
            $this->testId->HrefValue = "";

            // memberId
            $this->memberId->LinkCustomAttributes = "";
            $this->memberId->HrefValue = "";

            // memberName
            $this->memberName->LinkCustomAttributes = "";
            $this->memberName->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // newRankId
            $this->newRankId->LinkCustomAttributes = "";
            $this->newRankId->HrefValue = "";

            // oldRankId
            $this->oldRankId->LinkCustomAttributes = "";
            $this->oldRankId->HrefValue = "";
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
        if ($this->resultAmountId->Required) {
            if (!$this->resultAmountId->IsDetailKey && EmptyValue($this->resultAmountId->FormValue)) {
                $this->resultAmountId->addErrorMessage(str_replace("%s", $this->resultAmountId->caption(), $this->resultAmountId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->resultAmountId->FormValue)) {
            $this->resultAmountId->addErrorMessage($this->resultAmountId->getErrorMessage(false));
        }
        if ($this->federationId->Required) {
            if (!$this->federationId->IsDetailKey && EmptyValue($this->federationId->FormValue)) {
                $this->federationId->addErrorMessage(str_replace("%s", $this->federationId->caption(), $this->federationId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->federationId->FormValue)) {
            $this->federationId->addErrorMessage($this->federationId->getErrorMessage(false));
        }
        if ($this->schoolId->Required) {
            if (!$this->schoolId->IsDetailKey && EmptyValue($this->schoolId->FormValue)) {
                $this->schoolId->addErrorMessage(str_replace("%s", $this->schoolId->caption(), $this->schoolId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->schoolId->FormValue)) {
            $this->schoolId->addErrorMessage($this->schoolId->getErrorMessage(false));
        }
        if ($this->testId->Required) {
            if (!$this->testId->IsDetailKey && EmptyValue($this->testId->FormValue)) {
                $this->testId->addErrorMessage(str_replace("%s", $this->testId->caption(), $this->testId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->testId->FormValue)) {
            $this->testId->addErrorMessage($this->testId->getErrorMessage(false));
        }
        if ($this->memberId->Required) {
            if (!$this->memberId->IsDetailKey && EmptyValue($this->memberId->FormValue)) {
                $this->memberId->addErrorMessage(str_replace("%s", $this->memberId->caption(), $this->memberId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->memberId->FormValue)) {
            $this->memberId->addErrorMessage($this->memberId->getErrorMessage(false));
        }
        if ($this->memberName->Required) {
            if (!$this->memberName->IsDetailKey && EmptyValue($this->memberName->FormValue)) {
                $this->memberName->addErrorMessage(str_replace("%s", $this->memberName->caption(), $this->memberName->RequiredErrorMessage));
            }
        }
        if ($this->createUserId->Required) {
            if (!$this->createUserId->IsDetailKey && EmptyValue($this->createUserId->FormValue)) {
                $this->createUserId->addErrorMessage(str_replace("%s", $this->createUserId->caption(), $this->createUserId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->createUserId->FormValue)) {
            $this->createUserId->addErrorMessage($this->createUserId->getErrorMessage(false));
        }
        if ($this->createDate->Required) {
            if (!$this->createDate->IsDetailKey && EmptyValue($this->createDate->FormValue)) {
                $this->createDate->addErrorMessage(str_replace("%s", $this->createDate->caption(), $this->createDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->createDate->FormValue, $this->createDate->formatPattern())) {
            $this->createDate->addErrorMessage($this->createDate->getErrorMessage(false));
        }
        if ($this->newRankId->Required) {
            if (!$this->newRankId->IsDetailKey && EmptyValue($this->newRankId->FormValue)) {
                $this->newRankId->addErrorMessage(str_replace("%s", $this->newRankId->caption(), $this->newRankId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->newRankId->FormValue)) {
            $this->newRankId->addErrorMessage($this->newRankId->getErrorMessage(false));
        }
        if ($this->oldRankId->Required) {
            if (!$this->oldRankId->IsDetailKey && EmptyValue($this->oldRankId->FormValue)) {
                $this->oldRankId->addErrorMessage(str_replace("%s", $this->oldRankId->caption(), $this->oldRankId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->oldRankId->FormValue)) {
            $this->oldRankId->addErrorMessage($this->oldRankId->getErrorMessage(false));
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

        // resultAmountId
        $this->resultAmountId->setDbValueDef($rsnew, $this->resultAmountId->CurrentValue, null, $this->resultAmountId->ReadOnly);

        // federationId
        $this->federationId->setDbValueDef($rsnew, $this->federationId->CurrentValue, null, $this->federationId->ReadOnly);

        // schoolId
        $this->schoolId->setDbValueDef($rsnew, $this->schoolId->CurrentValue, null, $this->schoolId->ReadOnly);

        // testId
        $this->testId->setDbValueDef($rsnew, $this->testId->CurrentValue, null, $this->testId->ReadOnly);

        // memberId
        $this->memberId->setDbValueDef($rsnew, $this->memberId->CurrentValue, null, $this->memberId->ReadOnly);

        // memberName
        $this->memberName->setDbValueDef($rsnew, $this->memberName->CurrentValue, null, $this->memberName->ReadOnly);

        // createUserId
        $this->createUserId->setDbValueDef($rsnew, $this->createUserId->CurrentValue, null, $this->createUserId->ReadOnly);

        // createDate
        $this->createDate->setDbValueDef($rsnew, UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern()), null, $this->createDate->ReadOnly);

        // newRankId
        $this->newRankId->setDbValueDef($rsnew, $this->newRankId->CurrentValue, null, $this->newRankId->ReadOnly);

        // oldRankId
        $this->oldRankId->setDbValueDef($rsnew, $this->oldRankId->CurrentValue, null, $this->oldRankId->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TesAprovedList"), "", $this->TableVar, true);
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
