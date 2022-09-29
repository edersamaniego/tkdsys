<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedSchoolGrid extends FedSchool
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_school';

    // Page object name
    public $PageObjName = "FedSchoolGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ffed_schoolgrid";
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (fed_school)
        if (!isset($GLOBALS["fed_school"]) || get_class($GLOBALS["fed_school"]) == PROJECT_NAMESPACE . "fed_school") {
            $GLOBALS["fed_school"] = &$this;
        }
        $this->AddUrl = "FedSchoolAdd";

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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
    public $ShowOtherOptions = false;
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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
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

        // Set up lookup cache
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->masterSchoolId);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->isheadquarter);

        // Load default values for add
        $this->loadDefaultValues();

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd", ""));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
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
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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
            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
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
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
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
            $CurrentForm->hasValue("x_masterSchoolId") &&
            $CurrentForm->hasValue("o_masterSchoolId") &&
            $this->masterSchoolId->CurrentValue != $this->masterSchoolId->DefaultValue &&
            !($this->masterSchoolId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->masterSchoolId->CurrentValue == $this->masterSchoolId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_school") &&
            $CurrentForm->hasValue("o_school") &&
            $this->school->CurrentValue != $this->school->DefaultValue &&
            !($this->school->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->school->CurrentValue == $this->school->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_countryId") &&
            $CurrentForm->hasValue("o_countryId") &&
            $this->countryId->CurrentValue != $this->countryId->DefaultValue &&
            !($this->countryId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->countryId->CurrentValue == $this->countryId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cityId") &&
            $CurrentForm->hasValue("o_cityId") &&
            $this->cityId->CurrentValue != $this->cityId->DefaultValue &&
            !($this->cityId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->cityId->CurrentValue == $this->cityId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_owner") &&
            $CurrentForm->hasValue("o_owner") &&
            $this->owner->CurrentValue != $this->owner->DefaultValue &&
            !($this->owner->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->owner->CurrentValue == $this->owner->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_applicationId") &&
            $CurrentForm->hasValue("o_applicationId") &&
            $this->applicationId->CurrentValue != $this->applicationId->DefaultValue &&
            !($this->applicationId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->applicationId->CurrentValue == $this->applicationId->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_isheadquarter") &&
            $CurrentForm->hasValue("o_isheadquarter") &&
            ConvertToBool($this->isheadquarter->CurrentValue) != ConvertToBool($this->isheadquarter->DefaultValue) &&
            !($this->isheadquarter->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            ConvertToBool($this->isheadquarter->CurrentValue) == ConvertToBool($this->isheadquarter->getSessionValue()))
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
        $this->masterSchoolId->clearErrorMessage();
        $this->school->clearErrorMessage();
        $this->countryId->clearErrorMessage();
        $this->cityId->clearErrorMessage();
        $this->owner->clearErrorMessage();
        $this->applicationId->clearErrorMessage();
        $this->isheadquarter->clearErrorMessage();
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
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
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
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
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
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item && $item->Visible;
            }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->DefaultValue = CurrentUserID();
        $this->id->OldValue = $this->id->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
        }

        // Check field name 'masterSchoolId' first before field var 'x_masterSchoolId'
        $val = $CurrentForm->hasValue("masterSchoolId") ? $CurrentForm->getValue("masterSchoolId") : $CurrentForm->getValue("x_masterSchoolId");
        if (!$this->masterSchoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->masterSchoolId->Visible = false; // Disable update for API request
            } else {
                $this->masterSchoolId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_masterSchoolId")) {
            $this->masterSchoolId->setOldValue($CurrentForm->getValue("o_masterSchoolId"));
        }

        // Check field name 'school' first before field var 'x_school'
        $val = $CurrentForm->hasValue("school") ? $CurrentForm->getValue("school") : $CurrentForm->getValue("x_school");
        if (!$this->school->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->school->Visible = false; // Disable update for API request
            } else {
                $this->school->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_school")) {
            $this->school->setOldValue($CurrentForm->getValue("o_school"));
        }

        // Check field name 'countryId' first before field var 'x_countryId'
        $val = $CurrentForm->hasValue("countryId") ? $CurrentForm->getValue("countryId") : $CurrentForm->getValue("x_countryId");
        if (!$this->countryId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->countryId->Visible = false; // Disable update for API request
            } else {
                $this->countryId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_countryId")) {
            $this->countryId->setOldValue($CurrentForm->getValue("o_countryId"));
        }

        // Check field name 'cityId' first before field var 'x_cityId'
        $val = $CurrentForm->hasValue("cityId") ? $CurrentForm->getValue("cityId") : $CurrentForm->getValue("x_cityId");
        if (!$this->cityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cityId->Visible = false; // Disable update for API request
            } else {
                $this->cityId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cityId")) {
            $this->cityId->setOldValue($CurrentForm->getValue("o_cityId"));
        }

        // Check field name 'owner' first before field var 'x_owner'
        $val = $CurrentForm->hasValue("owner") ? $CurrentForm->getValue("owner") : $CurrentForm->getValue("x_owner");
        if (!$this->owner->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->owner->Visible = false; // Disable update for API request
            } else {
                $this->owner->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_owner")) {
            $this->owner->setOldValue($CurrentForm->getValue("o_owner"));
        }

        // Check field name 'applicationId' first before field var 'x_applicationId'
        $val = $CurrentForm->hasValue("applicationId") ? $CurrentForm->getValue("applicationId") : $CurrentForm->getValue("x_applicationId");
        if (!$this->applicationId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->applicationId->Visible = false; // Disable update for API request
            } else {
                $this->applicationId->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_applicationId")) {
            $this->applicationId->setOldValue($CurrentForm->getValue("o_applicationId"));
        }

        // Check field name 'isheadquarter' first before field var 'x_isheadquarter'
        $val = $CurrentForm->hasValue("isheadquarter") ? $CurrentForm->getValue("isheadquarter") : $CurrentForm->getValue("x_isheadquarter");
        if (!$this->isheadquarter->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isheadquarter->Visible = false; // Disable update for API request
            } else {
                $this->isheadquarter->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_isheadquarter")) {
            $this->isheadquarter->setOldValue($CurrentForm->getValue("o_isheadquarter"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->masterSchoolId->CurrentValue = $this->masterSchoolId->FormValue;
        $this->school->CurrentValue = $this->school->FormValue;
        $this->countryId->CurrentValue = $this->countryId->FormValue;
        $this->cityId->CurrentValue = $this->cityId->FormValue;
        $this->owner->CurrentValue = $this->owner->FormValue;
        $this->applicationId->CurrentValue = $this->applicationId->FormValue;
        $this->isheadquarter->CurrentValue = $this->isheadquarter->FormValue;
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
        $this->CopyUrl = $this->getCopyUrl();
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

            // masterSchoolId
            $this->masterSchoolId->setupEditAttributes();
            $this->masterSchoolId->EditCustomAttributes = "";
            $curVal = trim(strval($this->masterSchoolId->CurrentValue));
            if ($curVal != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
            } else {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->Lookup !== null && is_array($this->masterSchoolId->lookupOptions()) ? $curVal : null;
            }
            if ($this->masterSchoolId->ViewValue !== null) { // Load from cache
                $this->masterSchoolId->EditValue = array_values($this->masterSchoolId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->masterSchoolId->CurrentValue, DATATYPE_NUMBER, "");
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
                $this->school->CurrentValue = HtmlDecode($this->school->CurrentValue);
            }
            $this->school->EditValue = HtmlEncode($this->school->CurrentValue);
            $this->school->PlaceHolder = RemoveHtml($this->school->caption());

            // countryId
            $this->countryId->setupEditAttributes();
            $this->countryId->EditCustomAttributes = "";
            $curVal = trim(strval($this->countryId->CurrentValue));
            if ($curVal != "") {
                $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
            } else {
                $this->countryId->ViewValue = $this->countryId->Lookup !== null && is_array($this->countryId->lookupOptions()) ? $curVal : null;
            }
            if ($this->countryId->ViewValue !== null) { // Load from cache
                $this->countryId->EditValue = array_values($this->countryId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->countryId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->countryId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->countryId->EditValue = $arwrk;
            }
            $this->countryId->PlaceHolder = RemoveHtml($this->countryId->caption());

            // cityId
            $this->cityId->setupEditAttributes();
            $this->cityId->EditCustomAttributes = "";
            $curVal = trim(strval($this->cityId->CurrentValue));
            if ($curVal != "") {
                $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
            } else {
                $this->cityId->ViewValue = $this->cityId->Lookup !== null && is_array($this->cityId->lookupOptions()) ? $curVal : null;
            }
            if ($this->cityId->ViewValue !== null) { // Load from cache
                $this->cityId->EditValue = array_values($this->cityId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->cityId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->cityId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->cityId->EditValue = $arwrk;
            }
            $this->cityId->PlaceHolder = RemoveHtml($this->cityId->caption());

            // owner
            $this->owner->setupEditAttributes();
            $this->owner->EditCustomAttributes = "";
            if (!$this->owner->Raw) {
                $this->owner->CurrentValue = HtmlDecode($this->owner->CurrentValue);
            }
            $this->owner->EditValue = HtmlEncode($this->owner->CurrentValue);
            $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

            // applicationId
            $this->applicationId->setupEditAttributes();
            $this->applicationId->EditCustomAttributes = "";
            if ($this->applicationId->getSessionValue() != "") {
                $this->applicationId->CurrentValue = GetForeignKeyValue($this->applicationId->getSessionValue());
                $this->applicationId->OldValue = $this->applicationId->CurrentValue;
                $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
                $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
                $this->applicationId->ViewCustomAttributes = "";
            } else {
                $this->applicationId->EditValue = HtmlEncode($this->applicationId->CurrentValue);
                $this->applicationId->PlaceHolder = RemoveHtml($this->applicationId->caption());
                if (strval($this->applicationId->EditValue) != "" && is_numeric($this->applicationId->EditValue)) {
                    $this->applicationId->EditValue = FormatNumber($this->applicationId->EditValue, null);
                    $this->applicationId->OldValue = $this->applicationId->EditValue;
                }
            }

            // isheadquarter
            $this->isheadquarter->EditCustomAttributes = "";
            $this->isheadquarter->EditValue = $this->isheadquarter->options(false);
            $this->isheadquarter->PlaceHolder = RemoveHtml($this->isheadquarter->caption());

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // masterSchoolId
            $this->masterSchoolId->LinkCustomAttributes = "";
            $this->masterSchoolId->HrefValue = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // applicationId
            $this->applicationId->LinkCustomAttributes = "";
            $this->applicationId->HrefValue = "";

            // isheadquarter
            $this->isheadquarter->LinkCustomAttributes = "";
            $this->isheadquarter->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // masterSchoolId
            $this->masterSchoolId->setupEditAttributes();
            $this->masterSchoolId->EditCustomAttributes = "";
            $curVal = trim(strval($this->masterSchoolId->CurrentValue));
            if ($curVal != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
            } else {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->Lookup !== null && is_array($this->masterSchoolId->lookupOptions()) ? $curVal : null;
            }
            if ($this->masterSchoolId->ViewValue !== null) { // Load from cache
                $this->masterSchoolId->EditValue = array_values($this->masterSchoolId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->masterSchoolId->CurrentValue, DATATYPE_NUMBER, "");
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
                $this->school->CurrentValue = HtmlDecode($this->school->CurrentValue);
            }
            $this->school->EditValue = HtmlEncode($this->school->CurrentValue);
            $this->school->PlaceHolder = RemoveHtml($this->school->caption());

            // countryId
            $this->countryId->setupEditAttributes();
            $this->countryId->EditCustomAttributes = "";
            $curVal = trim(strval($this->countryId->CurrentValue));
            if ($curVal != "") {
                $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
            } else {
                $this->countryId->ViewValue = $this->countryId->Lookup !== null && is_array($this->countryId->lookupOptions()) ? $curVal : null;
            }
            if ($this->countryId->ViewValue !== null) { // Load from cache
                $this->countryId->EditValue = array_values($this->countryId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->countryId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->countryId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->countryId->EditValue = $arwrk;
            }
            $this->countryId->PlaceHolder = RemoveHtml($this->countryId->caption());

            // cityId
            $this->cityId->setupEditAttributes();
            $this->cityId->EditCustomAttributes = "";
            $curVal = trim(strval($this->cityId->CurrentValue));
            if ($curVal != "") {
                $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
            } else {
                $this->cityId->ViewValue = $this->cityId->Lookup !== null && is_array($this->cityId->lookupOptions()) ? $curVal : null;
            }
            if ($this->cityId->ViewValue !== null) { // Load from cache
                $this->cityId->EditValue = array_values($this->cityId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->cityId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->cityId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->cityId->EditValue = $arwrk;
            }
            $this->cityId->PlaceHolder = RemoveHtml($this->cityId->caption());

            // owner
            $this->owner->setupEditAttributes();
            $this->owner->EditCustomAttributes = "";
            if (!$this->owner->Raw) {
                $this->owner->CurrentValue = HtmlDecode($this->owner->CurrentValue);
            }
            $this->owner->EditValue = HtmlEncode($this->owner->CurrentValue);
            $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

            // applicationId
            $this->applicationId->setupEditAttributes();
            $this->applicationId->EditCustomAttributes = "";
            if ($this->applicationId->getSessionValue() != "") {
                $this->applicationId->CurrentValue = GetForeignKeyValue($this->applicationId->getSessionValue());
                $this->applicationId->OldValue = $this->applicationId->CurrentValue;
                $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
                $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
                $this->applicationId->ViewCustomAttributes = "";
            } else {
                $this->applicationId->EditValue = HtmlEncode($this->applicationId->CurrentValue);
                $this->applicationId->PlaceHolder = RemoveHtml($this->applicationId->caption());
                if (strval($this->applicationId->EditValue) != "" && is_numeric($this->applicationId->EditValue)) {
                    $this->applicationId->EditValue = FormatNumber($this->applicationId->EditValue, null);
                    $this->applicationId->OldValue = $this->applicationId->EditValue;
                }
            }

            // isheadquarter
            $this->isheadquarter->EditCustomAttributes = "";
            $this->isheadquarter->EditValue = $this->isheadquarter->options(false);
            $this->isheadquarter->PlaceHolder = RemoveHtml($this->isheadquarter->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // masterSchoolId
            $this->masterSchoolId->LinkCustomAttributes = "";
            $this->masterSchoolId->HrefValue = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // applicationId
            $this->applicationId->LinkCustomAttributes = "";
            $this->applicationId->HrefValue = "";

            // isheadquarter
            $this->isheadquarter->LinkCustomAttributes = "";
            $this->isheadquarter->HrefValue = "";
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
        if ($this->masterSchoolId->Required) {
            if (!$this->masterSchoolId->IsDetailKey && EmptyValue($this->masterSchoolId->FormValue)) {
                $this->masterSchoolId->addErrorMessage(str_replace("%s", $this->masterSchoolId->caption(), $this->masterSchoolId->RequiredErrorMessage));
            }
        }
        if ($this->school->Required) {
            if (!$this->school->IsDetailKey && EmptyValue($this->school->FormValue)) {
                $this->school->addErrorMessage(str_replace("%s", $this->school->caption(), $this->school->RequiredErrorMessage));
            }
        }
        if ($this->countryId->Required) {
            if (!$this->countryId->IsDetailKey && EmptyValue($this->countryId->FormValue)) {
                $this->countryId->addErrorMessage(str_replace("%s", $this->countryId->caption(), $this->countryId->RequiredErrorMessage));
            }
        }
        if ($this->cityId->Required) {
            if (!$this->cityId->IsDetailKey && EmptyValue($this->cityId->FormValue)) {
                $this->cityId->addErrorMessage(str_replace("%s", $this->cityId->caption(), $this->cityId->RequiredErrorMessage));
            }
        }
        if ($this->owner->Required) {
            if (!$this->owner->IsDetailKey && EmptyValue($this->owner->FormValue)) {
                $this->owner->addErrorMessage(str_replace("%s", $this->owner->caption(), $this->owner->RequiredErrorMessage));
            }
        }
        if ($this->applicationId->Required) {
            if (!$this->applicationId->IsDetailKey && EmptyValue($this->applicationId->FormValue)) {
                $this->applicationId->addErrorMessage(str_replace("%s", $this->applicationId->caption(), $this->applicationId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->applicationId->FormValue)) {
            $this->applicationId->addErrorMessage($this->applicationId->getErrorMessage(false));
        }
        if ($this->isheadquarter->Required) {
            if ($this->isheadquarter->FormValue == "") {
                $this->isheadquarter->addErrorMessage(str_replace("%s", $this->isheadquarter->caption(), $this->isheadquarter->RequiredErrorMessage));
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

        // masterSchoolId
        $this->masterSchoolId->setDbValueDef($rsnew, $this->masterSchoolId->CurrentValue, null, $this->masterSchoolId->ReadOnly);

        // school
        $this->school->setDbValueDef($rsnew, $this->school->CurrentValue, null, $this->school->ReadOnly);

        // countryId
        $this->countryId->setDbValueDef($rsnew, $this->countryId->CurrentValue, null, $this->countryId->ReadOnly);

        // cityId
        $this->cityId->setDbValueDef($rsnew, $this->cityId->CurrentValue, null, $this->cityId->ReadOnly);

        // owner
        $this->owner->setDbValueDef($rsnew, $this->owner->CurrentValue, null, $this->owner->ReadOnly);

        // applicationId
        if ($this->applicationId->getSessionValue() != "") {
            $this->applicationId->ReadOnly = true;
        }
        $this->applicationId->setDbValueDef($rsnew, $this->applicationId->CurrentValue, null, $this->applicationId->ReadOnly);

        // isheadquarter
        $tmpBool = $this->isheadquarter->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->isheadquarter->setDbValueDef($rsnew, $tmpBool, null, $this->isheadquarter->ReadOnly);

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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "fed_applicationschool") {
            $this->applicationId->CurrentValue = $this->applicationId->getSessionValue();
        }

        // Set new row
        $rsnew = [];

        // masterSchoolId
        $this->masterSchoolId->setDbValueDef($rsnew, $this->masterSchoolId->CurrentValue, null, false);

        // school
        $this->school->setDbValueDef($rsnew, $this->school->CurrentValue, null, false);

        // countryId
        $this->countryId->setDbValueDef($rsnew, $this->countryId->CurrentValue, null, false);

        // cityId
        $this->cityId->setDbValueDef($rsnew, $this->cityId->CurrentValue, null, false);

        // owner
        $this->owner->setDbValueDef($rsnew, $this->owner->CurrentValue, null, false);

        // applicationId
        $this->applicationId->setDbValueDef($rsnew, $this->applicationId->CurrentValue, null, false);

        // isheadquarter
        $tmpBool = $this->isheadquarter->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->isheadquarter->setDbValueDef($rsnew, $tmpBool, null, false);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->id->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->id->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->id->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "fed_applicationschool") {
            $masterTbl = Container("fed_applicationschool");
            $this->applicationId->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
}
