<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class TesTestList extends TesTest
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tes_test';

    // Page object name
    public $PageObjName = "TesTestList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ftes_testlist";
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

        // Table object (tes_test)
        if (!isset($GLOBALS["tes_test"]) || get_class($GLOBALS["tes_test"]) == PROJECT_NAMESPACE . "tes_test") {
            $GLOBALS["tes_test"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "TesTestAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "TesTestDelete";
        $this->MultiUpdateUrl = "TesTestUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tes_test');
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
                $tbl = Container("tes_test");
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
            $this->createUserId->Visible = false;
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
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id->setVisibility();
        $this->description->setVisibility();
        $this->testCity->setVisibility();
        $this->federationId->Visible = false;
        $this->martialartsId->setVisibility();
        $this->schoolId->setVisibility();
        $this->instructorId->Visible = false;
        $this->auxiliarInstructorId->Visible = false;
        $this->testDate->setVisibility();
        $this->testTime->setVisibility();
        $this->ceremonyDate->setVisibility();
        $this->testTypeId->Visible = false;
        $this->testStatusId->Visible = false;
        $this->createUserId->Visible = false;
        $this->createDate->Visible = false;
        $this->judgeId->Visible = false;
        $this->certificateId->setVisibility();
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

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->testCity);
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->martialartsId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->instructorId);
        $this->setupLookupOptions($this->auxiliarInstructorId);
        $this->setupLookupOptions($this->testTypeId);
        $this->setupLookupOptions($this->testStatusId);
        $this->setupLookupOptions($this->createUserId);
        $this->setupLookupOptions($this->judgeId);
        $this->setupLookupOptions($this->certificateId);

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

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

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

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }

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
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }

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
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
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

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server" && isset($UserProfile)) {
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "ftes_testsrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->description->AdvancedSearch->toJson(), ","); // Field description
        $filterList = Concat($filterList, $this->testCity->AdvancedSearch->toJson(), ","); // Field testCity
        $filterList = Concat($filterList, $this->federationId->AdvancedSearch->toJson(), ","); // Field federationId
        $filterList = Concat($filterList, $this->martialartsId->AdvancedSearch->toJson(), ","); // Field martialartsId
        $filterList = Concat($filterList, $this->schoolId->AdvancedSearch->toJson(), ","); // Field schoolId
        $filterList = Concat($filterList, $this->instructorId->AdvancedSearch->toJson(), ","); // Field instructorId
        $filterList = Concat($filterList, $this->auxiliarInstructorId->AdvancedSearch->toJson(), ","); // Field auxiliarInstructorId
        $filterList = Concat($filterList, $this->testDate->AdvancedSearch->toJson(), ","); // Field testDate
        $filterList = Concat($filterList, $this->testTime->AdvancedSearch->toJson(), ","); // Field testTime
        $filterList = Concat($filterList, $this->ceremonyDate->AdvancedSearch->toJson(), ","); // Field ceremonyDate
        $filterList = Concat($filterList, $this->testTypeId->AdvancedSearch->toJson(), ","); // Field testTypeId
        $filterList = Concat($filterList, $this->testStatusId->AdvancedSearch->toJson(), ","); // Field testStatusId
        $filterList = Concat($filterList, $this->createUserId->AdvancedSearch->toJson(), ","); // Field createUserId
        $filterList = Concat($filterList, $this->createDate->AdvancedSearch->toJson(), ","); // Field createDate
        $filterList = Concat($filterList, $this->judgeId->AdvancedSearch->toJson(), ","); // Field judgeId
        $filterList = Concat($filterList, $this->certificateId->AdvancedSearch->toJson(), ","); // Field certificateId
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

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
            $UserProfile->setSearchFilters(CurrentUserName(), "ftes_testsrch", $filters);
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

        // Field description
        $this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
        $this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
        $this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
        $this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
        $this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
        $this->description->AdvancedSearch->save();

        // Field testCity
        $this->testCity->AdvancedSearch->SearchValue = @$filter["x_testCity"];
        $this->testCity->AdvancedSearch->SearchOperator = @$filter["z_testCity"];
        $this->testCity->AdvancedSearch->SearchCondition = @$filter["v_testCity"];
        $this->testCity->AdvancedSearch->SearchValue2 = @$filter["y_testCity"];
        $this->testCity->AdvancedSearch->SearchOperator2 = @$filter["w_testCity"];
        $this->testCity->AdvancedSearch->save();

        // Field federationId
        $this->federationId->AdvancedSearch->SearchValue = @$filter["x_federationId"];
        $this->federationId->AdvancedSearch->SearchOperator = @$filter["z_federationId"];
        $this->federationId->AdvancedSearch->SearchCondition = @$filter["v_federationId"];
        $this->federationId->AdvancedSearch->SearchValue2 = @$filter["y_federationId"];
        $this->federationId->AdvancedSearch->SearchOperator2 = @$filter["w_federationId"];
        $this->federationId->AdvancedSearch->save();

        // Field martialartsId
        $this->martialartsId->AdvancedSearch->SearchValue = @$filter["x_martialartsId"];
        $this->martialartsId->AdvancedSearch->SearchOperator = @$filter["z_martialartsId"];
        $this->martialartsId->AdvancedSearch->SearchCondition = @$filter["v_martialartsId"];
        $this->martialartsId->AdvancedSearch->SearchValue2 = @$filter["y_martialartsId"];
        $this->martialartsId->AdvancedSearch->SearchOperator2 = @$filter["w_martialartsId"];
        $this->martialartsId->AdvancedSearch->save();

        // Field schoolId
        $this->schoolId->AdvancedSearch->SearchValue = @$filter["x_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator = @$filter["z_schoolId"];
        $this->schoolId->AdvancedSearch->SearchCondition = @$filter["v_schoolId"];
        $this->schoolId->AdvancedSearch->SearchValue2 = @$filter["y_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator2 = @$filter["w_schoolId"];
        $this->schoolId->AdvancedSearch->save();

        // Field instructorId
        $this->instructorId->AdvancedSearch->SearchValue = @$filter["x_instructorId"];
        $this->instructorId->AdvancedSearch->SearchOperator = @$filter["z_instructorId"];
        $this->instructorId->AdvancedSearch->SearchCondition = @$filter["v_instructorId"];
        $this->instructorId->AdvancedSearch->SearchValue2 = @$filter["y_instructorId"];
        $this->instructorId->AdvancedSearch->SearchOperator2 = @$filter["w_instructorId"];
        $this->instructorId->AdvancedSearch->save();

        // Field auxiliarInstructorId
        $this->auxiliarInstructorId->AdvancedSearch->SearchValue = @$filter["x_auxiliarInstructorId"];
        $this->auxiliarInstructorId->AdvancedSearch->SearchOperator = @$filter["z_auxiliarInstructorId"];
        $this->auxiliarInstructorId->AdvancedSearch->SearchCondition = @$filter["v_auxiliarInstructorId"];
        $this->auxiliarInstructorId->AdvancedSearch->SearchValue2 = @$filter["y_auxiliarInstructorId"];
        $this->auxiliarInstructorId->AdvancedSearch->SearchOperator2 = @$filter["w_auxiliarInstructorId"];
        $this->auxiliarInstructorId->AdvancedSearch->save();

        // Field testDate
        $this->testDate->AdvancedSearch->SearchValue = @$filter["x_testDate"];
        $this->testDate->AdvancedSearch->SearchOperator = @$filter["z_testDate"];
        $this->testDate->AdvancedSearch->SearchCondition = @$filter["v_testDate"];
        $this->testDate->AdvancedSearch->SearchValue2 = @$filter["y_testDate"];
        $this->testDate->AdvancedSearch->SearchOperator2 = @$filter["w_testDate"];
        $this->testDate->AdvancedSearch->save();

        // Field testTime
        $this->testTime->AdvancedSearch->SearchValue = @$filter["x_testTime"];
        $this->testTime->AdvancedSearch->SearchOperator = @$filter["z_testTime"];
        $this->testTime->AdvancedSearch->SearchCondition = @$filter["v_testTime"];
        $this->testTime->AdvancedSearch->SearchValue2 = @$filter["y_testTime"];
        $this->testTime->AdvancedSearch->SearchOperator2 = @$filter["w_testTime"];
        $this->testTime->AdvancedSearch->save();

        // Field ceremonyDate
        $this->ceremonyDate->AdvancedSearch->SearchValue = @$filter["x_ceremonyDate"];
        $this->ceremonyDate->AdvancedSearch->SearchOperator = @$filter["z_ceremonyDate"];
        $this->ceremonyDate->AdvancedSearch->SearchCondition = @$filter["v_ceremonyDate"];
        $this->ceremonyDate->AdvancedSearch->SearchValue2 = @$filter["y_ceremonyDate"];
        $this->ceremonyDate->AdvancedSearch->SearchOperator2 = @$filter["w_ceremonyDate"];
        $this->ceremonyDate->AdvancedSearch->save();

        // Field testTypeId
        $this->testTypeId->AdvancedSearch->SearchValue = @$filter["x_testTypeId"];
        $this->testTypeId->AdvancedSearch->SearchOperator = @$filter["z_testTypeId"];
        $this->testTypeId->AdvancedSearch->SearchCondition = @$filter["v_testTypeId"];
        $this->testTypeId->AdvancedSearch->SearchValue2 = @$filter["y_testTypeId"];
        $this->testTypeId->AdvancedSearch->SearchOperator2 = @$filter["w_testTypeId"];
        $this->testTypeId->AdvancedSearch->save();

        // Field testStatusId
        $this->testStatusId->AdvancedSearch->SearchValue = @$filter["x_testStatusId"];
        $this->testStatusId->AdvancedSearch->SearchOperator = @$filter["z_testStatusId"];
        $this->testStatusId->AdvancedSearch->SearchCondition = @$filter["v_testStatusId"];
        $this->testStatusId->AdvancedSearch->SearchValue2 = @$filter["y_testStatusId"];
        $this->testStatusId->AdvancedSearch->SearchOperator2 = @$filter["w_testStatusId"];
        $this->testStatusId->AdvancedSearch->save();

        // Field createUserId
        $this->createUserId->AdvancedSearch->SearchValue = @$filter["x_createUserId"];
        $this->createUserId->AdvancedSearch->SearchOperator = @$filter["z_createUserId"];
        $this->createUserId->AdvancedSearch->SearchCondition = @$filter["v_createUserId"];
        $this->createUserId->AdvancedSearch->SearchValue2 = @$filter["y_createUserId"];
        $this->createUserId->AdvancedSearch->SearchOperator2 = @$filter["w_createUserId"];
        $this->createUserId->AdvancedSearch->save();

        // Field createDate
        $this->createDate->AdvancedSearch->SearchValue = @$filter["x_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator = @$filter["z_createDate"];
        $this->createDate->AdvancedSearch->SearchCondition = @$filter["v_createDate"];
        $this->createDate->AdvancedSearch->SearchValue2 = @$filter["y_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator2 = @$filter["w_createDate"];
        $this->createDate->AdvancedSearch->save();

        // Field judgeId
        $this->judgeId->AdvancedSearch->SearchValue = @$filter["x_judgeId"];
        $this->judgeId->AdvancedSearch->SearchOperator = @$filter["z_judgeId"];
        $this->judgeId->AdvancedSearch->SearchCondition = @$filter["v_judgeId"];
        $this->judgeId->AdvancedSearch->SearchValue2 = @$filter["y_judgeId"];
        $this->judgeId->AdvancedSearch->SearchOperator2 = @$filter["w_judgeId"];
        $this->judgeId->AdvancedSearch->save();

        // Field certificateId
        $this->certificateId->AdvancedSearch->SearchValue = @$filter["x_certificateId"];
        $this->certificateId->AdvancedSearch->SearchOperator = @$filter["z_certificateId"];
        $this->certificateId->AdvancedSearch->SearchCondition = @$filter["v_certificateId"];
        $this->certificateId->AdvancedSearch->SearchValue2 = @$filter["y_certificateId"];
        $this->certificateId->AdvancedSearch->SearchOperator2 = @$filter["w_certificateId"];
        $this->certificateId->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
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
        $this->buildSearchSql($where, $this->description, $default, false); // description
        $this->buildSearchSql($where, $this->testCity, $default, false); // testCity
        $this->buildSearchSql($where, $this->federationId, $default, false); // federationId
        $this->buildSearchSql($where, $this->martialartsId, $default, false); // martialartsId
        $this->buildSearchSql($where, $this->schoolId, $default, false); // schoolId
        $this->buildSearchSql($where, $this->instructorId, $default, false); // instructorId
        $this->buildSearchSql($where, $this->auxiliarInstructorId, $default, false); // auxiliarInstructorId
        $this->buildSearchSql($where, $this->testDate, $default, false); // testDate
        $this->buildSearchSql($where, $this->testTime, $default, false); // testTime
        $this->buildSearchSql($where, $this->ceremonyDate, $default, false); // ceremonyDate
        $this->buildSearchSql($where, $this->testTypeId, $default, false); // testTypeId
        $this->buildSearchSql($where, $this->testStatusId, $default, false); // testStatusId
        $this->buildSearchSql($where, $this->createUserId, $default, false); // createUserId
        $this->buildSearchSql($where, $this->createDate, $default, false); // createDate
        $this->buildSearchSql($where, $this->judgeId, $default, false); // judgeId
        $this->buildSearchSql($where, $this->certificateId, $default, false); // certificateId

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->description->AdvancedSearch->save(); // description
            $this->testCity->AdvancedSearch->save(); // testCity
            $this->federationId->AdvancedSearch->save(); // federationId
            $this->martialartsId->AdvancedSearch->save(); // martialartsId
            $this->schoolId->AdvancedSearch->save(); // schoolId
            $this->instructorId->AdvancedSearch->save(); // instructorId
            $this->auxiliarInstructorId->AdvancedSearch->save(); // auxiliarInstructorId
            $this->testDate->AdvancedSearch->save(); // testDate
            $this->testTime->AdvancedSearch->save(); // testTime
            $this->ceremonyDate->AdvancedSearch->save(); // ceremonyDate
            $this->testTypeId->AdvancedSearch->save(); // testTypeId
            $this->testStatusId->AdvancedSearch->save(); // testStatusId
            $this->createUserId->AdvancedSearch->save(); // createUserId
            $this->createDate->AdvancedSearch->save(); // createDate
            $this->judgeId->AdvancedSearch->save(); // judgeId
            $this->certificateId->AdvancedSearch->save(); // certificateId
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

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->description;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->description->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testCity->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->federationId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->martialartsId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->schoolId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->instructorId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->auxiliarInstructorId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testTime->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ceremonyDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testTypeId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->testStatusId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createUserId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->judgeId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->certificateId->AdvancedSearch->issetSession()) {
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

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->id->AdvancedSearch->unsetSession();
        $this->description->AdvancedSearch->unsetSession();
        $this->testCity->AdvancedSearch->unsetSession();
        $this->federationId->AdvancedSearch->unsetSession();
        $this->martialartsId->AdvancedSearch->unsetSession();
        $this->schoolId->AdvancedSearch->unsetSession();
        $this->instructorId->AdvancedSearch->unsetSession();
        $this->auxiliarInstructorId->AdvancedSearch->unsetSession();
        $this->testDate->AdvancedSearch->unsetSession();
        $this->testTime->AdvancedSearch->unsetSession();
        $this->ceremonyDate->AdvancedSearch->unsetSession();
        $this->testTypeId->AdvancedSearch->unsetSession();
        $this->testStatusId->AdvancedSearch->unsetSession();
        $this->createUserId->AdvancedSearch->unsetSession();
        $this->createDate->AdvancedSearch->unsetSession();
        $this->judgeId->AdvancedSearch->unsetSession();
        $this->certificateId->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->id->AdvancedSearch->load();
        $this->description->AdvancedSearch->load();
        $this->testCity->AdvancedSearch->load();
        $this->federationId->AdvancedSearch->load();
        $this->martialartsId->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->instructorId->AdvancedSearch->load();
        $this->auxiliarInstructorId->AdvancedSearch->load();
        $this->testDate->AdvancedSearch->load();
        $this->testTime->AdvancedSearch->load();
        $this->ceremonyDate->AdvancedSearch->load();
        $this->testTypeId->AdvancedSearch->load();
        $this->testStatusId->AdvancedSearch->load();
        $this->createUserId->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
        $this->judgeId->AdvancedSearch->load();
        $this->certificateId->AdvancedSearch->load();
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
            $defaultSortList = ""; // Set up default sort
            if ($this->getSessionOrderByList() == "" && $defaultSortList != "") {
                $this->setSessionOrderByList($defaultSortList);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->description); // description
            $this->updateSort($this->testCity); // testCity
            $this->updateSort($this->martialartsId); // martialartsId
            $this->updateSort($this->schoolId); // schoolId
            $this->updateSort($this->testDate); // testDate
            $this->updateSort($this->testTime); // testTime
            $this->updateSort($this->ceremonyDate); // ceremonyDate
            $this->updateSort($this->certificateId); // certificateId
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

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->setSessionOrderByList($orderBy);
                $this->id->setSort("");
                $this->description->setSort("");
                $this->testCity->setSort("");
                $this->federationId->setSort("");
                $this->martialartsId->setSort("");
                $this->schoolId->setSort("");
                $this->instructorId->setSort("");
                $this->auxiliarInstructorId->setSort("");
                $this->testDate->setSort("");
                $this->testTime->setSort("");
                $this->ceremonyDate->setSort("");
                $this->testTypeId->setSort("");
                $this->testStatusId->setSort("");
                $this->createUserId->setSort("");
                $this->createDate->setSort("");
                $this->judgeId->setSort("");
                $this->certificateId->setSort("");
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

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // "detail_tes_candidate"
        $item = &$this->ListOptions->add("detail_tes_candidate");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'tes_candidate');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_view_test_aproveds"
        $item = &$this->ListOptions->add("detail_view_test_aproveds");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'view_test_aproveds');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = true;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("tes_candidate");
        $pages->add("view_test_aproveds");
        $this->DetailPages = $pages;

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
        $this->ListOptions->UseButtonGroup = true;
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
        $pageUrl = $this->pageUrl(false);
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
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd() && $this->showOptionLink("add")) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete() && $this->showOptionLink("delete")) {
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ftes_testlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ftes_testlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_tes_candidate"
        $opt = $this->ListOptions["detail_tes_candidate"];
        if ($Security->allowList(CurrentProjectID() . 'tes_candidate') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("tes_candidate", "TblCaption");
            if (!$this->ShowMultipleDetails) { // Skip loading record count if show multiple details
                $detailTbl = Container("tes_candidate");
                $detailFilter = $detailTbl->getDetailFilter($this);
                $detailTbl->setCurrentMasterTable($this->TableVar);
                $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $body .= "&nbsp;" . str_replace("%c", Container("tes_candidate")->Count, $Language->phrase("DetailCount"));
            }
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("TesCandidateList?" . Config("TABLE_SHOW_MASTER") . "=tes_test&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("TesCandidateGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "tes_candidate";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "tes_candidate";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "tes_candidate";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_view_test_aproveds"
        $opt = $this->ListOptions["detail_view_test_aproveds"];
        if ($Security->allowList(CurrentProjectID() . 'view_test_aproveds') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("view_test_aproveds", "TblCaption");
            if (!$this->ShowMultipleDetails) { // Skip loading record count if show multiple details
                $detailTbl = Container("view_test_aproveds");
                $detailFilter = $detailTbl->getDetailFilter($this);
                $detailTbl->setCurrentMasterTable($this->TableVar);
                $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $body .= "&nbsp;" . str_replace("%c", Container("view_test_aproveds")->Count, $Language->phrase("DetailCount"));
            }
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("ViewTestAprovedsList?" . Config("TABLE_SHOW_MASTER") . "=tes_test&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ViewTestAprovedsGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "view_test_aproveds";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "view_test_aproveds";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "view_test_aproveds";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
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

        // Preview extension
        $links = "";
        $sqlwrk = "`testId`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_tes_candidate"
        if ($this->DetailPages && $this->DetailPages["tes_candidate"] && $this->DetailPages["tes_candidate"]->Visible && $Security->allowList(CurrentProjectID() . 'tes_candidate')) {
            $link = "";
            $option = $this->ListOptions["detail_tes_candidate"];
            $url = "TesCandidatePreview?t=tes_test&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"tes_candidate\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group btn-group btn-group-sm d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'tes_test')) {
                $label = $Language->TablePhrase("tes_candidate", "TblCaption");
                if ($this->ShowMultipleDetails) { // Detail count not setup yet
                    $detailTbl = Container("tes_candidate");
                    $detailFilter = $detailTbl->getDetailFilter($this);
                    $detailTbl->setCurrentMasterTable($this->TableVar);
                    $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                    $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                }
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("tes_candidate")->Count, $Language->phrase("DetailCount")));
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"tes_candidate\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("TesCandidateList?" . Config("TABLE_SHOW_MASTER") . "=tes_test&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("tes_candidate", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</button>";
            }
            $detailPageObj = Container("TesCandidateGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</button>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</button>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }
        $sqlwrk = "`testId`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_view_test_aproveds"
        if ($this->DetailPages && $this->DetailPages["view_test_aproveds"] && $this->DetailPages["view_test_aproveds"]->Visible && $Security->allowList(CurrentProjectID() . 'view_test_aproveds')) {
            $link = "";
            $option = $this->ListOptions["detail_view_test_aproveds"];
            $url = "ViewTestAprovedsPreview?t=tes_test&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"view_test_aproveds\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group btn-group btn-group-sm d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'tes_test')) {
                $label = $Language->TablePhrase("view_test_aproveds", "TblCaption");
                if ($this->ShowMultipleDetails) { // Detail count not setup yet
                    $detailTbl = Container("view_test_aproveds");
                    $detailFilter = $detailTbl->getDetailFilter($this);
                    $detailTbl->setCurrentMasterTable($this->TableVar);
                    $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                    $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                }
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("view_test_aproveds")->Count, $Language->phrase("DetailCount")));
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"view_test_aproveds\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ViewTestAprovedsList?" . Config("TABLE_SHOW_MASTER") . "=tes_test&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("view_test_aproveds", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</button>";
            }
            $detailPageObj = Container("ViewTestAprovedsGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</button>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'tes_test')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds"));
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</button>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }

        // Add row attributes for expandable row
        if ($this->RowType == ROWTYPE_VIEW) {
            $this->RowAttrs["data-widget"] = "expandable-table";
            $this->RowAttrs["aria-expanded"] = "false";
        }

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = true;
            if ($option->OnLeft) {
                $option->moveTo($this->ListOptions->itemPos("checkbox") + 1);
            } else {
                $option->moveTo($this->ListOptions->itemPos("checkbox"));
            }
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $option->CssStyle = "width: 1%;";
            $icon = "fas fa-caret-right fa-fw"; // Right
            if (!$option->OnLeft) {
                $icon = preg_replace('/\\bright\\b/', "left", $icon);
            }
            if (IsRTL()) { // Reverse
                if (preg_match('/\\bleft\\b/', $icon)) {
                    $icon = preg_replace('/\\bleft\\b/', "right", $icon);
                } elseif (preg_match('/\\bright\\b/', $icon)) {
                    $icon = preg_replace('/\\bright\\b/', "left", $icon);
                }
            }
            $option->Body = "<i role=\"button\" class=\"ew-preview-btn expandable-table-caret ew-icon " . $icon . "\"></i>" .
                "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
                $item = &$option->add("detailadd_tes_candidate");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=tes_candidate");
                $detailPage = Container("TesCandidateGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'tes_test') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "tes_candidate";
                }
                $item = &$option->add("detailadd_view_test_aproveds");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=view_test_aproveds");
                $detailPage = Container("ViewTestAprovedsGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'tes_test') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "view_test_aproveds";
                }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("id", $this->createColumnOption("id"));
            $option->add("description", $this->createColumnOption("description"));
            $option->add("testCity", $this->createColumnOption("testCity"));
            $option->add("martialartsId", $this->createColumnOption("martialartsId"));
            $option->add("schoolId", $this->createColumnOption("schoolId"));
            $option->add("testDate", $this->createColumnOption("testDate"));
            $option->add("testTime", $this->createColumnOption("testTime"));
            $option->add("ceremonyDate", $this->createColumnOption("ceremonyDate"));
            $option->add("certificateId", $this->createColumnOption("certificateId"));
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = true;
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"ftes_testsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"ftes_testsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="ftes_testlist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
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

        // description
        if ($this->description->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->description->AdvancedSearch->SearchValue != "" || $this->description->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testCity
        if ($this->testCity->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testCity->AdvancedSearch->SearchValue != "" || $this->testCity->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // federationId
        if ($this->federationId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->federationId->AdvancedSearch->SearchValue != "" || $this->federationId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // martialartsId
        if ($this->martialartsId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->martialartsId->AdvancedSearch->SearchValue != "" || $this->martialartsId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // schoolId
        if ($this->schoolId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->schoolId->AdvancedSearch->SearchValue != "" || $this->schoolId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // instructorId
        if ($this->instructorId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->instructorId->AdvancedSearch->SearchValue != "" || $this->instructorId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // auxiliarInstructorId
        if ($this->auxiliarInstructorId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->auxiliarInstructorId->AdvancedSearch->SearchValue != "" || $this->auxiliarInstructorId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testDate
        if ($this->testDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testDate->AdvancedSearch->SearchValue != "" || $this->testDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testTime
        if ($this->testTime->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testTime->AdvancedSearch->SearchValue != "" || $this->testTime->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ceremonyDate
        if ($this->ceremonyDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ceremonyDate->AdvancedSearch->SearchValue != "" || $this->ceremonyDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testTypeId
        if ($this->testTypeId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testTypeId->AdvancedSearch->SearchValue != "" || $this->testTypeId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // testStatusId
        if ($this->testStatusId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->testStatusId->AdvancedSearch->SearchValue != "" || $this->testStatusId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // createUserId
        if ($this->createUserId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->createUserId->AdvancedSearch->SearchValue != "" || $this->createUserId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // judgeId
        if ($this->judgeId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->judgeId->AdvancedSearch->SearchValue != "" || $this->judgeId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // certificateId
        if ($this->certificateId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->certificateId->AdvancedSearch->SearchValue != "" || $this->certificateId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        $this->description->setDbValue($row['description']);
        $this->testCity->setDbValue($row['testCity']);
        if (array_key_exists('EV__testCity', $row)) {
            $this->testCity->VirtualValue = $row['EV__testCity']; // Set up virtual field value
        } else {
            $this->testCity->VirtualValue = ""; // Clear value
        }
        $this->federationId->setDbValue($row['federationId']);
        $this->martialartsId->setDbValue($row['martialartsId']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->instructorId->setDbValue($row['instructorId']);
        $this->auxiliarInstructorId->setDbValue($row['auxiliarInstructorId']);
        $this->testDate->setDbValue($row['testDate']);
        $this->testTime->setDbValue($row['testTime']);
        $this->ceremonyDate->setDbValue($row['ceremonyDate']);
        $this->testTypeId->setDbValue($row['testTypeId']);
        $this->testStatusId->setDbValue($row['testStatusId']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->judgeId->setDbValue($row['judgeId']);
        $this->certificateId->setDbValue($row['certificateId']);
        if (array_key_exists('EV__certificateId', $row)) {
            $this->certificateId->VirtualValue = $row['EV__certificateId']; // Set up virtual field value
        } else {
            $this->certificateId->VirtualValue = ""; // Clear value
        }
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['description'] = $this->description->DefaultValue;
        $row['testCity'] = $this->testCity->DefaultValue;
        $row['federationId'] = $this->federationId->DefaultValue;
        $row['martialartsId'] = $this->martialartsId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['instructorId'] = $this->instructorId->DefaultValue;
        $row['auxiliarInstructorId'] = $this->auxiliarInstructorId->DefaultValue;
        $row['testDate'] = $this->testDate->DefaultValue;
        $row['testTime'] = $this->testTime->DefaultValue;
        $row['ceremonyDate'] = $this->ceremonyDate->DefaultValue;
        $row['testTypeId'] = $this->testTypeId->DefaultValue;
        $row['testStatusId'] = $this->testStatusId->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['judgeId'] = $this->judgeId->DefaultValue;
        $row['certificateId'] = $this->certificateId->DefaultValue;
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

        // description

        // testCity

        // federationId

        // martialartsId

        // schoolId

        // instructorId

        // auxiliarInstructorId

        // testDate

        // testTime

        // ceremonyDate

        // testTypeId

        // testStatusId

        // createUserId

        // createDate

        // judgeId

        // certificateId

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // testCity
            if ($this->testCity->VirtualValue != "") {
                $this->testCity->ViewValue = $this->testCity->VirtualValue;
            } else {
                $curVal = strval($this->testCity->CurrentValue);
                if ($curVal != "") {
                    $this->testCity->ViewValue = $this->testCity->lookupCacheOption($curVal);
                    if ($this->testCity->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->testCity->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->testCity->Lookup->renderViewRow($rswrk[0]);
                            $this->testCity->ViewValue = $this->testCity->displayValue($arwrk);
                        } else {
                            $this->testCity->ViewValue = FormatNumber($this->testCity->CurrentValue, $this->testCity->formatPattern());
                        }
                    }
                } else {
                    $this->testCity->ViewValue = null;
                }
            }
            $this->testCity->ViewCustomAttributes = "";

            // federationId
            $curVal = strval($this->federationId->CurrentValue);
            if ($curVal != "") {
                $this->federationId->ViewValue = $this->federationId->lookupCacheOption($curVal);
                if ($this->federationId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->federationId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->federationId->Lookup->renderViewRow($rswrk[0]);
                        $this->federationId->ViewValue = $this->federationId->displayValue($arwrk);
                    } else {
                        $this->federationId->ViewValue = FormatNumber($this->federationId->CurrentValue, $this->federationId->formatPattern());
                    }
                }
            } else {
                $this->federationId->ViewValue = null;
            }
            $this->federationId->ViewCustomAttributes = "";

            // martialartsId
            $curVal = strval($this->martialartsId->CurrentValue);
            if ($curVal != "") {
                $this->martialartsId->ViewValue = $this->martialartsId->lookupCacheOption($curVal);
                if ($this->martialartsId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialartsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialartsId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialartsId->ViewValue = $this->martialartsId->displayValue($arwrk);
                    } else {
                        $this->martialartsId->ViewValue = FormatNumber($this->martialartsId->CurrentValue, $this->martialartsId->formatPattern());
                    }
                }
            } else {
                $this->martialartsId->ViewValue = null;
            }
            $this->martialartsId->ViewCustomAttributes = "";

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

            // instructorId
            $this->instructorId->ViewValue = $this->instructorId->CurrentValue;
            $curVal = strval($this->instructorId->CurrentValue);
            if ($curVal != "") {
                $this->instructorId->ViewValue = $this->instructorId->lookupCacheOption($curVal);
                if ($this->instructorId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->instructorId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->instructorId->Lookup->renderViewRow($rswrk[0]);
                        $this->instructorId->ViewValue = $this->instructorId->displayValue($arwrk);
                    } else {
                        $this->instructorId->ViewValue = FormatNumber($this->instructorId->CurrentValue, $this->instructorId->formatPattern());
                    }
                }
            } else {
                $this->instructorId->ViewValue = null;
            }
            $this->instructorId->ViewCustomAttributes = "";

            // auxiliarInstructorId
            $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->CurrentValue;
            $curVal = strval($this->auxiliarInstructorId->CurrentValue);
            if ($curVal != "") {
                $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->lookupCacheOption($curVal);
                if ($this->auxiliarInstructorId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->auxiliarInstructorId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->auxiliarInstructorId->Lookup->renderViewRow($rswrk[0]);
                        $this->auxiliarInstructorId->ViewValue = $this->auxiliarInstructorId->displayValue($arwrk);
                    } else {
                        $this->auxiliarInstructorId->ViewValue = FormatNumber($this->auxiliarInstructorId->CurrentValue, $this->auxiliarInstructorId->formatPattern());
                    }
                }
            } else {
                $this->auxiliarInstructorId->ViewValue = null;
            }
            $this->auxiliarInstructorId->ViewCustomAttributes = "";

            // testDate
            $this->testDate->ViewValue = $this->testDate->CurrentValue;
            $this->testDate->ViewValue = FormatDateTime($this->testDate->ViewValue, $this->testDate->formatPattern());
            $this->testDate->ViewCustomAttributes = "";

            // testTime
            $this->testTime->ViewValue = $this->testTime->CurrentValue;
            $this->testTime->ViewValue = FormatDateTime($this->testTime->ViewValue, $this->testTime->formatPattern());
            $this->testTime->ViewCustomAttributes = "";

            // ceremonyDate
            $this->ceremonyDate->ViewValue = $this->ceremonyDate->CurrentValue;
            $this->ceremonyDate->ViewValue = FormatDateTime($this->ceremonyDate->ViewValue, $this->ceremonyDate->formatPattern());
            $this->ceremonyDate->ViewCustomAttributes = "";

            // testTypeId
            if (strval($this->testTypeId->CurrentValue) != "") {
                $this->testTypeId->ViewValue = $this->testTypeId->optionCaption($this->testTypeId->CurrentValue);
            } else {
                $this->testTypeId->ViewValue = null;
            }
            $this->testTypeId->ViewCustomAttributes = "";

            // testStatusId
            $this->testStatusId->ViewValue = $this->testStatusId->CurrentValue;
            $curVal = strval($this->testStatusId->CurrentValue);
            if ($curVal != "") {
                $this->testStatusId->ViewValue = $this->testStatusId->lookupCacheOption($curVal);
                if ($this->testStatusId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->testStatusId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->testStatusId->Lookup->renderViewRow($rswrk[0]);
                        $this->testStatusId->ViewValue = $this->testStatusId->displayValue($arwrk);
                    } else {
                        $this->testStatusId->ViewValue = FormatNumber($this->testStatusId->CurrentValue, $this->testStatusId->formatPattern());
                    }
                }
            } else {
                $this->testStatusId->ViewValue = null;
            }
            $this->testStatusId->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $curVal = strval($this->createUserId->CurrentValue);
            if ($curVal != "") {
                $this->createUserId->ViewValue = $this->createUserId->lookupCacheOption($curVal);
                if ($this->createUserId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // judgeId
            $curVal = strval($this->judgeId->CurrentValue);
            if ($curVal != "") {
                $this->judgeId->ViewValue = $this->judgeId->lookupCacheOption($curVal);
                if ($this->judgeId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->judgeId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->judgeId->Lookup->renderViewRow($rswrk[0]);
                        $this->judgeId->ViewValue = $this->judgeId->displayValue($arwrk);
                    } else {
                        $this->judgeId->ViewValue = FormatNumber($this->judgeId->CurrentValue, $this->judgeId->formatPattern());
                    }
                }
            } else {
                $this->judgeId->ViewValue = null;
            }
            $this->judgeId->ViewCustomAttributes = "";

            // certificateId
            if ($this->certificateId->VirtualValue != "") {
                $this->certificateId->ViewValue = $this->certificateId->VirtualValue;
            } else {
                $curVal = strval($this->certificateId->CurrentValue);
                if ($curVal != "") {
                    $this->certificateId->ViewValue = $this->certificateId->lookupCacheOption($curVal);
                    if ($this->certificateId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->certificateId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->certificateId->Lookup->renderViewRow($rswrk[0]);
                            $this->certificateId->ViewValue = $this->certificateId->displayValue($arwrk);
                        } else {
                            $this->certificateId->ViewValue = FormatNumber($this->certificateId->CurrentValue, $this->certificateId->formatPattern());
                        }
                    }
                } else {
                    $this->certificateId->ViewValue = null;
                }
            }
            $this->certificateId->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";
            $this->description->TooltipValue = "";

            // testCity
            $this->testCity->LinkCustomAttributes = "";
            $this->testCity->HrefValue = "";
            $this->testCity->TooltipValue = "";

            // martialartsId
            $this->martialartsId->LinkCustomAttributes = "";
            $this->martialartsId->HrefValue = "";
            $this->martialartsId->TooltipValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";
            $this->schoolId->TooltipValue = "";

            // testDate
            $this->testDate->LinkCustomAttributes = "";
            $this->testDate->HrefValue = "";
            $this->testDate->TooltipValue = "";

            // testTime
            $this->testTime->LinkCustomAttributes = "";
            $this->testTime->HrefValue = "";
            $this->testTime->TooltipValue = "";

            // ceremonyDate
            $this->ceremonyDate->LinkCustomAttributes = "";
            $this->ceremonyDate->HrefValue = "";
            $this->ceremonyDate->TooltipValue = "";

            // certificateId
            $this->certificateId->LinkCustomAttributes = "";
            $this->certificateId->HrefValue = "";
            $this->certificateId->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // description
            $this->description->setupEditAttributes();
            $this->description->EditCustomAttributes = "";
            $this->description->EditValue = HtmlEncode($this->description->AdvancedSearch->SearchValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // testCity
            $this->testCity->setupEditAttributes();
            $this->testCity->EditCustomAttributes = "";
            $this->testCity->EditValue = HtmlEncode($this->testCity->AdvancedSearch->SearchValue);
            $this->testCity->PlaceHolder = RemoveHtml($this->testCity->caption());

            // martialartsId
            $this->martialartsId->setupEditAttributes();
            $this->martialartsId->EditCustomAttributes = "";
            $curVal = trim(strval($this->martialartsId->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->martialartsId->AdvancedSearch->ViewValue = $this->martialartsId->lookupCacheOption($curVal);
            } else {
                $this->martialartsId->AdvancedSearch->ViewValue = $this->martialartsId->Lookup !== null && is_array($this->martialartsId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialartsId->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->martialartsId->EditValue = array_values($this->martialartsId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialartsId->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialartsId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialartsId->EditValue = $arwrk;
            }
            $this->martialartsId->PlaceHolder = RemoveHtml($this->martialartsId->caption());

            // schoolId
            $this->schoolId->setupEditAttributes();
            $this->schoolId->EditCustomAttributes = "";
            $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());

            // testDate
            $this->testDate->setupEditAttributes();
            $this->testDate->EditCustomAttributes = "";
            $this->testDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->testDate->AdvancedSearch->SearchValue, $this->testDate->formatPattern()), $this->testDate->formatPattern()));
            $this->testDate->PlaceHolder = RemoveHtml($this->testDate->caption());
            $this->testDate->setupEditAttributes();
            $this->testDate->EditCustomAttributes = "";
            $this->testDate->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->testDate->AdvancedSearch->SearchValue2, $this->testDate->formatPattern()), $this->testDate->formatPattern()));
            $this->testDate->PlaceHolder = RemoveHtml($this->testDate->caption());

            // testTime
            $this->testTime->setupEditAttributes();
            $this->testTime->EditCustomAttributes = "";
            $this->testTime->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->testTime->AdvancedSearch->SearchValue, $this->testTime->formatPattern()), $this->testTime->formatPattern()));
            $this->testTime->PlaceHolder = RemoveHtml($this->testTime->caption());

            // ceremonyDate
            $this->ceremonyDate->setupEditAttributes();
            $this->ceremonyDate->EditCustomAttributes = "";
            $this->ceremonyDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->ceremonyDate->AdvancedSearch->SearchValue, $this->ceremonyDate->formatPattern()), $this->ceremonyDate->formatPattern()));
            $this->ceremonyDate->PlaceHolder = RemoveHtml($this->ceremonyDate->caption());

            // certificateId
            $this->certificateId->setupEditAttributes();
            $this->certificateId->EditCustomAttributes = "";
            $this->certificateId->EditValue = HtmlEncode($this->certificateId->AdvancedSearch->SearchValue);
            $this->certificateId->PlaceHolder = RemoveHtml($this->certificateId->caption());
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
        if (!CheckDate($this->testDate->AdvancedSearch->SearchValue, $this->testDate->formatPattern())) {
            $this->testDate->addErrorMessage($this->testDate->getErrorMessage(false));
        }
        if (!CheckDate($this->testDate->AdvancedSearch->SearchValue2, $this->testDate->formatPattern())) {
            $this->testDate->addErrorMessage($this->testDate->getErrorMessage(false));
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

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id->AdvancedSearch->load();
        $this->description->AdvancedSearch->load();
        $this->testCity->AdvancedSearch->load();
        $this->federationId->AdvancedSearch->load();
        $this->martialartsId->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->instructorId->AdvancedSearch->load();
        $this->auxiliarInstructorId->AdvancedSearch->load();
        $this->testDate->AdvancedSearch->load();
        $this->testTime->AdvancedSearch->load();
        $this->ceremonyDate->AdvancedSearch->load();
        $this->testTypeId->AdvancedSearch->load();
        $this->testStatusId->AdvancedSearch->load();
        $this->createUserId->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
        $this->judgeId->AdvancedSearch->load();
        $this->certificateId->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"ftes_testsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
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
                case "x_testCity":
                    break;
                case "x_federationId":
                    break;
                case "x_martialartsId":
                    break;
                case "x_schoolId":
                    break;
                case "x_instructorId":
                    $lookupFilter = function () {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_auxiliarInstructorId":
                    $lookupFilter = function () {
                        return "`instructorStatus` = TRUE";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_testTypeId":
                    break;
                case "x_testStatusId":
                    break;
                case "x_createUserId":
                    break;
                case "x_judgeId":
                    break;
                case "x_certificateId":
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
        $opt = &$this->ListOptions->Add("print-all-certificates");
        $opt = &$this->ListOptions->Add("candidates");    
        //$opt->Header = Language()->Phrase("candidatesontest");
        $opt->OnLeft = true; // Link on left
        //$opt->MoveTo(7); // Move to first column
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
        $btn = '<a class="btn btn-default ew-add-edit ew-add" title="'.Language()->Phrase("candidatesontest").'" data-caption="'.Language()->Phrase("candidatesontest").'" href="TesCandidateList?showmaster=tes_test&fk_id='.$this->id->CurrentValue.'" target = "_blank" data-original-title="'.Language()->Phrase("candidatesontest").'"><i class="fas fa-users" data-caption="'.Language()->Phrase("candidatesontest").'"></i></a>';
        $this->ListOptions["candidates"]->Body = $btn;
        $btn = '<a class="btn btn-default ew-add-edit ew-add" title="'.Language()->Phrase("print-all-certificates").'" data-caption="'.Language()->Phrase("print-all-certificates").'" href="./certificate/bulk_certificates.php?id='.$this->id->CurrentValue.'&certificateId='.$this->certificateId->CurrentValue.' " target = "_blank" data-original-title="'.Language()->Phrase("print-all-certificates").'"><i class="fas fa-print" data-caption="'.Language()->Phrase("print-all-certificates").'"></i></a>';
        $this->ListOptions["print-all-certificates"]->Body = $btn;
        //retirando botão mestre/detalhe
        $this->ListOptions["details"]->Body = "";
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
