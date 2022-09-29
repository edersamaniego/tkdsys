<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SchoolMemberDelete extends SchoolMember
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'school_member';

    // Page object name
    public $PageObjName = "SchoolMemberDelete";

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

        // Table object (school_member)
        if (!isset($GLOBALS["school_member"]) || get_class($GLOBALS["school_member"]) == PROJECT_NAMESPACE . "school_member") {
            $GLOBALS["school_member"] = &$this;
        }

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
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("SchoolMemberList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Check if valid User ID
        $conn = $this->getConnection();
        $sql = $this->getSql($this->CurrentFilter);
        $rows = $conn->fetchAllAssociative($sql);
        $res = true;
        foreach ($rows as $row) {
            $this->loadRowValues($row);
            if (!$this->showOptionLink("delete")) {
                $userIdMsg = $Language->phrase("NoDeletePermission");
                $this->setFailureMessage($userIdMsg);
                $res = false;
                break;
            }
        }
        if (!$res) {
            $this->terminate("SchoolMemberList"); // Return to list
            return;
        }

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("SchoolMemberList"); // Return to list
                return;
            }
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

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
                $this->photo->LinkAttrs["data-rel"] = "school_member_x_photo";
                $this->photo->LinkAttrs->appendClass("ew-lightbox");
            }
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        if ($this->UseTransaction) {
            $conn->beginTransaction();
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
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteSomeRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Get("fk_id", Get("schoolId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->schoolId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->schoolId->setSessionValue($this->schoolId->QueryStringValue);
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
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Post("fk_id", Post("schoolId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->schoolId->setFormValue($masterTbl->id->FormValue);
                    $this->schoolId->setSessionValue($this->schoolId->FormValue);
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
            if ($masterTblVar != "fed_school") {
                if ($this->schoolId->CurrentValue == "") {
                    $this->schoolId->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SchoolMemberList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
