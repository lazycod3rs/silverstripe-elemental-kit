<?php
namespace LazyCoders\Elemental\Extensions;
use SilverStripe\ORM\DataExtension;

class ElementalCmsEditLinkExtension extends DataExtension {
    public function CMSEditLink()
    {
        if (!$admin = $this->getAdmin()) {
            return;
        }
        $urlClass = str_replace('\\', '-', $this->owner->className);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->owner->ID}/edit");
   }

    public function getAdmin()
    {
        $admin = $this->owner->config()->get('model_admin');
        if (!$admin) {
            return;
        }
        return $admin::singleton();
    }
}
