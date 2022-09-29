<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SchoolUsersEdit extends SchoolUsers
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'school_users';

    // Page object name
    public $PageObjName = "SchoolUsersEdit";

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

        // Table object (school_users)
        if (!isset($GLOBALS["school_users"]) || get_class($GLOBALS["school_users"]) == PROJECT_NAMESPACE . "school_users") {
            $GLOBALS["school_users"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'school_users');
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
                $tbl = Container("school_users");
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
                    if ($pageName == "SchoolUsersView") {
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
        $this->name->setVisibility();
        $this->lastName->setVisibility();
        $this->schoolIdMaster->setVisibility();
        $this->schoolId->setVisibility();
        $this->_login->setVisibility();
        $this->_email->setVisibility();
        $this->activateEmail->setVisibility();
        $this->profileField->setVisibility();
        $this->_password->setVisibility();
        $this->createUserId->setVisibility();
        $this->createDate->setVisibility();
        $this->level->setVisibility();
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
        $this->setupLookupOptions($this->schoolIdMaster);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->createUserId);
        $this->setupLookupOptions($this->level);

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
                        $this->terminate("SchoolUsersList"); // Return to list page
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
                        $this->terminate("SchoolUsersList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("SchoolUsersList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "SchoolUsersList") {
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

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'lastName' first before field var 'x_lastName'
        $val = $CurrentForm->hasValue("lastName") ? $CurrentForm->getValue("lastName") : $CurrentForm->getValue("x_lastName");
        if (!$this->lastName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastName->Visible = false; // Disable update for API request
            } else {
                $this->lastName->setFormValue($val);
            }
        }

        // Check field name 'schoolIdMaster' first before field var 'x_schoolIdMaster'
        $val = $CurrentForm->hasValue("schoolIdMaster") ? $CurrentForm->getValue("schoolIdMaster") : $CurrentForm->getValue("x_schoolIdMaster");
        if (!$this->schoolIdMaster->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schoolIdMaster->Visible = false; // Disable update for API request
            } else {
                $this->schoolIdMaster->setFormValue($val, true, $validate);
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

        // Check field name 'login' first before field var 'x__login'
        $val = $CurrentForm->hasValue("login") ? $CurrentForm->getValue("login") : $CurrentForm->getValue("x__login");
        if (!$this->_login->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_login->Visible = false; // Disable update for API request
            } else {
                $this->_login->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'activateEmail' first before field var 'x_activateEmail'
        $val = $CurrentForm->hasValue("activateEmail") ? $CurrentForm->getValue("activateEmail") : $CurrentForm->getValue("x_activateEmail");
        if (!$this->activateEmail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->activateEmail->Visible = false; // Disable update for API request
            } else {
                $this->activateEmail->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'profileField' first before field var 'x_profileField'
        $val = $CurrentForm->hasValue("profileField") ? $CurrentForm->getValue("profileField") : $CurrentForm->getValue("x_profileField");
        if (!$this->profileField->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->profileField->Visible = false; // Disable update for API request
            } else {
                $this->profileField->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'createUserId' first before field var 'x_createUserId'
        $val = $CurrentForm->hasValue("createUserId") ? $CurrentForm->getValue("createUserId") : $CurrentForm->getValue("x_createUserId");
        if (!$this->createUserId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createUserId->Visible = false; // Disable update for API request
            } else {
                $this->createUserId->setFormValue($val);
            }
        }

        // Check field name 'createDate' first before field var 'x_createDate'
        $val = $CurrentForm->hasValue("createDate") ? $CurrentForm->getValue("createDate") : $CurrentForm->getValue("x_createDate");
        if (!$this->createDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createDate->Visible = false; // Disable update for API request
            } else {
                $this->createDate->setFormValue($val);
            }
            $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        }

        // Check field name 'level' first before field var 'x_level'
        $val = $CurrentForm->hasValue("level") ? $CurrentForm->getValue("level") : $CurrentForm->getValue("x_level");
        if (!$this->level->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->level->Visible = false; // Disable update for API request
            } else {
                $this->level->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->lastName->CurrentValue = $this->lastName->FormValue;
        $this->schoolIdMaster->CurrentValue = $this->schoolIdMaster->FormValue;
        $this->schoolId->CurrentValue = $this->schoolId->FormValue;
        $this->_login->CurrentValue = $this->_login->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->activateEmail->CurrentValue = $this->activateEmail->FormValue;
        $this->profileField->CurrentValue = $this->profileField->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->createUserId->CurrentValue = $this->createUserId->FormValue;
        $this->createDate->CurrentValue = $this->createDate->FormValue;
        $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->level->CurrentValue = $this->level->FormValue;
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
        $this->name->setDbValue($row['name']);
        $this->lastName->setDbValue($row['lastName']);
        $this->schoolIdMaster->setDbValue($row['schoolIdMaster']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->_login->setDbValue($row['login']);
        $this->_email->setDbValue($row['email']);
        $this->activateEmail->setDbValue($row['activateEmail']);
        $this->profileField->setDbValue($row['profileField']);
        $this->_password->setDbValue($row['password']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->level->setDbValue($row['level']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['lastName'] = $this->lastName->DefaultValue;
        $row['schoolIdMaster'] = $this->schoolIdMaster->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['login'] = $this->_login->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['activateEmail'] = $this->activateEmail->DefaultValue;
        $row['profileField'] = $this->profileField->DefaultValue;
        $row['password'] = $this->_password->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['level'] = $this->level->DefaultValue;
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

        // name
        $this->name->RowCssClass = "row";

        // lastName
        $this->lastName->RowCssClass = "row";

        // schoolIdMaster
        $this->schoolIdMaster->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // login
        $this->_login->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // activateEmail
        $this->activateEmail->RowCssClass = "row";

        // profileField
        $this->profileField->RowCssClass = "row";

        // password
        $this->_password->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // level
        $this->level->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // lastName
            $this->lastName->ViewValue = $this->lastName->CurrentValue;
            $this->lastName->ViewCustomAttributes = "";

            // schoolIdMaster
            $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->CurrentValue;
            $curVal = strval($this->schoolIdMaster->CurrentValue);
            if ($curVal != "") {
                $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->lookupCacheOption($curVal);
                if ($this->schoolIdMaster->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`typeId`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->schoolIdMaster->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->schoolIdMaster->Lookup->renderViewRow($rswrk[0]);
                        $this->schoolIdMaster->ViewValue = $this->schoolIdMaster->displayValue($arwrk);
                    } else {
                        $this->schoolIdMaster->ViewValue = FormatNumber($this->schoolIdMaster->CurrentValue, $this->schoolIdMaster->formatPattern());
                    }
                }
            } else {
                $this->schoolIdMaster->ViewValue = null;
            }
            $this->schoolIdMaster->ViewCustomAttributes = "";

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

            // login
            $this->_login->ViewValue = $this->_login->CurrentValue;
            $this->_login->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // activateEmail
            $this->activateEmail->ViewValue = $this->activateEmail->CurrentValue;
            $this->activateEmail->ViewValue = FormatNumber($this->activateEmail->ViewValue, $this->activateEmail->formatPattern());
            $this->activateEmail->ViewCustomAttributes = "";

            // profileField
            $this->profileField->ViewValue = $this->profileField->CurrentValue;
            $this->profileField->ViewCustomAttributes = "";

            // password
            $this->_password->ViewValue = $Language->phrase("PasswordMask");
            $this->_password->ViewCustomAttributes = "";

            // createUserId
            $curVal = strval($this->createUserId->CurrentValue);
            if ($curVal != "") {
                $this->createUserId->ViewValue = $this->createUserId->lookupCacheOption($curVal);
                if ($this->createUserId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // level
            if ($Security->canAdmin()) { // System admin
                $curVal = strval($this->level->CurrentValue);
                if ($curVal != "") {
                    $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                    if ($this->level->ViewValue === null) { // Lookup from database
                        $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                            $this->level->ViewValue = $this->level->displayValue($arwrk);
                        } else {
                            $this->level->ViewValue = FormatNumber($this->level->CurrentValue, $this->level->formatPattern());
                        }
                    }
                } else {
                    $this->level->ViewValue = null;
                }
            } else {
                $this->level->ViewValue = $Language->phrase("PasswordMask");
            }
            $this->level->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";

            // schoolIdMaster
            $this->schoolIdMaster->LinkCustomAttributes = "";
            $this->schoolIdMaster->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // login
            $this->_login->LinkCustomAttributes = "";
            $this->_login->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // activateEmail
            $this->activateEmail->LinkCustomAttributes = "";
            $this->activateEmail->HrefValue = "";

            // profileField
            $this->profileField->LinkCustomAttributes = "";
            $this->profileField->HrefValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // level
            $this->level->LinkCustomAttributes = "";
            $this->level->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // name
            $this->name->setupEditAttributes();
            $this->name->EditCustomAttributes = "";
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // lastName
            $this->lastName->setupEditAttributes();
            $this->lastName->EditCustomAttributes = "";
            if (!$this->lastName->Raw) {
                $this->lastName->CurrentValue = HtmlDecode($this->lastName->CurrentValue);
            }
            $this->lastName->EditValue = HtmlEncode($this->lastName->CurrentValue);
            $this->lastName->PlaceHolder = RemoveHtml($this->lastName->caption());

            // schoolIdMaster
            $this->schoolIdMaster->setupEditAttributes();
            $this->schoolIdMaster->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
                if (SameString($this->schoolId->CurrentValue, CurrentUserID())) {
                    $this->schoolIdMaster->EditValue = $this->schoolIdMaster->CurrentValue;
                    $curVal = strval($this->schoolIdMaster->CurrentValue);
                    if ($curVal != "") {
                        $this->schoolIdMaster->EditValue = $this->schoolIdMaster->lookupCacheOption($curVal);
                        if ($this->schoolIdMaster->EditValue === null) { // Lookup from database
                            $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                            $lookupFilter = function() {
                                return "`typeId`=1";
                            };
                            $lookupFilter = $lookupFilter->bindTo($this);
                            $sqlWrk = $this->schoolIdMaster->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                            $conn = Conn();
                            $config = $conn->getConfiguration();
                            $config->setResultCacheImpl($this->Cache);
                            $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                            $ari = count($rswrk);
                            if ($ari > 0) { // Lookup values found
                                $arwrk = $this->schoolIdMaster->Lookup->renderViewRow($rswrk[0]);
                                $this->schoolIdMaster->EditValue = $this->schoolIdMaster->displayValue($arwrk);
                            } else {
                                $this->schoolIdMaster->EditValue = FormatNumber($this->schoolIdMaster->CurrentValue, $this->schoolIdMaster->formatPattern());
                            }
                        }
                    } else {
                        $this->schoolIdMaster->EditValue = null;
                    }
                    $this->schoolIdMaster->ViewCustomAttributes = "";
                } else {
                    if (trim(strval($this->schoolIdMaster->CurrentValue)) == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->schoolIdMaster->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`typeId`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->schoolIdMaster->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll();
                    $arwrk = $rswrk;
                    $this->schoolIdMaster->EditValue = $arwrk;
                }
            } else {
                $this->schoolIdMaster->EditValue = HtmlEncode($this->schoolIdMaster->CurrentValue);
                $curVal = strval($this->schoolIdMaster->CurrentValue);
                if ($curVal != "") {
                    $this->schoolIdMaster->EditValue = $this->schoolIdMaster->lookupCacheOption($curVal);
                    if ($this->schoolIdMaster->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`typeId`=1";
                        };
                        $lookupFilter = $lookupFilter->bindTo($this);
                        $sqlWrk = $this->schoolIdMaster->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->schoolIdMaster->Lookup->renderViewRow($rswrk[0]);
                            $this->schoolIdMaster->EditValue = $this->schoolIdMaster->displayValue($arwrk);
                        } else {
                            $this->schoolIdMaster->EditValue = HtmlEncode(FormatNumber($this->schoolIdMaster->CurrentValue, $this->schoolIdMaster->formatPattern()));
                        }
                    }
                } else {
                    $this->schoolIdMaster->EditValue = null;
                }
                $this->schoolIdMaster->PlaceHolder = RemoveHtml($this->schoolIdMaster->caption());
            }

            // schoolId
            $this->schoolId->setupEditAttributes();
            $this->schoolId->EditCustomAttributes = "";
            if ($this->schoolId->getSessionValue() != "") {
                $this->schoolId->CurrentValue = GetForeignKeyValue($this->schoolId->getSessionValue());
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
            } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("edit")) { // Non system admin
                if (trim(strval($this->schoolId->CurrentValue)) == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->schoolId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->schoolId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll();
                $arwrk = $rswrk;
                $this->schoolId->EditValue = $arwrk;
            } else {
                $curVal = trim(strval($this->schoolId->CurrentValue));
                if ($curVal != "") {
                    $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
                } else {
                    $this->schoolId->ViewValue = $this->schoolId->Lookup !== null && is_array($this->schoolId->lookupOptions()) ? $curVal : null;
                }
                if ($this->schoolId->ViewValue !== null) { // Load from cache
                    $this->schoolId->EditValue = array_values($this->schoolId->lookupOptions());
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
                    $arwrk = $rswrk;
                    $this->schoolId->EditValue = $arwrk;
                }
                $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
            }

            // login
            $this->_login->setupEditAttributes();
            $this->_login->EditCustomAttributes = "";
            if (!$this->_login->Raw) {
                $this->_login->CurrentValue = HtmlDecode($this->_login->CurrentValue);
            }
            $this->_login->EditValue = HtmlEncode($this->_login->CurrentValue);
            $this->_login->PlaceHolder = RemoveHtml($this->_login->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // activateEmail
            $this->activateEmail->setupEditAttributes();
            $this->activateEmail->EditCustomAttributes = "";
            $this->activateEmail->EditValue = HtmlEncode($this->activateEmail->CurrentValue);
            $this->activateEmail->PlaceHolder = RemoveHtml($this->activateEmail->caption());
            if (strval($this->activateEmail->EditValue) != "" && is_numeric($this->activateEmail->EditValue)) {
                $this->activateEmail->EditValue = FormatNumber($this->activateEmail->EditValue, null);
            }

            // profileField
            $this->profileField->setupEditAttributes();
            $this->profileField->EditCustomAttributes = "";
            $this->profileField->EditValue = HtmlEncode($this->profileField->CurrentValue);
            $this->profileField->PlaceHolder = RemoveHtml($this->profileField->caption());

            // password
            $this->_password->setupEditAttributes();
            $this->_password->EditCustomAttributes = "";
            $this->_password->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // createUserId

            // createDate

            // level
            $this->level->setupEditAttributes();
            $this->level->EditCustomAttributes = "";
            if (!$Security->canAdmin()) { // System admin
                $this->level->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->level->CurrentValue));
                if ($curVal != "") {
                    $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                } else {
                    $this->level->ViewValue = $this->level->Lookup !== null && is_array($this->level->lookupOptions()) ? $curVal : null;
                }
                if ($this->level->ViewValue !== null) { // Load from cache
                    $this->level->EditValue = array_values($this->level->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`userlevelid`" . SearchString("=", $this->level->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->level->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->level->EditValue = $arwrk;
                }
                $this->level->PlaceHolder = RemoveHtml($this->level->caption());
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";

            // schoolIdMaster
            $this->schoolIdMaster->LinkCustomAttributes = "";
            $this->schoolIdMaster->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // login
            $this->_login->LinkCustomAttributes = "";
            $this->_login->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // activateEmail
            $this->activateEmail->LinkCustomAttributes = "";
            $this->activateEmail->HrefValue = "";

            // profileField
            $this->profileField->LinkCustomAttributes = "";
            $this->profileField->HrefValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // level
            $this->level->LinkCustomAttributes = "";
            $this->level->HrefValue = "";
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
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->lastName->Required) {
            if (!$this->lastName->IsDetailKey && EmptyValue($this->lastName->FormValue)) {
                $this->lastName->addErrorMessage(str_replace("%s", $this->lastName->caption(), $this->lastName->RequiredErrorMessage));
            }
        }
        if ($this->schoolIdMaster->Required) {
            if (!$this->schoolIdMaster->IsDetailKey && EmptyValue($this->schoolIdMaster->FormValue)) {
                $this->schoolIdMaster->addErrorMessage(str_replace("%s", $this->schoolIdMaster->caption(), $this->schoolIdMaster->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->schoolIdMaster->FormValue)) {
            $this->schoolIdMaster->addErrorMessage($this->schoolIdMaster->getErrorMessage(false));
        }
        if ($this->schoolId->Required) {
            if (!$this->schoolId->IsDetailKey && EmptyValue($this->schoolId->FormValue)) {
                $this->schoolId->addErrorMessage(str_replace("%s", $this->schoolId->caption(), $this->schoolId->RequiredErrorMessage));
            }
        }
        if ($this->_login->Required) {
            if (!$this->_login->IsDetailKey && EmptyValue($this->_login->FormValue)) {
                $this->_login->addErrorMessage(str_replace("%s", $this->_login->caption(), $this->_login->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if (!$this->_email->Raw && Config("REMOVE_XSS") && CheckUsername($this->_email->FormValue)) {
            $this->_email->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->activateEmail->Required) {
            if (!$this->activateEmail->IsDetailKey && EmptyValue($this->activateEmail->FormValue)) {
                $this->activateEmail->addErrorMessage(str_replace("%s", $this->activateEmail->caption(), $this->activateEmail->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->activateEmail->FormValue)) {
            $this->activateEmail->addErrorMessage($this->activateEmail->getErrorMessage(false));
        }
        if ($this->profileField->Required) {
            if (!$this->profileField->IsDetailKey && EmptyValue($this->profileField->FormValue)) {
                $this->profileField->addErrorMessage(str_replace("%s", $this->profileField->caption(), $this->profileField->RequiredErrorMessage));
            }
        }
        if ($this->_password->Required) {
            if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
            }
        }
        if (!$this->_password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_password->FormValue)) {
            $this->_password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->createUserId->Required) {
            if (!$this->createUserId->IsDetailKey && EmptyValue($this->createUserId->FormValue)) {
                $this->createUserId->addErrorMessage(str_replace("%s", $this->createUserId->caption(), $this->createUserId->RequiredErrorMessage));
            }
        }
        if ($this->createDate->Required) {
            if (!$this->createDate->IsDetailKey && EmptyValue($this->createDate->FormValue)) {
                $this->createDate->addErrorMessage(str_replace("%s", $this->createDate->caption(), $this->createDate->RequiredErrorMessage));
            }
        }
        if ($this->level->Required) {
            if (!$this->level->IsDetailKey && EmptyValue($this->level->FormValue)) {
                $this->level->addErrorMessage(str_replace("%s", $this->level->caption(), $this->level->RequiredErrorMessage));
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

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, null, $this->name->ReadOnly);

        // lastName
        $this->lastName->setDbValueDef($rsnew, $this->lastName->CurrentValue, null, $this->lastName->ReadOnly);

        // schoolIdMaster
        $this->schoolIdMaster->setDbValueDef($rsnew, $this->schoolIdMaster->CurrentValue, null, $this->schoolIdMaster->ReadOnly);

        // schoolId
        if ($this->schoolId->getSessionValue() != "") {
            $this->schoolId->ReadOnly = true;
        }
        $this->schoolId->setDbValueDef($rsnew, $this->schoolId->CurrentValue, null, $this->schoolId->ReadOnly);

        // login
        $this->_login->setDbValueDef($rsnew, $this->_login->CurrentValue, null, $this->_login->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

        // activateEmail
        $this->activateEmail->setDbValueDef($rsnew, $this->activateEmail->CurrentValue, null, $this->activateEmail->ReadOnly);

        // profileField
        $this->profileField->setDbValueDef($rsnew, $this->profileField->CurrentValue, null, $this->profileField->ReadOnly);

        // password
        if (!IsMaskedPassword($this->_password->CurrentValue)) {
            $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, null, $this->_password->ReadOnly || Config("ENCRYPTED_PASSWORD") && $rsold['password'] == $this->_password->CurrentValue);
        }

        // createUserId
        $this->createUserId->CurrentValue = CurrentUserID();
        $this->createUserId->setDbValueDef($rsnew, $this->createUserId->CurrentValue, null);

        // createDate
        $this->createDate->CurrentValue = CurrentDate();
        $this->createDate->setDbValueDef($rsnew, $this->createDate->CurrentValue, null);

        // level
        if ($Security->canAdmin()) { // System admin
            $this->level->setDbValueDef($rsnew, $this->level->CurrentValue, null, $this->level->ReadOnly);
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check field with unique index (email)
        if ($this->_email->CurrentValue != "") {
            $filterChk = "(`email` = '" . AdjustSql($this->_email->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
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
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Get("fk_id", Get("schoolId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->schoolId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->schoolId->setSessionValue($this->schoolId->QueryStringValue);
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
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Post("fk_id", Post("schoolId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->schoolId->setFormValue($masterTbl->id->FormValue);
                    $this->schoolId->setSessionValue($this->schoolId->FormValue);
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
            if ($masterTblVar != "fed_school") {
                if ($this->schoolId->CurrentValue == "") {
                    $this->schoolId->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SchoolUsersList"), "", $this->TableVar, true);
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
                case "x_schoolIdMaster":
                    $lookupFilter = function () {
                        return "`typeId`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_schoolId":
                    break;
                case "x_createUserId":
                    break;
                case "x_level":
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
