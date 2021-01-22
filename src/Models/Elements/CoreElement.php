<?php
namespace LazyCoders\Elemental;

use DNADesign\Elemental\Models\BaseElement;

class CoreElement extends BaseElement
{
    private static $table_name = 'CoreElement';

    private static $inline_editable = false;

    private static $db = [
        'Tagline' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Main',[
            $fields->dataFieldByName('Tagline'),
            $fields->dataFieldByName('Content'),
        ]);
        return $fields;
    }
}
