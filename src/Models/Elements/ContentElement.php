<?php
namespace LazyCoders\Elemental;

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;

class ContentElement extends CoreElement{
    private static $table_name = 'ContentElement';

    private static $db = [
        'Tagline' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'Tagline'
            ]);
            $fields->insertBefore('Content', TextField::create('Tagline', 'Tagline'));
        });

        $fields = parent::getCMSFields();
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Content Element');
    }
}
