<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedVideoAdd extends FedVideo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_video';

    // Page object name
    public $PageObjName = "FedVideoAdd";

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

        // Table object (fed_video)
        if (!isset($GLOBALS["fed_video"]) || get_class($GLOBALS["fed_video"]) == PROJECT_NAMESPACE . "fed_video") {
            $GLOBALS["fed_video"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fed_video');
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
                $tbl = Container("fed_video");
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
                    if ($pageName == "FedVideoView") {
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
        $this->_title->setVisibility();
        $this->URL->setVisibility();
        $this->thumbs->setVisibility();
        $this->description->setVisibility();
        $this->_userId->Visible = false;
        $this->section->setVisibility();
        $this->subsection->setVisibility();
        $this->createDate->Visible = false;
        $this->updateDate->Visible = false;
        $this->status->setVisibility();
        $this->frame->setVisibility();
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
        $this->setupLookupOptions($this->section);
        $this->setupLookupOptions($this->subsection);
        $this->setupLookupOptions($this->status);

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
                    $this->terminate("FedVideoList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "FedVideoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FedVideoView") {
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
        $this->thumbs->Upload->Index = $CurrentForm->Index;
        $this->thumbs->Upload->uploadFile();
        $this->thumbs->CurrentValue = $this->thumbs->Upload->FileName;
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

        // Check field name 'title' first before field var 'x__title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x__title");
        if (!$this->_title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_title->Visible = false; // Disable update for API request
            } else {
                $this->_title->setFormValue($val);
            }
        }

        // Check field name 'URL' first before field var 'x_URL'
        $val = $CurrentForm->hasValue("URL") ? $CurrentForm->getValue("URL") : $CurrentForm->getValue("x_URL");
        if (!$this->URL->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->URL->Visible = false; // Disable update for API request
            } else {
                $this->URL->setFormValue($val);
            }
        }

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'section' first before field var 'x_section'
        $val = $CurrentForm->hasValue("section") ? $CurrentForm->getValue("section") : $CurrentForm->getValue("x_section");
        if (!$this->section->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->section->Visible = false; // Disable update for API request
            } else {
                $this->section->setFormValue($val);
            }
        }

        // Check field name 'subsection' first before field var 'x_subsection'
        $val = $CurrentForm->hasValue("subsection") ? $CurrentForm->getValue("subsection") : $CurrentForm->getValue("x_subsection");
        if (!$this->subsection->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subsection->Visible = false; // Disable update for API request
            } else {
                $this->subsection->setFormValue($val);
            }
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

        // Check field name 'frame' first before field var 'x_frame'
        $val = $CurrentForm->hasValue("frame") ? $CurrentForm->getValue("frame") : $CurrentForm->getValue("x_frame");
        if (!$this->frame->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->frame->Visible = false; // Disable update for API request
            } else {
                $this->frame->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_title->CurrentValue = $this->_title->FormValue;
        $this->URL->CurrentValue = $this->URL->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->section->CurrentValue = $this->section->FormValue;
        $this->subsection->CurrentValue = $this->subsection->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->frame->CurrentValue = $this->frame->FormValue;
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
        $this->_title->setDbValue($row['title']);
        $this->URL->setDbValue($row['URL']);
        $this->thumbs->Upload->DbValue = $row['thumbs'];
        $this->thumbs->setDbValue($this->thumbs->Upload->DbValue);
        $this->description->setDbValue($row['description']);
        $this->_userId->setDbValue($row['userId']);
        $this->section->setDbValue($row['section']);
        $this->subsection->setDbValue($row['subsection']);
        $this->createDate->setDbValue($row['createDate']);
        $this->updateDate->setDbValue($row['updateDate']);
        $this->status->setDbValue($row['status']);
        $this->frame->setDbValue($row['frame']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['title'] = $this->_title->DefaultValue;
        $row['URL'] = $this->URL->DefaultValue;
        $row['thumbs'] = $this->thumbs->DefaultValue;
        $row['description'] = $this->description->DefaultValue;
        $row['userId'] = $this->_userId->DefaultValue;
        $row['section'] = $this->section->DefaultValue;
        $row['subsection'] = $this->subsection->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['updateDate'] = $this->updateDate->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['frame'] = $this->frame->DefaultValue;
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

        // title
        $this->_title->RowCssClass = "row";

        // URL
        $this->URL->RowCssClass = "row";

        // thumbs
        $this->thumbs->RowCssClass = "row";

        // description
        $this->description->RowCssClass = "row";

        // userId
        $this->_userId->RowCssClass = "row";

        // section
        $this->section->RowCssClass = "row";

        // subsection
        $this->subsection->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // updateDate
        $this->updateDate->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // frame
        $this->frame->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, $this->id->formatPattern());
            $this->id->ViewCustomAttributes = "";

            // title
            $this->_title->ViewValue = $this->_title->CurrentValue;
            $this->_title->ViewCustomAttributes = "";

            // URL
            $this->URL->ViewValue = $this->URL->CurrentValue;
            $this->URL->ImageAlt = $this->URL->alt();
                $this->URL->ImageCssClass = "ew-image";
            $this->URL->ViewCustomAttributes = "";

            // thumbs
            if (!EmptyValue($this->thumbs->Upload->DbValue)) {
                $this->thumbs->ImageWidth = 100;
                $this->thumbs->ImageHeight = 100;
                $this->thumbs->ImageAlt = $this->thumbs->alt();
                $this->thumbs->ImageCssClass = "ew-image";
                $this->thumbs->ViewValue = $this->thumbs->Upload->DbValue;
            } else {
                $this->thumbs->ViewValue = "";
            }
            $this->thumbs->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // userId
            $this->_userId->ViewValue = $this->_userId->CurrentValue;
            $this->_userId->ViewValue = FormatNumber($this->_userId->ViewValue, $this->_userId->formatPattern());
            $this->_userId->ViewCustomAttributes = "";

            // section
            $curVal = strval($this->section->CurrentValue);
            if ($curVal != "") {
                $this->section->ViewValue = $this->section->lookupCacheOption($curVal);
                if ($this->section->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->section->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->section->Lookup->renderViewRow($rswrk[0]);
                        $this->section->ViewValue = $this->section->displayValue($arwrk);
                    } else {
                        $this->section->ViewValue = FormatNumber($this->section->CurrentValue, $this->section->formatPattern());
                    }
                }
            } else {
                $this->section->ViewValue = null;
            }
            $this->section->ViewCustomAttributes = "";

            // subsection
            $curVal = strval($this->subsection->CurrentValue);
            if ($curVal != "") {
                $this->subsection->ViewValue = $this->subsection->lookupCacheOption($curVal);
                if ($this->subsection->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->subsection->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->subsection->Lookup->renderViewRow($rswrk[0]);
                        $this->subsection->ViewValue = $this->subsection->displayValue($arwrk);
                    } else {
                        $this->subsection->ViewValue = FormatNumber($this->subsection->CurrentValue, $this->subsection->formatPattern());
                    }
                }
            } else {
                $this->subsection->ViewValue = null;
            }
            $this->subsection->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // updateDate
            $this->updateDate->ViewValue = $this->updateDate->CurrentValue;
            $this->updateDate->ViewValue = FormatDateTime($this->updateDate->ViewValue, $this->updateDate->formatPattern());
            $this->updateDate->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // frame
            $this->frame->ViewValue = $this->frame->CurrentValue;
            $this->frame->ViewCustomAttributes = "";

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // URL
            $this->URL->LinkCustomAttributes = "";
            if (!EmptyValue($this->URL->CurrentValue)) {
                $this->URL->HrefValue = (!empty($this->URL->EditValue) && !is_array($this->URL->EditValue) ? RemoveHtml($this->URL->EditValue) : $this->URL->CurrentValue); // Add prefix/suffix
                $this->URL->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->URL->HrefValue = FullUrl($this->URL->HrefValue, "href");
                }
            } else {
                $this->URL->HrefValue = "";
            }

            // thumbs
            $this->thumbs->LinkCustomAttributes = "";
            if (!EmptyValue($this->description->CurrentValue)) {
                $this->thumbs->HrefValue = (!empty($this->description->EditValue) && !is_array($this->description->EditValue) ? RemoveHtml($this->description->EditValue) : $this->description->CurrentValue); // Add prefix/suffix
                $this->thumbs->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->thumbs->HrefValue = FullUrl($this->thumbs->HrefValue, "href");
                }
            } else {
                $this->thumbs->HrefValue = "";
            }
            $this->thumbs->ExportHrefValue = $this->thumbs->UploadPath . $this->thumbs->Upload->DbValue;

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // section
            $this->section->LinkCustomAttributes = "";
            $this->section->HrefValue = "";

            // subsection
            $this->subsection->LinkCustomAttributes = "";
            $this->subsection->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // frame
            $this->frame->LinkCustomAttributes = "";
            $this->frame->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // title
            $this->_title->setupEditAttributes();
            $this->_title->EditCustomAttributes = "";
            if (!$this->_title->Raw) {
                $this->_title->CurrentValue = HtmlDecode($this->_title->CurrentValue);
            }
            $this->_title->EditValue = HtmlEncode($this->_title->CurrentValue);
            $this->_title->PlaceHolder = RemoveHtml($this->_title->caption());

            // URL
            $this->URL->setupEditAttributes();
            $this->URL->EditCustomAttributes = "";
            if (!$this->URL->Raw) {
                $this->URL->CurrentValue = HtmlDecode($this->URL->CurrentValue);
            }
            $this->URL->EditValue = HtmlEncode($this->URL->CurrentValue);
            $this->URL->PlaceHolder = RemoveHtml($this->URL->caption());

            // thumbs
            $this->thumbs->setupEditAttributes();
            $this->thumbs->EditCustomAttributes = "";
            if (!EmptyValue($this->thumbs->Upload->DbValue)) {
                $this->thumbs->ImageWidth = 100;
                $this->thumbs->ImageHeight = 100;
                $this->thumbs->ImageAlt = $this->thumbs->alt();
                $this->thumbs->ImageCssClass = "ew-image";
                $this->thumbs->EditValue = $this->thumbs->Upload->DbValue;
            } else {
                $this->thumbs->EditValue = "";
            }
            if (!EmptyValue($this->thumbs->CurrentValue)) {
                $this->thumbs->Upload->FileName = $this->thumbs->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->thumbs);
            }

            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // section
            $this->section->EditCustomAttributes = "";
            if ($this->section->getSessionValue() != "") {
                $this->section->CurrentValue = GetForeignKeyValue($this->section->getSessionValue());
                $curVal = strval($this->section->CurrentValue);
                if ($curVal != "") {
                    $this->section->ViewValue = $this->section->lookupCacheOption($curVal);
                    if ($this->section->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->section->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->section->Lookup->renderViewRow($rswrk[0]);
                            $this->section->ViewValue = $this->section->displayValue($arwrk);
                        } else {
                            $this->section->ViewValue = FormatNumber($this->section->CurrentValue, $this->section->formatPattern());
                        }
                    }
                } else {
                    $this->section->ViewValue = null;
                }
                $this->section->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->section->CurrentValue));
                if ($curVal != "") {
                    $this->section->ViewValue = $this->section->lookupCacheOption($curVal);
                } else {
                    $this->section->ViewValue = $this->section->Lookup !== null && is_array($this->section->lookupOptions()) ? $curVal : null;
                }
                if ($this->section->ViewValue !== null) { // Load from cache
                    $this->section->EditValue = array_values($this->section->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->section->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->section->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->section->EditValue = $arwrk;
                }
                $this->section->PlaceHolder = RemoveHtml($this->section->caption());
            }

            // subsection
            $this->subsection->EditCustomAttributes = "";
            if ($this->subsection->getSessionValue() != "") {
                $this->subsection->CurrentValue = GetForeignKeyValue($this->subsection->getSessionValue());
                $curVal = strval($this->subsection->CurrentValue);
                if ($curVal != "") {
                    $this->subsection->ViewValue = $this->subsection->lookupCacheOption($curVal);
                    if ($this->subsection->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->subsection->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->subsection->Lookup->renderViewRow($rswrk[0]);
                            $this->subsection->ViewValue = $this->subsection->displayValue($arwrk);
                        } else {
                            $this->subsection->ViewValue = FormatNumber($this->subsection->CurrentValue, $this->subsection->formatPattern());
                        }
                    }
                } else {
                    $this->subsection->ViewValue = null;
                }
                $this->subsection->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->subsection->CurrentValue));
                if ($curVal != "") {
                    $this->subsection->ViewValue = $this->subsection->lookupCacheOption($curVal);
                } else {
                    $this->subsection->ViewValue = $this->subsection->Lookup !== null && is_array($this->subsection->lookupOptions()) ? $curVal : null;
                }
                if ($this->subsection->ViewValue !== null) { // Load from cache
                    $this->subsection->EditValue = array_values($this->subsection->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->subsection->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->subsection->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->subsection->EditValue = $arwrk;
                }
                $this->subsection->PlaceHolder = RemoveHtml($this->subsection->caption());
            }

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // frame
            $this->frame->setupEditAttributes();
            $this->frame->EditCustomAttributes = "";
            $this->frame->EditValue = HtmlEncode($this->frame->CurrentValue);
            $this->frame->PlaceHolder = RemoveHtml($this->frame->caption());

            // Add refer script

            // title
            $this->_title->LinkCustomAttributes = "";
            $this->_title->HrefValue = "";

            // URL
            $this->URL->LinkCustomAttributes = "";
            if (!EmptyValue($this->URL->CurrentValue)) {
                $this->URL->HrefValue = (!empty($this->URL->EditValue) && !is_array($this->URL->EditValue) ? RemoveHtml($this->URL->EditValue) : $this->URL->CurrentValue); // Add prefix/suffix
                $this->URL->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->URL->HrefValue = FullUrl($this->URL->HrefValue, "href");
                }
            } else {
                $this->URL->HrefValue = "";
            }

            // thumbs
            $this->thumbs->LinkCustomAttributes = "";
            if (!EmptyValue($this->description->CurrentValue)) {
                $this->thumbs->HrefValue = (!empty($this->description->EditValue) && !is_array($this->description->EditValue) ? RemoveHtml($this->description->EditValue) : $this->description->CurrentValue); // Add prefix/suffix
                $this->thumbs->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->thumbs->HrefValue = FullUrl($this->thumbs->HrefValue, "href");
                }
            } else {
                $this->thumbs->HrefValue = "";
            }
            $this->thumbs->ExportHrefValue = $this->thumbs->UploadPath . $this->thumbs->Upload->DbValue;

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // section
            $this->section->LinkCustomAttributes = "";
            $this->section->HrefValue = "";

            // subsection
            $this->subsection->LinkCustomAttributes = "";
            $this->subsection->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // frame
            $this->frame->LinkCustomAttributes = "";
            $this->frame->HrefValue = "";
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
        if ($this->_title->Required) {
            if (!$this->_title->IsDetailKey && EmptyValue($this->_title->FormValue)) {
                $this->_title->addErrorMessage(str_replace("%s", $this->_title->caption(), $this->_title->RequiredErrorMessage));
            }
        }
        if ($this->URL->Required) {
            if (!$this->URL->IsDetailKey && EmptyValue($this->URL->FormValue)) {
                $this->URL->addErrorMessage(str_replace("%s", $this->URL->caption(), $this->URL->RequiredErrorMessage));
            }
        }
        if ($this->thumbs->Required) {
            if ($this->thumbs->Upload->FileName == "" && !$this->thumbs->Upload->KeepFile) {
                $this->thumbs->addErrorMessage(str_replace("%s", $this->thumbs->caption(), $this->thumbs->RequiredErrorMessage));
            }
        }
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->section->Required) {
            if ($this->section->FormValue == "") {
                $this->section->addErrorMessage(str_replace("%s", $this->section->caption(), $this->section->RequiredErrorMessage));
            }
        }
        if ($this->subsection->Required) {
            if ($this->subsection->FormValue == "") {
                $this->subsection->addErrorMessage(str_replace("%s", $this->subsection->caption(), $this->subsection->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->frame->Required) {
            if (!$this->frame->IsDetailKey && EmptyValue($this->frame->FormValue)) {
                $this->frame->addErrorMessage(str_replace("%s", $this->frame->caption(), $this->frame->RequiredErrorMessage));
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

        // title
        $this->_title->setDbValueDef($rsnew, $this->_title->CurrentValue, null, false);

        // URL
        $this->URL->setDbValueDef($rsnew, $this->URL->CurrentValue, null, false);

        // thumbs
        if ($this->thumbs->Visible && !$this->thumbs->Upload->KeepFile) {
            $this->thumbs->Upload->DbValue = ""; // No need to delete old file
            if ($this->thumbs->Upload->FileName == "") {
                $rsnew['thumbs'] = null;
            } else {
                $rsnew['thumbs'] = $this->thumbs->Upload->FileName;
            }
        }

        // description
        $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, null, false);

        // section
        $this->section->setDbValueDef($rsnew, $this->section->CurrentValue, null, false);

        // subsection
        $this->subsection->setDbValueDef($rsnew, $this->subsection->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // frame
        $this->frame->setDbValueDef($rsnew, $this->frame->CurrentValue, null, false);
        if ($this->thumbs->Visible && !$this->thumbs->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->thumbs->Upload->DbValue) ? [] : [$this->thumbs->htmlDecode($this->thumbs->Upload->DbValue)];
            if (!EmptyValue($this->thumbs->Upload->FileName)) {
                $newFiles = [$this->thumbs->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->thumbs, $this->thumbs->Upload->Index);
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
                            $file1 = UniqueFilename($this->thumbs->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->thumbs->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->thumbs->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->thumbs->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->thumbs->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->thumbs->setDbValueDef($rsnew, $this->thumbs->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'fed_video'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["section"] = $this->section->CurrentValue;
        $masterTable = Container("fed_videosection");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "fed_videosection", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

        // Check referential integrity for master table 'fed_video'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["subsection"] = $this->subsection->CurrentValue;
        $masterTable = Container("fed_videosubsection");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "fed_videosubsection", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->thumbs->Visible && !$this->thumbs->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->thumbs->Upload->DbValue) ? [] : [$this->thumbs->htmlDecode($this->thumbs->Upload->DbValue)];
                    if (!EmptyValue($this->thumbs->Upload->FileName)) {
                        $newFiles = [$this->thumbs->Upload->FileName];
                        $newFiles2 = [$this->thumbs->htmlDecode($rsnew['thumbs'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->thumbs, $this->thumbs->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->thumbs->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->thumbs->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
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
            // thumbs
            CleanUploadTempPath($this->thumbs, $this->thumbs->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
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
            if ($masterTblVar == "fed_videosection") {
                $validMaster = true;
                $masterTbl = Container("fed_videosection");
                if (($parm = Get("fk_id", Get("section"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->section->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->section->setSessionValue($this->section->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "fed_videosubsection") {
                $validMaster = true;
                $masterTbl = Container("fed_videosubsection");
                if (($parm = Get("fk_id", Get("subsection"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->subsection->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->subsection->setSessionValue($this->subsection->QueryStringValue);
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
            if ($masterTblVar == "fed_videosection") {
                $validMaster = true;
                $masterTbl = Container("fed_videosection");
                if (($parm = Post("fk_id", Post("section"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->section->setFormValue($masterTbl->id->FormValue);
                    $this->section->setSessionValue($this->section->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "fed_videosubsection") {
                $validMaster = true;
                $masterTbl = Container("fed_videosubsection");
                if (($parm = Post("fk_id", Post("subsection"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->subsection->setFormValue($masterTbl->id->FormValue);
                    $this->subsection->setSessionValue($this->subsection->FormValue);
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
            if ($masterTblVar != "fed_videosection") {
                if ($this->section->CurrentValue == "") {
                    $this->section->setSessionValue("");
                }
            }
            if ($masterTblVar != "fed_videosubsection") {
                if ($this->subsection->CurrentValue == "") {
                    $this->subsection->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FedVideoList"), "", $this->TableVar, true);
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
                case "x_section":
                    break;
                case "x_subsection":
                    break;
                case "x_status":
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
