<?php
namespace Cecil\Generator;

use Cecil\Collection\Page\Page;
use Cecil\Collection\Page\Type;

class Database extends AbstractGenerator implements GeneratorInterface
{
    public function generate(): void
    {
        // create pages from a SQLite database
        $db = new SQLite3('database.sqlite');
        $statement = $db->prepare('SELECT * FROM blog');
        $result = $statement->execute();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $page = (new Page($row['page-id']))
                ->setType(Type::PAGE->value)
                ->setPath($row['path'])
                ->setBodyHtml($row['html'])
                ->setVariable('title', $row['title'])
                ->setVariable('date', $row['date']);
            $this->generatedPages->add($page);
        }
        $result->finalize();
        $db->close();
    }
}
