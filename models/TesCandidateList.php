<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesCandidateList extends TesCandidate
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_candidate';

    // Page object name
    public $PageObjName = "TesCandidateList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ftes_candidatelist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (tes_candidate)
        if (!isset($GLOBALS["tes_candidate"]) || get_class($GLOBALS["tes_candidate"]) == PROJECT_NAMESPACE . "tes_candidate") {
            $GLOBALS["tes_candidate"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "TesCandidateAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "TesCandidateDelete";
        $this->MultiUpdateUrl = "TesCandidateUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_candidate');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions(["Tag" => "td", "TableVar" => $this->TableVar]);

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Import options
        $this->ImportOptions = new ListOptions(["TagClassName" => "ew-import-option"]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions([
            "TagClassName" => "ew-add-edit-option",
            "UseDropDownButton" => false,
            "DropDownButtonPhrase" => $Language->phrase("ButtonAddEdit"),
            "UseButtonGroup" => true
        ]);

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(["TagClassName" => "ew-detail-option"]);
        // Actions
        $this->OtherOptions["action"] = new ListOptions(["TagClassName" => "ew-action-option"]);

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions([
            "TableVar" => $this->TableVar,
            "TagClassName" => "ew-column-option",
            "ButtonGroupClass" => "ew-column-dropdown",
            "UseDropDownButton" => true,
            "DropDownButtonPhrase" => $Language->phrase("Columns"),
            "DropDownAutoClose" => "outside",
            "UseButtonGroup" => false
        ]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);

        // List actions
        $this->ListActions = new ListActions();
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
                $tbl = Container("tes_candidate");
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
        if ($this->isAddOrEdit()) {
            $this->schoolId->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->createUseriD->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->createDate->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
        $this->id->setVisibility();
        $this->memberId->setVisibility();
        $this->memberDOB->Visible = false;
        $this->rankId->setVisibility();
        $this->testNominated->setVisibility();
        $this->testPaid->setVisibility();
        $this->testId->Visible = false;
        $this->result->setVisibility();
        $this->nextRankId->setVisibility();
        $this->memberAge->setVisibility();
        $this->obs->Visible = false;
        $this->renew->Visible = false;
        $this->schoolId->Visible = false;
        $this->createUseriD->Visible = false;
        $this->createDate->Visible = false;
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->memberId);
        $this->setupLookupOptions($this->rankId);
        $this->setupLookupOptions($this->testNominated);
        $this->setupLookupOptions($this->testPaid);
        $this->setupLookupOptions($this->testId);
        $this->setupLookupOptions($this->result);
        $this->setupLookupOptions($this->nextRankId);
        $this->setupLookupOptions($this->renew);
        $this->setupLookupOptions($this->createUseriD);

        // Load default values for add
        $this->loadDefaultValues();

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd", ""));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to grid edit mode
                if ($this->isGridEdit()) {
                    $this->gridEditMode();
                }

                // Switch to inline edit mode
                if ($this->isEdit()) {
                    $this->inlineEditMode();
                }

                // Switch to grid add mode
                if ($this->isGridAdd()) {
                    $this->gridAddMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Grid Update
                    if (($this->isGridUpdate() || $this->isGridOverwrite()) && Session(SESSION_INLINE_MODE) == "gridedit") {
                        if ($this->validateGridForm()) {
                            $gridUpdate = $this->gridUpdate();
                        } else {
                            $gridUpdate = false;
                        }
                        if ($gridUpdate) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridEditMode(); // Stay in Grid edit mode
                        }
                    }

                    // Inline Update
                    if (($this->isUpdate() || $this->isOverwrite()) && Session(SESSION_INLINE_MODE) == "edit") {
                        $this->setKey(Post($this->OldKeyName));
                        $this->inlineUpdate();
                    }

                    // Grid Insert
                    if ($this->isGridInsert() && Session(SESSION_INLINE_MODE) == "gridadd") {
                        if ($this->validateGridForm()) {
                            $gridInsert = $this->gridInsert();
                        } else {
                            $gridInsert = false;
                        }
                        if ($gridInsert) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridAddMode(); // Stay in Grid add mode
                        }
                    }
                } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                    if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NO")) !== null) { // Stay in grid edit mode if paging
                        $this->gridEditMode();
                    } else { // Reset grid edit
                        $this->clearInlineMode();
                    }
                }
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get and validate search values for advanced search
            if (EmptyValue($this->UserAction)) { // Skip if user action
                $this->loadSearchValues();
            }

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session

        // Add master User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
                if ($this->getCurrentMasterTable() == "tes_test") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "tes_test"); // Add master User ID filter
                }
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "tes_test") {
            $masterTbl = Container("tes_test");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("TesTestList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }

        // Export data only
        if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
            $this->exportData();
            $this->terminate();
            return;
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Allow) {
                if ($listaction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listaction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        global $Security, $Language;
        if (!$Security->canAdd()) { // No add permission
            $this->CurrentAction = "";
            $this->setFailureMessage($Language->phrase("NoAddPermission"));
            return false;
        }
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        global $Security, $Language;
        if (!$Security->canEdit()) { // No edit permission
            $this->CurrentAction = "";
            $this->setFailureMessage($Language->phrase("NoEditPermission"));
            return false;
        }
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Inline Edit mode
    protected function inlineEditMode()
    {
        global $Security, $Language;
        if (!$Security->canEdit()) { // No edit permission
            $this->CurrentAction = "";
            $this->setFailureMessage($Language->phrase("NoEditPermission"));
            return false;
        }
        $inlineEdit = true;
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->id->setQueryStringValue($keyValue);
        } else {
            $inlineEdit = false;
        }
        if ($inlineEdit) {
            if ($this->loadRow()) {
                    // Check if valid User ID
                    if (!$this->showOptionLink("edit")) {
                        $userIdMsg = $Language->phrase("NoEditPermission");
                        $this->setFailureMessage($userIdMsg);
                        $this->clearInlineMode(); // Clear inline edit mode
                        return false;
                    }
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey); // Set to OldValue
                $_SESSION[SESSION_INLINE_MODE] = "edit"; // Enable inline edit
            }
        }
        return true;
    }

    // Perform update to Inline Edit record
    protected function inlineUpdate()
    {
        global $Language, $CurrentForm;
        $CurrentForm->Index = 1;
        $this->loadFormValues(); // Get form values

        // Validate form
        $inlineUpdate = true;
        if (!$this->validateForm()) {
            $inlineUpdate = false; // Form error, reset action
        } else {
            $inlineUpdate = false;
            $this->SendEmail = true; // Send email on update success
            $inlineUpdate = $this->editRow(); // Update record
        }
        if ($inlineUpdate) { // Update success
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
            $this->EventCancelled = true; // Cancel event
            $this->CurrentAction = "edit"; // Stay in edit mode
        }
    }

    // Check Inline Edit key
    public function checkInlineEditKey()
    {
        if (!SameString($this->id->OldValue, $this->id->CurrentValue)) {
            return false;
        }
        return true;
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($Language->phrase("NoAddRecord"));
            $gridInsert = false;
        }
        if ($gridInsert) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_memberId") &&
            $CurrentForm->hasValue("o_memberId") &&
            $this->memberId->CurrentValue != $this->memberId->DefaultValue &&
            !($this->memberId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->memberId->CurrentValue == $this->memberId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_rankId") &&
            $CurrentForm->hasValue("o_rankId") &&
            $this->rankId->CurrentValue != $this->rankId->DefaultValue &&
            !($this->rankId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->rankId->CurrentValue == $this->rankId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_testNominated") &&
            $CurrentForm->hasValue("o_testNominated") &&
            ConvertToBool($this->testNominated->CurrentValue) != ConvertToBool($this->testNominated->DefaultValue) &&
            !($this->testNominated->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            ConvertToBool($this->testNominated->CurrentValue) == ConvertToBool($this->testNominated->getSessionValue()))
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_testPaid") &&
            $CurrentForm->hasValue("o_testPaid") &&
            ConvertToBool($this->testPaid->CurrentValue) != ConvertToBool($this->testPaid->DefaultValue) &&
            !($this->testPaid->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            ConvertToBool($this->testPaid->CurrentValue) == ConvertToBool($this->testPaid->getSessionValue()))
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_result") &&
            $CurrentForm->hasValue("o_result") &&
            ConvertToBool($this->result->CurrentValue) != ConvertToBool($this->result->DefaultValue) &&
            !($this->result->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            ConvertToBool($this->result->CurrentValue) == ConvertToBool($this->result->getSessionValue()))
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nextRankId") &&
            $CurrentForm->hasValue("o_nextRankId") &&
            $this->nextRankId->CurrentValue != $this->nextRankId->DefaultValue &&
            !($this->nextRankId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->nextRankId->CurrentValue == $this->nextRankId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_memberAge") &&
            $CurrentForm->hasValue("o_memberAge") &&
            $this->memberAge->CurrentValue != $this->memberAge->DefaultValue &&
            !($this->memberAge->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->memberAge->CurrentValue == $this->memberAge->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id->clearErrorMessage();
        $this->memberId->clearErrorMessage();
        $this->rankId->clearErrorMessage();
        $this->testNominated->clearErrorMessage();
        $this->testPaid->clearErrorMessage();
        $this->result->clearErrorMessage();
        $this->nextRankId->clearErrorMessage();
        $this->memberAge->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server" && isset($UserProfile)) {
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "ftes_candidatesrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->memberId->AdvancedSearch->toJson(), ","); // Field memberId
        $filterList = Concat($filterList, $this->memberDOB->AdvancedSearch->toJson(), ","); // Field memberDOB
        $filterList = Concat($filterList, $this->rankId->AdvancedSearch->toJson(), ","); // Field rankId
        $filterList = Concat($filterList, $this->testNominated->AdvancedSearch->toJson(), ","); // Field testNominated
        $filterList = Concat($filterList, $this->testPaid->AdvancedSearch->toJson(), ","); // Field testPaid
        $filterList = Concat($filterList, $this->testId->AdvancedSearch->toJson(), ","); // Field testId
        $filterList = Concat($filterList, $this->result->AdvancedSearch->toJson(), ","); // Field result
        $filterList = Concat($filterList, $this->nextRankId->AdvancedSearch->toJson(), ","); // Field nextRankId
        $filterList = Concat($filterList, $this->memberAge->AdvancedSearch->toJson(), ","); // Field memberAge
        $filterList = Concat($filterList, $this->obs->AdvancedSearch->toJson(), ","); // Field obs
        $filterList = Concat($filterList, $this->renew->AdvancedSearch->toJson(), ","); // Field renew
        $filterList = Concat($filterList, $this->schoolId->AdvancedSearch->toJson(), ","); // Field schoolId
        $filterList = Concat($filterList, $this->createUseriD->AdvancedSearch->toJson(), ","); // Field createUseriD
        $filterList = Concat($filterList, $this->createDate->AdvancedSearch->toJson(), ","); // Field createDate

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "ftes_candidatesrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field memberId
        $this->memberId->AdvancedSearch->SearchValue = @$filter["x_memberId"];
        $this->memberId->AdvancedSearch->SearchOperator = @$filter["z_memberId"];
        $this->memberId->AdvancedSearch->SearchCondition = @$filter["v_memberId"];
        $this->memberId->AdvancedSearch->SearchValue2 = @$filter["y_memberId"];
        $this->memberId->AdvancedSearch->SearchOperator2 = @$filter["w_memberId"];
        $this->memberId->AdvancedSearch->save();

        // Field memberDOB
        $this->memberDOB->AdvancedSearch->SearchValue = @$filter["x_memberDOB"];
        $this->memberDOB->AdvancedSearch->SearchOperator = @$filter["z_memberDOB"];
        $this->memberDOB->AdvancedSearch->SearchCondition = @$filter["v_memberDOB"];
        $this->memberDOB->AdvancedSearch->SearchValue2 = @$filter["y_memberDOB"];
        $this->memberDOB->AdvancedSearch->SearchOperator2 = @$filter["w_memberDOB"];
        $this->memberDOB->AdvancedSearch->save();

        // Field rankId
        $this->rankId->AdvancedSearch->SearchValue = @$filter["x_rankId"];
        $this->rankId->AdvancedSearch->SearchOperator = @$filter["z_rankId"];
        $this->rankId->AdvancedSearch->SearchCondition = @$filter["v_rankId"];
        $this->rankId->AdvancedSearch->SearchValue2 = @$filter["y_rankId"];
        $this->rankId->AdvancedSearch->SearchOperator2 = @$filter["w_rankId"];
        $this->rankId->AdvancedSearch->save();

        // Field testNominated
        $this->testNominated->AdvancedSearch->SearchValue = @$filter["x_testNominated"];
        $this->testNominated->AdvancedSearch->SearchOperator = @$filter["z_testNominated"];
        $this->testNominated->AdvancedSearch->SearchCondition = @$filter["v_testNominated"];
        $this->testNominated->AdvancedSearch->SearchValue2 = @$filter["y_testNominated"];
        $this->testNominated->AdvancedSearch->SearchOperator2 = @$filter["w_testNominated"];
        $this->testNominated->AdvancedSearch->save();

        // Field testPaid
        $this->testPaid->AdvancedSearch->SearchValue = @$filter["x_testPaid"];
        $this->testPaid->AdvancedSearch->SearchOperator = @$filter["z_testPaid"];
        $this->testPaid->AdvancedSearch->SearchCondition = @$filter["v_testPaid"];
        $this->testPaid->AdvancedSearch->SearchValue2 = @$filter["y_testPaid"];
        $this->testPaid->AdvancedSearch->SearchOperator2 = @$filter["w_testPaid"];
        $this->testPaid->AdvancedSearch->save();

        // Field testId
        $this->testId->AdvancedSearch->SearchValue = @$filter["x_testId"];
        $this->testId->AdvancedSearch->SearchOperator = @$filter["z_testId"];
        $this->testId->AdvancedSearch->SearchCondition = @$filter["v_testId"];
        $this->testId->AdvancedSearch->SearchValue2 = @$filter["y_testId"];
        $this->testId->AdvancedSearch->SearchOperator2 = @$filter["w_testId"];
        $this->testId->AdvancedSearch->save();

        // Field result
        $this->result->AdvancedSearch->SearchValue = @$filter["x_result"];
        $this->result->AdvancedSearch->SearchOperator = @$filter["z_result"];
        $this->result->AdvancedSearch->SearchCondition = @$filter["v_result"];
        $this->result->AdvancedSearch->SearchValue2 = @$filter["y_result"];
        $this->result->AdvancedSearch->SearchOperator2 = @$filter["w_result"];
        $this->result->AdvancedSearch->save();

        // Field nextRankId
        $this->nextRankId->AdvancedSearch->SearchValue = @$filter["x_nextRankId"];
        $this->nextRankId->AdvancedSearch->SearchOperator = @$filter["z_nextRankId"];
        $this->nextRankId->AdvancedSearch->SearchCondition = @$filter["v_nextRankId"];
        $this->nextRankId->AdvancedSearch->SearchValue2 = @$filter["y_nextRankId"];
        $this->nextRankId->AdvancedSearch->SearchOperator2 = @$filter["w_nextRankId"];
        $this->nextRankId->AdvancedSearch->save();

        // Field memberAge
        $this->memberAge->AdvancedSearch->SearchValue = @$filter["x_memberAge"];
        $this->memberAge->AdvancedSearch->SearchOperator = @$filter["z_memberAge"];
        $this->memberAge->AdvancedSearch->SearchCondition = @$filter["v_memberAge"];
        $this->memberAge->AdvancedSearch->SearchValue2 = @$filter["y_memberAge"];
        $this->memberAge->AdvancedSearch->SearchOperator2 = @$filter["w_memberAge"];
        $this->memberAge->AdvancedSearch->save();

        // Field obs
        $this->obs->AdvancedSearch->SearchValue = @$filter["x_obs"];
        $this->obs->AdvancedSearch->SearchOperator = @$filter["z_obs"];
        $this->obs->AdvancedSearch->SearchCondition = @$filter["v_obs"];
        $this->obs->AdvancedSearch->SearchValue2 = @$filter["y_obs"];
        $this->obs->AdvancedSearch->SearchOperator2 = @$filter["w_obs"];
        $this->obs->AdvancedSearch->save();

        // Field renew
        $this->renew->AdvancedSearch->SearchValue = @$filter["x_renew"];
        $this->renew->AdvancedSearch->SearchOperator = @$filter["z_renew"];
        $this->renew->AdvancedSearch->SearchCondition = @$filter["v_renew"];
        $this->renew->AdvancedSearch->SearchValue2 = @$filter["y_renew"];
        $this->renew->AdvancedSearch->SearchOperator2 = @$filter["w_renew"];
        $this->renew->AdvancedSearch->save();

        // Field schoolId
        $this->schoolId->AdvancedSearch->SearchValue = @$filter["x_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator = @$filter["z_schoolId"];
        $this->schoolId->AdvancedSearch->SearchCondition = @$filter["v_schoolId"];
        $this->schoolId->AdvancedSearch->SearchValue2 = @$filter["y_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator2 = @$filter["w_schoolId"];
        $this->schoolId->AdvancedSearch->save();

        // Field createUseriD
        $this->createUseriD->AdvancedSearch->SearchValue = @$filter["x_createUseriD"];
        $this->createUseriD->AdvancedSearch->SearchOperator = @$filter["z_createUseriD"];
        $this->createUseriD->AdvancedSearch->SearchCondition = @$filter["v_createUseriD"];
        $this->createUseriD->AdvancedSearch->SearchValue2 = @$filter["y_createUseriD"];
        $this->createUseriD->AdvancedSearch->SearchOperator2 = @$filter["w_createUseriD"];
        $this->createUseriD->AdvancedSearch->save();

        // Field createDate
        $this->createDate->AdvancedSearch->SearchValue = @$filter["x_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator = @$filter["z_createDate"];
        $this->createDate->AdvancedSearch->SearchCondition = @$filter["v_createDate"];
        $this->createDate->AdvancedSearch->SearchValue2 = @$filter["y_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator2 = @$filter["w_createDate"];
        $this->createDate->AdvancedSearch->save();
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->id, $default, false); // id
        $this->buildSearchSql($where, $this->memberId, $default, false); // memberId
        $this->buildSearchSql($where, $this->memberDOB, $default, false); // memberDOB
        $this->buildSearchSql($where, $this->rankId, $default, false); // rankId
        $this->buildSearchSql($where, $this->testNominated, $default, false); // testNominated
        $this->buildSearchSql($where, $this->testPaid, $default, false); // testPaid
        $this->buildSearchSql($where, $this->testId, $default, false); // testId
        $this->buildSearchSql($where, $this->result, $default, false); // result
        $this->buildSearchSql($where, $this->nextRankId, $default, false); // nextRankId
        $this->buildSearchSql($where, $this->memberAge, $default, false); // memberAge
        $this->buildSearchSql($where, $this->obs, $default, false); // obs
        $this->buildSearchSql($where, $this->renew, $default, false); // renew
        $this->buildSearchSql($where, $this->schoolId, $default, false); // schoolId
        $this->buildSearchSql($where, $this->createUseriD, $default, false); // createUseriD
        $this->buildSearchSql($where, $this->createDate, $default, false); // createDate

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->memberId->AdvancedSearch->save(); // memberId
            $this->memberDOB->AdvancedSearch->save(); // memberDOB
            $this->rankId->AdvancedSearch->save(); // rankId
            $this->testNominated->AdvancedSearch->save(); // testNominated
            $this->testPaid->AdvancedSearch->save(); // testPaid
            $this->testId->AdvancedSearch->save(); // testId
            $this->result->AdvancedSearch->save(); // result
            $this->nextRankId->AdvancedSearch->save(); // nextRankId
            $this->memberAge->AdvancedSearch->save(); // memberAge
            $this->obs->AdvancedSearch->save(); // obs
            $this->renew->AdvancedSearch->save(); // renew
            $this->schoolId->AdvancedSearch->save(); // schoolId
            $this->createUseriD->AdvancedSearch->save(); // createUseriD
            $this->createDate->AdvancedSearch->save(); // createDate
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr ?? ""));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2 ?? ""));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->formatPattern());
            }
        }
        return $value;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        if ($this->id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->memberId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->memberDOB->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->rankId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testNominated->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testPaid->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->result->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nextRankId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->memberAge->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->obs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->renew->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->schoolId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createUseriD->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createDate->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->id->AdvancedSearch->unsetSession();
        $this->memberId->AdvancedSearch->unsetSession();
        $this->memberDOB->AdvancedSearch->unsetSession();
        $this->rankId->AdvancedSearch->unsetSession();
        $this->testNominated->AdvancedSearch->unsetSession();
        $this->testPaid->AdvancedSearch->unsetSession();
        $this->testId->AdvancedSearch->unsetSession();
        $this->result->AdvancedSearch->unsetSession();
        $this->nextRankId->AdvancedSearch->unsetSession();
        $this->memberAge->AdvancedSearch->unsetSession();
        $this->obs->AdvancedSearch->unsetSession();
        $this->renew->AdvancedSearch->unsetSession();
        $this->schoolId->AdvancedSearch->unsetSession();
        $this->createUseriD->AdvancedSearch->unsetSession();
        $this->createDate->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
        $this->id->AdvancedSearch->load();
        $this->memberId->AdvancedSearch->load();
        $this->memberDOB->AdvancedSearch->load();
        $this->rankId->AdvancedSearch->load();
        $this->testNominated->AdvancedSearch->load();
        $this->testPaid->AdvancedSearch->load();
        $this->testId->AdvancedSearch->load();
        $this->result->AdvancedSearch->load();
        $this->nextRankId->AdvancedSearch->load();
        $this->memberAge->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->renew->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->createUseriD->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->memberId); // memberId
            $this->updateSort($this->rankId); // rankId
            $this->updateSort($this->testNominated); // testNominated
            $this->updateSort($this->testPaid); // testPaid
            $this->updateSort($this->result); // result
            $this->updateSort($this->nextRankId); // nextRankId
            $this->updateSort($this->memberAge); // memberAge
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->testId->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id->setSort("");
                $this->memberId->setSort("");
                $this->memberDOB->setSort("");
                $this->rankId->setSort("");
                $this->testNominated->setSort("");
                $this->testPaid->setSort("");
                $this->testId->setSort("");
                $this->result->setSort("");
                $this->nextRankId->setSort("");
                $this->memberAge->setSort("");
                $this->obs->setSort("");
                $this->renew->setSort("");
                $this->schoolId->setSort("");
                $this->createUseriD->setSort("");
                $this->createDate->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm, $UserProfile;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl(false);

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($this->isInlineEditRow()) { // Inline-Edit
            $this->ListOptions->CustomItem = "edit"; // Show edit column only
            $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $opt->Body = "<div" . (($opt->OnLeft) ? " class=\"text-end\"" : "") . ">" .
                "<button class=\"ew-grid-link ew-inline-update\" title=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("UpdateLink")) . "\" form=\"ftes_candidatelist\" formaction=\"" . HtmlEncode(GetUrl(UrlAddHash($this->pageName(), "r" . $this->RowCount . "_" . $this->TableVar))) . "\">" . $Language->phrase("UpdateLink") . "</button>&nbsp;" .
                "<a class=\"ew-grid-link ew-inline-cancel\" title=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("CancelLink") . "</a>" .
                "<input type=\"hidden\" name=\"action\" id=\"action\" value=\"update\"></div>";
            $opt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\">";
            return;
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView() && $this->showOptionLink("view")) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit() && $this->showOptionLink("edit")) {
                $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineEditLink")) . "\" href=\"" . HtmlEncode(UrlAddHash(GetUrl($this->InlineEditUrl), "r" . $this->RowCount . "_" . $this->TableVar)) . "\">" . $Language->phrase("InlineEditLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                $action = $listaction->Action;
                $allowed = $listaction->Allow;
                if ($listaction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ftes_candidatelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ftes_candidatelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];
        $item = &$option->add("gridadd");
        $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("id", $this->createColumnOption("id"));
            $option->add("memberId", $this->createColumnOption("memberId"));
            $option->add("rankId", $this->createColumnOption("rankId"));
            $option->add("testNominated", $this->createColumnOption("testNominated"));
            $option->add("testPaid", $this->createColumnOption("testPaid"));
            $option->add("result", $this->createColumnOption("result"));
            $option->add("nextRankId", $this->createColumnOption("nextRankId"));
            $option->add("memberAge", $this->createColumnOption("memberAge"));
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"ftes_candidatesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"ftes_candidatesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Create new column option
    public function createColumnOption($name)
    {
        $field = $this->Fields[$name] ?? false;
        if ($field && $field->Visible) {
            $item = new ListOption($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
            return $item;
        }
        return null;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listaction->Action);
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="ftes_candidatelist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
                    $item->Visible = $listaction->Allow;
                }
            }

            // Hide grid edit and other options
            if ($this->TotalRecords <= 0) {
                $option = $options["addedit"];
                $item = $option["gridedit"];
                if ($item) {
                    $item->Visible = false;
                }
                $option = $options["action"];
                $option->hideAllOptions();
            }
        } else { // Grid add/edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl(false);

            // Grid-Add
            if ($this->isGridAdd()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<a type=\"button\" class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                        $item->Visible = false;
                    }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                // Add grid insert
                $item = &$option->add("gridinsert");
                $item->Body = "<button class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" form=\"ftes_candidatelist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridInsertLink") . "</button>";
                // Add grid cancel
                $item = &$option->add("gridcancel");
                $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $item->Body = "<a type=\"button\" class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }

            // Grid-Edit
            if ($this->isGridEdit()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<button class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</button>";
                    $item->Visible = false;
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                    $item = &$option->add("gridsave");
                    $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" form=\"ftes_candidatelist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridSaveLink") . "</button>";
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn);
            $this->UserAction = $userAction;
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($rs) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        $conn->commit();
                    }
                    if ($this->getSuccessMessage() == "" && !ob_get_length() && !$Response->getBody()->getSize()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        $conn->rollback();
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->schoolId->DefaultValue = CurrentUserID();
        $this->schoolId->OldValue = $this->schoolId->DefaultValue;
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // id
        if ($this->id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->id->AdvancedSearch->SearchValue != "" || $this->id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // memberId
        if ($this->memberId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->memberId->AdvancedSearch->SearchValue != "" || $this->memberId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // memberDOB
        if ($this->memberDOB->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->memberDOB->AdvancedSearch->SearchValue != "" || $this->memberDOB->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // rankId
        if ($this->rankId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->rankId->AdvancedSearch->SearchValue != "" || $this->rankId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testNominated
        if ($this->testNominated->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testNominated->AdvancedSearch->SearchValue != "" || $this->testNominated->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->testNominated->AdvancedSearch->SearchValue)) {
            $this->testNominated->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->testNominated->AdvancedSearch->SearchValue);
        }
        if (is_array($this->testNominated->AdvancedSearch->SearchValue2)) {
            $this->testNominated->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->testNominated->AdvancedSearch->SearchValue2);
        }

        // testPaid
        if ($this->testPaid->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testPaid->AdvancedSearch->SearchValue != "" || $this->testPaid->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->testPaid->AdvancedSearch->SearchValue)) {
            $this->testPaid->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->testPaid->AdvancedSearch->SearchValue);
        }
        if (is_array($this->testPaid->AdvancedSearch->SearchValue2)) {
            $this->testPaid->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->testPaid->AdvancedSearch->SearchValue2);
        }

        // testId
        if ($this->testId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testId->AdvancedSearch->SearchValue != "" || $this->testId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // result
        if ($this->result->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->result->AdvancedSearch->SearchValue != "" || $this->result->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->result->AdvancedSearch->SearchValue)) {
            $this->result->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->result->AdvancedSearch->SearchValue);
        }
        if (is_array($this->result->AdvancedSearch->SearchValue2)) {
            $this->result->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->result->AdvancedSearch->SearchValue2);
        }

        // nextRankId
        if ($this->nextRankId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nextRankId->AdvancedSearch->SearchValue != "" || $this->nextRankId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // memberAge
        if ($this->memberAge->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->memberAge->AdvancedSearch->SearchValue != "" || $this->memberAge->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // obs
        if ($this->obs->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->obs->AdvancedSearch->SearchValue != "" || $this->obs->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // renew
        if ($this->renew->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->renew->AdvancedSearch->SearchValue != "" || $this->renew->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->renew->AdvancedSearch->SearchValue)) {
            $this->renew->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->renew->AdvancedSearch->SearchValue);
        }
        if (is_array($this->renew->AdvancedSearch->SearchValue2)) {
            $this->renew->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->renew->AdvancedSearch->SearchValue2);
        }

        // schoolId
        if ($this->schoolId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->schoolId->AdvancedSearch->SearchValue != "" || $this->schoolId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // createUseriD
        if ($this->createUseriD->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->createUseriD->AdvancedSearch->SearchValue != "" || $this->createUseriD->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // createDate
        if ($this->createDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->createDate->AdvancedSearch->SearchValue != "" || $this->createDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
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
        if ($CurrentForm->hasValue("o_memberId")) {
            $this->memberId->setOldValue($CurrentForm->getValue("o_memberId"));
        }

        // Check field name 'rankId' first before field var 'x_rankId'
        $val = $CurrentForm->hasValue("rankId") ? $CurrentForm->getValue("rankId") : $CurrentForm->getValue("x_rankId");
        if (!$this->rankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rankId->Visible = false; // Disable update for API request
            } else {
                $this->rankId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_rankId")) {
            $this->rankId->setOldValue($CurrentForm->getValue("o_rankId"));
        }

        // Check field name 'testNominated' first before field var 'x_testNominated'
        $val = $CurrentForm->hasValue("testNominated") ? $CurrentForm->getValue("testNominated") : $CurrentForm->getValue("x_testNominated");
        if (!$this->testNominated->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testNominated->Visible = false; // Disable update for API request
            } else {
                $this->testNominated->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_testNominated")) {
            $this->testNominated->setOldValue($CurrentForm->getValue("o_testNominated"));
        }

        // Check field name 'testPaid' first before field var 'x_testPaid'
        $val = $CurrentForm->hasValue("testPaid") ? $CurrentForm->getValue("testPaid") : $CurrentForm->getValue("x_testPaid");
        if (!$this->testPaid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->testPaid->Visible = false; // Disable update for API request
            } else {
                $this->testPaid->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_testPaid")) {
            $this->testPaid->setOldValue($CurrentForm->getValue("o_testPaid"));
        }

        // Check field name 'result' first before field var 'x_result'
        $val = $CurrentForm->hasValue("result") ? $CurrentForm->getValue("result") : $CurrentForm->getValue("x_result");
        if (!$this->result->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->result->Visible = false; // Disable update for API request
            } else {
                $this->result->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_result")) {
            $this->result->setOldValue($CurrentForm->getValue("o_result"));
        }

        // Check field name 'nextRankId' first before field var 'x_nextRankId'
        $val = $CurrentForm->hasValue("nextRankId") ? $CurrentForm->getValue("nextRankId") : $CurrentForm->getValue("x_nextRankId");
        if (!$this->nextRankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nextRankId->Visible = false; // Disable update for API request
            } else {
                $this->nextRankId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nextRankId")) {
            $this->nextRankId->setOldValue($CurrentForm->getValue("o_nextRankId"));
        }

        // Check field name 'memberAge' first before field var 'x_memberAge'
        $val = $CurrentForm->hasValue("memberAge") ? $CurrentForm->getValue("memberAge") : $CurrentForm->getValue("x_memberAge");
        if (!$this->memberAge->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberAge->Visible = false; // Disable update for API request
            } else {
                $this->memberAge->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_memberAge")) {
            $this->memberAge->setOldValue($CurrentForm->getValue("o_memberAge"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->memberId->CurrentValue = $this->memberId->FormValue;
        $this->rankId->CurrentValue = $this->rankId->FormValue;
        $this->testNominated->CurrentValue = $this->testNominated->FormValue;
        $this->testPaid->CurrentValue = $this->testPaid->FormValue;
        $this->result->CurrentValue = $this->result->FormValue;
        $this->nextRankId->CurrentValue = $this->nextRankId->FormValue;
        $this->memberAge->CurrentValue = $this->memberAge->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
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
        $this->memberId->setDbValue($row['memberId']);
        $this->memberDOB->setDbValue($row['memberDOB']);
        $this->rankId->setDbValue($row['rankId']);
        $this->testNominated->setDbValue($row['testNominated']);
        $this->testPaid->setDbValue($row['testPaid']);
        $this->testId->setDbValue($row['testId']);
        $this->result->setDbValue($row['result']);
        $this->nextRankId->setDbValue($row['nextRankId']);
        $this->memberAge->setDbValue($row['memberAge']);
        $this->obs->setDbValue($row['obs']);
        $this->renew->setDbValue($row['renew']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->createUseriD->setDbValue($row['createUseriD']);
        $this->createDate->setDbValue($row['createDate']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['memberId'] = $this->memberId->DefaultValue;
        $row['memberDOB'] = $this->memberDOB->DefaultValue;
        $row['rankId'] = $this->rankId->DefaultValue;
        $row['testNominated'] = $this->testNominated->DefaultValue;
        $row['testPaid'] = $this->testPaid->DefaultValue;
        $row['testId'] = $this->testId->DefaultValue;
        $row['result'] = $this->result->DefaultValue;
        $row['nextRankId'] = $this->nextRankId->DefaultValue;
        $row['memberAge'] = $this->memberAge->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['renew'] = $this->renew->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['createUseriD'] = $this->createUseriD->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // memberId

        // memberDOB

        // rankId

        // testNominated

        // testPaid

        // testId

        // result

        // nextRankId

        // memberAge

        // obs

        // renew

        // schoolId

        // createUseriD

        // createDate

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // memberId
            $this->memberId->ViewValue = $this->memberId->CurrentValue;
            $curVal = strval($this->memberId->CurrentValue);
            if ($curVal != "") {
                $this->memberId->ViewValue = $this->memberId->lookupCacheOption($curVal);
                if ($this->memberId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberId->ViewValue = $this->memberId->displayValue($arwrk);
                    } else {
                        $this->memberId->ViewValue = FormatNumber($this->memberId->CurrentValue, $this->memberId->formatPattern());
                    }
                }
            } else {
                $this->memberId->ViewValue = null;
            }
            $this->memberId->ViewCustomAttributes = "";

            // memberDOB
            $this->memberDOB->ViewValue = $this->memberDOB->CurrentValue;
            $this->memberDOB->ViewValue = FormatDateTime($this->memberDOB->ViewValue, $this->memberDOB->formatPattern());
            $this->memberDOB->ViewCustomAttributes = "";

            // rankId
            $curVal = strval($this->rankId->CurrentValue);
            if ($curVal != "") {
                $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
                if ($this->rankId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->rankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->rankId->Lookup->renderViewRow($rswrk[0]);
                        $this->rankId->ViewValue = $this->rankId->displayValue($arwrk);
                    } else {
                        $this->rankId->ViewValue = FormatNumber($this->rankId->CurrentValue, $this->rankId->formatPattern());
                    }
                }
            } else {
                $this->rankId->ViewValue = null;
            }
            $this->rankId->ViewCustomAttributes = "";

            // testNominated
            if (ConvertToBool($this->testNominated->CurrentValue)) {
                $this->testNominated->ViewValue = $this->testNominated->tagCaption(1) != "" ? $this->testNominated->tagCaption(1) : "Yes";
            } else {
                $this->testNominated->ViewValue = $this->testNominated->tagCaption(2) != "" ? $this->testNominated->tagCaption(2) : "No";
            }
            $this->testNominated->ViewCustomAttributes = "";

            // testPaid
            if (ConvertToBool($this->testPaid->CurrentValue)) {
                $this->testPaid->ViewValue = $this->testPaid->tagCaption(1) != "" ? $this->testPaid->tagCaption(1) : "Yes";
            } else {
                $this->testPaid->ViewValue = $this->testPaid->tagCaption(2) != "" ? $this->testPaid->tagCaption(2) : "No";
            }
            $this->testPaid->ViewCustomAttributes = "";

            // testId
            $this->testId->ViewValue = $this->testId->CurrentValue;
            $curVal = strval($this->testId->CurrentValue);
            if ($curVal != "") {
                $this->testId->ViewValue = $this->testId->lookupCacheOption($curVal);
                if ($this->testId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->testId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->testId->Lookup->renderViewRow($rswrk[0]);
                        $this->testId->ViewValue = $this->testId->displayValue($arwrk);
                    } else {
                        $this->testId->ViewValue = FormatNumber($this->testId->CurrentValue, $this->testId->formatPattern());
                    }
                }
            } else {
                $this->testId->ViewValue = null;
            }
            $this->testId->ViewCustomAttributes = "";

            // result
            if (ConvertToBool($this->result->CurrentValue)) {
                $this->result->ViewValue = $this->result->tagCaption(1) != "" ? $this->result->tagCaption(1) : "Yes";
            } else {
                $this->result->ViewValue = $this->result->tagCaption(2) != "" ? $this->result->tagCaption(2) : "No";
            }
            $this->result->ViewCustomAttributes = "";

            // nextRankId
            $curVal = strval($this->nextRankId->CurrentValue);
            if ($curVal != "") {
                $this->nextRankId->ViewValue = $this->nextRankId->lookupCacheOption($curVal);
                if ($this->nextRankId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->nextRankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->nextRankId->Lookup->renderViewRow($rswrk[0]);
                        $this->nextRankId->ViewValue = $this->nextRankId->displayValue($arwrk);
                    } else {
                        $this->nextRankId->ViewValue = FormatNumber($this->nextRankId->CurrentValue, $this->nextRankId->formatPattern());
                    }
                }
            } else {
                $this->nextRankId->ViewValue = null;
            }
            $this->nextRankId->ViewCustomAttributes = "";

            // memberAge
            $this->memberAge->ViewValue = $this->memberAge->CurrentValue;
            $this->memberAge->ViewValue = FormatNumber($this->memberAge->ViewValue, $this->memberAge->formatPattern());
            $this->memberAge->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
            $this->schoolId->ViewValue = FormatNumber($this->schoolId->ViewValue, $this->schoolId->formatPattern());
            $this->schoolId->ViewCustomAttributes = "";

            // createUseriD
            $this->createUseriD->ViewValue = $this->createUseriD->CurrentValue;
            $curVal = strval($this->createUseriD->CurrentValue);
            if ($curVal != "") {
                $this->createUseriD->ViewValue = $this->createUseriD->lookupCacheOption($curVal);
                if ($this->createUseriD->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->createUseriD->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->createUseriD->Lookup->renderViewRow($rswrk[0]);
                        $this->createUseriD->ViewValue = $this->createUseriD->displayValue($arwrk);
                    } else {
                        $this->createUseriD->ViewValue = FormatNumber($this->createUseriD->CurrentValue, $this->createUseriD->formatPattern());
                    }
                }
            } else {
                $this->createUseriD->ViewValue = null;
            }
            $this->createUseriD->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // memberId
            $this->memberId->LinkCustomAttributes = "";
            $this->memberId->HrefValue = "";
            $this->memberId->TooltipValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";
            $this->rankId->TooltipValue = "";

            // testNominated
            $this->testNominated->LinkCustomAttributes = "";
            $this->testNominated->HrefValue = "";
            $this->testNominated->TooltipValue = "";

            // testPaid
            $this->testPaid->LinkCustomAttributes = "";
            $this->testPaid->HrefValue = "";
            $this->testPaid->TooltipValue = "";

            // result
            $this->result->LinkCustomAttributes = "";
            $this->result->HrefValue = "";
            $this->result->TooltipValue = "";

            // nextRankId
            $this->nextRankId->LinkCustomAttributes = "";
            $this->nextRankId->HrefValue = "";
            $this->nextRankId->TooltipValue = "";

            // memberAge
            $this->memberAge->LinkCustomAttributes = "";
            $this->memberAge->HrefValue = "";
            $this->memberAge->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

            // memberId
            $this->memberId->setupEditAttributes();
            $this->memberId->EditCustomAttributes = "";
            $this->memberId->EditValue = HtmlEncode($this->memberId->CurrentValue);
            $curVal = strval($this->memberId->CurrentValue);
            if ($curVal != "") {
                $this->memberId->EditValue = $this->memberId->lookupCacheOption($curVal);
                if ($this->memberId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberId->EditValue = $this->memberId->displayValue($arwrk);
                    } else {
                        $this->memberId->EditValue = HtmlEncode(FormatNumber($this->memberId->CurrentValue, $this->memberId->formatPattern()));
                    }
                }
            } else {
                $this->memberId->EditValue = null;
            }
            $this->memberId->PlaceHolder = RemoveHtml($this->memberId->caption());

            // rankId
            $this->rankId->setupEditAttributes();
            $this->rankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->rankId->CurrentValue));
            if ($curVal != "") {
                $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
            } else {
                $this->rankId->ViewValue = $this->rankId->Lookup !== null && is_array($this->rankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->rankId->ViewValue !== null) { // Load from cache
                $this->rankId->EditValue = array_values($this->rankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->rankId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->rankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->rankId->EditValue = $arwrk;
            }
            $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());

            // testNominated
            $this->testNominated->EditCustomAttributes = "";
            $this->testNominated->EditValue = $this->testNominated->options(false);
            $this->testNominated->PlaceHolder = RemoveHtml($this->testNominated->caption());

            // testPaid
            $this->testPaid->EditCustomAttributes = "";
            $this->testPaid->EditValue = $this->testPaid->options(false);
            $this->testPaid->PlaceHolder = RemoveHtml($this->testPaid->caption());

            // result
            $this->result->EditCustomAttributes = "";
            $this->result->EditValue = $this->result->options(false);
            $this->result->PlaceHolder = RemoveHtml($this->result->caption());

            // nextRankId
            $this->nextRankId->setupEditAttributes();
            $this->nextRankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->nextRankId->CurrentValue));
            if ($curVal != "") {
                $this->nextRankId->ViewValue = $this->nextRankId->lookupCacheOption($curVal);
            } else {
                $this->nextRankId->ViewValue = $this->nextRankId->Lookup !== null && is_array($this->nextRankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->nextRankId->ViewValue !== null) { // Load from cache
                $this->nextRankId->EditValue = array_values($this->nextRankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->nextRankId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->nextRankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->nextRankId->EditValue = $arwrk;
            }
            $this->nextRankId->PlaceHolder = RemoveHtml($this->nextRankId->caption());

            // memberAge
            $this->memberAge->setupEditAttributes();
            $this->memberAge->EditCustomAttributes = "";
            $this->memberAge->EditValue = HtmlEncode($this->memberAge->CurrentValue);
            $this->memberAge->PlaceHolder = RemoveHtml($this->memberAge->caption());
            if (strval($this->memberAge->EditValue) != "" && is_numeric($this->memberAge->EditValue)) {
                $this->memberAge->EditValue = FormatNumber($this->memberAge->EditValue, null);
                $this->memberAge->OldValue = $this->memberAge->EditValue;
            }

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // memberId
            $this->memberId->LinkCustomAttributes = "";
            $this->memberId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // testNominated
            $this->testNominated->LinkCustomAttributes = "";
            $this->testNominated->HrefValue = "";

            // testPaid
            $this->testPaid->LinkCustomAttributes = "";
            $this->testPaid->HrefValue = "";

            // result
            $this->result->LinkCustomAttributes = "";
            $this->result->HrefValue = "";

            // nextRankId
            $this->nextRankId->LinkCustomAttributes = "";
            $this->nextRankId->HrefValue = "";

            // memberAge
            $this->memberAge->LinkCustomAttributes = "";
            $this->memberAge->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // memberId
            $this->memberId->setupEditAttributes();
            $this->memberId->EditCustomAttributes = "";
            $this->memberId->EditValue = HtmlEncode($this->memberId->CurrentValue);
            $curVal = strval($this->memberId->CurrentValue);
            if ($curVal != "") {
                $this->memberId->EditValue = $this->memberId->lookupCacheOption($curVal);
                if ($this->memberId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberId->EditValue = $this->memberId->displayValue($arwrk);
                    } else {
                        $this->memberId->EditValue = HtmlEncode(FormatNumber($this->memberId->CurrentValue, $this->memberId->formatPattern()));
                    }
                }
            } else {
                $this->memberId->EditValue = null;
            }
            $this->memberId->PlaceHolder = RemoveHtml($this->memberId->caption());

            // rankId
            $this->rankId->setupEditAttributes();
            $this->rankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->rankId->CurrentValue));
            if ($curVal != "") {
                $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
            } else {
                $this->rankId->ViewValue = $this->rankId->Lookup !== null && is_array($this->rankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->rankId->ViewValue !== null) { // Load from cache
                $this->rankId->EditValue = array_values($this->rankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->rankId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->rankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->rankId->EditValue = $arwrk;
            }
            $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());

            // testNominated
            $this->testNominated->EditCustomAttributes = "";
            $this->testNominated->EditValue = $this->testNominated->options(false);
            $this->testNominated->PlaceHolder = RemoveHtml($this->testNominated->caption());

            // testPaid
            $this->testPaid->EditCustomAttributes = "";
            $this->testPaid->EditValue = $this->testPaid->options(false);
            $this->testPaid->PlaceHolder = RemoveHtml($this->testPaid->caption());

            // result
            $this->result->EditCustomAttributes = "";
            $this->result->EditValue = $this->result->options(false);
            $this->result->PlaceHolder = RemoveHtml($this->result->caption());

            // nextRankId
            $this->nextRankId->setupEditAttributes();
            $this->nextRankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->nextRankId->CurrentValue));
            if ($curVal != "") {
                $this->nextRankId->ViewValue = $this->nextRankId->lookupCacheOption($curVal);
            } else {
                $this->nextRankId->ViewValue = $this->nextRankId->Lookup !== null && is_array($this->nextRankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->nextRankId->ViewValue !== null) { // Load from cache
                $this->nextRankId->EditValue = array_values($this->nextRankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->nextRankId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->nextRankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->nextRankId->EditValue = $arwrk;
            }
            $this->nextRankId->PlaceHolder = RemoveHtml($this->nextRankId->caption());

            // memberAge
            $this->memberAge->setupEditAttributes();
            $this->memberAge->EditCustomAttributes = "";
            $this->memberAge->EditValue = HtmlEncode($this->memberAge->CurrentValue);
            $this->memberAge->PlaceHolder = RemoveHtml($this->memberAge->caption());
            if (strval($this->memberAge->EditValue) != "" && is_numeric($this->memberAge->EditValue)) {
                $this->memberAge->EditValue = FormatNumber($this->memberAge->EditValue, null);
                $this->memberAge->OldValue = $this->memberAge->EditValue;
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // memberId
            $this->memberId->LinkCustomAttributes = "";
            $this->memberId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // testNominated
            $this->testNominated->LinkCustomAttributes = "";
            $this->testNominated->HrefValue = "";

            // testPaid
            $this->testPaid->LinkCustomAttributes = "";
            $this->testPaid->HrefValue = "";

            // result
            $this->result->LinkCustomAttributes = "";
            $this->result->HrefValue = "";

            // nextRankId
            $this->nextRankId->LinkCustomAttributes = "";
            $this->nextRankId->HrefValue = "";

            // memberAge
            $this->memberAge->LinkCustomAttributes = "";
            $this->memberAge->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // memberId
            $this->memberId->setupEditAttributes();
            $this->memberId->EditCustomAttributes = "";
            $this->memberId->EditValue = HtmlEncode($this->memberId->AdvancedSearch->SearchValue);
            $curVal = strval($this->memberId->AdvancedSearch->SearchValue);
            if ($curVal != "") {
                $this->memberId->EditValue = $this->memberId->lookupCacheOption($curVal);
                if ($this->memberId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberId->EditValue = $this->memberId->displayValue($arwrk);
                    } else {
                        $this->memberId->EditValue = HtmlEncode(FormatNumber($this->memberId->AdvancedSearch->SearchValue, $this->memberId->formatPattern()));
                    }
                }
            } else {
                $this->memberId->EditValue = null;
            }
            $this->memberId->PlaceHolder = RemoveHtml($this->memberId->caption());

            // rankId
            $this->rankId->setupEditAttributes();
            $this->rankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->rankId->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->rankId->AdvancedSearch->ViewValue = $this->rankId->lookupCacheOption($curVal);
            } else {
                $this->rankId->AdvancedSearch->ViewValue = $this->rankId->Lookup !== null && is_array($this->rankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->rankId->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->rankId->EditValue = array_values($this->rankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->rankId->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->rankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->rankId->EditValue = $arwrk;
            }
            $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());

            // testNominated
            $this->testNominated->EditCustomAttributes = "";
            $this->testNominated->EditValue = $this->testNominated->options(false);
            $this->testNominated->PlaceHolder = RemoveHtml($this->testNominated->caption());

            // testPaid
            $this->testPaid->EditCustomAttributes = "";
            $this->testPaid->EditValue = $this->testPaid->options(false);
            $this->testPaid->PlaceHolder = RemoveHtml($this->testPaid->caption());

            // result
            $this->result->EditCustomAttributes = "";
            $this->result->EditValue = $this->result->options(false);
            $this->result->PlaceHolder = RemoveHtml($this->result->caption());

            // nextRankId
            $this->nextRankId->setupEditAttributes();
            $this->nextRankId->EditCustomAttributes = "";
            $this->nextRankId->PlaceHolder = RemoveHtml($this->nextRankId->caption());

            // memberAge
            $this->memberAge->setupEditAttributes();
            $this->memberAge->EditCustomAttributes = "";
            $this->memberAge->EditValue = HtmlEncode($this->memberAge->AdvancedSearch->SearchValue);
            $this->memberAge->PlaceHolder = RemoveHtml($this->memberAge->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->memberId->AdvancedSearch->SearchValue)) {
            $this->memberId->addErrorMessage($this->memberId->getErrorMessage(false));
        }
        if (!CheckInteger($this->memberAge->AdvancedSearch->SearchValue)) {
            $this->memberAge->addErrorMessage($this->memberAge->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
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
        if ($this->memberId->Required) {
            if (!$this->memberId->IsDetailKey && EmptyValue($this->memberId->FormValue)) {
                $this->memberId->addErrorMessage(str_replace("%s", $this->memberId->caption(), $this->memberId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->memberId->FormValue)) {
            $this->memberId->addErrorMessage($this->memberId->getErrorMessage(false));
        }
        if ($this->rankId->Required) {
            if (!$this->rankId->IsDetailKey && EmptyValue($this->rankId->FormValue)) {
                $this->rankId->addErrorMessage(str_replace("%s", $this->rankId->caption(), $this->rankId->RequiredErrorMessage));
            }
        }
        if ($this->testNominated->Required) {
            if ($this->testNominated->FormValue == "") {
                $this->testNominated->addErrorMessage(str_replace("%s", $this->testNominated->caption(), $this->testNominated->RequiredErrorMessage));
            }
        }
        if ($this->testPaid->Required) {
            if ($this->testPaid->FormValue == "") {
                $this->testPaid->addErrorMessage(str_replace("%s", $this->testPaid->caption(), $this->testPaid->RequiredErrorMessage));
            }
        }
        if ($this->result->Required) {
            if ($this->result->FormValue == "") {
                $this->result->addErrorMessage(str_replace("%s", $this->result->caption(), $this->result->RequiredErrorMessage));
            }
        }
        if ($this->nextRankId->Required) {
            if (!$this->nextRankId->IsDetailKey && EmptyValue($this->nextRankId->FormValue)) {
                $this->nextRankId->addErrorMessage(str_replace("%s", $this->nextRankId->caption(), $this->nextRankId->RequiredErrorMessage));
            }
        }
        if ($this->memberAge->Required) {
            if (!$this->memberAge->IsDetailKey && EmptyValue($this->memberAge->FormValue)) {
                $this->memberAge->addErrorMessage(str_replace("%s", $this->memberAge->caption(), $this->memberAge->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->memberAge->FormValue)) {
            $this->memberAge->addErrorMessage($this->memberAge->getErrorMessage(false));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

        // memberId
        $this->memberId->setDbValueDef($rsnew, $this->memberId->CurrentValue, null, $this->memberId->ReadOnly);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, $this->rankId->ReadOnly);

        // testNominated
        $tmpBool = $this->testNominated->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->testNominated->setDbValueDef($rsnew, $tmpBool, null, $this->testNominated->ReadOnly);

        // testPaid
        $tmpBool = $this->testPaid->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->testPaid->setDbValueDef($rsnew, $tmpBool, null, $this->testPaid->ReadOnly);

        // result
        $tmpBool = $this->result->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->result->setDbValueDef($rsnew, $tmpBool, null, $this->result->ReadOnly);

        // nextRankId
        $this->nextRankId->setDbValueDef($rsnew, $this->nextRankId->CurrentValue, null, $this->nextRankId->ReadOnly);

        // memberAge
        $this->memberAge->setDbValueDef($rsnew, $this->memberAge->CurrentValue, null, $this->memberAge->ReadOnly);

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

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['memberId']); // memberId
        $hash .= GetFieldHash($row['rankId']); // rankId
        $hash .= GetFieldHash($row['testNominated']); // testNominated
        $hash .= GetFieldHash($row['testPaid']); // testPaid
        $hash .= GetFieldHash($row['result']); // result
        $hash .= GetFieldHash($row['nextRankId']); // nextRankId
        $hash .= GetFieldHash($row['memberAge']); // memberAge
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set new row
        $rsnew = [];

        // memberId
        $this->memberId->setDbValueDef($rsnew, $this->memberId->CurrentValue, null, false);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, false);

        // testNominated
        $tmpBool = $this->testNominated->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->testNominated->setDbValueDef($rsnew, $tmpBool, null, false);

        // testPaid
        $tmpBool = $this->testPaid->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->testPaid->setDbValueDef($rsnew, $tmpBool, null, false);

        // result
        $tmpBool = $this->result->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->result->setDbValueDef($rsnew, $tmpBool, null, false);

        // nextRankId
        $this->nextRankId->setDbValueDef($rsnew, $this->nextRankId->CurrentValue, null, false);

        // memberAge
        $this->memberAge->setDbValueDef($rsnew, $this->memberAge->CurrentValue, null, false);

        // testId
        if ($this->testId->getSessionValue() != "") {
            $rsnew['testId'] = $this->testId->getSessionValue();
        }

        // schoolId
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['schoolId'] = CurrentUserID();
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $detailKeys = [];
            $detailKeys["testId"] = $this->testId->CurrentValue;
            $masterTable = Container("tes_test");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $validMasterKey = true;
                if ($rsmaster = $masterTable->loadRs($masterFilter)->fetchAssociative()) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['schoolId']);
                } elseif ($this->getCurrentMasterTable() == "tes_test") {
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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id->AdvancedSearch->load();
        $this->memberId->AdvancedSearch->load();
        $this->memberDOB->AdvancedSearch->load();
        $this->rankId->AdvancedSearch->load();
        $this->testNominated->AdvancedSearch->load();
        $this->testPaid->AdvancedSearch->load();
        $this->testId->AdvancedSearch->load();
        $this->result->AdvancedSearch->load();
        $this->nextRankId->AdvancedSearch->load();
        $this->memberAge->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->renew->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->createUseriD->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl(false);
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"ftes_candidatelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"ftes_candidatelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"ftes_candidatelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="ftes_candidatelist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = true;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = true;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"ftes_candidatesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->memberId->Visible || $this->rankId->Visible || $this->testPaid->Visible || $this->result->Visible || $this->memberAge->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($return = false)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $this->TotalRecords = $this->listRecordCount();
        $this->StartRecord = 1;

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        $this->ExportDoc = GetExportDocument($this, "h");
        $doc = &$this->ExportDoc;
        if (!$doc) {
            $this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $this->ExportDoc->ExportCustom = !$this->pageExporting();

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "tes_test") {
            $tes_test = new TesTestList();
            $rsmaster = $tes_test->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $tes_test;
                    $tes_test->exportDocument($doc, new Recordset($rsmaster));
                    $doc->exportEmptyRow();
                    $doc->Table = &$this;
                }
                $doc->setStyle($exportStyle); // Restore
            }
        }
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Close recordset
        $rs->close();

        // Call Page Exported server event
        $this->pageExported();

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Clean output buffer (without destroying output buffer)
        $buffer = ob_get_contents(); // Save the output buffer
        if (!Config("DEBUG") && $buffer) {
            ob_clean();
        }

        // Write debug message if enabled
        if (Config("DEBUG") && !$this->isExport("pdf")) {
            echo GetDebugMessage();
        }

        // Output data
        if ($this->isExport("email")) {
            // Export-to-email disabled
        } else {
            $doc->export();
            if ($return) {
                RemoveHeader("Content-Type"); // Remove header
                RemoveHeader("Content-Disposition");
                $content = ob_get_contents();
                if ($content) {
                    ob_clean();
                }
                if ($buffer) {
                    echo $buffer; // Resume the output buffer
                }
                return $content;
            }
        }
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
            if ($masterTblVar == "tes_test") {
                $validMaster = true;
                $masterTbl = Container("tes_test");
                if (($parm = Get("fk_id", Get("testId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->testId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->testId->setSessionValue($this->testId->QueryStringValue);
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
            if ($masterTblVar == "tes_test") {
                $validMaster = true;
                $masterTbl = Container("tes_test");
                if (($parm = Post("fk_id", Post("testId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->testId->setFormValue($masterTbl->id->FormValue);
                    $this->testId->setSessionValue($this->testId->FormValue);
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

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "tes_test") {
                if ($this->testId->CurrentValue == "") {
                    $this->testId->setSessionValue("");
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
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x_memberId":
                    break;
                case "x_rankId":
                    break;
                case "x_testNominated":
                    break;
                case "x_testPaid":
                    break;
                case "x_testId":
                    break;
                case "x_result":
                    break;
                case "x_nextRankId":
                    break;
                case "x_renew":
                    break;
                case "x_createUseriD":
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
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                $pageNo = ParseInteger($pageNo);
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
