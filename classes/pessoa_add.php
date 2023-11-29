<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class pessoa_add extends pessoa
{

	// Page ID
	public $PageID = "add";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Table name
	public $TableName = 'pessoa';

	// Page object name
	public $PageObjName = "pessoa_add";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = TRUE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (pessoa)
		if (!isset($GLOBALS["pessoa"]) || get_class($GLOBALS["pessoa"]) == PROJECT_NAMESPACE . "pessoa") {
			$GLOBALS["pessoa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pessoa"];
		}

		// Table object (aulas)
		if (!isset($GLOBALS['aulas']))
			$GLOBALS['aulas'] = new aulas();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'add');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'pessoa');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (pessoa)
		$UserTable = $UserTable ?: new pessoa();
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $pessoa;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($pessoa);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url, "modal" => "1"];
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "pessoaview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
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
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									"fn=" . Encrypt($fld->physicalUploadPath() . $val)));
								$row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
										Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
										"fn=" . Encrypt($fld->physicalUploadPath() . $file)));
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
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
			$key .= @$ar['idpessoa'];
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
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->idpessoa->Visible = FALSE;
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!ValidApiRequest())
			return FALSE;
		$this->setupApiSecurity();

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Param("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
	}

	// Set up API security
	public function setupApiSecurity()
	{
		global $Security;

		// Setup security for API request
		if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
		$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
		if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
		$Security->UserID_Loading();
		$Security->loadUserID();
		$Security->UserID_Loaded();
	}
	public $FormClassName = "ew-horizontal ew-form ew-add-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $StartRecord;
	public $Priv = 0;
	public $OldRecordset;
	public $CopyRecord;
	public $DetailPages; // Detail pages object

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
			if (!$Security->canAdd()) {
				SetStatus(401); // Unauthorized
				return;
			}
		} else {
			$Security = new AdvancedSecurity();
			if (IsPasswordExpired())
				$this->terminate(GetUrl("changepwd.php"));
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canAdd()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("pessoalist.php"));
				else
					$this->terminate(GetUrl("login.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
				if (strval($Security->currentUserID()) == "") {
					$this->setFailureMessage(DeniedMessage()); // Set no permission
					$this->terminate(GetUrl("pessoalist.php"));
					return;
				}
			}
		}

		// Update last accessed time
		if ($UserProfile->isValidUser(CurrentUserName(), session_id())) {
		} else {
			Write($Language->phrase("UserProfileCorrupted"));
			$this->terminate();
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->idpessoa->Visible = FALSE;
		$this->idaula->setVisibility();
		$this->Nome->setVisibility();
		$this->CPF->setVisibility();
		$this->Senha->setVisibility();
		$this->Sexo->setVisibility();
		$this->datanascimento->setVisibility();
		$this->Funcao->setVisibility();
		$this->Sessao->Visible = FALSE;
		$this->_Email->setVisibility();
		$this->Ativado->setVisibility();
		$this->datadecadastro->setVisibility();
		$this->Idade->Visible = FALSE;
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

		// Set up detail page object
		$this->setupDetailPages();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up lookup cache
		$this->setupLookupOptions($this->idaula);
		$this->setupLookupOptions($this->Funcao);

		// Check permission
		if (!$Security->canAdd()) {
			$this->setFailureMessage(DeniedMessage()); // No permission
			$this->terminate("pessoalist.php");
			return;
		}

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-add-form ew-horizontal";
		$postBack = FALSE;

		// Set up current action
		if (IsApi()) {
			$this->CurrentAction = "insert"; // Add record directly
			$postBack = TRUE;
		} elseif (Post("action") !== NULL) {
			$this->CurrentAction = Post("action"); // Get form action
			$postBack = TRUE;
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (Get("idpessoa") !== NULL) {
				$this->idpessoa->setQueryStringValue(Get("idpessoa"));
				$this->setKey("idpessoa", $this->idpessoa->CurrentValue); // Set up key
			} else {
				$this->setKey("idpessoa", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "copy"; // Copy record
			} else {
				$this->CurrentAction = "show"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->loadOldRecord();

		// Set up master/detail parameters
		// NOTE: must be after loadOldRecord to prevent master key values overwritten

		$this->setupMasterParms();

		// Load form values
		if ($postBack) {
			$this->loadFormValues(); // Load form values
		}

		// Set up detail parameters
		$this->setupDetailParms();

		// Validate form if post back
		if ($postBack) {
			if (!$this->validateForm()) {
				$this->EventCancelled = TRUE; // Event cancelled
				$this->restoreFormValues(); // Restore form values
				$this->setFailureMessage($FormError);
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = "show"; // Form error, reset action
				}
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "copy": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
					$this->terminate("pessoalist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->setupDetailParms();
				break;
			case "insert": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() != "") // Master/detail add
						$returnUrl = $this->getDetailUrl();
					else
						$returnUrl = $this->getReturnUrl();
					if (GetPageName($returnUrl) == "pessoalist.php")
						$returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
					elseif (GetPageName($returnUrl) == "pessoaview.php")
						$returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate($returnUrl);
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->restoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->setupDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Render row based on row type
		$this->RowType = ROWTYPE_ADD; // Render add type

		// Render row
		$this->resetAttributes();
		$this->renderRow();
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idpessoa->CurrentValue = NULL;
		$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
		$this->idaula->CurrentValue = NULL;
		$this->idaula->OldValue = $this->idaula->CurrentValue;
		$this->Nome->CurrentValue = NULL;
		$this->Nome->OldValue = $this->Nome->CurrentValue;
		$this->CPF->CurrentValue = NULL;
		$this->CPF->OldValue = $this->CPF->CurrentValue;
		$this->Senha->CurrentValue = NULL;
		$this->Senha->OldValue = $this->Senha->CurrentValue;
		$this->Sexo->CurrentValue = NULL;
		$this->Sexo->OldValue = $this->Sexo->CurrentValue;
		$this->datanascimento->CurrentValue = NULL;
		$this->datanascimento->OldValue = $this->datanascimento->CurrentValue;
		$this->Funcao->CurrentValue = 0;
		$this->Sessao->CurrentValue = NULL;
		$this->Sessao->OldValue = $this->Sessao->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Ativado->CurrentValue = NULL;
		$this->Ativado->OldValue = $this->Ativado->CurrentValue;
		$this->datadecadastro->CurrentValue = NULL;
		$this->datadecadastro->OldValue = $this->datadecadastro->CurrentValue;
		$this->Idade->CurrentValue = NULL;
		$this->Idade->OldValue = $this->Idade->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'idaula' first before field var 'x_idaula'
		$val = $CurrentForm->hasValue("idaula") ? $CurrentForm->getValue("idaula") : $CurrentForm->getValue("x_idaula");
		if (!$this->idaula->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idaula->Visible = FALSE; // Disable update for API request
			else
				$this->idaula->setFormValue($val);
		}

		// Check field name 'Nome' first before field var 'x_Nome'
		$val = $CurrentForm->hasValue("Nome") ? $CurrentForm->getValue("Nome") : $CurrentForm->getValue("x_Nome");
		if (!$this->Nome->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Nome->Visible = FALSE; // Disable update for API request
			else
				$this->Nome->setFormValue($val);
		}

		// Check field name 'CPF' first before field var 'x_CPF'
		$val = $CurrentForm->hasValue("CPF") ? $CurrentForm->getValue("CPF") : $CurrentForm->getValue("x_CPF");
		if (!$this->CPF->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->CPF->Visible = FALSE; // Disable update for API request
			else
				$this->CPF->setFormValue($val);
		}

		// Check field name 'Senha' first before field var 'x_Senha'
		$val = $CurrentForm->hasValue("Senha") ? $CurrentForm->getValue("Senha") : $CurrentForm->getValue("x_Senha");
		if (!$this->Senha->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Senha->Visible = FALSE; // Disable update for API request
			else
				if (Config("ENCRYPTED_PASSWORD")) // Encrypted password, use raw value
					$this->Senha->setRawFormValue($val);
				else
					$this->Senha->setFormValue($val);
		}

		// Check field name 'Sexo' first before field var 'x_Sexo'
		$val = $CurrentForm->hasValue("Sexo") ? $CurrentForm->getValue("Sexo") : $CurrentForm->getValue("x_Sexo");
		if (!$this->Sexo->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Sexo->Visible = FALSE; // Disable update for API request
			else
				$this->Sexo->setFormValue($val);
		}

		// Check field name 'datanascimento' first before field var 'x_datanascimento'
		$val = $CurrentForm->hasValue("datanascimento") ? $CurrentForm->getValue("datanascimento") : $CurrentForm->getValue("x_datanascimento");
		if (!$this->datanascimento->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datanascimento->Visible = FALSE; // Disable update for API request
			else
				$this->datanascimento->setFormValue($val);
			$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		}

		// Check field name 'Funcao' first before field var 'x_Funcao'
		$val = $CurrentForm->hasValue("Funcao") ? $CurrentForm->getValue("Funcao") : $CurrentForm->getValue("x_Funcao");
		if (!$this->Funcao->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Funcao->Visible = FALSE; // Disable update for API request
			else
				$this->Funcao->setFormValue($val);
		}

		// Check field name 'Email' first before field var 'x__Email'
		$val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
		if (!$this->_Email->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->_Email->Visible = FALSE; // Disable update for API request
			else
				$this->_Email->setFormValue($val);
		}

		// Check field name 'Ativado' first before field var 'x_Ativado'
		$val = $CurrentForm->hasValue("Ativado") ? $CurrentForm->getValue("Ativado") : $CurrentForm->getValue("x_Ativado");
		if (!$this->Ativado->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Ativado->Visible = FALSE; // Disable update for API request
			else
				$this->Ativado->setFormValue($val);
		}

		// Check field name 'datadecadastro' first before field var 'x_datadecadastro'
		$val = $CurrentForm->hasValue("datadecadastro") ? $CurrentForm->getValue("datadecadastro") : $CurrentForm->getValue("x_datadecadastro");
		if (!$this->datadecadastro->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datadecadastro->Visible = FALSE; // Disable update for API request
			else
				$this->datadecadastro->setFormValue($val);
			$this->datadecadastro->CurrentValue = UnFormatDateTime($this->datadecadastro->CurrentValue, 0);
		}

		// Check field name 'idpessoa' first before field var 'x_idpessoa'
		$val = $CurrentForm->hasValue("idpessoa") ? $CurrentForm->getValue("idpessoa") : $CurrentForm->getValue("x_idpessoa");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->idaula->CurrentValue = $this->idaula->FormValue;
		$this->Nome->CurrentValue = $this->Nome->FormValue;
		$this->CPF->CurrentValue = $this->CPF->FormValue;
		$this->Senha->CurrentValue = $this->Senha->FormValue;
		$this->Sexo->CurrentValue = $this->Sexo->FormValue;
		$this->datanascimento->CurrentValue = $this->datanascimento->FormValue;
		$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		$this->Funcao->CurrentValue = $this->Funcao->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Ativado->CurrentValue = $this->Ativado->FormValue;
		$this->datadecadastro->CurrentValue = $this->datadecadastro->FormValue;
		$this->datadecadastro->CurrentValue = UnFormatDateTime($this->datadecadastro->CurrentValue, 0);
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}

		// Check if valid User ID
		if ($res) {
			$res = $this->showOptionLink('add');
			if (!$res) {
				$userIdMsg = DeniedMessage();
				$this->setFailureMessage($userIdMsg);
			}
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->idpessoa->setDbValue($row['idpessoa']);
		$this->idaula->setDbValue($row['idaula']);
		$this->Nome->setDbValue($row['Nome']);
		$this->CPF->setDbValue($row['CPF']);
		$this->Senha->setDbValue($row['Senha']);
		$this->Sexo->setDbValue($row['Sexo']);
		$this->datanascimento->setDbValue($row['datanascimento']);
		$this->Funcao->setDbValue($row['Funcao']);
		$this->Sessao->setDbValue($row['Sessao']);
		$this->_Email->setDbValue($row['Email']);
		$this->Ativado->setDbValue($row['Ativado']);
		$this->datadecadastro->setDbValue($row['datadecadastro']);
		$this->Idade->setDbValue($row['Idade']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idpessoa'] = $this->idpessoa->CurrentValue;
		$row['idaula'] = $this->idaula->CurrentValue;
		$row['Nome'] = $this->Nome->CurrentValue;
		$row['CPF'] = $this->CPF->CurrentValue;
		$row['Senha'] = $this->Senha->CurrentValue;
		$row['Sexo'] = $this->Sexo->CurrentValue;
		$row['datanascimento'] = $this->datanascimento->CurrentValue;
		$row['Funcao'] = $this->Funcao->CurrentValue;
		$row['Sessao'] = $this->Sessao->CurrentValue;
		$row['Email'] = $this->_Email->CurrentValue;
		$row['Ativado'] = $this->Ativado->CurrentValue;
		$row['datadecadastro'] = $this->datadecadastro->CurrentValue;
		$row['Idade'] = $this->Idade->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		if (strval($this->getKey("idpessoa")) != "")
			$this->idpessoa->OldValue = $this->getKey("idpessoa"); // idpessoa
		else
			$validKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
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

		$this->Row_Rendering();

		// Common render codes for all row types
		// idpessoa
		// idaula
		// Nome
		// CPF
		// Senha
		// Sexo
		// datanascimento
		// Funcao
		// Sessao
		// Email
		// Ativado
		// datadecadastro
		// Idade

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idpessoa
			$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
			$this->idpessoa->ViewCustomAttributes = "";

			// idaula
			$curVal = strval($this->idaula->CurrentValue);
			if ($curVal != "") {
				$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				if ($this->idaula->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaula->ViewValue = $this->idaula->CurrentValue;
					}
				}
			} else {
				$this->idaula->ViewValue = NULL;
			}
			$this->idaula->ViewCustomAttributes = "";

			// Nome
			$this->Nome->ViewValue = $this->Nome->CurrentValue;
			$this->Nome->ViewCustomAttributes = "";

			// CPF
			$this->CPF->ViewValue = $this->CPF->CurrentValue;
			$this->CPF->ViewCustomAttributes = "";

			// Senha
			$this->Senha->ViewValue = $Language->phrase("PasswordMask");
			$this->Senha->ViewCustomAttributes = "";

			// Sexo
			if (strval($this->Sexo->CurrentValue) != "") {
				$this->Sexo->ViewValue = $this->Sexo->optionCaption($this->Sexo->CurrentValue);
			} else {
				$this->Sexo->ViewValue = NULL;
			}
			$this->Sexo->ViewCustomAttributes = "";

			// datanascimento
			$this->datanascimento->ViewValue = $this->datanascimento->CurrentValue;
			$this->datanascimento->ViewValue = FormatDateTime($this->datanascimento->ViewValue, 7);
			$this->datanascimento->ViewCustomAttributes = "";

			// Funcao
			if ($Security->canAdmin()) { // System admin
				$curVal = strval($this->Funcao->CurrentValue);
				if ($curVal != "") {
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
					if ($this->Funcao->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->Funcao->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->Funcao->ViewValue = $this->Funcao->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->Funcao->ViewValue = $this->Funcao->CurrentValue;
						}
					}
				} else {
					$this->Funcao->ViewValue = NULL;
				}
			} else {
				$this->Funcao->ViewValue = $Language->phrase("PasswordMask");
			}
			$this->Funcao->ViewCustomAttributes = "";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->ViewCustomAttributes = "";

			// Ativado
			if (strval($this->Ativado->CurrentValue) != "") {
				$this->Ativado->ViewValue = $this->Ativado->optionCaption($this->Ativado->CurrentValue);
			} else {
				$this->Ativado->ViewValue = NULL;
			}
			$this->Ativado->ViewCustomAttributes = "";

			// datadecadastro
			$this->datadecadastro->ViewValue = $this->datadecadastro->CurrentValue;
			$this->datadecadastro->ViewValue = FormatDateTime($this->datadecadastro->ViewValue, 0);
			$this->datadecadastro->ViewCustomAttributes = "";

			// Idade
			$this->Idade->ViewValue = $this->Idade->CurrentValue;
			$this->Idade->ViewValue = FormatNumber($this->Idade->ViewValue, 0, -2, -2, -2);
			$this->Idade->ViewCustomAttributes = "";

			// idaula
			$this->idaula->LinkCustomAttributes = "";
			$this->idaula->HrefValue = "";
			$this->idaula->TooltipValue = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";
			$this->Nome->TooltipValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";
			$this->CPF->TooltipValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";
			$this->Senha->TooltipValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";
			$this->Sexo->TooltipValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";
			$this->datanascimento->TooltipValue = "";

			// Funcao
			$this->Funcao->LinkCustomAttributes = "";
			$this->Funcao->HrefValue = "";
			$this->Funcao->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";
			$this->Ativado->TooltipValue = "";

			// datadecadastro
			$this->datadecadastro->LinkCustomAttributes = "";
			$this->datadecadastro->HrefValue = "";
			$this->datadecadastro->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// idaula
			$this->idaula->EditAttrs["class"] = "form-control";
			$this->idaula->EditCustomAttributes = "";
			if ($this->idaula->getSessionValue() != "") {
				$this->idaula->CurrentValue = $this->idaula->getSessionValue();
				$curVal = strval($this->idaula->CurrentValue);
				if ($curVal != "") {
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
					if ($this->idaula->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$lookupFilter = function() {
							return "`ativado`=1";
						};
						$lookupFilter = $lookupFilter->bindTo($this);
						$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$arwrk[2] = $rswrk->fields('df2');
							$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idaula->ViewValue = $this->idaula->CurrentValue;
						}
					}
				} else {
					$this->idaula->ViewValue = NULL;
				}
				$this->idaula->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idaula->CurrentValue));
				if ($curVal != "")
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				else
					$this->idaula->ViewValue = $this->idaula->Lookup !== NULL && is_array($this->idaula->Lookup->Options) ? $curVal : NULL;
				if ($this->idaula->ViewValue !== NULL) { // Load from cache
					$this->idaula->EditValue = array_values($this->idaula->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idaulas`" . SearchString("=", $this->idaula->CurrentValue, DATATYPE_NUMBER, "");
					}
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(TRUE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idaula->EditValue = $arwrk;
				}
			}

			// Nome
			$this->Nome->EditAttrs["class"] = "form-control";
			$this->Nome->EditCustomAttributes = "";
			if (!$this->Nome->Raw)
				$this->Nome->CurrentValue = HtmlDecode($this->Nome->CurrentValue);
			$this->Nome->EditValue = HtmlEncode($this->Nome->CurrentValue);
			$this->Nome->PlaceHolder = RemoveHtml($this->Nome->caption());

			// CPF
			$this->CPF->EditAttrs["class"] = "form-control";
			$this->CPF->EditCustomAttributes = "";
			if (!$this->CPF->Raw)
				$this->CPF->CurrentValue = HtmlDecode($this->CPF->CurrentValue);
			$this->CPF->EditValue = HtmlEncode($this->CPF->CurrentValue);
			$this->CPF->PlaceHolder = RemoveHtml($this->CPF->caption());

			// Senha
			$this->Senha->EditAttrs["class"] = "form-control ew-password-strength";
			$this->Senha->EditCustomAttributes = "";
			$this->Senha->EditValue = HtmlEncode($this->Senha->CurrentValue);
			$this->Senha->PlaceHolder = RemoveHtml($this->Senha->caption());

			// Sexo
			$this->Sexo->EditCustomAttributes = "";
			$this->Sexo->EditValue = $this->Sexo->options(FALSE);

			// datanascimento
			$this->datanascimento->EditAttrs["class"] = "form-control";
			$this->datanascimento->EditCustomAttributes = "";
			$this->datanascimento->EditValue = HtmlEncode(FormatDateTime($this->datanascimento->CurrentValue, 7));
			$this->datanascimento->PlaceHolder = RemoveHtml($this->datanascimento->caption());

			// Funcao
			$this->Funcao->EditAttrs["class"] = "form-control";
			$this->Funcao->EditCustomAttributes = "";
			if (!$Security->canAdmin()) { // System admin
				$this->Funcao->EditValue = $Language->phrase("PasswordMask");
			} else {
				$curVal = trim(strval($this->Funcao->CurrentValue));
				if ($curVal != "")
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
				else
					$this->Funcao->ViewValue = $this->Funcao->Lookup !== NULL && is_array($this->Funcao->Lookup->Options) ? $curVal : NULL;
				if ($this->Funcao->ViewValue !== NULL) { // Load from cache
					$this->Funcao->EditValue = array_values($this->Funcao->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`userlevelid`" . SearchString("=", $this->Funcao->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->Funcao->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->Funcao->EditValue = $arwrk;
				}
			}

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			if (!$this->_Email->Raw)
				$this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
			$this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

			// Ativado
			$this->Ativado->EditCustomAttributes = "";
			$this->Ativado->EditValue = $this->Ativado->options(FALSE);

			// datadecadastro
			// Add refer script
			// idaula

			$this->idaula->LinkCustomAttributes = "";
			$this->idaula->HrefValue = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";

			// Funcao
			$this->Funcao->LinkCustomAttributes = "";
			$this->Funcao->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";

			// datadecadastro
			$this->datadecadastro->LinkCustomAttributes = "";
			$this->datadecadastro->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idaula->Required) {
			if (!$this->idaula->IsDetailKey && $this->idaula->FormValue != NULL && $this->idaula->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idaula->caption(), $this->idaula->RequiredErrorMessage));
			}
		}
		if ($this->Nome->Required) {
			if (!$this->Nome->IsDetailKey && $this->Nome->FormValue != NULL && $this->Nome->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nome->caption(), $this->Nome->RequiredErrorMessage));
			}
		}
		if ($this->CPF->Required) {
			if (!$this->CPF->IsDetailKey && $this->CPF->FormValue != NULL && $this->CPF->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CPF->caption(), $this->CPF->RequiredErrorMessage));
			}
		}
		if ($this->Senha->Required) {
			if (!$this->Senha->IsDetailKey && $this->Senha->FormValue != NULL && $this->Senha->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Senha->caption(), $this->Senha->RequiredErrorMessage));
			}
		}
		if ($this->Sexo->Required) {
			if ($this->Sexo->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Sexo->caption(), $this->Sexo->RequiredErrorMessage));
			}
		}
		if ($this->datanascimento->Required) {
			if (!$this->datanascimento->IsDetailKey && $this->datanascimento->FormValue != NULL && $this->datanascimento->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datanascimento->caption(), $this->datanascimento->RequiredErrorMessage));
			}
		}
		if (!CheckEuroDate($this->datanascimento->FormValue)) {
			AddMessage($FormError, $this->datanascimento->errorMessage());
		}
		if ($this->Funcao->Required) {
			if (!$this->Funcao->IsDetailKey && $this->Funcao->FormValue != NULL && $this->Funcao->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Funcao->caption(), $this->Funcao->RequiredErrorMessage));
			}
		}
		if ($this->_Email->Required) {
			if (!$this->_Email->IsDetailKey && $this->_Email->FormValue != NULL && $this->_Email->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
			}
		}
		if (!CheckEmail($this->_Email->FormValue)) {
			AddMessage($FormError, $this->_Email->errorMessage());
		}
		if ($this->Ativado->Required) {
			if ($this->Ativado->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Ativado->caption(), $this->Ativado->RequiredErrorMessage));
			}
		}
		if ($this->datadecadastro->Required) {
			if (!$this->datadecadastro->IsDetailKey && $this->datadecadastro->FormValue != NULL && $this->datadecadastro->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datadecadastro->caption(), $this->datadecadastro->RequiredErrorMessage));
			}
		}

		// Validate detail grid
		$detailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("endereco", $detailTblVar) && $GLOBALS["endereco"]->DetailAdd) {
			if (!isset($GLOBALS["endereco_grid"]))
				$GLOBALS["endereco_grid"] = new endereco_grid(); // Get detail page object
			$GLOBALS["endereco_grid"]->validateGridForm();
		}
		if (in_array("documentos", $detailTblVar) && $GLOBALS["documentos"]->DetailAdd) {
			if (!isset($GLOBALS["documentos_grid"]))
				$GLOBALS["documentos_grid"] = new documentos_grid(); // Get detail page object
			$GLOBALS["documentos_grid"]->validateGridForm();
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() != "" && !EmptyValue($this->idpessoa->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->idpessoa->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->idpessoa->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}

		// Check if valid key values for master user
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$masterFilter = $this->sqlMasterFilter_aulas();
			if (strval($this->idaula->CurrentValue) != "") {
				$masterFilter = str_replace("@idaulas@", AdjustSql($this->idaula->CurrentValue, "DB"), $masterFilter);
			} else {
				$masterFilter = "";
			}
			if ($masterFilter != "") {
				$rsmaster = $GLOBALS["aulas"]->loadRs($masterFilter);
				$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
				$validMasterKey = TRUE;
				if ($this->MasterRecordExists) {
					$validMasterKey = $Security->isValidUserID($rsmaster->fields['idaluno']);
				} elseif ($this->getCurrentMasterTable() == "aulas") {
					$validMasterKey = FALSE;
				}
				if (!$validMasterKey) {
					$masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
					$masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
					$this->setFailureMessage($masterUserIdMsg);
					return FALSE;
				}
				if ($rsmaster)
					$rsmaster->close();
			}
		}
		$conn = $this->getConnection();

		// Begin transaction
		if ($this->getCurrentDetailTable() != "")
			$conn->beginTrans();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// idaula
		$this->idaula->setDbValueDef($rsnew, $this->idaula->CurrentValue, NULL, FALSE);

		// Nome
		$this->Nome->setDbValueDef($rsnew, $this->Nome->CurrentValue, NULL, FALSE);

		// CPF
		$this->CPF->setDbValueDef($rsnew, $this->CPF->CurrentValue, "", FALSE);

		// Senha
		$this->Senha->setDbValueDef($rsnew, $this->Senha->CurrentValue, "", FALSE);

		// Sexo
		$this->Sexo->setDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, FALSE);

		// datanascimento
		$this->datanascimento->setDbValueDef($rsnew, UnFormatDateTime($this->datanascimento->CurrentValue, 7), NULL, FALSE);

		// Funcao
		
		if ($Security->canAdmin()) { // System admin
			
			$this->Funcao->setDbValueDef($rsnew, $this->Funcao->CurrentValue, NULL, strval($this->Funcao->CurrentValue) == "");
			
		}
		

		// Email
		$this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// Ativado
		$this->Ativado->setDbValueDef($rsnew, $this->Ativado->CurrentValue, NULL, FALSE);

		// datadecadastro
		$this->datadecadastro->CurrentValue = CurrentDateTime();
		$this->datadecadastro->setDbValueDef($rsnew, $this->datadecadastro->CurrentValue, NULL);

		// idpessoa
		// Call Row Inserting event

		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
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
			$addRow = FALSE;
		}

		// Add detail records
		if ($addRow) {
			$detailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("endereco", $detailTblVar) && $GLOBALS["endereco"]->DetailAdd) {
				$GLOBALS["endereco"]->idpessoa->setSessionValue($this->idpessoa->CurrentValue); // Set master key
				if (!isset($GLOBALS["endereco_grid"]))
					$GLOBALS["endereco_grid"] = new endereco_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "endereco"); // Load user level of detail table
				$addRow = $GLOBALS["endereco_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["endereco"]->idpessoa->setSessionValue(""); // Clear master key if insert failed
				}
			}
			if (in_array("documentos", $detailTblVar) && $GLOBALS["documentos"]->DetailAdd) {
				$GLOBALS["documentos"]->idpessoa->setSessionValue($this->idpessoa->CurrentValue); // Set master key
				if (!isset($GLOBALS["documentos_grid"]))
					$GLOBALS["documentos_grid"] = new documentos_grid(); // Get detail page object
				$Security->loadCurrentUserLevel($this->ProjectID . "documentos"); // Load user level of detail table
				$addRow = $GLOBALS["documentos_grid"]->gridInsert();
				$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$addRow) {
					$GLOBALS["documentos"]->idpessoa->setSessionValue(""); // Clear master key if insert failed
				}
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() != "") {
			if ($addRow) {
				$conn->commitTrans(); // Commit transaction
			} else {
				$conn->rollbackTrans(); // Rollback transaction
			}
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Show link optionally based on User ID
	protected function showOptionLink($id = "")
	{
		global $Security;
		if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id))
			return $Security->isValidUserID($this->idpessoa->CurrentValue);
		return TRUE;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{
		$validMaster = FALSE;

		// Get the keys for master table
		if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== NULL) {
			$masterTblVar = $master;
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "aulas") {
				$validMaster = TRUE;
				if (($parm = Get("fk_idaulas", Get("idaula"))) !== NULL) {
					$GLOBALS["aulas"]->idaulas->setQueryStringValue($parm);
					$this->idaula->setQueryStringValue($GLOBALS["aulas"]->idaulas->QueryStringValue);
					$this->idaula->setSessionValue($this->idaula->QueryStringValue);
					if (!is_numeric($GLOBALS["aulas"]->idaulas->QueryStringValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
				}
			}
		} elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== NULL) {
			$masterTblVar = $master;
			if ($masterTblVar == "") {
				$validMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($masterTblVar == "aulas") {
				$validMaster = TRUE;
				if (($parm = Post("fk_idaulas", Post("idaula"))) !== NULL) {
					$GLOBALS["aulas"]->idaulas->setFormValue($parm);
					$this->idaula->setFormValue($GLOBALS["aulas"]->idaulas->FormValue);
					$this->idaula->setSessionValue($this->idaula->FormValue);
					if (!is_numeric($GLOBALS["aulas"]->idaulas->FormValue))
						$validMaster = FALSE;
				} else {
					$validMaster = FALSE;
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
			if ($masterTblVar != "aulas") {
				if ($this->idaula->CurrentValue == "")
					$this->idaula->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	protected function setupDetailParms()
	{

		// Get the keys for master table
		$detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
		if ($detailTblVar !== NULL) {
			$this->setCurrentDetailTable($detailTblVar);
		} else {
			$detailTblVar = $this->getCurrentDetailTable();
		}
		if ($detailTblVar != "") {
			$detailTblVar = explode(",", $detailTblVar);
			if (in_array("endereco", $detailTblVar)) {
				if (!isset($GLOBALS["endereco_grid"]))
					$GLOBALS["endereco_grid"] = new endereco_grid();
				if ($GLOBALS["endereco_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["endereco_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["endereco_grid"]->CurrentMode = "add";
					$GLOBALS["endereco_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["endereco_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["endereco_grid"]->setStartRecordNumber(1);
					$GLOBALS["endereco_grid"]->idpessoa->IsDetailKey = TRUE;
					$GLOBALS["endereco_grid"]->idpessoa->CurrentValue = $this->idpessoa->CurrentValue;
					$GLOBALS["endereco_grid"]->idpessoa->setSessionValue($GLOBALS["endereco_grid"]->idpessoa->CurrentValue);
					$GLOBALS["endereco_grid"]->idacademia->setSessionValue(""); // Clear session key
				}
			}
			if (in_array("documentos", $detailTblVar)) {
				if (!isset($GLOBALS["documentos_grid"]))
					$GLOBALS["documentos_grid"] = new documentos_grid();
				if ($GLOBALS["documentos_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["documentos_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["documentos_grid"]->CurrentMode = "add";
					$GLOBALS["documentos_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["documentos_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["documentos_grid"]->setStartRecordNumber(1);
					$GLOBALS["documentos_grid"]->idpessoa->IsDetailKey = TRUE;
					$GLOBALS["documentos_grid"]->idpessoa->CurrentValue = $this->idpessoa->CurrentValue;
					$GLOBALS["documentos_grid"]->idpessoa->setSessionValue($GLOBALS["documentos_grid"]->idpessoa->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pessoalist.php"), "", $this->TableVar, TRUE);
		$pageId = ($this->isCopy()) ? "Copy" : "Add";
		$Breadcrumb->add("add", $pageId, $url);
	}

	// Set up detail pages
	protected function setupDetailPages()
	{
		$pages = new SubPages();
		$pages->Style = "tabs";
		$pages->add('endereco');
		$pages->add('documentos');
		$this->DetailPages = $pages;
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_idaula":
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					break;
				case "x_Sexo":
					break;
				case "x_Funcao":
					break;
				case "x_Ativado":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_idaula":
							break;
						case "x_Funcao":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
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
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}
} // End class
?>