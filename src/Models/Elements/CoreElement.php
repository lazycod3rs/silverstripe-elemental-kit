<?php
namespace LazyCoders\Elemental;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;

class CoreElement extends BaseElement {
    private static $table_name = 'CoreElement';

    private static $icon = 'font-icon-block-content';

    private static $inline_editable = false;

    private static $db = [];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            // If no template selected, only allow template selection
            $fields->removeByName(['ExtraClass']);
            if (!$this->hasTemplates()) {
                $this->addTemplateSpecificFields($fields);
            }
            $this->addTemplateFields($fields);
        });

        $fields = parent::getCMSFields();

        if (!$this->Style) {
            // If no template is selected, force only template Style selection,
            // provided there is actually a template style field.
            if ($template = $fields->dataFieldByName('Style')) {
                // Must add Root TabSet with a Tab, since Elemental forces
                // the resulting Fieldset to deliver a TabSet called "Root".
                $fields = FieldList::create(TabSet::create('Root', Tab::create('Template', $template)));
            }
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $templates = $this->getTemplates();
        if (count($templates) === 1) {
            $this->Style = array_keys($templates)[0];
        }

        return parent::populateDefaults();
    }

    /**
     * This override is not used for anything in particular,
     * but ensures missing methods on settings does not cause
     * breakage.
     * This is especially useful when a specific element has a
     * setting that other blocks in the same list does not.
     *
     * @param string $method
     * @param array  $arguments
     * @return mixed|string
     */
    public function __call($method, $arguments)
    {
        if (!$this->hasMethod($method)) {
            return '';
        }

        return parent::__call($method, $arguments);
    }

    protected function hasTemplates()
    {
        $styles = $this->getTemplateStyles();

        return count($styles) > 0 && !$this->Style;
    }

    private function addTemplateFields(FieldList $fields): void
    {
        $styles = $this->getTemplateStyles();
        $fields->removeByName('Style');
        if ($styles && count($styles) > 0) {
            $f = DropdownField::create('Style', 'Template', $styles)
                ->setEmptyString(_t(__CLASS__ . '.CUSTOM_STYLES', 'Select a template'));

            //$fields->addFieldsToTab('Root.Template', [$f]);
            $fields->insertBefore('Settings', Tab::create('Template', $f));

        } else {

        }
    }

    protected function addTemplateSpecificFields(FieldList $fields): void
    {
        $style_settings = $this->getSelectedTemplateSettings();
        $settingsFields = $style_settings['fields'] ?? [];

        foreach ($settingsFields as $column => $elm_fields) {
            $data_fields = [];
            foreach ($elm_fields as $fieldname) {
                $data_fields[] = $fields->dataFieldByName($fieldname);

            }

            $fields->addFieldsToTab("Root.$column", $data_fields);
        }
    }

    public function getSelectedTemplateSettings()
    {
        $settings = $this->config()->get('styles');

        return $settings[$this->Style] ?? [];
    }

    public function getTemplateStyles()
    {
        $styles = $this->getTemplates();
        $styles_flat = array();

        foreach ($styles as $key => $obj) {
            $styles_flat[$key] = $obj['label'];
        }

        return $styles_flat;
    }

    public function getTemplates()
    {
        return static::config()->uninherited('styles') ?? [];
    }

    public function getSummary()
    {
        $Content = $this->Content ?? '';
        return DBField::create_field('HTMLText', $Content)->Summary(20);
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();

        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Content');
    }

    public function isLive()
    {
        return Director::isLive();
    }

    public function getUnsetTemplateMessage(): string
    {
        $class = ClassInfo::shortName($this->ClassName);

        return "Fallback template for *$class*. No specific style has been selected!";
    }
}
