<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FinAccountspayableList extends FinAccountspayable
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fin_accountspayable';

    // Page object name
    public $PageObjName = "FinAccountspayableList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ffin_accountspayablelist";
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

        // Table object (fin_accountspayable)
        if (!isset($GLOBALS["fin_accountspayable"]) || get_class($GLOBALS["fin_accountspayable"]) == PROJECT_NAMESPACE . "fin_accountspayable") {
            $GLOBALS["fin_accountspayable"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "FinAccountspayableAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "FinAccountspayableDelete";
        $this->MultiUpdateUrl = "FinAccountspayableUpdate";

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
        $this->departamentId->setVisibility();
        $this->costCenterId->Visible = false;
        $this->historic->setVisibility();
        $this->issue->setVisibility();
        $this->due->setVisibility();
        $this->value->setVisibility();
        $this->employeeId->Visible = false;
        $this->status->setVisibility();
        $this->amountPaid->setVisibility();
        $this->creditorsId->setVisibility();
        $this->typeId->setVisibility();
        $this->obs->Visible = false;
        $this->invoiceFile->Visible = false;
        $this->guaranteeFile->Visible = false;
        $this->attachedFile->Visible = false;
        $this->deferred->Visible = false;
        $this->amountInstallments->Visible = false;
        $this->totalValueDeferred->Visible = false;
        $this->actualInstallment->Visible = false;
        $this->firstInstallmentDate->Visible = false;
        $this->accountFather->Visible = false;
        $this->_userId->Visible = false;
        $this->schoolId->Visible = false;
        $this->lastUserId->Visible = false;
        $this->registerDate->Visible = false;
        $this->lastUpdate->Visible = false;
        $this->incomeReceivable->Visible = false;
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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "ffin_accountspayablesrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->departamentId->AdvancedSearch->toJson(), ","); // Field departamentId
        $filterList = Concat($filterList, $this->costCenterId->AdvancedSearch->toJson(), ","); // Field costCenterId
        $filterList = Concat($filterList, $this->historic->AdvancedSearch->toJson(), ","); // Field historic
        $filterList = Concat($filterList, $this->issue->AdvancedSearch->toJson(), ","); // Field issue
        $filterList = Concat($filterList, $this->due->AdvancedSearch->toJson(), ","); // Field due
        $filterList = Concat($filterList, $this->value->AdvancedSearch->toJson(), ","); // Field value
        $filterList = Concat($filterList, $this->employeeId->AdvancedSearch->toJson(), ","); // Field employeeId
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->amountPaid->AdvancedSearch->toJson(), ","); // Field amountPaid
        $filterList = Concat($filterList, $this->creditorsId->AdvancedSearch->toJson(), ","); // Field creditorsId
        $filterList = Concat($filterList, $this->typeId->AdvancedSearch->toJson(), ","); // Field typeId
        $filterList = Concat($filterList, $this->obs->AdvancedSearch->toJson(), ","); // Field obs
        $filterList = Concat($filterList, $this->invoiceFile->AdvancedSearch->toJson(), ","); // Field invoiceFile
        $filterList = Concat($filterList, $this->guaranteeFile->AdvancedSearch->toJson(), ","); // Field guaranteeFile
        $filterList = Concat($filterList, $this->attachedFile->AdvancedSearch->toJson(), ","); // Field attachedFile
        $filterList = Concat($filterList, $this->deferred->AdvancedSearch->toJson(), ","); // Field deferred
        $filterList = Concat($filterList, $this->amountInstallments->AdvancedSearch->toJson(), ","); // Field amountInstallments
        $filterList = Concat($filterList, $this->totalValueDeferred->AdvancedSearch->toJson(), ","); // Field totalValueDeferred
        $filterList = Concat($filterList, $this->actualInstallment->AdvancedSearch->toJson(), ","); // Field actualInstallment
        $filterList = Concat($filterList, $this->firstInstallmentDate->AdvancedSearch->toJson(), ","); // Field firstInstallmentDate
        $filterList = Concat($filterList, $this->accountFather->AdvancedSearch->toJson(), ","); // Field accountFather
        $filterList = Concat($filterList, $this->_userId->AdvancedSearch->toJson(), ","); // Field userId
        $filterList = Concat($filterList, $this->schoolId->AdvancedSearch->toJson(), ","); // Field schoolId
        $filterList = Concat($filterList, $this->lastUserId->AdvancedSearch->toJson(), ","); // Field lastUserId
        $filterList = Concat($filterList, $this->registerDate->AdvancedSearch->toJson(), ","); // Field registerDate
        $filterList = Concat($filterList, $this->lastUpdate->AdvancedSearch->toJson(), ","); // Field lastUpdate
        $filterList = Concat($filterList, $this->incomeReceivable->AdvancedSearch->toJson(), ","); // Field incomeReceivable
        $filterList = Concat($filterList, $this->licenseId->AdvancedSearch->toJson(), ","); // Field licenseId
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
            $UserProfile->setSearchFilters(CurrentUserName(), "ffin_accountspayablesrch", $filters);
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

        // Field departamentId
        $this->departamentId->AdvancedSearch->SearchValue = @$filter["x_departamentId"];
        $this->departamentId->AdvancedSearch->SearchOperator = @$filter["z_departamentId"];
        $this->departamentId->AdvancedSearch->SearchCondition = @$filter["v_departamentId"];
        $this->departamentId->AdvancedSearch->SearchValue2 = @$filter["y_departamentId"];
        $this->departamentId->AdvancedSearch->SearchOperator2 = @$filter["w_departamentId"];
        $this->departamentId->AdvancedSearch->save();

        // Field costCenterId
        $this->costCenterId->AdvancedSearch->SearchValue = @$filter["x_costCenterId"];
        $this->costCenterId->AdvancedSearch->SearchOperator = @$filter["z_costCenterId"];
        $this->costCenterId->AdvancedSearch->SearchCondition = @$filter["v_costCenterId"];
        $this->costCenterId->AdvancedSearch->SearchValue2 = @$filter["y_costCenterId"];
        $this->costCenterId->AdvancedSearch->SearchOperator2 = @$filter["w_costCenterId"];
        $this->costCenterId->AdvancedSearch->save();

        // Field historic
        $this->historic->AdvancedSearch->SearchValue = @$filter["x_historic"];
        $this->historic->AdvancedSearch->SearchOperator = @$filter["z_historic"];
        $this->historic->AdvancedSearch->SearchCondition = @$filter["v_historic"];
        $this->historic->AdvancedSearch->SearchValue2 = @$filter["y_historic"];
        $this->historic->AdvancedSearch->SearchOperator2 = @$filter["w_historic"];
        $this->historic->AdvancedSearch->save();

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

        // Field value
        $this->value->AdvancedSearch->SearchValue = @$filter["x_value"];
        $this->value->AdvancedSearch->SearchOperator = @$filter["z_value"];
        $this->value->AdvancedSearch->SearchCondition = @$filter["v_value"];
        $this->value->AdvancedSearch->SearchValue2 = @$filter["y_value"];
        $this->value->AdvancedSearch->SearchOperator2 = @$filter["w_value"];
        $this->value->AdvancedSearch->save();

        // Field employeeId
        $this->employeeId->AdvancedSearch->SearchValue = @$filter["x_employeeId"];
        $this->employeeId->AdvancedSearch->SearchOperator = @$filter["z_employeeId"];
        $this->employeeId->AdvancedSearch->SearchCondition = @$filter["v_employeeId"];
        $this->employeeId->AdvancedSearch->SearchValue2 = @$filter["y_employeeId"];
        $this->employeeId->AdvancedSearch->SearchOperator2 = @$filter["w_employeeId"];
        $this->employeeId->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field amountPaid
        $this->amountPaid->AdvancedSearch->SearchValue = @$filter["x_amountPaid"];
        $this->amountPaid->AdvancedSearch->SearchOperator = @$filter["z_amountPaid"];
        $this->amountPaid->AdvancedSearch->SearchCondition = @$filter["v_amountPaid"];
        $this->amountPaid->AdvancedSearch->SearchValue2 = @$filter["y_amountPaid"];
        $this->amountPaid->AdvancedSearch->SearchOperator2 = @$filter["w_amountPaid"];
        $this->amountPaid->AdvancedSearch->save();

        // Field creditorsId
        $this->creditorsId->AdvancedSearch->SearchValue = @$filter["x_creditorsId"];
        $this->creditorsId->AdvancedSearch->SearchOperator = @$filter["z_creditorsId"];
        $this->creditorsId->AdvancedSearch->SearchCondition = @$filter["v_creditorsId"];
        $this->creditorsId->AdvancedSearch->SearchValue2 = @$filter["y_creditorsId"];
        $this->creditorsId->AdvancedSearch->SearchOperator2 = @$filter["w_creditorsId"];
        $this->creditorsId->AdvancedSearch->save();

        // Field typeId
        $this->typeId->AdvancedSearch->SearchValue = @$filter["x_typeId"];
        $this->typeId->AdvancedSearch->SearchOperator = @$filter["z_typeId"];
        $this->typeId->AdvancedSearch->SearchCondition = @$filter["v_typeId"];
        $this->typeId->AdvancedSearch->SearchValue2 = @$filter["y_typeId"];
        $this->typeId->AdvancedSearch->SearchOperator2 = @$filter["w_typeId"];
        $this->typeId->AdvancedSearch->save();

        // Field obs
        $this->obs->AdvancedSearch->SearchValue = @$filter["x_obs"];
        $this->obs->AdvancedSearch->SearchOperator = @$filter["z_obs"];
        $this->obs->AdvancedSearch->SearchCondition = @$filter["v_obs"];
        $this->obs->AdvancedSearch->SearchValue2 = @$filter["y_obs"];
        $this->obs->AdvancedSearch->SearchOperator2 = @$filter["w_obs"];
        $this->obs->AdvancedSearch->save();

        // Field invoiceFile
        $this->invoiceFile->AdvancedSearch->SearchValue = @$filter["x_invoiceFile"];
        $this->invoiceFile->AdvancedSearch->SearchOperator = @$filter["z_invoiceFile"];
        $this->invoiceFile->AdvancedSearch->SearchCondition = @$filter["v_invoiceFile"];
        $this->invoiceFile->AdvancedSearch->SearchValue2 = @$filter["y_invoiceFile"];
        $this->invoiceFile->AdvancedSearch->SearchOperator2 = @$filter["w_invoiceFile"];
        $this->invoiceFile->AdvancedSearch->save();

        // Field guaranteeFile
        $this->guaranteeFile->AdvancedSearch->SearchValue = @$filter["x_guaranteeFile"];
        $this->guaranteeFile->AdvancedSearch->SearchOperator = @$filter["z_guaranteeFile"];
        $this->guaranteeFile->AdvancedSearch->SearchCondition = @$filter["v_guaranteeFile"];
        $this->guaranteeFile->AdvancedSearch->SearchValue2 = @$filter["y_guaranteeFile"];
        $this->guaranteeFile->AdvancedSearch->SearchOperator2 = @$filter["w_guaranteeFile"];
        $this->guaranteeFile->AdvancedSearch->save();

        // Field attachedFile
        $this->attachedFile->AdvancedSearch->SearchValue = @$filter["x_attachedFile"];
        $this->attachedFile->AdvancedSearch->SearchOperator = @$filter["z_attachedFile"];
        $this->attachedFile->AdvancedSearch->SearchCondition = @$filter["v_attachedFile"];
        $this->attachedFile->AdvancedSearch->SearchValue2 = @$filter["y_attachedFile"];
        $this->attachedFile->AdvancedSearch->SearchOperator2 = @$filter["w_attachedFile"];
        $this->attachedFile->AdvancedSearch->save();

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

        // Field actualInstallment
        $this->actualInstallment->AdvancedSearch->SearchValue = @$filter["x_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchOperator = @$filter["z_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchCondition = @$filter["v_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchValue2 = @$filter["y_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->SearchOperator2 = @$filter["w_actualInstallment"];
        $this->actualInstallment->AdvancedSearch->save();

        // Field firstInstallmentDate
        $this->firstInstallmentDate->AdvancedSearch->SearchValue = @$filter["x_firstInstallmentDate"];
        $this->firstInstallmentDate->AdvancedSearch->SearchOperator = @$filter["z_firstInstallmentDate"];
        $this->firstInstallmentDate->AdvancedSearch->SearchCondition = @$filter["v_firstInstallmentDate"];
        $this->firstInstallmentDate->AdvancedSearch->SearchValue2 = @$filter["y_firstInstallmentDate"];
        $this->firstInstallmentDate->AdvancedSearch->SearchOperator2 = @$filter["w_firstInstallmentDate"];
        $this->firstInstallmentDate->AdvancedSearch->save();

        // Field accountFather
        $this->accountFather->AdvancedSearch->SearchValue = @$filter["x_accountFather"];
        $this->accountFather->AdvancedSearch->SearchOperator = @$filter["z_accountFather"];
        $this->accountFather->AdvancedSearch->SearchCondition = @$filter["v_accountFather"];
        $this->accountFather->AdvancedSearch->SearchValue2 = @$filter["y_accountFather"];
        $this->accountFather->AdvancedSearch->SearchOperator2 = @$filter["w_accountFather"];
        $this->accountFather->AdvancedSearch->save();

        // Field userId
        $this->_userId->AdvancedSearch->SearchValue = @$filter["x__userId"];
        $this->_userId->AdvancedSearch->SearchOperator = @$filter["z__userId"];
        $this->_userId->AdvancedSearch->SearchCondition = @$filter["v__userId"];
        $this->_userId->AdvancedSearch->SearchValue2 = @$filter["y__userId"];
        $this->_userId->AdvancedSearch->SearchOperator2 = @$filter["w__userId"];
        $this->_userId->AdvancedSearch->save();

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

        // Field registerDate
        $this->registerDate->AdvancedSearch->SearchValue = @$filter["x_registerDate"];
        $this->registerDate->AdvancedSearch->SearchOperator = @$filter["z_registerDate"];
        $this->registerDate->AdvancedSearch->SearchCondition = @$filter["v_registerDate"];
        $this->registerDate->AdvancedSearch->SearchValue2 = @$filter["y_registerDate"];
        $this->registerDate->AdvancedSearch->SearchOperator2 = @$filter["w_registerDate"];
        $this->registerDate->AdvancedSearch->save();

        // Field lastUpdate
        $this->lastUpdate->AdvancedSearch->SearchValue = @$filter["x_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator = @$filter["z_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchCondition = @$filter["v_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchValue2 = @$filter["y_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator2 = @$filter["w_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->save();

        // Field incomeReceivable
        $this->incomeReceivable->AdvancedSearch->SearchValue = @$filter["x_incomeReceivable"];
        $this->incomeReceivable->AdvancedSearch->SearchOperator = @$filter["z_incomeReceivable"];
        $this->incomeReceivable->AdvancedSearch->SearchCondition = @$filter["v_incomeReceivable"];
        $this->incomeReceivable->AdvancedSearch->SearchValue2 = @$filter["y_incomeReceivable"];
        $this->incomeReceivable->AdvancedSearch->SearchOperator2 = @$filter["w_incomeReceivable"];
        $this->incomeReceivable->AdvancedSearch->save();

        // Field licenseId
        $this->licenseId->AdvancedSearch->SearchValue = @$filter["x_licenseId"];
        $this->licenseId->AdvancedSearch->SearchOperator = @$filter["z_licenseId"];
        $this->licenseId->AdvancedSearch->SearchCondition = @$filter["v_licenseId"];
        $this->licenseId->AdvancedSearch->SearchValue2 = @$filter["y_licenseId"];
        $this->licenseId->AdvancedSearch->SearchOperator2 = @$filter["w_licenseId"];
        $this->licenseId->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->departamentId, $default, false); // departamentId
        $this->buildSearchSql($where, $this->costCenterId, $default, false); // costCenterId
        $this->buildSearchSql($where, $this->historic, $default, false); // historic
        $this->buildSearchSql($where, $this->issue, $default, false); // issue
        $this->buildSearchSql($where, $this->due, $default, false); // due
        $this->buildSearchSql($where, $this->value, $default, false); // value
        $this->buildSearchSql($where, $this->employeeId, $default, false); // employeeId
        $this->buildSearchSql($where, $this->status, $default, false); // status
        $this->buildSearchSql($where, $this->amountPaid, $default, false); // amountPaid
        $this->buildSearchSql($where, $this->creditorsId, $default, false); // creditorsId
        $this->buildSearchSql($where, $this->typeId, $default, false); // typeId
        $this->buildSearchSql($where, $this->obs, $default, false); // obs
        $this->buildSearchSql($where, $this->invoiceFile, $default, false); // invoiceFile
        $this->buildSearchSql($where, $this->guaranteeFile, $default, false); // guaranteeFile
        $this->buildSearchSql($where, $this->attachedFile, $default, false); // attachedFile
        $this->buildSearchSql($where, $this->deferred, $default, false); // deferred
        $this->buildSearchSql($where, $this->amountInstallments, $default, false); // amountInstallments
        $this->buildSearchSql($where, $this->totalValueDeferred, $default, false); // totalValueDeferred
        $this->buildSearchSql($where, $this->actualInstallment, $default, false); // actualInstallment
        $this->buildSearchSql($where, $this->firstInstallmentDate, $default, false); // firstInstallmentDate
        $this->buildSearchSql($where, $this->accountFather, $default, false); // accountFather
        $this->buildSearchSql($where, $this->_userId, $default, false); // userId
        $this->buildSearchSql($where, $this->schoolId, $default, false); // schoolId
        $this->buildSearchSql($where, $this->lastUserId, $default, false); // lastUserId
        $this->buildSearchSql($where, $this->registerDate, $default, false); // registerDate
        $this->buildSearchSql($where, $this->lastUpdate, $default, false); // lastUpdate
        $this->buildSearchSql($where, $this->incomeReceivable, $default, false); // incomeReceivable
        $this->buildSearchSql($where, $this->licenseId, $default, false); // licenseId

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->departamentId->AdvancedSearch->save(); // departamentId
            $this->costCenterId->AdvancedSearch->save(); // costCenterId
            $this->historic->AdvancedSearch->save(); // historic
            $this->issue->AdvancedSearch->save(); // issue
            $this->due->AdvancedSearch->save(); // due
            $this->value->AdvancedSearch->save(); // value
            $this->employeeId->AdvancedSearch->save(); // employeeId
            $this->status->AdvancedSearch->save(); // status
            $this->amountPaid->AdvancedSearch->save(); // amountPaid
            $this->creditorsId->AdvancedSearch->save(); // creditorsId
            $this->typeId->AdvancedSearch->save(); // typeId
            $this->obs->AdvancedSearch->save(); // obs
            $this->invoiceFile->AdvancedSearch->save(); // invoiceFile
            $this->guaranteeFile->AdvancedSearch->save(); // guaranteeFile
            $this->attachedFile->AdvancedSearch->save(); // attachedFile
            $this->deferred->AdvancedSearch->save(); // deferred
            $this->amountInstallments->AdvancedSearch->save(); // amountInstallments
            $this->totalValueDeferred->AdvancedSearch->save(); // totalValueDeferred
            $this->actualInstallment->AdvancedSearch->save(); // actualInstallment
            $this->firstInstallmentDate->AdvancedSearch->save(); // firstInstallmentDate
            $this->accountFather->AdvancedSearch->save(); // accountFather
            $this->_userId->AdvancedSearch->save(); // userId
            $this->schoolId->AdvancedSearch->save(); // schoolId
            $this->lastUserId->AdvancedSearch->save(); // lastUserId
            $this->registerDate->AdvancedSearch->save(); // registerDate
            $this->lastUpdate->AdvancedSearch->save(); // lastUpdate
            $this->incomeReceivable->AdvancedSearch->save(); // incomeReceivable
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
        $searchFlds[] = &$this->historic;
        $searchFlds[] = &$this->obs;
        $searchFlds[] = &$this->invoiceFile;
        $searchFlds[] = &$this->guaranteeFile;
        $searchFlds[] = &$this->attachedFile;
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
        if ($this->departamentId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->costCenterId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->historic->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->issue->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->due->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->value->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->employeeId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->status->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->amountPaid->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->creditorsId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->typeId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->obs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->invoiceFile->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->guaranteeFile->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->attachedFile->AdvancedSearch->issetSession()) {
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
        if ($this->actualInstallment->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->firstInstallmentDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->accountFather->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_userId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->schoolId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lastUserId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->registerDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lastUpdate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->incomeReceivable->AdvancedSearch->issetSession()) {
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
        $this->departamentId->AdvancedSearch->unsetSession();
        $this->costCenterId->AdvancedSearch->unsetSession();
        $this->historic->AdvancedSearch->unsetSession();
        $this->issue->AdvancedSearch->unsetSession();
        $this->due->AdvancedSearch->unsetSession();
        $this->value->AdvancedSearch->unsetSession();
        $this->employeeId->AdvancedSearch->unsetSession();
        $this->status->AdvancedSearch->unsetSession();
        $this->amountPaid->AdvancedSearch->unsetSession();
        $this->creditorsId->AdvancedSearch->unsetSession();
        $this->typeId->AdvancedSearch->unsetSession();
        $this->obs->AdvancedSearch->unsetSession();
        $this->invoiceFile->AdvancedSearch->unsetSession();
        $this->guaranteeFile->AdvancedSearch->unsetSession();
        $this->attachedFile->AdvancedSearch->unsetSession();
        $this->deferred->AdvancedSearch->unsetSession();
        $this->amountInstallments->AdvancedSearch->unsetSession();
        $this->totalValueDeferred->AdvancedSearch->unsetSession();
        $this->actualInstallment->AdvancedSearch->unsetSession();
        $this->firstInstallmentDate->AdvancedSearch->unsetSession();
        $this->accountFather->AdvancedSearch->unsetSession();
        $this->_userId->AdvancedSearch->unsetSession();
        $this->schoolId->AdvancedSearch->unsetSession();
        $this->lastUserId->AdvancedSearch->unsetSession();
        $this->registerDate->AdvancedSearch->unsetSession();
        $this->lastUpdate->AdvancedSearch->unsetSession();
        $this->incomeReceivable->AdvancedSearch->unsetSession();
        $this->licenseId->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->id->AdvancedSearch->load();
        $this->departamentId->AdvancedSearch->load();
        $this->costCenterId->AdvancedSearch->load();
        $this->historic->AdvancedSearch->load();
        $this->issue->AdvancedSearch->load();
        $this->due->AdvancedSearch->load();
        $this->value->AdvancedSearch->load();
        $this->employeeId->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->amountPaid->AdvancedSearch->load();
        $this->creditorsId->AdvancedSearch->load();
        $this->typeId->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->invoiceFile->AdvancedSearch->load();
        $this->guaranteeFile->AdvancedSearch->load();
        $this->attachedFile->AdvancedSearch->load();
        $this->deferred->AdvancedSearch->load();
        $this->amountInstallments->AdvancedSearch->load();
        $this->totalValueDeferred->AdvancedSearch->load();
        $this->actualInstallment->AdvancedSearch->load();
        $this->firstInstallmentDate->AdvancedSearch->load();
        $this->accountFather->AdvancedSearch->load();
        $this->_userId->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->lastUserId->AdvancedSearch->load();
        $this->registerDate->AdvancedSearch->load();
        $this->lastUpdate->AdvancedSearch->load();
        $this->incomeReceivable->AdvancedSearch->load();
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
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->departamentId); // departamentId
            $this->updateSort($this->historic); // historic
            $this->updateSort($this->issue); // issue
            $this->updateSort($this->due); // due
            $this->updateSort($this->value); // value
            $this->updateSort($this->status); // status
            $this->updateSort($this->amountPaid); // amountPaid
            $this->updateSort($this->creditorsId); // creditorsId
            $this->updateSort($this->typeId); // typeId
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
                $this->id->setSort("");
                $this->departamentId->setSort("");
                $this->costCenterId->setSort("");
                $this->historic->setSort("");
                $this->issue->setSort("");
                $this->due->setSort("");
                $this->value->setSort("");
                $this->employeeId->setSort("");
                $this->status->setSort("");
                $this->amountPaid->setSort("");
                $this->creditorsId->setSort("");
                $this->typeId->setSort("");
                $this->obs->setSort("");
                $this->invoiceFile->setSort("");
                $this->guaranteeFile->setSort("");
                $this->attachedFile->setSort("");
                $this->deferred->setSort("");
                $this->amountInstallments->setSort("");
                $this->totalValueDeferred->setSort("");
                $this->actualInstallment->setSort("");
                $this->firstInstallmentDate->setSort("");
                $this->accountFather->setSort("");
                $this->_userId->setSort("");
                $this->schoolId->setSort("");
                $this->lastUserId->setSort("");
                $this->registerDate->setSort("");
                $this->lastUpdate->setSort("");
                $this->incomeReceivable->setSort("");
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

        // "detail_fin_debit"
        $item = &$this->ListOptions->add("detail_fin_debit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'fin_debit');
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
        $pages->add("fin_debit");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffin_accountspayablelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffin_accountspayablelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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

        // "detail_fin_debit"
        $opt = $this->ListOptions["detail_fin_debit"];
        if ($Security->allowList(CurrentProjectID() . 'fin_debit') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("fin_debit", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("FinDebitList?" . Config("TABLE_SHOW_MASTER") . "=fin_accountspayable&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("FinDebitGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "fin_debit";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "fin_debit";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "fin_debit";
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

        // Column "detail_fin_debit"
        if ($this->DetailPages && $this->DetailPages["fin_debit"] && $this->DetailPages["fin_debit"]->Visible && $Security->allowList(CurrentProjectID() . 'fin_debit')) {
            $link = "";
            $option = $this->ListOptions["detail_fin_debit"];
            $url = "FinDebitPreview?t=fin_accountspayable&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"fin_debit\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'fin_accountspayable')) {
                $label = $Language->TablePhrase("fin_debit", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"fin_debit\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("FinDebitList?" . Config("TABLE_SHOW_MASTER") . "=fin_accountspayable&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("fin_debit", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("FinDebitGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fin_accountspayable')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit"));
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
                $item = &$option->add("detailadd_fin_debit");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=fin_debit");
                $detailPage = Container("FinDebitGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'fin_accountspayable') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "fin_debit";
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
            $option->add("departamentId", $this->createColumnOption("departamentId"));
            $option->add("historic", $this->createColumnOption("historic"));
            $option->add("issue", $this->createColumnOption("issue"));
            $option->add("due", $this->createColumnOption("due"));
            $option->add("value", $this->createColumnOption("value"));
            $option->add("status", $this->createColumnOption("status"));
            $option->add("amountPaid", $this->createColumnOption("amountPaid"));
            $option->add("creditorsId", $this->createColumnOption("creditorsId"));
            $option->add("typeId", $this->createColumnOption("typeId"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"ffin_accountspayablesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"ffin_accountspayablesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="ffin_accountspayablelist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

        // departamentId
        if ($this->departamentId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->departamentId->AdvancedSearch->SearchValue != "" || $this->departamentId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // costCenterId
        if ($this->costCenterId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->costCenterId->AdvancedSearch->SearchValue != "" || $this->costCenterId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // value
        if ($this->value->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->value->AdvancedSearch->SearchValue != "" || $this->value->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // employeeId
        if ($this->employeeId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->employeeId->AdvancedSearch->SearchValue != "" || $this->employeeId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // amountPaid
        if ($this->amountPaid->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->amountPaid->AdvancedSearch->SearchValue != "" || $this->amountPaid->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // creditorsId
        if ($this->creditorsId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->creditorsId->AdvancedSearch->SearchValue != "" || $this->creditorsId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // typeId
        if ($this->typeId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->typeId->AdvancedSearch->SearchValue != "" || $this->typeId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // invoiceFile
        if ($this->invoiceFile->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->invoiceFile->AdvancedSearch->SearchValue != "" || $this->invoiceFile->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // guaranteeFile
        if ($this->guaranteeFile->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->guaranteeFile->AdvancedSearch->SearchValue != "" || $this->guaranteeFile->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // attachedFile
        if ($this->attachedFile->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->attachedFile->AdvancedSearch->SearchValue != "" || $this->attachedFile->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // actualInstallment
        if ($this->actualInstallment->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->actualInstallment->AdvancedSearch->SearchValue != "" || $this->actualInstallment->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // firstInstallmentDate
        if ($this->firstInstallmentDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->firstInstallmentDate->AdvancedSearch->SearchValue != "" || $this->firstInstallmentDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // userId
        if ($this->_userId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_userId->AdvancedSearch->SearchValue != "" || $this->_userId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // registerDate
        if ($this->registerDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->registerDate->AdvancedSearch->SearchValue != "" || $this->registerDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // incomeReceivable
        if ($this->incomeReceivable->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->incomeReceivable->AdvancedSearch->SearchValue != "" || $this->incomeReceivable->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // departamentId

        // costCenterId

        // historic

        // issue

        // due

        // value

        // employeeId

        // status

        // amountPaid

        // creditorsId

        // typeId

        // obs

        // invoiceFile

        // guaranteeFile

        // attachedFile

        // deferred

        // amountInstallments

        // totalValueDeferred

        // actualInstallment

        // firstInstallmentDate

        // accountFather

        // userId

        // schoolId

        // lastUserId

        // registerDate

        // lastUpdate

        // incomeReceivable

        // licenseId

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
            $this->id->TooltipValue = "";

            // departamentId
            $this->departamentId->LinkCustomAttributes = "";
            $this->departamentId->HrefValue = "";
            $this->departamentId->TooltipValue = "";

            // historic
            $this->historic->LinkCustomAttributes = "";
            $this->historic->HrefValue = "";
            $this->historic->TooltipValue = "";

            // issue
            $this->issue->LinkCustomAttributes = "";
            $this->issue->HrefValue = "";
            $this->issue->TooltipValue = "";

            // due
            $this->due->LinkCustomAttributes = "";
            $this->due->HrefValue = "";
            $this->due->TooltipValue = "";

            // value
            $this->value->LinkCustomAttributes = "";
            $this->value->HrefValue = "";
            $this->value->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // amountPaid
            $this->amountPaid->LinkCustomAttributes = "";
            $this->amountPaid->HrefValue = "";
            $this->amountPaid->TooltipValue = "";

            // creditorsId
            $this->creditorsId->LinkCustomAttributes = "";
            $this->creditorsId->HrefValue = "";
            $this->creditorsId->TooltipValue = "";

            // typeId
            $this->typeId->LinkCustomAttributes = "";
            $this->typeId->HrefValue = "";
            $this->typeId->TooltipValue = "";

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

            // departamentId
            $this->departamentId->setupEditAttributes();
            $this->departamentId->EditCustomAttributes = "";
            $curVal = trim(strval($this->departamentId->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->departamentId->AdvancedSearch->ViewValue = $this->departamentId->lookupCacheOption($curVal);
            } else {
                $this->departamentId->AdvancedSearch->ViewValue = $this->departamentId->Lookup !== null && is_array($this->departamentId->lookupOptions()) ? $curVal : null;
            }
            if ($this->departamentId->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->departamentId->EditValue = array_values($this->departamentId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->departamentId->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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

            // historic
            $this->historic->setupEditAttributes();
            $this->historic->EditCustomAttributes = "";
            if (!$this->historic->Raw) {
                $this->historic->AdvancedSearch->SearchValue = HtmlDecode($this->historic->AdvancedSearch->SearchValue);
            }
            $this->historic->EditValue = HtmlEncode($this->historic->AdvancedSearch->SearchValue);
            $this->historic->PlaceHolder = RemoveHtml($this->historic->caption());

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

            // value
            $this->value->setupEditAttributes();
            $this->value->EditCustomAttributes = "";
            $this->value->EditValue = HtmlEncode($this->value->AdvancedSearch->SearchValue);
            $this->value->PlaceHolder = RemoveHtml($this->value->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // amountPaid
            $this->amountPaid->setupEditAttributes();
            $this->amountPaid->EditCustomAttributes = "";
            $this->amountPaid->EditValue = HtmlEncode($this->amountPaid->AdvancedSearch->SearchValue);
            $this->amountPaid->PlaceHolder = RemoveHtml($this->amountPaid->caption());

            // creditorsId
            $this->creditorsId->setupEditAttributes();
            $this->creditorsId->EditCustomAttributes = "";
            $this->creditorsId->PlaceHolder = RemoveHtml($this->creditorsId->caption());

            // typeId
            $this->typeId->setupEditAttributes();
            $this->typeId->EditCustomAttributes = "";
            $this->typeId->PlaceHolder = RemoveHtml($this->typeId->caption());

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
        if (!CheckDate($this->issue->AdvancedSearch->SearchValue, $this->issue->formatPattern())) {
            $this->issue->addErrorMessage($this->issue->getErrorMessage(false));
        }
        if (!CheckDate($this->due->AdvancedSearch->SearchValue, $this->due->formatPattern())) {
            $this->due->addErrorMessage($this->due->getErrorMessage(false));
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
        $this->departamentId->AdvancedSearch->load();
        $this->costCenterId->AdvancedSearch->load();
        $this->historic->AdvancedSearch->load();
        $this->issue->AdvancedSearch->load();
        $this->due->AdvancedSearch->load();
        $this->value->AdvancedSearch->load();
        $this->employeeId->AdvancedSearch->load();
        $this->status->AdvancedSearch->load();
        $this->amountPaid->AdvancedSearch->load();
        $this->creditorsId->AdvancedSearch->load();
        $this->typeId->AdvancedSearch->load();
        $this->obs->AdvancedSearch->load();
        $this->invoiceFile->AdvancedSearch->load();
        $this->guaranteeFile->AdvancedSearch->load();
        $this->attachedFile->AdvancedSearch->load();
        $this->deferred->AdvancedSearch->load();
        $this->amountInstallments->AdvancedSearch->load();
        $this->totalValueDeferred->AdvancedSearch->load();
        $this->actualInstallment->AdvancedSearch->load();
        $this->firstInstallmentDate->AdvancedSearch->load();
        $this->accountFather->AdvancedSearch->load();
        $this->_userId->AdvancedSearch->load();
        $this->schoolId->AdvancedSearch->load();
        $this->lastUserId->AdvancedSearch->load();
        $this->registerDate->AdvancedSearch->load();
        $this->lastUpdate->AdvancedSearch->load();
        $this->incomeReceivable->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"ffin_accountspayablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"ffin_accountspayablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"ffin_accountspayablelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="ffin_accountspayablelist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"ffin_accountspayablesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
        /*
        	Script para bloquear o acesso do usuário às configurações das contas criadas pelas MAS
        */
        if($this->incomeReceivable->CurrentValue > 0){ // caso seja uma conta criada pela federação
               $this->EditUrl = "";
               $this->DeleteUrl = "";
               $this->CopyUrl = "";
        }
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
