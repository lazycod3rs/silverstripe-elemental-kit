<?php
namespace LazyCoders\Elemental\Elements;

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use Symbiote\MultiValueField\Fields\MultiValueTextField;
use Symbiote\MultiValueField\ORM\FieldType\MultiValueField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;

class ProsAndConsElement extends CoreElement{
    private static $table_name = 'ProsAndConsElement';

    private static $db = [
        'Pros'   => MultiValueField::class,
        'Cons'   => MultiValueField::class,
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $pros = $fields->dataFieldByName('Pros')->setTitle('');
        $cons = $fields->dataFieldByName('Cons')->setTitle('');
        $fields->removeByName(['Pros', 'Cons']);
        $f = [
            Tab::create('Pros', $pros),
            Tab::create('Cons',$cons)
        ];
        $fields->insertAfter('Title', Tab::create('',
            TabSet::create('', $f)
        ));

        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Pros and Cons');
    }
}
