<?php
namespace LazyCoders\Elemental\Extensions;

use SilverStripe\ORM\DataExtension;

class DataObjectCmsEditLinkExtension extends DataExtension {
    //don't know what happend here!! How this is working!!????
    public function CMSEditLink()
    {
        $owner = $this->owner;
        return $owner->CMSEditLink;
   }
}
