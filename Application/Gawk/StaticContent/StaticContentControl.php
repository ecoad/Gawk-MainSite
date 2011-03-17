<?php
	require_once("Atrox/Core/Data/Data.php");
	require_once("Atrox/Core/Data/DataEntity.php");
/**
 * Use of this class allows static content to be added to the database, this gives the
 * ability for the content to be searched. The class also contains a formatter, so can generate
 * document parsed (WIKI style) content
 *
 * @author Adam Duncan (Clock Ltd) {@link mailto:adam.duncan@clock.co.uk adam.duncan@clock.co.uk }
 */
class StaticContentControl extends DataControl {
	var $table = "StaticContent";
	var $key = "Id";
	var $sequence = "StaticContent_Id_seq";
	var $defaultOrder = "Id";
	var $searchFields = array("Title", "Body");
	var $noTitle = "Hang on";
	var $noContent = "We Don't currently seem to have any content to display on this page, this is likely to be a temporary issue so try again soon.";

	public function init() {

		$this->fieldMeta["Id"] = new FieldMeta(
			"Id", "", FM_TYPE_INTEGER, null, FM_STORE_NEVER, true);

		$this->fieldMeta["Handle"] = new FieldMeta(
			"Handle", "", FM_TYPE_STRING, null, FM_STORE_NEVER, true);

		$this->fieldMeta["Title"] = new FieldMeta(
			"Title", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Body"] = new FieldMeta(
			"Body Text", "", FM_TYPE_STRING, null, FM_STORE_ALWAYS, false);

		$this->fieldMeta["Body"]->setFormatter(CoreFactory::getSimpleDocumentMarkupWithTableOfContentsFormatter());
	}

	public function setNoContentsBodyFormatter() {
		$this->init();
		$this->fieldMeta["Body"]->setFormatter(CoreFactory::getSimpleDocumentMarkupFormatter());
	}

	public function getDataEntity() {
		return new StaticContentDataEntity($this);
	}

	/**
	 * This function retrived
	 * @param String The unique Id for the page
	 * @return StaticContentDataEntity The page and its contents
	 */
	public function load($handle) {

		$filter = CoreFactory::getFilter();
		$filter->addConditional($this->table, "Handle", $handle, "ILIKE");
		$this->setFilter($filter);

		if ($this->getNumRows() > 0) {
			return $this->getNext();
		} else {
			$staticContent = $this->makeNew();
			$staticContent->set("Title", $this->noTitle);
			$staticContent->set("Body", $this->noContent);
			$staticContent->save();
			return $staticContent;
		}
	}
}

/**
 * @author Wilde
 * This class encapsulates formatting behaviour.
 */
class StaticContentDataEntity extends DataEntity {

	/**
	 * This function will format and return content for this page with a contents list
	 * @return String The content
	 */
	public function getContent() {
		return "<div class=\"document-markup\">" . $this->getFormatted("Body") . "</div>";
	}
}