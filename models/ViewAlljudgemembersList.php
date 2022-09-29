<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ViewAlljudgemembersList extends ViewAlljudgemembers
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'view_alljudgemembers';

    // Page object name
    public $PageObjName = "ViewAlljudgemembersList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_alljudgememberslist";
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

        // Table object (view_alljudgemembers)
        if (!isset($GLOBALS["view_alljudgemembers"]) || get_class($GLOBALS["view_alljudgemembers"]) == PROJECT_NAMESPACE . "view_alljudgemembers") {
            $GLOBALS["view_alljudgemembers"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewAlljudgemembersAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "ViewAlljudgemembersDelete";
        $this->MultiUpdateUrl = "ViewAlljudgemembersUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_alljudgemembers');
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
                $tbl = Container("view_alljudgemembers");
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
        $this->name->setVisibility();
        $this->lastName->setVisibility();
        $this->instructorStatus->setVisibility();
        $this->birthdate->setVisibility();
        $this->gender->setVisibility();
        $this->address->setVisibility();
        $this->neighborhood->setVisibility();
        $this->countryId->setVisibility();
        $this->UFId->setVisibility();
        $this->cityId->setVisibility();
        $this->zip->setVisibility();
        $this->celphone->setVisibility();
        $this->_email->setVisibility();
        $this->facebook->setVisibility();
        $this->instagram->setVisibility();
        $this->father->setVisibility();
        $this->fatherCellphone->setVisibility();
        $this->receiveSmsFather->setVisibility();
        $this->fatherEmail->setVisibility();
        $this->receiveEmailFather->setVisibility();
        $this->fatherOccupation->setVisibility();
        $this->fatherBirthdate->setVisibility();
        $this->mother->setVisibility();
        $this->motherCellphone->setVisibility();
        $this->receiveSmsMother->setVisibility();
        $this->motherEmail->setVisibility();
        $this->receiveEmailMother->setVisibility();
        $this->motherOccupation->setVisibility();
        $this->motherBirthdate->setVisibility();
        $this->emergencyContact->setVisibility();
        $this->emergencyFone->setVisibility();
        $this->obs->Visible = false;
        $this->schoolId->setVisibility();
        $this->memberStatusId->setVisibility();
        $this->photo->setVisibility();
        $this->beltSize->setVisibility();
        $this->dobokSize->setVisibility();
        $this->programId->setVisibility();
        $this->martialArtId->setVisibility();
        $this->modalityId->setVisibility();
        $this->classId->setVisibility();
        $this->federationRegister->setVisibility();
        $this->memberLevelId->setVisibility();
        $this->instructorLevelId->setVisibility();
        $this->judgeLevelId->setVisibility();
        $this->federationRegisterDate->setVisibility();
        $this->federationStatus->setVisibility();
        $this->createDate->setVisibility();
        $this->createUserId->setVisibility();
        $this->lastUpdate->setVisibility();
        $this->lastUserId->setVisibility();
        $this->rankId->setVisibility();
        $this->marketingSourceId->setVisibility();
        $this->marketingSourceDetail->setVisibility();
        $this->memberTypeId->setVisibility();
        $this->schoolUserId->setVisibility();
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
        $this->setupLookupOptions($this->instructorStatus);
        $this->setupLookupOptions($this->federationStatus);

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

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fview_alljudgememberssrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->name->AdvancedSearch->toJson(), ","); // Field name
        $filterList = Concat($filterList, $this->lastName->AdvancedSearch->toJson(), ","); // Field lastName
        $filterList = Concat($filterList, $this->instructorStatus->AdvancedSearch->toJson(), ","); // Field instructorStatus
        $filterList = Concat($filterList, $this->birthdate->AdvancedSearch->toJson(), ","); // Field birthdate
        $filterList = Concat($filterList, $this->gender->AdvancedSearch->toJson(), ","); // Field gender
        $filterList = Concat($filterList, $this->address->AdvancedSearch->toJson(), ","); // Field address
        $filterList = Concat($filterList, $this->neighborhood->AdvancedSearch->toJson(), ","); // Field neighborhood
        $filterList = Concat($filterList, $this->countryId->AdvancedSearch->toJson(), ","); // Field countryId
        $filterList = Concat($filterList, $this->UFId->AdvancedSearch->toJson(), ","); // Field UFId
        $filterList = Concat($filterList, $this->cityId->AdvancedSearch->toJson(), ","); // Field cityId
        $filterList = Concat($filterList, $this->zip->AdvancedSearch->toJson(), ","); // Field zip
        $filterList = Concat($filterList, $this->celphone->AdvancedSearch->toJson(), ","); // Field celphone
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->facebook->AdvancedSearch->toJson(), ","); // Field facebook
        $filterList = Concat($filterList, $this->instagram->AdvancedSearch->toJson(), ","); // Field instagram
        $filterList = Concat($filterList, $this->father->AdvancedSearch->toJson(), ","); // Field father
        $filterList = Concat($filterList, $this->fatherCellphone->AdvancedSearch->toJson(), ","); // Field fatherCellphone
        $filterList = Concat($filterList, $this->receiveSmsFather->AdvancedSearch->toJson(), ","); // Field receiveSmsFather
        $filterList = Concat($filterList, $this->fatherEmail->AdvancedSearch->toJson(), ","); // Field fatherEmail
        $filterList = Concat($filterList, $this->receiveEmailFather->AdvancedSearch->toJson(), ","); // Field receiveEmailFather
        $filterList = Concat($filterList, $this->fatherOccupation->AdvancedSearch->toJson(), ","); // Field fatherOccupation
        $filterList = Concat($filterList, $this->fatherBirthdate->AdvancedSearch->toJson(), ","); // Field fatherBirthdate
        $filterList = Concat($filterList, $this->mother->AdvancedSearch->toJson(), ","); // Field mother
        $filterList = Concat($filterList, $this->motherCellphone->AdvancedSearch->toJson(), ","); // Field motherCellphone
        $filterList = Concat($filterList, $this->receiveSmsMother->AdvancedSearch->toJson(), ","); // Field receiveSmsMother
        $filterList = Concat($filterList, $this->motherEmail->AdvancedSearch->toJson(), ","); // Field motherEmail
        $filterList = Concat($filterList, $this->receiveEmailMother->AdvancedSearch->toJson(), ","); // Field receiveEmailMother
        $filterList = Concat($filterList, $this->motherOccupation->AdvancedSearch->toJson(), ","); // Field motherOccupation
        $filterList = Concat($filterList, $this->motherBirthdate->AdvancedSearch->toJson(), ","); // Field motherBirthdate
        $filterList = Concat($filterList, $this->emergencyContact->AdvancedSearch->toJson(), ","); // Field emergencyContact
        $filterList = Concat($filterList, $this->emergencyFone->AdvancedSearch->toJson(), ","); // Field emergencyFone
        $filterList = Concat($filterList, $this->obs->AdvancedSearch->toJson(), ","); // Field obs
        $filterList = Concat($filterList, $this->schoolId->AdvancedSearch->toJson(), ","); // Field schoolId
        $filterList = Concat($filterList, $this->memberStatusId->AdvancedSearch->toJson(), ","); // Field memberStatusId
        $filterList = Concat($filterList, $this->photo->AdvancedSearch->toJson(), ","); // Field photo
        $filterList = Concat($filterList, $this->beltSize->AdvancedSearch->toJson(), ","); // Field beltSize
        $filterList = Concat($filterList, $this->dobokSize->AdvancedSearch->toJson(), ","); // Field dobokSize
        $filterList = Concat($filterList, $this->programId->AdvancedSearch->toJson(), ","); // Field programId
        $filterList = Concat($filterList, $this->martialArtId->AdvancedSearch->toJson(), ","); // Field martialArtId
        $filterList = Concat($filterList, $this->modalityId->AdvancedSearch->toJson(), ","); // Field modalityId
        $filterList = Concat($filterList, $this->classId->AdvancedSearch->toJson(), ","); // Field classId
        $filterList = Concat($filterList, $this->federationRegister->AdvancedSearch->toJson(), ","); // Field federationRegister
        $filterList = Concat($filterList, $this->memberLevelId->AdvancedSearch->toJson(), ","); // Field memberLevelId
        $filterList = Concat($filterList, $this->instructorLevelId->AdvancedSearch->toJson(), ","); // Field instructorLevelId
        $filterList = Concat($filterList, $this->judgeLevelId->AdvancedSearch->toJson(), ","); // Field judgeLevelId
        $filterList = Concat($filterList, $this->federationRegisterDate->AdvancedSearch->toJson(), ","); // Field federationRegisterDate
        $filterList = Concat($filterList, $this->federationStatus->AdvancedSearch->toJson(), ","); // Field federationStatus
        $filterList = Concat($filterList, $this->createDate->AdvancedSearch->toJson(), ","); // Field createDate
        $filterList = Concat($filterList, $this->createUserId->AdvancedSearch->toJson(), ","); // Field createUserId
        $filterList = Concat($filterList, $this->lastUpdate->AdvancedSearch->toJson(), ","); // Field lastUpdate
        $filterList = Concat($filterList, $this->lastUserId->AdvancedSearch->toJson(), ","); // Field lastUserId
        $filterList = Concat($filterList, $this->rankId->AdvancedSearch->toJson(), ","); // Field rankId
        $filterList = Concat($filterList, $this->marketingSourceId->AdvancedSearch->toJson(), ","); // Field marketingSourceId
        $filterList = Concat($filterList, $this->marketingSourceDetail->AdvancedSearch->toJson(), ","); // Field marketingSourceDetail
        $filterList = Concat($filterList, $this->memberTypeId->AdvancedSearch->toJson(), ","); // Field memberTypeId
        $filterList = Concat($filterList, $this->schoolUserId->AdvancedSearch->toJson(), ","); // Field schoolUserId
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fview_alljudgememberssrch", $filters);
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

        // Field name
        $this->name->AdvancedSearch->SearchValue = @$filter["x_name"];
        $this->name->AdvancedSearch->SearchOperator = @$filter["z_name"];
        $this->name->AdvancedSearch->SearchCondition = @$filter["v_name"];
        $this->name->AdvancedSearch->SearchValue2 = @$filter["y_name"];
        $this->name->AdvancedSearch->SearchOperator2 = @$filter["w_name"];
        $this->name->AdvancedSearch->save();

        // Field lastName
        $this->lastName->AdvancedSearch->SearchValue = @$filter["x_lastName"];
        $this->lastName->AdvancedSearch->SearchOperator = @$filter["z_lastName"];
        $this->lastName->AdvancedSearch->SearchCondition = @$filter["v_lastName"];
        $this->lastName->AdvancedSearch->SearchValue2 = @$filter["y_lastName"];
        $this->lastName->AdvancedSearch->SearchOperator2 = @$filter["w_lastName"];
        $this->lastName->AdvancedSearch->save();

        // Field instructorStatus
        $this->instructorStatus->AdvancedSearch->SearchValue = @$filter["x_instructorStatus"];
        $this->instructorStatus->AdvancedSearch->SearchOperator = @$filter["z_instructorStatus"];
        $this->instructorStatus->AdvancedSearch->SearchCondition = @$filter["v_instructorStatus"];
        $this->instructorStatus->AdvancedSearch->SearchValue2 = @$filter["y_instructorStatus"];
        $this->instructorStatus->AdvancedSearch->SearchOperator2 = @$filter["w_instructorStatus"];
        $this->instructorStatus->AdvancedSearch->save();

        // Field birthdate
        $this->birthdate->AdvancedSearch->SearchValue = @$filter["x_birthdate"];
        $this->birthdate->AdvancedSearch->SearchOperator = @$filter["z_birthdate"];
        $this->birthdate->AdvancedSearch->SearchCondition = @$filter["v_birthdate"];
        $this->birthdate->AdvancedSearch->SearchValue2 = @$filter["y_birthdate"];
        $this->birthdate->AdvancedSearch->SearchOperator2 = @$filter["w_birthdate"];
        $this->birthdate->AdvancedSearch->save();

        // Field gender
        $this->gender->AdvancedSearch->SearchValue = @$filter["x_gender"];
        $this->gender->AdvancedSearch->SearchOperator = @$filter["z_gender"];
        $this->gender->AdvancedSearch->SearchCondition = @$filter["v_gender"];
        $this->gender->AdvancedSearch->SearchValue2 = @$filter["y_gender"];
        $this->gender->AdvancedSearch->SearchOperator2 = @$filter["w_gender"];
        $this->gender->AdvancedSearch->save();

        // Field address
        $this->address->AdvancedSearch->SearchValue = @$filter["x_address"];
        $this->address->AdvancedSearch->SearchOperator = @$filter["z_address"];
        $this->address->AdvancedSearch->SearchCondition = @$filter["v_address"];
        $this->address->AdvancedSearch->SearchValue2 = @$filter["y_address"];
        $this->address->AdvancedSearch->SearchOperator2 = @$filter["w_address"];
        $this->address->AdvancedSearch->save();

        // Field neighborhood
        $this->neighborhood->AdvancedSearch->SearchValue = @$filter["x_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchOperator = @$filter["z_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchCondition = @$filter["v_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchValue2 = @$filter["y_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchOperator2 = @$filter["w_neighborhood"];
        $this->neighborhood->AdvancedSearch->save();

        // Field countryId
        $this->countryId->AdvancedSearch->SearchValue = @$filter["x_countryId"];
        $this->countryId->AdvancedSearch->SearchOperator = @$filter["z_countryId"];
        $this->countryId->AdvancedSearch->SearchCondition = @$filter["v_countryId"];
        $this->countryId->AdvancedSearch->SearchValue2 = @$filter["y_countryId"];
        $this->countryId->AdvancedSearch->SearchOperator2 = @$filter["w_countryId"];
        $this->countryId->AdvancedSearch->save();

        // Field UFId
        $this->UFId->AdvancedSearch->SearchValue = @$filter["x_UFId"];
        $this->UFId->AdvancedSearch->SearchOperator = @$filter["z_UFId"];
        $this->UFId->AdvancedSearch->SearchCondition = @$filter["v_UFId"];
        $this->UFId->AdvancedSearch->SearchValue2 = @$filter["y_UFId"];
        $this->UFId->AdvancedSearch->SearchOperator2 = @$filter["w_UFId"];
        $this->UFId->AdvancedSearch->save();

        // Field cityId
        $this->cityId->AdvancedSearch->SearchValue = @$filter["x_cityId"];
        $this->cityId->AdvancedSearch->SearchOperator = @$filter["z_cityId"];
        $this->cityId->AdvancedSearch->SearchCondition = @$filter["v_cityId"];
        $this->cityId->AdvancedSearch->SearchValue2 = @$filter["y_cityId"];
        $this->cityId->AdvancedSearch->SearchOperator2 = @$filter["w_cityId"];
        $this->cityId->AdvancedSearch->save();

        // Field zip
        $this->zip->AdvancedSearch->SearchValue = @$filter["x_zip"];
        $this->zip->AdvancedSearch->SearchOperator = @$filter["z_zip"];
        $this->zip->AdvancedSearch->SearchCondition = @$filter["v_zip"];
        $this->zip->AdvancedSearch->SearchValue2 = @$filter["y_zip"];
        $this->zip->AdvancedSearch->SearchOperator2 = @$filter["w_zip"];
        $this->zip->AdvancedSearch->save();

        // Field celphone
        $this->celphone->AdvancedSearch->SearchValue = @$filter["x_celphone"];
        $this->celphone->AdvancedSearch->SearchOperator = @$filter["z_celphone"];
        $this->celphone->AdvancedSearch->SearchCondition = @$filter["v_celphone"];
        $this->celphone->AdvancedSearch->SearchValue2 = @$filter["y_celphone"];
        $this->celphone->AdvancedSearch->SearchOperator2 = @$filter["w_celphone"];
        $this->celphone->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field facebook
        $this->facebook->AdvancedSearch->SearchValue = @$filter["x_facebook"];
        $this->facebook->AdvancedSearch->SearchOperator = @$filter["z_facebook"];
        $this->facebook->AdvancedSearch->SearchCondition = @$filter["v_facebook"];
        $this->facebook->AdvancedSearch->SearchValue2 = @$filter["y_facebook"];
        $this->facebook->AdvancedSearch->SearchOperator2 = @$filter["w_facebook"];
        $this->facebook->AdvancedSearch->save();

        // Field instagram
        $this->instagram->AdvancedSearch->SearchValue = @$filter["x_instagram"];
        $this->instagram->AdvancedSearch->SearchOperator = @$filter["z_instagram"];
        $this->instagram->AdvancedSearch->SearchCondition = @$filter["v_instagram"];
        $this->instagram->AdvancedSearch->SearchValue2 = @$filter["y_instagram"];
        $this->instagram->AdvancedSearch->SearchOperator2 = @$filter["w_instagram"];
        $this->instagram->AdvancedSearch->save();

        // Field father
        $this->father->AdvancedSearch->SearchValue = @$filter["x_father"];
        $this->father->AdvancedSearch->SearchOperator = @$filter["z_father"];
        $this->father->AdvancedSearch->SearchCondition = @$filter["v_father"];
        $this->father->AdvancedSearch->SearchValue2 = @$filter["y_father"];
        $this->father->AdvancedSearch->SearchOperator2 = @$filter["w_father"];
        $this->father->AdvancedSearch->save();

        // Field fatherCellphone
        $this->fatherCellphone->AdvancedSearch->SearchValue = @$filter["x_fatherCellphone"];
        $this->fatherCellphone->AdvancedSearch->SearchOperator = @$filter["z_fatherCellphone"];
        $this->fatherCellphone->AdvancedSearch->SearchCondition = @$filter["v_fatherCellphone"];
        $this->fatherCellphone->AdvancedSearch->SearchValue2 = @$filter["y_fatherCellphone"];
        $this->fatherCellphone->AdvancedSearch->SearchOperator2 = @$filter["w_fatherCellphone"];
        $this->fatherCellphone->AdvancedSearch->save();

        // Field receiveSmsFather
        $this->receiveSmsFather->AdvancedSearch->SearchValue = @$filter["x_receiveSmsFather"];
        $this->receiveSmsFather->AdvancedSearch->SearchOperator = @$filter["z_receiveSmsFather"];
        $this->receiveSmsFather->AdvancedSearch->SearchCondition = @$filter["v_receiveSmsFather"];
        $this->receiveSmsFather->AdvancedSearch->SearchValue2 = @$filter["y_receiveSmsFather"];
        $this->receiveSmsFather->AdvancedSearch->SearchOperator2 = @$filter["w_receiveSmsFather"];
        $this->receiveSmsFather->AdvancedSearch->save();

        // Field fatherEmail
        $this->fatherEmail->AdvancedSearch->SearchValue = @$filter["x_fatherEmail"];
        $this->fatherEmail->AdvancedSearch->SearchOperator = @$filter["z_fatherEmail"];
        $this->fatherEmail->AdvancedSearch->SearchCondition = @$filter["v_fatherEmail"];
        $this->fatherEmail->AdvancedSearch->SearchValue2 = @$filter["y_fatherEmail"];
        $this->fatherEmail->AdvancedSearch->SearchOperator2 = @$filter["w_fatherEmail"];
        $this->fatherEmail->AdvancedSearch->save();

        // Field receiveEmailFather
        $this->receiveEmailFather->AdvancedSearch->SearchValue = @$filter["x_receiveEmailFather"];
        $this->receiveEmailFather->AdvancedSearch->SearchOperator = @$filter["z_receiveEmailFather"];
        $this->receiveEmailFather->AdvancedSearch->SearchCondition = @$filter["v_receiveEmailFather"];
        $this->receiveEmailFather->AdvancedSearch->SearchValue2 = @$filter["y_receiveEmailFather"];
        $this->receiveEmailFather->AdvancedSearch->SearchOperator2 = @$filter["w_receiveEmailFather"];
        $this->receiveEmailFather->AdvancedSearch->save();

        // Field fatherOccupation
        $this->fatherOccupation->AdvancedSearch->SearchValue = @$filter["x_fatherOccupation"];
        $this->fatherOccupation->AdvancedSearch->SearchOperator = @$filter["z_fatherOccupation"];
        $this->fatherOccupation->AdvancedSearch->SearchCondition = @$filter["v_fatherOccupation"];
        $this->fatherOccupation->AdvancedSearch->SearchValue2 = @$filter["y_fatherOccupation"];
        $this->fatherOccupation->AdvancedSearch->SearchOperator2 = @$filter["w_fatherOccupation"];
        $this->fatherOccupation->AdvancedSearch->save();

        // Field fatherBirthdate
        $this->fatherBirthdate->AdvancedSearch->SearchValue = @$filter["x_fatherBirthdate"];
        $this->fatherBirthdate->AdvancedSearch->SearchOperator = @$filter["z_fatherBirthdate"];
        $this->fatherBirthdate->AdvancedSearch->SearchCondition = @$filter["v_fatherBirthdate"];
        $this->fatherBirthdate->AdvancedSearch->SearchValue2 = @$filter["y_fatherBirthdate"];
        $this->fatherBirthdate->AdvancedSearch->SearchOperator2 = @$filter["w_fatherBirthdate"];
        $this->fatherBirthdate->AdvancedSearch->save();

        // Field mother
        $this->mother->AdvancedSearch->SearchValue = @$filter["x_mother"];
        $this->mother->AdvancedSearch->SearchOperator = @$filter["z_mother"];
        $this->mother->AdvancedSearch->SearchCondition = @$filter["v_mother"];
        $this->mother->AdvancedSearch->SearchValue2 = @$filter["y_mother"];
        $this->mother->AdvancedSearch->SearchOperator2 = @$filter["w_mother"];
        $this->mother->AdvancedSearch->save();

        // Field motherCellphone
        $this->motherCellphone->AdvancedSearch->SearchValue = @$filter["x_motherCellphone"];
        $this->motherCellphone->AdvancedSearch->SearchOperator = @$filter["z_motherCellphone"];
        $this->motherCellphone->AdvancedSearch->SearchCondition = @$filter["v_motherCellphone"];
        $this->motherCellphone->AdvancedSearch->SearchValue2 = @$filter["y_motherCellphone"];
        $this->motherCellphone->AdvancedSearch->SearchOperator2 = @$filter["w_motherCellphone"];
        $this->motherCellphone->AdvancedSearch->save();

        // Field receiveSmsMother
        $this->receiveSmsMother->AdvancedSearch->SearchValue = @$filter["x_receiveSmsMother"];
        $this->receiveSmsMother->AdvancedSearch->SearchOperator = @$filter["z_receiveSmsMother"];
        $this->receiveSmsMother->AdvancedSearch->SearchCondition = @$filter["v_receiveSmsMother"];
        $this->receiveSmsMother->AdvancedSearch->SearchValue2 = @$filter["y_receiveSmsMother"];
        $this->receiveSmsMother->AdvancedSearch->SearchOperator2 = @$filter["w_receiveSmsMother"];
        $this->receiveSmsMother->AdvancedSearch->save();

        // Field motherEmail
        $this->motherEmail->AdvancedSearch->SearchValue = @$filter["x_motherEmail"];
        $this->motherEmail->AdvancedSearch->SearchOperator = @$filter["z_motherEmail"];
        $this->motherEmail->AdvancedSearch->SearchCondition = @$filter["v_motherEmail"];
        $this->motherEmail->AdvancedSearch->SearchValue2 = @$filter["y_motherEmail"];
        $this->motherEmail->AdvancedSearch->SearchOperator2 = @$filter["w_motherEmail"];
        $this->motherEmail->AdvancedSearch->save();

        // Field receiveEmailMother
        $this->receiveEmailMother->AdvancedSearch->SearchValue = @$filter["x_receiveEmailMother"];
        $this->receiveEmailMother->AdvancedSearch->SearchOperator = @$filter["z_receiveEmailMother"];
        $this->receiveEmailMother->AdvancedSearch->SearchCondition = @$filter["v_receiveEmailMother"];
        $this->receiveEmailMother->AdvancedSearch->SearchValue2 = @$filter["y_receiveEmailMother"];
        $this->receiveEmailMother->AdvancedSearch->SearchOperator2 = @$filter["w_receiveEmailMother"];
        $this->receiveEmailMother->AdvancedSearch->save();

        // Field motherOccupation
        $this->motherOccupation->AdvancedSearch->SearchValue = @$filter["x_motherOccupation"];
        $this->motherOccupation->AdvancedSearch->SearchOperator = @$filter["z_motherOccupation"];
        $this->motherOccupation->AdvancedSearch->SearchCondition = @$filter["v_motherOccupation"];
        $this->motherOccupation->AdvancedSearch->SearchValue2 = @$filter["y_motherOccupation"];
        $this->motherOccupation->AdvancedSearch->SearchOperator2 = @$filter["w_motherOccupation"];
        $this->motherOccupation->AdvancedSearch->save();

        // Field motherBirthdate
        $this->motherBirthdate->AdvancedSearch->SearchValue = @$filter["x_motherBirthdate"];
        $this->motherBirthdate->AdvancedSearch->SearchOperator = @$filter["z_motherBirthdate"];
        $this->motherBirthdate->AdvancedSearch->SearchCondition = @$filter["v_motherBirthdate"];
        $this->motherBirthdate->AdvancedSearch->SearchValue2 = @$filter["y_motherBirthdate"];
        $this->motherBirthdate->AdvancedSearch->SearchOperator2 = @$filter["w_motherBirthdate"];
        $this->motherBirthdate->AdvancedSearch->save();

        // Field emergencyContact
        $this->emergencyContact->AdvancedSearch->SearchValue = @$filter["x_emergencyContact"];
        $this->emergencyContact->AdvancedSearch->SearchOperator = @$filter["z_emergencyContact"];
        $this->emergencyContact->AdvancedSearch->SearchCondition = @$filter["v_emergencyContact"];
        $this->emergencyContact->AdvancedSearch->SearchValue2 = @$filter["y_emergencyContact"];
        $this->emergencyContact->AdvancedSearch->SearchOperator2 = @$filter["w_emergencyContact"];
        $this->emergencyContact->AdvancedSearch->save();

        // Field emergencyFone
        $this->emergencyFone->AdvancedSearch->SearchValue = @$filter["x_emergencyFone"];
        $this->emergencyFone->AdvancedSearch->SearchOperator = @$filter["z_emergencyFone"];
        $this->emergencyFone->AdvancedSearch->SearchCondition = @$filter["v_emergencyFone"];
        $this->emergencyFone->AdvancedSearch->SearchValue2 = @$filter["y_emergencyFone"];
        $this->emergencyFone->AdvancedSearch->SearchOperator2 = @$filter["w_emergencyFone"];
        $this->emergencyFone->AdvancedSearch->save();

        // Field obs
        $this->obs->AdvancedSearch->SearchValue = @$filter["x_obs"];
        $this->obs->AdvancedSearch->SearchOperator = @$filter["z_obs"];
        $this->obs->AdvancedSearch->SearchCondition = @$filter["v_obs"];
        $this->obs->AdvancedSearch->SearchValue2 = @$filter["y_obs"];
        $this->obs->AdvancedSearch->SearchOperator2 = @$filter["w_obs"];
        $this->obs->AdvancedSearch->save();

        // Field schoolId
        $this->schoolId->AdvancedSearch->SearchValue = @$filter["x_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator = @$filter["z_schoolId"];
        $this->schoolId->AdvancedSearch->SearchCondition = @$filter["v_schoolId"];
        $this->schoolId->AdvancedSearch->SearchValue2 = @$filter["y_schoolId"];
        $this->schoolId->AdvancedSearch->SearchOperator2 = @$filter["w_schoolId"];
        $this->schoolId->AdvancedSearch->save();

        // Field memberStatusId
        $this->memberStatusId->AdvancedSearch->SearchValue = @$filter["x_memberStatusId"];
        $this->memberStatusId->AdvancedSearch->SearchOperator = @$filter["z_memberStatusId"];
        $this->memberStatusId->AdvancedSearch->SearchCondition = @$filter["v_memberStatusId"];
        $this->memberStatusId->AdvancedSearch->SearchValue2 = @$filter["y_memberStatusId"];
        $this->memberStatusId->AdvancedSearch->SearchOperator2 = @$filter["w_memberStatusId"];
        $this->memberStatusId->AdvancedSearch->save();

        // Field photo
        $this->photo->AdvancedSearch->SearchValue = @$filter["x_photo"];
        $this->photo->AdvancedSearch->SearchOperator = @$filter["z_photo"];
        $this->photo->AdvancedSearch->SearchCondition = @$filter["v_photo"];
        $this->photo->AdvancedSearch->SearchValue2 = @$filter["y_photo"];
        $this->photo->AdvancedSearch->SearchOperator2 = @$filter["w_photo"];
        $this->photo->AdvancedSearch->save();

        // Field beltSize
        $this->beltSize->AdvancedSearch->SearchValue = @$filter["x_beltSize"];
        $this->beltSize->AdvancedSearch->SearchOperator = @$filter["z_beltSize"];
        $this->beltSize->AdvancedSearch->SearchCondition = @$filter["v_beltSize"];
        $this->beltSize->AdvancedSearch->SearchValue2 = @$filter["y_beltSize"];
        $this->beltSize->AdvancedSearch->SearchOperator2 = @$filter["w_beltSize"];
        $this->beltSize->AdvancedSearch->save();

        // Field dobokSize
        $this->dobokSize->AdvancedSearch->SearchValue = @$filter["x_dobokSize"];
        $this->dobokSize->AdvancedSearch->SearchOperator = @$filter["z_dobokSize"];
        $this->dobokSize->AdvancedSearch->SearchCondition = @$filter["v_dobokSize"];
        $this->dobokSize->AdvancedSearch->SearchValue2 = @$filter["y_dobokSize"];
        $this->dobokSize->AdvancedSearch->SearchOperator2 = @$filter["w_dobokSize"];
        $this->dobokSize->AdvancedSearch->save();

        // Field programId
        $this->programId->AdvancedSearch->SearchValue = @$filter["x_programId"];
        $this->programId->AdvancedSearch->SearchOperator = @$filter["z_programId"];
        $this->programId->AdvancedSearch->SearchCondition = @$filter["v_programId"];
        $this->programId->AdvancedSearch->SearchValue2 = @$filter["y_programId"];
        $this->programId->AdvancedSearch->SearchOperator2 = @$filter["w_programId"];
        $this->programId->AdvancedSearch->save();

        // Field martialArtId
        $this->martialArtId->AdvancedSearch->SearchValue = @$filter["x_martialArtId"];
        $this->martialArtId->AdvancedSearch->SearchOperator = @$filter["z_martialArtId"];
        $this->martialArtId->AdvancedSearch->SearchCondition = @$filter["v_martialArtId"];
        $this->martialArtId->AdvancedSearch->SearchValue2 = @$filter["y_martialArtId"];
        $this->martialArtId->AdvancedSearch->SearchOperator2 = @$filter["w_martialArtId"];
        $this->martialArtId->AdvancedSearch->save();

        // Field modalityId
        $this->modalityId->AdvancedSearch->SearchValue = @$filter["x_modalityId"];
        $this->modalityId->AdvancedSearch->SearchOperator = @$filter["z_modalityId"];
        $this->modalityId->AdvancedSearch->SearchCondition = @$filter["v_modalityId"];
        $this->modalityId->AdvancedSearch->SearchValue2 = @$filter["y_modalityId"];
        $this->modalityId->AdvancedSearch->SearchOperator2 = @$filter["w_modalityId"];
        $this->modalityId->AdvancedSearch->save();

        // Field classId
        $this->classId->AdvancedSearch->SearchValue = @$filter["x_classId"];
        $this->classId->AdvancedSearch->SearchOperator = @$filter["z_classId"];
        $this->classId->AdvancedSearch->SearchCondition = @$filter["v_classId"];
        $this->classId->AdvancedSearch->SearchValue2 = @$filter["y_classId"];
        $this->classId->AdvancedSearch->SearchOperator2 = @$filter["w_classId"];
        $this->classId->AdvancedSearch->save();

        // Field federationRegister
        $this->federationRegister->AdvancedSearch->SearchValue = @$filter["x_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchOperator = @$filter["z_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchCondition = @$filter["v_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchValue2 = @$filter["y_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchOperator2 = @$filter["w_federationRegister"];
        $this->federationRegister->AdvancedSearch->save();

        // Field memberLevelId
        $this->memberLevelId->AdvancedSearch->SearchValue = @$filter["x_memberLevelId"];
        $this->memberLevelId->AdvancedSearch->SearchOperator = @$filter["z_memberLevelId"];
        $this->memberLevelId->AdvancedSearch->SearchCondition = @$filter["v_memberLevelId"];
        $this->memberLevelId->AdvancedSearch->SearchValue2 = @$filter["y_memberLevelId"];
        $this->memberLevelId->AdvancedSearch->SearchOperator2 = @$filter["w_memberLevelId"];
        $this->memberLevelId->AdvancedSearch->save();

        // Field instructorLevelId
        $this->instructorLevelId->AdvancedSearch->SearchValue = @$filter["x_instructorLevelId"];
        $this->instructorLevelId->AdvancedSearch->SearchOperator = @$filter["z_instructorLevelId"];
        $this->instructorLevelId->AdvancedSearch->SearchCondition = @$filter["v_instructorLevelId"];
        $this->instructorLevelId->AdvancedSearch->SearchValue2 = @$filter["y_instructorLevelId"];
        $this->instructorLevelId->AdvancedSearch->SearchOperator2 = @$filter["w_instructorLevelId"];
        $this->instructorLevelId->AdvancedSearch->save();

        // Field judgeLevelId
        $this->judgeLevelId->AdvancedSearch->SearchValue = @$filter["x_judgeLevelId"];
        $this->judgeLevelId->AdvancedSearch->SearchOperator = @$filter["z_judgeLevelId"];
        $this->judgeLevelId->AdvancedSearch->SearchCondition = @$filter["v_judgeLevelId"];
        $this->judgeLevelId->AdvancedSearch->SearchValue2 = @$filter["y_judgeLevelId"];
        $this->judgeLevelId->AdvancedSearch->SearchOperator2 = @$filter["w_judgeLevelId"];
        $this->judgeLevelId->AdvancedSearch->save();

        // Field federationRegisterDate
        $this->federationRegisterDate->AdvancedSearch->SearchValue = @$filter["x_federationRegisterDate"];
        $this->federationRegisterDate->AdvancedSearch->SearchOperator = @$filter["z_federationRegisterDate"];
        $this->federationRegisterDate->AdvancedSearch->SearchCondition = @$filter["v_federationRegisterDate"];
        $this->federationRegisterDate->AdvancedSearch->SearchValue2 = @$filter["y_federationRegisterDate"];
        $this->federationRegisterDate->AdvancedSearch->SearchOperator2 = @$filter["w_federationRegisterDate"];
        $this->federationRegisterDate->AdvancedSearch->save();

        // Field federationStatus
        $this->federationStatus->AdvancedSearch->SearchValue = @$filter["x_federationStatus"];
        $this->federationStatus->AdvancedSearch->SearchOperator = @$filter["z_federationStatus"];
        $this->federationStatus->AdvancedSearch->SearchCondition = @$filter["v_federationStatus"];
        $this->federationStatus->AdvancedSearch->SearchValue2 = @$filter["y_federationStatus"];
        $this->federationStatus->AdvancedSearch->SearchOperator2 = @$filter["w_federationStatus"];
        $this->federationStatus->AdvancedSearch->save();

        // Field createDate
        $this->createDate->AdvancedSearch->SearchValue = @$filter["x_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator = @$filter["z_createDate"];
        $this->createDate->AdvancedSearch->SearchCondition = @$filter["v_createDate"];
        $this->createDate->AdvancedSearch->SearchValue2 = @$filter["y_createDate"];
        $this->createDate->AdvancedSearch->SearchOperator2 = @$filter["w_createDate"];
        $this->createDate->AdvancedSearch->save();

        // Field createUserId
        $this->createUserId->AdvancedSearch->SearchValue = @$filter["x_createUserId"];
        $this->createUserId->AdvancedSearch->SearchOperator = @$filter["z_createUserId"];
        $this->createUserId->AdvancedSearch->SearchCondition = @$filter["v_createUserId"];
        $this->createUserId->AdvancedSearch->SearchValue2 = @$filter["y_createUserId"];
        $this->createUserId->AdvancedSearch->SearchOperator2 = @$filter["w_createUserId"];
        $this->createUserId->AdvancedSearch->save();

        // Field lastUpdate
        $this->lastUpdate->AdvancedSearch->SearchValue = @$filter["x_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator = @$filter["z_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchCondition = @$filter["v_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchValue2 = @$filter["y_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->SearchOperator2 = @$filter["w_lastUpdate"];
        $this->lastUpdate->AdvancedSearch->save();

        // Field lastUserId
        $this->lastUserId->AdvancedSearch->SearchValue = @$filter["x_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchOperator = @$filter["z_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchCondition = @$filter["v_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchValue2 = @$filter["y_lastUserId"];
        $this->lastUserId->AdvancedSearch->SearchOperator2 = @$filter["w_lastUserId"];
        $this->lastUserId->AdvancedSearch->save();

        // Field rankId
        $this->rankId->AdvancedSearch->SearchValue = @$filter["x_rankId"];
        $this->rankId->AdvancedSearch->SearchOperator = @$filter["z_rankId"];
        $this->rankId->AdvancedSearch->SearchCondition = @$filter["v_rankId"];
        $this->rankId->AdvancedSearch->SearchValue2 = @$filter["y_rankId"];
        $this->rankId->AdvancedSearch->SearchOperator2 = @$filter["w_rankId"];
        $this->rankId->AdvancedSearch->save();

        // Field marketingSourceId
        $this->marketingSourceId->AdvancedSearch->SearchValue = @$filter["x_marketingSourceId"];
        $this->marketingSourceId->AdvancedSearch->SearchOperator = @$filter["z_marketingSourceId"];
        $this->marketingSourceId->AdvancedSearch->SearchCondition = @$filter["v_marketingSourceId"];
        $this->marketingSourceId->AdvancedSearch->SearchValue2 = @$filter["y_marketingSourceId"];
        $this->marketingSourceId->AdvancedSearch->SearchOperator2 = @$filter["w_marketingSourceId"];
        $this->marketingSourceId->AdvancedSearch->save();

        // Field marketingSourceDetail
        $this->marketingSourceDetail->AdvancedSearch->SearchValue = @$filter["x_marketingSourceDetail"];
        $this->marketingSourceDetail->AdvancedSearch->SearchOperator = @$filter["z_marketingSourceDetail"];
        $this->marketingSourceDetail->AdvancedSearch->SearchCondition = @$filter["v_marketingSourceDetail"];
        $this->marketingSourceDetail->AdvancedSearch->SearchValue2 = @$filter["y_marketingSourceDetail"];
        $this->marketingSourceDetail->AdvancedSearch->SearchOperator2 = @$filter["w_marketingSourceDetail"];
        $this->marketingSourceDetail->AdvancedSearch->save();

        // Field memberTypeId
        $this->memberTypeId->AdvancedSearch->SearchValue = @$filter["x_memberTypeId"];
        $this->memberTypeId->AdvancedSearch->SearchOperator = @$filter["z_memberTypeId"];
        $this->memberTypeId->AdvancedSearch->SearchCondition = @$filter["v_memberTypeId"];
        $this->memberTypeId->AdvancedSearch->SearchValue2 = @$filter["y_memberTypeId"];
        $this->memberTypeId->AdvancedSearch->SearchOperator2 = @$filter["w_memberTypeId"];
        $this->memberTypeId->AdvancedSearch->save();

        // Field schoolUserId
        $this->schoolUserId->AdvancedSearch->SearchValue = @$filter["x_schoolUserId"];
        $this->schoolUserId->AdvancedSearch->SearchOperator = @$filter["z_schoolUserId"];
        $this->schoolUserId->AdvancedSearch->SearchCondition = @$filter["v_schoolUserId"];
        $this->schoolUserId->AdvancedSearch->SearchValue2 = @$filter["y_schoolUserId"];
        $this->schoolUserId->AdvancedSearch->SearchOperator2 = @$filter["w_schoolUserId"];
        $this->schoolUserId->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
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
        $searchFlds[] = &$this->name;
        $searchFlds[] = &$this->lastName;
        $searchFlds[] = &$this->gender;
        $searchFlds[] = &$this->address;
        $searchFlds[] = &$this->neighborhood;
        $searchFlds[] = &$this->zip;
        $searchFlds[] = &$this->celphone;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->facebook;
        $searchFlds[] = &$this->instagram;
        $searchFlds[] = &$this->father;
        $searchFlds[] = &$this->fatherCellphone;
        $searchFlds[] = &$this->fatherEmail;
        $searchFlds[] = &$this->fatherOccupation;
        $searchFlds[] = &$this->mother;
        $searchFlds[] = &$this->motherCellphone;
        $searchFlds[] = &$this->motherEmail;
        $searchFlds[] = &$this->motherOccupation;
        $searchFlds[] = &$this->emergencyContact;
        $searchFlds[] = &$this->emergencyFone;
        $searchFlds[] = &$this->obs;
        $searchFlds[] = &$this->photo;
        $searchFlds[] = &$this->dobokSize;
        $searchFlds[] = &$this->federationRegister;
        $searchFlds[] = &$this->marketingSourceDetail;
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

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
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
            $this->updateSort($this->name); // name
            $this->updateSort($this->lastName); // lastName
            $this->updateSort($this->instructorStatus); // instructorStatus
            $this->updateSort($this->birthdate); // birthdate
            $this->updateSort($this->gender); // gender
            $this->updateSort($this->address); // address
            $this->updateSort($this->neighborhood); // neighborhood
            $this->updateSort($this->countryId); // countryId
            $this->updateSort($this->UFId); // UFId
            $this->updateSort($this->cityId); // cityId
            $this->updateSort($this->zip); // zip
            $this->updateSort($this->celphone); // celphone
            $this->updateSort($this->_email); // email
            $this->updateSort($this->facebook); // facebook
            $this->updateSort($this->instagram); // instagram
            $this->updateSort($this->father); // father
            $this->updateSort($this->fatherCellphone); // fatherCellphone
            $this->updateSort($this->receiveSmsFather); // receiveSmsFather
            $this->updateSort($this->fatherEmail); // fatherEmail
            $this->updateSort($this->receiveEmailFather); // receiveEmailFather
            $this->updateSort($this->fatherOccupation); // fatherOccupation
            $this->updateSort($this->fatherBirthdate); // fatherBirthdate
            $this->updateSort($this->mother); // mother
            $this->updateSort($this->motherCellphone); // motherCellphone
            $this->updateSort($this->receiveSmsMother); // receiveSmsMother
            $this->updateSort($this->motherEmail); // motherEmail
            $this->updateSort($this->receiveEmailMother); // receiveEmailMother
            $this->updateSort($this->motherOccupation); // motherOccupation
            $this->updateSort($this->motherBirthdate); // motherBirthdate
            $this->updateSort($this->emergencyContact); // emergencyContact
            $this->updateSort($this->emergencyFone); // emergencyFone
            $this->updateSort($this->schoolId); // schoolId
            $this->updateSort($this->memberStatusId); // memberStatusId
            $this->updateSort($this->photo); // photo
            $this->updateSort($this->beltSize); // beltSize
            $this->updateSort($this->dobokSize); // dobokSize
            $this->updateSort($this->programId); // programId
            $this->updateSort($this->martialArtId); // martialArtId
            $this->updateSort($this->modalityId); // modalityId
            $this->updateSort($this->classId); // classId
            $this->updateSort($this->federationRegister); // federationRegister
            $this->updateSort($this->memberLevelId); // memberLevelId
            $this->updateSort($this->instructorLevelId); // instructorLevelId
            $this->updateSort($this->judgeLevelId); // judgeLevelId
            $this->updateSort($this->federationRegisterDate); // federationRegisterDate
            $this->updateSort($this->federationStatus); // federationStatus
            $this->updateSort($this->createDate); // createDate
            $this->updateSort($this->createUserId); // createUserId
            $this->updateSort($this->lastUpdate); // lastUpdate
            $this->updateSort($this->lastUserId); // lastUserId
            $this->updateSort($this->rankId); // rankId
            $this->updateSort($this->marketingSourceId); // marketingSourceId
            $this->updateSort($this->marketingSourceDetail); // marketingSourceDetail
            $this->updateSort($this->memberTypeId); // memberTypeId
            $this->updateSort($this->schoolUserId); // schoolUserId
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
                $this->name->setSort("");
                $this->lastName->setSort("");
                $this->instructorStatus->setSort("");
                $this->birthdate->setSort("");
                $this->gender->setSort("");
                $this->address->setSort("");
                $this->neighborhood->setSort("");
                $this->countryId->setSort("");
                $this->UFId->setSort("");
                $this->cityId->setSort("");
                $this->zip->setSort("");
                $this->celphone->setSort("");
                $this->_email->setSort("");
                $this->facebook->setSort("");
                $this->instagram->setSort("");
                $this->father->setSort("");
                $this->fatherCellphone->setSort("");
                $this->receiveSmsFather->setSort("");
                $this->fatherEmail->setSort("");
                $this->receiveEmailFather->setSort("");
                $this->fatherOccupation->setSort("");
                $this->fatherBirthdate->setSort("");
                $this->mother->setSort("");
                $this->motherCellphone->setSort("");
                $this->receiveSmsMother->setSort("");
                $this->motherEmail->setSort("");
                $this->receiveEmailMother->setSort("");
                $this->motherOccupation->setSort("");
                $this->motherBirthdate->setSort("");
                $this->emergencyContact->setSort("");
                $this->emergencyFone->setSort("");
                $this->obs->setSort("");
                $this->schoolId->setSort("");
                $this->memberStatusId->setSort("");
                $this->photo->setSort("");
                $this->beltSize->setSort("");
                $this->dobokSize->setSort("");
                $this->programId->setSort("");
                $this->martialArtId->setSort("");
                $this->modalityId->setSort("");
                $this->classId->setSort("");
                $this->federationRegister->setSort("");
                $this->memberLevelId->setSort("");
                $this->instructorLevelId->setSort("");
                $this->judgeLevelId->setSort("");
                $this->federationRegisterDate->setSort("");
                $this->federationStatus->setSort("");
                $this->createDate->setSort("");
                $this->createUserId->setSort("");
                $this->lastUpdate->setSort("");
                $this->lastUserId->setSort("");
                $this->rankId->setSort("");
                $this->marketingSourceId->setSort("");
                $this->marketingSourceDetail->setSort("");
                $this->memberTypeId->setSort("");
                $this->schoolUserId->setSort("");
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
        if ($this->CurrentMode == "view") { // Check view mode
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fview_alljudgememberslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fview_alljudgememberslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("id", $this->createColumnOption("id"));
            $option->add("name", $this->createColumnOption("name"));
            $option->add("lastName", $this->createColumnOption("lastName"));
            $option->add("instructorStatus", $this->createColumnOption("instructorStatus"));
            $option->add("birthdate", $this->createColumnOption("birthdate"));
            $option->add("gender", $this->createColumnOption("gender"));
            $option->add("address", $this->createColumnOption("address"));
            $option->add("neighborhood", $this->createColumnOption("neighborhood"));
            $option->add("countryId", $this->createColumnOption("countryId"));
            $option->add("UFId", $this->createColumnOption("UFId"));
            $option->add("cityId", $this->createColumnOption("cityId"));
            $option->add("zip", $this->createColumnOption("zip"));
            $option->add("celphone", $this->createColumnOption("celphone"));
            $option->add("email", $this->createColumnOption("email"));
            $option->add("facebook", $this->createColumnOption("facebook"));
            $option->add("instagram", $this->createColumnOption("instagram"));
            $option->add("father", $this->createColumnOption("father"));
            $option->add("fatherCellphone", $this->createColumnOption("fatherCellphone"));
            $option->add("receiveSmsFather", $this->createColumnOption("receiveSmsFather"));
            $option->add("fatherEmail", $this->createColumnOption("fatherEmail"));
            $option->add("receiveEmailFather", $this->createColumnOption("receiveEmailFather"));
            $option->add("fatherOccupation", $this->createColumnOption("fatherOccupation"));
            $option->add("fatherBirthdate", $this->createColumnOption("fatherBirthdate"));
            $option->add("mother", $this->createColumnOption("mother"));
            $option->add("motherCellphone", $this->createColumnOption("motherCellphone"));
            $option->add("receiveSmsMother", $this->createColumnOption("receiveSmsMother"));
            $option->add("motherEmail", $this->createColumnOption("motherEmail"));
            $option->add("receiveEmailMother", $this->createColumnOption("receiveEmailMother"));
            $option->add("motherOccupation", $this->createColumnOption("motherOccupation"));
            $option->add("motherBirthdate", $this->createColumnOption("motherBirthdate"));
            $option->add("emergencyContact", $this->createColumnOption("emergencyContact"));
            $option->add("emergencyFone", $this->createColumnOption("emergencyFone"));
            $option->add("schoolId", $this->createColumnOption("schoolId"));
            $option->add("memberStatusId", $this->createColumnOption("memberStatusId"));
            $option->add("photo", $this->createColumnOption("photo"));
            $option->add("beltSize", $this->createColumnOption("beltSize"));
            $option->add("dobokSize", $this->createColumnOption("dobokSize"));
            $option->add("programId", $this->createColumnOption("programId"));
            $option->add("martialArtId", $this->createColumnOption("martialArtId"));
            $option->add("modalityId", $this->createColumnOption("modalityId"));
            $option->add("classId", $this->createColumnOption("classId"));
            $option->add("federationRegister", $this->createColumnOption("federationRegister"));
            $option->add("memberLevelId", $this->createColumnOption("memberLevelId"));
            $option->add("instructorLevelId", $this->createColumnOption("instructorLevelId"));
            $option->add("judgeLevelId", $this->createColumnOption("judgeLevelId"));
            $option->add("federationRegisterDate", $this->createColumnOption("federationRegisterDate"));
            $option->add("federationStatus", $this->createColumnOption("federationStatus"));
            $option->add("createDate", $this->createColumnOption("createDate"));
            $option->add("createUserId", $this->createColumnOption("createUserId"));
            $option->add("lastUpdate", $this->createColumnOption("lastUpdate"));
            $option->add("lastUserId", $this->createColumnOption("lastUserId"));
            $option->add("rankId", $this->createColumnOption("rankId"));
            $option->add("marketingSourceId", $this->createColumnOption("marketingSourceId"));
            $option->add("marketingSourceDetail", $this->createColumnOption("marketingSourceDetail"));
            $option->add("memberTypeId", $this->createColumnOption("memberTypeId"));
            $option->add("schoolUserId", $this->createColumnOption("schoolUserId"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_alljudgememberssrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_alljudgememberssrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_alljudgememberslist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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
        $this->name->setDbValue($row['name']);
        $this->lastName->setDbValue($row['lastName']);
        $this->instructorStatus->setDbValue($row['instructorStatus']);
        $this->birthdate->setDbValue($row['birthdate']);
        $this->gender->setDbValue($row['gender']);
        $this->address->setDbValue($row['address']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->countryId->setDbValue($row['countryId']);
        $this->UFId->setDbValue($row['UFId']);
        $this->cityId->setDbValue($row['cityId']);
        $this->zip->setDbValue($row['zip']);
        $this->celphone->setDbValue($row['celphone']);
        $this->_email->setDbValue($row['email']);
        $this->facebook->setDbValue($row['facebook']);
        $this->instagram->setDbValue($row['instagram']);
        $this->father->setDbValue($row['father']);
        $this->fatherCellphone->setDbValue($row['fatherCellphone']);
        $this->receiveSmsFather->setDbValue($row['receiveSmsFather']);
        $this->fatherEmail->setDbValue($row['fatherEmail']);
        $this->receiveEmailFather->setDbValue($row['receiveEmailFather']);
        $this->fatherOccupation->setDbValue($row['fatherOccupation']);
        $this->fatherBirthdate->setDbValue($row['fatherBirthdate']);
        $this->mother->setDbValue($row['mother']);
        $this->motherCellphone->setDbValue($row['motherCellphone']);
        $this->receiveSmsMother->setDbValue($row['receiveSmsMother']);
        $this->motherEmail->setDbValue($row['motherEmail']);
        $this->receiveEmailMother->setDbValue($row['receiveEmailMother']);
        $this->motherOccupation->setDbValue($row['motherOccupation']);
        $this->motherBirthdate->setDbValue($row['motherBirthdate']);
        $this->emergencyContact->setDbValue($row['emergencyContact']);
        $this->emergencyFone->setDbValue($row['emergencyFone']);
        $this->obs->setDbValue($row['obs']);
        $this->schoolId->setDbValue($row['schoolId']);
        $this->memberStatusId->setDbValue($row['memberStatusId']);
        $this->photo->setDbValue($row['photo']);
        $this->beltSize->setDbValue($row['beltSize']);
        $this->dobokSize->setDbValue($row['dobokSize']);
        $this->programId->setDbValue($row['programId']);
        $this->martialArtId->setDbValue($row['martialArtId']);
        $this->modalityId->setDbValue($row['modalityId']);
        $this->classId->setDbValue($row['classId']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->memberLevelId->setDbValue($row['memberLevelId']);
        $this->instructorLevelId->setDbValue($row['instructorLevelId']);
        $this->judgeLevelId->setDbValue($row['judgeLevelId']);
        $this->federationRegisterDate->setDbValue($row['federationRegisterDate']);
        $this->federationStatus->setDbValue($row['federationStatus']);
        $this->createDate->setDbValue($row['createDate']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->rankId->setDbValue($row['rankId']);
        $this->marketingSourceId->setDbValue($row['marketingSourceId']);
        $this->marketingSourceDetail->setDbValue($row['marketingSourceDetail']);
        $this->memberTypeId->setDbValue($row['memberTypeId']);
        $this->schoolUserId->setDbValue($row['schoolUserId']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['lastName'] = $this->lastName->DefaultValue;
        $row['instructorStatus'] = $this->instructorStatus->DefaultValue;
        $row['birthdate'] = $this->birthdate->DefaultValue;
        $row['gender'] = $this->gender->DefaultValue;
        $row['address'] = $this->address->DefaultValue;
        $row['neighborhood'] = $this->neighborhood->DefaultValue;
        $row['countryId'] = $this->countryId->DefaultValue;
        $row['UFId'] = $this->UFId->DefaultValue;
        $row['cityId'] = $this->cityId->DefaultValue;
        $row['zip'] = $this->zip->DefaultValue;
        $row['celphone'] = $this->celphone->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['facebook'] = $this->facebook->DefaultValue;
        $row['instagram'] = $this->instagram->DefaultValue;
        $row['father'] = $this->father->DefaultValue;
        $row['fatherCellphone'] = $this->fatherCellphone->DefaultValue;
        $row['receiveSmsFather'] = $this->receiveSmsFather->DefaultValue;
        $row['fatherEmail'] = $this->fatherEmail->DefaultValue;
        $row['receiveEmailFather'] = $this->receiveEmailFather->DefaultValue;
        $row['fatherOccupation'] = $this->fatherOccupation->DefaultValue;
        $row['fatherBirthdate'] = $this->fatherBirthdate->DefaultValue;
        $row['mother'] = $this->mother->DefaultValue;
        $row['motherCellphone'] = $this->motherCellphone->DefaultValue;
        $row['receiveSmsMother'] = $this->receiveSmsMother->DefaultValue;
        $row['motherEmail'] = $this->motherEmail->DefaultValue;
        $row['receiveEmailMother'] = $this->receiveEmailMother->DefaultValue;
        $row['motherOccupation'] = $this->motherOccupation->DefaultValue;
        $row['motherBirthdate'] = $this->motherBirthdate->DefaultValue;
        $row['emergencyContact'] = $this->emergencyContact->DefaultValue;
        $row['emergencyFone'] = $this->emergencyFone->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['memberStatusId'] = $this->memberStatusId->DefaultValue;
        $row['photo'] = $this->photo->DefaultValue;
        $row['beltSize'] = $this->beltSize->DefaultValue;
        $row['dobokSize'] = $this->dobokSize->DefaultValue;
        $row['programId'] = $this->programId->DefaultValue;
        $row['martialArtId'] = $this->martialArtId->DefaultValue;
        $row['modalityId'] = $this->modalityId->DefaultValue;
        $row['classId'] = $this->classId->DefaultValue;
        $row['federationRegister'] = $this->federationRegister->DefaultValue;
        $row['memberLevelId'] = $this->memberLevelId->DefaultValue;
        $row['instructorLevelId'] = $this->instructorLevelId->DefaultValue;
        $row['judgeLevelId'] = $this->judgeLevelId->DefaultValue;
        $row['federationRegisterDate'] = $this->federationRegisterDate->DefaultValue;
        $row['federationStatus'] = $this->federationStatus->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['lastUserId'] = $this->lastUserId->DefaultValue;
        $row['rankId'] = $this->rankId->DefaultValue;
        $row['marketingSourceId'] = $this->marketingSourceId->DefaultValue;
        $row['marketingSourceDetail'] = $this->marketingSourceDetail->DefaultValue;
        $row['memberTypeId'] = $this->memberTypeId->DefaultValue;
        $row['schoolUserId'] = $this->schoolUserId->DefaultValue;
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

        // name

        // lastName

        // instructorStatus

        // birthdate

        // gender

        // address

        // neighborhood

        // countryId

        // UFId

        // cityId

        // zip

        // celphone

        // email

        // facebook

        // instagram

        // father

        // fatherCellphone

        // receiveSmsFather

        // fatherEmail

        // receiveEmailFather

        // fatherOccupation

        // fatherBirthdate

        // mother

        // motherCellphone

        // receiveSmsMother

        // motherEmail

        // receiveEmailMother

        // motherOccupation

        // motherBirthdate

        // emergencyContact

        // emergencyFone

        // obs

        // schoolId

        // memberStatusId

        // photo

        // beltSize

        // dobokSize

        // programId

        // martialArtId

        // modalityId

        // classId

        // federationRegister

        // memberLevelId

        // instructorLevelId

        // judgeLevelId

        // federationRegisterDate

        // federationStatus

        // createDate

        // createUserId

        // lastUpdate

        // lastUserId

        // rankId

        // marketingSourceId

        // marketingSourceDetail

        // memberTypeId

        // schoolUserId

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

            // instructorStatus
            if (ConvertToBool($this->instructorStatus->CurrentValue)) {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(1) != "" ? $this->instructorStatus->tagCaption(1) : "Yes";
            } else {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(2) != "" ? $this->instructorStatus->tagCaption(2) : "No";
            }
            $this->instructorStatus->ViewCustomAttributes = "";

            // birthdate
            $this->birthdate->ViewValue = $this->birthdate->CurrentValue;
            $this->birthdate->ViewValue = FormatDateTime($this->birthdate->ViewValue, $this->birthdate->formatPattern());
            $this->birthdate->ViewCustomAttributes = "";

            // gender
            $this->gender->ViewValue = $this->gender->CurrentValue;
            $this->gender->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // countryId
            $this->countryId->ViewValue = $this->countryId->CurrentValue;
            $this->countryId->ViewValue = FormatNumber($this->countryId->ViewValue, $this->countryId->formatPattern());
            $this->countryId->ViewCustomAttributes = "";

            // UFId
            $this->UFId->ViewValue = $this->UFId->CurrentValue;
            $this->UFId->ViewValue = FormatNumber($this->UFId->ViewValue, $this->UFId->formatPattern());
            $this->UFId->ViewCustomAttributes = "";

            // cityId
            $this->cityId->ViewValue = $this->cityId->CurrentValue;
            $this->cityId->ViewValue = FormatNumber($this->cityId->ViewValue, $this->cityId->formatPattern());
            $this->cityId->ViewCustomAttributes = "";

            // zip
            $this->zip->ViewValue = $this->zip->CurrentValue;
            $this->zip->ViewCustomAttributes = "";

            // celphone
            $this->celphone->ViewValue = $this->celphone->CurrentValue;
            $this->celphone->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // facebook
            $this->facebook->ViewValue = $this->facebook->CurrentValue;
            $this->facebook->ViewCustomAttributes = "";

            // instagram
            $this->instagram->ViewValue = $this->instagram->CurrentValue;
            $this->instagram->ViewCustomAttributes = "";

            // father
            $this->father->ViewValue = $this->father->CurrentValue;
            $this->father->ViewCustomAttributes = "";

            // fatherCellphone
            $this->fatherCellphone->ViewValue = $this->fatherCellphone->CurrentValue;
            $this->fatherCellphone->ViewCustomAttributes = "";

            // receiveSmsFather
            $this->receiveSmsFather->ViewValue = $this->receiveSmsFather->CurrentValue;
            $this->receiveSmsFather->ViewValue = FormatNumber($this->receiveSmsFather->ViewValue, $this->receiveSmsFather->formatPattern());
            $this->receiveSmsFather->ViewCustomAttributes = "";

            // fatherEmail
            $this->fatherEmail->ViewValue = $this->fatherEmail->CurrentValue;
            $this->fatherEmail->ViewCustomAttributes = "";

            // receiveEmailFather
            $this->receiveEmailFather->ViewValue = $this->receiveEmailFather->CurrentValue;
            $this->receiveEmailFather->ViewValue = FormatNumber($this->receiveEmailFather->ViewValue, $this->receiveEmailFather->formatPattern());
            $this->receiveEmailFather->ViewCustomAttributes = "";

            // fatherOccupation
            $this->fatherOccupation->ViewValue = $this->fatherOccupation->CurrentValue;
            $this->fatherOccupation->ViewCustomAttributes = "";

            // fatherBirthdate
            $this->fatherBirthdate->ViewValue = $this->fatherBirthdate->CurrentValue;
            $this->fatherBirthdate->ViewValue = FormatDateTime($this->fatherBirthdate->ViewValue, $this->fatherBirthdate->formatPattern());
            $this->fatherBirthdate->ViewCustomAttributes = "";

            // mother
            $this->mother->ViewValue = $this->mother->CurrentValue;
            $this->mother->ViewCustomAttributes = "";

            // motherCellphone
            $this->motherCellphone->ViewValue = $this->motherCellphone->CurrentValue;
            $this->motherCellphone->ViewCustomAttributes = "";

            // receiveSmsMother
            $this->receiveSmsMother->ViewValue = $this->receiveSmsMother->CurrentValue;
            $this->receiveSmsMother->ViewValue = FormatNumber($this->receiveSmsMother->ViewValue, $this->receiveSmsMother->formatPattern());
            $this->receiveSmsMother->ViewCustomAttributes = "";

            // motherEmail
            $this->motherEmail->ViewValue = $this->motherEmail->CurrentValue;
            $this->motherEmail->ViewCustomAttributes = "";

            // receiveEmailMother
            $this->receiveEmailMother->ViewValue = $this->receiveEmailMother->CurrentValue;
            $this->receiveEmailMother->ViewValue = FormatNumber($this->receiveEmailMother->ViewValue, $this->receiveEmailMother->formatPattern());
            $this->receiveEmailMother->ViewCustomAttributes = "";

            // motherOccupation
            $this->motherOccupation->ViewValue = $this->motherOccupation->CurrentValue;
            $this->motherOccupation->ViewCustomAttributes = "";

            // motherBirthdate
            $this->motherBirthdate->ViewValue = $this->motherBirthdate->CurrentValue;
            $this->motherBirthdate->ViewValue = FormatDateTime($this->motherBirthdate->ViewValue, $this->motherBirthdate->formatPattern());
            $this->motherBirthdate->ViewCustomAttributes = "";

            // emergencyContact
            $this->emergencyContact->ViewValue = $this->emergencyContact->CurrentValue;
            $this->emergencyContact->ViewCustomAttributes = "";

            // emergencyFone
            $this->emergencyFone->ViewValue = $this->emergencyFone->CurrentValue;
            $this->emergencyFone->ViewCustomAttributes = "";

            // schoolId
            $this->schoolId->ViewValue = $this->schoolId->CurrentValue;
            $this->schoolId->ViewValue = FormatNumber($this->schoolId->ViewValue, $this->schoolId->formatPattern());
            $this->schoolId->ViewCustomAttributes = "";

            // memberStatusId
            $this->memberStatusId->ViewValue = $this->memberStatusId->CurrentValue;
            $this->memberStatusId->ViewValue = FormatNumber($this->memberStatusId->ViewValue, $this->memberStatusId->formatPattern());
            $this->memberStatusId->ViewCustomAttributes = "";

            // photo
            $this->photo->ViewValue = $this->photo->CurrentValue;
            $this->photo->ViewCustomAttributes = "";

            // beltSize
            $this->beltSize->ViewValue = $this->beltSize->CurrentValue;
            $this->beltSize->ViewCustomAttributes = "";

            // dobokSize
            $this->dobokSize->ViewValue = $this->dobokSize->CurrentValue;
            $this->dobokSize->ViewCustomAttributes = "";

            // programId
            $this->programId->ViewValue = $this->programId->CurrentValue;
            $this->programId->ViewValue = FormatNumber($this->programId->ViewValue, $this->programId->formatPattern());
            $this->programId->ViewCustomAttributes = "";

            // martialArtId
            $this->martialArtId->ViewValue = $this->martialArtId->CurrentValue;
            $this->martialArtId->ViewValue = FormatNumber($this->martialArtId->ViewValue, $this->martialArtId->formatPattern());
            $this->martialArtId->ViewCustomAttributes = "";

            // modalityId
            $this->modalityId->ViewValue = $this->modalityId->CurrentValue;
            $this->modalityId->ViewValue = FormatNumber($this->modalityId->ViewValue, $this->modalityId->formatPattern());
            $this->modalityId->ViewCustomAttributes = "";

            // classId
            $this->classId->ViewValue = $this->classId->CurrentValue;
            $this->classId->ViewValue = FormatNumber($this->classId->ViewValue, $this->classId->formatPattern());
            $this->classId->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // memberLevelId
            $this->memberLevelId->ViewValue = $this->memberLevelId->CurrentValue;
            $this->memberLevelId->ViewValue = FormatNumber($this->memberLevelId->ViewValue, $this->memberLevelId->formatPattern());
            $this->memberLevelId->ViewCustomAttributes = "";

            // instructorLevelId
            $this->instructorLevelId->ViewValue = $this->instructorLevelId->CurrentValue;
            $this->instructorLevelId->ViewValue = FormatNumber($this->instructorLevelId->ViewValue, $this->instructorLevelId->formatPattern());
            $this->instructorLevelId->ViewCustomAttributes = "";

            // judgeLevelId
            $this->judgeLevelId->ViewValue = $this->judgeLevelId->CurrentValue;
            $this->judgeLevelId->ViewValue = FormatNumber($this->judgeLevelId->ViewValue, $this->judgeLevelId->formatPattern());
            $this->judgeLevelId->ViewCustomAttributes = "";

            // federationRegisterDate
            $this->federationRegisterDate->ViewValue = $this->federationRegisterDate->CurrentValue;
            $this->federationRegisterDate->ViewValue = FormatDateTime($this->federationRegisterDate->ViewValue, $this->federationRegisterDate->formatPattern());
            $this->federationRegisterDate->ViewCustomAttributes = "";

            // federationStatus
            if (ConvertToBool($this->federationStatus->CurrentValue)) {
                $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(1) != "" ? $this->federationStatus->tagCaption(1) : "Yes";
            } else {
                $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(2) != "" ? $this->federationStatus->tagCaption(2) : "No";
            }
            $this->federationStatus->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // lastUserId
            $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
            $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->ViewValue, $this->lastUserId->formatPattern());
            $this->lastUserId->ViewCustomAttributes = "";

            // rankId
            $this->rankId->ViewValue = $this->rankId->CurrentValue;
            $this->rankId->ViewValue = FormatNumber($this->rankId->ViewValue, $this->rankId->formatPattern());
            $this->rankId->ViewCustomAttributes = "";

            // marketingSourceId
            $this->marketingSourceId->ViewValue = $this->marketingSourceId->CurrentValue;
            $this->marketingSourceId->ViewValue = FormatNumber($this->marketingSourceId->ViewValue, $this->marketingSourceId->formatPattern());
            $this->marketingSourceId->ViewCustomAttributes = "";

            // marketingSourceDetail
            $this->marketingSourceDetail->ViewValue = $this->marketingSourceDetail->CurrentValue;
            $this->marketingSourceDetail->ViewCustomAttributes = "";

            // memberTypeId
            $this->memberTypeId->ViewValue = $this->memberTypeId->CurrentValue;
            $this->memberTypeId->ViewValue = FormatNumber($this->memberTypeId->ViewValue, $this->memberTypeId->formatPattern());
            $this->memberTypeId->ViewCustomAttributes = "";

            // schoolUserId
            $this->schoolUserId->ViewValue = $this->schoolUserId->CurrentValue;
            $this->schoolUserId->ViewValue = FormatNumber($this->schoolUserId->ViewValue, $this->schoolUserId->formatPattern());
            $this->schoolUserId->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";
            $this->lastName->TooltipValue = "";

            // instructorStatus
            $this->instructorStatus->LinkCustomAttributes = "";
            $this->instructorStatus->HrefValue = "";
            $this->instructorStatus->TooltipValue = "";

            // birthdate
            $this->birthdate->LinkCustomAttributes = "";
            $this->birthdate->HrefValue = "";
            $this->birthdate->TooltipValue = "";

            // gender
            $this->gender->LinkCustomAttributes = "";
            $this->gender->HrefValue = "";
            $this->gender->TooltipValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";
            $this->address->TooltipValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";
            $this->neighborhood->TooltipValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";
            $this->countryId->TooltipValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";
            $this->UFId->TooltipValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";
            $this->cityId->TooltipValue = "";

            // zip
            $this->zip->LinkCustomAttributes = "";
            $this->zip->HrefValue = "";
            $this->zip->TooltipValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";
            $this->celphone->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // facebook
            $this->facebook->LinkCustomAttributes = "";
            $this->facebook->HrefValue = "";
            $this->facebook->TooltipValue = "";

            // instagram
            $this->instagram->LinkCustomAttributes = "";
            $this->instagram->HrefValue = "";
            $this->instagram->TooltipValue = "";

            // father
            $this->father->LinkCustomAttributes = "";
            $this->father->HrefValue = "";
            $this->father->TooltipValue = "";

            // fatherCellphone
            $this->fatherCellphone->LinkCustomAttributes = "";
            $this->fatherCellphone->HrefValue = "";
            $this->fatherCellphone->TooltipValue = "";

            // receiveSmsFather
            $this->receiveSmsFather->LinkCustomAttributes = "";
            $this->receiveSmsFather->HrefValue = "";
            $this->receiveSmsFather->TooltipValue = "";

            // fatherEmail
            $this->fatherEmail->LinkCustomAttributes = "";
            $this->fatherEmail->HrefValue = "";
            $this->fatherEmail->TooltipValue = "";

            // receiveEmailFather
            $this->receiveEmailFather->LinkCustomAttributes = "";
            $this->receiveEmailFather->HrefValue = "";
            $this->receiveEmailFather->TooltipValue = "";

            // fatherOccupation
            $this->fatherOccupation->LinkCustomAttributes = "";
            $this->fatherOccupation->HrefValue = "";
            $this->fatherOccupation->TooltipValue = "";

            // fatherBirthdate
            $this->fatherBirthdate->LinkCustomAttributes = "";
            $this->fatherBirthdate->HrefValue = "";
            $this->fatherBirthdate->TooltipValue = "";

            // mother
            $this->mother->LinkCustomAttributes = "";
            $this->mother->HrefValue = "";
            $this->mother->TooltipValue = "";

            // motherCellphone
            $this->motherCellphone->LinkCustomAttributes = "";
            $this->motherCellphone->HrefValue = "";
            $this->motherCellphone->TooltipValue = "";

            // receiveSmsMother
            $this->receiveSmsMother->LinkCustomAttributes = "";
            $this->receiveSmsMother->HrefValue = "";
            $this->receiveSmsMother->TooltipValue = "";

            // motherEmail
            $this->motherEmail->LinkCustomAttributes = "";
            $this->motherEmail->HrefValue = "";
            $this->motherEmail->TooltipValue = "";

            // receiveEmailMother
            $this->receiveEmailMother->LinkCustomAttributes = "";
            $this->receiveEmailMother->HrefValue = "";
            $this->receiveEmailMother->TooltipValue = "";

            // motherOccupation
            $this->motherOccupation->LinkCustomAttributes = "";
            $this->motherOccupation->HrefValue = "";
            $this->motherOccupation->TooltipValue = "";

            // motherBirthdate
            $this->motherBirthdate->LinkCustomAttributes = "";
            $this->motherBirthdate->HrefValue = "";
            $this->motherBirthdate->TooltipValue = "";

            // emergencyContact
            $this->emergencyContact->LinkCustomAttributes = "";
            $this->emergencyContact->HrefValue = "";
            $this->emergencyContact->TooltipValue = "";

            // emergencyFone
            $this->emergencyFone->LinkCustomAttributes = "";
            $this->emergencyFone->HrefValue = "";
            $this->emergencyFone->TooltipValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";
            $this->schoolId->TooltipValue = "";

            // memberStatusId
            $this->memberStatusId->LinkCustomAttributes = "";
            $this->memberStatusId->HrefValue = "";
            $this->memberStatusId->TooltipValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->HrefValue = "";
            $this->photo->TooltipValue = "";

            // beltSize
            $this->beltSize->LinkCustomAttributes = "";
            $this->beltSize->HrefValue = "";
            $this->beltSize->TooltipValue = "";

            // dobokSize
            $this->dobokSize->LinkCustomAttributes = "";
            $this->dobokSize->HrefValue = "";
            $this->dobokSize->TooltipValue = "";

            // programId
            $this->programId->LinkCustomAttributes = "";
            $this->programId->HrefValue = "";
            $this->programId->TooltipValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";
            $this->martialArtId->TooltipValue = "";

            // modalityId
            $this->modalityId->LinkCustomAttributes = "";
            $this->modalityId->HrefValue = "";
            $this->modalityId->TooltipValue = "";

            // classId
            $this->classId->LinkCustomAttributes = "";
            $this->classId->HrefValue = "";
            $this->classId->TooltipValue = "";

            // federationRegister
            $this->federationRegister->LinkCustomAttributes = "";
            $this->federationRegister->HrefValue = "";
            $this->federationRegister->TooltipValue = "";

            // memberLevelId
            $this->memberLevelId->LinkCustomAttributes = "";
            $this->memberLevelId->HrefValue = "";
            $this->memberLevelId->TooltipValue = "";

            // instructorLevelId
            $this->instructorLevelId->LinkCustomAttributes = "";
            $this->instructorLevelId->HrefValue = "";
            $this->instructorLevelId->TooltipValue = "";

            // judgeLevelId
            $this->judgeLevelId->LinkCustomAttributes = "";
            $this->judgeLevelId->HrefValue = "";
            $this->judgeLevelId->TooltipValue = "";

            // federationRegisterDate
            $this->federationRegisterDate->LinkCustomAttributes = "";
            $this->federationRegisterDate->HrefValue = "";
            $this->federationRegisterDate->TooltipValue = "";

            // federationStatus
            $this->federationStatus->LinkCustomAttributes = "";
            $this->federationStatus->HrefValue = "";
            $this->federationStatus->TooltipValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";
            $this->createDate->TooltipValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";
            $this->createUserId->TooltipValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";
            $this->lastUpdate->TooltipValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";
            $this->lastUserId->TooltipValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";
            $this->rankId->TooltipValue = "";

            // marketingSourceId
            $this->marketingSourceId->LinkCustomAttributes = "";
            $this->marketingSourceId->HrefValue = "";
            $this->marketingSourceId->TooltipValue = "";

            // marketingSourceDetail
            $this->marketingSourceDetail->LinkCustomAttributes = "";
            $this->marketingSourceDetail->HrefValue = "";
            $this->marketingSourceDetail->TooltipValue = "";

            // memberTypeId
            $this->memberTypeId->LinkCustomAttributes = "";
            $this->memberTypeId->HrefValue = "";
            $this->memberTypeId->TooltipValue = "";

            // schoolUserId
            $this->schoolUserId->LinkCustomAttributes = "";
            $this->schoolUserId->HrefValue = "";
            $this->schoolUserId->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl(false);
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fview_alljudgememberslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fview_alljudgememberslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fview_alljudgememberslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fview_alljudgememberslist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_alljudgememberssrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_instructorStatus":
                    break;
                case "x_federationStatus":
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
