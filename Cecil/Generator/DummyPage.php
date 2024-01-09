<?php
namespace Cecil\Generator;

use Cecil\Collection\Page\Page;
use Cecil\Collection\Page\Type;

class DummyPage extends AbstractGenerator implements GeneratorInterface
{
    public function generate(): void
    {
        // create a new page $page, then add it to the site collection
        $page = (new Page('my-page'))
            ->setType(Type::PAGE->value)
            ->setPath('mypage')
            ->setBodyHtml('<p>My page body</p>')
            ->setVariable('language', 'en')
            ->setVariable('title', 'My page')
            ->setVariable('date', now())
            ->setVariable('menu', ['main' => ['weight' => 99]]);
        $this->generatedPages->add($page);
    }
}
