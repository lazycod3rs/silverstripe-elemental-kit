<?php
namespace LazyCoders\Elemental\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;

class CoreElementExtension extends DataExtension {

    public function updateCMSEditLink(&$link): void
    {
        if (!$this->owner->inlineEditable()) {
            $page = $this->owner->getPage();

            if (!$page || $page instanceof SiteTree) {
                return;
            }

            // As non-page DataObject's are managed via GridFields, we have to grab their CMS edit URL
            // and replace the trailing /edit/ with a link to the nested ElementalArea edit form
            $relationName = $this->owner->getAreaRelationName();
            $link = preg_replace(
                '/edit\/?$/',
                "ItemEditForm/field/{$relationName}/item/{$this->owner->ID}/edit/",
                $page->CMSEditLink()
            );
        }
    }
}
