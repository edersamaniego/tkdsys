<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedSchoolList extends FedSchool
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_school';

    // Page object name
    public $PageObjName = "FedSchoolList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ffed_schoollist";
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

        // Table object (fed_school)
        if (!isset($GLOBALS["fed_school"]) || get_class($GLOBALS["fed_school"]) == PROJECT_NAMESPACE . "fed_school") {
            $GLOBALS["fed_school"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "FedSchoolAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "FedSchoolDelete";
        $this->MultiUpdateUrl = "FedSchoolUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fed_school');
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
                $tbl = Container("fed_school");
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
        $this->federationId->Visible = false;
        $this->masterSchoolId->setVisibility();
        $this->school->setVisibility();
        $this->countryId->setVisibility();
        $this->UFId->Visible = false;
        $this->cityId->setVisibility();
        $this->neighborhood->Visible = false;
        $this->address->Visible = false;
        $this->zipcode->Visible = false;
        $this->website->Visible = false;
        $this->_email->Visible = false;
        $this->phone->Visible = false;
        $this->celphone->Visible = false;
        $this->logo->Visible = false;
        $this->openingDate->Visible = false;
        $this->federationRegister->Visible = false;
        $this->createUserId->Visible = false;
        $this->createDate->Visible = false;
        $this->typeId->Visible = false;
        $this->owner->setVisibility();
        $this->identityNumber->Visible = false;
        $this->birthDateOwner->Visible = false;
        $this->ownerCountryId->Visible = false;
        $this->ownerStateId->Visible = false;
        $this->ownCityId->Visible = false;
        $this->ownerTelephone->Visible = false;
        $this->ownerTelephoneWork->Visible = false;
        $this->ownerProfession->Visible = false;
        $this->employer->Visible = false;
        $this->ownerGraduation->Visible = false;
        $this->ownerGraduationLocation->Visible = false;
        $this->ownerGraduationObs->Visible = false;
        $this->ownerMaritalStatus->Visible = false;
        $this->ownerSpouseName->Visible = false;
        $this->ownerSpouseProfession->Visible = false;
        $this->propertySituation->Visible = false;
        $this->numberOfStudentsInBeginnig->Visible = false;
        $this->ownerAbout->Visible = false;
        $this->pdfLicense->Visible = false;
        $this->applicationId->setVisibility();
        $this->isheadquarter->setVisibility();
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
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->masterSchoolId);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->isheadquarter);

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

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "fed_applicationschool") {
            $masterTbl = Container("fed_applicationschool");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("FedApplicationschoolList"); // Return to master page
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
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "ffed_schoolsrch");
        }
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->federationId->AdvancedSearch->toJson(), ","); // Field federationId
        $filterList = Concat($filterList, $this->masterSchoolId->AdvancedSearch->toJson(), ","); // Field masterSchoolId
        $filterList = Concat($filterList, $this->school->AdvancedSearch->toJson(), ","); // Field school
        $filterList = Concat($filterList, $this->countryId->AdvancedSearch->toJson(), ","); // Field countryId
        $filterList = Concat($filterList, $this->UFId->AdvancedSearch->toJson(), ","); // Field UFId
        $filterList = Concat($filterList, $this->cityId->AdvancedSearch->toJson(), ","); // Field cityId
        $filterList = Concat($filterList, $this->neighborhood->AdvancedSearch->toJson(), ","); // Field neighborhood
        $filterList = Concat($filterList, $this->address->AdvancedSearch->toJson(), ","); // Field address
        $filterList = Concat($filterList, $this->zipcode->AdvancedSearch->toJson(), ","); // Field zipcode
        $filterList = Concat($filterList, $this->website->AdvancedSearch->toJson(), ","); // Field website
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->phone->AdvancedSearch->toJson(), ","); // Field phone
        $filterList = Concat($filterList, $this->celphone->AdvancedSearch->toJson(), ","); // Field celphone
        $filterList = Concat($filterList, $this->logo->AdvancedSearch->toJson(), ","); // Field logo
        $filterList = Concat($filterList, $this->openingDate->AdvancedSearch->toJson(), ","); // Field openingDate
        $filterList = Concat($filterList, $this->federationRegister->AdvancedSearch->toJson(), ","); // Field federationRegister
        $filterList = Concat($filterList, $this->createUserId->AdvancedSearch->toJson(), ","); // Field createUserId
        $filterList = Concat($filterList, $this->createDate->AdvancedSearch->toJson(), ","); // Field createDate
        $filterList = Concat($filterList, $this->typeId->AdvancedSearch->toJson(), ","); // Field typeId
        $filterList = Concat($filterList, $this->owner->AdvancedSearch->toJson(), ","); // Field owner
        $filterList = Concat($filterList, $this->identityNumber->AdvancedSearch->toJson(), ","); // Field identityNumber
        $filterList = Concat($filterList, $this->birthDateOwner->AdvancedSearch->toJson(), ","); // Field birthDateOwner
        $filterList = Concat($filterList, $this->ownerCountryId->AdvancedSearch->toJson(), ","); // Field ownerCountryId
        $filterList = Concat($filterList, $this->ownerStateId->AdvancedSearch->toJson(), ","); // Field ownerStateId
        $filterList = Concat($filterList, $this->ownCityId->AdvancedSearch->toJson(), ","); // Field ownCityId
        $filterList = Concat($filterList, $this->ownerTelephone->AdvancedSearch->toJson(), ","); // Field ownerTelephone
        $filterList = Concat($filterList, $this->ownerTelephoneWork->AdvancedSearch->toJson(), ","); // Field ownerTelephoneWork
        $filterList = Concat($filterList, $this->ownerProfession->AdvancedSearch->toJson(), ","); // Field ownerProfession
        $filterList = Concat($filterList, $this->employer->AdvancedSearch->toJson(), ","); // Field employer
        $filterList = Concat($filterList, $this->ownerGraduation->AdvancedSearch->toJson(), ","); // Field ownerGraduation
        $filterList = Concat($filterList, $this->ownerGraduationLocation->AdvancedSearch->toJson(), ","); // Field ownerGraduationLocation
        $filterList = Concat($filterList, $this->ownerGraduationObs->AdvancedSearch->toJson(), ","); // Field ownerGraduationObs
        $filterList = Concat($filterList, $this->ownerMaritalStatus->AdvancedSearch->toJson(), ","); // Field ownerMaritalStatus
        $filterList = Concat($filterList, $this->ownerSpouseName->AdvancedSearch->toJson(), ","); // Field ownerSpouseName
        $filterList = Concat($filterList, $this->ownerSpouseProfession->AdvancedSearch->toJson(), ","); // Field ownerSpouseProfession
        $filterList = Concat($filterList, $this->propertySituation->AdvancedSearch->toJson(), ","); // Field propertySituation
        $filterList = Concat($filterList, $this->numberOfStudentsInBeginnig->AdvancedSearch->toJson(), ","); // Field numberOfStudentsInBeginnig
        $filterList = Concat($filterList, $this->ownerAbout->AdvancedSearch->toJson(), ","); // Field ownerAbout
        $filterList = Concat($filterList, $this->pdfLicense->AdvancedSearch->toJson(), ","); // Field pdfLicense
        $filterList = Concat($filterList, $this->applicationId->AdvancedSearch->toJson(), ","); // Field applicationId
        $filterList = Concat($filterList, $this->isheadquarter->AdvancedSearch->toJson(), ","); // Field isheadquarter
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
            $UserProfile->setSearchFilters(CurrentUserName(), "ffed_schoolsrch", $filters);
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

        // Field federationId
        $this->federationId->AdvancedSearch->SearchValue = @$filter["x_federationId"];
        $this->federationId->AdvancedSearch->SearchOperator = @$filter["z_federationId"];
        $this->federationId->AdvancedSearch->SearchCondition = @$filter["v_federationId"];
        $this->federationId->AdvancedSearch->SearchValue2 = @$filter["y_federationId"];
        $this->federationId->AdvancedSearch->SearchOperator2 = @$filter["w_federationId"];
        $this->federationId->AdvancedSearch->save();

        // Field masterSchoolId
        $this->masterSchoolId->AdvancedSearch->SearchValue = @$filter["x_masterSchoolId"];
        $this->masterSchoolId->AdvancedSearch->SearchOperator = @$filter["z_masterSchoolId"];
        $this->masterSchoolId->AdvancedSearch->SearchCondition = @$filter["v_masterSchoolId"];
        $this->masterSchoolId->AdvancedSearch->SearchValue2 = @$filter["y_masterSchoolId"];
        $this->masterSchoolId->AdvancedSearch->SearchOperator2 = @$filter["w_masterSchoolId"];
        $this->masterSchoolId->AdvancedSearch->save();

        // Field school
        $this->school->AdvancedSearch->SearchValue = @$filter["x_school"];
        $this->school->AdvancedSearch->SearchOperator = @$filter["z_school"];
        $this->school->AdvancedSearch->SearchCondition = @$filter["v_school"];
        $this->school->AdvancedSearch->SearchValue2 = @$filter["y_school"];
        $this->school->AdvancedSearch->SearchOperator2 = @$filter["w_school"];
        $this->school->AdvancedSearch->save();

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

        // Field neighborhood
        $this->neighborhood->AdvancedSearch->SearchValue = @$filter["x_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchOperator = @$filter["z_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchCondition = @$filter["v_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchValue2 = @$filter["y_neighborhood"];
        $this->neighborhood->AdvancedSearch->SearchOperator2 = @$filter["w_neighborhood"];
        $this->neighborhood->AdvancedSearch->save();

        // Field address
        $this->address->AdvancedSearch->SearchValue = @$filter["x_address"];
        $this->address->AdvancedSearch->SearchOperator = @$filter["z_address"];
        $this->address->AdvancedSearch->SearchCondition = @$filter["v_address"];
        $this->address->AdvancedSearch->SearchValue2 = @$filter["y_address"];
        $this->address->AdvancedSearch->SearchOperator2 = @$filter["w_address"];
        $this->address->AdvancedSearch->save();

        // Field zipcode
        $this->zipcode->AdvancedSearch->SearchValue = @$filter["x_zipcode"];
        $this->zipcode->AdvancedSearch->SearchOperator = @$filter["z_zipcode"];
        $this->zipcode->AdvancedSearch->SearchCondition = @$filter["v_zipcode"];
        $this->zipcode->AdvancedSearch->SearchValue2 = @$filter["y_zipcode"];
        $this->zipcode->AdvancedSearch->SearchOperator2 = @$filter["w_zipcode"];
        $this->zipcode->AdvancedSearch->save();

        // Field website
        $this->website->AdvancedSearch->SearchValue = @$filter["x_website"];
        $this->website->AdvancedSearch->SearchOperator = @$filter["z_website"];
        $this->website->AdvancedSearch->SearchCondition = @$filter["v_website"];
        $this->website->AdvancedSearch->SearchValue2 = @$filter["y_website"];
        $this->website->AdvancedSearch->SearchOperator2 = @$filter["w_website"];
        $this->website->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field phone
        $this->phone->AdvancedSearch->SearchValue = @$filter["x_phone"];
        $this->phone->AdvancedSearch->SearchOperator = @$filter["z_phone"];
        $this->phone->AdvancedSearch->SearchCondition = @$filter["v_phone"];
        $this->phone->AdvancedSearch->SearchValue2 = @$filter["y_phone"];
        $this->phone->AdvancedSearch->SearchOperator2 = @$filter["w_phone"];
        $this->phone->AdvancedSearch->save();

        // Field celphone
        $this->celphone->AdvancedSearch->SearchValue = @$filter["x_celphone"];
        $this->celphone->AdvancedSearch->SearchOperator = @$filter["z_celphone"];
        $this->celphone->AdvancedSearch->SearchCondition = @$filter["v_celphone"];
        $this->celphone->AdvancedSearch->SearchValue2 = @$filter["y_celphone"];
        $this->celphone->AdvancedSearch->SearchOperator2 = @$filter["w_celphone"];
        $this->celphone->AdvancedSearch->save();

        // Field logo
        $this->logo->AdvancedSearch->SearchValue = @$filter["x_logo"];
        $this->logo->AdvancedSearch->SearchOperator = @$filter["z_logo"];
        $this->logo->AdvancedSearch->SearchCondition = @$filter["v_logo"];
        $this->logo->AdvancedSearch->SearchValue2 = @$filter["y_logo"];
        $this->logo->AdvancedSearch->SearchOperator2 = @$filter["w_logo"];
        $this->logo->AdvancedSearch->save();

        // Field openingDate
        $this->openingDate->AdvancedSearch->SearchValue = @$filter["x_openingDate"];
        $this->openingDate->AdvancedSearch->SearchOperator = @$filter["z_openingDate"];
        $this->openingDate->AdvancedSearch->SearchCondition = @$filter["v_openingDate"];
        $this->openingDate->AdvancedSearch->SearchValue2 = @$filter["y_openingDate"];
        $this->openingDate->AdvancedSearch->SearchOperator2 = @$filter["w_openingDate"];
        $this->openingDate->AdvancedSearch->save();

        // Field federationRegister
        $this->federationRegister->AdvancedSearch->SearchValue = @$filter["x_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchOperator = @$filter["z_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchCondition = @$filter["v_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchValue2 = @$filter["y_federationRegister"];
        $this->federationRegister->AdvancedSearch->SearchOperator2 = @$filter["w_federationRegister"];
        $this->federationRegister->AdvancedSearch->save();

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

        // Field typeId
        $this->typeId->AdvancedSearch->SearchValue = @$filter["x_typeId"];
        $this->typeId->AdvancedSearch->SearchOperator = @$filter["z_typeId"];
        $this->typeId->AdvancedSearch->SearchCondition = @$filter["v_typeId"];
        $this->typeId->AdvancedSearch->SearchValue2 = @$filter["y_typeId"];
        $this->typeId->AdvancedSearch->SearchOperator2 = @$filter["w_typeId"];
        $this->typeId->AdvancedSearch->save();

        // Field owner
        $this->owner->AdvancedSearch->SearchValue = @$filter["x_owner"];
        $this->owner->AdvancedSearch->SearchOperator = @$filter["z_owner"];
        $this->owner->AdvancedSearch->SearchCondition = @$filter["v_owner"];
        $this->owner->AdvancedSearch->SearchValue2 = @$filter["y_owner"];
        $this->owner->AdvancedSearch->SearchOperator2 = @$filter["w_owner"];
        $this->owner->AdvancedSearch->save();

        // Field identityNumber
        $this->identityNumber->AdvancedSearch->SearchValue = @$filter["x_identityNumber"];
        $this->identityNumber->AdvancedSearch->SearchOperator = @$filter["z_identityNumber"];
        $this->identityNumber->AdvancedSearch->SearchCondition = @$filter["v_identityNumber"];
        $this->identityNumber->AdvancedSearch->SearchValue2 = @$filter["y_identityNumber"];
        $this->identityNumber->AdvancedSearch->SearchOperator2 = @$filter["w_identityNumber"];
        $this->identityNumber->AdvancedSearch->save();

        // Field birthDateOwner
        $this->birthDateOwner->AdvancedSearch->SearchValue = @$filter["x_birthDateOwner"];
        $this->birthDateOwner->AdvancedSearch->SearchOperator = @$filter["z_birthDateOwner"];
        $this->birthDateOwner->AdvancedSearch->SearchCondition = @$filter["v_birthDateOwner"];
        $this->birthDateOwner->AdvancedSearch->SearchValue2 = @$filter["y_birthDateOwner"];
        $this->birthDateOwner->AdvancedSearch->SearchOperator2 = @$filter["w_birthDateOwner"];
        $this->birthDateOwner->AdvancedSearch->save();

        // Field ownerCountryId
        $this->ownerCountryId->AdvancedSearch->SearchValue = @$filter["x_ownerCountryId"];
        $this->ownerCountryId->AdvancedSearch->SearchOperator = @$filter["z_ownerCountryId"];
        $this->ownerCountryId->AdvancedSearch->SearchCondition = @$filter["v_ownerCountryId"];
        $this->ownerCountryId->AdvancedSearch->SearchValue2 = @$filter["y_ownerCountryId"];
        $this->ownerCountryId->AdvancedSearch->SearchOperator2 = @$filter["w_ownerCountryId"];
        $this->ownerCountryId->AdvancedSearch->save();

        // Field ownerStateId
        $this->ownerStateId->AdvancedSearch->SearchValue = @$filter["x_ownerStateId"];
        $this->ownerStateId->AdvancedSearch->SearchOperator = @$filter["z_ownerStateId"];
        $this->ownerStateId->AdvancedSearch->SearchCondition = @$filter["v_ownerStateId"];
        $this->ownerStateId->AdvancedSearch->SearchValue2 = @$filter["y_ownerStateId"];
        $this->ownerStateId->AdvancedSearch->SearchOperator2 = @$filter["w_ownerStateId"];
        $this->ownerStateId->AdvancedSearch->save();

        // Field ownCityId
        $this->ownCityId->AdvancedSearch->SearchValue = @$filter["x_ownCityId"];
        $this->ownCityId->AdvancedSearch->SearchOperator = @$filter["z_ownCityId"];
        $this->ownCityId->AdvancedSearch->SearchCondition = @$filter["v_ownCityId"];
        $this->ownCityId->AdvancedSearch->SearchValue2 = @$filter["y_ownCityId"];
        $this->ownCityId->AdvancedSearch->SearchOperator2 = @$filter["w_ownCityId"];
        $this->ownCityId->AdvancedSearch->save();

        // Field ownerTelephone
        $this->ownerTelephone->AdvancedSearch->SearchValue = @$filter["x_ownerTelephone"];
        $this->ownerTelephone->AdvancedSearch->SearchOperator = @$filter["z_ownerTelephone"];
        $this->ownerTelephone->AdvancedSearch->SearchCondition = @$filter["v_ownerTelephone"];
        $this->ownerTelephone->AdvancedSearch->SearchValue2 = @$filter["y_ownerTelephone"];
        $this->ownerTelephone->AdvancedSearch->SearchOperator2 = @$filter["w_ownerTelephone"];
        $this->ownerTelephone->AdvancedSearch->save();

        // Field ownerTelephoneWork
        $this->ownerTelephoneWork->AdvancedSearch->SearchValue = @$filter["x_ownerTelephoneWork"];
        $this->ownerTelephoneWork->AdvancedSearch->SearchOperator = @$filter["z_ownerTelephoneWork"];
        $this->ownerTelephoneWork->AdvancedSearch->SearchCondition = @$filter["v_ownerTelephoneWork"];
        $this->ownerTelephoneWork->AdvancedSearch->SearchValue2 = @$filter["y_ownerTelephoneWork"];
        $this->ownerTelephoneWork->AdvancedSearch->SearchOperator2 = @$filter["w_ownerTelephoneWork"];
        $this->ownerTelephoneWork->AdvancedSearch->save();

        // Field ownerProfession
        $this->ownerProfession->AdvancedSearch->SearchValue = @$filter["x_ownerProfession"];
        $this->ownerProfession->AdvancedSearch->SearchOperator = @$filter["z_ownerProfession"];
        $this->ownerProfession->AdvancedSearch->SearchCondition = @$filter["v_ownerProfession"];
        $this->ownerProfession->AdvancedSearch->SearchValue2 = @$filter["y_ownerProfession"];
        $this->ownerProfession->AdvancedSearch->SearchOperator2 = @$filter["w_ownerProfession"];
        $this->ownerProfession->AdvancedSearch->save();

        // Field employer
        $this->employer->AdvancedSearch->SearchValue = @$filter["x_employer"];
        $this->employer->AdvancedSearch->SearchOperator = @$filter["z_employer"];
        $this->employer->AdvancedSearch->SearchCondition = @$filter["v_employer"];
        $this->employer->AdvancedSearch->SearchValue2 = @$filter["y_employer"];
        $this->employer->AdvancedSearch->SearchOperator2 = @$filter["w_employer"];
        $this->employer->AdvancedSearch->save();

        // Field ownerGraduation
        $this->ownerGraduation->AdvancedSearch->SearchValue = @$filter["x_ownerGraduation"];
        $this->ownerGraduation->AdvancedSearch->SearchOperator = @$filter["z_ownerGraduation"];
        $this->ownerGraduation->AdvancedSearch->SearchCondition = @$filter["v_ownerGraduation"];
        $this->ownerGraduation->AdvancedSearch->SearchValue2 = @$filter["y_ownerGraduation"];
        $this->ownerGraduation->AdvancedSearch->SearchOperator2 = @$filter["w_ownerGraduation"];
        $this->ownerGraduation->AdvancedSearch->save();

        // Field ownerGraduationLocation
        $this->ownerGraduationLocation->AdvancedSearch->SearchValue = @$filter["x_ownerGraduationLocation"];
        $this->ownerGraduationLocation->AdvancedSearch->SearchOperator = @$filter["z_ownerGraduationLocation"];
        $this->ownerGraduationLocation->AdvancedSearch->SearchCondition = @$filter["v_ownerGraduationLocation"];
        $this->ownerGraduationLocation->AdvancedSearch->SearchValue2 = @$filter["y_ownerGraduationLocation"];
        $this->ownerGraduationLocation->AdvancedSearch->SearchOperator2 = @$filter["w_ownerGraduationLocation"];
        $this->ownerGraduationLocation->AdvancedSearch->save();

        // Field ownerGraduationObs
        $this->ownerGraduationObs->AdvancedSearch->SearchValue = @$filter["x_ownerGraduationObs"];
        $this->ownerGraduationObs->AdvancedSearch->SearchOperator = @$filter["z_ownerGraduationObs"];
        $this->ownerGraduationObs->AdvancedSearch->SearchCondition = @$filter["v_ownerGraduationObs"];
        $this->ownerGraduationObs->AdvancedSearch->SearchValue2 = @$filter["y_ownerGraduationObs"];
        $this->ownerGraduationObs->AdvancedSearch->SearchOperator2 = @$filter["w_ownerGraduationObs"];
        $this->ownerGraduationObs->AdvancedSearch->save();

        // Field ownerMaritalStatus
        $this->ownerMaritalStatus->AdvancedSearch->SearchValue = @$filter["x_ownerMaritalStatus"];
        $this->ownerMaritalStatus->AdvancedSearch->SearchOperator = @$filter["z_ownerMaritalStatus"];
        $this->ownerMaritalStatus->AdvancedSearch->SearchCondition = @$filter["v_ownerMaritalStatus"];
        $this->ownerMaritalStatus->AdvancedSearch->SearchValue2 = @$filter["y_ownerMaritalStatus"];
        $this->ownerMaritalStatus->AdvancedSearch->SearchOperator2 = @$filter["w_ownerMaritalStatus"];
        $this->ownerMaritalStatus->AdvancedSearch->save();

        // Field ownerSpouseName
        $this->ownerSpouseName->AdvancedSearch->SearchValue = @$filter["x_ownerSpouseName"];
        $this->ownerSpouseName->AdvancedSearch->SearchOperator = @$filter["z_ownerSpouseName"];
        $this->ownerSpouseName->AdvancedSearch->SearchCondition = @$filter["v_ownerSpouseName"];
        $this->ownerSpouseName->AdvancedSearch->SearchValue2 = @$filter["y_ownerSpouseName"];
        $this->ownerSpouseName->AdvancedSearch->SearchOperator2 = @$filter["w_ownerSpouseName"];
        $this->ownerSpouseName->AdvancedSearch->save();

        // Field ownerSpouseProfession
        $this->ownerSpouseProfession->AdvancedSearch->SearchValue = @$filter["x_ownerSpouseProfession"];
        $this->ownerSpouseProfession->AdvancedSearch->SearchOperator = @$filter["z_ownerSpouseProfession"];
        $this->ownerSpouseProfession->AdvancedSearch->SearchCondition = @$filter["v_ownerSpouseProfession"];
        $this->ownerSpouseProfession->AdvancedSearch->SearchValue2 = @$filter["y_ownerSpouseProfession"];
        $this->ownerSpouseProfession->AdvancedSearch->SearchOperator2 = @$filter["w_ownerSpouseProfession"];
        $this->ownerSpouseProfession->AdvancedSearch->save();

        // Field propertySituation
        $this->propertySituation->AdvancedSearch->SearchValue = @$filter["x_propertySituation"];
        $this->propertySituation->AdvancedSearch->SearchOperator = @$filter["z_propertySituation"];
        $this->propertySituation->AdvancedSearch->SearchCondition = @$filter["v_propertySituation"];
        $this->propertySituation->AdvancedSearch->SearchValue2 = @$filter["y_propertySituation"];
        $this->propertySituation->AdvancedSearch->SearchOperator2 = @$filter["w_propertySituation"];
        $this->propertySituation->AdvancedSearch->save();

        // Field numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchValue = @$filter["x_numberOfStudentsInBeginnig"];
        $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchOperator = @$filter["z_numberOfStudentsInBeginnig"];
        $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchCondition = @$filter["v_numberOfStudentsInBeginnig"];
        $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchValue2 = @$filter["y_numberOfStudentsInBeginnig"];
        $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchOperator2 = @$filter["w_numberOfStudentsInBeginnig"];
        $this->numberOfStudentsInBeginnig->AdvancedSearch->save();

        // Field ownerAbout
        $this->ownerAbout->AdvancedSearch->SearchValue = @$filter["x_ownerAbout"];
        $this->ownerAbout->AdvancedSearch->SearchOperator = @$filter["z_ownerAbout"];
        $this->ownerAbout->AdvancedSearch->SearchCondition = @$filter["v_ownerAbout"];
        $this->ownerAbout->AdvancedSearch->SearchValue2 = @$filter["y_ownerAbout"];
        $this->ownerAbout->AdvancedSearch->SearchOperator2 = @$filter["w_ownerAbout"];
        $this->ownerAbout->AdvancedSearch->save();

        // Field pdfLicense
        $this->pdfLicense->AdvancedSearch->SearchValue = @$filter["x_pdfLicense"];
        $this->pdfLicense->AdvancedSearch->SearchOperator = @$filter["z_pdfLicense"];
        $this->pdfLicense->AdvancedSearch->SearchCondition = @$filter["v_pdfLicense"];
        $this->pdfLicense->AdvancedSearch->SearchValue2 = @$filter["y_pdfLicense"];
        $this->pdfLicense->AdvancedSearch->SearchOperator2 = @$filter["w_pdfLicense"];
        $this->pdfLicense->AdvancedSearch->save();

        // Field applicationId
        $this->applicationId->AdvancedSearch->SearchValue = @$filter["x_applicationId"];
        $this->applicationId->AdvancedSearch->SearchOperator = @$filter["z_applicationId"];
        $this->applicationId->AdvancedSearch->SearchCondition = @$filter["v_applicationId"];
        $this->applicationId->AdvancedSearch->SearchValue2 = @$filter["y_applicationId"];
        $this->applicationId->AdvancedSearch->SearchOperator2 = @$filter["w_applicationId"];
        $this->applicationId->AdvancedSearch->save();

        // Field isheadquarter
        $this->isheadquarter->AdvancedSearch->SearchValue = @$filter["x_isheadquarter"];
        $this->isheadquarter->AdvancedSearch->SearchOperator = @$filter["z_isheadquarter"];
        $this->isheadquarter->AdvancedSearch->SearchCondition = @$filter["v_isheadquarter"];
        $this->isheadquarter->AdvancedSearch->SearchValue2 = @$filter["y_isheadquarter"];
        $this->isheadquarter->AdvancedSearch->SearchOperator2 = @$filter["w_isheadquarter"];
        $this->isheadquarter->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->federationId, $default, false); // federationId
        $this->buildSearchSql($where, $this->masterSchoolId, $default, false); // masterSchoolId
        $this->buildSearchSql($where, $this->school, $default, false); // school
        $this->buildSearchSql($where, $this->countryId, $default, false); // countryId
        $this->buildSearchSql($where, $this->UFId, $default, false); // UFId
        $this->buildSearchSql($where, $this->cityId, $default, false); // cityId
        $this->buildSearchSql($where, $this->neighborhood, $default, false); // neighborhood
        $this->buildSearchSql($where, $this->address, $default, false); // address
        $this->buildSearchSql($where, $this->zipcode, $default, false); // zipcode
        $this->buildSearchSql($where, $this->website, $default, false); // website
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->phone, $default, false); // phone
        $this->buildSearchSql($where, $this->celphone, $default, false); // celphone
        $this->buildSearchSql($where, $this->logo, $default, false); // logo
        $this->buildSearchSql($where, $this->openingDate, $default, false); // openingDate
        $this->buildSearchSql($where, $this->federationRegister, $default, false); // federationRegister
        $this->buildSearchSql($where, $this->createUserId, $default, false); // createUserId
        $this->buildSearchSql($where, $this->createDate, $default, false); // createDate
        $this->buildSearchSql($where, $this->typeId, $default, false); // typeId
        $this->buildSearchSql($where, $this->owner, $default, false); // owner
        $this->buildSearchSql($where, $this->identityNumber, $default, false); // identityNumber
        $this->buildSearchSql($where, $this->birthDateOwner, $default, false); // birthDateOwner
        $this->buildSearchSql($where, $this->ownerCountryId, $default, false); // ownerCountryId
        $this->buildSearchSql($where, $this->ownerStateId, $default, false); // ownerStateId
        $this->buildSearchSql($where, $this->ownCityId, $default, false); // ownCityId
        $this->buildSearchSql($where, $this->ownerTelephone, $default, false); // ownerTelephone
        $this->buildSearchSql($where, $this->ownerTelephoneWork, $default, false); // ownerTelephoneWork
        $this->buildSearchSql($where, $this->ownerProfession, $default, false); // ownerProfession
        $this->buildSearchSql($where, $this->employer, $default, false); // employer
        $this->buildSearchSql($where, $this->ownerGraduation, $default, false); // ownerGraduation
        $this->buildSearchSql($where, $this->ownerGraduationLocation, $default, false); // ownerGraduationLocation
        $this->buildSearchSql($where, $this->ownerGraduationObs, $default, false); // ownerGraduationObs
        $this->buildSearchSql($where, $this->ownerMaritalStatus, $default, false); // ownerMaritalStatus
        $this->buildSearchSql($where, $this->ownerSpouseName, $default, false); // ownerSpouseName
        $this->buildSearchSql($where, $this->ownerSpouseProfession, $default, false); // ownerSpouseProfession
        $this->buildSearchSql($where, $this->propertySituation, $default, false); // propertySituation
        $this->buildSearchSql($where, $this->numberOfStudentsInBeginnig, $default, false); // numberOfStudentsInBeginnig
        $this->buildSearchSql($where, $this->ownerAbout, $default, false); // ownerAbout
        $this->buildSearchSql($where, $this->pdfLicense, $default, false); // pdfLicense
        $this->buildSearchSql($where, $this->applicationId, $default, false); // applicationId
        $this->buildSearchSql($where, $this->isheadquarter, $default, false); // isheadquarter

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id->AdvancedSearch->save(); // id
            $this->federationId->AdvancedSearch->save(); // federationId
            $this->masterSchoolId->AdvancedSearch->save(); // masterSchoolId
            $this->school->AdvancedSearch->save(); // school
            $this->countryId->AdvancedSearch->save(); // countryId
            $this->UFId->AdvancedSearch->save(); // UFId
            $this->cityId->AdvancedSearch->save(); // cityId
            $this->neighborhood->AdvancedSearch->save(); // neighborhood
            $this->address->AdvancedSearch->save(); // address
            $this->zipcode->AdvancedSearch->save(); // zipcode
            $this->website->AdvancedSearch->save(); // website
            $this->_email->AdvancedSearch->save(); // email
            $this->phone->AdvancedSearch->save(); // phone
            $this->celphone->AdvancedSearch->save(); // celphone
            $this->logo->AdvancedSearch->save(); // logo
            $this->openingDate->AdvancedSearch->save(); // openingDate
            $this->federationRegister->AdvancedSearch->save(); // federationRegister
            $this->createUserId->AdvancedSearch->save(); // createUserId
            $this->createDate->AdvancedSearch->save(); // createDate
            $this->typeId->AdvancedSearch->save(); // typeId
            $this->owner->AdvancedSearch->save(); // owner
            $this->identityNumber->AdvancedSearch->save(); // identityNumber
            $this->birthDateOwner->AdvancedSearch->save(); // birthDateOwner
            $this->ownerCountryId->AdvancedSearch->save(); // ownerCountryId
            $this->ownerStateId->AdvancedSearch->save(); // ownerStateId
            $this->ownCityId->AdvancedSearch->save(); // ownCityId
            $this->ownerTelephone->AdvancedSearch->save(); // ownerTelephone
            $this->ownerTelephoneWork->AdvancedSearch->save(); // ownerTelephoneWork
            $this->ownerProfession->AdvancedSearch->save(); // ownerProfession
            $this->employer->AdvancedSearch->save(); // employer
            $this->ownerGraduation->AdvancedSearch->save(); // ownerGraduation
            $this->ownerGraduationLocation->AdvancedSearch->save(); // ownerGraduationLocation
            $this->ownerGraduationObs->AdvancedSearch->save(); // ownerGraduationObs
            $this->ownerMaritalStatus->AdvancedSearch->save(); // ownerMaritalStatus
            $this->ownerSpouseName->AdvancedSearch->save(); // ownerSpouseName
            $this->ownerSpouseProfession->AdvancedSearch->save(); // ownerSpouseProfession
            $this->propertySituation->AdvancedSearch->save(); // propertySituation
            $this->numberOfStudentsInBeginnig->AdvancedSearch->save(); // numberOfStudentsInBeginnig
            $this->ownerAbout->AdvancedSearch->save(); // ownerAbout
            $this->pdfLicense->AdvancedSearch->save(); // pdfLicense
            $this->applicationId->AdvancedSearch->save(); // applicationId
            $this->isheadquarter->AdvancedSearch->save(); // isheadquarter
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
        $searchFlds[] = &$this->school;
        $searchFlds[] = &$this->neighborhood;
        $searchFlds[] = &$this->address;
        $searchFlds[] = &$this->zipcode;
        $searchFlds[] = &$this->website;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->phone;
        $searchFlds[] = &$this->celphone;
        $searchFlds[] = &$this->logo;
        $searchFlds[] = &$this->federationRegister;
        $searchFlds[] = &$this->owner;
        $searchFlds[] = &$this->identityNumber;
        $searchFlds[] = &$this->ownerTelephone;
        $searchFlds[] = &$this->ownerTelephoneWork;
        $searchFlds[] = &$this->ownerProfession;
        $searchFlds[] = &$this->employer;
        $searchFlds[] = &$this->ownerGraduationLocation;
        $searchFlds[] = &$this->ownerGraduationObs;
        $searchFlds[] = &$this->ownerSpouseName;
        $searchFlds[] = &$this->ownerSpouseProfession;
        $searchFlds[] = &$this->ownerAbout;
        $searchFlds[] = &$this->pdfLicense;
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
        if ($this->federationId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->masterSchoolId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->school->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->countryId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->UFId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cityId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->neighborhood->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->address->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->zipcode->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->website->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->phone->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->celphone->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->logo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->openingDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->federationRegister->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createUserId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->createDate->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->typeId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->owner->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->identityNumber->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->birthDateOwner->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerCountryId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerStateId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownCityId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerTelephone->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerTelephoneWork->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerProfession->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->employer->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerGraduation->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerGraduationLocation->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerGraduationObs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerMaritalStatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerSpouseName->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerSpouseProfession->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->propertySituation->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->numberOfStudentsInBeginnig->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ownerAbout->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pdfLicense->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->applicationId->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->isheadquarter->AdvancedSearch->issetSession()) {
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
        $this->federationId->AdvancedSearch->unsetSession();
        $this->masterSchoolId->AdvancedSearch->unsetSession();
        $this->school->AdvancedSearch->unsetSession();
        $this->countryId->AdvancedSearch->unsetSession();
        $this->UFId->AdvancedSearch->unsetSession();
        $this->cityId->AdvancedSearch->unsetSession();
        $this->neighborhood->AdvancedSearch->unsetSession();
        $this->address->AdvancedSearch->unsetSession();
        $this->zipcode->AdvancedSearch->unsetSession();
        $this->website->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->phone->AdvancedSearch->unsetSession();
        $this->celphone->AdvancedSearch->unsetSession();
        $this->logo->AdvancedSearch->unsetSession();
        $this->openingDate->AdvancedSearch->unsetSession();
        $this->federationRegister->AdvancedSearch->unsetSession();
        $this->createUserId->AdvancedSearch->unsetSession();
        $this->createDate->AdvancedSearch->unsetSession();
        $this->typeId->AdvancedSearch->unsetSession();
        $this->owner->AdvancedSearch->unsetSession();
        $this->identityNumber->AdvancedSearch->unsetSession();
        $this->birthDateOwner->AdvancedSearch->unsetSession();
        $this->ownerCountryId->AdvancedSearch->unsetSession();
        $this->ownerStateId->AdvancedSearch->unsetSession();
        $this->ownCityId->AdvancedSearch->unsetSession();
        $this->ownerTelephone->AdvancedSearch->unsetSession();
        $this->ownerTelephoneWork->AdvancedSearch->unsetSession();
        $this->ownerProfession->AdvancedSearch->unsetSession();
        $this->employer->AdvancedSearch->unsetSession();
        $this->ownerGraduation->AdvancedSearch->unsetSession();
        $this->ownerGraduationLocation->AdvancedSearch->unsetSession();
        $this->ownerGraduationObs->AdvancedSearch->unsetSession();
        $this->ownerMaritalStatus->AdvancedSearch->unsetSession();
        $this->ownerSpouseName->AdvancedSearch->unsetSession();
        $this->ownerSpouseProfession->AdvancedSearch->unsetSession();
        $this->propertySituation->AdvancedSearch->unsetSession();
        $this->numberOfStudentsInBeginnig->AdvancedSearch->unsetSession();
        $this->ownerAbout->AdvancedSearch->unsetSession();
        $this->pdfLicense->AdvancedSearch->unsetSession();
        $this->applicationId->AdvancedSearch->unsetSession();
        $this->isheadquarter->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->id->AdvancedSearch->load();
        $this->federationId->AdvancedSearch->load();
        $this->masterSchoolId->AdvancedSearch->load();
        $this->school->AdvancedSearch->load();
        $this->countryId->AdvancedSearch->load();
        $this->UFId->AdvancedSearch->load();
        $this->cityId->AdvancedSearch->load();
        $this->neighborhood->AdvancedSearch->load();
        $this->address->AdvancedSearch->load();
        $this->zipcode->AdvancedSearch->load();
        $this->website->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->phone->AdvancedSearch->load();
        $this->celphone->AdvancedSearch->load();
        $this->logo->AdvancedSearch->load();
        $this->openingDate->AdvancedSearch->load();
        $this->federationRegister->AdvancedSearch->load();
        $this->createUserId->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
        $this->typeId->AdvancedSearch->load();
        $this->owner->AdvancedSearch->load();
        $this->identityNumber->AdvancedSearch->load();
        $this->birthDateOwner->AdvancedSearch->load();
        $this->ownerCountryId->AdvancedSearch->load();
        $this->ownerStateId->AdvancedSearch->load();
        $this->ownCityId->AdvancedSearch->load();
        $this->ownerTelephone->AdvancedSearch->load();
        $this->ownerTelephoneWork->AdvancedSearch->load();
        $this->ownerProfession->AdvancedSearch->load();
        $this->employer->AdvancedSearch->load();
        $this->ownerGraduation->AdvancedSearch->load();
        $this->ownerGraduationLocation->AdvancedSearch->load();
        $this->ownerGraduationObs->AdvancedSearch->load();
        $this->ownerMaritalStatus->AdvancedSearch->load();
        $this->ownerSpouseName->AdvancedSearch->load();
        $this->ownerSpouseProfession->AdvancedSearch->load();
        $this->propertySituation->AdvancedSearch->load();
        $this->numberOfStudentsInBeginnig->AdvancedSearch->load();
        $this->ownerAbout->AdvancedSearch->load();
        $this->pdfLicense->AdvancedSearch->load();
        $this->applicationId->AdvancedSearch->load();
        $this->isheadquarter->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->school->Expression . " ASC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
            $defaultSortList = ($this->school->VirtualExpression != "" ? $this->school->VirtualExpression : $this->school->Expression) . " ASC"; // Set up default sort
            if ($this->getSessionOrderByList() == "" && $defaultSortList != "") {
                $this->setSessionOrderByList($defaultSortList);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->masterSchoolId); // masterSchoolId
            $this->updateSort($this->school); // school
            $this->updateSort($this->countryId); // countryId
            $this->updateSort($this->cityId); // cityId
            $this->updateSort($this->owner); // owner
            $this->updateSort($this->applicationId); // applicationId
            $this->updateSort($this->isheadquarter); // isheadquarter
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
                        $this->applicationId->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->setSessionOrderByList($orderBy);
                $this->id->setSort("");
                $this->federationId->setSort("");
                $this->masterSchoolId->setSort("");
                $this->school->setSort("");
                $this->countryId->setSort("");
                $this->UFId->setSort("");
                $this->cityId->setSort("");
                $this->neighborhood->setSort("");
                $this->address->setSort("");
                $this->zipcode->setSort("");
                $this->website->setSort("");
                $this->_email->setSort("");
                $this->phone->setSort("");
                $this->celphone->setSort("");
                $this->logo->setSort("");
                $this->openingDate->setSort("");
                $this->federationRegister->setSort("");
                $this->createUserId->setSort("");
                $this->createDate->setSort("");
                $this->typeId->setSort("");
                $this->owner->setSort("");
                $this->identityNumber->setSort("");
                $this->birthDateOwner->setSort("");
                $this->ownerCountryId->setSort("");
                $this->ownerStateId->setSort("");
                $this->ownCityId->setSort("");
                $this->ownerTelephone->setSort("");
                $this->ownerTelephoneWork->setSort("");
                $this->ownerProfession->setSort("");
                $this->employer->setSort("");
                $this->ownerGraduation->setSort("");
                $this->ownerGraduationLocation->setSort("");
                $this->ownerGraduationObs->setSort("");
                $this->ownerMaritalStatus->setSort("");
                $this->ownerSpouseName->setSort("");
                $this->ownerSpouseProfession->setSort("");
                $this->propertySituation->setSort("");
                $this->numberOfStudentsInBeginnig->setSort("");
                $this->ownerAbout->setSort("");
                $this->pdfLicense->setSort("");
                $this->applicationId->setSort("");
                $this->isheadquarter->setSort("");
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

        // "detail_school_users"
        $item = &$this->ListOptions->add("detail_school_users");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'school_users');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_school_member"
        $item = &$this->ListOptions->add("detail_school_member");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'school_member');
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
        $pages->add("school_users");
        $pages->add("school_member");
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
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffed_schoollist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"ffed_schoollist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
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

        // "detail_school_users"
        $opt = $this->ListOptions["detail_school_users"];
        if ($Security->allowList(CurrentProjectID() . 'school_users') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("school_users", "TblCaption");
            if (!$this->ShowMultipleDetails) { // Skip loading record count if show multiple details
                $detailTbl = Container("school_users");
                $detailFilter = $detailTbl->getDetailFilter($this);
                $detailTbl->setCurrentMasterTable($this->TableVar);
                $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $body .= "&nbsp;" . str_replace("%c", Container("school_users")->Count, $Language->phrase("DetailCount"));
            }
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("SchoolUsersList?" . Config("TABLE_SHOW_MASTER") . "=fed_school&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("SchoolUsersGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=school_users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "school_users";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=school_users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "school_users";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=school_users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "school_users";
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

        // "detail_school_member"
        $opt = $this->ListOptions["detail_school_member"];
        if ($Security->allowList(CurrentProjectID() . 'school_member') && $this->showOptionLink()) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("school_member", "TblCaption");
            if (!$this->ShowMultipleDetails) { // Skip loading record count if show multiple details
                $detailTbl = Container("school_member");
                $detailFilter = $detailTbl->getDetailFilter($this);
                $detailTbl->setCurrentMasterTable($this->TableVar);
                $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                $body .= "&nbsp;" . str_replace("%c", Container("school_member")->Count, $Language->phrase("DetailCount"));
            }
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("SchoolMemberList?" . Config("TABLE_SHOW_MASTER") . "=fed_school&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("SchoolMemberGrid");
            if ($detailPage->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=school_member");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "school_member";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=school_member");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "school_member";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailCopyLink", null);
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=school_member");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "school_member";
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
        $sqlwrk = "`schoolId`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_school_users"
        if ($this->DetailPages && $this->DetailPages["school_users"] && $this->DetailPages["school_users"]->Visible && $Security->allowList(CurrentProjectID() . 'school_users')) {
            $link = "";
            $option = $this->ListOptions["detail_school_users"];
            $url = "SchoolUsersPreview?t=fed_school&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"school_users\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'fed_school')) {
                $label = $Language->TablePhrase("school_users", "TblCaption");
                if ($this->ShowMultipleDetails) { // Detail count not setup yet
                    $detailTbl = Container("school_users");
                    $detailFilter = $detailTbl->getDetailFilter($this);
                    $detailTbl->setCurrentMasterTable($this->TableVar);
                    $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                    $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                }
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("school_users")->Count, $Language->phrase("DetailCount")));
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"school_users\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("SchoolUsersList?" . Config("TABLE_SHOW_MASTER") . "=fed_school&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("school_users", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("SchoolUsersGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=school_users"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=school_users"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=school_users"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }
        $sqlwrk = "`schoolId`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_school_member"
        if ($this->DetailPages && $this->DetailPages["school_member"] && $this->DetailPages["school_member"]->Visible && $Security->allowList(CurrentProjectID() . 'school_member')) {
            $link = "";
            $option = $this->ListOptions["detail_school_member"];
            $url = "SchoolMemberPreview?t=fed_school&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"school_member\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'fed_school')) {
                $label = $Language->TablePhrase("school_member", "TblCaption");
                if ($this->ShowMultipleDetails) { // Detail count not setup yet
                    $detailTbl = Container("school_member");
                    $detailFilter = $detailTbl->getDetailFilter($this);
                    $detailTbl->setCurrentMasterTable($this->TableVar);
                    $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
                    $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
                }
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("school_member")->Count, $Language->phrase("DetailCount")));
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"school_member\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("SchoolMemberList?" . Config("TABLE_SHOW_MASTER") . "=fed_school&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $title = $Language->TablePhrase("school_member", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("SchoolMemberGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $this->showOptionLink("view") && $Security->allowView(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=school_member"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $this->showOptionLink("edit") && $Security->allowEdit(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=school_member"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($url) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailAdd && $Security->canAdd() && $this->showOptionLink("add") && $Security->allowAdd(CurrentProjectID() . 'fed_school')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=school_member"));
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
                $item = &$option->add("detailadd_school_users");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=school_users");
                $detailPage = Container("SchoolUsersGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'fed_school') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "school_users";
                }
                $item = &$option->add("detailadd_school_member");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=school_member");
                $detailPage = Container("SchoolMemberGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'fed_school') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "school_member";
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
            $option->add("masterSchoolId", $this->createColumnOption("masterSchoolId"));
            $option->add("school", $this->createColumnOption("school"));
            $option->add("countryId", $this->createColumnOption("countryId"));
            $option->add("cityId", $this->createColumnOption("cityId"));
            $option->add("owner", $this->createColumnOption("owner"));
            $option->add("applicationId", $this->createColumnOption("applicationId"));
            $option->add("isheadquarter", $this->createColumnOption("isheadquarter"));
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"ffed_schoolsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"ffed_schoolsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="ffed_schoollist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
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

        // federationId
        if ($this->federationId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->federationId->AdvancedSearch->SearchValue != "" || $this->federationId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // masterSchoolId
        if ($this->masterSchoolId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->masterSchoolId->AdvancedSearch->SearchValue != "" || $this->masterSchoolId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // school
        if ($this->school->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->school->AdvancedSearch->SearchValue != "" || $this->school->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // countryId
        if ($this->countryId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->countryId->AdvancedSearch->SearchValue != "" || $this->countryId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // UFId
        if ($this->UFId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->UFId->AdvancedSearch->SearchValue != "" || $this->UFId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cityId
        if ($this->cityId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cityId->AdvancedSearch->SearchValue != "" || $this->cityId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // neighborhood
        if ($this->neighborhood->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->neighborhood->AdvancedSearch->SearchValue != "" || $this->neighborhood->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // address
        if ($this->address->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->address->AdvancedSearch->SearchValue != "" || $this->address->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // zipcode
        if ($this->zipcode->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->zipcode->AdvancedSearch->SearchValue != "" || $this->zipcode->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // website
        if ($this->website->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->website->AdvancedSearch->SearchValue != "" || $this->website->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_email->AdvancedSearch->SearchValue != "" || $this->_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // phone
        if ($this->phone->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->phone->AdvancedSearch->SearchValue != "" || $this->phone->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // celphone
        if ($this->celphone->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->celphone->AdvancedSearch->SearchValue != "" || $this->celphone->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // logo
        if ($this->logo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->logo->AdvancedSearch->SearchValue != "" || $this->logo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // openingDate
        if ($this->openingDate->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->openingDate->AdvancedSearch->SearchValue != "" || $this->openingDate->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // federationRegister
        if ($this->federationRegister->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->federationRegister->AdvancedSearch->SearchValue != "" || $this->federationRegister->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // typeId
        if ($this->typeId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->typeId->AdvancedSearch->SearchValue != "" || $this->typeId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // owner
        if ($this->owner->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->owner->AdvancedSearch->SearchValue != "" || $this->owner->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // identityNumber
        if ($this->identityNumber->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->identityNumber->AdvancedSearch->SearchValue != "" || $this->identityNumber->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // birthDateOwner
        if ($this->birthDateOwner->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->birthDateOwner->AdvancedSearch->SearchValue != "" || $this->birthDateOwner->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerCountryId
        if ($this->ownerCountryId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerCountryId->AdvancedSearch->SearchValue != "" || $this->ownerCountryId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerStateId
        if ($this->ownerStateId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerStateId->AdvancedSearch->SearchValue != "" || $this->ownerStateId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownCityId
        if ($this->ownCityId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownCityId->AdvancedSearch->SearchValue != "" || $this->ownCityId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerTelephone
        if ($this->ownerTelephone->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerTelephone->AdvancedSearch->SearchValue != "" || $this->ownerTelephone->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerTelephoneWork
        if ($this->ownerTelephoneWork->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerTelephoneWork->AdvancedSearch->SearchValue != "" || $this->ownerTelephoneWork->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerProfession
        if ($this->ownerProfession->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerProfession->AdvancedSearch->SearchValue != "" || $this->ownerProfession->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // employer
        if ($this->employer->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->employer->AdvancedSearch->SearchValue != "" || $this->employer->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerGraduation
        if ($this->ownerGraduation->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerGraduation->AdvancedSearch->SearchValue != "" || $this->ownerGraduation->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerGraduationLocation
        if ($this->ownerGraduationLocation->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerGraduationLocation->AdvancedSearch->SearchValue != "" || $this->ownerGraduationLocation->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerGraduationObs
        if ($this->ownerGraduationObs->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerGraduationObs->AdvancedSearch->SearchValue != "" || $this->ownerGraduationObs->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerMaritalStatus
        if ($this->ownerMaritalStatus->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerMaritalStatus->AdvancedSearch->SearchValue != "" || $this->ownerMaritalStatus->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerSpouseName
        if ($this->ownerSpouseName->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerSpouseName->AdvancedSearch->SearchValue != "" || $this->ownerSpouseName->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerSpouseProfession
        if ($this->ownerSpouseProfession->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerSpouseProfession->AdvancedSearch->SearchValue != "" || $this->ownerSpouseProfession->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // propertySituation
        if ($this->propertySituation->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->propertySituation->AdvancedSearch->SearchValue != "" || $this->propertySituation->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // numberOfStudentsInBeginnig
        if ($this->numberOfStudentsInBeginnig->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->numberOfStudentsInBeginnig->AdvancedSearch->SearchValue != "" || $this->numberOfStudentsInBeginnig->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ownerAbout
        if ($this->ownerAbout->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ownerAbout->AdvancedSearch->SearchValue != "" || $this->ownerAbout->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // pdfLicense
        if ($this->pdfLicense->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pdfLicense->AdvancedSearch->SearchValue != "" || $this->pdfLicense->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // applicationId
        if ($this->applicationId->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->applicationId->AdvancedSearch->SearchValue != "" || $this->applicationId->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // isheadquarter
        if ($this->isheadquarter->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->isheadquarter->AdvancedSearch->SearchValue != "" || $this->isheadquarter->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->isheadquarter->AdvancedSearch->SearchValue)) {
            $this->isheadquarter->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isheadquarter->AdvancedSearch->SearchValue);
        }
        if (is_array($this->isheadquarter->AdvancedSearch->SearchValue2)) {
            $this->isheadquarter->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->isheadquarter->AdvancedSearch->SearchValue2);
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
        $this->federationId->setDbValue($row['federationId']);
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
        $this->school->setDbValue($row['school']);
        $this->countryId->setDbValue($row['countryId']);
        $this->UFId->setDbValue($row['UFId']);
        $this->cityId->setDbValue($row['cityId']);
        if (array_key_exists('EV__cityId', $row)) {
            $this->cityId->VirtualValue = $row['EV__cityId']; // Set up virtual field value
        } else {
            $this->cityId->VirtualValue = ""; // Clear value
        }
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->address->setDbValue($row['address']);
        $this->zipcode->setDbValue($row['zipcode']);
        $this->website->setDbValue($row['website']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->celphone->setDbValue($row['celphone']);
        $this->logo->setDbValue($row['logo']);
        $this->openingDate->setDbValue($row['openingDate']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->typeId->setDbValue($row['typeId']);
        $this->owner->setDbValue($row['owner']);
        $this->identityNumber->setDbValue($row['identityNumber']);
        $this->birthDateOwner->setDbValue($row['birthDateOwner']);
        $this->ownerCountryId->setDbValue($row['ownerCountryId']);
        $this->ownerStateId->setDbValue($row['ownerStateId']);
        $this->ownCityId->setDbValue($row['ownCityId']);
        $this->ownerTelephone->setDbValue($row['ownerTelephone']);
        $this->ownerTelephoneWork->setDbValue($row['ownerTelephoneWork']);
        $this->ownerProfession->setDbValue($row['ownerProfession']);
        $this->employer->setDbValue($row['employer']);
        $this->ownerGraduation->setDbValue($row['ownerGraduation']);
        $this->ownerGraduationLocation->setDbValue($row['ownerGraduationLocation']);
        $this->ownerGraduationObs->setDbValue($row['ownerGraduationObs']);
        $this->ownerMaritalStatus->setDbValue($row['ownerMaritalStatus']);
        $this->ownerSpouseName->setDbValue($row['ownerSpouseName']);
        $this->ownerSpouseProfession->setDbValue($row['ownerSpouseProfession']);
        $this->propertySituation->setDbValue($row['propertySituation']);
        $this->numberOfStudentsInBeginnig->setDbValue($row['numberOfStudentsInBeginnig']);
        $this->ownerAbout->setDbValue($row['ownerAbout']);
        $this->pdfLicense->setDbValue($row['pdfLicense']);
        $this->applicationId->setDbValue($row['applicationId']);
        $this->isheadquarter->setDbValue($row['isheadquarter']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['federationId'] = $this->federationId->DefaultValue;
        $row['masterSchoolId'] = $this->masterSchoolId->DefaultValue;
        $row['school'] = $this->school->DefaultValue;
        $row['countryId'] = $this->countryId->DefaultValue;
        $row['UFId'] = $this->UFId->DefaultValue;
        $row['cityId'] = $this->cityId->DefaultValue;
        $row['neighborhood'] = $this->neighborhood->DefaultValue;
        $row['address'] = $this->address->DefaultValue;
        $row['zipcode'] = $this->zipcode->DefaultValue;
        $row['website'] = $this->website->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['phone'] = $this->phone->DefaultValue;
        $row['celphone'] = $this->celphone->DefaultValue;
        $row['logo'] = $this->logo->DefaultValue;
        $row['openingDate'] = $this->openingDate->DefaultValue;
        $row['federationRegister'] = $this->federationRegister->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['typeId'] = $this->typeId->DefaultValue;
        $row['owner'] = $this->owner->DefaultValue;
        $row['identityNumber'] = $this->identityNumber->DefaultValue;
        $row['birthDateOwner'] = $this->birthDateOwner->DefaultValue;
        $row['ownerCountryId'] = $this->ownerCountryId->DefaultValue;
        $row['ownerStateId'] = $this->ownerStateId->DefaultValue;
        $row['ownCityId'] = $this->ownCityId->DefaultValue;
        $row['ownerTelephone'] = $this->ownerTelephone->DefaultValue;
        $row['ownerTelephoneWork'] = $this->ownerTelephoneWork->DefaultValue;
        $row['ownerProfession'] = $this->ownerProfession->DefaultValue;
        $row['employer'] = $this->employer->DefaultValue;
        $row['ownerGraduation'] = $this->ownerGraduation->DefaultValue;
        $row['ownerGraduationLocation'] = $this->ownerGraduationLocation->DefaultValue;
        $row['ownerGraduationObs'] = $this->ownerGraduationObs->DefaultValue;
        $row['ownerMaritalStatus'] = $this->ownerMaritalStatus->DefaultValue;
        $row['ownerSpouseName'] = $this->ownerSpouseName->DefaultValue;
        $row['ownerSpouseProfession'] = $this->ownerSpouseProfession->DefaultValue;
        $row['propertySituation'] = $this->propertySituation->DefaultValue;
        $row['numberOfStudentsInBeginnig'] = $this->numberOfStudentsInBeginnig->DefaultValue;
        $row['ownerAbout'] = $this->ownerAbout->DefaultValue;
        $row['pdfLicense'] = $this->pdfLicense->DefaultValue;
        $row['applicationId'] = $this->applicationId->DefaultValue;
        $row['isheadquarter'] = $this->isheadquarter->DefaultValue;
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

        // federationId

        // masterSchoolId

        // school

        // countryId

        // UFId

        // cityId

        // neighborhood

        // address

        // zipcode

        // website

        // email

        // phone

        // celphone

        // logo

        // openingDate

        // federationRegister

        // createUserId

        // createDate

        // typeId

        // owner

        // identityNumber

        // birthDateOwner

        // ownerCountryId

        // ownerStateId

        // ownCityId

        // ownerTelephone

        // ownerTelephoneWork

        // ownerProfession

        // employer

        // ownerGraduation

        // ownerGraduationLocation

        // ownerGraduationObs

        // ownerMaritalStatus

        // ownerSpouseName

        // ownerSpouseProfession

        // propertySituation

        // numberOfStudentsInBeginnig

        // ownerAbout

        // pdfLicense

        // applicationId

        // isheadquarter

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // masterSchoolId
            $curVal = strval($this->masterSchoolId->CurrentValue);
            if ($curVal != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
                if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`typeId`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->masterSchoolId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->masterSchoolId->Lookup->renderViewRow($rswrk[0]);
                        $this->masterSchoolId->ViewValue = $this->masterSchoolId->displayValue($arwrk);
                    } else {
                        $this->masterSchoolId->ViewValue = FormatNumber($this->masterSchoolId->CurrentValue, $this->masterSchoolId->formatPattern());
                    }
                }
            } else {
                $this->masterSchoolId->ViewValue = null;
            }
            $this->masterSchoolId->ViewCustomAttributes = "";

            // school
            $this->school->ViewValue = $this->school->CurrentValue;
            $this->school->ViewCustomAttributes = "";

            // countryId
            $curVal = strval($this->countryId->CurrentValue);
            if ($curVal != "") {
                $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
                if ($this->countryId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->countryId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->countryId->Lookup->renderViewRow($rswrk[0]);
                        $this->countryId->ViewValue = $this->countryId->displayValue($arwrk);
                    } else {
                        $this->countryId->ViewValue = FormatNumber($this->countryId->CurrentValue, $this->countryId->formatPattern());
                    }
                }
            } else {
                $this->countryId->ViewValue = null;
            }
            $this->countryId->ViewCustomAttributes = "";

            // UFId
            $curVal = strval($this->UFId->CurrentValue);
            if ($curVal != "") {
                $this->UFId->ViewValue = $this->UFId->lookupCacheOption($curVal);
                if ($this->UFId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->UFId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->UFId->Lookup->renderViewRow($rswrk[0]);
                        $this->UFId->ViewValue = $this->UFId->displayValue($arwrk);
                    } else {
                        $this->UFId->ViewValue = FormatNumber($this->UFId->CurrentValue, $this->UFId->formatPattern());
                    }
                }
            } else {
                $this->UFId->ViewValue = null;
            }
            $this->UFId->ViewCustomAttributes = "";

            // cityId
            if ($this->cityId->VirtualValue != "") {
                $this->cityId->ViewValue = $this->cityId->VirtualValue;
            } else {
                $curVal = strval($this->cityId->CurrentValue);
                if ($curVal != "") {
                    $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
                    if ($this->cityId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->cityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->cityId->Lookup->renderViewRow($rswrk[0]);
                            $this->cityId->ViewValue = $this->cityId->displayValue($arwrk);
                        } else {
                            $this->cityId->ViewValue = FormatNumber($this->cityId->CurrentValue, $this->cityId->formatPattern());
                        }
                    }
                } else {
                    $this->cityId->ViewValue = null;
                }
            }
            $this->cityId->ViewCustomAttributes = "";

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // zipcode
            $this->zipcode->ViewValue = $this->zipcode->CurrentValue;
            $this->zipcode->ViewCustomAttributes = "";

            // website
            $this->website->ViewValue = $this->website->CurrentValue;
            $this->website->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

            // celphone
            $this->celphone->ViewValue = $this->celphone->CurrentValue;
            $this->celphone->ViewCustomAttributes = "";

            // logo
            $this->logo->ViewValue = $this->logo->CurrentValue;
            $this->logo->ViewCustomAttributes = "";

            // openingDate
            $this->openingDate->ViewValue = $this->openingDate->CurrentValue;
            $this->openingDate->ViewValue = FormatDateTime($this->openingDate->ViewValue, $this->openingDate->formatPattern());
            $this->openingDate->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // typeId
            $this->typeId->ViewValue = $this->typeId->CurrentValue;
            $this->typeId->ViewValue = FormatNumber($this->typeId->ViewValue, $this->typeId->formatPattern());
            $this->typeId->ViewCustomAttributes = "";

            // owner
            $this->owner->ViewValue = $this->owner->CurrentValue;
            $this->owner->ViewCustomAttributes = "";

            // identityNumber
            $this->identityNumber->ViewValue = $this->identityNumber->CurrentValue;
            $this->identityNumber->ViewCustomAttributes = "";

            // birthDateOwner
            $this->birthDateOwner->ViewValue = $this->birthDateOwner->CurrentValue;
            $this->birthDateOwner->ViewValue = FormatDateTime($this->birthDateOwner->ViewValue, $this->birthDateOwner->formatPattern());
            $this->birthDateOwner->ViewCustomAttributes = "";

            // ownerCountryId
            $this->ownerCountryId->ViewValue = $this->ownerCountryId->CurrentValue;
            $this->ownerCountryId->ViewValue = FormatNumber($this->ownerCountryId->ViewValue, $this->ownerCountryId->formatPattern());
            $this->ownerCountryId->ViewCustomAttributes = "";

            // ownerStateId
            $this->ownerStateId->ViewValue = $this->ownerStateId->CurrentValue;
            $this->ownerStateId->ViewValue = FormatNumber($this->ownerStateId->ViewValue, $this->ownerStateId->formatPattern());
            $this->ownerStateId->ViewCustomAttributes = "";

            // ownCityId
            $this->ownCityId->ViewValue = $this->ownCityId->CurrentValue;
            $this->ownCityId->ViewValue = FormatNumber($this->ownCityId->ViewValue, $this->ownCityId->formatPattern());
            $this->ownCityId->ViewCustomAttributes = "";

            // ownerTelephone
            $this->ownerTelephone->ViewValue = $this->ownerTelephone->CurrentValue;
            $this->ownerTelephone->ViewCustomAttributes = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->ViewValue = $this->ownerTelephoneWork->CurrentValue;
            $this->ownerTelephoneWork->ViewCustomAttributes = "";

            // ownerProfession
            $this->ownerProfession->ViewValue = $this->ownerProfession->CurrentValue;
            $this->ownerProfession->ViewCustomAttributes = "";

            // employer
            $this->employer->ViewValue = $this->employer->CurrentValue;
            $this->employer->ViewCustomAttributes = "";

            // ownerGraduation
            $this->ownerGraduation->ViewValue = $this->ownerGraduation->CurrentValue;
            $this->ownerGraduation->ViewValue = FormatNumber($this->ownerGraduation->ViewValue, $this->ownerGraduation->formatPattern());
            $this->ownerGraduation->ViewCustomAttributes = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->ViewValue = $this->ownerGraduationLocation->CurrentValue;
            $this->ownerGraduationLocation->ViewCustomAttributes = "";

            // ownerMaritalStatus
            $this->ownerMaritalStatus->ViewValue = $this->ownerMaritalStatus->CurrentValue;
            $this->ownerMaritalStatus->ViewValue = FormatNumber($this->ownerMaritalStatus->ViewValue, $this->ownerMaritalStatus->formatPattern());
            $this->ownerMaritalStatus->ViewCustomAttributes = "";

            // ownerSpouseName
            $this->ownerSpouseName->ViewValue = $this->ownerSpouseName->CurrentValue;
            $this->ownerSpouseName->ViewCustomAttributes = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->ViewValue = $this->ownerSpouseProfession->CurrentValue;
            $this->ownerSpouseProfession->ViewCustomAttributes = "";

            // propertySituation
            $this->propertySituation->ViewValue = $this->propertySituation->CurrentValue;
            $this->propertySituation->ViewValue = FormatNumber($this->propertySituation->ViewValue, $this->propertySituation->formatPattern());
            $this->propertySituation->ViewCustomAttributes = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->ViewValue = $this->numberOfStudentsInBeginnig->CurrentValue;
            $this->numberOfStudentsInBeginnig->ViewValue = FormatNumber($this->numberOfStudentsInBeginnig->ViewValue, $this->numberOfStudentsInBeginnig->formatPattern());
            $this->numberOfStudentsInBeginnig->ViewCustomAttributes = "";

            // applicationId
            $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
            $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
            $this->applicationId->ViewCustomAttributes = "";

            // isheadquarter
            if (ConvertToBool($this->isheadquarter->CurrentValue)) {
                $this->isheadquarter->ViewValue = $this->isheadquarter->tagCaption(1) != "" ? $this->isheadquarter->tagCaption(1) : "Yes";
            } else {
                $this->isheadquarter->ViewValue = $this->isheadquarter->tagCaption(2) != "" ? $this->isheadquarter->tagCaption(2) : "No";
            }
            $this->isheadquarter->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // masterSchoolId
            $this->masterSchoolId->LinkCustomAttributes = "";
            $this->masterSchoolId->HrefValue = "";
            $this->masterSchoolId->TooltipValue = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";
            $this->school->TooltipValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";
            $this->countryId->TooltipValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";
            $this->cityId->TooltipValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";
            $this->owner->TooltipValue = "";

            // applicationId
            $this->applicationId->LinkCustomAttributes = "";
            $this->applicationId->HrefValue = "";
            $this->applicationId->TooltipValue = "";

            // isheadquarter
            $this->isheadquarter->LinkCustomAttributes = "";
            $this->isheadquarter->HrefValue = "";
            $this->isheadquarter->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // masterSchoolId
            $this->masterSchoolId->setupEditAttributes();
            $this->masterSchoolId->EditCustomAttributes = "";
            $curVal = trim(strval($this->masterSchoolId->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->masterSchoolId->AdvancedSearch->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
            } else {
                $this->masterSchoolId->AdvancedSearch->ViewValue = $this->masterSchoolId->Lookup !== null && is_array($this->masterSchoolId->lookupOptions()) ? $curVal : null;
            }
            if ($this->masterSchoolId->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->masterSchoolId->EditValue = array_values($this->masterSchoolId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->masterSchoolId->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`typeId`=1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->masterSchoolId->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->masterSchoolId->EditValue = $arwrk;
            }
            $this->masterSchoolId->PlaceHolder = RemoveHtml($this->masterSchoolId->caption());

            // school
            $this->school->setupEditAttributes();
            $this->school->EditCustomAttributes = "";
            if (!$this->school->Raw) {
                $this->school->AdvancedSearch->SearchValue = HtmlDecode($this->school->AdvancedSearch->SearchValue);
            }
            $this->school->EditValue = HtmlEncode($this->school->AdvancedSearch->SearchValue);
            $this->school->PlaceHolder = RemoveHtml($this->school->caption());

            // countryId
            $this->countryId->setupEditAttributes();
            $this->countryId->EditCustomAttributes = "";
            $this->countryId->PlaceHolder = RemoveHtml($this->countryId->caption());

            // cityId
            $this->cityId->setupEditAttributes();
            $this->cityId->EditCustomAttributes = "";
            $this->cityId->PlaceHolder = RemoveHtml($this->cityId->caption());

            // owner
            $this->owner->setupEditAttributes();
            $this->owner->EditCustomAttributes = "";
            if (!$this->owner->Raw) {
                $this->owner->AdvancedSearch->SearchValue = HtmlDecode($this->owner->AdvancedSearch->SearchValue);
            }
            $this->owner->EditValue = HtmlEncode($this->owner->AdvancedSearch->SearchValue);
            $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

            // applicationId
            $this->applicationId->setupEditAttributes();
            $this->applicationId->EditCustomAttributes = "";
            $this->applicationId->EditValue = HtmlEncode($this->applicationId->AdvancedSearch->SearchValue);
            $this->applicationId->PlaceHolder = RemoveHtml($this->applicationId->caption());

            // isheadquarter
            $this->isheadquarter->EditCustomAttributes = "";
            $this->isheadquarter->EditValue = $this->isheadquarter->options(false);
            $this->isheadquarter->PlaceHolder = RemoveHtml($this->isheadquarter->caption());
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
        $this->federationId->AdvancedSearch->load();
        $this->masterSchoolId->AdvancedSearch->load();
        $this->school->AdvancedSearch->load();
        $this->countryId->AdvancedSearch->load();
        $this->UFId->AdvancedSearch->load();
        $this->cityId->AdvancedSearch->load();
        $this->neighborhood->AdvancedSearch->load();
        $this->address->AdvancedSearch->load();
        $this->zipcode->AdvancedSearch->load();
        $this->website->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->phone->AdvancedSearch->load();
        $this->celphone->AdvancedSearch->load();
        $this->logo->AdvancedSearch->load();
        $this->openingDate->AdvancedSearch->load();
        $this->federationRegister->AdvancedSearch->load();
        $this->createUserId->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
        $this->typeId->AdvancedSearch->load();
        $this->owner->AdvancedSearch->load();
        $this->identityNumber->AdvancedSearch->load();
        $this->birthDateOwner->AdvancedSearch->load();
        $this->ownerCountryId->AdvancedSearch->load();
        $this->ownerStateId->AdvancedSearch->load();
        $this->ownCityId->AdvancedSearch->load();
        $this->ownerTelephone->AdvancedSearch->load();
        $this->ownerTelephoneWork->AdvancedSearch->load();
        $this->ownerProfession->AdvancedSearch->load();
        $this->employer->AdvancedSearch->load();
        $this->ownerGraduation->AdvancedSearch->load();
        $this->ownerGraduationLocation->AdvancedSearch->load();
        $this->ownerGraduationObs->AdvancedSearch->load();
        $this->ownerMaritalStatus->AdvancedSearch->load();
        $this->ownerSpouseName->AdvancedSearch->load();
        $this->ownerSpouseProfession->AdvancedSearch->load();
        $this->propertySituation->AdvancedSearch->load();
        $this->numberOfStudentsInBeginnig->AdvancedSearch->load();
        $this->ownerAbout->AdvancedSearch->load();
        $this->pdfLicense->AdvancedSearch->load();
        $this->applicationId->AdvancedSearch->load();
        $this->isheadquarter->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl(false);
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"ffed_schoollist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"ffed_schoollist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"ffed_schoollist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="ffed_schoollist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"ffed_schoolsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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

        // Export master record
        if (Config("EXPORT_MASTER_RECORD") && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "fed_applicationschool") {
            $fed_applicationschool = new FedApplicationschoolList();
            $rsmaster = $fed_applicationschool->loadRs($this->DbMasterFilter); // Load master record
            if ($rsmaster) {
                $exportStyle = $doc->Style;
                $doc->setStyle("v"); // Change to vertical
                if (!$this->isExport("csv") || Config("EXPORT_MASTER_RECORD_FOR_CSV")) {
                    $doc->Table = $fed_applicationschool;
                    $fed_applicationschool->exportDocument($doc, new Recordset($rsmaster));
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
            return $Security->isValidUserID($this->id->CurrentValue);
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
            if ($masterTblVar == "fed_applicationschool") {
                $validMaster = true;
                $masterTbl = Container("fed_applicationschool");
                if (($parm = Get("fk_id", Get("applicationId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->applicationId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->applicationId->setSessionValue($this->applicationId->QueryStringValue);
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
                if (($parm = Post("fk_id", Post("applicationId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->applicationId->setFormValue($masterTbl->id->FormValue);
                    $this->applicationId->setSessionValue($this->applicationId->FormValue);
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
            if ($masterTblVar != "fed_applicationschool") {
                if ($this->applicationId->CurrentValue == "") {
                    $this->applicationId->setSessionValue("");
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
                case "x_federationId":
                    break;
                case "x_masterSchoolId":
                    $lookupFilter = function () {
                        return "`typeId`=1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_countryId":
                    break;
                case "x_UFId":
                    break;
                case "x_cityId":
                    break;
                case "x_isheadquarter":
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
