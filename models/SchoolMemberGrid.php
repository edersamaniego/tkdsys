<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SchoolMemberGrid extends SchoolMember
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'school_member';

    // Page object name
    public $PageObjName = "SchoolMemberGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fschool_membergrid";
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

        // Table object (school_member)
        if (!isset($GLOBALS["school_member"]) || get_class($GLOBALS["school_member"]) == PROJECT_NAMESPACE . "school_member") {
            $GLOBALS["school_member"] = &$this;
        }
        $this->AddUrl = "SchoolMemberAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'school_member');
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
                $tbl = Container("school_member");
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
		        $this->photo->OldUploadPath = "files/fotos";
		        $this->photo->UploadPath = $this->photo->OldUploadPath;
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
        if ($this->isAddOrEdit()) {
            $this->createDate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->createUserId->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->lastUpdate->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->lastUserId->Visible = false;
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
        $this->name->setVisibility();
        $this->lastName->setVisibility();
        $this->birthdate->Visible = false;
        $this->gender->Visible = false;
        $this->address->Visible = false;
        $this->neighborhood->Visible = false;
        $this->countryId->Visible = false;
        $this->UFId->Visible = false;
        $this->cityId->Visible = false;
        $this->zip->Visible = false;
        $this->celphone->Visible = false;
        $this->_email->Visible = false;
        $this->facebook->Visible = false;
        $this->instagram->Visible = false;
        $this->father->Visible = false;
        $this->fatherCellphone->Visible = false;
        $this->receiveSmsFather->Visible = false;
        $this->fatherEmail->Visible = false;
        $this->receiveEmailFather->Visible = false;
        $this->fatherOccupation->Visible = false;
        $this->fatherBirthdate->Visible = false;
        $this->mother->Visible = false;
        $this->motherCellphone->Visible = false;
        $this->receiveSmsMother->Visible = false;
        $this->motherEmail->Visible = false;
        $this->receiveEmailMother->Visible = false;
        $this->motherOccupation->Visible = false;
        $this->motherBirthdate->Visible = false;
        $this->emergencyContact->Visible = false;
        $this->emergencyFone->Visible = false;
        $this->obs->Visible = false;
        $this->modalityId->Visible = false;
        $this->instructorStatus->Visible = false;
        $this->martialArtId->setVisibility();
        $this->rankId->setVisibility();
        $this->schoolId->Visible = false;
        $this->memberStatusId->Visible = false;
        $this->photo->setVisibility();
        $this->beltSize->Visible = false;
        $this->dobokSize->Visible = false;
        $this->programId->Visible = false;
        $this->classId->Visible = false;
        $this->federationRegister->Visible = false;
        $this->memberLevelId->Visible = false;
        $this->instructorLevelId->Visible = false;
        $this->judgeLevelId->Visible = false;
        $this->federationRegisterDate->Visible = false;
        $this->federationStatus->Visible = false;
        $this->createDate->Visible = false;
        $this->createUserId->Visible = false;
        $this->lastUpdate->Visible = false;
        $this->lastUserId->Visible = false;
        $this->marketingSourceId->Visible = false;
        $this->marketingSourceDetail->Visible = false;
        $this->memberTypeId->Visible = false;
        $this->schoolUserId->Visible = false;
        $this->age->Visible = false;
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
        $this->setupLookupOptions($this->gender);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->receiveSmsFather);
        $this->setupLookupOptions($this->receiveEmailFather);
        $this->setupLookupOptions($this->receiveSmsMother);
        $this->setupLookupOptions($this->receiveEmailMother);
        $this->setupLookupOptions($this->modalityId);
        $this->setupLookupOptions($this->instructorStatus);
        $this->setupLookupOptions($this->martialArtId);
        $this->setupLookupOptions($this->rankId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->memberStatusId);
        $this->setupLookupOptions($this->programId);
        $this->setupLookupOptions($this->classId);
        $this->setupLookupOptions($this->memberLevelId);
        $this->setupLookupOptions($this->instructorLevelId);
        $this->setupLookupOptions($this->judgeLevelId);
        $this->setupLookupOptions($this->federationStatus);
        $this->setupLookupOptions($this->marketingSourceId);

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

        // Add master User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
                if ($this->getCurrentMasterTable() == "fed_school") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "fed_school"); // Add master User ID filter
                }
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "fed_school") {
            $masterTbl = Container("fed_school");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("FedSchoolList"); // Return to master page
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
            $CurrentForm->hasValue("x_name") &&
            $CurrentForm->hasValue("o_name") &&
            $this->name->CurrentValue != $this->name->DefaultValue &&
            !($this->name->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->name->CurrentValue == $this->name->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_lastName") &&
            $CurrentForm->hasValue("o_lastName") &&
            $this->lastName->CurrentValue != $this->lastName->DefaultValue &&
            !($this->lastName->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->lastName->CurrentValue == $this->lastName->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_martialArtId") &&
            $CurrentForm->hasValue("o_martialArtId") &&
            $this->martialArtId->CurrentValue != $this->martialArtId->DefaultValue &&
            !($this->martialArtId->IsForeignKey && $this->getCurrentMasterTable() != "" &&
            $this->martialArtId->CurrentValue == $this->martialArtId->getSessionValue())
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
        if (!EmptyValue($this->photo->Upload->Value)) {
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
        $this->name->clearErrorMessage();
        $this->lastName->clearErrorMessage();
        $this->martialArtId->clearErrorMessage();
        $this->rankId->clearErrorMessage();
        $this->photo->clearErrorMessage();
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
                        $this->schoolId->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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
        $this->photo->Upload->Index = $CurrentForm->Index;
        $this->photo->Upload->uploadFile();
        $this->photo->CurrentValue = $this->photo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->instructorStatus->DefaultValue = 0;
        $this->instructorStatus->OldValue = $this->instructorStatus->DefaultValue;
        $this->schoolId->DefaultValue = CurrentUserID();
        $this->schoolId->OldValue = $this->schoolId->DefaultValue;
        $this->photo->Upload->Index = $this->RowIndex;
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

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_name")) {
            $this->name->setOldValue($CurrentForm->getValue("o_name"));
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
        if ($CurrentForm->hasValue("o_lastName")) {
            $this->lastName->setOldValue($CurrentForm->getValue("o_lastName"));
        }

        // Check field name 'martialArtId' first before field var 'x_martialArtId'
        $val = $CurrentForm->hasValue("martialArtId") ? $CurrentForm->getValue("martialArtId") : $CurrentForm->getValue("x_martialArtId");
        if (!$this->martialArtId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->martialArtId->Visible = false; // Disable update for API request
            } else {
                $this->martialArtId->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_martialArtId")) {
            $this->martialArtId->setOldValue($CurrentForm->getValue("o_martialArtId"));
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
		$this->photo->OldUploadPath = "files/fotos";
		$this->photo->UploadPath = $this->photo->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->name->CurrentValue = $this->name->FormValue;
        $this->lastName->CurrentValue = $this->lastName->FormValue;
        $this->martialArtId->CurrentValue = $this->martialArtId->FormValue;
        $this->rankId->CurrentValue = $this->rankId->FormValue;
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
        $this->birthdate->setDbValue($row['birthdate']);
        $this->gender->setDbValue($row['gender']);
        $this->address->setDbValue($row['address']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->countryId->setDbValue($row['countryId']);
        if (array_key_exists('EV__countryId', $row)) {
            $this->countryId->VirtualValue = $row['EV__countryId']; // Set up virtual field value
        } else {
            $this->countryId->VirtualValue = ""; // Clear value
        }
        $this->UFId->setDbValue($row['UFId']);
        if (array_key_exists('EV__UFId', $row)) {
            $this->UFId->VirtualValue = $row['EV__UFId']; // Set up virtual field value
        } else {
            $this->UFId->VirtualValue = ""; // Clear value
        }
        $this->cityId->setDbValue($row['cityId']);
        if (array_key_exists('EV__cityId', $row)) {
            $this->cityId->VirtualValue = $row['EV__cityId']; // Set up virtual field value
        } else {
            $this->cityId->VirtualValue = ""; // Clear value
        }
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
        $this->modalityId->setDbValue($row['modalityId']);
        if (array_key_exists('EV__modalityId', $row)) {
            $this->modalityId->VirtualValue = $row['EV__modalityId']; // Set up virtual field value
        } else {
            $this->modalityId->VirtualValue = ""; // Clear value
        }
        $this->instructorStatus->setDbValue($row['instructorStatus']);
        $this->martialArtId->setDbValue($row['martialArtId']);
        $this->rankId->setDbValue($row['rankId']);
        $this->schoolId->setDbValue($row['schoolId']);
        if (array_key_exists('EV__schoolId', $row)) {
            $this->schoolId->VirtualValue = $row['EV__schoolId']; // Set up virtual field value
        } else {
            $this->schoolId->VirtualValue = ""; // Clear value
        }
        $this->memberStatusId->setDbValue($row['memberStatusId']);
        $this->photo->Upload->DbValue = $row['photo'];
        $this->photo->setDbValue($this->photo->Upload->DbValue);
        $this->photo->Upload->Index = $this->RowIndex;
        $this->beltSize->setDbValue($row['beltSize']);
        $this->dobokSize->setDbValue($row['dobokSize']);
        $this->programId->setDbValue($row['programId']);
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
        $this->marketingSourceId->setDbValue($row['marketingSourceId']);
        $this->marketingSourceDetail->setDbValue($row['marketingSourceDetail']);
        $this->memberTypeId->setDbValue($row['memberTypeId']);
        $this->schoolUserId->setDbValue($row['schoolUserId']);
        $this->age->setDbValue($row['age']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['lastName'] = $this->lastName->DefaultValue;
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
        $row['modalityId'] = $this->modalityId->DefaultValue;
        $row['instructorStatus'] = $this->instructorStatus->DefaultValue;
        $row['martialArtId'] = $this->martialArtId->DefaultValue;
        $row['rankId'] = $this->rankId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['memberStatusId'] = $this->memberStatusId->DefaultValue;
        $row['photo'] = $this->photo->DefaultValue;
        $row['beltSize'] = $this->beltSize->DefaultValue;
        $row['dobokSize'] = $this->dobokSize->DefaultValue;
        $row['programId'] = $this->programId->DefaultValue;
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
        $row['marketingSourceId'] = $this->marketingSourceId->DefaultValue;
        $row['marketingSourceDetail'] = $this->marketingSourceDetail->DefaultValue;
        $row['memberTypeId'] = $this->memberTypeId->DefaultValue;
        $row['schoolUserId'] = $this->schoolUserId->DefaultValue;
        $row['age'] = $this->age->DefaultValue;
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

        // name

        // lastName

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

        // modalityId

        // instructorStatus

        // martialArtId

        // rankId

        // schoolId

        // memberStatusId

        // photo

        // beltSize

        // dobokSize

        // programId

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

        // marketingSourceId

        // marketingSourceDetail

        // memberTypeId

        // schoolUserId

        // age

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

            // birthdate
            $this->birthdate->ViewValue = $this->birthdate->CurrentValue;
            $this->birthdate->ViewValue = FormatDateTime($this->birthdate->ViewValue, $this->birthdate->formatPattern());
            $this->birthdate->ViewCustomAttributes = "";

            // gender
            if (strval($this->gender->CurrentValue) != "") {
                $this->gender->ViewValue = $this->gender->optionCaption($this->gender->CurrentValue);
            } else {
                $this->gender->ViewValue = null;
            }
            $this->gender->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // countryId
            if ($this->countryId->VirtualValue != "") {
                $this->countryId->ViewValue = $this->countryId->VirtualValue;
            } else {
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
            }
            $this->countryId->ViewCustomAttributes = "";

            // UFId
            if ($this->UFId->VirtualValue != "") {
                $this->UFId->ViewValue = $this->UFId->VirtualValue;
            } else {
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
            if (strval($this->receiveSmsFather->CurrentValue) != "") {
                $this->receiveSmsFather->ViewValue = $this->receiveSmsFather->optionCaption($this->receiveSmsFather->CurrentValue);
            } else {
                $this->receiveSmsFather->ViewValue = null;
            }
            $this->receiveSmsFather->ViewCustomAttributes = "";

            // fatherEmail
            $this->fatherEmail->ViewValue = $this->fatherEmail->CurrentValue;
            $this->fatherEmail->ViewCustomAttributes = "";

            // receiveEmailFather
            if (strval($this->receiveEmailFather->CurrentValue) != "") {
                $this->receiveEmailFather->ViewValue = $this->receiveEmailFather->optionCaption($this->receiveEmailFather->CurrentValue);
            } else {
                $this->receiveEmailFather->ViewValue = null;
            }
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
            if (strval($this->receiveSmsMother->CurrentValue) != "") {
                $this->receiveSmsMother->ViewValue = $this->receiveSmsMother->optionCaption($this->receiveSmsMother->CurrentValue);
            } else {
                $this->receiveSmsMother->ViewValue = null;
            }
            $this->receiveSmsMother->ViewCustomAttributes = "";

            // motherEmail
            $this->motherEmail->ViewValue = $this->motherEmail->CurrentValue;
            $this->motherEmail->ViewCustomAttributes = "";

            // receiveEmailMother
            if (strval($this->receiveEmailMother->CurrentValue) != "") {
                $this->receiveEmailMother->ViewValue = $this->receiveEmailMother->optionCaption($this->receiveEmailMother->CurrentValue);
            } else {
                $this->receiveEmailMother->ViewValue = null;
            }
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

            // modalityId
            if ($this->modalityId->VirtualValue != "") {
                $this->modalityId->ViewValue = $this->modalityId->VirtualValue;
            } else {
                $curVal = strval($this->modalityId->CurrentValue);
                if ($curVal != "") {
                    $this->modalityId->ViewValue = $this->modalityId->lookupCacheOption($curVal);
                    if ($this->modalityId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->modalityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->modalityId->Lookup->renderViewRow($rswrk[0]);
                            $this->modalityId->ViewValue = $this->modalityId->displayValue($arwrk);
                        } else {
                            $this->modalityId->ViewValue = FormatNumber($this->modalityId->CurrentValue, $this->modalityId->formatPattern());
                        }
                    }
                } else {
                    $this->modalityId->ViewValue = null;
                }
            }
            $this->modalityId->ViewCustomAttributes = "";

            // instructorStatus
            if (ConvertToBool($this->instructorStatus->CurrentValue)) {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(1) != "" ? $this->instructorStatus->tagCaption(1) : "Yes";
            } else {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(2) != "" ? $this->instructorStatus->tagCaption(2) : "No";
            }
            $this->instructorStatus->ViewCustomAttributes = "";

            // martialArtId
            $curVal = strval($this->martialArtId->CurrentValue);
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
                if ($this->martialArtId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialArtId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialArtId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialArtId->ViewValue = $this->martialArtId->displayValue($arwrk);
                    } else {
                        $this->martialArtId->ViewValue = FormatNumber($this->martialArtId->CurrentValue, $this->martialArtId->formatPattern());
                    }
                }
            } else {
                $this->martialArtId->ViewValue = null;
            }
            $this->martialArtId->ViewCustomAttributes = "";

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

            // schoolId
            if ($this->schoolId->VirtualValue != "") {
                $this->schoolId->ViewValue = $this->schoolId->VirtualValue;
            } else {
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
            }
            $this->schoolId->ViewCustomAttributes = "";

            // memberStatusId
            $curVal = strval($this->memberStatusId->CurrentValue);
            if ($curVal != "") {
                $this->memberStatusId->ViewValue = $this->memberStatusId->lookupCacheOption($curVal);
                if ($this->memberStatusId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberStatusId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberStatusId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberStatusId->ViewValue = $this->memberStatusId->displayValue($arwrk);
                    } else {
                        $this->memberStatusId->ViewValue = FormatNumber($this->memberStatusId->CurrentValue, $this->memberStatusId->formatPattern());
                    }
                }
            } else {
                $this->memberStatusId->ViewValue = null;
            }
            $this->memberStatusId->ViewCustomAttributes = "";

            // photo
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->ImageWidth = 80;
                $this->photo->ImageHeight = 90;
                $this->photo->ImageAlt = $this->photo->alt();
                $this->photo->ImageCssClass = "ew-image";
                $this->photo->ViewValue = $this->photo->Upload->DbValue;
            } else {
                $this->photo->ViewValue = "";
            }
            $this->photo->ViewCustomAttributes = "";

            // beltSize
            $this->beltSize->ViewValue = $this->beltSize->CurrentValue;
            $this->beltSize->ViewCustomAttributes = "";

            // dobokSize
            $this->dobokSize->ViewValue = $this->dobokSize->CurrentValue;
            $this->dobokSize->ViewCustomAttributes = "";

            // programId
            $curVal = strval($this->programId->CurrentValue);
            if ($curVal != "") {
                $this->programId->ViewValue = $this->programId->lookupCacheOption($curVal);
                if ($this->programId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->programId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->programId->Lookup->renderViewRow($rswrk[0]);
                        $this->programId->ViewValue = $this->programId->displayValue($arwrk);
                    } else {
                        $this->programId->ViewValue = FormatNumber($this->programId->CurrentValue, $this->programId->formatPattern());
                    }
                }
            } else {
                $this->programId->ViewValue = null;
            }
            $this->programId->ViewCustomAttributes = "";

            // classId
            $curVal = strval($this->classId->CurrentValue);
            if ($curVal != "") {
                $this->classId->ViewValue = $this->classId->lookupCacheOption($curVal);
                if ($this->classId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->classId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->classId->Lookup->renderViewRow($rswrk[0]);
                        $this->classId->ViewValue = $this->classId->displayValue($arwrk);
                    } else {
                        $this->classId->ViewValue = FormatNumber($this->classId->CurrentValue, $this->classId->formatPattern());
                    }
                }
            } else {
                $this->classId->ViewValue = null;
            }
            $this->classId->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // memberLevelId
            $curVal = strval($this->memberLevelId->CurrentValue);
            if ($curVal != "") {
                $this->memberLevelId->ViewValue = $this->memberLevelId->lookupCacheOption($curVal);
                if ($this->memberLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberLevelId->ViewValue = $this->memberLevelId->displayValue($arwrk);
                    } else {
                        $this->memberLevelId->ViewValue = FormatNumber($this->memberLevelId->CurrentValue, $this->memberLevelId->formatPattern());
                    }
                }
            } else {
                $this->memberLevelId->ViewValue = null;
            }
            $this->memberLevelId->ViewCustomAttributes = "";

            // instructorLevelId
            $curVal = strval($this->instructorLevelId->CurrentValue);
            if ($curVal != "") {
                $this->instructorLevelId->ViewValue = $this->instructorLevelId->lookupCacheOption($curVal);
                if ($this->instructorLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->instructorLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->instructorLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->instructorLevelId->ViewValue = $this->instructorLevelId->displayValue($arwrk);
                    } else {
                        $this->instructorLevelId->ViewValue = FormatNumber($this->instructorLevelId->CurrentValue, $this->instructorLevelId->formatPattern());
                    }
                }
            } else {
                $this->instructorLevelId->ViewValue = null;
            }
            $this->instructorLevelId->ViewCustomAttributes = "";

            // judgeLevelId
            $curVal = strval($this->judgeLevelId->CurrentValue);
            if ($curVal != "") {
                $this->judgeLevelId->ViewValue = $this->judgeLevelId->lookupCacheOption($curVal);
                if ($this->judgeLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->judgeLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->judgeLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->judgeLevelId->ViewValue = $this->judgeLevelId->displayValue($arwrk);
                    } else {
                        $this->judgeLevelId->ViewValue = FormatNumber($this->judgeLevelId->CurrentValue, $this->judgeLevelId->formatPattern());
                    }
                }
            } else {
                $this->judgeLevelId->ViewValue = null;
            }
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

            // marketingSourceId
            $curVal = strval($this->marketingSourceId->CurrentValue);
            if ($curVal != "") {
                $this->marketingSourceId->ViewValue = $this->marketingSourceId->lookupCacheOption($curVal);
                if ($this->marketingSourceId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->marketingSourceId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->marketingSourceId->Lookup->renderViewRow($rswrk[0]);
                        $this->marketingSourceId->ViewValue = $this->marketingSourceId->displayValue($arwrk);
                    } else {
                        $this->marketingSourceId->ViewValue = FormatNumber($this->marketingSourceId->CurrentValue, $this->marketingSourceId->formatPattern());
                    }
                }
            } else {
                $this->marketingSourceId->ViewValue = null;
            }
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

            // age
            $this->age->ViewValue = $this->age->CurrentValue;
            $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
            $this->age->ViewCustomAttributes = "";

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

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";
            $this->martialArtId->TooltipValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";
            $this->rankId->TooltipValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
                $this->photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
                }
            } else {
                $this->photo->HrefValue = "";
            }
            $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;
            $this->photo->TooltipValue = "";
            if ($this->photo->UseColorbox) {
                if (EmptyValue($this->photo->TooltipValue)) {
                    $this->photo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->photo->LinkAttrs["data-rel"] = "school_member_x" . $this->RowCount . "_photo";
                $this->photo->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

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

            // martialArtId
            $this->martialArtId->setupEditAttributes();
            $this->martialArtId->EditCustomAttributes = "";
            $curVal = trim(strval($this->martialArtId->CurrentValue));
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
            } else {
                $this->martialArtId->ViewValue = $this->martialArtId->Lookup !== null && is_array($this->martialArtId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialArtId->ViewValue !== null) { // Load from cache
                $this->martialArtId->EditValue = array_values($this->martialArtId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialArtId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialArtId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialArtId->EditValue = $arwrk;
            }
            $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

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

            // photo
            $this->photo->setupEditAttributes();
            $this->photo->EditCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->ImageWidth = 80;
                $this->photo->ImageHeight = 90;
                $this->photo->ImageAlt = $this->photo->alt();
                $this->photo->ImageCssClass = "ew-image";
                $this->photo->EditValue = $this->photo->Upload->DbValue;
            } else {
                $this->photo->EditValue = "";
            }
            if (!EmptyValue($this->photo->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->photo->Upload->FileName = "";
                } else {
                    $this->photo->Upload->FileName = $this->photo->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->photo, $this->RowIndex);
            }

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
                $this->photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
                }
            } else {
                $this->photo->HrefValue = "";
            }
            $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;
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

            // martialArtId
            $this->martialArtId->setupEditAttributes();
            $this->martialArtId->EditCustomAttributes = "";
            $curVal = trim(strval($this->martialArtId->CurrentValue));
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
            } else {
                $this->martialArtId->ViewValue = $this->martialArtId->Lookup !== null && is_array($this->martialArtId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialArtId->ViewValue !== null) { // Load from cache
                $this->martialArtId->EditValue = array_values($this->martialArtId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialArtId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialArtId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialArtId->EditValue = $arwrk;
            }
            $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

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

            // photo
            $this->photo->setupEditAttributes();
            $this->photo->EditCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->ImageWidth = 80;
                $this->photo->ImageHeight = 90;
                $this->photo->ImageAlt = $this->photo->alt();
                $this->photo->ImageCssClass = "ew-image";
                $this->photo->EditValue = $this->photo->Upload->DbValue;
            } else {
                $this->photo->EditValue = "";
            }
            if (!EmptyValue($this->photo->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->photo->Upload->FileName = "";
                } else {
                    $this->photo->Upload->FileName = $this->photo->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->photo, $this->RowIndex);
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

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
                $this->photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
                }
            } else {
                $this->photo->HrefValue = "";
            }
            $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;
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
        if ($this->martialArtId->Required) {
            if (!$this->martialArtId->IsDetailKey && EmptyValue($this->martialArtId->FormValue)) {
                $this->martialArtId->addErrorMessage(str_replace("%s", $this->martialArtId->caption(), $this->martialArtId->RequiredErrorMessage));
            }
        }
        if ($this->rankId->Required) {
            if (!$this->rankId->IsDetailKey && EmptyValue($this->rankId->FormValue)) {
                $this->rankId->addErrorMessage(str_replace("%s", $this->rankId->caption(), $this->rankId->RequiredErrorMessage));
            }
        }
        if ($this->photo->Required) {
            if ($this->photo->Upload->FileName == "" && !$this->photo->Upload->KeepFile) {
                $this->photo->addErrorMessage(str_replace("%s", $this->photo->caption(), $this->photo->RequiredErrorMessage));
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
            $this->photo->OldUploadPath = "files/fotos";
            $this->photo->UploadPath = $this->photo->OldUploadPath;
        }

        // Set new row
        $rsnew = [];

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, null, $this->name->ReadOnly);

        // lastName
        $this->lastName->setDbValueDef($rsnew, $this->lastName->CurrentValue, null, $this->lastName->ReadOnly);

        // martialArtId
        $this->martialArtId->setDbValueDef($rsnew, $this->martialArtId->CurrentValue, null, $this->martialArtId->ReadOnly);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, $this->rankId->ReadOnly);

        // photo
        if ($this->photo->Visible && !$this->photo->ReadOnly && !$this->photo->Upload->KeepFile) {
            $this->photo->Upload->DbValue = $rsold['photo']; // Get original value
            if ($this->photo->Upload->FileName == "") {
                $rsnew['photo'] = null;
            } else {
                $rsnew['photo'] = $this->photo->Upload->FileName;
            }
            $this->photo->ImageWidth = 300; // Resize width
            $this->photo->ImageHeight = 0; // Resize height
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
            $this->photo->UploadPath = "files/fotos";
            $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
            if (!EmptyValue($this->photo->Upload->FileName)) {
                $newFiles = [$this->photo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->photo, $this->photo->Upload->Index);
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
                            $file1 = UniqueFilename($this->photo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->photo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->photo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->photo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->photo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->photo->setDbValueDef($rsnew, $this->photo->Upload->FileName, null, $this->photo->ReadOnly);
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
                if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
                    if (!EmptyValue($this->photo->Upload->FileName)) {
                        $newFiles = [$this->photo->Upload->FileName];
                        $newFiles2 = [$this->photo->htmlDecode($rsnew['photo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->photo, $this->photo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->photo->Upload->ResizeAndSaveToFile($this->photo->ImageWidth, $this->photo->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                @unlink($this->photo->oldPhysicalUploadPath() . $oldFile);
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
            // photo
            CleanUploadTempPath($this->photo, $this->photo->Upload->Index);
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
        if ($this->getCurrentMasterTable() == "fed_school") {
            $this->schoolId->CurrentValue = $this->schoolId->getSessionValue();
        }

        // Set new row
        $rsnew = [];

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, null, false);

        // lastName
        $this->lastName->setDbValueDef($rsnew, $this->lastName->CurrentValue, null, false);

        // martialArtId
        $this->martialArtId->setDbValueDef($rsnew, $this->martialArtId->CurrentValue, null, false);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, false);

        // photo
        if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
            $this->photo->Upload->DbValue = ""; // No need to delete old file
            if ($this->photo->Upload->FileName == "") {
                $rsnew['photo'] = null;
            } else {
                $rsnew['photo'] = $this->photo->Upload->FileName;
            }
            $this->photo->ImageWidth = 300; // Resize width
            $this->photo->ImageHeight = 0; // Resize height
        }

        // schoolId
        if ($this->schoolId->getSessionValue() != "") {
            $rsnew['schoolId'] = $this->schoolId->getSessionValue();
        } elseif (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['schoolId'] = CurrentUserID();
        }
        if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
            $this->photo->UploadPath = "files/fotos";
            $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
            if (!EmptyValue($this->photo->Upload->FileName)) {
                $newFiles = [$this->photo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->photo, $this->photo->Upload->Index);
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
                            $file1 = UniqueFilename($this->photo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->photo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->photo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->photo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->photo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->photo->setDbValueDef($rsnew, $this->photo->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->schoolId->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->schoolId->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->schoolId->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $detailKeys = [];
            $detailKeys["schoolId"] = $this->schoolId->CurrentValue;
            $masterTable = Container("fed_school");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $validMasterKey = true;
                if ($rsmaster = $masterTable->loadRs($masterFilter)->fetchAssociative()) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['id']);
                } elseif ($this->getCurrentMasterTable() == "fed_school") {
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
        $this->photo->OldUploadPath = "files/fotos";
        $this->photo->UploadPath = $this->photo->OldUploadPath;

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
                    if (!EmptyValue($this->photo->Upload->FileName)) {
                        $newFiles = [$this->photo->Upload->FileName];
                        $newFiles2 = [$this->photo->htmlDecode($rsnew['photo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->photo, $this->photo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->photo->Upload->ResizeAndSaveToFile($this->photo->ImageWidth, $this->photo->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                @unlink($this->photo->oldPhysicalUploadPath() . $oldFile);
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
            // photo
            CleanUploadTempPath($this->photo, $this->photo->Upload->Index);
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
            return $Security->isValidUserID($this->schoolId->CurrentValue);
        }
        return true;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "fed_school") {
            $masterTbl = Container("fed_school");
            $this->schoolId->Visible = false;
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
                case "x_gender":
                    break;
                case "x_countryId":
                    break;
                case "x_UFId":
                    break;
                case "x_cityId":
                    break;
                case "x_receiveSmsFather":
                    break;
                case "x_receiveEmailFather":
                    break;
                case "x_receiveSmsMother":
                    break;
                case "x_receiveEmailMother":
                    break;
                case "x_modalityId":
                    break;
                case "x_instructorStatus":
                    break;
                case "x_martialArtId":
                    break;
                case "x_rankId":
                    break;
                case "x_schoolId":
                    break;
                case "x_memberStatusId":
                    break;
                case "x_programId":
                    break;
                case "x_classId":
                    break;
                case "x_memberLevelId":
                    break;
                case "x_instructorLevelId":
                    break;
                case "x_judgeLevelId":
                    break;
                case "x_federationStatus":
                    break;
                case "x_marketingSourceId":
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
