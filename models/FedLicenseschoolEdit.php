<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedLicenseschoolEdit extends FedLicenseschool
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_licenseschool';

    // Page object name
    public $PageObjName = "FedLicenseschoolEdit";

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

        // Table object (fed_licenseschool)
        if (!isset($GLOBALS["fed_licenseschool"]) || get_class($GLOBALS["fed_licenseschool"]) == PROJECT_NAMESPACE . "fed_licenseschool") {
            $GLOBALS["fed_licenseschool"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fed_licenseschool');
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
                $tbl = Container("fed_licenseschool");
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
                    if ($pageName == "FedLicenseschoolView") {
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
        $this->application->setVisibility();
        $this->dateLicense->setVisibility();
        $this->dateStart->setVisibility();
        $this->dateFinish->setVisibility();
        $this->schooltype->setVisibility();
        $this->value->setVisibility();
        $this->installment->setVisibility();
        $this->masterSchool->Visible = false;
        $this->school->setVisibility();
        $this->_userId->setVisibility();
        $this->registerDate->setVisibility();
        $this->status->setVisibility();
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
        $this->setupLookupOptions($this->application);
        $this->setupLookupOptions($this->schooltype);
        $this->setupLookupOptions($this->value);
        $this->setupLookupOptions($this->masterSchool);
        $this->setupLookupOptions($this->school);
        $this->setupLookupOptions($this->_userId);

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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                        $this->terminate("FedLicenseschoolList"); // Return to list page
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
                        $this->terminate("FedLicenseschoolList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("FedLicenseschoolList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "FedLicenseschoolList") {
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

        // Check field name 'application' first before field var 'x_application'
        $val = $CurrentForm->hasValue("application") ? $CurrentForm->getValue("application") : $CurrentForm->getValue("x_application");
        if (!$this->application->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->application->Visible = false; // Disable update for API request
            } else {
                $this->application->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'dateLicense' first before field var 'x_dateLicense'
        $val = $CurrentForm->hasValue("dateLicense") ? $CurrentForm->getValue("dateLicense") : $CurrentForm->getValue("x_dateLicense");
        if (!$this->dateLicense->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateLicense->Visible = false; // Disable update for API request
            } else {
                $this->dateLicense->setFormValue($val, true, $validate);
            }
            $this->dateLicense->CurrentValue = UnFormatDateTime($this->dateLicense->CurrentValue, $this->dateLicense->formatPattern());
        }

        // Check field name 'dateStart' first before field var 'x_dateStart'
        $val = $CurrentForm->hasValue("dateStart") ? $CurrentForm->getValue("dateStart") : $CurrentForm->getValue("x_dateStart");
        if (!$this->dateStart->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateStart->Visible = false; // Disable update for API request
            } else {
                $this->dateStart->setFormValue($val, true, $validate);
            }
            $this->dateStart->CurrentValue = UnFormatDateTime($this->dateStart->CurrentValue, $this->dateStart->formatPattern());
        }

        // Check field name 'dateFinish' first before field var 'x_dateFinish'
        $val = $CurrentForm->hasValue("dateFinish") ? $CurrentForm->getValue("dateFinish") : $CurrentForm->getValue("x_dateFinish");
        if (!$this->dateFinish->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateFinish->Visible = false; // Disable update for API request
            } else {
                $this->dateFinish->setFormValue($val, true, $validate);
            }
            $this->dateFinish->CurrentValue = UnFormatDateTime($this->dateFinish->CurrentValue, $this->dateFinish->formatPattern());
        }

        // Check field name 'schooltype' first before field var 'x_schooltype'
        $val = $CurrentForm->hasValue("schooltype") ? $CurrentForm->getValue("schooltype") : $CurrentForm->getValue("x_schooltype");
        if (!$this->schooltype->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schooltype->Visible = false; // Disable update for API request
            } else {
                $this->schooltype->setFormValue($val);
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

        // Check field name 'installment' first before field var 'x_installment'
        $val = $CurrentForm->hasValue("installment") ? $CurrentForm->getValue("installment") : $CurrentForm->getValue("x_installment");
        if (!$this->installment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->installment->Visible = false; // Disable update for API request
            } else {
                $this->installment->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'school' first before field var 'x_school'
        $val = $CurrentForm->hasValue("school") ? $CurrentForm->getValue("school") : $CurrentForm->getValue("x_school");
        if (!$this->school->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->school->Visible = false; // Disable update for API request
            } else {
                $this->school->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'userId' first before field var 'x__userId'
        $val = $CurrentForm->hasValue("userId") ? $CurrentForm->getValue("userId") : $CurrentForm->getValue("x__userId");
        if (!$this->_userId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_userId->Visible = false; // Disable update for API request
            } else {
                $this->_userId->setFormValue($val);
            }
        }

        // Check field name 'registerDate' first before field var 'x_registerDate'
        $val = $CurrentForm->hasValue("registerDate") ? $CurrentForm->getValue("registerDate") : $CurrentForm->getValue("x_registerDate");
        if (!$this->registerDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->registerDate->Visible = false; // Disable update for API request
            } else {
                $this->registerDate->setFormValue($val);
            }
            $this->registerDate->CurrentValue = UnFormatDateTime($this->registerDate->CurrentValue, $this->registerDate->formatPattern());
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->application->CurrentValue = $this->application->FormValue;
        $this->dateLicense->CurrentValue = $this->dateLicense->FormValue;
        $this->dateLicense->CurrentValue = UnFormatDateTime($this->dateLicense->CurrentValue, $this->dateLicense->formatPattern());
        $this->dateStart->CurrentValue = $this->dateStart->FormValue;
        $this->dateStart->CurrentValue = UnFormatDateTime($this->dateStart->CurrentValue, $this->dateStart->formatPattern());
        $this->dateFinish->CurrentValue = $this->dateFinish->FormValue;
        $this->dateFinish->CurrentValue = UnFormatDateTime($this->dateFinish->CurrentValue, $this->dateFinish->formatPattern());
        $this->schooltype->CurrentValue = $this->schooltype->FormValue;
        $this->value->CurrentValue = $this->value->FormValue;
        $this->installment->CurrentValue = $this->installment->FormValue;
        $this->school->CurrentValue = $this->school->FormValue;
        $this->_userId->CurrentValue = $this->_userId->FormValue;
        $this->registerDate->CurrentValue = $this->registerDate->FormValue;
        $this->registerDate->CurrentValue = UnFormatDateTime($this->registerDate->CurrentValue, $this->registerDate->formatPattern());
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->application->setDbValue($row['application']);
        $this->dateLicense->setDbValue($row['dateLicense']);
        $this->dateStart->setDbValue($row['dateStart']);
        $this->dateFinish->setDbValue($row['dateFinish']);
        $this->schooltype->setDbValue($row['schooltype']);
        $this->value->setDbValue($row['value']);
        $this->installment->setDbValue($row['installment']);
        $this->masterSchool->setDbValue($row['masterSchool']);
        $this->school->setDbValue($row['school']);
        $this->_userId->setDbValue($row['userId']);
        $this->registerDate->setDbValue($row['registerDate']);
        $this->status->setDbValue($row['status']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['application'] = $this->application->DefaultValue;
        $row['dateLicense'] = $this->dateLicense->DefaultValue;
        $row['dateStart'] = $this->dateStart->DefaultValue;
        $row['dateFinish'] = $this->dateFinish->DefaultValue;
        $row['schooltype'] = $this->schooltype->DefaultValue;
        $row['value'] = $this->value->DefaultValue;
        $row['installment'] = $this->installment->DefaultValue;
        $row['masterSchool'] = $this->masterSchool->DefaultValue;
        $row['school'] = $this->school->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['registerDate'] = $this->registerDate->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
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

        // application
        $this->application->RowCssClass = "row";

        // dateLicense
        $this->dateLicense->RowCssClass = "row";

        // dateStart
        $this->dateStart->RowCssClass = "row";

        // dateFinish
        $this->dateFinish->RowCssClass = "row";

        // schooltype
        $this->schooltype->RowCssClass = "row";

        // value
        $this->value->RowCssClass = "row";

        // installment
        $this->installment->RowCssClass = "row";

        // masterSchool
        $this->masterSchool->RowCssClass = "row";

        // school
        $this->school->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // registerDate
        $this->registerDate->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // application
            $this->application->ViewValue = $this->application->CurrentValue;
            $curVal = strval($this->application->CurrentValue);
            if ($curVal != "") {
                $this->application->ViewValue = $this->application->lookupCacheOption($curVal);
                if ($this->application->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->application->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->application->Lookup->renderViewRow($rswrk[0]);
                        $this->application->ViewValue = $this->application->displayValue($arwrk);
                    } else {
                        $this->application->ViewValue = FormatNumber($this->application->CurrentValue, $this->application->formatPattern());
                    }
                }
            } else {
                $this->application->ViewValue = null;
            }
            $this->application->ViewCustomAttributes = "";

            // dateLicense
            $this->dateLicense->ViewValue = $this->dateLicense->CurrentValue;
            $this->dateLicense->ViewValue = FormatDateTime($this->dateLicense->ViewValue, $this->dateLicense->formatPattern());
            $this->dateLicense->ViewCustomAttributes = "";

            // dateStart
            $this->dateStart->ViewValue = $this->dateStart->CurrentValue;
            $this->dateStart->ViewValue = FormatDateTime($this->dateStart->ViewValue, $this->dateStart->formatPattern());
            $this->dateStart->ViewCustomAttributes = "";

            // dateFinish
            $this->dateFinish->ViewValue = $this->dateFinish->CurrentValue;
            $this->dateFinish->ViewValue = FormatDateTime($this->dateFinish->ViewValue, $this->dateFinish->formatPattern());
            $this->dateFinish->ViewCustomAttributes = "";

            // schooltype
            $curVal = strval($this->schooltype->CurrentValue);
            if ($curVal != "") {
                $this->schooltype->ViewValue = $this->schooltype->lookupCacheOption($curVal);
                if ($this->schooltype->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->schooltype->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->schooltype->Lookup->renderViewRow($rswrk[0]);
                        $this->schooltype->ViewValue = $this->schooltype->displayValue($arwrk);
                    } else {
                        $this->schooltype->ViewValue = FormatNumber($this->schooltype->CurrentValue, $this->schooltype->formatPattern());
                    }
                }
            } else {
                $this->schooltype->ViewValue = null;
            }
            $this->schooltype->ViewCustomAttributes = "";

            // value
            $this->value->ViewValue = $this->value->CurrentValue;
            $curVal = strval($this->value->CurrentValue);
            if ($curVal != "") {
                $this->value->ViewValue = $this->value->lookupCacheOption($curVal);
                if ($this->value->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->value->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->value->Lookup->renderViewRow($rswrk[0]);
                        $this->value->ViewValue = $this->value->displayValue($arwrk);
                    } else {
                        $this->value->ViewValue = FormatNumber($this->value->CurrentValue, $this->value->formatPattern());
                    }
                }
            } else {
                $this->value->ViewValue = null;
            }
            $this->value->ViewCustomAttributes = "";

            // installment
            $this->installment->ViewValue = $this->installment->CurrentValue;
            $this->installment->ViewValue = FormatNumber($this->installment->ViewValue, $this->installment->formatPattern());
            $this->installment->ViewCustomAttributes = "";

            // masterSchool
            $this->masterSchool->ViewValue = $this->masterSchool->CurrentValue;
            $curVal = strval($this->masterSchool->CurrentValue);
            if ($curVal != "") {
                $this->masterSchool->ViewValue = $this->masterSchool->lookupCacheOption($curVal);
                if ($this->masterSchool->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->masterSchool->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->masterSchool->Lookup->renderViewRow($rswrk[0]);
                        $this->masterSchool->ViewValue = $this->masterSchool->displayValue($arwrk);
                    } else {
                        $this->masterSchool->ViewValue = FormatNumber($this->masterSchool->CurrentValue, $this->masterSchool->formatPattern());
                    }
                }
            } else {
                $this->masterSchool->ViewValue = null;
            }
            $this->masterSchool->ViewCustomAttributes = "";

            // school
            $this->school->ViewValue = $this->school->CurrentValue;
            $curVal = strval($this->school->CurrentValue);
            if ($curVal != "") {
                $this->school->ViewValue = $this->school->lookupCacheOption($curVal);
                if ($this->school->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->school->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->school->Lookup->renderViewRow($rswrk[0]);
                        $this->school->ViewValue = $this->school->displayValue($arwrk);
                    } else {
                        $this->school->ViewValue = FormatNumber($this->school->CurrentValue, $this->school->formatPattern());
                    }
                }
            } else {
                $this->school->ViewValue = null;
            }
            $this->school->ViewCustomAttributes = "";

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

            // registerDate
            $this->registerDate->ViewValue = $this->registerDate->CurrentValue;
            $this->registerDate->ViewValue = FormatDateTime($this->registerDate->ViewValue, $this->registerDate->formatPattern());
            $this->registerDate->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // application
            $this->application->LinkCustomAttributes = "";
            $this->application->HrefValue = "";

            // dateLicense
            $this->dateLicense->LinkCustomAttributes = "";
            $this->dateLicense->HrefValue = "";

            // dateStart
            $this->dateStart->LinkCustomAttributes = "";
            $this->dateStart->HrefValue = "";

            // dateFinish
            $this->dateFinish->LinkCustomAttributes = "";
            $this->dateFinish->HrefValue = "";

            // schooltype
            $this->schooltype->LinkCustomAttributes = "";
            $this->schooltype->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // installment
            $this->installment->LinkCustomAttributes = "";
            $this->installment->HrefValue = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // userId
            $this->_userId->LinkCustomAttributes = "";
            $this->_userId->HrefValue = "";

            // registerDate
            $this->registerDate->LinkCustomAttributes = "";
            $this->registerDate->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // application
            $this->application->setupEditAttributes();
            $this->application->EditCustomAttributes = "";
            if ($this->application->getSessionValue() != "") {
                $this->application->CurrentValue = GetForeignKeyValue($this->application->getSessionValue());
                $this->application->ViewValue = $this->application->CurrentValue;
                $curVal = strval($this->application->CurrentValue);
                if ($curVal != "") {
                    $this->application->ViewValue = $this->application->lookupCacheOption($curVal);
                    if ($this->application->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->application->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->application->Lookup->renderViewRow($rswrk[0]);
                            $this->application->ViewValue = $this->application->displayValue($arwrk);
                        } else {
                            $this->application->ViewValue = FormatNumber($this->application->CurrentValue, $this->application->formatPattern());
                        }
                    }
                } else {
                    $this->application->ViewValue = null;
                }
                $this->application->ViewCustomAttributes = "";
            } else {
                $this->application->EditValue = HtmlEncode($this->application->CurrentValue);
                $curVal = strval($this->application->CurrentValue);
                if ($curVal != "") {
                    $this->application->EditValue = $this->application->lookupCacheOption($curVal);
                    if ($this->application->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->application->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->application->Lookup->renderViewRow($rswrk[0]);
                            $this->application->EditValue = $this->application->displayValue($arwrk);
                        } else {
                            $this->application->EditValue = HtmlEncode(FormatNumber($this->application->CurrentValue, $this->application->formatPattern()));
                        }
                    }
                } else {
                    $this->application->EditValue = null;
                }
                $this->application->PlaceHolder = RemoveHtml($this->application->caption());
            }

            // dateLicense
            $this->dateLicense->setupEditAttributes();
            $this->dateLicense->EditCustomAttributes = "";
            $this->dateLicense->EditValue = HtmlEncode(FormatDateTime($this->dateLicense->CurrentValue, $this->dateLicense->formatPattern()));
            $this->dateLicense->PlaceHolder = RemoveHtml($this->dateLicense->caption());

            // dateStart
            $this->dateStart->setupEditAttributes();
            $this->dateStart->EditCustomAttributes = "";
            $this->dateStart->EditValue = HtmlEncode(FormatDateTime($this->dateStart->CurrentValue, $this->dateStart->formatPattern()));
            $this->dateStart->PlaceHolder = RemoveHtml($this->dateStart->caption());

            // dateFinish
            $this->dateFinish->setupEditAttributes();
            $this->dateFinish->EditCustomAttributes = "";
            $this->dateFinish->EditValue = HtmlEncode(FormatDateTime($this->dateFinish->CurrentValue, $this->dateFinish->formatPattern()));
            $this->dateFinish->PlaceHolder = RemoveHtml($this->dateFinish->caption());

            // schooltype
            $this->schooltype->setupEditAttributes();
            $this->schooltype->EditCustomAttributes = "";
            $curVal = trim(strval($this->schooltype->CurrentValue));
            if ($curVal != "") {
                $this->schooltype->ViewValue = $this->schooltype->lookupCacheOption($curVal);
            } else {
                $this->schooltype->ViewValue = $this->schooltype->Lookup !== null && is_array($this->schooltype->lookupOptions()) ? $curVal : null;
            }
            if ($this->schooltype->ViewValue !== null) { // Load from cache
                $this->schooltype->EditValue = array_values($this->schooltype->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->schooltype->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->schooltype->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->schooltype->EditValue = $arwrk;
            }
            $this->schooltype->PlaceHolder = RemoveHtml($this->schooltype->caption());

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->CurrentValue);
            $curVal = strval($this->value->CurrentValue);
            if ($curVal != "") {
                $this->value->EditValue = $this->value->lookupCacheOption($curVal);
                if ($this->value->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->value->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->value->Lookup->renderViewRow($rswrk[0]);
                        $this->value->EditValue = $this->value->displayValue($arwrk);
                    } else {
                        $this->value->EditValue = HtmlEncode(FormatNumber($this->value->CurrentValue, $this->value->formatPattern()));
                    }
                }
            } else {
                $this->value->EditValue = null;
            }
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());

            // installment
            $this->installment->setupEditAttributes();
            $this->installment->EditCustomAttributes = "";
            $this->installment->EditValue = HtmlEncode($this->installment->CurrentValue);
            $this->installment->PlaceHolder = RemoveHtml($this->installment->caption());
            if (strval($this->installment->EditValue) != "" && is_numeric($this->installment->EditValue)) {
                $this->installment->EditValue = FormatNumber($this->installment->EditValue, null);
            }

            // school
            $this->school->setupEditAttributes();
            $this->school->EditCustomAttributes = "";
            $this->school->EditValue = HtmlEncode($this->school->CurrentValue);
            $curVal = strval($this->school->CurrentValue);
            if ($curVal != "") {
                $this->school->EditValue = $this->school->lookupCacheOption($curVal);
                if ($this->school->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->school->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->school->Lookup->renderViewRow($rswrk[0]);
                        $this->school->EditValue = $this->school->displayValue($arwrk);
                    } else {
                        $this->school->EditValue = HtmlEncode(FormatNumber($this->school->CurrentValue, $this->school->formatPattern()));
                    }
                }
            } else {
                $this->school->EditValue = null;
            }
            $this->school->PlaceHolder = RemoveHtml($this->school->caption());

            // userId

            // registerDate

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // application
            $this->application->LinkCustomAttributes = "";
            $this->application->HrefValue = "";

            // dateLicense
            $this->dateLicense->LinkCustomAttributes = "";
            $this->dateLicense->HrefValue = "";

            // dateStart
            $this->dateStart->LinkCustomAttributes = "";
            $this->dateStart->HrefValue = "";

            // dateFinish
            $this->dateFinish->LinkCustomAttributes = "";
            $this->dateFinish->HrefValue = "";

            // schooltype
            $this->schooltype->LinkCustomAttributes = "";
            $this->schooltype->HrefValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";

            // installment
            $this->installment->LinkCustomAttributes = "";
            $this->installment->HrefValue = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // userId
            $this->_userId->LinkCustomAttributes = "";
            $this->_userId->HrefValue = "";

            // registerDate
            $this->registerDate->LinkCustomAttributes = "";
            $this->registerDate->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
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
        if ($this->application->Required) {
            if (!$this->application->IsDetailKey && EmptyValue($this->application->FormValue)) {
                $this->application->addErrorMessage(str_replace("%s", $this->application->caption(), $this->application->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->application->FormValue)) {
            $this->application->addErrorMessage($this->application->getErrorMessage(false));
        }
        if ($this->dateLicense->Required) {
            if (!$this->dateLicense->IsDetailKey && EmptyValue($this->dateLicense->FormValue)) {
                $this->dateLicense->addErrorMessage(str_replace("%s", $this->dateLicense->caption(), $this->dateLicense->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateLicense->FormValue, $this->dateLicense->formatPattern())) {
            $this->dateLicense->addErrorMessage($this->dateLicense->getErrorMessage(false));
        }
        if ($this->dateStart->Required) {
            if (!$this->dateStart->IsDetailKey && EmptyValue($this->dateStart->FormValue)) {
                $this->dateStart->addErrorMessage(str_replace("%s", $this->dateStart->caption(), $this->dateStart->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateStart->FormValue, $this->dateStart->formatPattern())) {
            $this->dateStart->addErrorMessage($this->dateStart->getErrorMessage(false));
        }
        if ($this->dateFinish->Required) {
            if (!$this->dateFinish->IsDetailKey && EmptyValue($this->dateFinish->FormValue)) {
                $this->dateFinish->addErrorMessage(str_replace("%s", $this->dateFinish->caption(), $this->dateFinish->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateFinish->FormValue, $this->dateFinish->formatPattern())) {
            $this->dateFinish->addErrorMessage($this->dateFinish->getErrorMessage(false));
        }
        if ($this->schooltype->Required) {
            if (!$this->schooltype->IsDetailKey && EmptyValue($this->schooltype->FormValue)) {
                $this->schooltype->addErrorMessage(str_replace("%s", $this->schooltype->caption(), $this->schooltype->RequiredErrorMessage));
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
        if ($this->installment->Required) {
            if (!$this->installment->IsDetailKey && EmptyValue($this->installment->FormValue)) {
                $this->installment->addErrorMessage(str_replace("%s", $this->installment->caption(), $this->installment->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->installment->FormValue)) {
            $this->installment->addErrorMessage($this->installment->getErrorMessage(false));
        }
        if ($this->school->Required) {
            if (!$this->school->IsDetailKey && EmptyValue($this->school->FormValue)) {
                $this->school->addErrorMessage(str_replace("%s", $this->school->caption(), $this->school->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->school->FormValue)) {
            $this->school->addErrorMessage($this->school->getErrorMessage(false));
        }
        if ($this->_userId->Required) {
            if (!$this->_userId->IsDetailKey && EmptyValue($this->_userId->FormValue)) {
                $this->_userId->addErrorMessage(str_replace("%s", $this->_userId->caption(), $this->_userId->RequiredErrorMessage));
            }
        }
        if ($this->registerDate->Required) {
            if (!$this->registerDate->IsDetailKey && EmptyValue($this->registerDate->FormValue)) {
                $this->registerDate->addErrorMessage(str_replace("%s", $this->registerDate->caption(), $this->registerDate->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
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

        // application
        if ($this->application->getSessionValue() != "") {
            $this->application->ReadOnly = true;
        }
        $this->application->setDbValueDef($rsnew, $this->application->CurrentValue, null, $this->application->ReadOnly);

        // dateLicense
        $this->dateLicense->setDbValueDef($rsnew, UnFormatDateTime($this->dateLicense->CurrentValue, $this->dateLicense->formatPattern()), null, $this->dateLicense->ReadOnly);

        // dateStart
        $this->dateStart->setDbValueDef($rsnew, UnFormatDateTime($this->dateStart->CurrentValue, $this->dateStart->formatPattern()), null, $this->dateStart->ReadOnly);

        // dateFinish
        $this->dateFinish->setDbValueDef($rsnew, UnFormatDateTime($this->dateFinish->CurrentValue, $this->dateFinish->formatPattern()), null, $this->dateFinish->ReadOnly);

        // schooltype
        $this->schooltype->setDbValueDef($rsnew, $this->schooltype->CurrentValue, null, $this->schooltype->ReadOnly);

        // value
        $this->value->setDbValueDef($rsnew, $this->value->CurrentValue, null, $this->value->ReadOnly);

        // installment
        $this->installment->setDbValueDef($rsnew, $this->installment->CurrentValue, null, $this->installment->ReadOnly);

        // school
        $this->school->setDbValueDef($rsnew, $this->school->CurrentValue, null, $this->school->ReadOnly);

        // userId
        $this->_userId->CurrentValue = GetLoggedUserID();
        $this->_userId->setDbValueDef($rsnew, $this->_userId->CurrentValue, null);

        // registerDate
        $this->registerDate->CurrentValue = CurrentDate();
        $this->registerDate->setDbValueDef($rsnew, $this->registerDate->CurrentValue, null);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

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
            if ($masterTblVar == "fed_applicationschool") {
                $validMaster = true;
                $masterTbl = Container("fed_applicationschool");
                if (($parm = Get("fk_id", Get("application"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->application->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->application->setSessionValue($this->application->QueryStringValue);
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
            if ($masterTblVar == "fed_applicationschool") {
                $validMaster = true;
                $masterTbl = Container("fed_applicationschool");
                if (($parm = Post("fk_id", Post("application"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->application->setFormValue($masterTbl->id->FormValue);
                    $this->application->setSessionValue($this->application->FormValue);
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "fed_applicationschool") {
                if ($this->application->CurrentValue == "") {
                    $this->application->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FedLicenseschoolList"), "", $this->TableVar, true);
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
                case "x_application":
                    break;
                case "x_schooltype":
                    break;
                case "x_value":
                    break;
                case "x_masterSchool":
                    break;
                case "x_school":
                    break;
                case "x__userId":
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
