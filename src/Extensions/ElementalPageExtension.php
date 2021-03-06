<?php
namespace LazyCoders\Elemental\Extensions;

use SilverStripe\Dev\Debug;
use DNADesign\Elemental\Extensions\ElementalPageExtension as BasePageExtension;
use SilverStripe\Forms\FieldList;

class ElementalPageExtension extends BasePageExtension {
    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $elemental_tab = $this->owner->config()->get('elemental_tab') ?? true;
        if ($elemental_tab) {
            $fields->findTab('Root.Main')->setTitle('Primary');
            $this->addElementalFields($fields);
        } elseif ($fields->hasTabSet('SEOFields_Container') && $fields->dataFieldByName('ElementalArea')) {
            $fields->insertBefore('SEOFields_Container', $fields->dataFieldByName('ElementalArea'));
        }
        return $fields;
    }

    public function addElementalFields($fields): void
    {
        if ($elementalArea = $fields->dataFieldByName('ElementalArea')) {
            $fields->addFieldToTab('Root.Elemental', $elementalArea);
        }
    }
}
