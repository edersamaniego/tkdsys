<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedSchoolEdit extends FedSchool
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_school';

    // Page object name
    public $PageObjName = "FedSchoolEdit";

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

        // Table object (fed_school)
        if (!isset($GLOBALS["fed_school"]) || get_class($GLOBALS["fed_school"]) == PROJECT_NAMESPACE . "fed_school") {
            $GLOBALS["fed_school"] = &$this;
        }

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "FedSchoolView") {
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
    public $DetailPages; // Detail pages object

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
        $this->federationId->Visible = false;
        $this->masterSchoolId->Visible = false;
        $this->school->Visible = false;
        $this->countryId->setVisibility();
        $this->UFId->setVisibility();
        $this->cityId->setVisibility();
        $this->neighborhood->setVisibility();
        $this->address->setVisibility();
        $this->zipcode->setVisibility();
        $this->website->setVisibility();
        $this->_email->setVisibility();
        $this->phone->setVisibility();
        $this->celphone->setVisibility();
        $this->logo->setVisibility();
        $this->openingDate->setVisibility();
        $this->federationRegister->Visible = false;
        $this->createUserId->Visible = false;
        $this->createDate->Visible = false;
        $this->typeId->Visible = false;
        $this->owner->setVisibility();
        $this->identityNumber->setVisibility();
        $this->birthDateOwner->setVisibility();
        $this->ownerCountryId->setVisibility();
        $this->ownerStateId->setVisibility();
        $this->ownCityId->setVisibility();
        $this->ownerTelephone->setVisibility();
        $this->ownerTelephoneWork->setVisibility();
        $this->ownerProfession->setVisibility();
        $this->employer->setVisibility();
        $this->ownerGraduation->setVisibility();
        $this->ownerGraduationLocation->setVisibility();
        $this->ownerGraduationObs->setVisibility();
        $this->ownerMaritalStatus->setVisibility();
        $this->ownerSpouseName->setVisibility();
        $this->ownerSpouseProfession->setVisibility();
        $this->propertySituation->setVisibility();
        $this->numberOfStudentsInBeginnig->setVisibility();
        $this->ownerAbout->setVisibility();
        $this->pdfLicense->setVisibility();
        $this->applicationId->setVisibility();
        $this->isheadquarter->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->masterSchoolId);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->isheadquarter);

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
                        $this->terminate("FedSchoolList"); // Return to list page
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

            // Set up detail parameters
            $this->setupDetailParms();
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
                        $this->terminate("FedSchoolList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("FedSchoolList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "FedSchoolList") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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

        // Check field name 'countryId' first before field var 'x_countryId'
        $val = $CurrentForm->hasValue("countryId") ? $CurrentForm->getValue("countryId") : $CurrentForm->getValue("x_countryId");
        if (!$this->countryId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->countryId->Visible = false; // Disable update for API request
            } else {
                $this->countryId->setFormValue($val);
            }
        }

        // Check field name 'UFId' first before field var 'x_UFId'
        $val = $CurrentForm->hasValue("UFId") ? $CurrentForm->getValue("UFId") : $CurrentForm->getValue("x_UFId");
        if (!$this->UFId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UFId->Visible = false; // Disable update for API request
            } else {
                $this->UFId->setFormValue($val);
            }
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

        // Check field name 'neighborhood' first before field var 'x_neighborhood'
        $val = $CurrentForm->hasValue("neighborhood") ? $CurrentForm->getValue("neighborhood") : $CurrentForm->getValue("x_neighborhood");
        if (!$this->neighborhood->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->neighborhood->Visible = false; // Disable update for API request
            } else {
                $this->neighborhood->setFormValue($val);
            }
        }

        // Check field name 'address' first before field var 'x_address'
        $val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
        if (!$this->address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address->Visible = false; // Disable update for API request
            } else {
                $this->address->setFormValue($val);
            }
        }

        // Check field name 'zipcode' first before field var 'x_zipcode'
        $val = $CurrentForm->hasValue("zipcode") ? $CurrentForm->getValue("zipcode") : $CurrentForm->getValue("x_zipcode");
        if (!$this->zipcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->zipcode->Visible = false; // Disable update for API request
            } else {
                $this->zipcode->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
            }
        }

        // Check field name 'celphone' first before field var 'x_celphone'
        $val = $CurrentForm->hasValue("celphone") ? $CurrentForm->getValue("celphone") : $CurrentForm->getValue("x_celphone");
        if (!$this->celphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->celphone->Visible = false; // Disable update for API request
            } else {
                $this->celphone->setFormValue($val);
            }
        }

        // Check field name 'logo' first before field var 'x_logo'
        $val = $CurrentForm->hasValue("logo") ? $CurrentForm->getValue("logo") : $CurrentForm->getValue("x_logo");
        if (!$this->logo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->logo->Visible = false; // Disable update for API request
            } else {
                $this->logo->setFormValue($val);
            }
        }

        // Check field name 'openingDate' first before field var 'x_openingDate'
        $val = $CurrentForm->hasValue("openingDate") ? $CurrentForm->getValue("openingDate") : $CurrentForm->getValue("x_openingDate");
        if (!$this->openingDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->openingDate->Visible = false; // Disable update for API request
            } else {
                $this->openingDate->setFormValue($val, true, $validate);
            }
            $this->openingDate->CurrentValue = UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern());
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

        // Check field name 'identityNumber' first before field var 'x_identityNumber'
        $val = $CurrentForm->hasValue("identityNumber") ? $CurrentForm->getValue("identityNumber") : $CurrentForm->getValue("x_identityNumber");
        if (!$this->identityNumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->identityNumber->Visible = false; // Disable update for API request
            } else {
                $this->identityNumber->setFormValue($val);
            }
        }

        // Check field name 'birthDateOwner' first before field var 'x_birthDateOwner'
        $val = $CurrentForm->hasValue("birthDateOwner") ? $CurrentForm->getValue("birthDateOwner") : $CurrentForm->getValue("x_birthDateOwner");
        if (!$this->birthDateOwner->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->birthDateOwner->Visible = false; // Disable update for API request
            } else {
                $this->birthDateOwner->setFormValue($val, true, $validate);
            }
            $this->birthDateOwner->CurrentValue = UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern());
        }

        // Check field name 'ownerCountryId' first before field var 'x_ownerCountryId'
        $val = $CurrentForm->hasValue("ownerCountryId") ? $CurrentForm->getValue("ownerCountryId") : $CurrentForm->getValue("x_ownerCountryId");
        if (!$this->ownerCountryId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerCountryId->Visible = false; // Disable update for API request
            } else {
                $this->ownerCountryId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerStateId' first before field var 'x_ownerStateId'
        $val = $CurrentForm->hasValue("ownerStateId") ? $CurrentForm->getValue("ownerStateId") : $CurrentForm->getValue("x_ownerStateId");
        if (!$this->ownerStateId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerStateId->Visible = false; // Disable update for API request
            } else {
                $this->ownerStateId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownCityId' first before field var 'x_ownCityId'
        $val = $CurrentForm->hasValue("ownCityId") ? $CurrentForm->getValue("ownCityId") : $CurrentForm->getValue("x_ownCityId");
        if (!$this->ownCityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownCityId->Visible = false; // Disable update for API request
            } else {
                $this->ownCityId->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerTelephone' first before field var 'x_ownerTelephone'
        $val = $CurrentForm->hasValue("ownerTelephone") ? $CurrentForm->getValue("ownerTelephone") : $CurrentForm->getValue("x_ownerTelephone");
        if (!$this->ownerTelephone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerTelephone->Visible = false; // Disable update for API request
            } else {
                $this->ownerTelephone->setFormValue($val);
            }
        }

        // Check field name 'ownerTelephoneWork' first before field var 'x_ownerTelephoneWork'
        $val = $CurrentForm->hasValue("ownerTelephoneWork") ? $CurrentForm->getValue("ownerTelephoneWork") : $CurrentForm->getValue("x_ownerTelephoneWork");
        if (!$this->ownerTelephoneWork->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerTelephoneWork->Visible = false; // Disable update for API request
            } else {
                $this->ownerTelephoneWork->setFormValue($val);
            }
        }

        // Check field name 'ownerProfession' first before field var 'x_ownerProfession'
        $val = $CurrentForm->hasValue("ownerProfession") ? $CurrentForm->getValue("ownerProfession") : $CurrentForm->getValue("x_ownerProfession");
        if (!$this->ownerProfession->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerProfession->Visible = false; // Disable update for API request
            } else {
                $this->ownerProfession->setFormValue($val);
            }
        }

        // Check field name 'employer' first before field var 'x_employer'
        $val = $CurrentForm->hasValue("employer") ? $CurrentForm->getValue("employer") : $CurrentForm->getValue("x_employer");
        if (!$this->employer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->employer->Visible = false; // Disable update for API request
            } else {
                $this->employer->setFormValue($val);
            }
        }

        // Check field name 'ownerGraduation' first before field var 'x_ownerGraduation'
        $val = $CurrentForm->hasValue("ownerGraduation") ? $CurrentForm->getValue("ownerGraduation") : $CurrentForm->getValue("x_ownerGraduation");
        if (!$this->ownerGraduation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduation->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduation->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerGraduationLocation' first before field var 'x_ownerGraduationLocation'
        $val = $CurrentForm->hasValue("ownerGraduationLocation") ? $CurrentForm->getValue("ownerGraduationLocation") : $CurrentForm->getValue("x_ownerGraduationLocation");
        if (!$this->ownerGraduationLocation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduationLocation->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduationLocation->setFormValue($val);
            }
        }

        // Check field name 'ownerGraduationObs' first before field var 'x_ownerGraduationObs'
        $val = $CurrentForm->hasValue("ownerGraduationObs") ? $CurrentForm->getValue("ownerGraduationObs") : $CurrentForm->getValue("x_ownerGraduationObs");
        if (!$this->ownerGraduationObs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduationObs->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduationObs->setFormValue($val);
            }
        }

        // Check field name 'ownerMaritalStatus' first before field var 'x_ownerMaritalStatus'
        $val = $CurrentForm->hasValue("ownerMaritalStatus") ? $CurrentForm->getValue("ownerMaritalStatus") : $CurrentForm->getValue("x_ownerMaritalStatus");
        if (!$this->ownerMaritalStatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerMaritalStatus->Visible = false; // Disable update for API request
            } else {
                $this->ownerMaritalStatus->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerSpouseName' first before field var 'x_ownerSpouseName'
        $val = $CurrentForm->hasValue("ownerSpouseName") ? $CurrentForm->getValue("ownerSpouseName") : $CurrentForm->getValue("x_ownerSpouseName");
        if (!$this->ownerSpouseName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerSpouseName->Visible = false; // Disable update for API request
            } else {
                $this->ownerSpouseName->setFormValue($val);
            }
        }

        // Check field name 'ownerSpouseProfession' first before field var 'x_ownerSpouseProfession'
        $val = $CurrentForm->hasValue("ownerSpouseProfession") ? $CurrentForm->getValue("ownerSpouseProfession") : $CurrentForm->getValue("x_ownerSpouseProfession");
        if (!$this->ownerSpouseProfession->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerSpouseProfession->Visible = false; // Disable update for API request
            } else {
                $this->ownerSpouseProfession->setFormValue($val);
            }
        }

        // Check field name 'propertySituation' first before field var 'x_propertySituation'
        $val = $CurrentForm->hasValue("propertySituation") ? $CurrentForm->getValue("propertySituation") : $CurrentForm->getValue("x_propertySituation");
        if (!$this->propertySituation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->propertySituation->Visible = false; // Disable update for API request
            } else {
                $this->propertySituation->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'numberOfStudentsInBeginnig' first before field var 'x_numberOfStudentsInBeginnig'
        $val = $CurrentForm->hasValue("numberOfStudentsInBeginnig") ? $CurrentForm->getValue("numberOfStudentsInBeginnig") : $CurrentForm->getValue("x_numberOfStudentsInBeginnig");
        if (!$this->numberOfStudentsInBeginnig->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->numberOfStudentsInBeginnig->Visible = false; // Disable update for API request
            } else {
                $this->numberOfStudentsInBeginnig->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerAbout' first before field var 'x_ownerAbout'
        $val = $CurrentForm->hasValue("ownerAbout") ? $CurrentForm->getValue("ownerAbout") : $CurrentForm->getValue("x_ownerAbout");
        if (!$this->ownerAbout->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerAbout->Visible = false; // Disable update for API request
            } else {
                $this->ownerAbout->setFormValue($val);
            }
        }

        // Check field name 'pdfLicense' first before field var 'x_pdfLicense'
        $val = $CurrentForm->hasValue("pdfLicense") ? $CurrentForm->getValue("pdfLicense") : $CurrentForm->getValue("x_pdfLicense");
        if (!$this->pdfLicense->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pdfLicense->Visible = false; // Disable update for API request
            } else {
                $this->pdfLicense->setFormValue($val);
            }
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

        // Check field name 'isheadquarter' first before field var 'x_isheadquarter'
        $val = $CurrentForm->hasValue("isheadquarter") ? $CurrentForm->getValue("isheadquarter") : $CurrentForm->getValue("x_isheadquarter");
        if (!$this->isheadquarter->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isheadquarter->Visible = false; // Disable update for API request
            } else {
                $this->isheadquarter->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->countryId->CurrentValue = $this->countryId->FormValue;
        $this->UFId->CurrentValue = $this->UFId->FormValue;
        $this->cityId->CurrentValue = $this->cityId->FormValue;
        $this->neighborhood->CurrentValue = $this->neighborhood->FormValue;
        $this->address->CurrentValue = $this->address->FormValue;
        $this->zipcode->CurrentValue = $this->zipcode->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->celphone->CurrentValue = $this->celphone->FormValue;
        $this->logo->CurrentValue = $this->logo->FormValue;
        $this->openingDate->CurrentValue = $this->openingDate->FormValue;
        $this->openingDate->CurrentValue = UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern());
        $this->owner->CurrentValue = $this->owner->FormValue;
        $this->identityNumber->CurrentValue = $this->identityNumber->FormValue;
        $this->birthDateOwner->CurrentValue = $this->birthDateOwner->FormValue;
        $this->birthDateOwner->CurrentValue = UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern());
        $this->ownerCountryId->CurrentValue = $this->ownerCountryId->FormValue;
        $this->ownerStateId->CurrentValue = $this->ownerStateId->FormValue;
        $this->ownCityId->CurrentValue = $this->ownCityId->FormValue;
        $this->ownerTelephone->CurrentValue = $this->ownerTelephone->FormValue;
        $this->ownerTelephoneWork->CurrentValue = $this->ownerTelephoneWork->FormValue;
        $this->ownerProfession->CurrentValue = $this->ownerProfession->FormValue;
        $this->employer->CurrentValue = $this->employer->FormValue;
        $this->ownerGraduation->CurrentValue = $this->ownerGraduation->FormValue;
        $this->ownerGraduationLocation->CurrentValue = $this->ownerGraduationLocation->FormValue;
        $this->ownerGraduationObs->CurrentValue = $this->ownerGraduationObs->FormValue;
        $this->ownerMaritalStatus->CurrentValue = $this->ownerMaritalStatus->FormValue;
        $this->ownerSpouseName->CurrentValue = $this->ownerSpouseName->FormValue;
        $this->ownerSpouseProfession->CurrentValue = $this->ownerSpouseProfession->FormValue;
        $this->propertySituation->CurrentValue = $this->propertySituation->FormValue;
        $this->numberOfStudentsInBeginnig->CurrentValue = $this->numberOfStudentsInBeginnig->FormValue;
        $this->ownerAbout->CurrentValue = $this->ownerAbout->FormValue;
        $this->pdfLicense->CurrentValue = $this->pdfLicense->FormValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // federationId
        $this->federationId->RowCssClass = "row";

        // masterSchoolId
        $this->masterSchoolId->RowCssClass = "row";

        // school
        $this->school->RowCssClass = "row";

        // countryId
        $this->countryId->RowCssClass = "row";

        // UFId
        $this->UFId->RowCssClass = "row";

        // cityId
        $this->cityId->RowCssClass = "row";

        // neighborhood
        $this->neighborhood->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // zipcode
        $this->zipcode->RowCssClass = "row";

        // website
        $this->website->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // celphone
        $this->celphone->RowCssClass = "row";

        // logo
        $this->logo->RowCssClass = "row";

        // openingDate
        $this->openingDate->RowCssClass = "row";

        // federationRegister
        $this->federationRegister->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // typeId
        $this->typeId->RowCssClass = "row";

        // owner
        $this->owner->RowCssClass = "row";

        // identityNumber
        $this->identityNumber->RowCssClass = "row";

        // birthDateOwner
        $this->birthDateOwner->RowCssClass = "row";

        // ownerCountryId
        $this->ownerCountryId->RowCssClass = "row";

        // ownerStateId
        $this->ownerStateId->RowCssClass = "row";

        // ownCityId
        $this->ownCityId->RowCssClass = "row";

        // ownerTelephone
        $this->ownerTelephone->RowCssClass = "row";

        // ownerTelephoneWork
        $this->ownerTelephoneWork->RowCssClass = "row";

        // ownerProfession
        $this->ownerProfession->RowCssClass = "row";

        // employer
        $this->employer->RowCssClass = "row";

        // ownerGraduation
        $this->ownerGraduation->RowCssClass = "row";

        // ownerGraduationLocation
        $this->ownerGraduationLocation->RowCssClass = "row";

        // ownerGraduationObs
        $this->ownerGraduationObs->RowCssClass = "row";

        // ownerMaritalStatus
        $this->ownerMaritalStatus->RowCssClass = "row";

        // ownerSpouseName
        $this->ownerSpouseName->RowCssClass = "row";

        // ownerSpouseProfession
        $this->ownerSpouseProfession->RowCssClass = "row";

        // propertySituation
        $this->propertySituation->RowCssClass = "row";

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->RowCssClass = "row";

        // ownerAbout
        $this->ownerAbout->RowCssClass = "row";

        // pdfLicense
        $this->pdfLicense->RowCssClass = "row";

        // applicationId
        $this->applicationId->RowCssClass = "row";

        // isheadquarter
        $this->isheadquarter->RowCssClass = "row";

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

            // ownerGraduationObs
            $this->ownerGraduationObs->ViewValue = $this->ownerGraduationObs->CurrentValue;
            $this->ownerGraduationObs->ViewCustomAttributes = "";

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

            // ownerAbout
            $this->ownerAbout->ViewValue = $this->ownerAbout->CurrentValue;
            $this->ownerAbout->ViewCustomAttributes = "";

            // pdfLicense
            $this->pdfLicense->ViewValue = $this->pdfLicense->CurrentValue;
            $this->pdfLicense->ViewCustomAttributes = "";

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

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // zipcode
            $this->zipcode->LinkCustomAttributes = "";
            $this->zipcode->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            $this->logo->HrefValue = "";

            // openingDate
            $this->openingDate->LinkCustomAttributes = "";
            $this->openingDate->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // identityNumber
            $this->identityNumber->LinkCustomAttributes = "";
            $this->identityNumber->HrefValue = "";

            // birthDateOwner
            $this->birthDateOwner->LinkCustomAttributes = "";
            $this->birthDateOwner->HrefValue = "";

            // ownerCountryId
            $this->ownerCountryId->LinkCustomAttributes = "";
            $this->ownerCountryId->HrefValue = "";

            // ownerStateId
            $this->ownerStateId->LinkCustomAttributes = "";
            $this->ownerStateId->HrefValue = "";

            // ownCityId
            $this->ownCityId->LinkCustomAttributes = "";
            $this->ownCityId->HrefValue = "";

            // ownerTelephone
            $this->ownerTelephone->LinkCustomAttributes = "";
            $this->ownerTelephone->HrefValue = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->LinkCustomAttributes = "";
            $this->ownerTelephoneWork->HrefValue = "";

            // ownerProfession
            $this->ownerProfession->LinkCustomAttributes = "";
            $this->ownerProfession->HrefValue = "";

            // employer
            $this->employer->LinkCustomAttributes = "";
            $this->employer->HrefValue = "";

            // ownerGraduation
            $this->ownerGraduation->LinkCustomAttributes = "";
            $this->ownerGraduation->HrefValue = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->LinkCustomAttributes = "";
            $this->ownerGraduationLocation->HrefValue = "";

            // ownerGraduationObs
            $this->ownerGraduationObs->LinkCustomAttributes = "";
            $this->ownerGraduationObs->HrefValue = "";

            // ownerMaritalStatus
            $this->ownerMaritalStatus->LinkCustomAttributes = "";
            $this->ownerMaritalStatus->HrefValue = "";

            // ownerSpouseName
            $this->ownerSpouseName->LinkCustomAttributes = "";
            $this->ownerSpouseName->HrefValue = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->LinkCustomAttributes = "";
            $this->ownerSpouseProfession->HrefValue = "";

            // propertySituation
            $this->propertySituation->LinkCustomAttributes = "";
            $this->propertySituation->HrefValue = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->LinkCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->HrefValue = "";

            // ownerAbout
            $this->ownerAbout->LinkCustomAttributes = "";
            $this->ownerAbout->HrefValue = "";

            // pdfLicense
            $this->pdfLicense->LinkCustomAttributes = "";
            $this->pdfLicense->HrefValue = "";

            // applicationId
            $this->applicationId->LinkCustomAttributes = "";
            $this->applicationId->HrefValue = "";

            // isheadquarter
            $this->isheadquarter->LinkCustomAttributes = "";
            $this->isheadquarter->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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

            // UFId
            $this->UFId->setupEditAttributes();
            $this->UFId->EditCustomAttributes = "";
            $curVal = trim(strval($this->UFId->CurrentValue));
            if ($curVal != "") {
                $this->UFId->ViewValue = $this->UFId->lookupCacheOption($curVal);
            } else {
                $this->UFId->ViewValue = $this->UFId->Lookup !== null && is_array($this->UFId->lookupOptions()) ? $curVal : null;
            }
            if ($this->UFId->ViewValue !== null) { // Load from cache
                $this->UFId->EditValue = array_values($this->UFId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->UFId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->UFId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->UFId->EditValue = $arwrk;
            }
            $this->UFId->PlaceHolder = RemoveHtml($this->UFId->caption());

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

            // neighborhood
            $this->neighborhood->setupEditAttributes();
            $this->neighborhood->EditCustomAttributes = "";
            if (!$this->neighborhood->Raw) {
                $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
            }
            $this->neighborhood->EditValue = HtmlEncode($this->neighborhood->CurrentValue);
            $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

            // address
            $this->address->setupEditAttributes();
            $this->address->EditCustomAttributes = "";
            if (!$this->address->Raw) {
                $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
            }
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // zipcode
            $this->zipcode->setupEditAttributes();
            $this->zipcode->EditCustomAttributes = "";
            if (!$this->zipcode->Raw) {
                $this->zipcode->CurrentValue = HtmlDecode($this->zipcode->CurrentValue);
            }
            $this->zipcode->EditValue = HtmlEncode($this->zipcode->CurrentValue);
            $this->zipcode->PlaceHolder = RemoveHtml($this->zipcode->caption());

            // website
            $this->website->setupEditAttributes();
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            if (!$this->phone->Raw) {
                $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // celphone
            $this->celphone->setupEditAttributes();
            $this->celphone->EditCustomAttributes = "";
            if (!$this->celphone->Raw) {
                $this->celphone->CurrentValue = HtmlDecode($this->celphone->CurrentValue);
            }
            $this->celphone->EditValue = HtmlEncode($this->celphone->CurrentValue);
            $this->celphone->PlaceHolder = RemoveHtml($this->celphone->caption());

            // logo
            $this->logo->setupEditAttributes();
            $this->logo->EditCustomAttributes = "";
            if (!$this->logo->Raw) {
                $this->logo->CurrentValue = HtmlDecode($this->logo->CurrentValue);
            }
            $this->logo->EditValue = HtmlEncode($this->logo->CurrentValue);
            $this->logo->PlaceHolder = RemoveHtml($this->logo->caption());

            // openingDate
            $this->openingDate->setupEditAttributes();
            $this->openingDate->EditCustomAttributes = "";
            $this->openingDate->EditValue = HtmlEncode(FormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern()));
            $this->openingDate->PlaceHolder = RemoveHtml($this->openingDate->caption());

            // owner
            $this->owner->setupEditAttributes();
            $this->owner->EditCustomAttributes = "";
            if (!$this->owner->Raw) {
                $this->owner->CurrentValue = HtmlDecode($this->owner->CurrentValue);
            }
            $this->owner->EditValue = HtmlEncode($this->owner->CurrentValue);
            $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

            // identityNumber
            $this->identityNumber->setupEditAttributes();
            $this->identityNumber->EditCustomAttributes = "";
            if (!$this->identityNumber->Raw) {
                $this->identityNumber->CurrentValue = HtmlDecode($this->identityNumber->CurrentValue);
            }
            $this->identityNumber->EditValue = HtmlEncode($this->identityNumber->CurrentValue);
            $this->identityNumber->PlaceHolder = RemoveHtml($this->identityNumber->caption());

            // birthDateOwner
            $this->birthDateOwner->setupEditAttributes();
            $this->birthDateOwner->EditCustomAttributes = "";
            $this->birthDateOwner->EditValue = HtmlEncode(FormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern()));
            $this->birthDateOwner->PlaceHolder = RemoveHtml($this->birthDateOwner->caption());

            // ownerCountryId
            $this->ownerCountryId->setupEditAttributes();
            $this->ownerCountryId->EditCustomAttributes = "";
            $this->ownerCountryId->EditValue = HtmlEncode($this->ownerCountryId->CurrentValue);
            $this->ownerCountryId->PlaceHolder = RemoveHtml($this->ownerCountryId->caption());
            if (strval($this->ownerCountryId->EditValue) != "" && is_numeric($this->ownerCountryId->EditValue)) {
                $this->ownerCountryId->EditValue = FormatNumber($this->ownerCountryId->EditValue, null);
            }

            // ownerStateId
            $this->ownerStateId->setupEditAttributes();
            $this->ownerStateId->EditCustomAttributes = "";
            $this->ownerStateId->EditValue = HtmlEncode($this->ownerStateId->CurrentValue);
            $this->ownerStateId->PlaceHolder = RemoveHtml($this->ownerStateId->caption());
            if (strval($this->ownerStateId->EditValue) != "" && is_numeric($this->ownerStateId->EditValue)) {
                $this->ownerStateId->EditValue = FormatNumber($this->ownerStateId->EditValue, null);
            }

            // ownCityId
            $this->ownCityId->setupEditAttributes();
            $this->ownCityId->EditCustomAttributes = "";
            $this->ownCityId->EditValue = HtmlEncode($this->ownCityId->CurrentValue);
            $this->ownCityId->PlaceHolder = RemoveHtml($this->ownCityId->caption());
            if (strval($this->ownCityId->EditValue) != "" && is_numeric($this->ownCityId->EditValue)) {
                $this->ownCityId->EditValue = FormatNumber($this->ownCityId->EditValue, null);
            }

            // ownerTelephone
            $this->ownerTelephone->setupEditAttributes();
            $this->ownerTelephone->EditCustomAttributes = "";
            if (!$this->ownerTelephone->Raw) {
                $this->ownerTelephone->CurrentValue = HtmlDecode($this->ownerTelephone->CurrentValue);
            }
            $this->ownerTelephone->EditValue = HtmlEncode($this->ownerTelephone->CurrentValue);
            $this->ownerTelephone->PlaceHolder = RemoveHtml($this->ownerTelephone->caption());

            // ownerTelephoneWork
            $this->ownerTelephoneWork->setupEditAttributes();
            $this->ownerTelephoneWork->EditCustomAttributes = "";
            if (!$this->ownerTelephoneWork->Raw) {
                $this->ownerTelephoneWork->CurrentValue = HtmlDecode($this->ownerTelephoneWork->CurrentValue);
            }
            $this->ownerTelephoneWork->EditValue = HtmlEncode($this->ownerTelephoneWork->CurrentValue);
            $this->ownerTelephoneWork->PlaceHolder = RemoveHtml($this->ownerTelephoneWork->caption());

            // ownerProfession
            $this->ownerProfession->setupEditAttributes();
            $this->ownerProfession->EditCustomAttributes = "";
            if (!$this->ownerProfession->Raw) {
                $this->ownerProfession->CurrentValue = HtmlDecode($this->ownerProfession->CurrentValue);
            }
            $this->ownerProfession->EditValue = HtmlEncode($this->ownerProfession->CurrentValue);
            $this->ownerProfession->PlaceHolder = RemoveHtml($this->ownerProfession->caption());

            // employer
            $this->employer->setupEditAttributes();
            $this->employer->EditCustomAttributes = "";
            if (!$this->employer->Raw) {
                $this->employer->CurrentValue = HtmlDecode($this->employer->CurrentValue);
            }
            $this->employer->EditValue = HtmlEncode($this->employer->CurrentValue);
            $this->employer->PlaceHolder = RemoveHtml($this->employer->caption());

            // ownerGraduation
            $this->ownerGraduation->setupEditAttributes();
            $this->ownerGraduation->EditCustomAttributes = "";
            $this->ownerGraduation->EditValue = HtmlEncode($this->ownerGraduation->CurrentValue);
            $this->ownerGraduation->PlaceHolder = RemoveHtml($this->ownerGraduation->caption());
            if (strval($this->ownerGraduation->EditValue) != "" && is_numeric($this->ownerGraduation->EditValue)) {
                $this->ownerGraduation->EditValue = FormatNumber($this->ownerGraduation->EditValue, null);
            }

            // ownerGraduationLocation
            $this->ownerGraduationLocation->setupEditAttributes();
            $this->ownerGraduationLocation->EditCustomAttributes = "";
            if (!$this->ownerGraduationLocation->Raw) {
                $this->ownerGraduationLocation->CurrentValue = HtmlDecode($this->ownerGraduationLocation->CurrentValue);
            }
            $this->ownerGraduationLocation->EditValue = HtmlEncode($this->ownerGraduationLocation->CurrentValue);
            $this->ownerGraduationLocation->PlaceHolder = RemoveHtml($this->ownerGraduationLocation->caption());

            // ownerGraduationObs
            $this->ownerGraduationObs->setupEditAttributes();
            $this->ownerGraduationObs->EditCustomAttributes = "";
            $this->ownerGraduationObs->EditValue = HtmlEncode($this->ownerGraduationObs->CurrentValue);
            $this->ownerGraduationObs->PlaceHolder = RemoveHtml($this->ownerGraduationObs->caption());

            // ownerMaritalStatus
            $this->ownerMaritalStatus->setupEditAttributes();
            $this->ownerMaritalStatus->EditCustomAttributes = "";
            $this->ownerMaritalStatus->EditValue = HtmlEncode($this->ownerMaritalStatus->CurrentValue);
            $this->ownerMaritalStatus->PlaceHolder = RemoveHtml($this->ownerMaritalStatus->caption());
            if (strval($this->ownerMaritalStatus->EditValue) != "" && is_numeric($this->ownerMaritalStatus->EditValue)) {
                $this->ownerMaritalStatus->EditValue = FormatNumber($this->ownerMaritalStatus->EditValue, null);
            }

            // ownerSpouseName
            $this->ownerSpouseName->setupEditAttributes();
            $this->ownerSpouseName->EditCustomAttributes = "";
            if (!$this->ownerSpouseName->Raw) {
                $this->ownerSpouseName->CurrentValue = HtmlDecode($this->ownerSpouseName->CurrentValue);
            }
            $this->ownerSpouseName->EditValue = HtmlEncode($this->ownerSpouseName->CurrentValue);
            $this->ownerSpouseName->PlaceHolder = RemoveHtml($this->ownerSpouseName->caption());

            // ownerSpouseProfession
            $this->ownerSpouseProfession->setupEditAttributes();
            $this->ownerSpouseProfession->EditCustomAttributes = "";
            if (!$this->ownerSpouseProfession->Raw) {
                $this->ownerSpouseProfession->CurrentValue = HtmlDecode($this->ownerSpouseProfession->CurrentValue);
            }
            $this->ownerSpouseProfession->EditValue = HtmlEncode($this->ownerSpouseProfession->CurrentValue);
            $this->ownerSpouseProfession->PlaceHolder = RemoveHtml($this->ownerSpouseProfession->caption());

            // propertySituation
            $this->propertySituation->setupEditAttributes();
            $this->propertySituation->EditCustomAttributes = "";
            $this->propertySituation->EditValue = HtmlEncode($this->propertySituation->CurrentValue);
            $this->propertySituation->PlaceHolder = RemoveHtml($this->propertySituation->caption());
            if (strval($this->propertySituation->EditValue) != "" && is_numeric($this->propertySituation->EditValue)) {
                $this->propertySituation->EditValue = FormatNumber($this->propertySituation->EditValue, null);
            }

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->setupEditAttributes();
            $this->numberOfStudentsInBeginnig->EditCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->EditValue = HtmlEncode($this->numberOfStudentsInBeginnig->CurrentValue);
            $this->numberOfStudentsInBeginnig->PlaceHolder = RemoveHtml($this->numberOfStudentsInBeginnig->caption());
            if (strval($this->numberOfStudentsInBeginnig->EditValue) != "" && is_numeric($this->numberOfStudentsInBeginnig->EditValue)) {
                $this->numberOfStudentsInBeginnig->EditValue = FormatNumber($this->numberOfStudentsInBeginnig->EditValue, null);
            }

            // ownerAbout
            $this->ownerAbout->setupEditAttributes();
            $this->ownerAbout->EditCustomAttributes = "";
            $this->ownerAbout->EditValue = HtmlEncode($this->ownerAbout->CurrentValue);
            $this->ownerAbout->PlaceHolder = RemoveHtml($this->ownerAbout->caption());

            // pdfLicense
            $this->pdfLicense->setupEditAttributes();
            $this->pdfLicense->EditCustomAttributes = "";
            $this->pdfLicense->EditValue = HtmlEncode($this->pdfLicense->CurrentValue);
            $this->pdfLicense->PlaceHolder = RemoveHtml($this->pdfLicense->caption());

            // applicationId
            $this->applicationId->setupEditAttributes();
            $this->applicationId->EditCustomAttributes = "";
            if ($this->applicationId->getSessionValue() != "") {
                $this->applicationId->CurrentValue = GetForeignKeyValue($this->applicationId->getSessionValue());
                $this->applicationId->ViewValue = $this->applicationId->CurrentValue;
                $this->applicationId->ViewValue = FormatNumber($this->applicationId->ViewValue, $this->applicationId->formatPattern());
                $this->applicationId->ViewCustomAttributes = "";
            } else {
                $this->applicationId->EditValue = HtmlEncode($this->applicationId->CurrentValue);
                $this->applicationId->PlaceHolder = RemoveHtml($this->applicationId->caption());
                if (strval($this->applicationId->EditValue) != "" && is_numeric($this->applicationId->EditValue)) {
                    $this->applicationId->EditValue = FormatNumber($this->applicationId->EditValue, null);
                }
            }

            // isheadquarter
            $this->isheadquarter->EditCustomAttributes = "";
            $this->isheadquarter->EditValue = $this->isheadquarter->options(false);
            $this->isheadquarter->PlaceHolder = RemoveHtml($this->isheadquarter->caption());

            // Edit refer script

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // zipcode
            $this->zipcode->LinkCustomAttributes = "";
            $this->zipcode->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            $this->logo->HrefValue = "";

            // openingDate
            $this->openingDate->LinkCustomAttributes = "";
            $this->openingDate->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // identityNumber
            $this->identityNumber->LinkCustomAttributes = "";
            $this->identityNumber->HrefValue = "";

            // birthDateOwner
            $this->birthDateOwner->LinkCustomAttributes = "";
            $this->birthDateOwner->HrefValue = "";

            // ownerCountryId
            $this->ownerCountryId->LinkCustomAttributes = "";
            $this->ownerCountryId->HrefValue = "";

            // ownerStateId
            $this->ownerStateId->LinkCustomAttributes = "";
            $this->ownerStateId->HrefValue = "";

            // ownCityId
            $this->ownCityId->LinkCustomAttributes = "";
            $this->ownCityId->HrefValue = "";

            // ownerTelephone
            $this->ownerTelephone->LinkCustomAttributes = "";
            $this->ownerTelephone->HrefValue = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->LinkCustomAttributes = "";
            $this->ownerTelephoneWork->HrefValue = "";

            // ownerProfession
            $this->ownerProfession->LinkCustomAttributes = "";
            $this->ownerProfession->HrefValue = "";

            // employer
            $this->employer->LinkCustomAttributes = "";
            $this->employer->HrefValue = "";

            // ownerGraduation
            $this->ownerGraduation->LinkCustomAttributes = "";
            $this->ownerGraduation->HrefValue = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->LinkCustomAttributes = "";
            $this->ownerGraduationLocation->HrefValue = "";

            // ownerGraduationObs
            $this->ownerGraduationObs->LinkCustomAttributes = "";
            $this->ownerGraduationObs->HrefValue = "";

            // ownerMaritalStatus
            $this->ownerMaritalStatus->LinkCustomAttributes = "";
            $this->ownerMaritalStatus->HrefValue = "";

            // ownerSpouseName
            $this->ownerSpouseName->LinkCustomAttributes = "";
            $this->ownerSpouseName->HrefValue = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->LinkCustomAttributes = "";
            $this->ownerSpouseProfession->HrefValue = "";

            // propertySituation
            $this->propertySituation->LinkCustomAttributes = "";
            $this->propertySituation->HrefValue = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->LinkCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->HrefValue = "";

            // ownerAbout
            $this->ownerAbout->LinkCustomAttributes = "";
            $this->ownerAbout->HrefValue = "";

            // pdfLicense
            $this->pdfLicense->LinkCustomAttributes = "";
            $this->pdfLicense->HrefValue = "";

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
        if ($this->countryId->Required) {
            if (!$this->countryId->IsDetailKey && EmptyValue($this->countryId->FormValue)) {
                $this->countryId->addErrorMessage(str_replace("%s", $this->countryId->caption(), $this->countryId->RequiredErrorMessage));
            }
        }
        if ($this->UFId->Required) {
            if (!$this->UFId->IsDetailKey && EmptyValue($this->UFId->FormValue)) {
                $this->UFId->addErrorMessage(str_replace("%s", $this->UFId->caption(), $this->UFId->RequiredErrorMessage));
            }
        }
        if ($this->cityId->Required) {
            if (!$this->cityId->IsDetailKey && EmptyValue($this->cityId->FormValue)) {
                $this->cityId->addErrorMessage(str_replace("%s", $this->cityId->caption(), $this->cityId->RequiredErrorMessage));
            }
        }
        if ($this->neighborhood->Required) {
            if (!$this->neighborhood->IsDetailKey && EmptyValue($this->neighborhood->FormValue)) {
                $this->neighborhood->addErrorMessage(str_replace("%s", $this->neighborhood->caption(), $this->neighborhood->RequiredErrorMessage));
            }
        }
        if ($this->address->Required) {
            if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
            }
        }
        if ($this->zipcode->Required) {
            if (!$this->zipcode->IsDetailKey && EmptyValue($this->zipcode->FormValue)) {
                $this->zipcode->addErrorMessage(str_replace("%s", $this->zipcode->caption(), $this->zipcode->RequiredErrorMessage));
            }
        }
        if ($this->website->Required) {
            if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->phone->Required) {
            if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
            }
        }
        if ($this->celphone->Required) {
            if (!$this->celphone->IsDetailKey && EmptyValue($this->celphone->FormValue)) {
                $this->celphone->addErrorMessage(str_replace("%s", $this->celphone->caption(), $this->celphone->RequiredErrorMessage));
            }
        }
        if ($this->logo->Required) {
            if (!$this->logo->IsDetailKey && EmptyValue($this->logo->FormValue)) {
                $this->logo->addErrorMessage(str_replace("%s", $this->logo->caption(), $this->logo->RequiredErrorMessage));
            }
        }
        if ($this->openingDate->Required) {
            if (!$this->openingDate->IsDetailKey && EmptyValue($this->openingDate->FormValue)) {
                $this->openingDate->addErrorMessage(str_replace("%s", $this->openingDate->caption(), $this->openingDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->openingDate->FormValue, $this->openingDate->formatPattern())) {
            $this->openingDate->addErrorMessage($this->openingDate->getErrorMessage(false));
        }
        if ($this->owner->Required) {
            if (!$this->owner->IsDetailKey && EmptyValue($this->owner->FormValue)) {
                $this->owner->addErrorMessage(str_replace("%s", $this->owner->caption(), $this->owner->RequiredErrorMessage));
            }
        }
        if ($this->identityNumber->Required) {
            if (!$this->identityNumber->IsDetailKey && EmptyValue($this->identityNumber->FormValue)) {
                $this->identityNumber->addErrorMessage(str_replace("%s", $this->identityNumber->caption(), $this->identityNumber->RequiredErrorMessage));
            }
        }
        if ($this->birthDateOwner->Required) {
            if (!$this->birthDateOwner->IsDetailKey && EmptyValue($this->birthDateOwner->FormValue)) {
                $this->birthDateOwner->addErrorMessage(str_replace("%s", $this->birthDateOwner->caption(), $this->birthDateOwner->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->birthDateOwner->FormValue, $this->birthDateOwner->formatPattern())) {
            $this->birthDateOwner->addErrorMessage($this->birthDateOwner->getErrorMessage(false));
        }
        if ($this->ownerCountryId->Required) {
            if (!$this->ownerCountryId->IsDetailKey && EmptyValue($this->ownerCountryId->FormValue)) {
                $this->ownerCountryId->addErrorMessage(str_replace("%s", $this->ownerCountryId->caption(), $this->ownerCountryId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ownerCountryId->FormValue)) {
            $this->ownerCountryId->addErrorMessage($this->ownerCountryId->getErrorMessage(false));
        }
        if ($this->ownerStateId->Required) {
            if (!$this->ownerStateId->IsDetailKey && EmptyValue($this->ownerStateId->FormValue)) {
                $this->ownerStateId->addErrorMessage(str_replace("%s", $this->ownerStateId->caption(), $this->ownerStateId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ownerStateId->FormValue)) {
            $this->ownerStateId->addErrorMessage($this->ownerStateId->getErrorMessage(false));
        }
        if ($this->ownCityId->Required) {
            if (!$this->ownCityId->IsDetailKey && EmptyValue($this->ownCityId->FormValue)) {
                $this->ownCityId->addErrorMessage(str_replace("%s", $this->ownCityId->caption(), $this->ownCityId->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ownCityId->FormValue)) {
            $this->ownCityId->addErrorMessage($this->ownCityId->getErrorMessage(false));
        }
        if ($this->ownerTelephone->Required) {
            if (!$this->ownerTelephone->IsDetailKey && EmptyValue($this->ownerTelephone->FormValue)) {
                $this->ownerTelephone->addErrorMessage(str_replace("%s", $this->ownerTelephone->caption(), $this->ownerTelephone->RequiredErrorMessage));
            }
        }
        if ($this->ownerTelephoneWork->Required) {
            if (!$this->ownerTelephoneWork->IsDetailKey && EmptyValue($this->ownerTelephoneWork->FormValue)) {
                $this->ownerTelephoneWork->addErrorMessage(str_replace("%s", $this->ownerTelephoneWork->caption(), $this->ownerTelephoneWork->RequiredErrorMessage));
            }
        }
        if ($this->ownerProfession->Required) {
            if (!$this->ownerProfession->IsDetailKey && EmptyValue($this->ownerProfession->FormValue)) {
                $this->ownerProfession->addErrorMessage(str_replace("%s", $this->ownerProfession->caption(), $this->ownerProfession->RequiredErrorMessage));
            }
        }
        if ($this->employer->Required) {
            if (!$this->employer->IsDetailKey && EmptyValue($this->employer->FormValue)) {
                $this->employer->addErrorMessage(str_replace("%s", $this->employer->caption(), $this->employer->RequiredErrorMessage));
            }
        }
        if ($this->ownerGraduation->Required) {
            if (!$this->ownerGraduation->IsDetailKey && EmptyValue($this->ownerGraduation->FormValue)) {
                $this->ownerGraduation->addErrorMessage(str_replace("%s", $this->ownerGraduation->caption(), $this->ownerGraduation->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ownerGraduation->FormValue)) {
            $this->ownerGraduation->addErrorMessage($this->ownerGraduation->getErrorMessage(false));
        }
        if ($this->ownerGraduationLocation->Required) {
            if (!$this->ownerGraduationLocation->IsDetailKey && EmptyValue($this->ownerGraduationLocation->FormValue)) {
                $this->ownerGraduationLocation->addErrorMessage(str_replace("%s", $this->ownerGraduationLocation->caption(), $this->ownerGraduationLocation->RequiredErrorMessage));
            }
        }
        if ($this->ownerGraduationObs->Required) {
            if (!$this->ownerGraduationObs->IsDetailKey && EmptyValue($this->ownerGraduationObs->FormValue)) {
                $this->ownerGraduationObs->addErrorMessage(str_replace("%s", $this->ownerGraduationObs->caption(), $this->ownerGraduationObs->RequiredErrorMessage));
            }
        }
        if ($this->ownerMaritalStatus->Required) {
            if (!$this->ownerMaritalStatus->IsDetailKey && EmptyValue($this->ownerMaritalStatus->FormValue)) {
                $this->ownerMaritalStatus->addErrorMessage(str_replace("%s", $this->ownerMaritalStatus->caption(), $this->ownerMaritalStatus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ownerMaritalStatus->FormValue)) {
            $this->ownerMaritalStatus->addErrorMessage($this->ownerMaritalStatus->getErrorMessage(false));
        }
        if ($this->ownerSpouseName->Required) {
            if (!$this->ownerSpouseName->IsDetailKey && EmptyValue($this->ownerSpouseName->FormValue)) {
                $this->ownerSpouseName->addErrorMessage(str_replace("%s", $this->ownerSpouseName->caption(), $this->ownerSpouseName->RequiredErrorMessage));
            }
        }
        if ($this->ownerSpouseProfession->Required) {
            if (!$this->ownerSpouseProfession->IsDetailKey && EmptyValue($this->ownerSpouseProfession->FormValue)) {
                $this->ownerSpouseProfession->addErrorMessage(str_replace("%s", $this->ownerSpouseProfession->caption(), $this->ownerSpouseProfession->RequiredErrorMessage));
            }
        }
        if ($this->propertySituation->Required) {
            if (!$this->propertySituation->IsDetailKey && EmptyValue($this->propertySituation->FormValue)) {
                $this->propertySituation->addErrorMessage(str_replace("%s", $this->propertySituation->caption(), $this->propertySituation->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->propertySituation->FormValue)) {
            $this->propertySituation->addErrorMessage($this->propertySituation->getErrorMessage(false));
        }
        if ($this->numberOfStudentsInBeginnig->Required) {
            if (!$this->numberOfStudentsInBeginnig->IsDetailKey && EmptyValue($this->numberOfStudentsInBeginnig->FormValue)) {
                $this->numberOfStudentsInBeginnig->addErrorMessage(str_replace("%s", $this->numberOfStudentsInBeginnig->caption(), $this->numberOfStudentsInBeginnig->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->numberOfStudentsInBeginnig->FormValue)) {
            $this->numberOfStudentsInBeginnig->addErrorMessage($this->numberOfStudentsInBeginnig->getErrorMessage(false));
        }
        if ($this->ownerAbout->Required) {
            if (!$this->ownerAbout->IsDetailKey && EmptyValue($this->ownerAbout->FormValue)) {
                $this->ownerAbout->addErrorMessage(str_replace("%s", $this->ownerAbout->caption(), $this->ownerAbout->RequiredErrorMessage));
            }
        }
        if ($this->pdfLicense->Required) {
            if (!$this->pdfLicense->IsDetailKey && EmptyValue($this->pdfLicense->FormValue)) {
                $this->pdfLicense->addErrorMessage(str_replace("%s", $this->pdfLicense->caption(), $this->pdfLicense->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SchoolUsersGrid");
        if (in_array("school_users", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("SchoolMemberGrid");
        if (in_array("school_member", $detailTblVar) && $detailPage->DetailEdit) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // countryId
        $this->countryId->setDbValueDef($rsnew, $this->countryId->CurrentValue, null, $this->countryId->ReadOnly);

        // UFId
        $this->UFId->setDbValueDef($rsnew, $this->UFId->CurrentValue, null, $this->UFId->ReadOnly);

        // cityId
        $this->cityId->setDbValueDef($rsnew, $this->cityId->CurrentValue, null, $this->cityId->ReadOnly);

        // neighborhood
        $this->neighborhood->setDbValueDef($rsnew, $this->neighborhood->CurrentValue, null, $this->neighborhood->ReadOnly);

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, null, $this->address->ReadOnly);

        // zipcode
        $this->zipcode->setDbValueDef($rsnew, $this->zipcode->CurrentValue, null, $this->zipcode->ReadOnly);

        // website
        $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, null, $this->website->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

        // phone
        $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, null, $this->phone->ReadOnly);

        // celphone
        $this->celphone->setDbValueDef($rsnew, $this->celphone->CurrentValue, null, $this->celphone->ReadOnly);

        // logo
        $this->logo->setDbValueDef($rsnew, $this->logo->CurrentValue, null, $this->logo->ReadOnly);

        // openingDate
        $this->openingDate->setDbValueDef($rsnew, UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern()), null, $this->openingDate->ReadOnly);

        // owner
        $this->owner->setDbValueDef($rsnew, $this->owner->CurrentValue, null, $this->owner->ReadOnly);

        // identityNumber
        $this->identityNumber->setDbValueDef($rsnew, $this->identityNumber->CurrentValue, null, $this->identityNumber->ReadOnly);

        // birthDateOwner
        $this->birthDateOwner->setDbValueDef($rsnew, UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern()), null, $this->birthDateOwner->ReadOnly);

        // ownerCountryId
        $this->ownerCountryId->setDbValueDef($rsnew, $this->ownerCountryId->CurrentValue, null, $this->ownerCountryId->ReadOnly);

        // ownerStateId
        $this->ownerStateId->setDbValueDef($rsnew, $this->ownerStateId->CurrentValue, null, $this->ownerStateId->ReadOnly);

        // ownCityId
        $this->ownCityId->setDbValueDef($rsnew, $this->ownCityId->CurrentValue, null, $this->ownCityId->ReadOnly);

        // ownerTelephone
        $this->ownerTelephone->setDbValueDef($rsnew, $this->ownerTelephone->CurrentValue, null, $this->ownerTelephone->ReadOnly);

        // ownerTelephoneWork
        $this->ownerTelephoneWork->setDbValueDef($rsnew, $this->ownerTelephoneWork->CurrentValue, null, $this->ownerTelephoneWork->ReadOnly);

        // ownerProfession
        $this->ownerProfession->setDbValueDef($rsnew, $this->ownerProfession->CurrentValue, null, $this->ownerProfession->ReadOnly);

        // employer
        $this->employer->setDbValueDef($rsnew, $this->employer->CurrentValue, null, $this->employer->ReadOnly);

        // ownerGraduation
        $this->ownerGraduation->setDbValueDef($rsnew, $this->ownerGraduation->CurrentValue, null, $this->ownerGraduation->ReadOnly);

        // ownerGraduationLocation
        $this->ownerGraduationLocation->setDbValueDef($rsnew, $this->ownerGraduationLocation->CurrentValue, null, $this->ownerGraduationLocation->ReadOnly);

        // ownerGraduationObs
        $this->ownerGraduationObs->setDbValueDef($rsnew, $this->ownerGraduationObs->CurrentValue, null, $this->ownerGraduationObs->ReadOnly);

        // ownerMaritalStatus
        $this->ownerMaritalStatus->setDbValueDef($rsnew, $this->ownerMaritalStatus->CurrentValue, null, $this->ownerMaritalStatus->ReadOnly);

        // ownerSpouseName
        $this->ownerSpouseName->setDbValueDef($rsnew, $this->ownerSpouseName->CurrentValue, null, $this->ownerSpouseName->ReadOnly);

        // ownerSpouseProfession
        $this->ownerSpouseProfession->setDbValueDef($rsnew, $this->ownerSpouseProfession->CurrentValue, null, $this->ownerSpouseProfession->ReadOnly);

        // propertySituation
        $this->propertySituation->setDbValueDef($rsnew, $this->propertySituation->CurrentValue, null, $this->propertySituation->ReadOnly);

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->setDbValueDef($rsnew, $this->numberOfStudentsInBeginnig->CurrentValue, null, $this->numberOfStudentsInBeginnig->ReadOnly);

        // ownerAbout
        $this->ownerAbout->setDbValueDef($rsnew, $this->ownerAbout->CurrentValue, null, $this->ownerAbout->ReadOnly);

        // pdfLicense
        $this->pdfLicense->setDbValueDef($rsnew, $this->pdfLicense->CurrentValue, null, $this->pdfLicense->ReadOnly);

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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            if ($editRow) {
                $detailPage = Container("SchoolUsersGrid");
                if (in_array("school_users", $detailTblVar) && $detailPage->DetailEdit) {
                    $Security->loadCurrentUserLevel($this->ProjectID . "school_users"); // Load user level of detail table
                    $editRow = $detailPage->gridUpdate();
                    $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                }
            }
            if ($editRow) {
                $detailPage = Container("SchoolMemberGrid");
                if (in_array("school_member", $detailTblVar) && $detailPage->DetailEdit) {
                    $Security->loadCurrentUserLevel($this->ProjectID . "school_member"); // Load user level of detail table
                    $editRow = $detailPage->gridUpdate();
                    $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                }
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
                    if ($this->UseTransaction) { // Commit transaction
                        $conn->commit();
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        $conn->rollback();
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

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

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("school_users", $detailTblVar)) {
                $detailPageObj = Container("SchoolUsersGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->schoolId->IsDetailKey = true;
                    $detailPageObj->schoolId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->schoolId->setSessionValue($detailPageObj->schoolId->CurrentValue);
                }
            }
            if (in_array("school_member", $detailTblVar)) {
                $detailPageObj = Container("SchoolMemberGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->schoolId->IsDetailKey = true;
                    $detailPageObj->schoolId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->schoolId->setSessionValue($detailPageObj->schoolId->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FedSchoolList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('school_users');
        $pages->add('school_member');
        $this->DetailPages = $pages;
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
