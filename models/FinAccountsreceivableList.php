<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinAccountsreceivableList extends FinAccountsreceivable
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_accountsreceivable';

    // Page object name
    public $PageObjName = "FinAccountsreceivableList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ffin_accountsreceivablelist";
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

        // Table object (fin_accountsreceivable)
        if (!isset($GLOBALS["fin_accountsreceivable"]) || get_class($GLOBALS["fin_accountsreceivable"]) == PROJECT_NAMESPACE . "fin_accountsreceivable") {
            $GLOBALS["fin_accountsreceivable"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "FinAccountsreceivableAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "FinAccountsreceivableDelete";
        $this->MultiUpdateUrl = "FinAccountsreceivableUpdate";

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
            $this->lastUserId->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->lastUpdate->Visible = false;
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
        $this->issue->setVisibility();
        $this->due->setVisibility();
        $this->historic->Visible = false;
        $this->income->setVisibility();
        $this->status->setVisibility();
        $this->obs->Visible = false;
        $this->value->setVisibility();
        $this->deferred->Visible = false;
        $this->amountInstallments->Visible = false;
        $this->totalValueDeferred->Visible = false;
        $this->firstdateInstallment->Visible = false;
        $this->actualInstallment->Visible = false;
        $this->orderId->setVisibility();
        $this->balance->setVisibility();
        $this->_userId->Visible = false;
        $this->debtorId->setVisibility();
        $this->accountFather->Visible = false;
        $this->schoolId->Visible = false;
        $this->lastUserId->Visible = false;
        $this->_register->Visible = false;
        $this->lastUpdate->Visible = false;
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

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "ffin_accountsreceivablesrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->issue->AdvancedSearch->toJson(), ","); // Field issue
        $filterList = Concat($filterList, $this->due->AdvancedSearch->toJson(), ","); // Field due
        $filterList = Concat($filterList, $this->historic->AdvancedSearch->toJson(), ","); // Field historic
        $filterList = Concat($filterList, $this->income->AdvancedSearch->toJson(), ","); // Field income
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->obs->AdvancedSearch->toJson(), ","); // Field obs
        $filterList = Concat($filterList, $this->value->AdvancedSearch->toJson(), ","); // Field value
        $filterList = Concat($filterList, $this->deferred->AdvancedSearch->toJson(), ","); // Field deferred
        $filterList = Concat($filterList, $this->amountInstallments->AdvancedSearch->toJson(), ","); // Field amountInstallments
        $filterList = Concat($filterList, $this->totalValueDeferred->AdvancedSearch->toJson(), ","); // Field totalValueDeferred
        $filterList = Concat($filterList, $this->firstdateInstallment->AdvancedSearch->toJson(), ","); // Field firstdateInstallment
        $filterList = Concat($filterList, $this->actualInstallment->AdvancedSearch->toJson(), ","); // Field actualInstallment
        $filterList = Concat($filterList, $this->orderId->AdvancedSearch->toJson(), ","); // Field orderId
        $filterList = Concat($filterList, $this->balance->AdvancedSearch->toJson(), ","); // Field balance
        $filterList = Concat($filterList, $this->_userId->AdvancedSearch->toJson(), ","); // Field userId
        $filterList = Concat($filterList, $this->debtorId->AdvancedSearch->toJson(), ","); // Field debtorId
        $filterList = Concat($filterList, $this->accountFather->AdvancedSearch->toJson(), ","); // Field accountFather
        $filterList = Concat($filterList, $this->schoolId->AdvancedSearch->toJson(), ","); // Field schoolId
        $filterList = Concat($filterList, $this->lastUserId->AdvancedSearch->toJson(), ","); // Field lastUserId
        $filterList = Concat($filterList, $this->_register->AdvancedSearch->toJson(), ","); // Field register
        $filterList = Concat($filterList, $this->lastUpdate->AdvancedSearch->toJson(), ","); // Field lastUpdate
        $filterList = Concat($filterList, $this->licenseId->AdvancedSearch->toJson(), ","); // Field licenseId

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
            $UserProfile->setSearchFilters(CurrentUserName(), "ffin_accountsreceivablesrch", $filters);
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

        // Field issue
        $this->issue->AdvancedSearch->SearchValue = @$filter["x_issue"];
        $this->issue->AdvancedSearch->SearchOperator = @$filter["z_issue"];
        $this->issue->AdvancedSearch->SearchCondition = @$filter["v_issue"];
        $this->issue->AdvancedSearch->SearchValue2 = @$filter["y_issue"];
        $this->issue->AdvancedSearch->SearchOperator2 = @$filter["w_issue"];
        $this->issue->AdvancedSearch->save();

        // Field due
        $this->due->AdvancedSearch->SearchValue = @$filter["x_due"];
        $this->due->AdvancedSearch->SearchOperator = @$filter["z_due"];
        $this->due->AdvancedSearch->SearchCondition = @$filter["v_due"];
        $this->due->AdvancedSearch->SearchValue2 = @$filter["y_due"];
        $this->due->AdvancedSearch->SearchOperator2 = @$filter["w_due"];
        $this->due->AdvancedSearch->save();

        // Field historic
        $this->historic->AdvancedSearch->SearchValue = @$filter["x_historic"];
        $this->historic->AdvancedSearch->SearchOperator = @$filter["z_historic"];
        $this->historic->AdvancedSearch->SearchCondition = @$filter["v_historic"];
        $this->historic->AdvancedSearch->SearchValue2 = @$filter["y_historic"];
        $this->historic->AdvancedSearch->SearchOperator2 = @$filter["w_historic"];
        $this->historic->AdvancedSearch->save();

        // Field income
        $this->income->AdvancedSearch->SearchValue = @$filter["x_income"];
        $this->income->AdvancedSearch->SearchOperator = @$filter["z_income"];
        $this->income->AdvancedSearch->SearchCondition = @$filter["v_income"];
        $this->income->AdvancedSearch->SearchValue2 = @$filter["y_income"];
        $this->income->AdvancedSearch->SearchOperator2 = @$filter["w_income"];
        $this->income->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field obs
        $this->obs->AdvancedSearch->SearchValue = @$filter["x_obs"];
        $this->obs->AdvancedSearch->SearchOperator = @$filter["z_obs"];
        $this->obs->AdvancedSearch->SearchCondition = @$filter["v_obs"];
        $this->obs->AdvancedSearch->SearchValue2 = @$filter["y_obs"];
        $this->obs->AdvancedSearch->SearchOperator2 = @$filter["w_obs"];
        $this->obs->AdvancedSearch->save();

        // Field value
        $this->value->AdvancedSearch->SearchValue = @$filter["x_value"];
        $this->value->AdvancedSearch->SearchOperator = @$filter["z_value"];
        $this->value->AdvancedSearch->SearchCondition = @$filter["v_value"];
        $this->value->AdvancedSearch->SearchValue2 = @$filter["y_value"];
        $this->value->AdvancedSearch->SearchOperator2 = @$filter["w_value"];
        $this->value->AdvancedSearch->save();

        // Field deferred
        $this->deferred->AdvancedSearch->SearchValue = @$filter["x_deferred"];
        $this->deferred->AdvancedSearch->SearchOperator = @$filter["z_deferred"];
        $this->deferred->AdvancedSearch->SearchCondition = @$filter["v_deferred"];
        $this->deferred->AdvancedSearch->SearchValue2 = @$filter["y_deferred"];
        $this->deferred->AdvancedSearch->SearchOperator2 = @$filter["w_deferred"];
        $this->deferred->AdvancedSearch->save();

        // Field amountInstallments
        $this->amountInstallments->AdvancedSearch->SearchValue = @$filter["x_amountInstallments"];
        $this->amountInstallments->AdvancedSearch->SearchOperator = @$filter["z_amountInstallments"];
        $this->amountInstallments->AdvancedSearch->SearchCondition = @$filter["v_amountInstallments"];
        $this->amountInstallments->AdvancedSearch->SearchValue2 = @$filter["y_amountInstallments"];
        $this->amountInstallments->AdvancedSearch->SearchOperator2 = @$filter["w_amountInstallments"];
        $this->amountInstallments->AdvancedSearch->save();

        // Field totalValueDeferred
        $this->totalValueDeferred->AdvancedSearch->SearchValue = @$filter["x_totalValueDeferred"];
        $this->totalValueDeferred->AdvancedSearch->SearchOperator = @$filter["z_totalValueDeferred"];
        $this->totalValueDeferred->AdvancedSearch->SearchCondition = @$filter["v_totalValueDeferred"];
        $this->totalValueDeferred->AdvancedSearch->SearchValue2 = @$filter["y_totalValueDeferred"];
        $this->totalValueDeferred->AdvancedSearch->SearchOperator2 = @$filter["w_totalValueDeferred"];
        $this->totalValueDeferred->AdvancedSearch->save();

        // Field firstdateInstallment
        $this->firstdateInstallment->AdvancedSearch->SearchValue = @$filter["x_firstdateInstallment"];
        $this->firstdateInstallment->AdvancedSearch->SearchOperator = @$filter["z_firstdateInstallment"];
        $this->firstdateInstallment->AdvancedSearch->SearchCondition = @$filter["v_firstdateInstallment"];
        $this->firstdateInstallment->AdvancedSearch->SearchValue2 = @$filter["y_firstdateInstallment"];
        $this->firstdateInstallment->AdvancedSearch->SearchOperator2 = @$filter["w_firstdateInstallment"];
        $this->firstdateInstallment->AdvancedSearch->save();

        // Field actualInstallment
        $this->actualInstallment->AdvancedSearch->SearchValue = @$filter["x_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchOperator = @$filter["z_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchCondition = @$filter["v_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchValue2 = @$filter["y_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchOperator2 = @$filter["w_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->save();

        // Field orderId
        $this->orderId->AdvancedSearch->SearchValue = @$filter["x_orderId"];
        $this->orderId->AdvancedSearch->SearchOperator = @$filter["z_orderId"];
        $this->orderId->AdvancedSearch->SearchCondition = @$filter["v_orderId"];
        $this->orderId->AdvancedSearch->SearchValue2 = @$filter["y_orderId"];
        $this->orderId->AdvancedSearch->SearchOperator2 = @$filter["w_orderId"];
        $this->orderId->AdvancedSearch->save();

        // Field balance
        $this->balance->AdvancedSearch->SearchValue = @$filter["x_balance"];
        $this->balance->AdvancedSearch->SearchOperator = @$filter["z_balance"];
        $this->balance->AdvancedSearch->SearchCondition = @$filter["v_balance"];
        $this->balance->AdvancedSearch->SearchValue2 = @$filter["y_balance"];
        $this->balance->AdvancedSearch->SearchOperator2 = @$filter["w_balance"];
        $this->balance->AdvancedSearch->save();

        // Field userId
        $this->_userId->AdvancedSearch->SearchValue = @$filter["x__userId"];
        $this->_userId->AdvancedSearch->SearchOperator = @$filter["z__userId"];
        $this->_userId->AdvancedSearch->SearchCondition = @$filter["v__userId"];
        $this->_userId->AdvancedSearch->SearchValue2 = @$filter["y__userId"];
        $this->_userId->AdvancedSearch->SearchOperator2 = @$filter["w__userId"];
        $this->_userId->AdvancedSearch->save();

        // Field debtorId
        $this->debtorId->AdvancedSearch->SearchValue = @$filter["x_debtorId"];
        $this->debtorId->AdvancedSearch->SearchOperator = @$filter["z_debtorId"];
        $this->debtorId->AdvancedSearch->SearchCondition = @$filter["v_debtorId"];
        $this->debtorId->AdvancedSearch->SearchValue2 = @$filter["y_debtorId"];
        $this->debtorId->AdvancedSearch->SearchOperator2 = @$filter["w_debtorId"];
        $this->debtorId->AdvancedSearch->save();

        // Field accountFather
        $this->accountFather->AdvancedSearch->SearchValue = @$filter["x_accountFather"];
        $this->accountFather->AdvancedSearch->SearchOperator = @$filter["z_accountFather"];
        $this->accountFather->AdvancedSearch->SearchCondition = @$filter["v_accountFather"];
        $this->accountFather->AdvancedSearch->SearchValue2 = @$filter["y_accountFather"];
        $this->accountFather->AdvancedSearch->SearchOperator2 = @$filter["w_accountFather"];
        $this->accountFather->AdvancedSearch->save();

        // Field schoolId
        $this->schoolId->AdvancedSearch->SearchValue = @$filter["x_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator = @$filter["z_schoolId"];
        $this->schoolId->AdvancedSearch->SearchCondition = @$filter["v_schoolId"];
        $this->schoolId->AdvancedSearch->SearchValue2 = @$filter["y_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator2 = @$filter["w_schoolId"];
        $this->schoolId->AdvancedSearch->save();

        // Field lastUserId
        $this->lastUserId->AdvancedSearch->SearchValue = @$filter["x_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchOperator = @$filter["z_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchCondition = @$filter["v_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchValue2 = @$filter["y_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchOperator2 = @$filter["w_lastUserId"];
        $this->lastUserId->AdvancedSearch->save();

        // Field register
        $this->_register->AdvancedSearch->SearchValue = @$filter["x__register"];
        $this->_register->AdvancedSearch->SearchOperator = @$filter["z__register"];
        $this->_register->AdvancedSearch->SearchCondition = @$filter["v__register"];
        $this->_register->AdvancedSearch->SearchValue2 = @$filter["y__register"];
        $this->_register->AdvancedSearch->SearchOperator2 = @$filter["w__register"];
        $this->_register->AdvancedSearch->save();

        // Field lastUpdate
        $this->lastUpdate->AdvancedSearch->SearchValue = @$filter["x_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator = @$filter["z_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchCondition = @$filter["v_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchValue2 = @$filter["y_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator2 = @$filter["w_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->save();

        // Field licenseId
        $this->licenseId->AdvancedSearch->SearchValue = @$filter["x_licenseId"];
        $this->licenseId->AdvancedSearch->SearchOperator = @$filter["z_licenseId"];
        $this->licenseId->AdvancedSearch->SearchCondition = @$filter["v_licenseId"];
        $this->licenseId->AdvancedSearch->SearchValue2 = @$filter["y_licenseId"];
        $this->licenseId->AdvancedSearch->SearchOperator2 = @$filter["w_licenseId"];
        $this->licenseId->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->issue, $default, false); // issue
        $this->buildSearchSql($where, $this->due, $default, false); // due
        $this->buildSearchSql($where, $this->historic, $default, false); // historic
        $this->buildSearchSql($where, $this->income, $default, false); // income
        $this->buildSearchSql($where, $this->status, $default, false); // status
        $this->buildSearchSql($where, $this->obs, $default, false); // obs
        $this->buildSearchSql($where, $this->value, $default, false); // value
        $this->buildSearchSql($where, $this->deferred, $default, false); // deferred
        $this->buildSearchSql($where, $this->amountInstallments, $default, false); // amountInstallments
        $this->buildSearchSql($where, $this->totalValueDeferred, $default, false); // totalValueDeferred
        $this->buildSearchSql($where, $this->firstdateInstallment, $default, false); // firstdateInstallment
        $this->buildSearchSql($where, $this->actualInstallment, $default, false); // actualInstallment
        $this->buildSearchSql($where, $this->orderId, $default, false); // orderId
        $this->buildSearchSql($where, $this->balance, $default, false); // balance
        $this->buildSearchSql($where, $this->_userId, $default, false); // userId
        $this->buildSearchSql($where, $this->debtorId, $default, false); // debtorId
        $this->buildSearchSql($where, $this->accountFather, $default, false); // accountFather
        $this->buildSearchSql($where, $this->schoolId, $default, false); // schoolId
        $this->buildSearchSql($where, $this->lastUserId, $default, false); // lastUserId
        $this->buildSearchSql($where, $this->_register, $default, false); // register
        $this->buildSearchSql($where, $this->lastUpdate, $default, false); // lastUpdate
        $this->buildSearchSql($where, $this->licenseId, $default, false); // licenseId

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->issue->AdvancedSearch->save(); // issue
            $this->due->AdvancedSearch->save(); // due
            $this->historic->AdvancedSearch->save(); // historic
            $this->income->AdvancedSearch->save(); // income
            $this->status->AdvancedSearch->save(); // status
            $this->obs->AdvancedSearch->save(); // obs
            $this->value->AdvancedSearch->save(); // value
            $this->deferred->AdvancedSearch->save(); // deferred
            $this->amountInstallments->AdvancedSearch->save(); // amountInstallments
            $this->totalValueDeferred->AdvancedSearch->save(); // totalValueDeferred
            $this->firstdateInstallment->AdvancedSearch->save(); // firstdateInstallment
            $this->actualInstallment->AdvancedSearch->save(); // actualInstallment
            $this->orderId->AdvancedSearch->save(); // orderId
            $this->balance->AdvancedSearch->save(); // balance
            $this->_userId->AdvancedSearch->save(); // userId
            $this->debtorId->AdvancedSearch->save(); // debtorId
            $this->accountFather->AdvancedSearch->save(); // accountFather
            $this->schoolId->AdvancedSearch->save(); // schoolId
            $this->lastUserId->AdvancedSearch->save(); // lastUserId
            $this->_register->AdvancedSearch->save(); // register
            $this->lastUpdate->AdvancedSearch->save(); // lastUpdate
            $this->licenseId->AdvancedSearch->save(); // licenseId
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
        if ($this->issue->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->due->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->historic->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->income->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->obs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->value->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->deferred->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->amountInstallments->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->totalValueDeferred->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->firstdateInstallment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->actualInstallment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->orderId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->balance->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_userId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->debtorId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->accountFather->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->schoolId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lastUserId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_register->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lastUpdate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->licenseId->AdvancedSearch->issetSession()) {
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
        $this->issue->AdvancedSearch->unsetSession();
        $this->due->AdvancedSearch->unsetSession();
        $this->historic->AdvancedSearch->unsetSession();
        $this->income->AdvancedSearch->unsetSession();
        $this->status->AdvancedSearch->unsetSession();
        $this->obs->AdvancedSearch->unsetSession();
        $this->value->AdvancedSearch->unsetSession();
        $this->deferred->AdvancedSearch->unsetSession();
        $this->amountInstallments->AdvancedSearch->unsetSession();
        $this->totalValueDeferred->AdvancedSearch->unsetSession();
        $this->firstdateInstallment->AdvancedSearch->unsetSession();
        $this->actualInstallment->AdvancedSearch->unsetSession();
        $this->orderId->AdvancedSearch->unsetSession();
        $this->balance->AdvancedSearch->unsetSession();
        $this->_userId->AdvancedSearch->unsetSession();
        $this->debtorId->AdvancedSearch->unsetSession();
        $this->accountFather->AdvancedSearch->unsetSession();
        $this->schoolId->AdvancedSearch->unsetSession();
        $this->lastUserId->AdvancedSearch->unsetSession();
        $this->_register->AdvancedSearch->unsetSession();
        $this->lastUpdate->AdvancedSearch->unsetSession();
        $this->licenseId->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore advanced search values
        $this->id->AdvancedSearch->load();
        $this->issue->AdvancedSearch->load();
        $this->due->AdvancedSearch->load();
        $this->historic->AdvancedSearch->load();
        $this->income->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->value->AdvancedSearch->load();
        $this->deferred->AdvancedSearch->load();
        $this->amountInstallments->AdvancedSearch->load();
        $this->totalValueDeferred->AdvancedSearch->load();
        $this->firstdateInstallment->AdvancedSearch->load();
        $this->actualInstallment->AdvancedSearch->load();
        $this->orderId->AdvancedSearch->load();
        $this->balance->AdvancedSearch->load();
        $this->_userId->AdvancedSearch->load();
        $this->debtorId->AdvancedSearch->load();
        $this->accountFather->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->lastUserId->AdvancedSearch->load();
        $this->_register->AdvancedSearch->load();
        $this->lastUpdate->AdvancedSearch->load();
        $this->licenseId->AdvancedSearch->load();
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
            $this->updateSort($this->issue); // issue
            $this->updateSort($this->due); // due
            $this->updateSort($this->income); // income
            $this->updateSort($this->status); // status
            $this->updateSort($this->value); // value
            $this->updateSort($this->orderId); // orderId
            $this->updateSort($this->balance); // balance
            $this->updateSort($this->debtorId); // debtorId
            $this->updateSort($this->licenseId); // licenseId
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
                $this->issue->setSort("");
                $this->due->setSort("");
                $this->historic->setSort("");
                $this->income->setSort("");
                $this->status->setSort("");
                $this->obs->setSort("");
                $this->value->setSort("");
                $this->deferred->setSort("");
                $this->amountInstallments->setSort("");
                $this->totalValueDeferred->setSort("");
                $this->firstdateInstallment->setSort("");
                $this->actualInstallment->setSort("");
                $this->orderId->setSort("");
                $this->balance->setSort("");
                $this->_userId->setSort("");
                $this->debtorId->setSort("");
                $this->accountFather->setSort("");
                $this->schoolId->setSort("");
                $this->lastUserId->setSort("");
                $this->_register->setSort("");
                $this->lastUpdate->setSort("");
                $this->licenseId->setSort("");
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

        // "detail_fin_credit"
        $item = &$this->ListOptions->add("detail_fin_credit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'fin_credit');
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
        $pages->add("fin_credit");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffin_accountsreceivablelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffin_accountsreceivablelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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

        // "detail_fin_credit"
        $opt = $this->ListOptions["detail_fin_credit"];
        if ($Security->allowList(CurrentProjectID() . 'fin_credit') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("fin_credit", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("FinCreditList?" . Config("TABLE_SHOW_MASTER") . "=fin_accountsreceivable&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("FinCreditGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "fin_credit";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "fin_credit";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "fin_credit";
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
        $sqlwrk = "`accountId`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_fin_credit"
        if ($this->DetailPages && $this->DetailPages["fin_credit"] && $this->DetailPages["fin_credit"]->Visible && $Security->allowList(CurrentProjectID() . 'fin_credit')) {
            $link = "";
            $option = $this->ListOptions["detail_fin_credit"];
            $url = "FinCreditPreview?t=fin_accountsreceivable&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"fin_credit\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'fin_accountsreceivable')) {
                $label = $Language->TablePhrase("fin_credit", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"fin_credit\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("FinCreditList?" . Config("TABLE_SHOW_MASTER") . "=fin_accountsreceivable&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("fin_credit", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("FinCreditGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fin_accountsreceivable')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
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
                $item = &$option->add("detailadd_fin_credit");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=fin_credit");
                $detailPage = Container("FinCreditGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'fin_accountsreceivable') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "fin_credit";
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
            $option->add("issue", $this->createColumnOption("issue"));
            $option->add("due", $this->createColumnOption("due"));
            $option->add("income", $this->createColumnOption("income"));
            $option->add("status", $this->createColumnOption("status"));
            $option->add("value", $this->createColumnOption("value"));
            $option->add("orderId", $this->createColumnOption("orderId"));
            $option->add("balance", $this->createColumnOption("balance"));
            $option->add("debtorId", $this->createColumnOption("debtorId"));
            $option->add("licenseId", $this->createColumnOption("licenseId"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"ffin_accountsreceivablesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"ffin_accountsreceivablesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="ffin_accountsreceivablelist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

        // issue
        if ($this->issue->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->issue->AdvancedSearch->SearchValue != "" || $this->issue->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // due
        if ($this->due->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->due->AdvancedSearch->SearchValue != "" || $this->due->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // historic
        if ($this->historic->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->historic->AdvancedSearch->SearchValue != "" || $this->historic->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // income
        if ($this->income->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->income->AdvancedSearch->SearchValue != "" || $this->income->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // status
        if ($this->status->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->status->AdvancedSearch->SearchValue != "" || $this->status->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // value
        if ($this->value->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->value->AdvancedSearch->SearchValue != "" || $this->value->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // deferred
        if ($this->deferred->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->deferred->AdvancedSearch->SearchValue != "" || $this->deferred->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->deferred->AdvancedSearch->SearchValue)) {
            $this->deferred->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->deferred->AdvancedSearch->SearchValue);
        }
        if (is_array($this->deferred->AdvancedSearch->SearchValue2)) {
            $this->deferred->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->deferred->AdvancedSearch->SearchValue2);
        }

        // amountInstallments
        if ($this->amountInstallments->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->amountInstallments->AdvancedSearch->SearchValue != "" || $this->amountInstallments->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // totalValueDeferred
        if ($this->totalValueDeferred->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->totalValueDeferred->AdvancedSearch->SearchValue != "" || $this->totalValueDeferred->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // firstdateInstallment
        if ($this->firstdateInstallment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->firstdateInstallment->AdvancedSearch->SearchValue != "" || $this->firstdateInstallment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // actualInstallment
        if ($this->actualInstallment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->actualInstallment->AdvancedSearch->SearchValue != "" || $this->actualInstallment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // orderId
        if ($this->orderId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->orderId->AdvancedSearch->SearchValue != "" || $this->orderId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // balance
        if ($this->balance->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->balance->AdvancedSearch->SearchValue != "" || $this->balance->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // userId
        if ($this->_userId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_userId->AdvancedSearch->SearchValue != "" || $this->_userId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // debtorId
        if ($this->debtorId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->debtorId->AdvancedSearch->SearchValue != "" || $this->debtorId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // accountFather
        if ($this->accountFather->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->accountFather->AdvancedSearch->SearchValue != "" || $this->accountFather->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // lastUserId
        if ($this->lastUserId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lastUserId->AdvancedSearch->SearchValue != "" || $this->lastUserId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // register
        if ($this->_register->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_register->AdvancedSearch->SearchValue != "" || $this->_register->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // lastUpdate
        if ($this->lastUpdate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lastUpdate->AdvancedSearch->SearchValue != "" || $this->lastUpdate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // licenseId
        if ($this->licenseId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->licenseId->AdvancedSearch->SearchValue != "" || $this->licenseId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // issue

        // due

        // historic

        // income

        // status

        // obs

        // value

        // deferred

        // amountInstallments

        // totalValueDeferred

        // firstdateInstallment

        // actualInstallment

        // orderId

        // balance

        // userId

        // debtorId

        // accountFather

        // schoolId

        // lastUserId

        // register

        // lastUpdate

        // licenseId

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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";
            $this->issue->TooltipValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";
            $this->due->TooltipValue = "";

            // income
            $this->income->LinkCustomAttributes = "";
            $this->income->HrefValue = "";
            $this->income->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";
            $this->value->TooltipValue = "";

            // orderId
            $this->orderId->LinkCustomAttributes = "";
            $this->orderId->HrefValue = "";
            $this->orderId->TooltipValue = "";

            // balance
            $this->balance->LinkCustomAttributes = "";
            $this->balance->HrefValue = "";
            $this->balance->TooltipValue = "";

            // debtorId
            $this->debtorId->LinkCustomAttributes = "";
            $this->debtorId->HrefValue = "";
            $this->debtorId->TooltipValue = "";

            // licenseId
            $this->licenseId->LinkCustomAttributes = "";
            $this->licenseId->HrefValue = "";
            $this->licenseId->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // issue
            $this->issue->setupEditAttributes();
            $this->issue->EditCustomAttributes = "";
            $this->issue->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->issue->AdvancedSearch->SearchValue, $this->issue->formatPattern()), $this->issue->formatPattern()));
            $this->issue->PlaceHolder = RemoveHtml($this->issue->caption());

            // due
            $this->due->setupEditAttributes();
            $this->due->EditCustomAttributes = "";
            $this->due->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->due->AdvancedSearch->SearchValue, $this->due->formatPattern()), $this->due->formatPattern()));
            $this->due->PlaceHolder = RemoveHtml($this->due->caption());

            // income
            $this->income->setupEditAttributes();
            $this->income->EditCustomAttributes = "";
            $this->income->EditValue = HtmlEncode($this->income->AdvancedSearch->SearchValue);
            $this->income->PlaceHolder = RemoveHtml($this->income->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->AdvancedSearch->SearchValue);
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());

            // orderId
            $this->orderId->setupEditAttributes();
            $this->orderId->EditCustomAttributes = "";
            $this->orderId->EditValue = HtmlEncode($this->orderId->AdvancedSearch->SearchValue);
            $this->orderId->PlaceHolder = RemoveHtml($this->orderId->caption());

            // balance
            $this->balance->setupEditAttributes();
            $this->balance->EditCustomAttributes = "";
            $this->balance->EditValue = HtmlEncode($this->balance->AdvancedSearch->SearchValue);
            $this->balance->PlaceHolder = RemoveHtml($this->balance->caption());

            // debtorId
            $this->debtorId->setupEditAttributes();
            $this->debtorId->EditCustomAttributes = "";
            $this->debtorId->EditValue = HtmlEncode($this->debtorId->AdvancedSearch->SearchValue);
            $this->debtorId->PlaceHolder = RemoveHtml($this->debtorId->caption());

            // licenseId
            $this->licenseId->setupEditAttributes();
            $this->licenseId->EditCustomAttributes = "";
            $this->licenseId->EditValue = HtmlEncode($this->licenseId->AdvancedSearch->SearchValue);
            $this->licenseId->PlaceHolder = RemoveHtml($this->licenseId->caption());
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
        $this->issue->AdvancedSearch->load();
        $this->due->AdvancedSearch->load();
        $this->historic->AdvancedSearch->load();
        $this->income->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->value->AdvancedSearch->load();
        $this->deferred->AdvancedSearch->load();
        $this->amountInstallments->AdvancedSearch->load();
        $this->totalValueDeferred->AdvancedSearch->load();
        $this->firstdateInstallment->AdvancedSearch->load();
        $this->actualInstallment->AdvancedSearch->load();
        $this->orderId->AdvancedSearch->load();
        $this->balance->AdvancedSearch->load();
        $this->_userId->AdvancedSearch->load();
        $this->debtorId->AdvancedSearch->load();
        $this->accountFather->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->lastUserId->AdvancedSearch->load();
        $this->_register->AdvancedSearch->load();
        $this->lastUpdate->AdvancedSearch->load();
        $this->licenseId->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl(false);
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"ffin_accountsreceivablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"ffin_accountsreceivablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"ffin_accountsreceivablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="ffin_accountsreceivablelist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"ffin_accountsreceivablesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        return $this->income->Visible;
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
