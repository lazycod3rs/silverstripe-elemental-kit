<?php
namespace LazyCoders\Elemental\Extensions;
use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

class ElementalTabExtension extends Extension {

    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;
        $this->addElementalFields($fields);
        return $fields;
    }

    public function addElementalFields($fields): void
    {
        if ($elementalArea = $fields->dataFieldByName('ElementalArea')) {
            $fields->addFieldToTab('Root.Elemental', $elementalArea);
        }
    }
}
